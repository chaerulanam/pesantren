<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\KelasProfilModel;

class Kelas extends BaseController
{
    public function __construct()
    {
        $this->kelasModel = new KelasProfilModel();
    }

    public function index()
    {
        $id = $this->request->getGet('id');
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'kelas' => $this->kelasModel
                ->select('profil.nama_lengkap as nama_wali, kelas, tahun_ajaran, profil.no_hp')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->join('users as userwali', 'master_kelas.wali_id = userwali.id', 'LEFT')
                ->join('users_profil', 'users_profil.user_id = userwali.id', 'LEFT')
                ->join('profil', 'users_profil.profil_id = profil.id', 'LEFT')
                ->join('profil as profilsantri', 'kelas_profil.santri_id = profilsantri.id')
                ->join('users_profil as usersantri', 'usersantri.profil_id = profilsantri.id')
                ->join('users as santri', 'usersantri.user_id = santri.id')
                ->where('santri.id', user_id())
                ->orderBy('kelas_profil.id', 'DESC')
                ->findAll(),
            'tahun' => $this->tahunModel->TahunAktif(),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Kelas', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Kelas', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
        ];

        // dd($data);
        return view('santri/kelas', $data);
    }
}