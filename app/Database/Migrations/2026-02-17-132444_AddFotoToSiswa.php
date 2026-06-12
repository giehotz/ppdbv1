<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_siswa', [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'tk'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa', 'foto');
    }
}
