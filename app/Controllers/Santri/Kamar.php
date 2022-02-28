<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\KamarProfilModel;

class Kamar extends BaseController
{
    public function __construct()
    {
        $this->kamarModel = new KamarProfilModel();
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
            'kamar' => $this->kamarModel
                ->select('profil.nama_lengkap as nama_wali, nama_kamar, nama_gedung, tahun_ajaran, profil.no_hp')
                ->join('master_kamar', 'kamar_profil.kamar_id = master_kamar.id')
                ->join('users as userwali', 'master_kamar.wali_id = userwali.id', 'LEFT')
                ->join('users_profil', 'users_profil.user_id = userwali.id', 'LEFT')
                ->join('profil', 'users_profil.profil_id = profil.id', 'LEFT')
                ->join('profil as profilsantri', 'kamar_profil.santri_id = profilsantri.id')
                ->join('users_profil as usersantri', 'usersantri.profil_id = profilsantri.id')
                ->join('users as santri', 'usersantri.user_id = santri.id')
                ->where('santri.id', user_id())
                ->orderBy('kamar_profil.id', 'DESC')
                ->findAll(),
            'tahun' => $this->tahunModel->TahunAktif(),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Kamar', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Kamar', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
        ];

        // dd($data);
        return view('santri/kamar', $data);
    }
}