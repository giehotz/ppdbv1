<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqs extends Migration
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
            'pertanyaan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jawaban' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('faqs');
    }

    public function down()
    {
        $this->forge->dropTable('faqs');
    }
}
