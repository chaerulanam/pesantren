<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterTagihanModel extends Model
{
    protected $table = 'master_tagihan';
    protected $primaryKey = 'id';
    protected $returnType = MasterTagihanModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_tagihan', 'deskripsi'];
}