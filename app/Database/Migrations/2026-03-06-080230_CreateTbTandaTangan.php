<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbTandaTangan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ttd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kota_ttd' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'nama_pejabat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'nip_pejabat' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tgl_ttd' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'file_ttd' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'file_cap' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_ttd', true);
        $this->forge->createTable('tb_tanda_tangan', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_tanda_tangan', true);
    }
}
