<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Permissions extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'dashboard.view',
                'description'    => 'View Dashboard'
            ],
            [
                'name' => 'manage.users',
                'description'    => 'Manage All Users'
            ],
            [
                'name' => 'manage.blog.post.author',
                'description'    => 'Manage blog post (add, delete)'
            ],
            [
                'name' => 'manage.blog.post.editor',
                'description'    => 'Manage blog post (add, update and delete, publish)'
            ],
            [
                'name' => 'manage.bendahara',
                'description'    => 'Manage activity of Bendahara'
            ],
            [
                'name' => 'manage.pengasuhan',
                'description'    => 'Manage activity of Pengasuhan'
            ],
            [
                'name' => 'manage.pengajaran',
                'description'    => 'Manage activity of Pengajaran'
            ],
            [
                'name' => 'manage.kesehatan',
                'description'    => 'Manage activity of Kesehatan'
            ],
            [
                'name' => 'manage.santri',
                'description'    => 'Manage activity of Santri'
            ],
            [
                'name' => 'manage.alumni',
                'description'    => 'Manage activity of Alumni'
            ],
            [
                'name' => 'manage.guru',
                'description'    => 'Manage activity of Guru'
            ],
            [
                'name' => 'manage.admin',
                'description'    => 'Manage All Admin'
            ],
        ];
        // Using Query Builder
        $this->db->table('auth_permissions')->insertBatch($data);
    }
}