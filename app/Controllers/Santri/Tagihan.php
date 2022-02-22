<?php

namespace App\Controllers\Santri;

use App\Controllers\BaseController;
use App\Models\DataTagihanModel;
use App\Models\PembayaranModel;
use CodeIgniter\API\ResponseTrait;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class Tagihan extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->tagihanModel = new DataTagihanModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->midtransConfig = new Config;
        $this->midtransSnap = new Snap;
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
            'users' => $this->userModel
                ->select('users.id as userid, username, name')
                ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                ->join('users_profil', 'users_profil.user_id = users.id', 'LEFT')
                ->where('name', 'santri')
                ->where('users_profil.user_id', null)
                ->findAll(),
            'tahun' => $this->tahunModel->TahunAktif(),
            'title_table' => 'Data Tagihan Santri',
            'title_meta' => view('santri/partials/title-meta', ['title' => 'Tagihan', 'sitename' => $this->opsiModel->getopsi('sitename'),]),
            'page_title' => view('santri/partials/page-title', ['title' => 'Tagihan', 'pagetitle' => $this->opsiModel->getopsi('sitename'),]),
            'clientKey' => $this->midtransConfig::$clientKey,
            'baseurl' => $this->midtransConfig->getSnapBaseUrl(),
        ];
        // dd($data);
        return view('santri/tagihan', $data);
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $tahun = $this->request->getGet('tahun');

            $posts = $this->tagihanModel
                ->select('*, tagihan.id as tagihanid, tagihan.status as status')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->where('tagihan.user_id', user_id())
                ->where('tahun_ajaran', $this->tahunModel->TahunAktif())
                ->findAll();

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    if ($key->invoice == "") {
                        $row[] = '<input type="checkbox" class="form-check-input check' . $no . '" id="check" data-no="' . $no . '" data-id="' . $key->tagihanid . '">';
                    } else {
                        $row[] = '';
                    }
                    $row[] = $key->nama_lengkap . " | " . $key->kelas;
                    $row[] = $key->no_tagihan;
                    $row[] = number_to_currency($key->nominal, 'IDR', null);
                    $row[] = $key->nama_tagihan;
                    if ($key->status == 1) {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">Belum Lunas</span></div>';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-success text-white">Sudah Lunas</span></div>';
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

    public function invoice()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $id = $this->request->getPost('id');
            $total = 0;
            for ($i = 0; $i < count($id); $i++) {
                if ($id[$i] > 0) {
                    $posts = $this->tagihanModel
                        ->select('*, profil.id as profilid, tagihan.id as tagihanid, master_tagihan.deskripsi as desc')
                        ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                        ->join('users', 'tagihan.user_id = users.id')
                        ->join('users_profil', 'users_profil.user_id = users.id')
                        ->join('profil', 'users_profil.profil_id = profil.id')
                        ->where('tagihan.id', $id[$i])
                        ->get()->getRow();
                    $row = array();
                    $row[] = $i + 1;
                    $row[] = $posts->nama_tagihan;
                    $row[] = $posts->desc;
                    $row[] = number_to_currency($posts->nominal, 'IDR', null);
                    $data[] = $row;
                    $total += $posts->nominal;
                }
            }

            $profil = [
                'profilid' => $posts->profilid,
                'nama_lengkap' => $posts->nama_lengkap,
                'alamat' => $posts->alamat_lengkap,
                'no_hp' => $posts->no_hp,
            ];
            $data = array('responce' => 'success', 'profil' => $profil, 'posts' => $data, 'total' => number_to_currency($total, 'IDR', null));
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function datatable_pembayaran()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $tahun = $this->request->getGet('tahun');

            $posts = $this->tagihanModel
                ->select('*, tagihan.deskripsi as desc, tagihan.updated_at')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('pembayaran', 'tagihan.invoice = pembayaran.order_id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->where('tagihan.useri_id', user_id())
                ->where('pembayaran.tahun_ajaran', $this->tahunModel->TahunAktif())
                ->findAll();

            if ($posts) {
                $no = 0;
                foreach ($posts as $key) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $key->order_id;
                    $row[] = number_to_currency($key->gross_amount, 'IDR', null);
                    $row[] = $key->payment_type;
                    $row[] = $key->tahun_ajaran;
                    if ($key->status == "") {
                        $row[] = '<a href="javascript:void(0);" class="btn btn-outline-info uil-money-insert" id="button-bayar" data-id="' . $key->order_id . '"> Bayar </a>';
                    } else  if ($key->status == "pending") {
                        $row[] = '<a href="' . $key->pdf_link . '" target="_blank" class="btn btn-outline-info uil-file-download-alt"> Download Petunjuk </a>';
                    } else  if ($key->status == "settlement") {
                        $row[] = '<a href="invoice?id=' . $key->order_id . '" class="btn btn-outline-info uil-file-download-alt"> Download Invoice </a>';
                    } else {
                        $row[] = '<div class="btn-group d-flex justify-content-center"><span class="badge bg-danger text-white">' . $key->status . '</span></div>';
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

    public function pay()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            $invoice = $this->request->getPost('id');

            $post = $this->tagihanModel
                ->select('*, tagihan.id as tagihanid')
                ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                ->join('users', 'tagihan.user_id = users.id')
                ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                ->join('users_profil', 'users_profil.user_id = users.id')
                ->join('profil', 'users_profil.profil_id = profil.id')
                ->where('invoice', $invoice)
                ->findAll();
            $i = 0;
            $nominal = 0;
            foreach ($post as $key) {
                $i++;
                $row = [
                    'id' => 'a' . $i,
                    'price' => $key->nominal,
                    'quantity' => 1,
                    'name' => $key->nama_tagihan,
                ];

                $nominal += $key->nominal;

                $item_details[] = $row;
            }

            $transaction_details = array(
                'order_id' => $invoice,
                "gross_amount" => $nominal,
            );

            // Optional
            $customer_details = array(
                'first_name'     => user()->username,
                'email'         => user()->email,
            );

            $billing_address = array(
                'first_name'    => "Al-Ishlah",
                'last_name'     => "Tajug",
                'address'       => "Jl Raya Sudimampir, Balongan",
                'city'          => "Indramayu",
                'postal_code'   => "45285",
                'phone'         => "(0234) 353074",
                'country_code'  => 'IDN'
            );

            $shipping_address = array(
                'first_name'    => $key->nama_lengkap,
                // 'last_name'     => "Supriadi",
                'address'       => $key->alamat_lengkap,
                // 'city'          => "Jakarta",
                // 'postal_code'   => "16601",
                'phone'         => $key->no_hp,
                'country_code'  => 'IDN'
            );

            // Optional
            $customer_details = array(
                'first_name'    => $key->nama_lengkap,
                // 'last_name'     => "Litani",
                'email'         => user()->email,
                'phone'         => $key->no_hp,
                'billing_address'  => $billing_address,
                'shipping_address' => $shipping_address
            );
            $transaction = array(
                // 'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $item_details,
            );

            try {
                $snap_token = $this->midtransSnap->getSnapToken($transaction);
                $data = array('success' => 'Successfully add to data class.', 'snap_token' => $snap_token);
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            } catch (\Exception $e) {
                // echo $e->getMessage();
                $data = array('success' => 'Successfully add to data class.', 'snap_token' => $e->getMessage());
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();

            $id = $this->request->getPost('id');
            $invoice = $this->request->getPost('invoice');
            $nominal = 0;
            for ($i = 0; $i < count($id); $i++) {
                if ($id[$i] != null) {
                    $data = [
                        'id' => $id[$i],
                        'invoice' => $invoice,
                    ];

                    if (!$this->tagihanModel->save($data)) {
                        $data = array('error' => 'Gagal menambah invoice tagihan.');
                    }

                    $post = $this->tagihanModel
                        ->select('*, tagihan.id as tagihanid')
                        ->join('master_tagihan', 'tagihan.master_tagihan_id = master_tagihan.id')
                        ->join('users', 'tagihan.user_id = users.id')
                        ->join('master_kelas', 'tagihan.kelas_id = master_kelas.id')
                        ->join('users_profil', 'users_profil.user_id = users.id')
                        ->join('profil', 'users_profil.profil_id = profil.id')
                        ->find($id[$i]);

                    $nominal += $post->nominal;

                    $row = [
                        'id' => 'a' . $i,
                        'price' => $post->nominal,
                        'quantity' => 1,
                        'name' => $post->nama_tagihan,
                    ];

                    $item_details[] = $row;
                }
            }



            $transaction_details = array(
                'order_id' => $invoice,
                "gross_amount" => $nominal,
            );

            // Optional
            $customer_details = array(
                'first_name'     => user()->username,
                'email'         => user()->email,
            );

            $billing_address = array(
                'first_name'    => "Al-Ishlah",
                'last_name'     => "Tajug",
                'address'       => "Jl Raya Sudimampir, Balongan",
                'city'          => "Indramayu",
                'postal_code'   => "45285",
                'phone'         => "(0234) 353074",
                'country_code'  => 'IDN'
            );

            $shipping_address = array(
                'first_name'    => $post->nama_lengkap,
                // 'last_name'     => "Supriadi",
                'address'       => $post->alamat_lengkap,
                // 'city'          => "Jakarta",
                // 'postal_code'   => "16601",
                'phone'         => $post->no_hp,
                'country_code'  => 'IDN'
            );

            // Optional
            $customer_details = array(
                'first_name'    => $post->nama_lengkap,
                // 'last_name'     => "Litani",
                'email'         => user()->email,
                'phone'         => $post->no_hp,
                'billing_address'  => $billing_address,
                'shipping_address' => $shipping_address
            );
            $transaction = array(
                // 'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $item_details,
            );

            $data = [
                'order_id' => $invoice,
                'gross_amount' => $nominal,
                'tahun_ajaran' => $this->tahunModel->TahunAktif(),
            ];

            if (!$this->pembayaranModel->save($data)) {
                $data = array('error' => 'Gagal menambah pembayaran.');
            }

            // $this->logModel->save($data);

            try {
                $snap_token = $this->midtransSnap->getSnapToken($transaction);
                $data = array('success' => 'Berhasil menambahkan invoice.', 'snap_token' => $snap_token);
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            } catch (\Exception $e) {
                // echo $e->getMessage();
                $data = array('success' => 'Gagal menambahkan invoice.', 'snap_token' => $e->getMessage());
                $data[$csrfname] = $csrfhash;
                return $this->response->setJSON($data);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function proses()
    {
        if ($this->request->isAJAX()) {
            $csrfname = csrf_token();
            $csrfhash = csrf_hash();
            if ($this->pembayaranModel->where('order_id', $this->request->getPost('order_id'))->countAllResults() > 0) {
                $post = $this->pembayaranModel->where('order_id', $this->request->getPost('order_id'))->get()->getRow();
                if ($post->status == "settlement") {
                    $data = array('success' => 'Berhasil menginput data pembayaran');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                } else {
                    $data = [
                        'id' => $post->id,
                        'payment_type' => $this->request->getPost('payment_type'),
                        'gross_amount' => (int)$this->request->getPost('gross_amount'),
                        'pdf_link' => $this->request->getPost('pdf_link'),
                        'status' => $this->request->getPost('status'),
                        'bank' => $this->request->getPost('bank'),
                        'va_number' => $this->request->getPost('va_number'),
                    ];

                    $this->pembayaranModel->save($data);

                    $data = array('success' => 'Berhasil mengupdate data pembayaran');
                    $data[$csrfname] = $csrfhash;
                    return $this->response->setJSON($data);
                }
            }
            $data = [
                'user_id' => user_id(),
                'order_id' => $this->request->getPost('order_id'),
                'payment_type' => $this->request->getPost('payment_type'),
                'gross_amount' => (int)$this->request->getPost('gross_amount'),
                'pdf_link' => $this->request->getPost('pdf_link'),
                'status' => $this->request->getPost('status'),
                'bank' => $this->request->getPost('bank'),
                'va_number' => $this->request->getPost('va_number'),
            ];

            $this->pembayaranModel->save($data);

            $data = array('success' => 'Berhasil menginput data pembayaran');
            $data[$csrfname] = $csrfhash;
            return $this->response->setJSON($data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function notifikasi()
    {
        $this->notifocation =  new Notification();
        try {
            $notif = $this->notifocation;
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $notif = $notif->getResponse();
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;
        $status_code = $notif->status_code;
        $gross_amount = $notif->gross_amount;
        // $signature_key = $notif;
        $bank = $notif->va_numbers[0]->bank;
        $va_number = $notif->va_numbers[0]->va_number;
        // $verifikasi_key = hash('sha512', $order_id . $status_code . $gross_amount . $this->midtransConfig::$serverKey);
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            if ($this->pembayaranModel->where('order_id', $order_id)->countAllResults() > 0) {
                $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();
                $data = [
                    'id' => $post->id,
                    'status' => $transaction,
                ];
            } else {
                $data = [
                    'user_id' => substr($order_id, 13, 4),
                    'order_id' => $order_id,
                    'payment_type' => $type,
                    'gross_amount' => (int)$gross_amount,
                    'pdf_link' => '',
                    'status' => $transaction,
                    'bank' => $bank,
                    'va_number' => $va_number,
                ];
            }

            if ($post = $this->pembayaranModel->save($data)) {
                $data = [
                    "error" => "false",
                    "status_code" => 201,
                    'message' => "Berhasil Mengupdate Data",
                ];
            } else {
                $data = [
                    "error" => "true",
                    "status_code" => 501,
                    'message' => "Gagal Mengupdate Data",
                ];
            }

            $post = $this->tagihanModel->where('invoice', $order_id)->findAll();

            foreach ($post as $key) {
                $data = [
                    'id' => $key->id,
                    'status' => 0,
                ];

                if (!$this->tagihanModel->save($data)) {
                    $data = array('error' => 'Gagal mengubah status tagihan.');
                }
            }

            // $this->sendMessage("Pembayaran PMB \nNomor Tagihan: " . $order_id . "\nStatus: " . $transaction . "\n" . base_url());

            return $this->respond($data);
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            if ($this->pembayaranModel->where('order_id', $order_id)->countAllResults() > 0) {
                $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();
                $data = [
                    'id' => $post->id,
                    'status' => $transaction,
                ];
            } else {
                $data = [
                    'user_id' => substr($order_id, 13, 4),
                    'order_id' => $order_id,
                    'payment_type' => $type,
                    'gross_amount' => (int)$gross_amount,
                    'pdf_link' => '',
                    'status' => $transaction,
                    'bank' => $bank,
                    'va_number' => $va_number,
                ];
            }

            if ($post = $this->pembayaranModel->save($data)) {
                $data = [
                    "error" => "false",
                    "status_code" => 201,
                    'message' => "Berhasil Mengupdate Data",
                ];
            } else {
                $data = [
                    "error" => "true",
                    "status_code" => 501,
                    'message' => "Gagal Mengupdate Data",
                ];
            }
            // $this->sendMessage("Pembayaran PMB \nNomor Tagihan: " . $order_id . "\nStatus: " . $transaction . "\n" . base_url());
            return $this->respond($data);
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } else if ($transaction == 'expire') {

            // if ($signature_key == $verifikasi_key) {
            $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();
            $id = $post->id;
            // } else {
            //     $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();

            //     $data = [
            //         'id' => $post->id,
            //         'status' => 'Anda Mencoba Melakukan Pelanggaran Hukum !!',
            //     ];
            // }

            if ($post = $this->pembayaranModel->delete($id)) {
                $data = [
                    "error" => "false",
                    "status_code" => 201,
                    'message' => "Berhasil Menghapus Data",
                ];
            } else {
                $data = [
                    "error" => "true",
                    "status_code" => 501,
                    'message' => "Gagal Menghapus Data",
                ];
            }

            $post = $this->tagihanModel->where('invoice', $order_id)->findAll();

            foreach ($post as $key) {
                $data = [
                    'id' => $key->id,
                    'invoice' => '',
                ];

                if (!$this->tagihanModel->save($data)) {
                    $data = array('error' => 'Gagal mengubah status tagihan.');
                }
            }

            // $this->sendMessage("Pembayaran PMB \nNomor Tagihan: " . $order_id . "\nStatus: " . $transaction . "\n" . base_url());

            return $this->respond($data);
        } else if ($transaction == 'cancel') {
            // if ($signature_key == $verifikasi_key) {
            $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();
            $id = $post->id;
            // } else {
            //     $post = $this->pembayaranModel->where('order_id', $order_id)->get()->getRow();

            //     $data = [
            //         'id' => $post->id,
            //         'status' => 'Anda Mencoba Melakukan Pelanggaran Hukum !!',
            //     ];
            // }

            if ($post = $this->pembayaranModel->delete($id)) {
                $data = [
                    "error" => "false",
                    "status_code" => 201,
                    'message' => "Berhasil Menghapus Data",
                ];
            } else {
                $data = [
                    "error" => "true",
                    "status_code" => 501,
                    'message' => "Gagal Menghapus Data",
                ];
            }

            $post = $this->tagihanModel->where('invoice', $order_id)->findAll();

            foreach ($post as $key) {
                $data = [
                    'id' => $key->id,
                    'invoice' => '',
                ];

                if (!$this->tagihanModel->save($data)) {
                    $data = array('error' => 'Gagal mengubah status tagihan.');
                }
            }

            // $this->sendMessage("Pembayaran PMB \nNomor Tagihan: " . $order_id . " \nStatus: " . $transaction . "\n" . base_url());

            return $this->respond($data);
        }
    }
}