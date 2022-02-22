<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Profil extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 900; $i++) {
            if ($i % 2 == 0) {
                $gender = "Laki-laki";
                $g = "male";
                $jenjang = "SMP";
            } else {
                $gender = "Perempuan";
                $g = "female";
                $jenjang = "SMA";
            }
            $row = [
                'nama_lengkap' => $faker->name($g),
                'nisn' => $faker->ean8,
                'nik' => $faker->nik,
                'kk' => $faker->nik,
                'sekolah_asal' => 'SD ' . $faker->city . ' ' . random_int(1, 5),
                'jenis_kelamin' => $gender,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', 'now'),
                'jenjang_pendidikan' => $jenjang,
                'no_hp' => $faker->e164PhoneNumber,
                'alamat_lengkap' => $faker->address,
                'deskripsi' => $faker->realText,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $data[] = $row;
        }

        for ($i = 900; $i < 910; $i++) {
            if ($i % 2 == 0) {
                $gender = "Laki-laki";
                $g = "male";
                $jenjang = "S1";
            } else {
                $gender = "Perempuan";
                $g = "female";
                $jenjang = "S2";
            }
            $row = [
                'nama_lengkap' => $faker->name($g),
                'nisn' => $faker->ean8,
                'nik' => $faker->nik,
                'kk' => $faker->nik,
                'sekolah_asal' => 'Universitas Negeri ' . $faker->city,
                'jenis_kelamin' => $gender,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', 'now'),
                'jenjang_pendidikan' => $jenjang,
                'no_hp' => $faker->e164PhoneNumber,
                'alamat_lengkap' => $faker->address,
                'deskripsi' => $faker->realText,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $data[] = $row;
        }
        $this->db->table('profil')->insertBatch($data);

        for ($i = 0; $i < 900; $i++) {
            if ($i % 2 == 0) {
                $jenjang = "S2";
            } else {
                $jenjang = "D3";
            }
            $row = [
                'nama_ayah' => $faker->name('male'),
                'pendidikan_ayah' => $jenjang,
                'penghasilan_ayah' => "diatas 5 juta",
                'pekerjaan_ayah' => "PNS",
                'nama_ibu' => $faker->name('female'),
                'pendidikan_ibu' => $jenjang,
                'penghasilan_ibu' => "dibawah 1 juta",
                'pekerjaan_ibu' => "Pedagang",
                'profil_id' => $i + 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $data1[] = $row;
        }

        for ($i = 900; $i < 910; $i++) {
            if ($i % 2 == 0) {
                $jenjang = "S1";
            } else {
                $jenjang = "D3";
            }
            $row = [
                'nama_ayah' => $faker->name('male'),
                'pendidikan_ayah' => $jenjang,
                'penghasilan_ayah' => "diatas 5 juta",
                'pekerjaan_ayah' => "PNS",
                'nama_ibu' => $faker->name('female'),
                'pendidikan_ibu' => $jenjang,
                'penghasilan_ibu' => "dibawah 1 juta",
                'pekerjaan_ibu' => "Pedagang",
                'profil_id' => $i + 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $data1[] = $row;
        }
        $this->db->table('orangtua')->insertBatch($data1);

        for ($i = 0; $i < 910; $i++) {
            $row = [
                'nama_wali' => $faker->name('male'),
                'hubungan_sosial' => "Kakek",
                'penghasilan_wali' => "diatas 5 juta",
                'pekerjaan_wali' => "PNS",
                'profil_id' => $i + 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $data2[] = $row;
        }

        $this->db->table('wali')->insertBatch($data2);
    }
}