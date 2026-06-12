<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TblKompSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_komp' => 1, 'kompetensi' => 'Rekayasa Perangkat Lunak'],
            ['id_komp' => 2, 'kompetensi' => 'Teknik Komputer dan Jaringan'],
            ['id_komp' => 3, 'kompetensi' => 'Multimedia'],
            ['id_komp' => 4, 'kompetensi' => 'Akuntansi'],
            ['id_komp' => 5, 'kompetensi' => 'Perkantoran'],
        ];

        foreach ($data as $row) {
            $this->db->table('tbl_komp')->replace($row);
        }
    }
}
