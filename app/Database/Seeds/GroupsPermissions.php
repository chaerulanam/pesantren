<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsPermissions extends Seeder
{
    public function run()
    {
        $data = [
            [
                'group_id' => 1,
                'permission_id'    => 1
            ],
            [
                'group_id' => 1,
                'permission_id'    => 2
            ],
            [
                'group_id' => 1,
                'permission_id'    => 3
            ],
            [
                'group_id' => 1,
                'permission_id'    => 4
            ],
            [
                'group_id' => 1,
                'permission_id'    => 5
            ],
            [
                'group_id' => 1,
                'permission_id'    => 6
            ],
            [
                'group_id' => 1,
                'permission_id'    => 7
            ],
            [
                'group_id' => 1,
                'permission_id'    => 8
            ],
            [
                'group_id' => 1,
                'permission_id'    => 9
            ],
            [
                'group_id' => 1,
                'permission_id'    => 10
            ],
            [
                'group_id' => 1,
                'permission_id'    => 11
            ],
            [
                'group_id' => 1,
                'permission_id'    => 12
            ],
        ];

        // Using Query Builder
        $this->db->table('auth_groups_permissions')->insertBatch($data);
    }
}