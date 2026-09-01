<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\BerkasModel;

class Siswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $sortOrder = $this->request->getGet('sort') == 'DESC' ? 'DESC' : 'ASC';

        $siswaList = $this->siswaModel->getStudents($search, 20, $sortOrder);

        // Add completion percentage
        foreach ($siswaList as &$s) {
            $completionData = $this->siswaModel->calculateCompletionPercentage($s);
            $s['kelengkapan'] = $completionData['percentage'];
        }

        $data = [
            'siswa' => $siswaList,
            'pager' => $this->siswaModel->pager,
            'search' => $search,
            'sort' => $sortOrder
        ];

        return view('admin/siswa/index', $data);
    }

    public function detail($id)
    {
        // Use getStudentDetail() to include verification details (JOIN)
        $student = $this->siswaModel->getStudentDetail($id);

        if (!$student) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/admin/siswa');
        }

        $completionData = $this->siswaModel->calculateCompletionPercentage($student);
        $student['kelengkapan'] = $completionData['percentage'];

        // Fetch student photo from berkas
        $berkasModel = new BerkasModel();
        $berkasFoto = $berkasModel->where('id_siswa', $id)
                                  ->where('jenis_berkas', 'foto')
                                  ->orderBy('created_at', 'DESC')
                                  ->first();

        $data = [
            'siswa' => $student,
            'berkasFoto' => $berkasFoto,
        ];

        return view('admin/siswa/detail', $data);
    }

    public function verify($id)
    {
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $verifikasiModel = new \App\Models\VerifikasiModel();

        // Check if verification record exists
        $existing = $verifikasiModel->where('id_siswa', $id)->first();

        $data = [
            'id_siswa' => $id,
            'ket' => $status, // Map status to 'ket'
            'isi' => $catatan, // Map catatan to 'isi'
            'tgl_verifikasi' => date('Y-m-d H:i:s'),
            'verifikator' => session()->get('nama_lengkap')
        ];

        if ($existing) {
            $verifikasiModel->update($existing['id_verifikasi'], $data);
        } else {
            $verifikasiModel->insert($data);
        }

        // Update student verification status
        $updateData = [
            'status_verifikasi' => $status
        ];

        // Jika Ditolak, buka kembali form pendaftaran siswa agar bisa diperbaiki
        if ($status === 'Ditolak') {
            $updateData['status_pendaftaran'] = '';
        }

        $this->siswaModel->update($id, $updateData);

        $siswaInfo = $this->siswaModel->find($id);
        $namaSiswa = $siswaInfo ? $siswaInfo['nama_lengkap'] : "ID {$id}";
        catat_log('Verifikasi Siswa', "Mengubah status verifikasi untuk $namaSiswa menjadi $status");

        session()->setFlashdata('success', 'Status verifikasi berhasil diperbarui.');
        return redirect()->to('/admin/siswa/detail/' . $id);
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/admin/siswa');
        }

        if ($this->siswaModel->delete($id)) {
            catat_log('Hapus Siswa', 'Menghapus data siswa: ' . ($siswa['nama_lengkap'] ?? $id) . ' (NISN: ' . ($siswa['nisn'] ?? '-') . ')');
            session()->setFlashdata('success', 'Data siswa berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data siswa.');
        }

        return redirect()->to('/admin/siswa');
    }

    public function resetPassword($id)
    {
        $newPassword = $this->request->getPost('new_password') ?: $this->request->getPost('password_baru');
        if (empty($newPassword)) {
            $newPassword = bin2hex(random_bytes(6));
        }
        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $student = $this->siswaModel->find($id);

        if ($student && $this->siswaModel->update($id, ['password' => $hashedPassword])) {
            session()->set('siswa_pwd_' . $id, $newPassword);
            
            // Bersihkan throttle & cache agar siswa bisa langsung login tanpa terkunci
            try {
                \Config\Services::cache()->clean();
            } catch (\Throwable $e) {
                // ignore
            }

            $printData = [
                'nama' => $student['nama_lengkap'],
                'nisn' => $student['nisn'] ?? '-',
                'no_daftar' => $student['no_pendaftaran'],
                'password' => $newPassword,
                'tanggal' => date('d-m-Y H:i:s')
            ];
            session()->setFlashdata('success', 'Password siswa berhasil direset ke: <strong>' . esc($newPassword) . '</strong>. Kunci login telah dibuka.');
            session()->setFlashdata('print_password', $printData);
        } else {
            session()->setFlashdata('error', 'Gagal mereset password siswa.');
        }

        return redirect()->back();
    }

    public function resetThrottle()
    {
        try {
            \Config\Services::cache()->clean();
            session()->setFlashdata('success', 'Batas waktu percobaan login (lockout 15 menit) berhasil direset. Silakan login kembali.');
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Gagal mereset cache login: ' . $e->getMessage());
        }

        return redirect()->to(base_url('admin/siswa'));
    }

    public function cetak($id)
    {
        $student = $this->siswaModel->find($id);

        if (!$student) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/admin/siswa');
        }

        $webModel = new \App\Models\TblWebModel();

        $data = [
            'siswa' => $student,
            'web' => $webModel->find(1)
        ];

        return view('siswa/cetak_formulir', $data);
    }

    public function cetakKartu($id)
    {
        $siswaModel = new \App\Models\SiswaModel();
        $webModel = new \App\Models\TblWebModel();
        $layoutModel = new \App\Models\LayoutKartuModel();
        $qrModel = new \App\Models\SettingQrModel();
        $ttdModel = new \App\Models\TandaTanganModel();
        $printerModel = new \App\Models\SettingPrinterModel();

        $siswa = $siswaModel->find($id);

        if (!$siswa) {
            return redirect()->to(base_url('admin/siswa'))->with('error', 'Data siswa tidak ditemukan.');
        }

        $berkasModel = new \App\Models\BerkasModel();
        $berkasFoto = $berkasModel->where('id_siswa', $siswa['id_siswa'])
                                  ->where('jenis_berkas', 'foto')
                                  ->orderBy('created_at', 'DESC')
                                  ->first();
        if ($berkasFoto) {
            $siswa['foto_berkas'] = $berkasFoto['path_file'];
        }

        $data = [
            'siswa'    => $siswa,
            'instansi' => $webModel->first() ?? [],
            'layout'   => $layoutModel->first() ?? [],
            'qr'       => $qrModel->first() ?? [],
            'ttd'      => $ttdModel->first() ?? [],
            'printer'  => $printerModel->first() ?? [],
        ];
        return view('admin/siswa/cetak_kartu', $data);
    }

    public function cetakPassword()
    {
        $printData = session()->getFlashdata('print_password');

        if (!$printData) {
            return redirect()->to(base_url('admin/siswa'))->with('error', 'Data password tidak ditemukan atau sesi cetak telah kedaluwarsa.');
        }

        // Tampilkan view cetak
        return view('admin/siswa/cetak_password', ['data' => $printData]);
    }
}
