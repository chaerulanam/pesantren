<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wali extends Migration
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
            'nama_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'hubungan_sosial' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'pekerjaan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'penghasilan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'hp_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'profil_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('profil_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addUniqueKey('profil_id');
        $this->forge->createTable('wali');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('profil', 'orangtua_profil_id_foreign');
        } else {
            $this->forge->dropTable('wali', true);
        }
    }
}