<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangtuaModel extends Model
{
    protected $table = 'orangtua';
    protected $primaryKey = 'id';
    protected $returnType = OrangtuaModel::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'hp_ayah', 'nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'hp_ibu', 'profil_id'];
}