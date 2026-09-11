<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pindahan\SiswaPindahanModel;
use App\Models\Pindahan\BerkasPindahanModel;
use App\Models\Pindahan\VerifikasiPindahanModel;
use App\Models\TblWebModel;
use App\Services\PindahanService;
use Config\PindahanConfig;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pindahan extends BaseController
{
    protected SiswaPindahanModel $pindahanModel;
    protected BerkasPindahanModel $berkasModel;
    protected VerifikasiPindahanModel $verifikasiModel;
    protected PindahanService $pindahanService;

    /**
     * Dependency injection opsional — default fallback ke instansiasi
     * manual agar tetap kompatibel dengan createController() CI4.
     */
    public function __construct(
        ?SiswaPindahanModel $pindahanModel = null,
        ?BerkasPindahanModel $berkasModel = null,
        ?VerifikasiPindahanModel $verifikasiModel = null,
        ?PindahanService $pindahanService = null
    ) {
        $this->pindahanModel   = $pindahanModel ?? new SiswaPindahanModel();
        $this->berkasModel     = $berkasModel ?? new BerkasPindahanModel();
        $this->verifikasiModel = $verifikasiModel ?? new VerifikasiPindahanModel();
        $this->pindahanService = $pindahanService ?? new PindahanService($this->pindahanModel, $this->berkasModel, $this->verifikasiModel);
    }

    public function index()
    {
        $search     = $this->request->getGet('search');
        $sortOrder  = $this->request->getGet('sort') == 'DESC' ? 'DESC' : 'ASC';
        $tab        = $this->request->getGet('tab') ?? 'all';

        $activeTh   = $this->pindahanModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran');
        if ($selectedTh === null) {
            $selectedTh = $activeTh;
        }

        $tahunModel = new \App\Models\TahunPelajaranModel();
        $tahunList = $tahunModel->orderBy('id_tahun', 'DESC')->findAll();

        $statusCounts = $this->pindahanModel->getStatusCounts($selectedTh);
        $siswaList = $this->pindahanModel->getStudents($search, 20, $sortOrder, $selectedTh, $tab);

        foreach ($siswaList as &$s) {
            $comp = $this->pindahanModel->calculateCompletionPercentage($s);
            $s['kelengkapan'] = $comp['percentage'];
            $s['foto_url'] = $this->pindahanService->resolvePhotoUrl($s['foto'] ?? null);
        }
        unset($s);

        $data = [
            'layout'      => 'layouts/admin',
            'page_title'  => 'Data Siswa Pindahan',
            'siswa'       => $siswaList,
            'pager'       => $this->pindahanModel->pager,
            'search'      => $search,
            'sort'        => $sortOrder,
            'selectedTh'  => $selectedTh,
            'activeTh'    => $activeTh,
            'tahunList'   => $tahunList,
            'currentTab'  => $tab,
            'statusCounts'=> $statusCounts,
        ];

        return view('pindahan/admin/index', $data);
    }

    public function detail($id)
    {
        $siswa = $this->pindahanModel->getStudentDetail($id);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/admin/pindahan');
        }

        $comp = $this->pindahanModel->calculateCompletionPercentage($siswa);
        $siswa['kelengkapan'] = $comp['percentage'];
        $siswa['foto_url'] = $this->pindahanService->resolvePhotoUrl($siswa['foto'] ?? null);

        $berkasList = $this->berkasModel->getByPindahan($id);
        $verifikasiRiwayat = $this->verifikasiModel->getByPindahan($id);

        $data = [
            'layout'      => 'layouts/admin',
            'page_title'  => 'Detail Siswa Pindahan',
            'siswa'       => $siswa,
            'berkasList'  => $berkasList,
            'verifikasiRiwayat' => $verifikasiRiwayat,
            'semuaJenjang' => PindahanConfig::getAllJenjang(),
            'berkasWajib' => $this->berkasModel->isWajibLengkap($id),
        ];

        return view('pindahan/admin/detail', $data);
    }

    public function quickDetail($id)
    {
        $siswa = $this->pindahanModel->getStudentDetail($id);
        if (!$siswa) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data siswa pindahan tidak ditemukan.'
            ]);
        }

        $comp = $this->pindahanModel->calculateCompletionPercentage($siswa);
        $siswa['kelengkapan'] = $comp['percentage'];
        $siswa['incomplete_fields'] = $comp['incomplete'];

        $berkasList = $this->berkasModel->getByPindahan($id);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => [
                'student' => $siswa,
                'berkas'  => $berkasList,
            ]
        ]);
    }

    public function verify($id)
    {
        $status  = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');
        $adminName = session()->get('nama_lengkap') ?: 'Admin';

        $result = $this->pindahanService->doVerify((int) $id, $status, $catatan, $adminName, 'Admin');

        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);
        return redirect()->to('/admin/pindahan/detail/' . $id);
    }

    public function bulkVerify()
    {
        $ids = $this->request->getPost('ids');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan') ?: 'Verifikasi massal oleh Admin';

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array) $ids));

        $adminName = session()->get('nama_lengkap') ?: 'Admin';
        $result = $this->pindahanService->doBulkVerify($ids, $status, $catatan, $adminName);

        if ($result['success']) {
            catat_log('Verifikasi Massal Pindahan', "Mengubah status verifikasi {$result['count']} siswa pindahan menjadi $status");
        }

        return $this->response->setJSON([
            'status'  => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
        ]);
    }

    public function delete($id)
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/admin/pindahan');
        }

        if ($this->pindahanService->softDeletePindahan((int) $id)) {
            catat_log('Hapus Siswa Pindahan', 'Menghapus (soft) siswa pindahan: ' . ($siswa['nama_lengkap'] ?? $id));
            session()->setFlashdata('success', 'Data siswa pindahan berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data siswa pindahan.');
        }

        return redirect()->to('/admin/pindahan');
    }

    public function bulkDelete()
    {
        $ids = $this->request->getPost('ids');
        $confirm = strtolower(trim($this->request->getPost('confirm') ?? ''));

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_filter(array_map('intval', (array) $ids));

        if ($confirm !== 'hapus') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Konfirmasi kata "hapus" tidak sesuai.']);
        }

        $count = 0;
        foreach ($ids as $id) {
            if ($this->pindahanService->softDeletePindahan($id)) {
                $count++;
            }
        }

        catat_log('Hapus Massal Pindahan', "Menghapus $count data siswa pindahan secara massal");

        return $this->response->setJSON(['status' => 'success', 'message' => "Berhasil menghapus $count data siswa pindahan."]);
    }

    public function resetPassword($id)
    {
        $newPassword = $this->request->getPost('new_password') ?: $this->request->getPost('password_baru');
        if (empty($newPassword)) {
            $newPassword = bin2hex(random_bytes(6));
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $siswa = $this->pindahanModel->find($id);

        if ($siswa && $this->pindahanModel->update($id, ['password' => $hashedPassword])) {
            session()->set('pindahan_pwd_' . $id, $newPassword);

            try {
                \Config\Services::cache()->clean();
            } catch (\Throwable $e) {
                // ignore
            }

            $printData = [
                'nama'   => $siswa['nama_lengkap'],
                'nisn'   => $siswa['nisn'] ?? '-',
                'no_daftar' => $siswa['no_pendaftaran'],
                'password' => $newPassword,
                'tanggal' => date('d-m-Y H:i:s'),
                'jenis'  => 'pindahan',
            ];
            session()->setFlashdata('success', 'Password siswa pindahan berhasil direset ke: <strong>' . esc($newPassword) . '</strong>.');
            session()->setFlashdata('print_password', $printData);
        } else {
            session()->setFlashdata('error', 'Gagal mereset password siswa pindahan.');
        }

        return redirect()->back();
    }

    public function verifyBerkas($id)
    {
        $berkas = $this->berkasModel->find($id);
        if (!$berkas) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Berkas tidak ditemukan.']);
        }

        $status = $this->request->getPost('status');
        if (!in_array($status, ['pending', 'valid', 'invalid'], true)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Status berkas tidak valid.']);
        }

        $this->berkasModel->update($id, ['status_verifikasi' => $status]);

        $idPindahan = $berkas['id_pindahan'];
        $pindahan = $this->pindahanModel->find($idPindahan);
        $namaSiswa = $pindahan['nama_lengkap'] ?? ('ID ' . $idPindahan);
        catat_log('Verifikasi Berkas Pindahan', "Berkas {$berkas['jenis_berkas']} siswa {$namaSiswa} menjadi $status");

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status berkas diperbarui menjadi ' . $status]);
    }

    public function cetak($id)
    {
        helper('kop');
        $pindahan = $this->pindahanModel->find($id);
        if (!$pindahan) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/admin/pindahan');
        }

        $webModel = new TblWebModel();

        $data = [
            'pindahan' => $pindahan,
            'web'      => $webModel->find(1),
            'berkas'   => $this->berkasModel->getByPindahan($id),
        ];

        return view('pindahan/siswa/cetak_formulir', $data);
    }

    public function cetakKartu($id)
    {
        $pindahan = $this->pindahanModel->find($id);
        if (!$pindahan) {
            return redirect()->to(base_url('admin/pindahan'))->with('error', 'Data siswa pindahan tidak ditemukan.');
        }

        $webModel = new \App\Models\TblWebModel();
        $layoutModel = new \App\Models\LayoutKartuModel();
        $qrModel = new \App\Models\SettingQrModel();
        $ttdModel = new \App\Models\TandaTanganModel();
        $printerModel = new \App\Models\SettingPrinterModel();

        $data = [
            'pindahan' => $pindahan,
            'instansi' => $webModel->first() ?? [],
            'layout'   => $layoutModel->first() ?? [],
            'qr'       => $qrModel->first() ?? [],
            'ttd'      => $ttdModel->first() ?? [],
            'printer'  => $printerModel->first() ?? [],
        ];

        return view('pindahan/admin/cetak_kartu', $data);
    }

    public function exportExcel()
    {
        $search = $this->request->getGet('search');
        $thPelajaran = $this->request->getGet('th_pelajaran');
        if (empty($thPelajaran)) {
            $thPelajaran = $this->pindahanModel->getActiveThPelajaran();
        }

        $rumus = $this->pindahanModel
            ->like('nama_lengkap', $search)
            ->orLike('no_pendaftaran', $search)
            ->orLike('nisn', $search);

        if ($thPelajaran !== 'all') {
            $rumus->where('th_pelajaran', $thPelajaran);
        }

        $rows = $rumus->orderBy('id_pindahan', 'ASC')->findAll();

        // Nama file
        $fileName = 'siswa_pindahan_' . date('Ymd_His') . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Siswa Pindahan');

        $headers = [
            'No', 'No Pendaftaran', 'NISN', 'Nama Lengkap', 'Email', 'JK',
            'Jenjang Asal', 'Sekolah Asal',
            'Jenis Kelamin', 'Alamat', 'No HP', 'Status Verifikasi', 'Status Pendaftaran',
        ];
        $sheet->fromArray([$headers], null, 'A1');
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);

        $col = 2;
        $no = 1;
        foreach ($rows as $row) {
            $sheet->fromArray([
                $no++,
                $row['no_pendaftaran'],
                $row['nisn'],
                $row['nama_lengkap'],
                $row['email'],
                $row['jk'] ?? '',
                $row['jenjang_sekolah_asal'] ?? '',
                $row['nama_sekolah_asal'] ?? '',
                $row['jk'] ?? '',
                $row['alamat_siswa'] ?? '',
                $row['no_hp_siswa'] ?? '',
                $row['status_verifikasi'] ?? '',
                $row['status_pendaftaran'] ?? '',
            ], null, 'A' . $col);
            $col++;
        }

        foreach (range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        // Force download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}