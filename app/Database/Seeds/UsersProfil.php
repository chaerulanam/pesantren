<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersProfil extends Seeder
{
    public function run()
    {
        for ($i = 6; $i < 916; $i++) {
            $row = [
                'user_id' => $i,
                'profil_id' => $i - 5,
            ];
            $data[] = $row;
        }

        // for ($i = 906; $i < 917; $i++) {
        //     $row = [
        //         'user_id' => $i,
        //         'profil_id' => $i - 6,
        //     ];
        //     $data[] = $row;
        // }

        $this->db->table('users_profil')->insertBatch($data);
    }
}