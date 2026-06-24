<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToTagihanSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_tagihan_siswa', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_tagihan_siswa', 'updated_at');
    }
}
