<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblPekerjaanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama_pekerjaan' => 'PNS/TNI/Polri',               'urutan' => 1],
            ['nama_pekerjaan' => 'Tenaga Medis',                'urutan' => 2],
            ['nama_pekerjaan' => 'Tenaga Pendidik',             'urutan' => 3],
            ['nama_pekerjaan' => 'Karyawan Swasta',             'urutan' => 4],
            ['nama_pekerjaan' => 'Wiraswasta/Pedagang',         'urutan' => 5],
            ['nama_pekerjaan' => 'Petani/Peternak/Nelayan',     'urutan' => 6],
            ['nama_pekerjaan' => 'Buruh/Pekerja Lepas',         'urutan' => 7],
            ['nama_pekerjaan' => 'Seni/Hukum/Komunikasi',       'urutan' => 8],
            ['nama_pekerjaan' => 'Transportasi',                'urutan' => 9],
            ['nama_pekerjaan' => 'Pensiunan',                   'urutan' => 10],
            ['nama_pekerjaan' => 'Tidak Bekerja',               'urutan' => 11],
            ['nama_pekerjaan' => 'Sudah Meninggal',             'urutan' => 12],
        ];

        $this->db->table('tbl_pekerjaan')->truncate();

        foreach ($data as $row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            $this->db->table('tbl_pekerjaan')->insert($row);
        }
    }
}
