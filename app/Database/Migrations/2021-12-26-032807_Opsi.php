<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Opsi extends Migration
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
            'nama'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'isi'       => [
                'type'       => 'longtext',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('opsi', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        } else {
            $this->forge->dropTable('opsi');
        }
    }
}