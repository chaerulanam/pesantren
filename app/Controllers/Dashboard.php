<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
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
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Dashboard', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Dashboard', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/dashboard', $data);
    }
}