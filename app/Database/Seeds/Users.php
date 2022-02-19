<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Password;

class Users extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 900; $i++) {
            $row = [
                'email'            => '200106' . str_pad($i, 3, '0', STR_PAD_LEFT) . '@al-ishlahtajug.sch.id',
                'username'         => '200106' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ];
            $data[] = $row;
        }
        for ($i = 900; $i < 910; $i++) {
            $row = [
                'email'            => 'teachers' . str_pad($i, 3, '0', STR_PAD_LEFT) . '@al-ishlahtajug.sch.id',
                'username'         => 'teachers' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ];
            $data[] = $row;
        }
        $this->db->table('users')->insertBatch($data);
    }
}