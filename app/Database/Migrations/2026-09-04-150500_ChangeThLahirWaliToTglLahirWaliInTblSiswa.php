<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeThLahirWaliToTglLahirWaliInTblSiswa extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // 1. Tambahkan kolom tgl_lahir_wali jika belum ada
        if (!$db->fieldExists('tgl_lahir_wali', 'tbl_siswa')) {
            $fields = [
                'tgl_lahir_wali' => [
                    'type' => 'DATE',
                    'null' => true,
                    'after' => 'nik_wali',
                ],
            ];
            $this->forge->addColumn('tbl_siswa', $fields);
        }

        // 2. Migrasikan data yang ada dari th_lahir_wali ke tgl_lahir_wali
        if ($db->fieldExists('th_lahir_wali', 'tbl_siswa')) {
            $builder = $db->table('tbl_siswa');
            $rows = $builder->select('id_siswa, th_lahir_wali, tgl_lahir_wali')
                ->where('th_lahir_wali IS NOT NULL AND th_lahir_wali != ""')
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {
                $thWali = trim((string)$row['th_lahir_wali']);
                $updates = [];

                if (preg_match('/^[12][0-9]{3}$/', $thWali)) {
                    $updates['tgl_lahir_wali'] = $thWali . '-01-01';
                } elseif (preg_match('/^(\d{2})(\d{2})(\d{4})$/', $thWali, $m)) {
                    $d = $m[1];
                    $mo = $m[2];
                    $y = $m[3];
                    if (checkdate((int)$mo, (int)$d, (int)$y)) {
                        $updates['tgl_lahir_wali'] = sprintf('%04d-%02d-%02d', $y, $mo, $d);
                    }
                }

                if (!empty($updates)) {
                    $db->table('tbl_siswa')->where('id_siswa', $row['id_siswa'])->update($updates);
                }
            }

            // 3. Drop kolom th_lahir_wali dari tbl_siswa
            $this->forge->dropColumn('tbl_siswa', 'th_lahir_wali');
        }
    }

    public function down()
    {
        $fields = [
            'th_lahir_wali' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'nik_wali',
            ],
        ];
        $this->forge->addColumn('tbl_siswa', $fields);
        $this->forge->dropColumn('tbl_siswa', 'tgl_lahir_wali');
    }
}
