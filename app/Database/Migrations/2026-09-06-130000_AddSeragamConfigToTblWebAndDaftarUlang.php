<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSeragamConfigToTblWebAndDaftarUlang extends Migration
{
    public function up()
    {
        // 1. Add seragam_aktif & seragam_fields to tbl_web
        $webFields = [
            'seragam_aktif' => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1'],
                'default'    => '1',
                'null'       => true,
                'after'      => 'pesan_daftar_ulang',
            ],
            'seragam_fields' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'seragam_aktif',
            ],
        ];
        $this->forge->addColumn('tbl_web', $webFields);

        // 2. Add data_seragam to tbl_daftar_ulang for dynamic student uniform data
        $daftarUlangFields = [
            'data_seragam' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'catatan',
            ],
        ];
        $this->forge->addColumn('tbl_daftar_ulang', $daftarUlangFields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', ['seragam_aktif', 'seragam_fields']);
        $this->forge->dropColumn('tbl_daftar_ulang', ['data_seragam']);
    }
}
