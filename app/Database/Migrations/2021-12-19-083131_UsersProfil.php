<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersProfil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'profil_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);

        $this->forge->addKey(['profil_id', 'user_id']);
        $this->forge->addForeignKey('profil_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('users_profil');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('users_profil', 'users_profil_id_foreign');
        }
        $this->forge->dropTable('users_profil', true);
    }
}