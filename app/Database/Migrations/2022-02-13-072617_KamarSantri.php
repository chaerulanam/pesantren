<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KamarSantri extends Migration
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
            'santri_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'kamar_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'tahun_ajaran'  => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('santri_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('kamar_id', 'master_kamar', 'id', '', 'CASCADE');
        $this->forge->createTable('kamar_profil', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('master_kamar', 'master_kamar_kamar_santri_id_foreign');
            $this->forge->dropForeignKey('profil', 'master_kamar_santri_id_foreign');
        }
        $this->forge->dropTable('kamar_profil');
    }
}