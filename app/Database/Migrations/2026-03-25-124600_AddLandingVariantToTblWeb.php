<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLandingVariantToTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_web', [
            'landing_variant' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'index',
                'null'       => false,
                'after'      => 'tampil_grup_wa',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'landing_variant');
    }
}
