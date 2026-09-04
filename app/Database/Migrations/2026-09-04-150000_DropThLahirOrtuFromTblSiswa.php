<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropThLahirOrtuFromTblSiswa extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // 1. Migrasikan data yang ada di PHP agar aman dari strict mode MySQL
        $builder = $db->table('tbl_siswa');
        $rows = $builder->select('id_siswa, tgl_lahir_ayah, th_lahir_ayah, tgl_lahir_ibu, th_lahir_ibu')->get()->getResultArray();

        foreach ($rows as $row) {
            $updates = [];

            // Evaluasi Tanggal Lahir Ayah
            $tglAyah = $row['tgl_lahir_ayah'];
            $thAyah  = trim((string)($row['th_lahir_ayah'] ?? ''));
            $isTglAyahEmpty = empty($tglAyah) || $tglAyah === '0000-00-00';

            if ($isTglAyahEmpty && !empty($thAyah)) {
                // Jika 4 digit tahun (contoh: 1985)
                if (preg_match('/^[12][0-9]{3}$/', $thAyah)) {
                    $updates['tgl_lahir_ayah'] = $thAyah . '-01-01';
                }
                // Jika 8 digit ddmmyyyy (contoh: 02111983)
                elseif (preg_match('/^(\d{2})(\d{2})(\d{4})$/', $thAyah, $m)) {
                    $d = $m[1];
                    $mo = $m[2];
                    $y = $m[3];
                    if (checkdate((int)$mo, (int)$d, (int)$y)) {
                        $updates['tgl_lahir_ayah'] = sprintf('%04d-%02d-%02d', $y, $mo, $d);
                    }
                }
            } elseif ($tglAyah === '0000-00-00') {
                $updates['tgl_lahir_ayah'] = null;
            }

            // Evaluasi Tanggal Lahir Ibu
            $tglIbu = $row['tgl_lahir_ibu'];
            $thIbu  = trim((string)($row['th_lahir_ibu'] ?? ''));
            $isTglIbuEmpty = empty($tglIbu) || $tglIbu === '0000-00-00';

            if ($isTglIbuEmpty && !empty($thIbu)) {
                // Jika 4 digit tahun (contoh: 1988)
                if (preg_match('/^[12][0-9]{3}$/', $thIbu)) {
                    $updates['tgl_lahir_ibu'] = $thIbu . '-01-01';
                }
                // Jika 8 digit ddmmyyyy
                elseif (preg_match('/^(\d{2})(\d{2})(\d{4})$/', $thIbu, $m)) {
                    $d = $m[1];
                    $mo = $m[2];
                    $y = $m[3];
                    if (checkdate((int)$mo, (int)$d, (int)$y)) {
                        $updates['tgl_lahir_ibu'] = sprintf('%04d-%02d-%02d', $y, $mo, $d);
                    }
                }
            } elseif ($tglIbu === '0000-00-00') {
                $updates['tgl_lahir_ibu'] = null;
            }

            if (!empty($updates)) {
                $db->table('tbl_siswa')->where('id_siswa', $row['id_siswa'])->update($updates);
            }
        }

        // 2. Drop kolom th_lahir_ayah dan th_lahir_ibu dari tbl_siswa
        $fieldsToDrop = [];
        if ($db->fieldExists('th_lahir_ayah', 'tbl_siswa')) {
            $fieldsToDrop[] = 'th_lahir_ayah';
        }
        if ($db->fieldExists('th_lahir_ibu', 'tbl_siswa')) {
            $fieldsToDrop[] = 'th_lahir_ibu';
        }

        if (!empty($fieldsToDrop)) {
            $this->forge->dropColumn('tbl_siswa', $fieldsToDrop);
        }
    }

    public function down()
    {
        $fields = [
            'th_lahir_ayah' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'status_ayah',
            ],
            'th_lahir_ibu' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'status_ibu',
            ],
        ];
        $this->forge->addColumn('tbl_siswa', $fields);
    }
}
