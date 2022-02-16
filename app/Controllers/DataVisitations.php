<?php

namespace App\Controllers;

use App\Models\KunjunganModel;

class DataVisitations extends BaseController
{
    public function __construct()
    {
        $this->kunjunganModel = new KunjunganModel();
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
        return view('admin/data-kunjungan', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->kunjunganModel
                    ->select('*, kunjungan.id as kunjunganid, kunjungan.status, kunjungan.created_at, kunjungan.updated_at, kunjungan.nama_lengkap as nama_pengunjung')
                    ->join('profil', 'kunjungan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'kunjungan.kelas_id = master_kelas.id')
                    ->where('kunjungan.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->kunjunganModel
                    ->select('*, kunjungan.id as kunjunganid, kunjungan.status, kunjungan.created_at, kunjungan.updated_at, kunjungan.nama_lengkap as nama_pengunjung')
                    ->join('profil', 'kunjungan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'kunjungan.kelas_id = master_kelas.id')
                    ->where('kunjungan.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->nama_pengunjung;
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
                <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".edit" id="edit" data-id="' . $key->kunjunganid .  '">
                <i class="nav-icon fas fa-edit"></i>
                </a>
                 <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->kunjunganid .  '">
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
                    'nama_pengunjung' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama pengunjung harus diisi !'
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
                'nama_lengkap' => $this->request->getPost('nama_pengunjung'),
                'santri_id' => $this->request->getPost('profil'),
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                'status' => 1,
            ];

            if (!$this->kunjunganModel->save($data)) {
                $data = array('error' => 'Gagal menambah data kunjungan.');
            }
            $data = array('success' => 'Berhasil menambah data kunjungan.');
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
            if (!$this->kunjunganModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data kunjungan');
            } else {
                $data = array('success' => 'Berhasil menghapus data kunjungan');
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
            $post = $this->kunjunganModel
                ->select('*, kunjungan.status, kunjungan.created_at, kunjungan.updated_at, kunjungan.nama_lengkap as nama_pengunjung')
                ->join('profil', 'kunjungan.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('master_kelas', 'kunjungan.kelas_id = master_kelas.id')
                ->find($id);

            $data = [
                'id' => $id,
                'kelas' => $post->kelas,
                'nama_lengkap' => $post->nama_lengkap,
                'nama_pengunjung' => $post->nama_pengunjung,
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

            if (!$this->kunjunganModel->save($data)) {
                $data = array('error' => 'Gagal mengubah status kunjungan.');
            }
            $data = array('success' => 'Berhasil mengubah status kunjungan.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}