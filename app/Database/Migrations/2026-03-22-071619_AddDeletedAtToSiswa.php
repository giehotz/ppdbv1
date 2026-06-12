<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToSiswa extends Migration
{
    public function up()
    {
        $fields = [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ];
        $this->forge->addColumn('tbl_siswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa', 'deleted_at');
    }
}
