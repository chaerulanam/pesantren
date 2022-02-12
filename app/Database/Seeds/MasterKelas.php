<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterKelas extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kelas' => '1',
                'deskripsi'    => 'SD'
            ],
            [
                'kelas' => '2',
                'deskripsi'    => 'SD'
            ],
            [
                'kelas' => '3',
                'deskripsi'    => 'SD'
            ],
            [
                'kelas' => '4',
                'deskripsi'    => 'SD'
            ],
            [
                'kelas' => '5',
                'deskripsi'    => 'SD'
            ],

            [
                'kelas' => '6',
                'deskripsi'    => 'SD'
            ],

            [
                'kelas' => '1A',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '1B',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '1C',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '1D',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '1E',
                'deskripsi'    => 'SMP'
            ],

            [
                'kelas' => '2A',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '2B',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '2C',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '2D',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '2E',
                'deskripsi'    => 'SMP'
            ],

            [
                'kelas' => '3A',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3B',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3C',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3D',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3E',
                'deskripsi'    => 'SMP'
            ],

            [
                'kelas' => '3A',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3B',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3C',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3D',
                'deskripsi'    => 'SMP'
            ],
            [
                'kelas' => '3E',
                'deskripsi'    => 'SMP'
            ],

            [
                'kelas' => 'I\'Dady',
                'deskripsi'    => 'SMP'
            ],

            [
                'kelas' => '4A',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '4B',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '4C',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '4D',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '4E',
                'deskripsi'    => 'SMA'
            ],

            [
                'kelas' => '5A',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '5B',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '5C',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '5D',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '5E',
                'deskripsi'    => 'SMA'
            ],

            [
                'kelas' => '6A',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '6B',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '6C',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '6D',
                'deskripsi'    => 'SMA'
            ],
            [
                'kelas' => '6E',
                'deskripsi'    => 'SMA'
            ],
        ];
        // Using Query Builder
        $this->db->table('master_kelas')->insertBatch($data);
    }
}