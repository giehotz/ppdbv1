<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWajibBiodataToTblWeb extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('wajib_biodata_100', 'tbl_web')) {
            $this->forge->addColumn('tbl_web', [
                'wajib_biodata_100' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                    'null'       => false,
                    'after'      => 'landing_variant',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'wajib_biodata_100');
    }
}
