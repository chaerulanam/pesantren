<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterPelajaran extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pelajaran' => 'Bahasa Indonesia',
                'deskripsi'    => 'Umum'
            ],
            [
                'nama_pelajaran' => 'Bahasa Arab',
                'deskripsi'    => 'Pondok'
            ],
            [
                'nama_pelajaran' => 'Bahasa Inggris',
                'deskripsi'    => 'Umum'
            ],
            [
                'nama_pelajaran' => 'Hadits',
                'deskripsi'    => 'Pondok'
            ],
        ];
        // Using Query Builder
        $this->db->table('master_pelajaran')->insertBatch($data);
    }
}