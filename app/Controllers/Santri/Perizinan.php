<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\PerizinanModel;

class Perizinan extends BaseController
{
    public function __construct()
    {
        $this->perizinanModel = new PerizinanModel();
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
            'tahun' => $this->tahunModel->TahunAktif(),
            'alltahun' => $this->tahunModel->groupBy('tahun')->findAll(),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Perizinan', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Perizinan', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
        ];

        // dd($data);
        return view('santri/perizinan', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $tahun = $this->request->getGet('tahun');
            if ($tahun == "") {
                $posts = $this->perizinanModel
                    ->select('nama_lengkap, kelas, keperluan, perizinan.status, tahun_ajaran, perizinan.created_at, perizinan.updated_at')
                    ->join('profil', 'perizinan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'perizinan.kelas_id = master_kelas.id')
                    ->where('users.id', user_id())
                    ->orderBy('perizinan.id', 'DESC')
                    ->where('perizinan.tahun_ajaran', $this->tahunModel->TahunAktif())
                    ->findAll();
            } else {
                $posts = $this->perizinanModel
                    ->select('nama_lengkap, kelas, keperluan, perizinan.status, tahun_ajaran, perizinan.created_at, perizinan.updated_at')
                    ->join('profil', 'perizinan.santri_id = profil.id')
                    ->join('users_profil', 'users_profil.profil_id = profil.id')
                    ->join('users', 'users_profil.user_id = users.id')
                    ->join('master_kelas', 'perizinan.kelas_id = master_kelas.id')
                    ->where('users.id', user_id())
                    ->orderBy('perizinan.id', 'DESC')
                    ->where('perizinan.tahun_ajaran', $tahun)
                    ->findAll();
            }

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->nama_lengkap;
                    $row[] = $key->kelas;
                    $row[] = $key->keperluan;
                    $row[] = $key->created_at;
                    if ($key->status == 0) {
                        $row[] = $key->updated_at;
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">Sudah Selesai</span></div>';
                    } else {
                        $row[] = '-';
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">Belum Selesai</span></div>';
                    }
                    $row[] = $key->tahun_ajaran;
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
}