<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPopupBiodataMessagesToTblWeb extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('popup_biodata_welcome', 'tbl_web')) {
            $this->forge->addColumn('tbl_web', [
                'popup_biodata_welcome' => [
                    'type'    => 'TEXT',
                    'null'    => true,
                    'after'   => 'wajib_biodata_100',
                ],
            ]);
        }
        if (!$this->db->fieldExists('popup_biodata_warning', 'tbl_web')) {
            $this->forge->addColumn('tbl_web', [
                'popup_biodata_warning' => [
                    'type'    => 'TEXT',
                    'null'    => true,
                    'after'   => 'popup_biodata_welcome',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_web', ['popup_biodata_welcome', 'popup_biodata_warning']);
    }
}
