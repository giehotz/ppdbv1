<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'username' => 'admin',
                'password' => '$2y$10$tj0C1gvqIbccPcg49QT4pulJfPucrUbDKnFszwvkVU0vz1ATcCCba',
                'nama_lengkap' => 'Administrator PPDB',
                'alamat' => 'Jl. Pendidikan No. 1',
                'email' => 'admin@sekolah.sch.id',
                'website' => 'https://sekolah.sch.id',
                'telp' => '081234567890',
                'kab_sekolah' => 'Kabupaten Contoh',
                'ketua_panitia' => NULL,
                'nip_ketua' => NULL,
                'th_pelajaran' => '2025/2026',
                'no_surat' => NULL,
                'kepsek' => NULL,
                'nip_kepsek' => NULL,
                'level' => 'admin',
                'tgl_daftar' => '2025-12-28 11:32:37',
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_user')->replace($row);
        }
    }
}
