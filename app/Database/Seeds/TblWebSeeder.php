<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblWebSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_web' => 1,
                'status_ppdb' => 'buka',
                'ujian_aktif' => '0',
                'tgl_ujian' => NULL,
                'pengumuman_aktif' => '1',
                'tgl_pengumuman' => '2026-04-15 19:50:00',
                'tgl_diubah' => '2026-01-30 11:52:19',
                'nama_sekolah' => 'MIN 2 Tanggamus',
                'alamat_sekolah' => NULL,
                'logo_sekolah' => 'logo_sekolah.png',
                'pesan_tutup' => '',
                'limit_kuota' => 0,
                'nsm' => '111118060002',
                'npsn' => '60705691',
                'kecamatan' => 'GISTING',
                'kabupaten' => 'TANGGAMUS',
                'provinsi' => 'LAMPUNG',
                'nama_kepala' => '',
                'nip_kepala' => '',
                'telepon' => '(021) 12345678',
                'email' => 'minduatanggamus@gmail.com',
                'website' => '',
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_web')->replace($row);
        }
    }
}
