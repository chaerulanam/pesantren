<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalPelajaran extends Migration
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
            'pelajaran_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'kelas_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'jadwal_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'guru_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'tahun_ajaran'  => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('guru_id', 'profil', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'master_kelas', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('jadwal_id', 'master_jadwal', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('pelajaran_id', 'master_pelajaran', 'id', '', 'CASCADE');
        $this->forge->createTable('jadwal_pelajaran', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('master_kelas', 'master_kelas_kelas_profil_id_foreign');
            $this->forge->dropForeignKey('profil', 'profil_kelas_profil_id_foreign');
        }
        $this->forge->dropTable('jadwal_pelajaran', true);
    }
}