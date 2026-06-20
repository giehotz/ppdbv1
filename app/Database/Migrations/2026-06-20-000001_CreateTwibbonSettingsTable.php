<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTwibbonSettingsTable extends Migration
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
            'cleanup_enabled' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'results_ttl_hours' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 12,
            ],
            'temp_ttl_hours' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('twibbon_settings');

        // Insert default row
        $this->db->table('twibbon_settings')->insert([
            'cleanup_enabled'   => 1,
            'results_ttl_hours' => 12,
            'temp_ttl_hours'    => 1,
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('twibbon_settings');
    }
}
