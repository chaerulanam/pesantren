<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\ProfilModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->profilModel = new ProfilModel();
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
        // dd($data);
        return view('santri/profil', $data);
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