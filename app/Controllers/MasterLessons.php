<?php

namespace App\Controllers;

use App\Models\MasterPelajaranModel;
use Myth\Auth\Models\UserModel;

class MasterLessons extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->masterpelajaranModel = new MasterPelajaranModel();
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
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Master Lessons', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Master Lessons', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'title_table' => lang('Files.Master Lessons')
        ];
        // dd($data);
        return view('admin/master-pelajaran', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->masterpelajaranModel
                ->orderBy('nama_pelajaran', 'ASC')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $key->id;
                    $row[] = $key->nama_pelajaran;
                    $row[] = $key->deskripsi;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->id .  '">
                   <i class="nav-icon fas fa-trash"></i>
                   </a>
                   </div>';

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

    public function add()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if (!$this->validate(
                [
                    'pelajaran' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Mata Pelajaran is required !'
                        ]
                    ],
                    'deskripsi' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Deskripsi is required !'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'nama_pelajaran' => $this->request->getPost('pelajaran'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            if (!$this->masterpelajaranModel->save($data)) {
                $data = array('error' => 'Failed add to master class.');
            }
            $data = array('success' => 'Successfully add to master class.');
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
            if (!$this->masterpelajaranModel->delete($id)) {
                $data = array('error' => 'Failed delete master class');
            } else {
                $data = array('success' => 'Successfully delete master class');
            }
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}