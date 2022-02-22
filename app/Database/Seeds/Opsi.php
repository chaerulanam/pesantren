<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Opsi extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'sitename',
                'isi'    => 'Al-Ishlah Tajug',
            ], [
                'nama' => 'sitedesc',
                'isi'    => 'Aplikasi pengolahan data pesantren',
            ], [
                'nama' => 'sitelogo',
                'isi'    => 'default.png',
            ], [
                'nama' => 'siteicon',
                'isi'    => 'favicon.ico',
            ],
        ];
        // Using Query Builder
        $this->db->table('opsi')->insertBatch($data);
    }
}