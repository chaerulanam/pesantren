<?php

namespace App\Controllers;

use App\Models\MasterTahunModel;
use Myth\Auth\Models\UserModel;

class MasterYears extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->mastertahunModel = new MasterTahunModel();
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
            'title_meta' => view('admin/partials/title-meta', ['title' => 'School Years', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'School Years', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'title_table' => lang('Files.Master Billings')
        ];
        // dd($data);
        return view('admin/master-tahun', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->mastertahunModel
                ->orderBy('tahun', 'ASC')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->tahun;
                    $row[] = $key->semester;
                    if ($key->status == 1) {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white"> Active </span></div>';
                        $row[] = '<div class="btn-group d-flex justify-content-center">-</div>';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white"> Not Active </span></div>';
                        $row[] = '<div class="btn-group d-flex justify-content-center">
            <a href="#" class="btn btn-outline-info" id="editmodal" data-bs-toggle="modal"
            data-bs-target=".editmodal" data-id="' . $key->id .  '">
            <i class="nav-icon fas fa-edit"></i>
            </a>
            <a href="#" class="btn btn-outline-danger" id="button-delete" data-id="' . $key->id .  '">
            <i class="nav-icon fas fa-trash"></i>
            </a>
            </div>';
                    }

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
                    'tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tahun is required !'
                        ]
                    ],
                    'semester' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Semester is required !'
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
                'tahun' => $this->request->getPost('tahun'),
                'semester' => $this->request->getPost('semester')
            ];

            if (!$this->mastertahunModel->save($data)) {
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
            if (!$this->mastertahunModel->delete($id)) {
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

            $post = $this->mastertahunModel->find($id);

            $data = [
                'id' => $post->id,
                'status' => $post->status,
                'tahun' => $post->tahun,
                'semester' => $post->semester,
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

            $aktif = $this->mastertahunModel->where('status', 1)->get()->getRow();

            $data = [
                'id' => $aktif->id,
                'status' => 0,
            ];

            if (!$this->mastertahunModel->save($data)) {
                $data = array('error' => 'Failed update to master year.');
            }

            $data = [
                'id' => $this->request->getPost('id'),
                'status' => 1
            ];

            if (!$this->mastertahunModel->save($data)) {
                $data = array('error' => 'Failed update to master year.');
            }
            $data = array('success' => 'Successfully update to master year.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}