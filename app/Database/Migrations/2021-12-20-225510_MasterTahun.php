<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterTahun extends Migration
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
            'tahun'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'semester'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'status'       => [
                'type'       => 'INT',
                'constraint' => 5,
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
        $this->forge->createTable('master_tahun', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        } else {
            $this->forge->dropTable('master_tahun', true);
        }
    }
}