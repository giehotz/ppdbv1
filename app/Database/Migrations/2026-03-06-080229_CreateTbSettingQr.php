<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSettingQr extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_qr' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'version' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => 4,
            ],
            'ecc_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'M',
            ],
            'size_pixel' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 100,
            ],
            'padding_tepi' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => 2,
            ],
            'global_text' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'posisi_kartu' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Background Depan',
            ],
        ]);
        $this->forge->addKey('id_qr', true);
        $this->forge->createTable('tb_setting_qr', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_setting_qr', true);
    }
}
