<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TblWebModel;
use App\Models\LayoutKartuModel;
use App\Models\SettingQrModel;
use App\Models\TandaTanganModel;
use App\Models\SettingPrinterModel;
use App\Models\BerkasModel;

class CetakKartu extends BaseController
{
    public function index()
    {
        helper('qr');

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

        // Validasi kelengkapan data siswa (harus 100% atau sudah terverifikasi)
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);
        if ($completionData['percentage'] < 100 && ($siswa['status_verifikasi'] ?? '') !== 'Terverifikasi') {
            session()->setFlashdata('error', 'Silakan lengkapi biodata pendaftaran hingga 100% untuk dapat mencetak Kartu Tanda Peserta.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $webModel     = new TblWebModel();
        $layoutModel  = new LayoutKartuModel();
        $qrModel      = new SettingQrModel();
        $ttdModel     = new TandaTanganModel();
        $printerModel = new SettingPrinterModel();
        $berkasModel  = new BerkasModel();

        // Cari foto siswa dari berkas upload
        $berkasFoto = $berkasModel->where('id_siswa', $siswa['id_siswa'])
                                  ->where('jenis_berkas', 'foto')
                                  ->orderBy('created_at', 'DESC')
                                  ->first();
        if ($berkasFoto) {
            $siswa['foto_berkas'] = $berkasFoto['path_file'];
        }

        $data = [
            'siswa'    => $siswa,
            'instansi' => $webModel->first() ?? [],
            'layout'   => $layoutModel->first() ?? [],
            'qr'       => $qrModel->first() ?? [],
            'ttd'      => $ttdModel->first() ?? [],
            'printer'  => $printerModel->first() ?? [],
        ];

        return view('siswa/cetak_kartu', $data);
    }
}
