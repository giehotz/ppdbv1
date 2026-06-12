<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJalurPendaftaran extends Migration
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
            'nama_jalur' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'fas fa-graduation-cap',
            ],
            'icon_color' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'primary',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'persyaratan' => [
                'type'    => 'TEXT',
                'comment' => 'JSON array of requirements',
            ],
            'urutan' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->createTable('jalur_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('jalur_pendaftaran');
    }
}
