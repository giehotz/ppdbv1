<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPdd extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pdd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'urutan' => [
                'type'    => 'INT',
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id_pdd', true);
        $this->forge->createTable('tbl_pdd');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pdd');
    }
}
