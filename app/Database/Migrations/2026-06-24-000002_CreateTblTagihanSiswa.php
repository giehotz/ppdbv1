<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblTagihanSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tagihan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'item_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'harga_satuan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'comment'    => 'harga saat tagihan dibuat',
            ],
            'dibuat_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_tagihan', true);
        $this->forge->addKey('siswa_id');
        $this->forge->addForeignKey('siswa_id', 'tbl_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('item_id', 'tbl_item_pembiayaan', 'id_item', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_tagihan_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_tagihan_siswa');
    }
}
