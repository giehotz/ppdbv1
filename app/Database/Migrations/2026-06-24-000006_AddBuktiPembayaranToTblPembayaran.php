<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBuktiPembayaranToTblPembayaran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('bukti_pembayaran', 'tbl_pembayaran')) {
            $this->forge->addColumn('tbl_pembayaran', [
                'bukti_pembayaran' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'comment' => 'JSON array of file paths',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_pembayaran', 'bukti_pembayaran');
    }
}
