<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\KehadiranModel;
use CodeIgniter\I18n\Time;

class Presences extends BaseController
{
    public function __construct()
    {
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
        $this->kehadiranModel = new KehadiranModel();
        $this->time = new Time('now', 'Asia/Jakarta', 'id');
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
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Lessons Schedules', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Lessons Schedules', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/absensi', $data);
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
                    ->select('*, jadwal_pelajaran.id as jadwalpelajaranid')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'jadwal_pelajaran.guru_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->where('users.id', user_id())
                    ->where('tahun_ajaran', $tahun)
                    ->orderBy('kelas_id', 'ASC')
                    ->orderBy('hari', 'ASC')
                    ->orderBy('jam', 'ASC')
                    ->findAll();
            } else {
                $posts = $this->jadwalpelajaranModel
                    ->select('*, jadwal_pelajaran.id as jadwalpelajaranid')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'jadwal_pelajaran.guru_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->where('users.id', user_id())
                    ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->orderBy('kelas_id', 'ASC')
                    ->orderBy('hari', 'ASC')
                    ->orderBy('jam', 'ASC')
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $totalmasuk = $this->kehadiranModel
                        ->where('jadwal_id', $key->jadwalpelajaranid)
                        ->groupBy('date(created_at)')
                        ->countAllresults();
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->kelas;
                    $row[] = $key->nama_pelajaran;
                    $row[] = $hari[$key->hari] . ' | ' . $key->jam;
                    $row[] = $totalmasuk;
                    $row[] = $key->tahun_ajaran;
                    if ($key->hari == (int)$this->time->getDayOfWeek()) {
                        if ($this->time->difference($key->jam, 'Asia/Jakarta')->minutes <= 0 && $this->time->difference($key->jam, 'Asia/Jakarta')->minutes > -45) {
                            $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-info" id="absen"  data-bs-toggle="modal" data-bs-target=".absen" data-id="' . $key->jadwalpelajaranid . '">
                        <i class="fas fa-edit"></i> Absen
                        </a></div>';
                        } else {
                            $row[] = '<p><span class="badge bg-warning text-white">Belum Bisa Absen<span></p>';
                        }
                    } else {
                        $row[] = '<p><span class="badge bg-warning text-white">Belum Bisa Absen<span></p>';
                    }
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

    public function datatable_absen()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $id = $this->request->getGet('id');

            $posts = $this->userModel
                ->select('*, profil.id as profilid')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                ->where('jadwal_pelajaran.id', $id)
                ->findAll();
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $totalmasuk = $this->kehadiranModel
                        ->where('jadwal_id', $key->jadwalid)
                        ->groupBy('date(created_at)')
                        ->countAllresults();
                    $no++;
                    $row = array();
                    // $row1 = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap;
                    $row[] = '<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input hadir' . $no . '" id="hadir' . $no . '" data-no="' . $no . '"  data-status="hadir"></div>';
                    $row[] = '<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input izin' . $no . '" id="izin' . $no . '" data-no="' . $no . '"  data-status="izin"></div>';
                    $row[] = '<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input absen' . $no . '" id="absen' . $no . '" data-no="' . $no . '"  data-status="absen"></div>';
                    $row1 = $key->profilid;
                    $dataid[] = $row1;
                    $data[] = $row;
                }
                $data = array('responce' => 'success', 'posts' => $data, 'id' => $dataid);
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
            $profil = $this->request->getPost('profil');
            $jadwal = $this->request->getPost('jadwal');
            $status = $this->request->getPost('status');

            if ($this->kehadiranModel
                ->where('date(created_at)', date('Y:m:d'))
                ->where('jadwal_id', $jadwal)
                ->get()->getRow()
            ) {
                $data = array('error' => 'Anda Sudah Mengisi Absen Hari ini!');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            for ($i = 0; $i < count($profil); $i++) {
                if ($profil[$i] > 0) {
                    $row = [
                        'jadwal_id' => $jadwal,
                        'santri_id' => $profil[$i],
                        'status' => $status[$i],
                    ];
                    $data[] = $row;
                }
            }

            $this->kehadiranModel->insertBatch($data);

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