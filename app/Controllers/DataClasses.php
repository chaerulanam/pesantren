<?php

namespace App\Controllers;

use App\Models\KelasProfilModel;
use App\Models\MasterKelasModel;
use App\Models\ProfilModel;

class DataClasses extends BaseController
{
    public function __construct()
    {
        $this->kelasprofilModel = new KelasProfilModel();
        $this->masterkelasModel = new MasterKelasModel();
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
            'kelas' => $this->masterkelasModel->findAll(),
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Classes', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Classes', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-kelas', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $jenjang = $this->request->getGet('jenjang');
            $tahun = $this->request->getGet('tahun');

            $profil = $this->userModel
                ->select('users.id as userid, profil.id as profilid, nama_lengkap, nisn')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id', 'LEFT')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id', 'LEFT')
                ->where('name', 'santri')
                ->where('kelas_id', null)
                ->where('santri_id', null)
                ->findAll();
            if ($tahun != "") {
                $posts = $this->kelasprofilModel
                    ->select('kelas_profil.id as tabelid, master_kelas.id as kelasid, santri_id, santri.nama_lengkap as santri, wali.nama_lengkap as wali, santri.nisn, tahun_ajaran, kelas')
                    ->join('profil santri', 'kelas_profil.santri_id = santri.id')
                    ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                    ->join('profil wali', 'master_kelas.wali_id = wali.id', 'LEFT')
                    ->where('master_kelas.deskripsi', $jenjang)
                    ->where('kelas_profil.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->kelasprofilModel
                    ->select('kelas_profil.id as tabelid, master_kelas.id as kelasid, santri_id, santri.nama_lengkap as santri, wali.nama_lengkap as wali, santri.nisn, tahun_ajaran, kelas')
                    ->join('profil santri', 'kelas_profil.santri_id = santri.id')
                    ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                    ->join('profil wali', 'master_kelas.wali_id = wali.id', 'LEFT')
                    ->where('master_kelas.deskripsi', $jenjang)
                    ->where('kelas_profil.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }



            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = '<div class="btn-group d-flex justify-content-center"><input
                type="checkbox" class="form-check-input check' . $no . '"
                id="check" data-no="' . $no . '" data-santri-id="' . $key->santri_id . '" data-kelas-id="' . $key->kelas_id . '" data-id="' . $key->tabelid . '"></div>';
                    $row[] = $key->santri;
                    $row[] = $key->kelas;
                    $row[] = $key->nisn;
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
                    'kelasid' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kelas is required !'
                        ]
                    ],
                    'userid' => [
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
                'kelas_id' => $this->request->getPost('kelasid'),
                'santri_id' => $this->request->getPost('userid'),
                'tahun_ajaran' => $this->tahunModel->where('status', 1)->get()->getRow()->tahun,
            ];

            if (!$this->kelasprofilModel->save($data)) {
                $data = array('error' => 'Failed add to data class.');
            }
            $data = array('success' => 'Successfully add to data class.');
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
            $kelas_id = $this->request->getPost('kelasid');

            for ($i = 0; $i < count($santri_id); $i++) {
                if ($santri_id[$i] != null) {
                    if (
                        $this->kelasprofilModel
                        ->where('santri_id', $santri_id[$i])
                        ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                        ->countAllResults() != 0
                    ) {
                        $data = array('error' => 'Santri sudah memiliki kelas tahun ini');
                        $data[$csrfname] = $csrfhash;
                        return $this->response->setJSON($data);
                    }
                    $row = [
                        'santri_id' => $santri_id[$i],
                        'kelas_id' => $kelas_id,
                        'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                    ];

                    $data[] = $row;
                }
            }

            if (!$this->kelasprofilModel->insertBatch($data)) {
                $data = array('error' => 'Gagal mengubah kelas.');
            }

            for ($i = 0; $i < count($santri_id); $i++) {
                if ($santri_id[$i] != null) {
                    $data = [
                        'user_id' => user()->id,
                        'pesan' => 'Update kelas santri_id = ' . $santri_id[$i] . ' ke kelas_id = ' . $kelas_id,
                    ];
                    $data[] = $row;
                }
            }

            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah data kelas.');
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

            if (!$this->kelasprofilModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data kelas.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Menghapus data kelas',
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil menghapus data kelas santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}