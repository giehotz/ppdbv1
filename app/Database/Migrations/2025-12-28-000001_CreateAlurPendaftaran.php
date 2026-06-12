<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlurPendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'fas fa-check',
            ],
            'urutan' => [
                'type'       => 'INT',
                'default'    => 1,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'tidak_aktif'],
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('alur_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('alur_pendaftaran');
    }
}
