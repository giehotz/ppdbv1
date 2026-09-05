<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\BerkasModel;
use App\Models\VerifikasiModel;
use App\Models\TagihanSiswaModel;
use App\Models\PembayaranModel;
use App\Models\TahunPelajaranModel;

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
        $tab = $this->request->getGet('tab') ?? 'all';

        $activeTh = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran');
        if ($selectedTh === null) {
            $selectedTh = $activeTh;
        }

        $tahunModel = new TahunPelajaranModel();
        $tahunList = $tahunModel->orderBy('id_tahun', 'DESC')->findAll();

        $statusCounts = $this->siswaModel->getStatusCounts($selectedTh);
        $siswaList = $this->siswaModel->getStudents($search, 20, $sortOrder, $selectedTh, $tab);

        // Add completion percentage
        foreach ($siswaList as &$s) {
            $completionData = $this->siswaModel->calculateCompletionPercentage($s);
            $s['kelengkapan'] = $completionData['percentage'];
        }
        unset($s);

        // Batch load tagihan, pembayaran, dan foto berkas (mencegah N+1)
        $siswaIds = array_column($siswaList, 'id_siswa');
        if (!empty($siswaIds)) {
            $db = \Config\Database::connect();

            // Tagihan
            $tagihanRows = $db->table('tbl_tagihan_siswa')
                ->select('siswa_id, COUNT(*) as jml_tagihan, SUM(harga_satuan) as total_tagihan, SUM(CASE WHEN status_bayar = "lunas" THEN 1 ELSE 0 END) as tagihan_lunas_cnt')
                ->whereIn('siswa_id', $siswaIds)
                ->groupBy('siswa_id')
                ->get()->getResultArray();
            $tagihanMap = [];
            foreach ($tagihanRows as $tr) {
                $tagihanMap[$tr['siswa_id']] = $tr;
            }

            // Pembayaran
            $bayarRows = $db->table('tbl_pembayaran')
                ->select('siswa_id, SUM(jumlah) as total_bayar')
                ->whereIn('siswa_id', $siswaIds)
                ->groupBy('siswa_id')
                ->get()->getResultArray();
            $bayarMap = [];
            foreach ($bayarRows as $br) {
                $bayarMap[$br['siswa_id']] = (int)$br['total_bayar'];
            }

            // Foto Berkas
            $fotoRows = $db->table('tbl_berkas')
                ->select('id_siswa, path_file')
                ->whereIn('id_siswa', $siswaIds)
                ->where('jenis_berkas', 'foto')
                ->orderBy('created_at', 'ASC')
                ->get()->getResultArray();
            $fotoMap = [];
            foreach ($fotoRows as $fr) {
                $fotoMap[$fr['id_siswa']] = $fr['path_file'];
            }

            foreach ($siswaList as &$s) {
                $sid = $s['id_siswa'];
                $t = $tagihanMap[$sid] ?? null;
                $b = $bayarMap[$sid] ?? 0;
                if (!$t || (int)$t['jml_tagihan'] === 0) {
                    $s['status_pembiayaan'] = 'no_bill'; // Belum Ada Tagihan
                    $s['total_tagihan'] = 0;
                    $s['total_bayar'] = 0;
                    $s['sisa_tagihan'] = 0;
                } else {
                    $totalTagihan = (int)$t['total_tagihan'];
                    $sisa = max(0, $totalTagihan - $b);
                    $s['total_tagihan'] = $totalTagihan;
                    $s['total_bayar'] = $b;
                    $s['sisa_tagihan'] = $sisa;
                    if ($sisa == 0 && (int)$t['tagihan_lunas_cnt'] == (int)$t['jml_tagihan']) {
                        $s['status_pembiayaan'] = 'lunas';
                    } elseif ($b > 0) {
                        $s['status_pembiayaan'] = 'sebagian';
                    } else {
                        $s['status_pembiayaan'] = 'belum';
                    }
                }
                $s['foto_berkas'] = $fotoMap[$sid] ?? null;
                $s['foto_url'] = $this->resolvePhotoUrl($fotoMap[$sid] ?? null, $s['foto'] ?? null, $s['nisn'] ?? null);
            }
            unset($s);
        }

        $data = [
            'siswa'        => $siswaList,
            'pager'        => $this->siswaModel->pager,
            'search'       => $search,
            'sort'         => $sortOrder,
            'selectedTh'   => $selectedTh,
            'activeTh'     => $activeTh,
            'tahunList'    => $tahunList,
            'currentTab'   => $tab,
            'statusCounts' => $statusCounts,
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

        $student['foto_url'] = $this->resolvePhotoUrl($berkasFoto['path_file'] ?? null, $student['foto'] ?? null, $student['nisn'] ?? null);

        $data = [
            'siswa' => $student,
            'berkasFoto' => $berkasFoto,
        ];

        return view('admin/siswa/detail', $data);
    }

    public function quickDetail($id)
    {
        $student = $this->siswaModel->getStudentDetail($id);
        if (!$student) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data siswa tidak ditemukan.'
            ]);
        }

        $comp = $this->siswaModel->calculateCompletionPercentage($student);
        $student['kelengkapan'] = $comp['percentage'];
        $student['incomplete_fields'] = $comp['incomplete'];

        // Berkas
        $berkasModel = new BerkasModel();
        $berkasList = $berkasModel->where('id_siswa', $id)->findAll();
        $foto = null;
        foreach ($berkasList as $b) {
            if ($b['jenis_berkas'] === 'foto') {
                $foto = $b['path_file'];
                break;
            }
        }
        $student['foto_url'] = $this->resolvePhotoUrl($foto, $student['foto'] ?? null, $student['nisn'] ?? null);

        // Keuangan
        $tagihanModel = new TagihanSiswaModel();
        $pembayaranModel = new PembayaranModel();
        $tagihans = $tagihanModel->getTagihanBySiswa($id);
        $totalTagihan = $tagihanModel->getTotalTagihan($id);
        $totalBayar = $pembayaranModel->getTotalBayar($id);
        $sisa = max(0, $totalTagihan - $totalBayar);

        $statusBayar = 'no_bill';
        if (!empty($tagihans)) {
            $isAllLunas = $tagihanModel->isAllLunas($id);
            if ($isAllLunas && $sisa == 0) {
                $statusBayar = 'lunas';
            } elseif ($totalBayar > 0) {
                $statusBayar = 'sebagian';
            } else {
                $statusBayar = 'belum';
            }
        }

        $data = [
            'student'  => $student,
            'berkas'   => $berkasList,
            'keuangan' => [
                'status'        => $statusBayar,
                'total_tagihan' => $totalTagihan,
                'total_bayar'   => $totalBayar,
                'sisa'          => $sisa,
                'items'         => $tagihans,
            ]
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
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

    public function bulkVerify()
    {
        $ids = $this->request->getPost('ids');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan') ?: 'Verifikasi massal oleh Admin';

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array)$ids));

        if (empty($ids) || !in_array($status, ['Terverifikasi', 'Menunggu', 'Ditolak'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data atau status verifikasi tidak valid.']);
            }
            return redirect()->back()->with('error', 'Pilih siswa dan status yang valid.');
        }

        $verifikasiModel = new VerifikasiModel();
        $userName = session()->get('nama_lengkap') ?: 'Admin';
        $count = 0;

        foreach ($ids as $id) {
            $existing = $verifikasiModel->where('id_siswa', $id)->first();
            $verifData = [
                'id_siswa'       => $id,
                'ket'            => $status,
                'isi'            => $catatan,
                'tgl_verifikasi' => date('Y-m-d H:i:s'),
                'verifikator'    => $userName,
            ];
            if ($existing) {
                $verifikasiModel->update($existing['id_verifikasi'], $verifData);
            } else {
                $verifikasiModel->insert($verifData);
            }

            $updateData = ['status_verifikasi' => $status];
            if ($status === 'Ditolak') {
                $updateData['status_pendaftaran'] = '';
            }
            $this->siswaModel->update($id, $updateData);
            $count++;
        }

        catat_log('Verifikasi Massal Siswa', "Mengubah status verifikasi $count siswa menjadi $status");

        $msg = "Berhasil memperbarui status verifikasi $count siswa menjadi $status.";
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
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

    public function bulkDelete()
    {
        $ids = $this->request->getPost('ids');
        $confirm = strtolower(trim($this->request->getPost('confirm') ?? ''));

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array)$ids));

        if ($confirm !== 'hapus') {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Konfirmasi tidak sesuai. Harap ketik "hapus".']);
            }
            return redirect()->back()->with('error', 'Konfirmasi kata "hapus" tidak sesuai.');
        }

        if (empty($ids)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada siswa yang dipilih.']);
            }
            return redirect()->back()->with('error', 'Pilih minimal satu siswa.');
        }

        $count = 0;
        foreach ($ids as $id) {
            if ($this->siswaModel->delete($id)) {
                $count++;
            }
        }

        catat_log('Hapus Massal Siswa', "Menghapus $count data siswa secara massal");

        $msg = "Berhasil menghapus $count data siswa.";
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
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

    /**
     * Resolusi URL foto siswa dengan memeriksa path berkas & kolom foto siswa serta memverifikasi file fisik
     */
    private function resolvePhotoUrl(?string $fotoBerkas, ?string $fotoSiswa, ?string $nisn): ?string
    {
        $candidates = [];
        if (!empty($fotoBerkas)) {
            $candidates[] = $fotoBerkas;
        }
        if (!empty($fotoSiswa)) {
            $candidates[] = $fotoSiswa;
        }

        foreach ($candidates as $c) {
            $ext = strtolower(pathinfo($c, PATHINFO_EXTENSION));
            // Hanya ekstensi gambar yang didukung
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                continue;
            }

            $possiblePaths = [];
            if (str_starts_with($c, 'uploads/')) {
                $possiblePaths[] = $c;
            } else {
                if (!empty($nisn)) {
                    $possiblePaths[] = 'uploads/berkas/' . $nisn . '/' . $c;
                }
                $possiblePaths[] = 'uploads/berkas/' . $c;
                $possiblePaths[] = 'uploads/' . $c;
            }

            foreach ($possiblePaths as $relPath) {
                $fullPath = rtrim(FCPATH, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);
                if (is_file($fullPath)) {
                    return base_url($relPath);
                }
            }
        }

        return null;
    }
}
