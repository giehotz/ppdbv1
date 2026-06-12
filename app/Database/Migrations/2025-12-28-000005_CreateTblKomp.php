<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblKomp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_komp' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'kompetensi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_komp', true);
        $this->forge->createTable('tbl_komp');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_komp');
    }
}
