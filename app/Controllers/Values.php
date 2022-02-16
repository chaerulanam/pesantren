<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\KehadiranModel;
use App\Models\NilaiModel;
use CodeIgniter\I18n\Time;

class Values extends BaseController
{
    public function __construct()
    {
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
        $this->kehadiranModel = new KehadiranModel();
        $this->nilaiModel = new NilaiModel();
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
        return view('admin/nilai', $data);
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
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-info" id="nilai"  data-bs-toggle="modal" data-bs-target=".nilai" data-id="' . $key->jadwalpelajaranid . '">
                        <i class="fas fa-edit"></i> Isi Nilai
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

    public function datatable_nilai()
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
                    $no++;
                    $row = array();
                    // $row1 = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap;
                    $row[] = '<div class="d-flex justify-content-center">
                <input type="number" onchange="setTwoNumberDecimal()" min="0" max="10" step="0.25" value="0.0" class="form-control" id="form-nilai' . $no . '" placeholder="Input Nilai" data-id ="' . $no . '" data-profil ="' . $key->profilid . '" >
                  </div>';
                    $row1 = $key->profilid;
                    $dataid[] = $row1;
                    $data[] = $row;
                }
                $data = array('responce' => 'success', 'posts' => $data, 'id' => $dataid, 'kelas' => $key->kelas, 'mapel' => $key->nama_pelajaran);
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
            $nilai = $this->request->getPost('nilai');

            if (
                $this->nilaiModel
                ->where('semester', $this->tahunModel->SemesterAktif())
                ->where('jadwal_id', $jadwal)
                ->countAllresults() > 0
            ) {
                $data = array('error' => 'Anda sudah mengisi nilai semester tahun ini!');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            for ($i = 0; $i < count($profil); $i++) {
                if ($profil[$i] > 0) {
                    $row = [
                        'jadwal_id' => $jadwal,
                        'santri_id' => $profil[$i],
                        'nilai' => $nilai[$i],
                        'semester' => $this->tahunModel->SemesterAktif(),
                    ];

                    $data[] = $row;
                }
            }

            $this->nilaiModel->insertBatch($data);

            $data = array('success' => 'Berhasil menambahkan nilai.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}