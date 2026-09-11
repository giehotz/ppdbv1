<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Impersonate extends BaseController
{
    public function start($id_siswa)
    {
        $session = session();
        
        // 1. Validasi: Hanya Admin / Verifikator yang boleh melakukan impersonate
        $userType = $session->get('user_type') ?? $session->get('level') ?? $session->get('role');
        if (!in_array($userType, ['admin', 'verifikator'])) {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        // 2. Validasi: Jangan impersonate jika sudah dalam mode impersonate
        if ($session->get('impersonator_id')) {
            return redirect()->back()->with('error', 'Anda sudah berada dalam mode menyamar. Silakan keluar dari mode ini terlebih dahulu.');
        }

        // 3. Ambil data calon siswa yang akan di-impersonate
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($id_siswa);

        if (!$siswa) {
            return redirect()->back()->with('error', 'Calon siswa tidak ditemukan.');
        }

        // 4. Simpan sesi asli (admin/verifikator) ke variabel sementara
        $session->set([
            'impersonator_id'       => $session->get('id_user'),
            'impersonator_username' => $session->get('username'),
            'impersonator_nama'     => $session->get('nama'),
            'impersonator_nama_lengkap' => $session->get('nama_lengkap'),
            'impersonator_level'    => $session->get('level'),
            'impersonator_role'     => $session->get('role'),
            'impersonator_foto'     => $session->get('foto'),
            'impersonator_user_type'=> $session->get('user_type'),
        ]);

        // Hapus sesi admin/verifikator saat ini (agar tidak campur aduk jika ada pengecekan id_user di layout siswa)
        $session->remove(['id_user', 'username', 'nama', 'level', 'role']);

        // 5. Timpa sesi dengan data calon siswa
        $session->set([
            'id_siswa'       => $siswa['id_siswa'],
            'no_pendaftaran' => $siswa['no_pendaftaran'],
            'nisn'           => $siswa['nisn'],
            'nama_lengkap'   => $siswa['nama_lengkap'],
            'email'          => $siswa['email'],
            'foto'           => $siswa['foto'],
            'logged_in'      => TRUE,
            'user_type'      => 'siswa'
        ]);
        
        catat_log('Impersonate', 'Menyamar sebagai calon siswa: ' . $siswa['nama_lengkap'] . ' (ID: ' . $siswa['id_siswa'] . ')');

        return redirect()->to('/siswa/dashboard')->with('success', 'Berhasil masuk sebagai ' . $siswa['nama_lengkap']);
    }

    public function startPindahan($id_pindahan)
    {
        $session = session();

        // 1. Validasi: Hanya Admin / Verifikator yang boleh melakukan impersonate
        $userType = $session->get('user_type') ?? $session->get('level') ?? $session->get('role');
        if (!in_array($userType, ['admin', 'verifikator'])) {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        // 2. Validasi: Jangan impersonate jika sudah dalam mode impersonate
        if ($session->get('impersonator_id')) {
            return redirect()->back()->with('error', 'Anda sudah berada dalam mode menyamar. Silakan keluar dari mode ini terlebih dahulu.');
        }

        // 3. Ambil data siswa pindahan yang akan di-impersonate
        $pindahanModel = new \App\Models\Pindahan\SiswaPindahanModel();
        $pindahan = $pindahanModel->find($id_pindahan);

        if (!$pindahan) {
            return redirect()->back()->with('error', 'Siswa pindahan tidak ditemukan.');
        }

        // 4. Simpan sesi asli (admin/verifikator) ke variabel sementara
        $session->set([
            'impersonator_id'       => $session->get('id_user'),
            'impersonator_username' => $session->get('username'),
            'impersonator_nama'     => $session->get('nama'),
            'impersonator_nama_lengkap' => $session->get('nama_lengkap'),
            'impersonator_level'    => $session->get('level'),
            'impersonator_role'     => $session->get('role'),
            'impersonator_foto'     => $session->get('foto'),
            'impersonator_user_type'=> $session->get('user_type'),
            'impersonator_return'   => $userType === 'admin' ? '/admin/pindahan' : '/verifikator/pindahan',
        ]);

        // Hapus sesi admin/verifikator saat ini (agar tidak campur aduk jika ada pengecekan id_user di layout siswa)
        $session->remove(['id_user', 'username', 'nama', 'level', 'role']);

        // 5. Timpa sesi dengan data siswa pindahan
        $session->set([
            'id_siswa'       => $pindahan['id_pindahan'],
            'no_pendaftaran' => $pindahan['no_pendaftaran'],
            'nisn'           => $pindahan['nisn'],
            'nama_lengkap'   => $pindahan['nama_lengkap'],
            'email'          => $pindahan['email'],
            'foto'           => $pindahan['foto'],
            'logged_in'      => TRUE,
            'user_type'      => 'siswa_pindahan'
        ]);

        catat_log('Impersonate', 'Menyamar sebagai siswa pindahan: ' . $pindahan['nama_lengkap'] . ' (ID: ' . $pindahan['id_pindahan'] . ')');

        return redirect()->to('/siswa/pindahan/dashboard')->with('success', 'Berhasil masuk sebagai ' . $pindahan['nama_lengkap']);
    }

    public function stop()
    {
        $session = session();

        // 1. Validasi: Pastikan memang sedang impersonate
        if (!$session->get('impersonator_id')) {
            return redirect()->to('/login');
        }

        $impersonatorLevel = $session->get('impersonator_level');

        // 2. Bersihkan sesi siswa
        $session->remove(['id_siswa', 'no_pendaftaran', 'nisn', 'email']);

        // 3. Kembalikan sesi asli admin/verifikator
        $session->set([
            'id_user'      => $session->get('impersonator_id'),
            'username'     => $session->get('impersonator_username'),
            'nama'         => $session->get('impersonator_nama'),
            'nama_lengkap' => $session->get('impersonator_nama_lengkap'),
            'level'        => $impersonatorLevel,
            'role'         => $session->get('impersonator_role'),
            'foto'         => $session->get('impersonator_foto'),
            'user_type'    => $session->get('impersonator_user_type'),
            'logged_in'    => TRUE
        ]);

        // 4. Hapus variabel impersonator
        $session->remove([
            'impersonator_id',
            'impersonator_username',
            'impersonator_nama',
            'impersonator_nama_lengkap',
            'impersonator_level',
            'impersonator_role',
            'impersonator_foto',
            'impersonator_user_type'
        ]);

        catat_log('Impersonate Exit', 'Berhenti menyamar dan kembali ke akun asli');

        // Redirect kembali ke halaman asal (admin/verifikator/pindahan)
        $returnUrl = $session->get('impersonator_return');
        if ($returnUrl) {
            $session->remove('impersonator_return');
            return redirect()->to($returnUrl)->with('success', 'Berhasil kembali ke akun Anda.');
        }
        $redirectUrl = ($impersonatorLevel === 'verifikator') ? '/verifikator/siswa' : '/admin/siswa';
        
        return redirect()->to($redirectUrl)->with('success', 'Berhasil kembali ke akun Anda.');
    }
}
