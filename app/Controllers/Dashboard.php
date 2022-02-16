<?php

namespace App\Controllers;

use App\Models\DataTagihanModel;
use App\Models\KunjunganModel;
use App\Models\PengeluaranModel;
use Myth\Auth\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->tagihanModel = new DataTagihanModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->kunjunganModel = new KunjunganModel();
        helper('number');
    }
    public function index()
    {
        $in = $this->tagihanModel->where('status', 0)->selectSum('nominal')->get()->getRow()->nominal;
        $out = $this->pengeluaranModel->where('bukti !=', '')->selectSum('nominal')->get()->getRow()->nominal;
        $inyear = $this->tagihanModel
            ->where('status', 0)
            ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
            ->selectSum('nominal')->get()->getRow()->nominal;
        $inmonth = $this->tagihanModel
            ->where('status', 0)
            ->where('MONTH(created_at)', date('m'))
            ->selectSum('nominal')->get()->getRow()->nominal;
        $outmonth = $this->pengeluaranModel->where('bukti !=', '')->where('MONTH(created_at)', date('m'))->selectSum('nominal')->get()->getRow()->nominal;
        $data = [
            'myprofil' => $this->userModel->where('user_id', user_id())
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->join('orangtua', 'orangtua.profil_id = profil.id')
                ->join('wali', 'wali.profil_id = profil.id')
                ->get()->getRow(),
            'sisa_uang' => number_to_currency(($in - $out) / 1000, 'IDR', null),
            'uang_bulan_ini' => number_to_currency(($inmonth) / 1000, 'IDR', null),
            'uang_tahun_ini' => number_to_currency(($inyear) / 1000, 'IDR', null),
            'pengeluaran' => number_to_currency(($outmonth) / 1000, 'IDR', null),
            'total_santri' => $this->userModel
                ->select('users.id as userid, username, name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->where('name', 'santri')
                ->where('users_profil.user_id !=', null)
                ->countAllresults(),
            'total_guru' => $this->userModel
                ->select('users.id as userid, username, name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->Where('name', 'guru')
                ->where('users_profil.user_id !=', null)
                ->countAllresults(),
            'pengunjung' => $this->kunjunganModel->where('MONTH(created_at)', date('m'))->countAllresults(),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Dashboard', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Dashboard', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/dashboard', $data);
    }
}