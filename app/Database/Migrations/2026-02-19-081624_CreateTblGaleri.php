<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblGaleri extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'galeri_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->addKey('galeri_id', true);
        $this->forge->createTable('tbl_galeri');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_galeri');
    }
}
