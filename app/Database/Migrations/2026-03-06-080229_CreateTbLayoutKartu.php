<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLayoutKartu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_layout' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_layout' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'panjang_cm' => [
                'type'       => 'FLOAT',
                'default'    => 8.56,
            ],
            'lebar_cm' => [
                'type'       => 'FLOAT',
                'default'    => 5.39,
            ],
            'masa_berlaku' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 3,
            ],
            'bg_depan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'bg_belakang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_layout', true);
        $this->forge->createTable('tb_layout_kartu', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_layout_kartu', true);
    }
}
