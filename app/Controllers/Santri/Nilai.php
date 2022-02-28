<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\JadwalPelajaranModel;
use App\Models\NilaiModel;
use App\Models\PerizinanModel;
use CodeIgniter\I18n\Time;

class Nilai extends BaseController
{
    public function __construct()
    {
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
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
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Data Values and Ranks', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Data Values and Ranks', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('santri/nilai', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $tahun = $this->request->getGet('tahun');
            $kelasid = $this->request->getGet('kelas');
            $semester = $this->request->getGet('semester');
            if ($semester != "" || $tahun != "") {
                $posts = $this->nilaiModel
                    ->select('*, nilai.id as nilaiid, jadwal_pelajaran.id as pelajaranid, nilai.created_at')
                    ->join('jadwal_pelajaran', 'nilai.jadwal_id = jadwal_pelajaran.id')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'nilai.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->where('tahun_ajaran', $tahun)
                    ->where('semester', $semester)
                    ->where('users.id', user_id())
                    ->orderBy('kelas_id', 'ASC')
                    ->orderBy('hari', 'ASC')
                    ->orderBy('jam', 'ASC')
                    ->findAll();
            } else {
                $posts = $this->nilaiModel
                    ->select('*, nilai.id as nilaiid, jadwal_pelajaran.id as pelajaranid, nilai.created_at')
                    ->join('jadwal_pelajaran', 'nilai.jadwal_id = jadwal_pelajaran.id')
                    ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                    ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                    ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                    ->join('profil', 'nilai.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->where('semester', $this->tahunModel->SemesterAktif())
                    ->where('users.id', user_id())
                    ->groupBy('nama_pelajaran')
                    ->groupBy('nama_lengkap')
                    ->groupBy('kelas')
                    ->groupBy('semester')
                    ->groupBy('tahun_ajaran')
                    ->orderBy('kelas_id', 'ASC')
                    ->orderBy('hari', 'ASC')
                    ->orderBy('jam', 'ASC')
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->nama_pelajaran;
                    $row[] = $key->nilai;
                    $row[] = $key->tahun_ajaran . ' | ' . $key->semester;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-info" id="edit"  data-bs-toggle="modal" data-bs-target=".edit" data-id="' . $key->nilaiid . '" data-kelas="' . $key->kelas . '" data-nama="' . $key->nama_lengkap . '" data-mapel="' . $key->nama_pelajaran . '" data-nilai="' . $key->nilai . '">
                        <i class="fas fa-edit"></i> Edit Nilai
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

    public function datatable_rangking()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $myposts = $this->nilaiModel
                ->select('*, nilai.id as nilaiid, jadwal_pelajaran.id as pelajaranid, nilai.created_at')
                ->join('jadwal_pelajaran', 'nilai.jadwal_id = jadwal_pelajaran.id')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->join('profil', 'nilai.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->where('semester', $this->tahunModel->SemesterAktif())
                ->where('users.id', user_id())
                ->groupBy('nama_lengkap')
                ->groupBy('kelas')
                ->groupBy('semester')
                ->groupBy('tahun_ajaran')
                ->selectAvg('nilai')
                ->orderBy('kelas_id', 'ASC')
                ->orderBy('nilai', 'DESC')
                ->orderBy('hari', 'ASC')
                ->orderBy('jam', 'ASC')
                ->findAll();

            $posts = $this->nilaiModel
                ->select('*, users.id as userid, nilai.id as nilaiid, jadwal_pelajaran.id as pelajaranid, nilai.created_at')
                ->join('jadwal_pelajaran', 'nilai.jadwal_id = jadwal_pelajaran.id')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->join('profil', 'nilai.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->where('semester', $this->tahunModel->SemesterAktif())
                ->groupBy('nama_lengkap')
                ->groupBy('kelas')
                ->groupBy('semester')
                ->groupBy('tahun_ajaran')
                ->selectAvg('nilai')
                ->orderBy('kelas_id', 'ASC')
                ->orderBy('nilai', 'DESC')
                ->orderBy('hari', 'ASC')
                ->orderBy('jam', 'ASC')
                ->findAll();

            $myrank = 0;
            if ($posts) {

                $kelas_lama = 0;
                $oldnilai = 0;
                $i = 0;
                foreach ($posts as $key) {
                    $i++;
                    $rank = $i;
                    if ($key->nilai == $oldnilai) {
                        $rank = $i - 1;
                    }

                    if ($key->kelas != $kelas_lama) {
                        $i = 1;
                        $rank = $i;
                    }
                    $oldnilai = $key->nilai;
                    $kelas_lama = $key->kelas;
                    if ($key->userid == user_id()) {
                        $myrank = $rank;
                    }
                }

                $no = 0;
                foreach ($myposts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                    $row[] = $key->nilai;
                    $row[] = $myrank;
                    $row[] = $key->tahun_ajaran . ' | ' . $key->semester;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-info" id="print"  data-bs-toggle="modal" data-bs-target=".print" data-id="' . $key->nilaiid . '" data-kelas="' . $key->kelas . '" data-nama="' . $key->nama_lengkap . '" data-mapel="' . $key->nama_pelajaran . '" data-nilai="' . $key->nilai . '">
                        <i class="fas fa-print"></i> Cetak Raport
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

            $mapel = $this->nilaiModel
                ->select('*, nilai.id as nilaiid, jadwal_pelajaran.id as pelajaranid, nilai.status, nilai.created_at')
                ->join('jadwal_pelajaran', 'nilai.jadwal_id = jadwal_pelajaran.id')
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
            $nilai = $this->request->getPost('nilai');

            $data = [
                'id' => $jadwalid,
                'nilai' => $nilai,
            ];

            $this->nilaiModel->save($data);

            $data = [
                'user_id' => user_id(),
                'pesan' => 'Mengubah data nilai ' . $nama . ' ke : ' . $nilai,
            ];

            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah nilai santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}