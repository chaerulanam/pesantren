<?php

namespace App\Models;

use CodeIgniter\Model;

class OpsiModel extends Model
{
    protected $table = 'opsi';
    protected $primaryKey = 'id';
    protected $returnType = OpsiModel::class;
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'isi'];


    public function getopsi($nama)
    {
        return $this->where('nama', $nama)->get()->getRow()->isi;
    }
}