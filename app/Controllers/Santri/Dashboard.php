<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\DataTagihanModel;
use App\Models\JadwalPelajaranModel;
use App\Models\KehadiranModel;
use App\Models\PelanggaranModel;
use App\Models\ProfilModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->profilModel = new ProfilModel();
        $this->tagihanModel = new DataTagihanModel();
        $this->pelanggaranModel = new PelanggaranModel();
        $this->jadwalpelajaranModel = new JadwalPelajaranModel();
        helper('number');
    }
    public function index()
    {
        $biaya = $this->tagihanModel->where('user_id', user_id())->where('status', 0)->selectSum('nominal')->get()->getRow()->nominal;
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'mapel' => $this->jadwalpelajaranModel
                ->select('*, kehadiran.id as kehadiranid, jadwal_pelajaran.id as pelajaranid, master_pelajaran.id as mapelid, kehadiran.status, kehadiran.created_at')
                ->join('kehadiran', 'kehadiran.jadwal_id = jadwal_pelajaran.id', 'LEFT')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_jadwal', 'jadwal_pelajaran.jadwal_id = master_jadwal.id')
                ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->join('profil santri1', 'kehadiran.santri_id = santri1.id', 'LEFT')
                ->join('users_profil u1', 'u1.profil_id = santri1.id', 'LEFT')
                ->join('kelas_profil', 'kelas_profil.kelas_id = master_kelas.id')
                ->join('profil santri2', 'kelas_profil.santri_id = santri2.id')
                ->join('users_profil u2', 'u2.profil_id = santri2.id')
                ->join('users users1', 'u1.user_id = users1.id', 'LEFT')
                ->join('users users2', 'u2.user_id = users2.id')
                ->where('jadwal_pelajaran.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->Where('users2.id', user_id())
                ->orWhere('users1.id', user_id())
                ->orderBy('master_kelas.id', 'ASC')
                ->orderBy('hari', 'ASC')
                ->orderBy('jam', 'ASC')
                ->countAllResults(),
            'tagihan' => $this->tagihanModel->where('user_id', user_id())->where('status', 1)->countAllResults(),
            'pelanggaran' => $this->pelanggaranModel->join('profil', 'pelanggaran.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('master_kelas', 'pelanggaran.kelas_id = master_kelas.id')
                ->where('users.id', user_id())->countAllResults(),
            'biaya' => number_to_currency(($biaya) / 1000, 'IDR', null),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Dashboard', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Dashboard', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        // return view('santri/dashboard', $data);
        if (in_groups('santri')) {
            return view('santri/dashboard', $data);
        } else {
            return redirect()->to('/admin');
        }
    }

    public function profil()
    {
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->select('*, profil.id as profilid')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Profile', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Profile', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        dd($data);
        // return view('santri/profil', $data);
    }

    public function update()
    {
        if ($this->request->isAjax()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $data = [
                'id' => $this->request->getPost('id'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            $this->profilModel->save($data);

            $data = [
                'user_id' => user_id(),
                'pesan' => 'Changed password user ' . user()->username,
            ];

            $this->logModel->save($data);

            $data = array('success' => 'Successfully Update Your Profile');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}