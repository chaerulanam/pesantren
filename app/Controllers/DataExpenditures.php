<?php

namespace App\Controllers;

use App\Models\PengeluaranModel;

class DataExpenditures extends BaseController
{
    public function __construct()
    {
        $this->pengeluaranModel = new PengeluaranModel();
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
            'title_table' => 'Data pengeluaran',
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Expenditure', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Expenditure', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-pengeluaran', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $tahun = $this->request->getGet('tahun');
            if ($tahun != "") {
                $posts = $this->pengeluaranModel
                    ->where('pengeluaran.tahun_ajaran', $tahun)
                    ->findAll();
            } else {
                $posts = $this->pengeluaranModel
                    ->where('pengeluaran.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            }
            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_penerima;
                    $row[] = number_to_currency($key->nominal, 'IDR', null);
                    $row[] = $key->deskripsi;
                    if ($key->bukti == "") {
                        $row[] = '';
                    } else {
                        $row[] = '<a href="' . base_url() . '/assets/images/bukti/' . date('Y-m', strtotime($key->updated_at)) . '/' . $key->bukti . '" title="Foto bukti pengeluaran ' . $key->nama_lengkap . '">
                    <img class="img-fluid" alt="Foto Profil ' . $key->nama_lengkap . '" src="' . base_url() . '/assets/images/bukti/' . date('Y-m', strtotime($key->updated_at)) . '/' . $key->bukti . '" width="145">
                    </a>';
                    }

                    $row[] = '<div class="btn-group d-flex justify-content-center">
                <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".edit" id="edit" data-id="' . $key->id .  '">
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
                    'nama_penerima' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama penerima harus diisi !'
                        ]
                    ],
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nominal harus diisi !'
                        ]
                    ],
                ]
            )) {
                $validation = service('validation')->getErrors();
                $data = $validation;
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }

            $nominal = str_replace('Rp', '', $this->request->getPost('nominal'));
            $nominal = str_replace('.', '', $nominal);

            $data = [
                'nama_penerima' => $this->request->getPost('nama_penerima'),
                'nominal' => $nominal,
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
                'status' => 1,
            ];

            if (!$this->pengeluaranModel->save($data)) {
                $data = array('error' => 'Gagal menambah data pengeluaran.');
            }
            $data = array('success' => 'Berhasil menambah data pengeluaran.');
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
            $post = $this->pengeluaranModel->find($id);
            if ($post->bukti != "") {
                $path = 'assets/images/bukti/' . date('Y-m', strtotime($post->updated_at)) . '/' . $post->bukti;
                unlink($path);
            }

            if (!$this->pengeluaranModel->delete($id)) {
                $data = array('error' => 'Gagal menghapus data pengeluaran');
            } else {
                $data = array('success' => 'Berhasil menghapus data pengeluaran');
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
            $post = $this->pengeluaranModel
                ->find($id);

            $data = [
                'id' => $id,
                'nama_penerima' => $post->nama_penerima,
                'nominal' => number_to_currency($post->nominal, 'IDR', null),
                'deskripsi' => $post->deskripsi,
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

            if (!$this->validate(
                [
                    'foto' => [
                        'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                        'errors' => [
                            'uploaded' => 'Upload bukti dulu !',
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
            $file->move('assets/images/bukti/' . date('Y-m'));
            $filename = $file->getName();

            $data = [
                'id' => $this->request->getPost('id'),
                'bukti' => $filename,
            ];

            if (!$this->pengeluaranModel->save($data)) {
                $data = array('error' => 'Gagal mengubah bukti pengeluaran.');
            }
            $data = array('success' => 'Berhasil mengubah bukti pengeluaran.');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}