<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kehadiran extends Migration
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
            'status'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'jadwal_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'santri_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
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
        $this->forge->addForeignKey('santri_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('jadwal_id', 'jadwal_pelajaran', 'id', '', 'CASCADE');
        $this->forge->createTable('kehadiran');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('profil', 'kehadiran_santri_id_foreign');
            $this->forge->dropForeignKey('jadwal_mapel', 'kehadiran_jadwal_id_foreign');
        } else {
            $this->forge->dropTable('kehadiran', true);
        }
    }
}