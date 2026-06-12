<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbInstansi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_instansi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kementerian' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'nama_instansi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telp_fax' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_instansi', true);
        $this->forge->createTable('tb_instansi', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_instansi', true);
    }
}
