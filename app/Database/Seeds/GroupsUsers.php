<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Password;

class GroupsUsers extends Seeder
{
    public function run()
    {
        $data = [
            [
                'group_id' => 1,
                'user_id'    => 1
            ],
            [
                'group_id' => 7,
                'user_id'    => 2
            ],
            [
                'group_id' => 6,
                'user_id'    => 3
            ],
            [
                'group_id' => 5,
                'user_id'    => 4
            ],
            [
                'group_id' => 9,
                'user_id'    => 5
            ],
        ];

        // for ($i = 6; $i < 906; $i++) {
        //     $row = [
        //         'group_id' => 10,
        //         'user_id'    => $i
        //     ];
        //     $data[] = $row;
        // }
        // for ($i = 906; $i < 916; $i++) {
        //     $row = [
        //         'group_id' => 9,
        //         'user_id'    => $i
        //     ];
        //     $data[] = $row;
        // }

        // Using Query Builder
        $this->db->table('auth_groups_users')->insertBatch($data);
    }
}