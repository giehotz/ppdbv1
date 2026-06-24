<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblItemPembiayaanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_item' => 1, 'nama' => 'Infak 1 Tahun',           'harga' => 150000,  'jenis_kelamin' => null, 'urutan' => 1, 'aktif' => 1],
            ['id_item' => 2, 'nama' => 'Kaos Olah Raga',          'harga' => 75000,   'jenis_kelamin' => null, 'urutan' => 2, 'aktif' => 1],
            ['id_item' => 3, 'nama' => 'Batik',                   'harga' => 120000,  'jenis_kelamin' => null, 'urutan' => 3, 'aktif' => 1],
            ['id_item' => 4, 'nama' => 'Peci',                    'harga' => 25000,   'jenis_kelamin' => 'L',  'urutan' => 4, 'aktif' => 1],
            ['id_item' => 5, 'nama' => 'Atribut',                 'harga' => 50000,   'jenis_kelamin' => null, 'urutan' => 5, 'aktif' => 1],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_item_pembiayaan')->replace($row);
        }
    }
}
