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
            'kelas' => $this->masterkelasModel->groupBy('deskripsi')
                ->groupBy('kelas')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Billings', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Billings', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
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

            $posts = $this->kelasprofilModel
                ->select('master_kelas.id as kelasid, santri.nama_lengkap as santri, wali.nama_lengkap as wali, santri.nisn, tahun_ajaran, kelas')
                ->join('profil santri', 'kelas_profil.santri_id = santri.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->join('profil wali', 'master_kelas.wali_id = wali.id', 'LEFT')
                ->where('master_kelas.deskripsi', $jenjang)
                ->findAll();


            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = '<div class="btn-group d-flex justify-content-center"><input
                type="checkbox" class="form-check-input check' . $no . '"
                id="check" data-no="' . $no . '" data-santri-id="' . $key->santri_id . '" data-kelas-id="' . $key->kelas_id . '"></div>';
                    $row[] = $key->santri;
                    $row[] = $key->kelas;
                    $row[] = $key->nisn;
                    $row[] = $key->tahun_ajaran;
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
                        $data = array('error' => 'Santri already have class');
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
                $data = array('error' => 'Failed update to data class.');
            }

            for ($i = 0; $i < count($santri_id); $i++) {
                if ($santri_id[$i] != null) {
                    $data = [
                        'user_id' => user()->id,
                        'pesan' => 'Update class of students by santri_id = ' . $santri_id[$i] . ' to kelas_id = ' . $kelas_id,
                    ];
                    $data[] = $row;
                }
            }

            $this->logModel->save($data);

            $data = array('success' => 'Successfully update to data class.');
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
            $profilid = $this->request->getPost('profilid');
            // $userid = $this->request->getPost('userid');

            $santri = $this->profilModel->find($profilid);

            if (!$this->profilModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Profil.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->orangtuaModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Orang Tua.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->waliModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Wali.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Menghapus Santri  ' . $santri->nama_lengkap,
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil Menghapus Data Santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}