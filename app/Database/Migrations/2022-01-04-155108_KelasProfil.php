<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasProfil extends Migration
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
            'kelas_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'tahun_ajaran'  => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('santri_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'master_kelas', 'id', '', 'CASCADE');
        $this->forge->createTable('kelas_profil', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('master_kelas', 'master_kelas_kelas_profil_id_foreign');
            $this->forge->dropForeignKey('profil', 'profil_kelas_profil_id_foreign');
        }
        $this->forge->dropTable('kelas_profil');
    }
}