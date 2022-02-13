<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nilai extends Migration
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
            'nilai'       => [
                'type'       => 'FLOAT',
            ],
            'jadwal_id'       => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'semester'       => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
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
        $this->forge->addForeignKey('jadwal_id', 'jadwal_pelajaran', 'id', '', 'CASCADE');
        $this->forge->createTable('nilai');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('jadwal_pelajaran', 'nilai_jadwal_id_foreign');
        } else {
            $this->forge->dropTable('nilai', true);
        }
    }
}