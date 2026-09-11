<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJarakTransToTblSiswaPindahan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_siswa_pindahan', [
            'jarak' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'trans' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa_pindahan', ['jarak', 'trans']);
    }
}