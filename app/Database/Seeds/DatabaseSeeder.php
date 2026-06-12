<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('TblUserSeeder');
        $this->call('TblWebSeeder');
        $this->call('AlurPendaftaranSeeder');
        $this->call('FaqsSeeder');
        $this->call('JalurPendaftaranSeeder');
        $this->call('TblKompSeeder');
        $this->call('TblPddSeeder');
        $this->call('TblPekerjaanSeeder');
        $this->call('TblPenghasilanSeeder');
        $this->call('TblPengumumanSeeder');
        $this->call('TblStaticPageSeeder');
        $this->call('TblSiswaSeeder');
        $this->call('TblBerkasSeeder');
        $this->call('TblLandingContentSeeder');
        $this->call('TblVerifikasiSeeder');
    }
}
