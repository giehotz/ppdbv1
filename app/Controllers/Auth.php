<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TblWebModel;
use App\Models\ResetPasswordModel;

class Auth extends BaseController
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOGIN_LOCKOUT_MINUTES = 15;
    private const MAX_FORGOT_ATTEMPTS = 3;
    private const FORGOT_LOCKOUT_MINUTES = 60;

    public function index()
    {
        if (session()->get('logged_in')) {
            $userType = session()->get('user_type') ?? session()->get('level') ?? session()->get('role');
            if ($userType === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            } elseif ($userType === 'admin') {
                return redirect()->to('/admin/dashboard')->withCookies();
            } elseif ($userType === 'siswa') {
                return redirect()->to('/siswa/dashboard')->withCookies();
            } elseif ($userType === 'siswa_pindahan') {
                return redirect()->to('/siswa/pindahan/dashboard')->withCookies();
            } else {
                session()->destroy();
            }
        }
        return view('auth/login');
    }

    private function checkPpdbStatus()
    {
        $tblWebModel = new TblWebModel();
        $web = $tblWebModel->find(1);

        if ($web && $web['status_ppdb'] !== 'Buka') {
            return false;
        }
        return true;
    }

    private function getClientIp(): string
    {
        $ip = $this->request->getIPAddress();
        return $ip ?: '0.0.0.0';
    }

    private function throttleKey(string $prefix): string
    {
        $ip = $this->getClientIp();
        return $prefix . str_replace(['{','}','(',')','/','\\','@',':'], '_', $ip);
    }

    private function isThrottled(string $key, int $maxAttempts, int $lockoutMinutes): bool
    {
        $cache = \Config\Services::cache();
        $attempts = (int) $cache->get($key);
        if ($attempts >= $maxAttempts) {
            return true;
        }
        return false;
    }

    private function incrementAttempt(string $key, int $lockoutMinutes): int
    {
        $cache = \Config\Services::cache();
        $attempts = (int) $cache->get($key);
        $attempts++;
        $cache->save($key, $attempts, $lockoutMinutes * 60);
        return $attempts;
    }

    private function clearAttempts(string $key): void
    {
        $cache = \Config\Services::cache();
        $cache->delete($key);
    }

    public function login()
    {
        $session = session();
        $throttleKey = $this->throttleKey('login_attempts_');

        // Check throttle
        if ($this->isThrottled($throttleKey, self::MAX_LOGIN_ATTEMPTS, self::LOGIN_LOCKOUT_MINUTES)) {
            $session->setFlashdata('msg', 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . self::LOGIN_LOCKOUT_MINUTES . ' menit.');
            return redirect()->to('/login');
        }

        $identifier = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Try admin login first
        $userModel = new UserModel();
        $admin = $userModel->where('username', $identifier)->first();

        if ($admin) {
            $verify_pass = password_verify($password, $admin['password']);
            if ($verify_pass) {
                $this->clearAttempts($throttleKey);
                $userModel->update($admin['id_user'], ['last_login' => date('Y-m-d H:i:s')]);

                $ses_data = [
                    'id_user'       => $admin['id_user'],
                    'username'      => $admin['username'],
                    'nama'          => $admin['nama_lengkap'] ?? $admin['username'],
                    'nama_lengkap'  => $admin['nama_lengkap'],
                    'level'         => $admin['level'],
                    'role'          => $admin['level'],
                    'foto'          => $admin['foto'] ?? null,
                    'logged_in'     => TRUE,
                    'user_type'     => $admin['level']
                ];
                $session->set($ses_data);
                $session->regenerate();

                catat_log('Login', 'Berhasil login sebagai ' . ($admin['level'] === 'verifikator' ? 'Verifikator' : 'Admin'));

                if ($ses_data['level'] === 'verifikator') {
                    return redirect()->to('/verifikator/dashboard')->withCookies();
                }

                return redirect()->to('/admin/dashboard')->withCookies();
            } else {
                $this->incrementAttempt($throttleKey, self::LOGIN_LOCKOUT_MINUTES);
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }

        // Try student login — gunakan query terpisah agar index nisn/email/nik digunakan
        $siswaModel = new \App\Models\SiswaModel();
        $siswa = $siswaModel->where('nisn', $identifier)->first();
        if (!$siswa) {
            $siswa = $siswaModel->where('email', $identifier)->first();
        }
        if (!$siswa) {
            $siswa = $siswaModel->where('nik', $identifier)->first();
        }

        if ($siswa) {
            $verify_pass = password_verify($password, $siswa['password']);
            if ($verify_pass) {
                $this->clearAttempts($throttleKey);
                $siswaModel->update($siswa['id_siswa'], ['last_login' => date('Y-m-d H:i:s')]);
                $ses_data = [
                    'id_siswa'       => $siswa['id_siswa'],
                    'no_pendaftaran' => $siswa['no_pendaftaran'],
                    'nisn'           => $siswa['nisn'],
                    'nama_lengkap'   => $siswa['nama_lengkap'],
                    'email'          => $siswa['email'],
                    'foto'           => $siswa['foto'],
                    'logged_in'      => TRUE,
                    'user_type'      => 'siswa'
                ];
                $session->set($ses_data);
                $session->regenerate();

                catat_log('Login', 'Berhasil login sebagai calon siswa baru');
                return redirect()->to('/siswa/dashboard');
            } else {
                $this->incrementAttempt($throttleKey, self::LOGIN_LOCKOUT_MINUTES);
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }

        // Try siswa pindahan login — berdiri sendiri di tabel tbl_siswa_pindahan
        $pindahanModel = new \App\Models\Pindahan\SiswaPindahanModel();
        $pindahan = $pindahanModel->where('nisn', $identifier)->first();
        if (!$pindahan) {
            $pindahan = $pindahanModel->where('email', $identifier)->first();
        }
        if (!$pindahan) {
            $pindahan = $pindahanModel->where('nik', $identifier)->first();
        }

        if ($pindahan) {
            $verify_pass = password_verify($password, $pindahan['password']);
            if ($verify_pass) {
                $this->clearAttempts($throttleKey);
                $pindahanModel->update($pindahan['id_pindahan'], ['last_login' => date('Y-m-d H:i:s')]);
                $ses_data = [
                    'id_siswa'       => $pindahan['id_pindahan'],
                    'no_pendaftaran' => $pindahan['no_pendaftaran'],
                    'nisn'           => $pindahan['nisn'],
                    'nama_lengkap'   => $pindahan['nama_lengkap'],
                    'email'          => $pindahan['email'],
                    'foto'           => $pindahan['foto'],
                    'logged_in'      => TRUE,
                    'user_type'      => 'siswa_pindahan'
                ];
                $session->set($ses_data);
                $session->regenerate();

                catat_log('Login', 'Berhasil login sebagai calon siswa pindahan');
                return redirect()->to('/siswa/pindahan/dashboard');
            } else {
                $this->incrementAttempt($throttleKey, self::LOGIN_LOCKOUT_MINUTES);
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }

        $this->incrementAttempt($throttleKey, self::LOGIN_LOCKOUT_MINUTES);
        $session->setFlashdata('msg', 'Username/Email/NISN/NIK tidak ditemukan');
        return redirect()->to('/login');
    }


    public function logout()
    {
        $session = session();
        
        // Catat log aktivitas sebelum session dibersihkan
        if ($session->get('logged_in')) {
            try {
                catat_log('Logout', 'Berhasil keluar dari sistem');
            } catch (\Throwable $e) {
                // Abaikan jika database log tidak dapat diakses saat logout
            }
        }

        // Hapus seluruh variabel session
        $session->destroy();

        // Cegah caching halaman terautentikasi di browser
        $response = service('response');
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->setHeader('Pragma', 'no-cache');

        return redirect()->to('/login')->withCookies();
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            $userType = session()->get('user_type') ?? session()->get('level') ?? session()->get('role');
            if ($userType === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            } elseif ($userType === 'admin') {
                return redirect()->to('/admin/dashboard')->withCookies();
            } elseif ($userType === 'siswa') {
                return redirect()->to('/siswa/dashboard')->withCookies();
            } elseif ($userType === 'siswa_pindahan') {
                return redirect()->to('/siswa/pindahan/dashboard')->withCookies();
            } else {
                session()->destroy();
            }
        }

        if (!$this->checkPpdbStatus()) {
            return view('auth/register_closed');
        }

        return view('auth/register');
    }

    public function doRegister()
    {
        if (!$this->checkPpdbStatus()) {
            return redirect()->to('/auth/register');
        }

        $session = session();
        $jenisPendaftaran = $this->request->getPost('jenis_pendaftaran') ?? 'baru';
        if (!in_array($jenisPendaftaran, ['baru', 'pindahan'], true)) {
            $jenisPendaftaran = 'baru';
        }

        // Validation rules — tabel tujuan tergantung jenis pendaftaran
        $tableTarget = $jenisPendaftaran === 'pindahan' ? 'tbl_siswa_pindahan' : 'tbl_siswa';
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nisn' => 'required|numeric|min_length[10]|max_length[10]|is_unique[' . $tableTarget . '.nisn]',
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[' . $tableTarget . '.email]',
            'no_hp' => 'required|numeric',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $session->setFlashdata('errors', $validation->getErrors());
            return redirect()->to('/auth/register')->withInput();
        }

        // Mencegah Race Condition: Gunakan Transaksi DB dan manfaatkan Auto-Increment ID
        $db = \Config\Database::connect();
        $tblWebModel = new TblWebModel();
        $web = $tblWebModel->find(1);
        $thPelajaran = !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';

        $tglPendaftaran = date('Y-m-d H:i:s');
        $noPendaftaran = '';
        $insertId = null;

        $db->transStart();

        if ($jenisPendaftaran === 'pindahan') {
            // === REGISTRASI SISWA PINDAHAN → tbl_siswa_pindahan ===
            $pindahanModel = new \App\Models\Pindahan\SiswaPindahanModel();
            $insertId = $pindahanModel->skipValidation(true)->insert([
                'no_pendaftaran'    => 'TEMP-' . uniqid(),
                'th_pelajaran'      => $thPelajaran,
                'nisn'              => $this->request->getPost('nisn'),
                'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
                'email'             => $this->request->getPost('email'),
                'no_hp'             => $this->request->getPost('no_hp'),
                'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'tgl_pindahan'      => $tglPendaftaran,
                'jalur_pendaftaran' => 'pindahan',
                'status_verifikasi' => 'Menunggu'
            ]);
        } else {
            // === REGISTRASI SISWA BARU → tbl_siswa ===
            $siswaModel = new \App\Models\SiswaModel();
            $insertId = $siswaModel->skipValidation(true)->insert([
                'no_pendaftaran'    => 'TEMP-' . uniqid(),
                'th_pelajaran'      => $thPelajaran,
                'nisn'              => $this->request->getPost('nisn'),
                'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
                'email'             => $this->request->getPost('email'),
                'no_hp'             => $this->request->getPost('no_hp'),
                'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'tgl_siswa'         => $tglPendaftaran,
                'status_verifikasi' => 'Menunggu'
            ]);
        }

        if ($insertId) {
            // Susun no_pendaftaran permanen dari Auto-Increment ID
            $format = !empty($web['format_no_daftar']) ? $web['format_no_daftar'] : 'PPDB-{TAHUN}-{URUT}';
            $year  = !empty($web['th_pelajaran']) ? substr($web['th_pelajaran'], 0, 4) : date('Y');
            $month = date('m');
            $newNumber = str_pad($insertId, 4, '0', STR_PAD_LEFT);
            $noPendaftaran = str_replace(
                ['{TAHUN}', '{BULAN}', '{URUT}'],
                [$year, $month, $newNumber],
                $format
            );

            if ($jenisPendaftaran === 'pindahan') {
                $pindahanModel->update($insertId, ['no_pendaftaran' => $noPendaftaran]);
            } else {
                $siswaModel->update($insertId, ['no_pendaftaran' => $noPendaftaran]);
            }

            // Catat ke tabel registrasi (jenis pendaftaran: baru/pindahan)
            $db->table('tbl_registrasi')->insert([
                'jenis_pendaftaran' => $jenisPendaftaran,
                'no_pendaftaran'    => $noPendaftaran,
                'th_pelajaran'      => $thPelajaran,
                'nisn'              => $this->request->getPost('nisn'),
                'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
                'email'             => $this->request->getPost('email'),
                'no_hp'             => $this->request->getPost('no_hp'),
                'id_siswa'          => $jenisPendaftaran === 'baru' ? $insertId : null,
                'id_pindahan'       => $jenisPendaftaran === 'pindahan' ? $insertId : null,
                'created_at'        => $tglPendaftaran,
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            $session->setFlashdata('error', 'Registrasi gagal karena kendala sistem. Silakan coba lagi nanti.');
            return redirect()->to('/auth/register')->withInput();
        }

        $session->setFlashdata('success', 'Registrasi berhasil! Silakan login dengan NISN dan password Anda. Nomor Pendaftaran: ' . $noPendaftaran);
        return redirect()->to('/login');
    }

    public function submitForgotPassword()
    {
        $session = session();
        $throttleKey = $this->throttleKey('forgot_attempts_');

        if ($this->isThrottled($throttleKey, self::MAX_FORGOT_ATTEMPTS, self::FORGOT_LOCKOUT_MINUTES)) {
            $session->setFlashdata('msg', 'Terlalu banyak permintaan reset password. Silakan coba lagi dalam ' . self::FORGOT_LOCKOUT_MINUTES . ' menit.');
            return redirect()->to('/login');
        }

        $nama = $this->request->getPost('nama');
        $nik  = $this->request->getPost('nik');

        if (empty($nama) || empty($nik)) {
            $this->incrementAttempt($throttleKey, self::FORGOT_LOCKOUT_MINUTES);
            $session->setFlashdata('msg', 'Nama dan NIK wajib diisi.');
            return redirect()->to('/login');
        }

        // Cari siswa berdasar NIK
        $siswaModel = new \App\Models\SiswaModel();
        $siswa = $siswaModel->where('nik', $nik)->first();

        if (!$siswa) {
            $this->incrementAttempt($throttleKey, self::FORGOT_LOCKOUT_MINUTES);
            $session->setFlashdata('msg', 'Data tidak ditemukan. Pastikan Nama dan NIK yang Anda masukkan sesuai dengan data pendaftaran.');
            return redirect()->to('/login');
        }

        // Validasi pencocokan nama dengan database (case-insensitive)
        if (strtolower(trim($nama)) !== strtolower(trim($siswa['nama_lengkap']))) {
            $this->incrementAttempt($throttleKey, self::FORGOT_LOCKOUT_MINUTES);
            $session->setFlashdata('msg', 'Nama dan NIK tidak cocok dengan data yang terdaftar. Permintaan ditolak oleh sistem.');
            return redirect()->to('/login');
        }

        // Cek double request
        $resetModel = new ResetPasswordModel();
        $existing = $resetModel->where('nik', $nik)->where('status', 'Pending')->first();

        if ($existing) {
            $session->setFlashdata('msg', 'Permintaan reset password Anda sebelumnya masih diproses oleh Admin. Silakan hubungi WA admin jika belum ada balasan.');
            return redirect()->to('/login');
        }

        $this->clearAttempts($throttleKey);

        // Simpan request
        $resetModel->insert([
            'id_siswa'   => $siswa['id_siswa'],
            'nama'       => $nama,
            'nik'        => $nik,
            'status'     => 'Pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        catat_log('Reset Password Request', 'Permintaan reset password oleh siswa: ' . $nama . ' (NIK: ' . $nik . ')');

        // Ambil nomor WA admin dari landing content
        $db = \Config\Database::connect();
        $waRow = $db->table('tbl_landing_content')
            ->where('content_key', 'whatsapp_number')
            ->get()->getRowArray();
        $waAdminNumber = $waRow['content_value'] ?? '';

        return view('auth/forgot_password_success', [
            'nama' => $nama,
            'nik'  => $nik,
            'wa_admin_number' => $waAdminNumber,
        ]);
    }
}
