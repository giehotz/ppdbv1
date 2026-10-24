<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTampilSuratPernyataanToTblWeb extends Migration
{
    public function up()
    {
        $fields = [
            'tampil_surat_pernyataan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
                'after'      => 'tampil_pembiayaan_siswa',
            ],
        ];

        $this->forge->addColumn('tbl_web', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'tampil_surat_pernyataan');
    }
}
