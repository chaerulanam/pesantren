<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profil extends Migration
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
            'nisn'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nik'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'kk'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'sekolah_asal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jenjang_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'alamat_lengkap' => [
                'type' => 'TEXT',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('profil', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }
        $this->forge->dropTable('profil', true);
    }
}