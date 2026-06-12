<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPengumuman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengumuman' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'isi_pengumuman' => [
                'type' => 'TEXT',
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['general', 'ujian', 'kelulusan'],
                'default'    => 'general',
            ],
            'target_audience' => [
                'type'       => 'ENUM',
                'constraint' => ['all', 'verified', 'lulus', 'rejected'],
                'default'    => 'all',
            ],
            'lampiran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'publish_date' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addKey('id_pengumuman', true);
        $this->forge->createTable('tbl_pengumuman');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pengumuman');
    }
}
