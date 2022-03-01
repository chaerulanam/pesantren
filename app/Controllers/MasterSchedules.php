<?php

namespace App\Controllers;

use App\Models\MasterJadwalModel;
use Myth\Auth\Models\UserModel;

class MasterSchedules extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->masterjadwalModel = new MasterJadwalModel();
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
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Master Schedules', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Master Schedules', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'title_table' => lang('Files.Master Schedules')
        ];
        // dd($data);
        return view('admin/master-jadwal', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
            if ($posts = $this->masterjadwalModel
                ->groupBy('hari')
                ->groupBy('jam')
                ->orderBy('Hari', 'ASC')
                ->orderBy('Jam', 'ASC')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->jam;
                    $row[] = $hari[$key->hari];
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
                    'jam' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Jam is required !'
                        ]
                    ],
                    'hari' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Hari is required !'
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
                'jam' => $this->request->getPost('jam'),
                'hari' => $this->request->getPost('hari')
            ];

            if (!$this->masterjadwalModel->save($data)) {
                $data = array('error' => 'Failed add to master schedule.');
            }
            $data = array('success' => 'Successfully add to master schedule.');
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
            if (!$this->masterjadwalModel->delete($id)) {
                $data = array('error' => 'Failed delete master schedule');
            } else {
                $data = array('success' => 'Successfully delete master schedule');
            }
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}