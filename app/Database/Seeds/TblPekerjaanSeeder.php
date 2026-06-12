<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblPekerjaanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_pekerjaan' => 1, 'nama_pekerjaan' => 'Tidak Bekerja', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 2, 'nama_pekerjaan' => 'PNS / ASN', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 3, 'nama_pekerjaan' => 'TNI / Polri', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 4, 'nama_pekerjaan' => 'Karyawan Swasta', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 5, 'nama_pekerjaan' => 'Wiraswasta', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 6, 'nama_pekerjaan' => 'Petani / Peternak', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 7, 'nama_pekerjaan' => 'Nelayan', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 8, 'nama_pekerjaan' => 'Buruh', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 9, 'nama_pekerjaan' => 'Pedagang', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 10, 'nama_pekerjaan' => 'Ibu Rumah Tangga', 'kategori_peruntukan' => 'ibu'],
            ['id_pekerjaan' => 11, 'nama_pekerjaan' => 'Pensiunan', 'kategori_peruntukan' => 'umum'],
            ['id_pekerjaan' => 12, 'nama_pekerjaan' => 'Lainnya', 'kategori_peruntukan' => 'umum'],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_pekerjaan')->replace($row);
        }
    }
}
