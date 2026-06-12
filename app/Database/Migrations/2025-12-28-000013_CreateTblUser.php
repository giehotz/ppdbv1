<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'password' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kab_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'ketua_panitia' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'nip_ketua' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'th_pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'no_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kepsek' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'nip_kepsek' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'tgl_daftar' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('tbl_user');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_user');
    }
}
