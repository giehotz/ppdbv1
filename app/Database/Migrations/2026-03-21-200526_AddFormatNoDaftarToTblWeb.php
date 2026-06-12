<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFormatNoDaftarToTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_web', [
            'format_no_daftar' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'PPDB-{TAHUN}-{URUT}',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'format_no_daftar');
    }
}
