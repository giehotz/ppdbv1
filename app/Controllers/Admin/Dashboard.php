<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\PengumumanModel;
use App\Models\UnlockRequestModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $pengumumanModel = new PengumumanModel();

        // Main stat cards
        $totalPendaftar = $siswaModel->countAll();
        $terverifikasi  = $siswaModel->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $pending        = $siswaModel->groupStart()
            ->where('status_verifikasi', 'Menunggu')
            ->orWhere('status_verifikasi IS NULL')
            ->groupEnd()->countAllResults();
        $ditolak        = $siswaModel->where('status_verifikasi', 'Ditolak')->countAllResults();
        $lulus          = $siswaModel->where('status_lulus', 'Lulus')->countAllResults();

        // Mini stats
        $lakiLaki  = $siswaModel->where('jk', 'L')->countAllResults();
        $perempuan = $siswaModel->where('jk', 'P')->countAllResults();
        $pengumumanAktif = $pengumumanModel->where('is_active', 1)->countAll();

        // Berkas stats
        $db = \Config\Database::connect();
        $berkasMasuk  = $db->table('tbl_berkas')->countAll();
        $berkasValid  = $db->table('tbl_berkas')->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $berkasInvalid = $db->table('tbl_berkas')->where('status_verifikasi', 'Ditolak')->countAllResults();

        // Registration trend (last 7 days)
        $trendRaw = $siswaModel
            ->select("DATE(tgl_siswa) as tgl, COUNT(*) as jumlah")
            ->where('tgl_siswa >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
            ->groupBy('DATE(tgl_siswa)')
            ->orderBy('tgl', 'ASC')
            ->findAll();
        $trendLabels = [];
        $trendData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $trendLabels[] = date('d M', strtotime($date));
            $found = 0;
            foreach ($trendRaw as $r) {
                if ($r['tgl'] === $date) { $found = (int)$r['jumlah']; break; }
            }
            $trendData[] = $found;
        }

        // Top schools (top 5)
        $topSchools = $siswaModel
            ->select('nama_sekolah, COUNT(*) as jumlah')
            ->where('nama_sekolah IS NOT NULL')
            ->where('nama_sekolah !=', '')
            ->groupBy('nama_sekolah')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->findAll();

        // Registration channels
        $jalurOnline  = $siswaModel->where('jalur_pendaftaran', 'Online')->countAllResults();
        $jalurOffline = $siswaModel->where('jalur_pendaftaran', 'Offline')->countAllResults();

        // Recent 5 students
        $recentStudents = $siswaModel->orderBy('tgl_siswa', 'DESC')->limit(5)->findAll();

        // Recent activity logins
        $userModel = new \App\Models\UserModel();
        $adminUsers = $userModel->select('id_user as id, nama_lengkap, level, last_login')
            ->where('last_login IS NOT NULL')->orderBy('last_login', 'DESC')->limit(5)->findAll();
        $siswaUsers = $siswaModel->select('id_siswa as id, nama_lengkap, last_login')
            ->where('last_login IS NOT NULL')->orderBy('last_login', 'DESC')->limit(5)->findAll();
        foreach ($siswaUsers as &$su) { $su['level'] = 'siswa'; }
        unset($su);
        $activeUsers = array_merge($adminUsers, $siswaUsers);
        usort($activeUsers, fn($a, $b) => strtotime($b['last_login']) - strtotime($a['last_login']));
        $activeUsers = array_slice($activeUsers, 0, 5);

        // Pending unlock requests count
        $unlockModel = new UnlockRequestModel();
        $pendingUnlock = $unlockModel->getPendingCount();

        // Latest announcements
        $latestAnnouncements = $pengumumanModel->where('is_active', 1)
            ->orderBy('publish_date', 'DESC')->limit(3)->findAll();

        $data = [
            'totalPendaftar'      => $totalPendaftar,
            'terverifikasi'       => $terverifikasi,
            'pending'             => $pending,
            'ditolak'             => $ditolak,
            'lulus'               => $lulus,
            'lakiLaki'            => $lakiLaki,
            'perempuan'           => $perempuan,
            'pengumumanAktif'     => $pengumumanAktif,
            'berkasMasuk'         => $berkasMasuk,
            'berkasValid'         => $berkasValid,
            'berkasInvalid'       => $berkasInvalid,
            'trendLabels'         => $trendLabels,
            'trendData'           => $trendData,
            'topSchools'          => $topSchools,
            'jalurOnline'         => $jalurOnline,
            'jalurOffline'        => $jalurOffline,
            'recentStudents'      => $recentStudents,
            'activeUsers'         => $activeUsers,
            'pendingUnlock'       => $pendingUnlock,
            'latestAnnouncements' => $latestAnnouncements,
        ];

        return view('admin/dashboard', $data);
    }
}
