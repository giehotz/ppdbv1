<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdSiswaToTblVerifikasi extends Migration
{
    public function up()
    {
        $fields = [
            'id_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'id_verifikasi',
            ],
        ];

        $this->forge->addColumn('tbl_verifikasi', $fields);

        // Add foreign key
        $this->forge->addForeignKey('id_siswa', 'tbl_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->db->query('ALTER TABLE tbl_verifikasi ADD CONSTRAINT fk_verifikasi_siswa FOREIGN KEY (id_siswa) REFERENCES tbl_siswa(id_siswa) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign key first
        $this->db->query('ALTER TABLE tbl_verifikasi DROP FOREIGN KEY fk_verifikasi_siswa');

        // Drop column
        $this->forge->dropColumn('tbl_verifikasi', 'id_siswa');
    }
}
