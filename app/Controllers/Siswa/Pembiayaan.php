<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TagihanSiswaModel;
use App\Models\PembayaranModel;
use App\Libraries\PdfGenerator;

class Pembiayaan extends BaseController
{
    protected $siswaModel;
    protected $tagihanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->siswaModel     = new SiswaModel();
        $this->tagihanModel   = new TagihanSiswaModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $idSiswa = session()->get('id_siswa');
        $siswa = $this->siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/siswa/dashboard');
        }

        $tagihan       = $this->tagihanModel->getTagihanBySiswa($idSiswa);
        $totalTagihan  = $this->tagihanModel->getTotalTagihan($idSiswa);
        $totalLunas    = $this->tagihanModel->getTotalLunas($idSiswa);
        $statusLunas   = $this->tagihanModel->isAllLunas($idSiswa);
        $unpaidItems   = $this->tagihanModel->getUnpaidItems($idSiswa);
        $riwayatBayar  = $this->pembayaranModel->getRiwayatBySiswa($idSiswa);

        $data = [
            'siswa'         => $siswa,
            'tagihan'       => $tagihan,
            'totalTagihan'  => $totalTagihan,
            'totalLunas'    => $totalLunas,
            'statusLunas'   => $statusLunas,
            'unpaidItems'   => $unpaidItems,
            'riwayatBayar'  => $riwayatBayar,
        ];

        return view('siswa/pembiayaan', $data);
    }

    public function kuitansi()
    {
        $idSiswa = session()->get('id_siswa');
        $siswa = $this->siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/siswa/dashboard');
        }

        $statusLunas = $this->tagihanModel->isAllLunas($idSiswa);

        if (!$statusLunas) {
            session()->setFlashdata('error', 'Pembayaran belum lunas. Kuitansi hanya tersedia setelah semua tagihan terbayar.');
            return redirect()->to('/siswa/pembiayaan');
        }

        $tagihan      = $this->tagihanModel->getTagihanBySiswa($idSiswa);
        $totalTagihan = $this->tagihanModel->getTotalTagihan($idSiswa);
        $totalLunas   = $this->tagihanModel->getTotalLunas($idSiswa);
        $riwayatBayar = $this->pembayaranModel->getRiwayatBySiswa($idSiswa);

        $pdf = new PdfGenerator();
        $pdf->generate('siswa/kuitansi_pdf', [
            'siswa'         => $siswa,
            'tagihan'       => $tagihan,
            'totalTagihan'  => $totalTagihan,
            'totalLunas'    => $totalLunas,
            'riwayatBayar'  => $riwayatBayar,
        ], 'kuitansi_' . $siswa['no_pendaftaran'] . '.pdf');
    }
}
