<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblWeb extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_web' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'status_ppdb' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'ujian_aktif' => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1'],
                'default'    => '0',
                'null'       => true,
            ],
            'tgl_ujian' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'pengumuman_aktif' => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1'],
                'default'    => '0',
                'null'       => true,
            ],
            'tgl_pengumuman' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'tgl_diubah' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'alamat_sekolah' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'logo_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'pesan_tutup' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'limit_kuota' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => true,
            ],
            'nsm' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'npsn' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kabupaten' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'provinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'nama_kepala' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'nip_kepala' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'null'       => true,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
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
        ]);
        $this->forge->addKey('id_web', true);
        $this->forge->createTable('tbl_web');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_web');
    }
}
