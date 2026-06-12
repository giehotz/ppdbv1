<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPenghasilan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penghasilan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_penghasilan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'urutan' => [
                'type'    => 'INT',
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id_penghasilan', true);
        $this->forge->createTable('tbl_penghasilan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_penghasilan');
    }
}
