<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggaran extends Migration
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
            'nama_pelanggaran' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'hukuman' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'santri_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'kelas_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'status'          => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
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
        $this->forge->addForeignKey('kelas_id', 'master_kelas', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('santri_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->createTable('pelanggaran');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('master_kelas', 'pelanggaran_kelas_id_foreign');
            $this->forge->dropForeignKey('profil', 'pelanggaran_santri_id_foreign');
        } else {
            $this->forge->dropTable('pelanggaran', true);
        }
    }
}