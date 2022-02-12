<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterKelasModel extends Model
{
    protected $table = 'master_kelas';
    protected $primaryKey = 'id';
    protected $returnType = MasterKelasModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['kelas', 'deskripsi', 'wali_id'];
}