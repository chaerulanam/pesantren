<?php

namespace App\Controllers;

use App\Models\OrangtuaModel;
use App\Models\ProfilModel;
use App\Models\UsersProfilModel;
use App\Models\WaliModel;
use CodeIgniter\HTTP\ResponseTrait;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class ProfileStudents extends BaseController
{
    protected $auth;
    use ResponseTrait;

    /**
     * @var AuthConfig
     */
    protected $config;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->profilModel = new ProfilModel();
        $this->orangtuaModel = new OrangtuaModel();
        $this->waliModel = new WaliModel();
        $this->usersprofilModel = new UsersProfilModel();
        $this->config = config('Auth');
        $this->auth = service('authentication');
        $this->auth = service('authorization');
        $this->groupModel = new GroupModel();
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
                ->where('name', 'none')
                ->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Profile', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Profile', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/profil-santri', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($posts = $this->profilModel
                ->select('users.id as userid, profil.id as profilid, username, active, nama_lengkap, jenjang_pendidikan, jenis_kelamin, tempat_lahir, tanggal_lahir, foto')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->where('name', 'santri')
                ->orderBy('profil.id', 'DESC')
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
                    if ($key->foto == "") {
                        $row[] = '<a href="' . base_url() . '/assets/images/users/default.png" title="profil">
                    <img class="img-fluid" alt="" src="' . base_url() . '/assets/images/users/default.png" width="145">
                    </a>';
                    } else {
                        $row[] = '<a href="' . base_url() . '/assets/images/users/' . $key->foto . '" title="profil">
                    <img class="img-fluid" alt="" src="' . base_url() . '/assets/images/users/' . $key->foto . '" width="145">
                    </a>';
                    }
                    if ($key->active == 1) {
                        $row[] = '<span class="badge bg-success text-white">Active</span>';
                        if (has_permission('manage.admin')) {
                            $row[] = '<div class="btn-group me-1 mt-1">
                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="detail-students?username=' . $key->username . '" >Detail</a>  
                        <a class="dropdown-item" id="edit" href="#" data-bs-toggle="modal"
                        data-bs-target=".edit" data-id="' . $key->profilid . '" data-userid="' . $key->userid . '">Edit</a>  
                        <a class="dropdown-item" id="updatefoto" href="#" data-bs-toggle="modal"
                        data-bs-target=".updatefoto" data-id="' . $key->profilid . '" data-userid="' . $key->userid . '">Update Foto</a>                      
                        <a class="dropdown-item" id="delete" href="#" data-id="' . $key->profilid . '" data-userid="' . $key->userid . '">Delete</a>
                        </div>
                        </div>';
                        } else {
                            if ($key->userid == user_id()) {
                                $row[] = '<div class="btn-group me-1 mt-1">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="detail-students?username=' . $key->username . '" >Detail</a>                        
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

            if (!$this->validate(
                [
                    'user_id' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Username Harus Dipilih!'
                        ]
                    ],
                    'nama_lengkap' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Lengkap Harus Diisi !'
                        ]
                    ],
                    'sekolah_asal' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Sekolah Asal Harus Diisi !'
                        ]
                    ],
                    'jenis_kelamin' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Jenis Kelamin Harus Diisi !'
                        ]
                    ],
                    'no_hp' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'No Hp Harus Diisi !'
                        ]
                    ],
                    'nik' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'NIK Harus Diisi !'
                        ]
                    ],
                    'no_kk' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'No KK Harus Diisi !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Tempat Lahir Harus Diisi !'
                        ]
                    ],
                    'tanggal_lahir' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Tanggal Lahir Harus Diisi !'
                        ]
                    ],
                    'alamat' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Alamat Lengkap Harus Diisi !'
                        ]
                    ],
                    'desa' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Desa Harus Diisi !'
                        ]
                    ],
                    'kecamatan' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Kecamatan Harus Diisi !'
                        ]
                    ],
                    'kabupaten' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Kabupaten Harus Diisi !'
                        ]
                    ],
                    'provinsi' => [
                        'rules' => 'required|alpha_numeric_punct',
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
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Ayah Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pendidikan Ayah Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Penghasilan Ayah Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pekerjaan Ayah Harus Diisi !'
                        ]
                    ],
                    'nama_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Ibu Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pendidikan Ibu Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Penghasilan Ibu Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
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
                $data = array('error' => 'Gagal menambahkan profil santri');
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
                $data = array('error' => 'Gagal menambahkan orangtua santri.');
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
                $data = array('error' => 'Gagal menambahkan wali santri.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            if (!$this->usersprofilModel->adduserstoprofil($user_id, $this->profilModel->insertID())) {
                $data = array('error' => 'Failed Add to Users Profil');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            if (!$this->auth->removeUserFromGroup($user_id, 'none')) {
                $data = array('error' => 'Gagal Menghapus Grup User');
            } else if (!$this->auth->addUserToGroup($user_id, 'santri')) {
                $data = array('error' => 'Gagal Menambah Grup User');
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Menambah santri baru  ' . $this->request->getPost('nama_lengkap'),
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil menambah santri baru.');
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

            $santri = $this->profilModel->find($profilid);

            if (!$this->profilModel->delete($profilid)) {
                $data = array('error' => 'Failed delete data profil.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->orangtuaModel->delete($profilid)) {
                $data = array('error' => 'Failed delete Data orang tua.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
            if (!$this->waliModel->delete($profilid)) {
                $data = array('error' => 'Fagal felete data wali.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Delete student  ' . $santri->nama_lengkap,
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil Delete Data Santri.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function get_detail()
    {
        // if ($this->request->isAJAX()) {
        $csrfname = csrf_token();
        $csrfhash = csrf_hash();
        $id = $this->request->getGet('id');

        $data['profil'] = $this->profilModel
            ->select('*, users.id as userid, profil.id as profilid')
            ->join('orangtua', 'orangtua.profil_id = profil.id')
            ->join('wali', 'wali.profil_id = profil.id')
            ->join('users_profil', 'users_profil.profil_id = profil.id')
            ->join('users', 'users_profil.user_id = users.id')
            ->find($id);

        $data[$csrfname] = $csrfhash;
        return $this->response->setJSON($data);
        // } else {
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $id = $this->request->getPost('id');

            if (!$this->validate(
                [
                    'nama_lengkap' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Lengkap Harus Diisi !'
                        ]
                    ],
                    'sekolah_asal' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Sekolah Asal Harus Diisi !'
                        ]
                    ],
                    'jenis_kelamin' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Jenis Kelamin Harus Diisi !'
                        ]
                    ],
                    'no_hp' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'No Hp Harus Diisi !'
                        ]
                    ],
                    'nik' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'NIK Harus Diisi !'
                        ]
                    ],
                    'no_kk' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'No KK Harus Diisi !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Tempat Lahir Harus Diisi !'
                        ]
                    ],
                    'tanggal_lahir' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Tanggal Lahir Harus Diisi !'
                        ]
                    ],
                    'alamat' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Alamat Lengkap Harus Diisi !'
                        ]
                    ],
                    'nama_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Ayah Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pendidikan Ayah Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Penghasilan Ayah Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ayah' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pekerjaan Ayah Harus Diisi !'
                        ]
                    ],
                    'nama_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Nama Ibu Harus Diisi !'
                        ]
                    ],
                    'pendidikan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Pendidikan Ibu Harus Diisi !'
                        ]
                    ],
                    'penghasilan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
                        'errors' => [
                            'required' => 'Penghasilan Ibu Harus Diisi !'
                        ]
                    ],
                    'pekerjaan_ibu' => [
                        'rules' => 'required|alpha_numeric_punct',
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

            $data = [
                'id' => $id,
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
                'alamat_lengkap' => $alamat,
            ];

            if (!$this->profilModel->save($data)) {
                $data = array('error' => 'Gagal mengubah profil');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'id' => $id,
                'nama_ayah' => $this->request->getPost('nama_ayah'),
                'pendidikan_ayah' => $this->request->getPost('pendidikan_ayah'),
                'penghasilan_ayah' => $this->request->getPost('penghasilan_ayah'),
                'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
                'nama_ibu' => $this->request->getPost('nama_ibu'),
                'pendidikan_ibu' => $this->request->getPost('pendidikan_ibu'),
                'penghasilan_ibu' => $this->request->getPost('penghasilan_ibu'),
                'pekerjaan_ibu' => $this->request->getPost('pekerjaan_ibu'),
            ];

            if (!$this->orangtuaModel->save($data)) {
                $data = array('error' => 'Gagal mengubah orang tua.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'id' => $id,
                'nama_wali' => $this->request->getPost('nama_wali'),
                'hubungan_sosial' => $this->request->getPost('hubungan_sosial'),
                'penghasilan_wali' => $this->request->getPost('penghasilan_wali'),
                'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
            ];

            if (!$this->waliModel->save($data)) {
                $data = array('error' => 'Gagal mengubah wali.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Mengubah profil' . $this->request->getPost('nama_lengkap'),
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah profil.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }


    public function updatefoto()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $id = $this->request->getPost('id');

            if (!$this->validate(
                [

                    'foto' => [
                        'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                        'errors' => [
                            'uploaded' => 'Upload gambar dulu !',
                            'max_size' => 'Ukuran gambar maximal 2Mb !',
                            'is_image' => 'Yang anda upload bukan gambar !',
                            'mime_in' => 'Pilih format Jpg/Jpeg/Png !'
                        ]
                    ],

                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $file = $this->request->getFile('foto');

            if ($file == "") {
                $filename = $this->request->getPost('foto-before');
            } else {
                $file->move('assets/images/users');
                $filename = $file->getName();
            }

            $data = [
                'id' => $id,
                'foto' => $filename,
            ];

            if (!$this->profilModel->save($data)) {
                $data = array('error' => 'Gagal mengubah foto profil');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Update foto profil  ' . $this->request->getPost('nama_lengkap'),
            ];
            $this->logModel->save($data);

            $data = array('success' => 'Berhasil mengubah foto profil.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }


    public function import()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if (!$this->validate(
                [
                    'file' => [
                        'rules' => 'uploaded[file]',
                        'errors' => [
                            'uploaded' => 'Upload Your File !',
                        ],
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $file = $this->request->getFile('file');
            $filename = $file->getTempName();

            $post = array_map('str_getcsv', file($filename));

            $data = array();
            foreach ($post as $key) {
                $data = [
                    'username' => $key[0],
                    'email' => $key[1] . '@al-ishlahtajug.sch.id',
                    'password' => $key[2],
                ];

                $users = model(UserModel::class);

                // $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
                $user = new User($data);

                $user->activate();

                $users = $users->withGroup('santri');

                if (!$users->save($user)) {
                    // return redirect()->back()->withInput()->with('errors', $users->errors());

                    $data = $users->errors();
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }

                // // profil

                $data = [
                    'nama_lengkap' => $key[3],
                    'sekolah_asal' => $key[4],
                    'jenis_kelamin' => $key[5],
                    'nisn' => $key[6],
                    'tempat_lahir' => $key[7],
                    'tanggal_lahir' => $key[8],
                    'nik' => $key[9],
                    'kk' => $key[10],
                    'jenjang_pendidikan' => $key[11],
                    'no_hp' => $key[12],
                    'alamat_lengkap' => $key[13],
                ];

                if (!$this->profilModel->save($data)) {
                    $data = array('error' => 'Gagal menambahkan profil santri');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }

                // // //orangtua

                $data = [
                    'nama_ayah' => $key[14],
                    'pendidikan_ayah' => $key[15],
                    'penghasilan_ayah' => $key[16],
                    'pekerjaan_ayah' => $key[17],
                    'nama_ibu' => $key[18],
                    'pendidikan_ibu' => $key[19],
                    'penghasilan_ibu' => $key[20],
                    'pekerjaan_ibu' => $key[21],
                    'profil_id' => $this->profilModel->getID(),
                ];

                if (!$this->orangtuaModel->save($data)) {
                    $data = array('error' => 'Gagal menambahkan orangtua santri.');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }

                $data = [
                    'nama_wali' => $key[22],
                    'hubungan_sosial' => $key[23],
                    'penghasilan_wali' => $key[24],
                    'pekerjaan_wali' => $key[25],
                    'profil_id' => $this->profilModel->getID(),
                ];

                if (!$this->waliModel->save($data)) {
                    $data = array('error' => 'Gagal menambahkan wali santri.');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }

                if (!$this->usersprofilModel->adduserstoprofil($this->userModel->getID(), $this->profilModel->getID())) {
                    $data = array('error' => 'Gagal menambahkan santri ke user');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }

                $data = [
                    'user_id' => user_id(),
                    'pesan' => 'Menambahkan santri baru' . $key[3],
                ];

                $this->logModel->save($data);
            }
            $data = array('message' => lang('Auth.registerSuccess'));
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        }
    }
}