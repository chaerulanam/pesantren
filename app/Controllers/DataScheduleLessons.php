<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\MasterJadwalModel;
use App\Models\MasterKelasModel;
use App\Models\MasterPelajaranModel;

class DataScheduleLessons extends BaseController
{
    public function __construct()
    {
        $this->masterkelasModel = new MasterKelasModel();
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
        $this->masterpelajaranModel = new MasterPelajaranModel();
        $this->masterjadwalModel = new MasterJadwalModel();
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
            'guru' => $this->userModel
                ->select('profil.id, nama_lengkap')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->orWhere('name', 'guru')
                ->orWhere('name', 'bendahara')
                ->orWhere('name', 'pengajaran')
                ->orWhere('name', 'pengasuhan')
                ->findAll(),
            'kelas' => $this->masterkelasModel->groupBy('deskripsi')
                ->groupBy('kelas')->findAll(),
            'pelajaran' => $this->masterpelajaranModel->findAll(),
            'jadwal' => $this->masterjadwalModel->orderBy('hari', 'ASC')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Lessons Schedules', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Lessons Schedules', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/jadwal-pelajaran', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
            $tahun = $this->request->getPost('tahun');
            if ($tahun != "") {
                $posts = $this->jadwalpelajaranModel
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'jadwal_pelajaran.guru_id = profil.id')
                    ->where('tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->jadwalpelajaranModel
                    ->select('jadwal_pelajaran.id as jadwalpelajaranid, kelas, nama_pelajaran, hari, jam, nama_lengkap, tahun_ajaran')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'jadwal_pelajaran.guru_id = profil.id')
                    ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->kelas;
                    $row[] = $key->nama_pelajaran;
                    $row[] = $hari[$key->hari];
                    $row[] = $key->jam;
                    $row[] = $key->nama_lengkap;
                    $row[] = $key->tahun_ajaran;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                <a href="javascript:void(0);" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->jadwalpelajaranid . '">
                <i class="fas fa-trash-alt"></i>
                </a></div>';
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
            if ($this->jadwalpelajaranModel
                ->where('guru_id', $this->request->getPost('profilid'))
                ->where('jadwal_id', $this->request->getPost('jadwalid'))
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->countAllResults() > 0
            ) {
                $data = array('error' => 'Jadwal untuk guru ini sudah ada.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            if ($this->jadwalpelajaranModel
                ->where('kelas_id', $this->request->getPost('kelasid'))
                ->where('jadwal_id', $this->request->getPost('jadwalid'))
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->countAllResults() > 0
            ) {
                $data = array('error' => 'Jadwal untuk kelas ini sudah ada.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'kelas_id' => $this->request->getPost('kelasid'),
                'jadwal_id' => $this->request->getPost('jadwalid'),
                'pelajaran_id' => $this->request->getPost('pelajaranid'),
                'guru_id' => $this->request->getPost('profilid'),
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
            ];

            if (!$this->jadwalpelajaranModel->save($data)) {
                $data = array('error' => 'Failed add to data lessons schedules.');
            }
            $data = array('success' => 'Successfully add to data lessons schedules.');
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
            $id = $this->request->getPost('id');
            // $userid = $this->request->getPost('userid');
            if (!$this->jadwalpelajaranModel->delete($id)) {
                $data = array('error' => 'Failed delete data schedule lessons.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Delete data schedule lessons',
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Successfully delete data schedule lessons.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}