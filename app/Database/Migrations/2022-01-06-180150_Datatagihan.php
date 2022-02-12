<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Datatagihan extends Migration
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
            'no_tagihan'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'master_tagihan_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'kelas_id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'nominal'          => [
                'type'           => 'INT',
                'constraint'     => 15,
            ],
            'tahun_ajaran'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'status'          => [
                'type'           => 'INT',
                'constraint'     => 5,
            ],
            'deskripsi'          => [
                'type'           => 'TEXT',
            ],
            'invoice'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
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
        $this->forge->addForeignKey('master_tagihan_id', 'master_tagihan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'master_kelas', 'id', '', 'CASCADE');
        $this->forge->createTable('tagihan');
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
            $this->forge->dropForeignKey('master_tagihan', 'tagihan_master_tagihan_id_foreign');
            $this->forge->dropForeignKey('user', 'data_tagihan_user_id_foreign');
            $this->forge->dropForeignKey('master_kelas', 'data_tagihan_master_kelas_id_foreign');
        } else {
            $this->forge->dropTable('tagihan', true);
        }
    }
}