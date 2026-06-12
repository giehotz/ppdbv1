<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Status extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/logout');
        }

        // Determine registration status based on verification status
        $statusInfo = $this->getStatusInfo($siswa['status_verifikasi']);
        
        // Calculate completion percentage
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);

        $data = [
            'siswa' => $siswa,
            'statusInfo' => $statusInfo,
            'completionPercentage' => $completionData['percentage']
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/status', $data);
        }

        return view('siswa/status/index', $data);
    }

    private function getStatusInfo($statusVerifikasi)
    {
        $statusMap = [
            'Menunggu' => [
                'badge' => 'warning',
                'icon' => 'fa-clock',
                'text' => 'Menunggu Verifikasi',
                'description' => 'Pendaftaran Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu.',
                'color' => 'yellow'
            ],
            'Terverifikasi' => [
                'badge' => 'success',
                'icon' => 'fa-check-circle',
                'text' => 'Terverifikasi',
                'description' => 'Selamat! Pendaftaran Anda telah diverifikasi. Silakan lengkapi dokumen yang diperlukan.',
                'color' => 'green'
            ],
            'Ditolak' => [
                'badge' => 'danger',
                'icon' => 'fa-times-circle',
                'text' => 'Ditolak',
                'description' => 'Maaf, pendaftaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
                'color' => 'red'
            ],
            // Fallback for old data mappings
            'pending' => [
                'badge' => 'warning',
                'icon' => 'fa-clock',
                'text' => 'Menunggu Verifikasi',
                'description' => 'Pendaftaran Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu.',
                'color' => 'yellow'
            ],
            'verified' => [
                'badge' => 'success',
                'icon' => 'fa-check-circle',
                'text' => 'Terverifikasi',
                'description' => 'Selamat! Pendaftaran Anda telah diverifikasi. Silakan lengkapi dokumen yang diperlukan.',
                'color' => 'green'
            ],
            'rejected' => [
                'badge' => 'danger',
                'icon' => 'fa-times-circle',
                'text' => 'Ditolak',
                'description' => 'Maaf, pendaftaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
                'color' => 'red'
            ]
        ];

        // Default to 'Menunggu' if not found
        return $statusMap[$statusVerifikasi] ?? $statusMap['Menunggu'];
    }
}
