<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPekerjaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pekerjaan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_pekerjaan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kategori_peruntukan' => [
                'type'       => 'ENUM',
                'constraint' => ['ayah', 'ibu', 'wali', 'umum'],
                'default'    => 'umum',
                'null'       => true,
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
        $this->forge->addKey('id_pekerjaan', true);
        $this->forge->createTable('tbl_pekerjaan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pekerjaan');
    }
}
