<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Groups extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'superadmin',
                'description'    => 'Tingkat pertama'
            ],
            [
                'name' => 'admin',
                'description'    => 'Tingkat kedua'
            ],
            [
                'name' => 'editor',
                'description'    => 'Tingkat ketiga'
            ],
            [
                'name' => 'author',
                'description'    => 'Tingkat keempat'
            ],
            [
                'name' => 'pengasuhan',
                'description'    => 'Tingkat kelima'
            ],
            [
                'name' => 'pengajaran',
                'description'    => 'Tingkat keenam'
            ],
            [
                'name' => 'bendahara',
                'description'    => 'Tingkat ketujuh'
            ],
            [
                'name' => 'kesehatan',
                'description'    => 'Tingkat kedelapan'
            ],
            [
                'name' => 'guru',
                'description'    => 'Tingkat kesembilan'
            ],
            [
                'name' => 'santri',
                'description'    => 'Tingkat kesepuluh'
            ],
            [
                'name' => 'alumni',
                'description'    => 'Tingkat kesebelas'
            ],
            [
                'name' => 'none',
                'description'    => 'Tingkat keduabelas'
            ]
        ];

        // Using Query Builder
        $this->db->table('auth_groups')->insertBatch($data);
    }
}