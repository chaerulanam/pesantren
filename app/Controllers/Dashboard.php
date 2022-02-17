<?php

namespace App\Controllers;

use App\Models\DataTagihanModel;
use App\Models\KehadiranModel;
use App\Models\KunjunganModel;
use App\Models\PelanggaranModel;
use App\Models\PembayaranModel;
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
        $this->pembayaranModel = new PembayaranModel();
        $this->pelanggaranModel = new PelanggaranModel();
        $this->kehadiranModel = new KehadiranModel();
        helper('number');
    }
    public function index()
    {
        $in = $this->pembayaranModel
            ->where('status', 'settlement')
            ->selectSum('gross_amount')->get()->getRow()->gross_amount;
        $out = $this->pengeluaranModel
            ->where('bukti !=', '')
            ->selectSum('nominal')->get()->getRow()->nominal;
        $inyear = $this->pembayaranModel
            ->where('status', 'settlement')
            ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
            ->selectSum('gross_amount')->get()->getRow()->gross_amount;
        $inmonth = $this->pembayaranModel
            ->where('status', 'settlement')
            ->where('MONTH(created_at)', date('m'))
            ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
            ->selectSum('gross_amount')->get()->getRow()->gross_amount;
        $outmonth = $this->pengeluaranModel->where('bukti !=', '')->where('MONTH(created_at)', date('m'))->where('tahun_ajaran', $this->tahunModel->TahunAktif())->selectSum('nominal')->get()->getRow()->nominal;
        $outyear = $this->pengeluaranModel->where('bukti !=', '')->where('tahun_ajaran', $this->tahunModel->TahunAktif())->selectSum('nominal')->get()->getRow()->nominal;
        if ($inyear > 0 && $outyear > 0) {
            $rasio = round($outyear / $inyear, 3);
        } else {
            $rasio = 0;
        }
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
            'pengeluaran_tahun' => number_to_currency(($outyear) / 1000, 'IDR', null),
            'rasio' => $rasio,
            'tabel_pembayaran' => $this->pembayaranModel
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->findAll(),
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
            'pelanggar' => $this->pelanggaranModel
                ->join('profil', 'pelanggaran.santri_id = profil.id')
                ->join('users_profil', 'users_profil.profil_id = profil.id')
                ->join('users', 'users_profil.user_id = users.id')
                ->join('master_kelas', 'pelanggaran.kelas_id = master_kelas.id')
                ->where('DAY(pelanggaran.created_at)', date('d'))
                ->findAll(),
            'absen' => $this->kehadiranModel
                ->select('*, kehadiran.status, nama_pelajaran, kehadiran.status as status')
                ->join('profil', 'kehadiran.santri_id = profil.id')
                ->join('jadwal_pelajaran', 'kehadiran.jadwal_id = jadwal_pelajaran.id')
                ->join('master_pelajaran', 'jadwal_pelajaran.pelajaran_id = master_pelajaran.id')
                ->join('master_kelas', 'jadwal_pelajaran.kelas_id = master_kelas.id')
                ->where('DAY(kehadiran.created_at)', date('d'))
                ->where('kehadiran.status', 'absen')
                ->findAll(),
            'pengunjung' => $this->kunjunganModel->where('MONTH(created_at)', date('m'))->countAllresults(),
            'title_meta' => view('admin/partials/title-meta', ['title' => 'Dashboard', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('admin/partials/page-title', ['title' => 'Dashboard', 'pagetitle' => $this->opsiModel->getopsi('sitename'),])
        ];
        // dd($data);
        return view('admin/dashboard', $data);
    }

    public function chart()
    {
        // if ($this->request->isAJAX()) {
        $csrfname = csrf_token();
        $csrfhash = csrf_hash();
        $keluar = array();
        $masuk = array();
        $post = $this->pengeluaranModel
            ->select('*, pengeluaran.created_at')
            ->groupBy('MONTH(pengeluaran.created_at)')
            ->selectSum('nominal')
            ->where('bukti !=', '')
            ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
            ->findAll();
        foreach ($post as $key) {
            $keluar[] = $key->nominal;
        }

        $posts = $this->pembayaranModel
            ->select('*, pembayaran.created_at')
            ->where('status', 'settlement')
            ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
            ->groupBy('MONTH(pembayaran.created_at)')
            ->selectSum('gross_amount')
            ->findAll();
        if ($posts) {
            $no = 0;
            foreach ($posts as $key) {
                $tahun[] = date("m/d/Y", strtotime($key->created_at));
                $masuk[] = $key->gross_amount;
            }
            $data = array('responce' => 'success', 'masuk' => $masuk, 'keluar' => $keluar,  'tahun' => $tahun);
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