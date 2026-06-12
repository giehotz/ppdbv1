<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPopupFieldsToPengumuman extends Migration
{
    public function up()
    {
        $fields = [
            'is_popup' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_active',
            ],
            'popup_countdown' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'after'      => 'is_popup',
            ],
        ];

        $this->forge->addColumn('tbl_pengumuman', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_pengumuman', ['is_popup', 'popup_countdown']);
    }
}
