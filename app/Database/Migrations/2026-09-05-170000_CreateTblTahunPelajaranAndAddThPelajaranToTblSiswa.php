<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblTahunPelajaranAndAddThPelajaranToTblSiswa extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // 1. Buat tabel tbl_tahun_pelajaran jika belum ada
        if (!$db->tableExists('tbl_tahun_pelajaran')) {
            $this->forge->addField([
                'id_tahun' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'tahun_pelajaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Aktif', 'Tidak Aktif'],
                    'default'    => 'Tidak Aktif',
                ],
                'keterangan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $this->forge->addKey('id_tahun', true);
            $this->forge->addUniqueKey('tahun_pelajaran');
            $this->forge->createTable('tbl_tahun_pelajaran', true);

            // Ambil tahun pelajaran aktif saat ini dari tbl_web jika ada
            $webRow = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();
            $currentYear = !empty($webRow['th_pelajaran']) ? $webRow['th_pelajaran'] : '2025/2026';

            // Seed initial active academic year
            $db->table('tbl_tahun_pelajaran')->insert([
                'tahun_pelajaran' => $currentYear,
                'status'          => 'Aktif',
                'keterangan'      => 'Tahun Pelajaran Utama Saat Migrasi',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
        }

        // 2. Tambahkan kolom th_pelajaran pada tbl_siswa jika belum ada
        if (!$db->fieldExists('th_pelajaran', 'tbl_siswa')) {
            $this->forge->addColumn('tbl_siswa', [
                'th_pelajaran' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'null'       => true,
                    'after'      => 'no_pendaftaran',
                ],
            ]);

            // Tambahkan index untuk performa pencarian / filter
            $db->query("CREATE INDEX idx_siswa_th_pelajaran ON tbl_siswa(th_pelajaran)");
        }

        // 3. Backfill data siswa yang sudah ada dengan tahun pelajaran aktif saat ini (misal 2025/2026)
        $webRow = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();
        $targetYear = !empty($webRow['th_pelajaran']) ? $webRow['th_pelajaran'] : '2025/2026';

        $db->table('tbl_siswa')
            ->where('th_pelajaran IS NULL OR th_pelajaran = ""')
            ->update(['th_pelajaran' => $targetYear]);
    }

    public function down()
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('tbl_tahun_pelajaran')) {
            $this->forge->dropTable('tbl_tahun_pelajaran', true);
        }

        if ($db->fieldExists('th_pelajaran', 'tbl_siswa')) {
            $this->forge->dropColumn('tbl_siswa', 'th_pelajaran');
        }
    }
}
