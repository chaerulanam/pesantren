<?php

namespace App\Controllers;

use App\Models\DataTagihanModel;
use App\Models\PembayaranModel;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->tagihanModel = new DataTagihanModel();
        $this->pembayaranModel = new PembayaranModel();

        helper('number');
    }


    public function index()
    {
        $id = $this->request->getGet('id');
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'invoice' => $this->tagihanModel
                ->select('*, tagihan.deskripsi as desc, tagihan.updated_at')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('pembayaran', 'tagihan.invoice = pembayaran.order_id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->where('invoice', $id)->findAll(),
            'tahun' => $this->tahunModel->TahunAktif(),
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Invoice', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Invoice', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
        ];

        // dd($data);
        return view('admin/invoice', $data);
    }
}