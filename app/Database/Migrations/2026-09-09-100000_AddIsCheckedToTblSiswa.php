<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsCheckedToTblSiswa extends Migration
{
    public function up()
    {
        // Add is_checked column after status_lulus
        $this->forge->addColumn('tbl_siswa', [
            'is_checked' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'after'      => 'status_lulus',
            ],
        ]);

        // Add index for performance
        $this->db->query('ALTER TABLE `tbl_siswa` ADD INDEX `idx_is_checked` (`is_checked`)');
    }

    public function down()
    {
        // Remove index first
        $this->db->query('ALTER TABLE `tbl_siswa` DROP INDEX `idx_is_checked`');

        // Drop column
        $this->forge->dropColumn('tbl_siswa', 'is_checked');
    }
}
