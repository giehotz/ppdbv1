<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusLulusToTblSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_siswa', [
            'status_lulus' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => 'Pending'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa', 'status_lulus');
    }
}
