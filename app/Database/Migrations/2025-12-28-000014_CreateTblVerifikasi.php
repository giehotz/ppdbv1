<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblVerifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_verifikasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ket' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_verifikasi' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id_verifikasi', true);
        $this->forge->createTable('tbl_verifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_verifikasi');
    }
}
