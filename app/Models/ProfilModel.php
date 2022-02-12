<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = 'profil';
    protected $primaryKey = 'id';
    protected $returnType = ProfilModel::class;
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $allowedFields = ['nisn', 'kk', 'nik', 'nama_lengkap', 'tempat_lahir', 'jenjang_pendidikan', 'sekolah_asal', 'jenis_kelamin', 'tanggal_lahir', 'alamat_lengkap', 'foto', 'no_hp', 'deskripsi'];
}