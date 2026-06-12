<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWhatsappGroupToTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_web', [
            'link_grup_wa' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tampil_grup_wa' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', 'link_grup_wa');
        $this->forge->dropColumn('tbl_web', 'tampil_grup_wa');
    }
}
