<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterKamar extends Migration
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
            'nama_gedung'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'nama_kamar'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'jenis_kelamin'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'wali_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('wali_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->createTable('master_kamar');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        } else {
            $this->forge->dropTable('master_kamar', true);
        }
    }
}