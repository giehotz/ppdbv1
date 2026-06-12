<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSettingPrinter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_printer' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dpi' => [
                'type'       => 'INT',
                'constraint' => 4,
                'default'    => 300,
            ],
            'margin_kiri' => [
                'type'       => 'FLOAT',
                'default'    => 0,
            ],
            'margin_atas' => [
                'type'       => 'FLOAT',
                'default'    => 0,
            ],
            'margin_kartu_kanan' => [
                'type'       => 'FLOAT',
                'default'    => 0,
            ],
            'margin_kartu_bawah' => [
                'type'       => 'FLOAT',
                'default'    => 0,
            ],
            'margin_depan_belakang' => [
                'type'       => 'FLOAT',
                'default'    => 0,
            ],
        ]);
        $this->forge->addKey('id_printer', true);
        $this->forge->createTable('tb_setting_printer', true);
    }

    public function down()
    {
        $this->forge->dropTable('tb_setting_printer', true);
    }
}
