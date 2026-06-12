<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAnggota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_anggota' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nomor_induk' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'departemen' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'sub_departemen' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'qr_text' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_anggota', true);
        $this->forge->createTable('tb_anggota', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_anggota', true);
    }
}
