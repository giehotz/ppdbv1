<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblPddSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_pdd' => 1, 'pendidikan' => 'Tidak Sekolah', 'urutan' => 1],
            ['id_pdd' => 2, 'pendidikan' => 'SD / Sederajat', 'urutan' => 2],
            ['id_pdd' => 3, 'pendidikan' => 'SMP / Sederajat', 'urutan' => 3],
            ['id_pdd' => 4, 'pendidikan' => 'SMA / SMK / Sederajat', 'urutan' => 4],
            ['id_pdd' => 5, 'pendidikan' => 'D1', 'urutan' => 5],
            ['id_pdd' => 6, 'pendidikan' => 'D2', 'urutan' => 6],
            ['id_pdd' => 7, 'pendidikan' => 'D3', 'urutan' => 7],
            ['id_pdd' => 8, 'pendidikan' => 'D4 / S1', 'urutan' => 8],
            ['id_pdd' => 9, 'pendidikan' => 'S2', 'urutan' => 9],
            ['id_pdd' => 10, 'pendidikan' => 'S3', 'urutan' => 10],
            ['id_pdd' => 11, 'pendidikan' => 'TK/RA/PAUD', 'urutan' => 2],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_pdd')->replace($row);
        }
    }
}
