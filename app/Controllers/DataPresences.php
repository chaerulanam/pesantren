<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\KehadiranModel;
use App\Models\PerizinanModel;
use CodeIgniter\I18n\Time;

class DataPresences extends BaseController
{
    public function __construct()
    {
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
        $this->kehadiranModel = new KehadiranModel();
        $this->perizinanModel = new PerizinanModel();
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
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Lessons', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Lessons', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-absensi', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
            $tahun = $this->request->getGet('tahun');
            $kelasid = $this->request->getGet('kelas');
            $user_id = $this->request->getGet('nama_lengkap');
            $jadwal_id = $this->request->getGet('mapel');
            $tanggal = $this->request->getGet('tanggal');

            if ($tanggal != "") {
                if ($tahun != "") {
                    $tahun = $tahun;
                    $posts = $this->kehadiranModel
                        ->select('*, kehadiran.id as kehadiranid, jadwal_pelajaran.id as pelajaranid, master_pelajaran.id as mapelid, kehadiran.status, kehadiran.created_at')
                        ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                        ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                        ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                        ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                        ->join('profil', 'kehadiran.santri_id = profil.id')
                        ->join('users_profil', 'users_profil.profil_id = profil.id')
                        ->join('users', 'users_profil.user_id = users.id')
                        ->where('tahun_ajaran', $tahun)
                        ->where('master_kelas.id', $kelasid)
                        ->where('users.id', $user_id)
                        ->where('jadwal_pelajaran.id', $jadwal_id)
                        ->where('date(kehadiran.created_at)', $tanggal)
                        ->orderBy('kelas_id', 'ASC')
                        ->orderBy('hari', 'ASC')
                        ->orderBy('jam', 'ASC')
                        ->findAll();
                } else {
                    $tahun = $this->tahunModel->TahunAktif();
                    $posts = $this->kehadiranModel
                        ->select('*, kehadiran.id as kehadiranid, jadwal_pelajaran.id as pelajaranid, master_pelajaran.id as mapelid, kehadiran.status, kehadiran.created_at')
                        ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                        ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                        ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                        ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                        ->join('profil', 'kehadiran.santri_id = profil.id')
                        ->join('users_profil', 'users_profil.profil_id = profil.id')
                        ->join('users', 'users_profil.user_id = users.id')
                        ->where('tahun_ajaran', $tahun)
                        ->where('master_kelas.id', $kelasid)
                        ->where('users.id', $user_id)
                        ->where('jadwal_pelajaran.id', $jadwal_id)
                        ->where('date(kehadiran.created_at)', $tanggal)
                        ->orderBy('kelas_id', 'ASC')
                        ->orderBy('hari', 'ASC')
                        ->orderBy('jam', 'ASC')
                        ->findAll();
                }
            } else {
                $tahun = $this->tahunModel->TahunAktif();
                $posts = $this->kehadiranModel
                    ->select('*, kehadiran.id as kehadiranid, jadwal_pelajaran.id as pelajaranid, master_pelajaran.id as mapelid, kehadiran.status, kehadiran.created_at')
                    ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'kehadiran.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
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
                        ->select('kehadiran.created_at as waktu')
                        ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                        ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                        ->where('master_pelajaran.id', $key->mapelid)
                        ->groupBy('date(kehadiran.created_at)')
                        ->countAllresults();
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->nama_pelajaran;
                    $row[] = $hari[$key->hari] . ' | ' . $key->jam;
                    $row[] = $totalmasuk;
                    $row[] = $key->status;
                    $row[] = $key->created_at;
                    $row[] = $key->tahun_ajaran;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-info" id="edit"  data-bs-toggle="modal" data-bs-target=".edit" data-id="' . $key->kehadiranid . '" data-kelas="' . $key->kelas . '" data-nama="' . $key->nama_lengkap . '" data-mapel="' . $key->nama_pelajaran . '" data-tanggal="' . date('Y-m-d', strtotime($key->created_at)) . '">
                        <i class="fas fa-edit"></i> Edit Status
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

    public function mapel()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $user_id = $this->request->getGet('userid');

            $mapel = $this->kehadiranModel
                ->select('*, kehadiran.id as kehadiranid, jadwal_pelajaran.id as pelajaranid, kehadiran.status, kehadiran.created_at')
                ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->join('kelas_profil', 'kelas_profil.kelas_id = master_kelas.id')
                ->join('profil', 'kelas_profil.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->groupBy('nama_pelajaran')
                ->where('users.id', $user_id)
                ->where('jadwal_pelajaran.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->orderBy('master_kelas.id', 'ASC')
                ->orderBy('hari', 'ASC')
                ->orderBy('jam', 'ASC')
                ->findAll();

            $data = array('mapel' => $mapel);
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

            $jadwalid = $this->request->getPost('id');
            $nama = $this->request->getPost('nama');
            $status = $this->request->getPost('status');

            $data = [
                'id' => $jadwalid,
                'status' => $status,
            ];

            $this->kehadiranModel->save($data);

            $data = [
                'user_id' => user_id(),
                'pesan' => 'Mengubah data kehadiran ' . $nama . ' ke status : ' . $status,
            ];

            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah data kehadiran santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}