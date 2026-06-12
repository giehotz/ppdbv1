<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThPelajaranToTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_web', [
            'th_pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
                'default'    => 'Ganjil',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', ['th_pelajaran', 'semester']);
    }
}
