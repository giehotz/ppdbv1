<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTampilPembiayaanSiswaToTblWeb extends Migration
{
    public function up()
    {
        $fields = [
            'tampil_pembiayaan_siswa' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
            ],
        ];
        $this->forge->addColumn('tbl_web', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'tampil_pembiayaan_siswa');
    }
}
