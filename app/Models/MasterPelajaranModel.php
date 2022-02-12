<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPelajaranModel extends Model
{
    protected $table = 'master_pelajaran';
    protected $primaryKey = 'id';
    protected $returnType = MasterPelajaranModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_pelajaran', 'deskripsi'];
}