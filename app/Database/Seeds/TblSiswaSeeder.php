<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblSiswaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_siswa' => 1,
                'no_pendaftaran' => 'PPDB-2026-0001',
                'password' => '$2y$10$4MKt38gPljQ/BFNJ/It8L.nDOb1sG24V1UW1udwX1/Nwsge1xWJjC',
                'nis' => NULL,
                'nisn' => '3190042995',
                'nik' => '1806012705700006',
                'nama_lengkap' => 'MUHAMMAD SOFYAN HARIS',
                'email' => '',
                'jk' => 'L',
                'tempat_lahir' => 'TANGGAMUS',
                'tgl_lahir' => '2019-02-09',
                'agama' => 'Islam',
                'status_keluarga' => NULL,
                'anak_ke' => '1',
                'jml_saudara' => '2',
                'hobi' => 'main',
                'cita' => 'doker',
                'paud' => NULL,
                'tk' => NULL,
                'alamat_siswa' => 'DUSUN GUNUNG SARI, RT/RW 003/002, WAY PRING, PUGUNG, TANGGAMUS, LAMPUNG, 35375',
                'jenis_tinggal' => 'Bersama Orang Tua',
                'desa' => 'PURWODADI',
                'kec' => 'GISTING',
                'kab' => 'KABUPATEN TANGGAMUS',
                'prov' => 'LAMPUNG',
                'kode_pos' => '35378',
                'jarak' => '1',
                'trans' => 'Jalan Kaki',
                'no_hp_siswa' => '082269226552',
                'no_kk' => '1806201011206666',
                'kepala_keluarga' => NULL,
                'nama_ayah' => 'MU\'MIN',
                'nik_ayah' => '1806112002190010',
                'tempat_lahir_ayah' => 'PANDEGLANG',
                'tgl_lahir_ayah' => '1991-06-12',
                'status_ayah' => 'Hidup',
                'pdd_ayah' => 'SD / Sederajat',
                'pekerjaan_ayah' => 'Petani / Peternak',
                'penghasilan_ayah' => 'Rp. 500.000 - Rp. 1.000.000',
                'nama_ibu' => 'SUPIAH',
                'nik_ibu' => '1806116505980002',
                'tempat_lahir_ibu' => 'GEDONG TATAAN',
                'tgl_lahir_ibu' => '1998-05-25',
                'status_ibu' => 'Hidup',
                'pdd_ibu' => 'SMP / Sederajat',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => 'Rp. 500.000 - Rp. 1.000.000',
                'nama_wali' => 'MU\'MIN',
                'nik_wali' => '1806112002190010',
                'tgl_lahir_wali' => '1991-01-01',
                'pdd_wali' => 'SD / Sederajat',
                'pekerjaan_wali' => 'Petani / Peternak',
                'penghasilan_wali' => 'Rp. 500.000 - Rp. 1.000.000',
                'no_hp_ortu' => '082269226558',
                'npsn_sekolah' => '160606222',
                'nama_sekolah' => 'RA PPI',
                'status_sekolah' => 'Swasta',
                'jenjang_sekolah' => 'TK/RA/PAUD',
                'lokasi_sekolah' => 'Tanggamus',
                'no_kks' => '',
                'file_kks' => '',
                'no_pkh' => '',
                'file_pkh' => '',
                'no_kip' => '',
                'file_kip' => '',
                'komp_ahli' => NULL,
                'jalur_pendaftaran' => NULL,
                'tgl_siswa' => '2026-01-17 10:22:15',
                'status_verifikasi' => '1',
                'status_pendaftaran' => 'Lulus',
                'tgl_verifikasi' => '2026-01-30 12:16:40',
                'verified_by' => 1,
                'catatan_verifikasi' => NULL,
            ],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_siswa')->replace($row);
        }
    }
}
