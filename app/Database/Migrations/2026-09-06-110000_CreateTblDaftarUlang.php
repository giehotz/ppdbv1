<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblDaftarUlang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_daftar_ulang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status_konfirmasi' => [
                'type'       => 'ENUM',
                'constraint' => ['bersedia', 'mengundurkan_diri'],
                'default'    => 'bersedia',
            ],
            'ukuran_baju' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'ukuran_celana' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'ukuran_peci' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'ukuran_sepatu' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'alasan_mundur' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tgl_konfirmasi' => [
                'type' => 'DATETIME',
                'null' => true,
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

        $this->forge->addKey('id_daftar_ulang', true);
        $this->forge->addUniqueKey('id_siswa');
        $this->forge->createTable('tbl_daftar_ulang', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_daftar_ulang', true);
    }
}
