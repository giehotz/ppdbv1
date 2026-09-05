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
        $activeYear = $siswaModel->getActiveThPelajaran();

        // Main stat cards (difilter berdasarkan tahun ajaran aktif)
        $totalPendaftar = $siswaModel->where('th_pelajaran', $activeYear)->countAllResults();
        $terverifikasi  = $siswaModel->where('th_pelajaran', $activeYear)->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $pending        = $siswaModel->where('th_pelajaran', $activeYear)->groupStart()
            ->where('status_verifikasi', 'Menunggu')
            ->orWhere('status_verifikasi IS NULL')
            ->orWhere('status_verifikasi', '')
            ->groupEnd()->countAllResults();
        $ditolak        = $siswaModel->where('th_pelajaran', $activeYear)->where('status_verifikasi', 'Ditolak')->countAllResults();
        $lulus          = $siswaModel->where('th_pelajaran', $activeYear)->where('status_lulus', 'Lulus')->countAllResults();

        // Mini stats
        $lakiLaki  = $siswaModel->where('th_pelajaran', $activeYear)->where('jk', 'L')->countAllResults();
        $perempuan = $siswaModel->where('th_pelajaran', $activeYear)->where('jk', 'P')->countAllResults();
        $pengumumanAktif = $pengumumanModel->where('is_active', 1)->countAll();

        // Berkas stats (difilter berdasarkan siswa tahun ajaran aktif)
        $db = \Config\Database::connect();
        $berkasMasuk   = $db->table('tbl_berkas')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_berkas.id_siswa')
            ->where('tbl_siswa.th_pelajaran', $activeYear)
            ->where('tbl_siswa.deleted_at', null)
            ->countAllResults();
        $berkasValid   = $db->table('tbl_berkas')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_berkas.id_siswa')
            ->where('tbl_siswa.th_pelajaran', $activeYear)
            ->where('tbl_siswa.deleted_at', null)
            ->where('tbl_berkas.status_verifikasi', 'Terverifikasi')
            ->countAllResults();
        $berkasInvalid = $db->table('tbl_berkas')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_berkas.id_siswa')
            ->where('tbl_siswa.th_pelajaran', $activeYear)
            ->where('tbl_siswa.deleted_at', null)
            ->where('tbl_berkas.status_verifikasi', 'Ditolak')
            ->countAllResults();

        // Registration trend (last 7 days - tahun ajaran aktif)
        $trendRaw = $siswaModel
            ->select("DATE(tgl_siswa) as tgl, COUNT(*) as jumlah")
            ->where('th_pelajaran', $activeYear)
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

        // Top schools (top 5 - tahun ajaran aktif)
        $topSchools = $siswaModel
            ->select('nama_sekolah, COUNT(*) as jumlah')
            ->where('th_pelajaran', $activeYear)
            ->where('nama_sekolah IS NOT NULL')
            ->where('nama_sekolah !=', '')
            ->groupBy('nama_sekolah')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->findAll();

        // Registration channels
        $jalurOnline  = $siswaModel->where('th_pelajaran', $activeYear)->where('jalur_pendaftaran', 'Online')->countAllResults();
        $jalurOffline = $siswaModel->where('th_pelajaran', $activeYear)->where('jalur_pendaftaran', 'Offline')->countAllResults();

        // Recent 5 students
        $recentStudents = $siswaModel->where('th_pelajaran', $activeYear)->orderBy('tgl_siswa', 'DESC')->limit(5)->findAll();

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
            'activeYear'          => $activeYear,
        ];

        return view('admin/dashboard', $data);
    }
}
