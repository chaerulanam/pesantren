<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterTagihan extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_tagihan' => 'Pendaftaran',
                'deskripsi'    => 'Biaya Awal Masuk'
            ],
            [
                'nama_tagihan' => 'Sumbangan Pembangungan',
                'deskripsi'    => 'Biaya Awal Masuk'
            ],
            [
                'nama_tagihan' => 'Meja dan Kursi',
                'deskripsi'    => 'Biaya Awal Masuk'
            ],
            [
                'nama_tagihan' => 'Januari',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Februari',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Maret',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'April',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Mei',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Juni',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Juli',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Agustus',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'September',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Oktober',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'November',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Desember',
                'deskripsi'    => 'Biaya Bulanan (Makan, Asrama, Laundry)'
            ],
            [
                'nama_tagihan' => 'Seragam Pramuka',
                'deskripsi'    => 'Biaya Pakaian Seragam'
            ],
            [
                'nama_tagihan' => 'Seragam Batik',
                'deskripsi'    => 'Biaya Pakaian Seragam'
            ],
            [
                'nama_tagihan' => 'Seragam Olahraga',
                'deskripsi'    => 'Biaya Pakaian Seragam'
            ],
            [
                'nama_tagihan' => 'Kerudung Seragam 4 Pcs',
                'deskripsi'    => 'Biaya Pakaian Seragam'
            ],
            [
                'nama_tagihan' => 'Lemari',
                'deskripsi'    => 'Biaya Kebutuhan Santri'
            ],
            [
                'nama_tagihan' => 'Kasur',
                'deskripsi'    => 'Biaya Kebutuhan Santri'
            ],
        ];
        // Using Query Builder
        $this->db->table('master_tagihan')->insertBatch($data);
    }
}