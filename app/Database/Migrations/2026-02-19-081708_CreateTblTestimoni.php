<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblTestimoni extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'testimoni_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'peran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'avatar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'rating' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 5,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('testimoni_id', true);
        $this->forge->createTable('tbl_testimoni');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_testimoni');
    }
}
