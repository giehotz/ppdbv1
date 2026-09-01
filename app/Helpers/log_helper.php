<?php

if (!function_exists('catat_log')) {
    /**
     * Menyimpan log aktivitas user ke database.
     * Mengambil role, nama, IP, dan user agent otomatis.
     * 
     * @param string $tindakan Nama tindakan singkat (misal: 'Login', 'Update Biodata')
     * @param string $keterangan Deskripsi detail tindakan
     * @return bool
     */
    function catat_log($tindakan, $keterangan = '')
    {
        $request = \Config\Services::request();
        $session = session();
        $db      = \Config\Database::connect();

        $role = 'system';
        $nama_user = 'System';

        // Deteksi role dan nama berdasar session dengan safe null fallback
        if ($session->get('logged_in')) {
            $userType  = $session->get('user_type') ?? $session->get('role') ?? $session->get('level') ?? 'user';
            $role      = strtolower((string)$userType);
            $nama_user = $session->get('nama_lengkap') ?? $session->get('nama') ?? $session->get('username') ?? 'Pengguna';
        } elseif ($session->get('is_siswa')) {
            $role      = 'siswa';
            $nama_user = $session->get('nama_lengkap') ?? $session->get('username') ?? 'Siswa';
        }

        $data = [
            'role'       => $role ?: 'user',
            'nama_user'  => $nama_user ?: 'User',
            'tindakan'   => $tindakan,
            'keterangan' => $keterangan,
            'ip_address' => $request->getIPAddress() ?: '0.0.0.0',
            'user_agent' => substr(preg_replace('/[^\x20-\x7E\s]/', '', (string)$request->getUserAgent()), 0, 128),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        try {
            return $db->table('log_aktivitas')->insert($data);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
