<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblPenghasilanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_penghasilan' => 4, 'nama_penghasilan' => 'Rp. 2.000.000 - Rp. 5.000.000', 'urutan' => 4],
            ['id_penghasilan' => 6, 'nama_penghasilan' => 'Kurang dari Rp. 500.000', 'urutan' => 1],
            ['id_penghasilan' => 7, 'nama_penghasilan' => 'Rp. 500.000 - Rp. 1.000.000', 'urutan' => 2],
            ['id_penghasilan' => 8, 'nama_penghasilan' => 'Rp. 1.000.000 - Rp. 2.000.000', 'urutan' => 3],
            ['id_penghasilan' => 10, 'nama_penghasilan' => 'Lebih dari Rp. 5.000.000', 'urutan' => 5],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_penghasilan')->replace($row);
        }
    }
}
