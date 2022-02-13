<?php

namespace App\Models;

use CodeIgniter\Model;

class PerizinanModel extends Model
{
    protected $table = 'perizinan';
    protected $primaryKey = 'id';
    protected $returnType = PerizinanModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['santri_id', 'kelas_id', 'keperluan', 'status', 'tahun_ajaran'];
}