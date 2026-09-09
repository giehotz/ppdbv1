<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUrutanToTblPekerjaan extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        if (!$db->fieldExists('urutan', 'tbl_pekerjaan')) {
            $this->forge->addColumn('tbl_pekerjaan', [
                'urutan' => [
                    'type'    => 'INT',
                    'default' => 0,
                    'after'   => 'nama_pekerjaan',
                ],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->fieldExists('urutan', 'tbl_pekerjaan')) {
            $this->forge->dropColumn('tbl_pekerjaan', 'urutan');
        }
    }
}
