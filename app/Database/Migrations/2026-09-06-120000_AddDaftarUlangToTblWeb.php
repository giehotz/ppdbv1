<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDaftarUlangToTblWeb extends Migration
{
    public function up()
    {
        $fields = [
            'daftar_ulang_aktif' => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1'],
                'default'    => '1',
                'null'       => true,
                'after'      => 'pengumuman_aktif',
            ],
            'tgl_tutup_daftar_ulang' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'daftar_ulang_aktif',
            ],
            'pesan_daftar_ulang' => [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'tgl_tutup_daftar_ulang',
            ],
        ];

        $this->forge->addColumn('tbl_web', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', ['daftar_ulang_aktif', 'tgl_tutup_daftar_ulang', 'pesan_daftar_ulang']);
    }
}
