<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblFitur extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'fitur_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ikon' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addKey('fitur_id', true);
        $this->forge->createTable('tbl_fitur');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fitur');
    }
}
