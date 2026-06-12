<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBerkas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_siswa' => [
                'type'       => 'INT', // Assuming tbl_siswa.id_siswa is INT
                'constraint' => 11,
                // 'unsigned'   => true, // tbl_siswa.id_siswa is NOT unsigned in dump, correcting to match
            ],
            'jenis_berkas' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id_berkas', true);
        $this->forge->addForeignKey('id_siswa', 'tbl_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_berkas');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_berkas');
    }
}
