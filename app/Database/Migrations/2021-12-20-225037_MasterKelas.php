<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kelas'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'wali_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('wali_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->createTable('master_kelas', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        } else {
            $this->forge->dropTable('master_kelas', true);
        }
    }
}