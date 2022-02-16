<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterKamarModel extends Model
{
    protected $table = 'master_kamar';
    protected $primaryKey = 'id';
    protected $returnType = MasterKamarModel::class;
    protected $allowedFields = ['nama_kamar', 'nama_gedung', 'jenis_kelamin', 'wali_id'];
}