<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJadwalModel extends Model
{
    protected $table = 'master_jadwal';
    protected $primaryKey = 'id';
    protected $returnType = MasterJadwalModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['jam', 'hari'];
}