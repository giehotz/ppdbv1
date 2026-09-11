<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasDiterimaToTblSiswaPindahan extends Migration
{
    public function up()
    {
        $fields = [
            'kelas_diterima' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'kelas_sekolah_asal',
            ],
        ];

        $this->forge->addColumn('tbl_siswa_pindahan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_siswa_pindahan', 'kelas_diterima');
    }
}