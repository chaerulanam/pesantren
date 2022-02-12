<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterJadwal extends Seeder
{
    public function run()
    {
        $data = [
            [
                'jam' => '07:00',
                'hari'    => 0
            ],
            [
                'jam' => '08:00',
                'hari'    => 0
            ],
            [
                'jam' => '09:00',
                'hari'    => 0
            ],
            [
                'jam' => '07:00',
                'hari'    => 1
            ],
        ];
        // Using Query Builder
        $this->db->table('master_jadwal')->insertBatch($data);
    }
}