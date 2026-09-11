<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblVerifikasiPindahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_verifikasi_pindahan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pindahan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ket' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tgl_verifikasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'verifikator' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_verifikasi_pindahan', true);
        $this->forge->addKey('id_pindahan');
        $this->forge->addForeignKey('id_pindahan', 'tbl_siswa_pindahan', 'id_pindahan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_verifikasi_pindahan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_verifikasi_pindahan');
    }
}