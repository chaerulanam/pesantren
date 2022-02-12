<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTagihanModel extends Model
{
    protected $table = 'tagihan';
    protected $primaryKey = 'id';
    protected $returnType = DataTagihanModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['no_tagihan', 'master_tagihan_id', 'user_id', 'kelas_id', 'nominal', 'tahun_ajaran', 'status', 'deskripsi', 'invoice'];
}