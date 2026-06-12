<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class CetakFormulir extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/siswa/dashboard');
        }

        // Cek kelengkapan biodata
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);
        if ($completionData['percentage'] < 100) {
            session()->setFlashdata('error', 'Silahkan lengkapi biodata untuk mencetak formulir.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $webModel = new \App\Models\TblWebModel();

        $data = [
            'siswa' => $siswa,
            'web' => $webModel->find(1)
        ];

        return view('siswa/cetak_formulir', $data);
    }
}
