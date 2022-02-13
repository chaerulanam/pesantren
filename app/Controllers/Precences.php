<?php

namespace App\Controllers;

use App\Models\DataTagihanModel;
use App\Models\MasterKelasModel;
use App\Models\MasterTagihanModel;

class Precences extends BaseController
{
    public function __construct()
    {
        $this->datatagihanModel = new DataTagihanModel();
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
            'alltahun' => $this->tahunModel->findAll(),
            'title_table' => 'Data ' . lang('Files.Profile') . ' ' . lang('Files.Students'),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Data Payments', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Data Payments', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/data-pembayaran', $data);
    }

    public function datatable()
    {
        // if ($this->request->isAJAX()) {
        $csrfname = csrf_token();
        $csrfhash = csrf_hash();
        $tahun = $this->request->getGet('tahun');
        if ($tahun != "") {
            $posts = $this->datatagihanModel
                ->select('*, tagihan.id as tagihanid, users.id as userid, tagihan.status')
                ->join('pembayaran', 'tagihan.invoice = pembayaran.order_id')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('tagihan.tahun_ajaran', $tahun)
                ->findAll();
        } else {
            $posts = $this->datatagihanModel
                ->select('*, tagihan.id as tagihanid, users.id as userid, pembayaran.status')
                ->join('pembayaran', 'tagihan.invoice = pembayaran.order_id')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('kelas_profil', 'kelas_profil.santri_id = profil.id')
                ->join('master_kelas', 'kelas_profil.kelas_id = master_kelas.id')
                ->where('tagihan.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->findAll();
        }
        if ($posts) {
            $no = 0;
            foreach ($posts as $key) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $key->invoice;
                $row[] = $key->nama_lengkap . ' | ' . $key->kelas;
                $row[] = $key->payment_type;
                $row[] = number_to_currency($key->nominal, 'IDR', null);
                if ($key->status == "") {
                    $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">Belum Dibayar</span></div>';
                    $row[] = $key->tahun_ajaran;
                    $row[] = '-';
                } else  if ($key->status == "pending") {
                    $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-warning text-white">' . $key->status . '</span></div>';
                    $row[] = $key->tahun_ajaran;
                    $row[] = '-';
                } else  if ($key->status == "settlement") {
                    $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">' . $key->status . '</span></div>';
                    $row[] = $key->tahun_ajaran;
                    $row[] = '<a href="invoice?id=' . $key->order_id . '" class="btn btn-outline-info uil-file-download-alt"> Download Invoice </a>';
                } else {
                    $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">' . $key->status . '</span></div>';
                    $row[] = $key->tahun_ajaran;
                    $row[] = '-';
                }

                $data[] = $row;
            }
            $data = array('responce' => 'success', 'posts' => $data);
        } else {
            $data = array('responce' => 'success', 'posts' => '');
        }
        $data[$csrfname] = $csrfhash;
        return $this->response->setJSON($data);
        // } else {
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
    }
}