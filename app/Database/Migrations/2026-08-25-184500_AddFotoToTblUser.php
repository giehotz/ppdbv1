<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToTblUser extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'level',
            ],
        ];

        if (!$this->db->fieldExists('foto', 'tbl_user')) {
            $this->forge->addColumn('tbl_user', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('foto', 'tbl_user')) {
            $this->forge->dropColumn('tbl_user', 'foto');
        }
    }
}
