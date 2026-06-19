<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        $data = [
            'statistik'  => $this->laporanModel->getStatistikUmum(),
            'kelulusan'  => $this->laporanModel->getKelulusan(),
            'gender'     => $this->laporanModel->getGenderStats(),
            'jalur'      => $this->laporanModel->getJalurPendaftaranStats(),
            'topSekolah' => $this->laporanModel->getTopSekolah(),
            'topWilayah' => $this->laporanModel->getTopWilayah(),
        ];

        return view('admin/laporan/index', $data);
    }

    public function cetak()
    {
        $data = [
            'semua_siswa'=> $this->laporanModel->orderBy('tgl_siswa', 'ASC')->findAll(),
            'statistik'  => $this->laporanModel->getStatistikUmum(),
            'kelulusan'  => $this->laporanModel->getKelulusan(),
            'gender'     => $this->laporanModel->getGenderStats(),
            'jalur'      => $this->laporanModel->getJalurPendaftaranStats(),
            'topSekolah' => $this->laporanModel->getTopSekolah(),
            'topWilayah' => $this->laporanModel->getTopWilayah(),
            'waktu_cetak'=> date('d-m-Y H:i:s'),
            'dicetak_oleh'=> session()->get('nama_lengkap') ?? 'Administrator'
        ];

        return view('admin/laporan/cetak_pdf', $data);
    }
}
