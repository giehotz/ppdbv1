<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAppNameToTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_web', [
            'app_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => 'Penerimaan Peserta Didik Baru',
                'after'      => 'app_alias'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'app_name');
    }
}
