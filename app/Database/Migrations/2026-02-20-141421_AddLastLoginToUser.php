<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLastLoginToUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_user', [
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'level',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_user', 'last_login');
    }
}
