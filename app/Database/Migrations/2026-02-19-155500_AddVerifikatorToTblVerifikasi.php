<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerifikatorToTblVerifikasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_verifikasi', [
            'verifikator' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'tgl_verifikasi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_verifikasi', 'verifikator');
    }
}
