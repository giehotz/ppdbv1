<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusBayarToTagihanSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_tagihan_siswa', [
            'status_bayar' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'belum',
                'null'       => false,
                'comment'    => 'belum/lunas',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_tagihan_siswa', 'status_bayar');
    }
}
