<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TblWebModel;
use App\Models\DaftarUlangModel;
use App\Models\SiswaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DaftarUlang extends BaseController
{
    protected $webModel;
    protected $daftarUlangModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->webModel = new TblWebModel();
        $this->daftarUlangModel = new DaftarUlangModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $web = $this->webModel->first() ?? [];
        $activeTh = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;
        $statusKonfirmasi = $this->request->getGet('status_konfirmasi');
        $search = $this->request->getGet('search');

        // Hitung statistik pendaftar lulus yang terdaftar daftar ulang
        $db = \Config\Database::connect();
        
        $baseQuery = $db->table('tbl_siswa s')
            ->where('s.status_lulus', 'Lulus');
        if ($selectedTh !== 'all' && !empty($selectedTh)) {
            $baseQuery->where('s.th_pelajaran', $selectedTh);
        }
        $totalLulus = (clone $baseQuery)->countAllResults();

        $queryBersedia = (clone $baseQuery)
            ->join('tbl_daftar_ulang du', 'du.id_siswa = s.id_siswa')
            ->where('du.status_konfirmasi', 'bersedia');
        $totalBersedia = $queryBersedia->countAllResults();

        $queryMundur = (clone $baseQuery)
            ->join('tbl_daftar_ulang du', 'du.id_siswa = s.id_siswa')
            ->where('du.status_konfirmasi', 'mengundurkan_diri');
        $totalMundur = $queryMundur->countAllResults();

        $totalBelum = max(0, $totalLulus - ($totalBersedia + $totalMundur));

        // Ambil data siswa & konfirmasi daftar ulang
        $thFilter = ($selectedTh === 'all') ? null : $selectedTh;
        $rekapSiswa = $this->daftarUlangModel->getRekapDaftarUlang($statusKonfirmasi, $thFilter, $search);

        // Ambil definisi form ukuran seragam
        $seragamFields = DaftarUlangModel::getSeragamFields($web);

        $data = [
            'web'               => $web,
            'activeTh'          => $activeTh,
            'selectedTh'        => $selectedTh,
            'statusKonfirmasi'  => $statusKonfirmasi,
            'search'            => $search,
            'totalLulus'        => $totalLulus,
            'totalBersedia'     => $totalBersedia,
            'totalMundur'       => $totalMundur,
            'totalBelum'        => $totalBelum,
            'rekapSiswa'        => $rekapSiswa,
            'seragamFields'     => $seragamFields,
        ];

        return view('admin/daftar_ulang/index', $data);
    }

    /**
     * Simpan pengaturan umum & visibilitas form seragam
     */
    public function simpanPengaturan()
    {
        $web = $this->webModel->first();
        if (!$web) {
            session()->setFlashdata('error', 'Data profil web sekolah tidak ditemukan.');
            return redirect()->to(base_url('admin/daftar-ulang'));
        }

        $daftarUlangAktif = $this->request->getPost('daftar_ulang_aktif') ? '1' : '0';
        $tglTutup = $this->request->getPost('tgl_tutup_daftar_ulang');
        $pesan = $this->request->getPost('pesan_daftar_ulang');
        $seragamAktif = $this->request->getPost('seragam_aktif') ? '1' : '0';

        $updateData = [
            'daftar_ulang_aktif'     => $daftarUlangAktif,
            'tgl_tutup_daftar_ulang' => !empty($tglTutup) ? date('Y-m-d H:i:s', strtotime($tglTutup)) : null,
            'pesan_daftar_ulang'     => $pesan,
            'seragam_aktif'          => $seragamAktif,
        ];

        $this->webModel->update($web['id_web'], $updateData);

        session()->setFlashdata('success', 'Pengaturan umum Daftar Ulang & visibilitas seragam berhasil disimpan!');
        return redirect()->to(base_url('admin/daftar-ulang'));
    }

    /**
     * Simpan konfigurasi struktur form seragam dinamis
     */
    public function simpanFormSeragam()
    {
        $web = $this->webModel->first();
        if (!$web) {
            session()->setFlashdata('error', 'Data pengaturan tidak ditemukan.');
            return redirect()->to(base_url('admin/daftar-ulang'));
        }

        $labels = $this->request->getPost('field_label') ?? [];
        $ids = $this->request->getPost('field_id') ?? [];
        $types = $this->request->getPost('field_type') ?? [];
        $requireds = $this->request->getPost('field_required') ?? [];
        $options = $this->request->getPost('field_options') ?? [];

        $cleanedFields = [];
        foreach ($labels as $index => $label) {
            $labelTrim = trim($label);
            if (empty($labelTrim)) {
                continue;
            }

            $rawId = trim($ids[$index] ?? '');
            if (empty($rawId)) {
                $rawId = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $labelTrim));
            } else {
                $rawId = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '_', $rawId));
            }

            $type = in_array($types[$index] ?? '', ['select', 'text']) ? $types[$index] : 'select';
            $isRequired = (!empty($requireds[$index]) && $requireds[$index] == '1') ? 1 : 0;
            $optStr = trim($options[$index] ?? '');

            $cleanedFields[] = [
                'id'       => $rawId,
                'label'    => $labelTrim,
                'type'     => $type,
                'required' => $isRequired,
                'options'  => $optStr,
            ];
        }

        $this->webModel->update($web['id_web'], [
            'seragam_fields' => json_encode($cleanedFields, JSON_UNESCAPED_UNICODE)
        ]);

        session()->setFlashdata('success', 'Formulir Pendataan Ukuran Seragam berhasil diperbarui (' . count($cleanedFields) . ' field aktif)!');
        return redirect()->to(base_url('admin/daftar-ulang'));
    }

    /**
     * Reset struktur form seragam ke standar bawaan
     */
    public function resetFormSeragam()
    {
        $web = $this->webModel->first();
        if ($web) {
            $defaultFields = DaftarUlangModel::getDefaultSeragamFields();
            $this->webModel->update($web['id_web'], [
                'seragam_fields' => json_encode($defaultFields, JSON_UNESCAPED_UNICODE)
            ]);
        }

        session()->setFlashdata('success', 'Form ukuran seragam berhasil direset ke 4 standar bawaan (Baju, Celana, Peci, Sepatu)!');
        return redirect()->to(base_url('admin/daftar-ulang'));
    }

    /**
     * Export rekap data daftar ulang ke file Excel (XLSX)
     */
    public function exportExcel()
    {
        $web = $this->webModel->first() ?? [];
        $activeTh = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;
        $statusKonfirmasi = $this->request->getGet('status_konfirmasi');
        $search = $this->request->getGet('search');

        $thFilter = ($selectedTh === 'all') ? null : $selectedTh;
        $rekapSiswa = $this->daftarUlangModel->getRekapDaftarUlang($statusKonfirmasi, $thFilter, $search);
        $seragamFields = DaftarUlangModel::getSeragamFields($web);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Daftar Ulang');

        // Header basic
        $headers = [
            'No',
            'No. Pendaftaran',
            'NISN',
            'Nama Lengkap',
            'L/P',
            'No. WhatsApp / HP',
            'Tahun Pelajaran',
            'Status Konfirmasi',
            'Tgl Konfirmasi',
        ];

        // Tambahkan header seragam dinamis jika seragam aktif
        $seragamAktif = ($web['seragam_aktif'] ?? '1') == '1';
        if ($seragamAktif) {
            foreach ($seragamFields as $f) {
                $headers[] = $f['label'];
            }
            $headers[] = 'Catatan Seragam';
        }
        $headers[] = 'Alasan Mundur (Jika Mengundurkan Diri)';

        // Tulis baris header
        $colIndex = 1;
        foreach ($headers as $h) {
            $sheet->setCellValueByColumnAndRow($colIndex, 1, $h);
            $colIndex++;
        }

        // Style header
        $highestCol = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$highestCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10B981'], // Brand emerald
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $row = 2;
        $no = 1;
        foreach ($rekapSiswa as $s) {
            $statusText = 'Belum Konfirmasi';
            if (($s['status_konfirmasi'] ?? '') === 'bersedia') {
                $statusText = 'Bersedia Daftar Ulang';
            } elseif (($s['status_konfirmasi'] ?? '') === 'mengundurkan_diri') {
                $statusText = 'Mengundurkan Diri';
            }

            $tglText = !empty($s['tgl_konfirmasi']) ? date('d/m/Y H:i', strtotime($s['tgl_konfirmasi'])) : '-';

            $c = 1;
            $sheet->setCellValueByColumnAndRow($c++, $row, $no++);
            $sheet->setCellValueExplicitByColumnAndRow($c++, $row, $s['no_pendaftaran'] ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicitByColumnAndRow($c++, $row, $s['nisn'] ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueByColumnAndRow($c++, $row, $s['nama_lengkap'] ?? '');
            $sheet->setCellValueByColumnAndRow($c++, $row, $s['jk'] ?? '');
            $sheet->setCellValueExplicitByColumnAndRow($c++, $row, $s['telepon'] ?? '', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueByColumnAndRow($c++, $row, $s['th_pelajaran'] ?? '');
            $sheet->setCellValueByColumnAndRow($c++, $row, $statusText);
            $sheet->setCellValueByColumnAndRow($c++, $row, $tglText);

            if ($seragamAktif) {
                // Parse dynamic answers
                $answers = [];
                if (!empty($s['data_seragam'])) {
                    $answers = json_decode($s['data_seragam'], true) ?: [];
                }

                foreach ($seragamFields as $f) {
                    $fid = $f['id'];
                    $val = $answers[$fid] ?? $s[$fid] ?? '-';
                    $sheet->setCellValueByColumnAndRow($c++, $row, $val ?: '-');
                }
                $sheet->setCellValueByColumnAndRow($c++, $row, $s['catatan'] ?? '-');
            }

            $sheet->setCellValueByColumnAndRow($c++, $row, $s['alasan_mundur'] ?? '-');
            $row++;
        }

        // Auto-width
        foreach (range('A', $highestCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Rekap_Daftar_Ulang_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
