<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
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
            'payment_type' => [
                'type'           => 'VARCHAR',
                'constraint'     => 30,
            ],
            'order_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
            ],
            'gross_amount' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'bank' => [
                'type'           => 'VARCHAR',
                'constraint'     => 30,
                'null'           => true,
            ],
            'va_number' => [
                'type'           => 'VARCHAR',
                'constraint'     => 30,
                'null'           => true,
            ],
            'pdf_link' => [
                'type'           => 'TEXT',
            ],
            'status' => [
                'type'           => 'VARCHAR',
                'constraint'     => 15,
            ],
            'tahun_ajaran'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
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
        $this->forge->createTable('pembayaran', true);
    }

    public function down()
    {
        if ($this->db->DBDriver != 'SQLite3') // @phpstan-ignore-line
        {
        }
        $this->forge->dropTable('pembayaran', true);
    }
}