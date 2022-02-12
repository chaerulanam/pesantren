<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterTahun extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tahun' => '2022/2023',
                'semester'    => 'Ganjil',
                'status' => 1
            ], [
                'tahun' => '2022/2023',
                'semester'    => 'Genap',
                'status' => 0
            ],
            [
                'tahun' => '2023/2024',
                'semester'    => 'Ganjil',
                'status' => 0
            ], [
                'tahun' => '2023/2024',
                'semester'    => 'Genap',
                'status' => 0
            ],
            [
                'tahun' => '2024/2025',
                'semester'    => 'Ganjil',
                'status' => 0
            ], [
                'tahun' => '2024/2025',
                'semester'    => 'Genap',
                'status' => 0
            ],
            [
                'tahun' => '2025/2026',
                'semester'    => 'Ganjil',
                'status' => 0
            ], [
                'tahun' => '2025/2026',
                'semester'    => 'Genap',
                'status' => 0
            ],
        ];
        // Using Query Builder
        $this->db->table('master_tahun')->insertBatch($data);
    }
}