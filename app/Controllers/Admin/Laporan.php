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
        $activeTh = $this->laporanModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;

        $data = [
            'statistik'  => $this->laporanModel->getStatistikUmum($selectedTh),
            'kelulusan'  => $this->laporanModel->getKelulusan($selectedTh),
            'gender'     => $this->laporanModel->getGenderStats($selectedTh),
            'jalur'      => $this->laporanModel->getJalurPendaftaranStats($selectedTh),
            'topSekolah' => $this->laporanModel->getTopSekolah($selectedTh),
            'topWilayah' => $this->laporanModel->getTopWilayah($selectedTh),
            'selectedTh' => $selectedTh,
            'activeTh'   => $activeTh,
        ];

        return view('admin/laporan/index', $data);
    }

    public function cetak()
    {
        $activeTh = $this->laporanModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;

        $query = $this->laporanModel->orderBy('tgl_siswa', 'ASC');
        if ($selectedTh !== 'all') {
            $query->where('th_pelajaran', $selectedTh);
        }

        $data = [
            'semua_siswa' => $query->findAll(),
            'statistik'   => $this->laporanModel->getStatistikUmum($selectedTh),
            'kelulusan'   => $this->laporanModel->getKelulusan($selectedTh),
            'gender'      => $this->laporanModel->getGenderStats($selectedTh),
            'jalur'       => $this->laporanModel->getJalurPendaftaranStats($selectedTh),
            'topSekolah'  => $this->laporanModel->getTopSekolah($selectedTh),
            'topWilayah'  => $this->laporanModel->getTopWilayah($selectedTh),
            'waktu_cetak' => date('d-m-Y H:i:s'),
            'dicetak_oleh'=> session()->get('nama_lengkap') ?? 'Administrator',
            'selectedTh'  => $selectedTh,
            'activeTh'    => $activeTh,
        ];

        return view('admin/laporan/cetak_pdf', $data);
    }
}
