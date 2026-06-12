<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlurPendaftaranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'judul' => 'Buat Akun',
                'deskripsi' => 'buat akun untuk mendaftar',
                'icon' => 'fas fa-user-circle',
                'urutan' => 1,
                'status' => 'aktif',
                'created_at' => '2026-02-14 13:36:35',
                'updated_at' => '2026-02-14 13:43:39',
            ],
            [
                'id' => 2,
                'judul' => 'isi data diri',
                'deskripsi' => 'isi data diri sesuai dengan kartu keluarga',
                'icon' => 'fas fa-trophy',
                'urutan' => 2,
                'status' => 'aktif',
                'created_at' => '2026-02-14 13:58:07',
                'updated_at' => '2026-02-14 13:58:07',
            ],
        ];

        // Simple check to avoid duplicates if re-run, or just insert
        // Using replace() to handle existing IDs
        foreach ($data as $row) {
            $this->db->table('alur_pendaftaran')->replace($row);
        }
    }
}
