<?php

namespace App\Controllers;

use App\Models\UsersProfilModel;

class Test extends BaseController
{
    public function __construct()
    {
        $this->testModel = new UsersProfilModel();
    }
    public function index()
    {
        if (!$this->testModel->adduserstoprofil(2, 3)) {
            $data = array('hello' => 'Gagal');
            return $this->response->setJSON($data);
        }
        $data = array('berhasil' => 'Berhasil');
        return $this->response->setJSON($data);
    }
}