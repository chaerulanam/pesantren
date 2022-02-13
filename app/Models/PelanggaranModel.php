<?php

namespace App\Models;

use CodeIgniter\Model;

class PelanggaranModel extends Model
{
    protected $table = 'pelanggaran';
    protected $primaryKey = 'id';
    protected $returnType = PelanggaranModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['santri_id', 'kelas_id', 'nama_pelanggaran', 'hukuman', 'status', 'tahun_ajaran'];
}