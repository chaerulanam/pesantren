<?php

namespace App\Controllers;

use App\Models\PerizinanModel;

class DataPermissions extends BaseController
{
    public function __construct()
    {
        $this->perizinanModel = new PerizinanModel();
    }
    public function index()
    {
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Payments', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Payments', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-perizinan', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->perizinanModel
                    ->select('*, perizinan.id as perizinanid, perizinan.status, perizinan.created_at, perizinan.updated_at')
                    ->join('profil', 'perizinan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'perizinan.kelas_id = master_kelas.id')
                    ->where('perizinan.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->perizinanModel
                    ->select('*, perizinan.id as perizinanid, perizinan.status, perizinan.created_at, perizinan.updated_at')
                    ->join('profil', 'perizinan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'perizinan.kelas_id = master_kelas.id')
                    ->where('perizinan.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->keperluan;
                    if ($key->status == 1) {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">Belum Selesai</span></div>';
                        $row[] = $key->tahun_ajaran;
                        $row[] = $key->created_at;
                        $row[] = '-';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">Sudah Selesai</span></div>';
                        $row[] = $key->tahun_ajaran;
                        $row[] = $key->created_at;
                        $row[] = $key->updated_at;
                    }

                    $row[] = '<div class="btn-group d-flex justify-content-center">
                <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".edit" id="edit" data-id="' . $key->perizinanid .  '">
                <i class="nav-icon fas fa-edit"></i>
                </a>
                 <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->perizinanid .  '">
                <i class="nav-icon fas fa-trash"></i>
                </a>
                </div>';
                    $data[] = $row;
                }
                $data = array('responce' => 'success', 'posts' => $data);
            } else {
                $data = array('responce' => 'success', 'posts' => '');
            }
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if (!$this->validate(
                [
                    'kelas' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kelas harus diisi !'
                        ]
                    ],
                    'profil' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama lengkap harus diisi !'
                        ]
                    ],
                    'keperluan' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Keperluan harus diisi !'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'kelas_id' => $this->request->getPost('kelas'),
                'keperluan' => $this->request->getPost('keperluan'),
                'santri_id' => $this->request->getPost('profil'),
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                'status' => 1,
            ];

            if (!$this->perizinanModel->save($data)) {
                $data = array('error' => 'Gagal menambah data perizinan.');
            }
            $data = array('success' => 'Berhasil menambah data perizinan.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $id = $this->request->getPost('id');
            if (!$this->perizinanModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data perizinan');
            } else {
                $data = array('success' => 'Berhasil menghapus data perizinan');
            }
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function get_detail()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $id = $this->request->getGet('id');
            $post = $this->perizinanModel
                ->select('*, perizinan.status, perizinan.created_at, perizinan.updated_at')
                ->join('profil', 'perizinan.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('master_kelas', 'perizinan.kelas_id = master_kelas.id')
                ->find($id);

            $data = [
                'id' => $id,
                'kelas' => $post->kelas,
                'nama_lengkap' => $post->nama_lengkap,
                'keperluan' => $post->keperluan,
                'status' => $post->status,
            ];

            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $data = [
                'id' => $this->request->getPost('id'),
                'status' => $this->request->getPost('status')
            ];

            if (!$this->perizinanModel->save($data)) {
                $data = array('error' => 'Gagal mengubah status perizinan.');
            }
            $data = array('success' => 'Berhasil mengubah status perizinan.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}