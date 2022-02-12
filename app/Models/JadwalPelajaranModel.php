<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPelajaranModel extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'id';
    protected $returnType = JadwalPelajaranModel::class;
    protected $allowedFields = ['kelas_id', 'pelajaran_id', 'jadwal_id', 'guru_id', 'tahun_ajaran'];
}