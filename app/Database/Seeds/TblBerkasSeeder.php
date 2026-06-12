<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblBerkasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_berkas' => 5,
                'id_siswa' => 1,
                'jenis_berkas' => 'Kartu Keluarga',
                'nama_file' => '3190042995/kartu_keluarga_1768650631_1768650631_a223fa1ec23ba89f1d44.jpeg',
                'deskripsi' => '',
                'keterangan' => NULL,
                'status_verifikasi' => 'pending',
                'created_at' => '2026-01-17 11:50:31',
                'updated_at' => '2026-01-17 11:50:31',
            ],
            [
                'id_berkas' => 6,
                'id_siswa' => 1,
                'jenis_berkas' => 'Akte Kelahiran',
                'nama_file' => '3190042995/akte_kelahiran_1768650675_1768650675_64f9a8b73702e0064040.jpeg',
                'deskripsi' => '',
                'keterangan' => NULL,
                'status_verifikasi' => 'pending',
                'created_at' => '2026-01-17 11:51:15',
                'updated_at' => '2026-01-17 11:51:15',
            ],
            [
                'id_berkas' => 7,
                'id_siswa' => 1,
                'jenis_berkas' => 'Pas Foto',
                'nama_file' => '3190042995/pas_foto_1768652497_1768652497_1840dcf933a049ed2271.png',
                'deskripsi' => '',
                'keterangan' => NULL,
                'status_verifikasi' => 'pending',
                'created_at' => '2026-01-17 12:21:37',
                'updated_at' => '2026-01-17 12:21:37',
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_berkas')->replace($row);
        }
    }
}
