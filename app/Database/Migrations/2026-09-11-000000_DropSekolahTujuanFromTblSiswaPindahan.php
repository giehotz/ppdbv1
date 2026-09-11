<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropSekolahTujuanFromTblSiswaPindahan extends Migration
{
    /**
     * Kolom "Sekolah Tujuan" sudah tidak digunakan (sekolah tujuan
     * ditentukan panitia). Hapus seluruh kolom tujuan agar persentase
     * kelengkapan biodata dapat mencapai 100%.
     */
    protected $fieldsToDrop = [
        'npsn_sekolah_tujuan',
        'nama_sekolah_tujuan',
        'alamat_sekolah_tujuan',
        'kota_tujuan',
        'provinsi_tujuan',
        'jenjang_sekolah_tujuan',
        'grup_jenjang_tujuan',
        'kelas_tujuan',
    ];

    public function up()
    {
        $db = \Config\Database::connect();

        $fields = [];
        foreach ($this->fieldsToDrop as $field) {
            if ($db->fieldExists($field, 'tbl_siswa_pindahan')) {
                $fields[] = $field;
            }
        }

        if (!empty($fields)) {
            $this->forge->dropColumn('tbl_siswa_pindahan', $fields);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();

        $fields = [
            'npsn_sekolah_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'tgl_ijazah_sekolah_asal',
            ],
            'nama_sekolah_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'npsn_sekolah_tujuan',
            ],
            'alamat_sekolah_tujuan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'nama_sekolah_tujuan',
            ],
            'kota_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'alamat_sekolah_tujuan',
            ],
            'provinsi_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'kota_tujuan',
            ],
            'jenjang_sekolah_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'provinsi_tujuan',
            ],
            'grup_jenjang_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'jenjang_sekolah_tujuan',
            ],
            'kelas_tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'grup_jenjang_tujuan',
            ],
        ];

        $pending = [];
        foreach ($fields as $name => $def) {
            if (!$db->fieldExists($name, 'tbl_siswa_pindahan')) {
                $pending[$name] = $def;
            }
        }

        if (!empty($pending)) {
            $this->forge->addColumn('tbl_siswa_pindahan', $pending);
        }
    }
}