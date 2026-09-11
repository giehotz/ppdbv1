<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblRegistrasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_registrasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // 'baru' (siswa baru) | 'pindahan' (siswa pindahan)
            'jenis_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'baru',
            ],
            'no_pendaftaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'th_pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'nisn' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '14',
                'null'       => true,
            ],
            // FK ke tbl_siswa (hanya terisi jika jenis 'baru')
            'id_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            // FK ke tbl_siswa_pindahan (hanya terisi jika jenis 'pindahan')
            'id_pindahan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
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
        $this->forge->addKey('id_registrasi', true);
        $this->forge->addKey('jenis_pendaftaran');
        $this->forge->addKey('no_pendaftaran');
        $this->forge->addKey('nisn');
        $this->forge->createTable('tbl_registrasi');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_registrasi');
    }
}