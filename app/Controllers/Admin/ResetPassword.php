<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ResetPasswordModel;
use App\Models\SiswaModel;

class ResetPassword extends BaseController
{
    protected $resetModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->resetModel = new ResetPasswordModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'requests' => $this->resetModel->getPendingRequests()
        ];

        return view('admin/reset_password/index', $data);
    }

    public function approve($id)
    {
        $request = $this->resetModel->find($id);
        if (!$request) {
            session()->setFlashdata('error', 'Data permintaan tidak ditemukan.');
            return redirect()->to('/admin/reset-password');
        }

        // Generate random 12-char password
        $newPassword = bin2hex(random_bytes(6));
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->siswaModel->update($request['id_siswa'], ['password' => $hashedPassword]);

        // Update status request
        $this->resetModel->update($id, ['status' => 'Disetujui']);

        catat_log('Reset Password Approve', 'Menyetujui reset password untuk siswa: ' . $request['nama'] . ' (NIK: ' . $request['nik'] . ')');

        // Ambil data siswa untuk nomor WA
        $siswa = $this->siswaModel->find($request['id_siswa']);
        $nomorWa = $siswa['no_hp_siswa'] ?? ($siswa['no_hp_ortu'] ?? '');

        // Generate WA message
        $appUrl = base_url('/login');
        $pesan = "Halo " . ($siswa['nama_lengkap'] ?? $request['nama']) . ", permintaan reset password Anda telah disetujui.\n\n"
            . "Password baru Anda: " . $newPassword . "\n"
            . "Silakan login di: " . $appUrl . "\n\n"
            . "Catatan: Segera ganti password setelah login demi keamanan akun Anda.";

        $waUrl = '';
        if (!empty($nomorWa)) {
            $waUrl = "https://wa.me/" . $nomorWa . "?text=" . urlencode($pesan);
        }

        session()->setFlashdata('success', 'Password siswa berhasil direset menjadi <strong>' . $newPassword . '</strong>.');
        if (!empty($waUrl)) {
            session()->setFlashdata('wa_url', $waUrl);
            session()->setFlashdata('wa_nama', $siswa['nama_lengkap'] ?? $request['nama']);
        }

        return redirect()->to('/admin/reset-password');
    }

    public function reject($id)
    {
        $request = $this->resetModel->find($id);
        if (!$request) {
            session()->setFlashdata('error', 'Data permintaan tidak ditemukan.');
            return redirect()->to('/admin/reset-password');
        }

        $this->resetModel->update($id, ['status' => 'Ditolak']);

        catat_log('Reset Password Reject', 'Menolak reset password untuk siswa: ' . $request['nama'] . ' (NIK: ' . $request['nik'] . ')');

        session()->setFlashdata('success', 'Permintaan reset password ditolak.');
        return redirect()->to('/admin/reset-password');
    }
}
