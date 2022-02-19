<?php

namespace App\Database\Seeds;

use Myth\Auth\Password;
use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email'            => 'superadmin@al-ishlahtajug.sch.id',
                'username'         => 'superadmin',
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ],
            [
                'email'            => 'bendahara@al-ishlahtajug.sch.id',
                'username'         => 'bendahara',
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ],
            [
                'email'            => 'pengajaran@al-ishlahtajug.sch.id',
                'username'         => 'pengajaran',
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ],
            [
                'email'            => 'pengasuhan@al-ishlahtajug.sch.id',
                'username'         => 'pengasuhan',
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ],
            [
                'email'            => 'guru@al-ishlahtajug.sch.id',
                'username'         => 'guru',
                'password_hash'    => Password::hash("demoajalah"),
                'active'           => 1,
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}