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

        // Periksa apakah fitur Surat Pernyataan diaktifkan oleh admin
        if (isset($web['tampil_surat_pernyataan']) && (int) $web['tampil_surat_pernyataan'] === 0) {
            session()->setFlashdata('warning', 'Fitur Surat Pernyataan sedang dinonaktifkan oleh panitia.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        // Validasi kelengkapan data siswa (harus 100%)
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);
        if ($completionData['percentage'] < 100) {
            session()->setFlashdata('warning', 'Silakan lengkapi biodata pendaftaran hingga 100% untuk dapat mencetak Surat Pernyataan.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $data = [
            'siswa' => $siswa,
            'web'   => $web,
        ];

        return view('siswa/surat_pernyataan', $data);
    }
}
