<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStepperConfigToTblWeb extends Migration
{
    public function up()
    {
        $fields = [
            'stepper_aktif' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'after'      => 'seragam_fields',
            ],
            'stepper_config' => [
                'type'       => 'LONGTEXT',
                'null'       => true,
                'after'      => 'stepper_aktif',
            ],
        ];

        // Only add if not already existing
        $db = \Config\Database::connect();
        if (!$db->fieldExists('stepper_aktif', 'tbl_web')) {
            $this->forge->addColumn('tbl_web', ['stepper_aktif' => $fields['stepper_aktif']]);
        }
        if (!$db->fieldExists('stepper_config', 'tbl_web')) {
            $this->forge->addColumn('tbl_web', ['stepper_config' => $fields['stepper_config']]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->fieldExists('stepper_config', 'tbl_web')) {
            $this->forge->dropColumn('tbl_web', 'stepper_config');
        }
        if ($db->fieldExists('stepper_aktif', 'tbl_web')) {
            $this->forge->dropColumn('tbl_web', 'stepper_aktif');
        }
    }
}
