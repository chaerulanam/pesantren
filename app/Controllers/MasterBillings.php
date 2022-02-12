<?php

namespace App\Controllers;

use App\Models\MasterTagihanModel;
use Myth\Auth\Models\UserModel;

class MasterBillings extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->mastertagihanModel = new MasterTagihanModel();
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
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Master Billings', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Master Billings', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'title_table' => lang('Files.Master Billings')
        ];
        // dd($data);
        return view('admin/master-tagihan', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->mastertagihanModel
                ->orderBy('id', 'DESC')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_tagihan;
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
                    'nama_tagihan' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} Harus diisi !'
                        ]
                    ],
                    'deskripsi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} Harus diisi !'
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

                'nama_tagihan' => $this->request->getPost('nama_tagihan'),
                'deskripsi' => $this->request->getPost('deskripsi')
            ];

            if (!$this->mastertagihanModel->save($data)) {
                $data = array('error' => 'Gagal Menambah Master Tagihan');
            }
            $data = array('success' => 'Berhasil Menambah Master Tagihan', 'post' => $data);
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
            if (!$this->mastertagihanModel->delete($id)) {
                $data = array('error' => 'delete Master Tagihan Gagal');
            } else {
                $data = array('success' => 'Delete Master Tagihan Berhasil');
            }
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}