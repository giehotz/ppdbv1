<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbSettingKop extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'logo_kiri' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'kementerian_pusat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'kementerian_kabupaten' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_madrasah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'alamat_madrasah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'email_madrasah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_setting_kop');

        // Insert default data
        $this->db->table('tb_setting_kop')->insert([
            'id' => 1,
            'logo_kiri' => 'logo-kemenag.png',
            'kementerian_pusat' => 'KEMENTERIAN AGAMA REPUBLIK INDONESIA',
            'kementerian_kabupaten' => 'KANTOR KEMENTERIAN AGAMA KABUPATEN TANGGAMUS',
            'nama_madrasah' => 'MADRASAH IBTIDAIYAH NEGERI 2 TANGGAMUS',
            'alamat_madrasah' => 'Jln. Lap. Ampera No. 109 Purwodadi Kec. Gisting Kab. Tanggamus (0729) 347578 35378',
            'email_madrasah' => 'Email : minduatanggamus@gmail.com',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('tb_setting_kop');
    }
}
