<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblLandingContent extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'section' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'content_key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'content_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'media_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'order_index' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_landing_content');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_landing_content');
    }
}
