<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastLoginToSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('tbl_siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa', 'last_login');
    }
}
