<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblItemPembiayaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_item' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'comment'    => 'L/P/null=semua',
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'aktif' => [
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
        $this->forge->addKey('id_item', true);
        $this->forge->createTable('tbl_item_pembiayaan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_item_pembiayaan');
    }
}
