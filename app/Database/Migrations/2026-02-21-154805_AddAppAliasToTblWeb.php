<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAppAliasToTblWeb extends Migration
{
    public function up()
    {
        $fields = [
            'app_alias' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'PPDB',
                'after'      => 'id_web',
            ],
        ];
        $this->forge->addColumn('tbl_web', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'app_alias');
    }
}
