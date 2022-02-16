<?php

namespace App\Controllers;

use App\Models\MasterKamarModel;
use Myth\Auth\Models\UserModel;

class MasterRooms extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->masterkamarModel = new MasterKamarModel();
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
            'wali' => $this->userModel
                ->select('users.id as userid, profil.id as profilid, username, name, nama_lengkap')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->orWhere('name', 'guru')
                ->orWhere('name', 'bendahara')
                ->orWhere('name', 'pengasuhan')
                ->orWhere('name', 'pengajaran')
                ->findAll(),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Master Room', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Master Room', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'title_table' => lang('Files.Master Room')
        ];
        // dd($data);
        return view('admin/master-kamar', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->masterkamarModel
                ->select('*, master_kamar.id as id, master_kamar.jenis_kelamin')
                ->join('profil', 'master_kamar.wali_id = profil.id', 'LEFT')
                ->groupBy('nama_gedung')
                ->groupBy('nama_kamar')
                // ->orderBy('kamar', 'ASC')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_kamar;
                    $row[] = $key->nama_gedung;
                    $row[] = $key->jenis_kelamin;
                    $row[] = $key->nama_lengkap;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-info" id="editmodal" data-bs-toggle="modal"
                    data-bs-target=".editmodal" data-id="' . $key->id .  '">
                    <i class="nav-icon fas fa-edit"></i>
                    </a>
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
                    'nama_kamar' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kamar harus diisi !'
                        ]
                    ],
                    'nama_gedung' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama gedung harus diisi !'
                        ]
                    ],
                    'wali' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Wali kamar harus diisi !'
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
                'nama_kamar' => $this->request->getPost('nama_kamar'),
                'nama_gedung' => $this->request->getPost('nama_gedung'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'wali_id' => $this->request->getPost('wali'),
            ];

            if (!$this->masterkamarModel->save($data)) {
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
            if (!$this->masterkamarModel->delete($id)) {
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

    public function get_detail()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $id = $this->request->getGet('id');
            $post = $this->masterkamarModel->find($id);

            $data = [
                'id' => $post->id,
                'nama_kamar' => $post->nama_kamar,
                'nama_gedung' => $post->nama_gedung,
                'jenis_kelamin' => $post->jenis_kelamin,
                'wali_id' => $post->wali_id,
            ];

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

            $data = [
                'id' => $this->request->getPost('id'),
                'wali_id' => $this->request->getPost('wali')
            ];

            if (!$this->masterkamarModel->save($data)) {
                $data = array('error' => 'Failed update to master class.');
            }
            $data = array('success' => 'Successfully update to master class.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}