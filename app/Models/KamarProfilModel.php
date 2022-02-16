<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarProfilModel extends Model
{
    protected $table = 'kamar_profil';
    protected $primaryKey = 'id';
    protected $returnType = KamarProfilModel::class;
    protected $allowedFields = ['kamar_id', 'santri_id', 'tahun_ajaran'];
}