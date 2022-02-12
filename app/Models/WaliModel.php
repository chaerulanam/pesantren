<?php

namespace App\Models;

use CodeIgniter\Model;

class WaliModel extends Model
{
    protected $table = 'wali';
    protected $primaryKey = 'id';
    protected $returnType = WaliModel::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_wali', 'hubungan_sosial', 'pekerjaan_wali', 'penghasilan_wali', 'hp_wali', 'profil_id'];
}