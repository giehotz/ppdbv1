<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBerkasPindahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas_pindahan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pindahan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jenis_berkas' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '500',
                'null'       => true,
            ],
            'ukuran_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_verifikasi' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'valid', 'invalid'],
                'default'    => 'pending',
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
        $this->forge->addKey('id_berkas_pindahan', true);
        $this->forge->addKey('id_pindahan');
        $this->forge->addForeignKey('id_pindahan', 'tbl_siswa_pindahan', 'id_pindahan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_berkas_pindahan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_berkas_pindahan');
    }
}