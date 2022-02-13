<?php

namespace App\Controllers;

use App\Models\OrangtuaModel;
use App\Models\ProfilModel;
use App\Models\UsersProfilModel;
use App\Models\WaliModel;
use Myth\Auth\Models\UserModel;

class ProfileDetails extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->profilModel = new ProfilModel();
    }
    public function index()
    {
        $username = $this->request->getGet('username');
        if ($username != null) {
            $data = [
                'profil' => $this->userModel->where('username', $username)
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('orangtua', 'orangtua.profil_id = profil.id')
                    ->join('wali', 'wali.profil_id = profil.id')
                    ->get()->getRow(),
                'myprofil' => $this->userModel->where('user_id', user_id())
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('orangtua', 'orangtua.profil_id = profil.id')
                    ->join('wali', 'wali.profil_id = profil.id')
                    ->get()->getRow(),
                'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
                'title_meta' => view('admin/partials/title-meta', ['title' => 'Profile', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
                'page_title' => view('admin/partials/page-title', ['title' => 'Profile', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
            ];
            // dd($data);
            if (has_permission('manage.admin')) {
                return view('admin/profil-detail', $data);
            } else {
                if ($username == user()->username) {
                    return view('admin/profil-detail', $data);
                } else {
                    return redirect()->to('/admin');
                }
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}