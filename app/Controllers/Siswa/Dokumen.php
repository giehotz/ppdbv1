<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TblWebModel;

class Dokumen extends BaseController
{
    public function suratPernyataan()
    {
        $siswaModel = new SiswaModel();
        $idSiswa = session()->get('id_siswa');

        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        $siswa = $siswaModel->find($idSiswa);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $webModel = new TblWebModel();
        $web = $webModel->first() ?? [];

        $data = [
            'siswa' => $siswa,
            'web'   => $web,
        ];

        return view('siswa/surat_pernyataan', $data);
    }
}
