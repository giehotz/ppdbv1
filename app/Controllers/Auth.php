<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TblWebModel;
use App\Models\ResetPasswordModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            $userType = session()->get('user_type');
            if ($userType === 'verifikato') {
                return redirect()->to('/verifikator/dashboard');
            } elseif ($userType === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/siswa/dashboard');
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

    public function login()
    {
        $session = session();
        $identifier = $this->request->getVar('username'); // Can be username, NISN, or no_pendaftaran
        $password = $this->request->getVar('password');

        // Try admin login first
        $userModel = new UserModel();
        $admin = $userModel->where('username', $identifier)->first();

        if ($admin) {
            $verify_pass = password_verify($password, $admin['password']);
            if ($verify_pass) {
                // Update last_login
                $userModel->update($admin['id_user'], ['last_login' => date('Y-m-d H:i:s')]);

                $ses_data = [
                    'id_user'       => $admin['id_user'],
                    'username'      => $admin['username'],
                    'nama_lengkap'  => $admin['nama_lengkap'],
                    'level'         => $admin['level'],
                    'logged_in'     => TRUE,
                    'user_type'     => $admin['level'] // 'admin' or 'verifikato'
                ];
                $session->set($ses_data);

                // Catat log
                catat_log('Login', 'Berhasil login sebagai ' . ($admin['level'] === 'verifikato' ? 'Verifikator' : 'Admin'));

                if ($ses_data['level'] === 'verifikato') {
                    return redirect()->to('/verifikator/dashboard')->withCookies();
                }

                return redirect()->to('/admin/dashboard')->withCookies();
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }

        // Try student login (NISN, Email, NIK)
        $siswaModel = new \App\Models\SiswaModel();
        $siswa = $siswaModel->where('nisn', $identifier)
            ->orWhere('email', $identifier)
            ->orWhere('nik', $identifier)
            ->first();

        if ($siswa) {
            $verify_pass = password_verify($password, $siswa['password']);
            if ($verify_pass) {
                // Update last_login
                $siswaModel->update($siswa['id_siswa'], ['last_login' => date('Y-m-d H:i:s')]);
                $ses_data = [
                    'id_siswa'       => $siswa['id_siswa'],
                    'no_pendaftaran' => $siswa['no_pendaftaran'],
                    'nisn'           => $siswa['nisn'],
                    'nama_lengkap'   => $siswa['nama_lengkap'],
                    'email'          => $siswa['email'],
                    'foto'           => $siswa['foto'], // Added for header photo display
                    'logged_in'      => TRUE,
                    'user_type'      => 'siswa'
                ];
                $session->set($ses_data);

                // Catat log
                catat_log('Login', 'Berhasil login sebagai calon siswa');
                return redirect()->to('/siswa/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }

        $session->setFlashdata('msg', 'Username/Email/NISN/NIK tidak ditemukan');
        return redirect()->to('/login');
    }


    public function logout()
    {
        $session = session();
        
        // Catat log sebelum session dihapus
        if ($session->get('logged_in')) {
            catat_log('Logout', 'Berhasil keluar dari sistem');
        }

        $session->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            $userType = session()->get('user_type');
            if ($userType === 'verifikato') {
                return redirect()->to('/verifikator/dashboard');
            } elseif ($userType === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/siswa/dashboard');
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

        $siswaModel = new \App\Models\SiswaModel();
        $session = session();

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nisn' => 'required|numeric|min_length[10]|max_length[10]|is_unique[tbl_siswa.nisn]',
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[tbl_siswa.email]',
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
        $db->transStart();

        // Insert initial data dengan temporary no_pendaftaran
        $data = [
            'no_pendaftaran' => 'TEMP-' . uniqid(),
            'nisn' => $this->request->getPost('nisn'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'tgl_siswa' => date('Y-m-d H:i:s'),
            'status_verifikasi' => 'Menunggu'
        ];

        // Eksekusi insert, CI4 akan mengembalikan Insert ID dari DB
        $insertId = $siswaModel->insert($data);
        $no_pendaftaran = '';

        if ($insertId) {
            // Setelah insert ID didapat secara absolut dari MySQL, susun no_pendaftaran permanen
            $tblWebModel = new TblWebModel();
            $web = $tblWebModel->find(1);
            $format = !empty($web['format_no_daftar']) ? $web['format_no_daftar'] : 'PPDB-{TAHUN}-{URUT}';
            
            $year = date('Y');
            $month = date('m');
            $newNumber = str_pad($insertId, 4, '0', STR_PAD_LEFT);
            
            // Replace placeholders
            $no_pendaftaran = str_replace(
                ['{TAHUN}', '{BULAN}', '{URUT}'], 
                [$year, $month, $newNumber], 
                $format
            );

            // Perbarui record dengan nomor pendaftaran yang benar & permanen
            $siswaModel->update($insertId, ['no_pendaftaran' => $no_pendaftaran]);
        }

        // Selesaikan Transaksi
        $db->transComplete();

        if ($db->transStatus() === false) {
            $session->setFlashdata('error', 'Registrasi gagal karena kendala sistem. Silakan coba lagi nanti.');
            return redirect()->to('/auth/register')->withInput();
        } else {
        $session->setFlashdata('success', 'Registrasi berhasil! Silakan login dengan NISN dan password Anda. Nomor Pendaftaran: ' . $no_pendaftaran);
            return redirect()->to('/login');
        }
    }

    public function submitForgotPassword()
    {
        $session = session();
        $nama = $this->request->getPost('nama');
        $nik  = $this->request->getPost('nik');

        if (empty($nama) || empty($nik)) {
            $session->setFlashdata('msg', 'Nama dan NIK wajib diisi.');
            return redirect()->to('/login');
        }

        // Cari siswa berdasar NIK
        $siswaModel = new \App\Models\SiswaModel();
        $siswa = $siswaModel->where('nik', $nik)->first();

        if (!$siswa) {
            $session->setFlashdata('msg', 'Data tidak ditemukan. Pastikan Nama dan NIK yang Anda masukkan sesuai dengan data pendaftaran.');
            return redirect()->to('/login');
        }

        // Validasi pencocokan nama dengan database (case-insensitive)
        if (strtolower(trim($nama)) !== strtolower(trim($siswa['nama_lengkap']))) {
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
