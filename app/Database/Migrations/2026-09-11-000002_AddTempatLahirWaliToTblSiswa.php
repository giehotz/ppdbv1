<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTempatLahirWaliToTblSiswa extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->fieldExists('tempat_lahir_wali', 'tbl_siswa')) {
            $this->forge->addColumn('tbl_siswa', [
                'tempat_lahir_wali' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                    'after'      => 'nik_wali',
                ],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->fieldExists('tempat_lahir_wali', 'tbl_siswa')) {
            $this->forge->dropColumn('tbl_siswa', 'tempat_lahir_wali');
        }
    }
}