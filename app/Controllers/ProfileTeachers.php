<?php

namespace App\Controllers;

use App\Models\OrangtuaModel;
use App\Models\ProfilModel;
use App\Models\UsersProfilModel;
use App\Models\WaliModel;
use Myth\Auth\Models\UserModel;

class ProfileTeachers extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->profilModel = new ProfilModel();
        $this->orangtuaModel = new OrangtuaModel();
        $this->waliModel = new WaliModel();
        $this->usersprofilModel = new UsersProfilModel();
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
            'users' => $this->userModel
                ->select('users.id as userid, username, name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->where('name', 'guru')
                ->where('users_profil.user_id', null)
                ->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Profile', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Profile', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/profil-guru', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->profilModel
                ->select('users.id as userid, profil.id as profilid, username, active, nama_lengkap, jenjang_pendidikan, jenis_kelamin, tempat_lahir, tanggal_lahir, foto')
                ->join('users_profil', 'users_profil.profil_id = profil.id', 'LEFT')
                ->join('users', 'users_profil.user_id = users.id', 'LEFT')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->where('name', 'guru')
                ->findAll()
            ) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->username;
                    $row[] = $key->nama_lengkap;
                    $row[] = $key->jenis_kelamin;
                    $row[] = $key->jenjang_pendidikan;
                    $row[] = $key->tempat_lahir . ', ' . $key->tanggal_lahir;
                    $row[] = '<a class="image-popup-vertical-fit" href="' . base_url() . '/assets/images/users/' . $key->foto . '" title="Caption. Can be aligned it to any side and contain any HTML.">
                    <img class="img-fluid" alt="" src="' . base_url() . '/assets/images/users/' . $key->foto . '" width="145">
                    </a>';
                    if ($key->active == 1) {
                        $row[] = '<span class="badge bg-success text-white">Active</span>';
                        if (has_permission('manage.admin')) {
                            $row[] = '<div class="btn-group me-1 mt-1">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="detail-teachers?username=' . $key->username . '" >Detail</a>                        
                        <a class="dropdown-item" id="delete" href="#" data-id="' . $key->profilid . '" data-userid="' . $key->userid . '">Delete</a>
                        </div>
                        </div>';
                        } else {
                            if ($key->userid == user_id()) {
                                $row[] = '<div class="btn-group me-1 mt-1">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="detail-teachers?username=' . $key->username . '" >Detail</a>                        
                                </div>
                                </div>';
                            } else {
                                $row[] = '-';
                            }
                        }
                        // <a class="dropdown-item" id="" href="#" data-bs-toggle="modal" data-bs-target=".update" data-id="' . $key->userid . '">Update</a>
                    } else if ($key->active == 0) {
                        if ($key->username == 0) {
                            $row[] = '<span class="badge bg-secondary text-white">Username Not Set</span>';
                            $row[] = '<div class="btn-group me-1 mt-1">
                            <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                            <div class="dropdown-menu">
                               <a class="dropdown-item" id="setusername" href="#" data-bs-toggle="modal" data-bs-target=".setusername" data-id="' . $key->profilid . '">Set Username</a>
                            </div>
                        </div>';
                        } else {
                            $row[] = '<span class="badge bg-danger text-white">Not Active</span>';
                        }
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

            $user_id = $this->request->getPost('user_id');

            // if (
            //     $this->profilModel
            //     ->where('user_id', $user_id)
            //     ->countAllResults() > 0
            // ) {
            //     $data = array('error' => 'Anda Sudah Menginput Data');
            //     $data[$csrfname] = $csrfhash;
            //     return $this->response->setJSON($data);
            // }

            if (!$this->validate(
                [
                    'user_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Username Harus Dipilih!'
                        ]
                    ],
                    'nama_lengkap' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama Lengkap Harus Diisi !'
                        ]
                    ],
                    'sekolah_asal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sekolah Asal Harus Diisi !'
                        ]
                    ],
                    'jenis_kelamin' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Jenis Kelamin Harus Diisi !'
                        ]
                    ],
                    'no_hp' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'No Hp Harus Diisi !'
                        ]
                    ],
                    'nik' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'NIK Harus Diisi !'
                        ]
                    ],
                    'no_kk' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'No KK Harus Diisi !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tempat Lahir Harus Diisi !'
                        ]
                    ],
                    'tanggal_lahir' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tanggal Lahir Harus Diisi !'
                        ]
                    ],
                    'alamat' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Alamat Lengkap Harus Diisi !'
                        ]
                    ],
                    'desa' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Desa Harus Diisi !'
                        ]
                    ],
                    'kecamatan' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kecamatan Harus Diisi !'
                        ]
                    ],
                    'kabupaten' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kabupaten Harus Diisi !'
                        ]
                    ],
                    'provinsi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Provinsi Harus Diisi !'
                        ]
                    ],
                    'foto' => [
                        'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                        'errors' => [
                            'uploaded' => 'Upload gambar dulu !',
                            'max_size' => 'Ukuran gambar maximal 2Mb !',
                            'is_image' => 'Yang anda upload bukan gambar !',
                            'mime_in' => 'Pilih format Jpg/Jpeg/Png !'
                        ]
                    ],
                    'nama_ayah' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama Ayah Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ayah' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pendidikan Ayah Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ayah' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Penghasilan Ayah Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ayah' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pekerjaan Ayah Harus Diisi !'
                        ]
                    ],
                    'nama_ibu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama Ibu Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ibu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pendidikan Ibu Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ibu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Penghasilan Ibu Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ibu' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Pekerjaan Ibu Harus Diisi !'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $alamat = $this->request->getPost('alamat');
            $desa = $this->request->getPost('desa');
            $kecamatan = $this->request->getPost('kecamatan');
            $kabupaten = $this->request->getPost('kabupaten');
            $provinsi = $this->request->getPost('provinsi');

            $file = $this->request->getFile('foto');
            $file->move('assets/images/users/');
            $filename = $file->getName();

            $data = [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'sekolah_asal' => $this->request->getPost('sekolah_asal'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'nisn' => $this->request->getPost('nisn'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => date('Y-m-d', strtotime($this->request->getPost('tanggal_lahir'))),
                'nik' => $this->request->getPost('nik'),
                'kk' => $this->request->getPost('no_kk'),
                'jenjang_pendidikan' => $this->request->getPost('jenjang_pendidikan'),
                'no_hp' => $this->request->getPost('no_hp'),
                'alamat_lengkap' => $alamat . '-' . $desa . '-' . $kecamatan . '-' . $kabupaten . '-' . $provinsi,
                'foto' => $filename,
            ];

            if (!$this->profilModel->save($data)) {
                $data = array('error' => 'Failed Add to Data Profile');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'nama_ayah' => $this->request->getPost('nama_ayah'),
                'pendidikan_ayah' => $this->request->getPost('pendidikan_ayah'),
                'penghasilan_ayah' => $this->request->getPost('penghasilan_ayah'),
                'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
                'nama_ibu' => $this->request->getPost('nama_ibu'),
                'pendidikan_ibu' => $this->request->getPost('pendidikan_ibu'),
                'penghasilan_ibu' => $this->request->getPost('penghasilan_ibu'),
                'pekerjaan_ibu' => $this->request->getPost('pekerjaan_ibu'),
                'profil_id' => $this->profilModel->insertID(),
            ];

            if (!$this->orangtuaModel->save($data)) {
                $data = array('error' => 'Failed Add to Data Orang Tua.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'nama_wali' => $this->request->getPost('nama_wali'),
                'hubungan_sosial' => $this->request->getPost('hubungan_sosial'),
                'penghasilan_wali' => $this->request->getPost('penghasilan_wali'),
                'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
                'profil_id' => $this->profilModel->insertID(),
            ];

            if (!$this->waliModel->save($data)) {
                $data = array('error' => 'Failed Add to Data Wali.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            if (!$this->usersprofilModel->adduserstoprofil($user_id, $this->profilModel->insertID())) {
                $data = array('error' => 'Failed Add to Users Profil');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Add new student  ' . $this->request->getPost('nama_lengkap'),
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Successfully add new student.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function setusersprofil()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $user_id = $this->request->getPost('user_id');
            $profil_id = $this->request->getPost('profil_id');
            if (!$this->usersprofilModel->adduserstoprofil($user_id, $profil_id)) {
                $data = array('error' => 'Failed Add to Users Profil');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            $data = array('success' => 'Successfully Add to Users Profil');
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
            $profilid = $this->request->getPost('profilid');
            // $userid = $this->request->getPost('userid');

            $guru = $this->profilModel->find($profilid);

            if (!$this->profilModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Profil.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->orangtuaModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Orang Tua.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->waliModel->delete($profilid)) {
                $data = array('error' => 'Gagal Menghapus Data Wali.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Menghapus Guru  ' . $guru->nama_lengkap,
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil Menghapus Data Guru.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}