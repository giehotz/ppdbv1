<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pesan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pengirim_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // As user requested: identify if sent by verifikator or admin
            'pengirim_type' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'verifikator'],
                'default'    => 'admin',
            ],
            'penerima_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'subjek' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'isi_pesan' => [
                'type'       => 'TEXT',
            ],
            'lampiran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['unread', 'read'],
                'default'    => 'unread',
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

        $this->forge->addKey('id_pesan', true);
        
        // Foreign keys for integrity
        // $this->forge->addForeignKey('pengirim_id', 'tbl_user', 'id_user', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('penerima_id', 'tbl_siswa', 'id_siswa', 'CASCADE', 'CASCADE');

        $this->forge->createTable('tbl_pesan', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pesan', true);
    }
}
