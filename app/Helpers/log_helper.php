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

        // Deteksi role dan nama berdasar session
        if ($session->get('logged_in')) {
            // Jika Admin / Verifikator
            $role = strtolower($session->get('role'));
            $nama_user = $session->get('nama_lengkap');
        } elseif ($session->get('is_siswa')) {
            // Jika Calon Siswa
            $role = 'siswa';
            // Siswa might not have 'nama_lengkap' directly but 'nama_lengkap' from tbl_siswa if registered. Let's try 'nama_lengkap' or 'username' or session ID
            $nama_user = $session->get('nama_lengkap') ?? ($session->get('username') ?? 'Siswa User');
        }

        $data = [
            'role'       => $role,
            'nama_user'  => $nama_user,
            'tindakan'   => $tindakan,
            'keterangan' => $keterangan,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => substr((string)$request->getUserAgent(), 0, 255), // truncate if too long
            'created_at' => date('Y-m-d H:i:s'),
        ];

        return $db->table('log_aktivitas')->insert($data);
    }
}
