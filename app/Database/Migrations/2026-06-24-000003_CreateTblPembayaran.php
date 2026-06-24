<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pembayaran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'siswa_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'metode' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'comment'    => 'tunai/transfer/qris',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diverifikasi_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_pembayaran', true);
        $this->forge->addKey('siswa_id');
        $this->forge->addForeignKey('siswa_id', 'tbl_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pembayaran');
    }
}
