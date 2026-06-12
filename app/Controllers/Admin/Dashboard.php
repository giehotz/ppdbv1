<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get statistics
        $totalPendaftar = $siswaModel->countAll();
        $terverifikasi = $siswaModel->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $pending = $siswaModel->where('status_verifikasi', 'Menunggu')->orWhere('status_verifikasi IS NULL')->countAllResults();
        $tidakLulus = 0; // Column status_lulus doesn't exist yet in schema
        // Get recent 5 students
        $recentStudents = $siswaModel->orderBy('tgl_siswa', 'DESC')->limit(5)->findAll();

        $userModel = new \App\Models\UserModel();
        // Get 5 users who logged in most recently
        $adminUsers = $userModel->select('id_user as id, nama_lengkap, level, last_login')
            ->where('last_login IS NOT NULL')
            ->orderBy('last_login', 'DESC')
            ->limit(5)
            ->findAll();

        // Get 5 students who logged in most recently
        $siswaUsers = $siswaModel->select('id_siswa as id, nama_lengkap, last_login')
            ->where('last_login IS NOT NULL')
            ->orderBy('last_login', 'DESC')
            ->limit(5)
            ->findAll();

        // Add level 'siswa' to students
        foreach ($siswaUsers as &$su) {
            $su['level'] = 'siswa';
        }
        unset($su);

        // Merge both arrays
        $activeUsers = array_merge($adminUsers, $siswaUsers);

        // Sort descending by last_login
        usort($activeUsers, function ($a, $b) {
            return strtotime($b['last_login']) - strtotime($a['last_login']);
        });

        // Limit to 5 total records
        $activeUsers = array_slice($activeUsers, 0, 5);

        $data = [
            'totalPendaftar' => $totalPendaftar,
            'terverifikasi' => $terverifikasi,
            'pending' => $pending,
            'tidakLulus' => $tidakLulus,
            'recentStudents' => $recentStudents,
            'activeUsers' => $activeUsers
        ];

        return view('admin/dashboard', $data);
    }
}
