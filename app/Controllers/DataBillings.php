<?php

namespace App\Controllers;

use App\Models\DataTagihanModel;
use App\Models\MasterKelasModel;
use App\Models\MasterTagihanModel;

class DataBillings extends BaseController
{
    public function __construct()
    {
        $this->datatagihanModel = new DataTagihanModel();
        $this->masterkelasModel = new MasterKelasModel();
        $this->mastertagihanModel = new MasterTagihanModel();
        helper('number');
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
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Billings', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Billings', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-tagihan', $data);
    }

    public function datatable_perkelas()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->datatagihanModel
                    ->select('tagihan.id as tagihanid, users.id as userid, master_tagihan.id as mastertagihanid, master_kelas.id as kelasid, kelas, nama_tagihan, no_tagihan, tagihan.status, tagihan.tahun_ajaran, nominal')
                    ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                    ->join('users', 'tagihan.user_id = users.id')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                    ->groupBy('kelas')
                    ->groupBy('tahun_ajaran')
                    ->groupBy('nama_tagihan')
                    ->selectSum('tagihan.status')
                    ->selectSum('tagihan.nominal')
                    ->where('tagihan.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->datatagihanModel
                    ->select('tagihan.id as tagihanid, users.id as userid, master_tagihan.id as mastertagihanid, master_kelas.id as kelasid, kelas, nama_tagihan, no_tagihan, tagihan.status, tagihan.tahun_ajaran, nominal')
                    ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                    ->join('users', 'tagihan.user_id = users.id')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                    ->groupBy('kelas')
                    ->groupBy('tahun_ajaran')
                    ->groupBy('nama_tagihan')
                    ->selectSum('tagihan.status')
                    ->selectSum('tagihan.nominal')
                    ->where('tagihan.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->kelas;
                    $row[] = $key->nama_tagihan;
                    $row[] = number_to_currency($key->nominal, 'IDR', null);
                    if ($key->status > 0) {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-warning text-white">Sisa ' . $key->status . ' Santri</span></div>';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">Lunas Semua</span></div>';
                    }
                    $row[] = $key->tahun_ajaran;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <a href="#" class="btn btn-outline-danger" id="button-delete-perkelas" data-kelas-id="' . $key->kelasid . '" data-master-tagihan-id="' . $key->mastertagihanid . '" data-tahun-ajaran="' . $key->tahun_ajaran . '"> <span class="uil-trash-alt" > Delete </span></a>
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

    public function datatable_perindividu()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->datatagihanModel
                    ->select('tagihan.id as tagihanid, users.id as userid, kelas, nama_tagihan, no_tagihan, tagihan.status, tagihan.tahun_ajaran, nama_lengkap, tagihan.deskripsi, nominal')
                    ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                    ->join('users', 'tagihan.user_id = users.id')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                    ->groupBy('kelas')
                    ->groupBy('no_tagihan')
                    ->groupBy('tahun_ajaran')
                    ->where('tagihan.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->datatagihanModel
                    ->select('tagihan.id as tagihanid, users.id as userid, kelas, nama_tagihan, no_tagihan, tagihan.status, tagihan.tahun_ajaran, nama_lengkap, tagihan.deskripsi, nominal')
                    ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                    ->join('users', 'tagihan.user_id = users.id')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                    ->groupBy('kelas')
                    ->groupBy('no_tagihan')
                    ->groupBy('tahun_ajaran')
                    ->where('tagihan.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->no_tagihan;
                    $row[] = $key->nama_lengkap;
                    $row[] = $key->kelas;
                    $row[] = $key->nama_tagihan;
                    $row[] = number_to_currency($key->nominal, 'IDR', null);
                    if ($key->status > 0) {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">Belum Lunas</span></div>';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">Sudah Lunas</span></div>';
                    }
                    $row[] = $key->tahun_ajaran;
                    $row[] = $key->deskripsi;
                    $row[] = '<div class="btn-group d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-danger waves-effect waves-light" id="button-delete-perindividu" data-id="' . $key->tagihanid . '"> <span class="uil-trash-alt" > Delete </span></button>
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

    public function add_perkelas()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            if (!$this->validate(
                [
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nominal is required!'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $kelasid = $this->request->getPost('kelasid');
            $jenis = $this->request->getPost('jenis_kelamin');

            if (
                $this->datatagihanModel
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('master_kelas.id', $kelasid)
                ->where('master_tagihan.id', $this->request->getPost('tagihanid'))
                ->where('tagihan.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->countAllResults() > 0
            ) {
                $data = array('error' => 'Data billings is exists.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            if ($jenis != "") {
                $posts = $this->userModel
                    ->select('users.id as userid')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                    ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                    ->where('master_kelas.id', $kelasid)
                    ->where('jenis_kelamin', $jenis)
                    ->findAll();
            } else {
                $posts = $this->userModel
                    ->select('users.id as userid')
                    ->join('users_profil', 'users_profil.user_id = users.id')
                    ->join('profil', 'users_profil.profil_id = profil.id')
                    ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                    ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                    ->where('master_kelas.id', $kelasid)
                    ->findAll();
            }

            if (!$posts) {
                $data = array('error' => 'No student in class.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $nominal = str_replace('Rp', '', $this->request->getPost('nominal'));
            $nominal = str_replace('.', '', $nominal);

            foreach ($posts as $key) {
                $notagihan = str_replace('20', '', $this->tahunModel->TahunAktif());
                $notagihan = str_replace('/', '', $notagihan);
                $notagihan = 'PAT' . $notagihan . $this->request->getPost('tagihanid') . $kelasid . $key->userid;
                $row = [
                    'no_tagihan' => $notagihan,
                    'kelas_id' => $kelasid,
                    'master_tagihan_id' => $this->request->getPost('tagihanid'),
                    'user_id' => $key->userid,
                    'nominal' => $nominal,
                    'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                    'status' => 1,
                ];
                $data[] = $row;
            }

            $this->datatagihanModel->insertBatch($data);

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Add new data billings by kelas',
            ];

            $this->logModel->save($data);

            $data = array('success' => 'Successfully add new billings by kelas.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function add_perindividu()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            if (!$this->validate(
                [
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nominal is required!'
                        ]
                    ],
                    'userid' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama lengkap is required!'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $kelasid = $this->request->getPost('kelasid');

            if (
                $this->datatagihanModel
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('master_kelas.id', $kelasid)
                ->where('master_tagihan.id', $this->request->getPost('tagihanid'))
                ->where('tagihan.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->countAllResults() > 0
            ) {
                $data = array('error' => 'Data billings is exists.');
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }


            $nominal = str_replace('Rp', '', $this->request->getPost('nominal'));
            $nominal = str_replace('.', '', $nominal);


            $notagihan = str_replace('20', '', $this->tahunModel->TahunAktif());
            $notagihan = str_replace('/', '', $notagihan);
            $notagihan = 'PAT' . $notagihan . $this->request->getPost('tagihanid') . $kelasid . $this->request->getPost('userid');
            $data = [
                'no_tagihan' => $notagihan,
                'kelas_id' => $kelasid,
                'master_tagihan_id' => $this->request->getPost('tagihanid'),
                'user_id' => $this->request->getPost('userid'),
                'nominal' => $nominal,
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                'status' => 1,
            ];

            $this->datatagihanModel->save($data);

            $data = [
                'user_id' => user()->id,
                'pesan' => 'Add new data billings no' . $notagihan,
            ];

            $this->logModel->save($data);

            $data = array('success' => 'Successfully add new billings by kelas.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete_perkelas()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $kelas = $this->request->getPost('kelas_id');
            $tagihan = $this->request->getPost('master_tagihan_id');
            $tahun = $this->request->getPost('tahun_ajaran');

            $posts = $this->datatagihanModel
                ->select('tagihan.id, no_tagihan')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('master_kelas.id', $kelas)
                ->where('master_tagihan.id', $tagihan)
                ->where('tagihan.tahun_ajaran', $tahun)
                ->findAll();

            foreach ($posts as $key) {
                $this->datatagihanModel->delete($key->id);

                $data = [
                    'user_id' => user()->id,
                    'pesan' => 'Delete data billing by no ' . $key->no_tagihan,
                ];
                $this->logModel->save($data);
            }

            $data = array('success' => 'Success detele data billings by kelas.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function delete_perindividu()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $this->datatagihanModel->delete($this->request->getPost('id'));
            $data = array('success' => 'Success detele data billings.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function getclassandbillings()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $kelas = $this->masterkelasModel->groupBy('deskripsi')
                ->groupBy('kelas')->findAll();
            $tagihan = $this->mastertagihanModel->findAll();

            $data = array('kelas' => $kelas, 'tagihan' => $tagihan);
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function getnama()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $kelasid = $this->request->getGet('kelas');

            $nama = $this->userModel
                ->select('users.id as userid, profil.id as profilid, nama_lengkap')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('kelas_id', $kelasid)
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->findAll();

            $data = array('nama' => $nama);
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}