<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $activeYear = $siswaModel->getActiveThPelajaran();

        $data = [
            'total_pendaftar'     => $siswaModel->where('th_pelajaran', $activeYear)->countAllResults(),
            'menunggu_verifikasi' => $siswaModel->where('th_pelajaran', $activeYear)->groupStart()
                ->where('status_verifikasi', 'Menunggu')
                ->orWhere('status_verifikasi IS NULL')
                ->orWhere('status_verifikasi', '')
                ->groupEnd()->countAllResults(),
            'terverifikasi'       => $siswaModel->where('th_pelajaran', $activeYear)->where('status_verifikasi', 'Terverifikasi')->countAllResults(),
            'ditolak'             => $siswaModel->where('th_pelajaran', $activeYear)->where('status_verifikasi', 'Ditolak')->countAllResults(),
            'recentStudents'      => $siswaModel->where('th_pelajaran', $activeYear)->orderBy('tgl_siswa', 'DESC')->limit(5)->findAll(),
            'activeYear'          => $activeYear,
        ];

        return view('verifikator/dashboard', $data);
    }
}
