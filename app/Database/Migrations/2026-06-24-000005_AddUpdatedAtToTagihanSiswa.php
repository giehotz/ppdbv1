<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToTagihanSiswa extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('updated_at', 'tbl_tagihan_siswa')) {
            $this->forge->addColumn('tbl_tagihan_siswa', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_tagihan_siswa', 'updated_at');
    }
}
