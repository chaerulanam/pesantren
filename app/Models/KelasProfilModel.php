<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasProfilModel extends Model
{
    protected $table = 'kelas_profil';
    protected $primaryKey = 'id';
    protected $returnType = KelasProfilModel::class;
    protected $allowedFields = ['kelas_id', 'santri_id', 'tahun_ajaran'];
}