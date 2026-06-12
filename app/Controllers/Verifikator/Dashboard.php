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

        $data = [
            'total_pendaftar' => $siswaModel->countAllResults(),
            'menunggu_verifikasi' => $siswaModel->where('status_verifikasi', 'Menunggu')->countAllResults(),
            'terverifikasi' => $siswaModel->where('status_verifikasi', 'Terverifikasi')->countAllResults(),
            'ditolak' => $siswaModel->where('status_verifikasi', 'Ditolak')->countAllResults(),
            'recentStudents' => $siswaModel->orderBy('tgl_siswa', 'DESC')->limit(5)->findAll(),
        ];

        return view('verifikator/dashboard', $data);
    }
}
