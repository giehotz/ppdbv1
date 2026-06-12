<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblUnlockRequests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_request' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'alasan' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Pending', 'Disetujui', 'Ditolak'],
                'default'    => 'Pending',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_request', true);
        $this->forge->createTable('tbl_unlock_requests');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_unlock_requests');
    }
}
