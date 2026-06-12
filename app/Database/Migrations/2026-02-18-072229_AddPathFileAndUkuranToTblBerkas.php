<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPathFileAndUkuranToTblBerkas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_berkas', [
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'nama_file',
            ],
            'ukuran_file' => [
                'type'    => 'INT',
                'null'    => true,
                'after'   => 'path_file',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_berkas', 'path_file');
        $this->forge->dropColumn('tbl_berkas', 'ukuran_file');
    }
}
