<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterTahunModel extends Model
{
    protected $table = 'master_tahun';
    protected $primaryKey = 'id';
    protected $returnType = MasterTahunModel::class;
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $allowedFields = ['tahun', 'semester', 'status'];

    function TahunAktif()
    {
        return $this
            ->where('status', 1)
            ->get()->getRow()->tahun;
    }
}