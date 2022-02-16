<?php

namespace App\Controllers;

use App\Models\KamarProfilModel;
use App\Models\MasterKamarModel;
use App\Models\ProfilModel;

class DataRooms extends BaseController
{
    public function __construct()
    {
        $this->kamarprofilModel = new KamarProfilModel();
        $this->masterkamarModel = new MasterKamarModel();
        $this->profilModel = new ProfilModel();
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
            'users' => $this->userModel
                ->select('users.id as userid, username, name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->where('name', 'santri')
                ->where('users_profil.user_id', null)
                ->findAll(),
            'kamar' => $this->masterkamarModel->groupBy('nama_gedung')
                ->groupBy('nama_kamar')->findAll(),
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Room Santri', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Room Santri', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-kamar', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $kelamin = $this->request->getGet('jenis_kelamin');
            $tahun = $this->request->getGet('tahun');

            $profil = $this->userModel
                ->select('users.id as userid, profil.id as profilid, nama_lengkap, nisn')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kamar_profil', 'kamar_profil.santri_id = profil.id', 'LEFT')
                ->join('master_kamar', 'kamar_profil.kamar_id = master_kamar.id', 'LEFT')
                ->where('name', 'santri')
                ->where('kamar_id', null)
                ->where('santri_id', null)
                ->findAll();
            if ($tahun != "") {
                $posts = $this->kamarprofilModel
                    ->select('kamar_profil.id as tabelid, master_kamar.id as kamarid, santri_id, santri.nama_lengkap as santri, wali.nama_lengkap as wali, santri.nisn, tahun_ajaran, nama_kamar, nama_gedung')
                    ->join('profil santri', 'kamar_profil.santri_id = santri.id')
                    ->join('master_kamar', 'kamar_profil.kamar_id = master_kamar.id')
                    ->join('profil wali', 'master_kamar.wali_id = wali.id', 'LEFT')
                    ->where('master_kamar.jenis_kelamin', $kelamin)
                    ->where('kamar_profil.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->kamarprofilModel
                    ->select('kamar_profil.id as tabelid, master_kamar.id as kamarid, santri_id, santri.nama_lengkap as santri, wali.nama_lengkap as wali, santri.nisn, tahun_ajaran, nama_kamar, nama_gedung')
                    ->join('profil santri', 'kamar_profil.santri_id = santri.id')
                    ->join('master_kamar', 'kamar_profil.kamar_id = master_kamar.id')
                    ->join('profil wali', 'master_kamar.wali_id = wali.id', 'LEFT')
                    ->where('master_kamar.jenis_kelamin', $kelamin)
                    ->where('kamar_profil.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = '<div class="btn-group d-flex justify-content-center"><input
                type="checkbox" class="form-check-input check' . $no . '"
                id="check" data-no="' . $no . '" data-santri-id="' . $key->santri_id . '" data-kamar-id="' . $key->kamar_id . '"></div>';
                    $row[] = $key->santri . ' | ' . $key->nisn;
                    $row[] = $key->nama_gedung;
                    $row[] = $key->nama_kamar;
                    $row[] = $key->tahun_ajaran;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                 <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->tabelid .  '">
                <i class="nav-icon fas fa-trash"></i>
                </a>
                </div>';
                    $data[] = $row;
                }
                $data = array('responce' => 'success', 'posts' => $data, 'profil' => $profil);
            } else {
                $data = array('responce' => 'success', 'posts' => '', 'profil' => $profil);
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
                    'kamarid' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kamar is required !'
                        ]
                    ],
                    'santriid' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama Lengkap is required !'
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
                'kamar_id' => $this->request->getPost('kamarid'),
                'santri_id' => $this->request->getPost('santriid'),
                'tahun_ajaran' => $this->tahunModel->where('status', 1)->get()->getRow()->tahun,
            ];

            if (!$this->kamarprofilModel->save($data)) {
                $data = array('error' => 'Gagal menambah data kamar santri.');
            }
            $data = array('success' => 'Berhasil menambah data kamar santri.');
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

            $santri_id = $this->request->getPost('santriid');
            $kamar_id = $this->request->getPost('kamarid');

            for ($i = 0; $i < count($santri_id); $i++) {
                if ($santri_id[$i] != null) {
                    if (
                        $this->kamarprofilModel
                        ->where('santri_id', $santri_id[$i])
                        ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                        ->countAllResults() != 0
                    ) {
                        $data = array('error' => 'Santri sudah memiliki kamar di tahun ini');
                        $data[$csrfname] = $csrfhash;
                        return $this->response->setJSON($data);
                    }
                    $row = [
                        'santri_id' => $santri_id[$i],
                        'kamar_id' => $kamar_id,
                        'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                    ];

                    $data[] = $row;
                }
            }

            if (!$this->kamarprofilModel->insertBatch($data)) {
                $data = array('error' => 'Gagal mengubah kamar.');
            }

            for ($i = 0; $i < count($santri_id); $i++) {
                if ($santri_id[$i] != null) {
                    $data = [
                        'user_id' => user()->id,
                        'pesan' => 'Mengubah santri id = ' . $santri_id[$i] . ' ke kamar id = ' . $kamar_id,
                    ];
                    $data[] = $row;
                }
            }

            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah kamar santri.');
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

            if (!$this->kamarprofilModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data kamar santri.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Menghapus data kamar',
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil menghapus data kamar santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}