<?php

namespace App\Controllers;

use App\Models\PelanggaranModel;

class DataViolations extends BaseController
{
    public function __construct()
    {
        $this->pelanggaranModel = new PelanggaranModel();
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
        return view('admin/data-pelanggaran', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->pelanggaranModel
                    ->select('*, pelanggaran.id as pelanggaranid, pelanggaran.status, pelanggaran.created_at, pelanggaran.updated_at')
                    ->join('profil', 'pelanggaran.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'pelanggaran.kelas_id = master_kelas.id')
                    ->where('pelanggaran.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->pelanggaranModel
                    ->select('*, pelanggaran.id as pelanggaranid, pelanggaran.status, pelanggaran.created_at, pelanggaran.updated_at')
                    ->join('profil', 'pelanggaran.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'pelanggaran.kelas_id = master_kelas.id')
                    ->where('pelanggaran.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->nama_pelanggaran;
                    $row[] = $key->hukuman;
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
                <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".edit" id="edit" data-id="' . $key->pelanggaranid .  '">
                <i class="nav-icon fas fa-edit"></i>
                </a>
                 <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->pelanggaranid .  '">
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
                    'nama_pelanggaran' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama pelanggaran harus diisi !'
                        ]
                    ],
                    'hukuman' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Hukuman harus diisi !'
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
                'nama_pelanggaran' => $this->request->getPost('nama_pelanggaran'),
                'hukuman' => $this->request->getPost('hukuman'),
                'santri_id' => $this->request->getPost('profil'),
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                'status' => 1,
            ];

            if (!$this->pelanggaranModel->save($data)) {
                $data = array('error' => 'Gagal menambah data pelanggaran.');
            }
            $data = array('success' => 'Berhasil menambah data pelanggaran.');
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
            if (!$this->pelanggaranModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data pelanggaran');
            } else {
                $data = array('success' => 'Berhasil menghapus data pelanggaran');
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
            $post = $this->pelanggaranModel
                ->select('*, pelanggaran.status, pelanggaran.created_at, pelanggaran.updated_at')
                ->join('profil', 'pelanggaran.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('master_kelas', 'pelanggaran.kelas_id = master_kelas.id')
                ->find($id);

            $data = [
                'id' => $id,
                'kelas' => $post->kelas,
                'nama_lengkap' => $post->nama_lengkap,
                'nama_pelanggaran' => $post->nama_pelanggaran,
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

            if (!$this->pelanggaranModel->save($data)) {
                $data = array('error' => 'Gagal mengubah status pelanggaran.');
            }
            $data = array('success' => 'Berhasil mengubah status pelanggaran.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}