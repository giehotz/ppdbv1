<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteSettings extends Migration
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
            'site_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_title_suffix' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'meta_keywords' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'og_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'google_analytics' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('site_settings');

        // Insert default row
        $this->db->table('site_settings')->insert([
            'id'                => 1,
            'site_name'         => 'PPDB MIN 2 Tanggamus',
            'meta_title_suffix' => ' | PPDB MIN 2 Tanggamus',
            'meta_description'  => 'Portal Penerimaan Peserta Didik Baru (PPDB) Online MIN 2 Tanggamus. Daftar sekarang untuk tahun pelajaran baru.',
            'meta_keywords'     => 'PPDB, MIN 2 Tanggamus, pendaftaran siswa baru, madrasah ibtidaiyah, sekolah islam',
            'og_image'          => null,
            'google_analytics'  => null,
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('site_settings');
    }
}
