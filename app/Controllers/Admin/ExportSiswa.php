<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportSiswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    /**
     * Export all student biodata to Excel (.xlsx)
     */
    public function exportExcel()
    {
        // The data will be fetched in chunks later to prevent memory exhaustion

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Biodata Siswa');

        // Define column headers
        $headers = [
            // Data Diri
            'A' => 'No',
            'B' => 'No. Pendaftaran',
            'C' => 'NISN',
            'D' => 'NIK',
            'E' => 'No. KK',
            'F' => 'Kepala Keluarga',
            'G' => 'Nama Lengkap',
            'H' => 'Jenis Kelamin',
            'I' => 'Status Keluarga',
            'J' => 'Agama',
            'K' => 'Tempat Lahir',
            'L' => 'Tanggal Lahir',
            'M' => 'Email',
            'N' => 'No. HP Siswa',
            'O' => 'Anak Ke',
            'P' => 'Jumlah Saudara',
            'Q' => 'Hobi',
            'R' => 'Cita-cita',
            'S' => 'Pernah PAUD',
            'T' => 'Pernah TK',
            // Alamat
            'U' => 'Alamat',
            'V' => 'Provinsi',
            'W' => 'Kabupaten/Kota',
            'X' => 'Kecamatan',
            'Y' => 'Desa/Kelurahan',
            'Z' => 'Kode Pos',
            'AA' => 'Jenis Tinggal',
            // Data Ayah
            'AB' => 'Nama Ayah',
            'AC' => 'Status Ayah',
            'AD' => 'NIK Ayah',
            'AE' => 'Tahun Lahir Ayah',
            'AF' => 'Pendidikan Ayah',
            'AG' => 'Pekerjaan Ayah',
            'AH' => 'Penghasilan Ayah',
            // Data Ibu
            'AI' => 'Nama Ibu',
            'AJ' => 'Status Ibu',
            'AK' => 'NIK Ibu',
            'AL' => 'Tahun Lahir Ibu',
            'AM' => 'Pendidikan Ibu',
            'AN' => 'Pekerjaan Ibu',
            'AO' => 'Penghasilan Ibu',
            'AP' => 'No. HP Orang Tua',
            // Data Wali
            'AQ' => 'Nama Wali',
            'AR' => 'NIK Wali',
            'AS' => 'Tahun Lahir Wali',
            'AT' => 'Pendidikan Wali',
            'AU' => 'Pekerjaan Wali',
            'AV' => 'Penghasilan Wali',
            // Asal Sekolah
            'AW' => 'Nama Sekolah',
            'AX' => 'NPSN Sekolah',
            'AY' => 'Jenjang Sekolah',
            'AZ' => 'Status Sekolah',
            'BA' => 'Lokasi Sekolah',
            // Kesejahteraan
            'BB' => 'No. KKS',
            'BC' => 'No. PKH',
            'BD' => 'No. KIP',
            // Status
            // Tambahan
            'BG' => 'Jalur Pendaftaran',
            'BH' => 'Jarak (km)',
            'BI' => 'Transportasi',
            'BJ' => 'Tempat Lahir Ayah',
            'BK' => 'Tanggal Lahir Ayah',
            'BL' => 'Tempat Lahir Ibu',
            'BM' => 'Tanggal Lahir Ibu',
            'BN' => 'Kompetensi Keahlian',
            'BO' => 'Tanggal Lahir Wali',
        ];

        // Write headers
        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
        }

        // Style header row
        $lastCol = 'BO';
        $headerRange = "A1:{$lastCol}1";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '16A34A'], // green-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Populate data rows using chunking to prevent memory exhaustion
        $activeTh = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;

        $row = 2;
        $index = 0;
        $limit = 100;
        $offset = 0;

        while (true) {
            // Fetch students in segments
            $builder = $this->siswaModel->orderBy('tgl_siswa', 'DESC');
            if ($selectedTh !== 'all' && !empty($selectedTh)) {
                $builder->where('th_pelajaran', $selectedTh);
            }
            $students = $builder->findAll($limit, $offset);

            if (empty($students)) {
                break;
            }

            foreach ($students as $s) {
                // Data Diri
                $sheet->setCellValue("A{$row}", $index + 1);
                $sheet->setCellValue("B{$row}", $s['no_pendaftaran'] ?? '');
                $sheet->setCellValue("C{$row}", $s['nisn'] ?? '');
                $sheet->setCellValue("D{$row}", $s['nik'] ?? '');
                $sheet->setCellValue("E{$row}", $s['no_kk'] ?? '');
                $sheet->setCellValue("F{$row}", $s['kepala_keluarga'] ?? '');
                $sheet->setCellValue("G{$row}", $s['nama_lengkap'] ?? '');
                $sheet->setCellValue("H{$row}", $s['jk'] ?? '');
                $sheet->setCellValue("I{$row}", $s['status_keluarga'] ?? '');
                $sheet->setCellValue("J{$row}", $s['agama'] ?? '');
                $sheet->setCellValue("K{$row}", $s['tempat_lahir'] ?? '');
                $sheet->setCellValue("L{$row}", $s['tgl_lahir'] ?? '');
                $sheet->setCellValue("M{$row}", $s['email'] ?? '');
                $sheet->setCellValue("N{$row}", $s['no_hp_siswa'] ?? ($s['telepon'] ?? ''));
                $sheet->setCellValue("O{$row}", $s['anak_ke'] ?? '');
                $sheet->setCellValue("P{$row}", $s['jml_saudara'] ?? '');
                $sheet->setCellValue("Q{$row}", $s['hobi'] ?? '');
                $sheet->setCellValue("R{$row}", $s['cita'] ?? '');
                $sheet->setCellValue("S{$row}", $s['paud'] ?? '');
                $sheet->setCellValue("T{$row}", $s['tk'] ?? '');
                // Alamat
                $sheet->setCellValue("U{$row}", $s['alamat_siswa'] ?? ($s['alamat_lengkap'] ?? ''));
                $sheet->setCellValue("V{$row}", $s['prov'] ?? ($s['provinsi'] ?? ''));
                $sheet->setCellValue("W{$row}", $s['kab'] ?? ($s['kota'] ?? ''));
                $sheet->setCellValue("X{$row}", $s['kec'] ?? ($s['kecamatan'] ?? ''));
                $sheet->setCellValue("Y{$row}", $s['desa'] ?? ($s['kelurahan'] ?? ''));
                $sheet->setCellValue("Z{$row}", $s['kode_pos'] ?? '');
                $sheet->setCellValue("AA{$row}", $s['jenis_tinggal'] ?? '');
                // Data Ayah
                $sheet->setCellValue("AB{$row}", $s['nama_ayah'] ?? '');
                $sheet->setCellValue("AC{$row}", $s['status_ayah'] ?? '');
                $sheet->setCellValue("AD{$row}", $s['nik_ayah'] ?? '');
                $sheet->setCellValue("AE{$row}", (!empty($s['tgl_lahir_ayah']) && $s['tgl_lahir_ayah'] !== '0000-00-00') ? date('Y', strtotime($s['tgl_lahir_ayah'])) : '');
                $sheet->setCellValue("AF{$row}", $s['pdd_ayah'] ?? ($s['pendidikan_ayah'] ?? ''));
                $sheet->setCellValue("AG{$row}", $s['pekerjaan_ayah'] ?? '');
                $sheet->setCellValue("AH{$row}", $s['penghasilan_ayah'] ?? '');
                // Data Ibu
                $sheet->setCellValue("AI{$row}", $s['nama_ibu'] ?? '');
                $sheet->setCellValue("AJ{$row}", $s['status_ibu'] ?? '');
                $sheet->setCellValue("AK{$row}", $s['nik_ibu'] ?? '');
                $sheet->setCellValue("AL{$row}", (!empty($s['tgl_lahir_ibu']) && $s['tgl_lahir_ibu'] !== '0000-00-00') ? date('Y', strtotime($s['tgl_lahir_ibu'])) : '');
                $sheet->setCellValue("AM{$row}", $s['pdd_ibu'] ?? ($s['pendidikan_ibu'] ?? ''));
                $sheet->setCellValue("AN{$row}", $s['pekerjaan_ibu'] ?? '');
                $sheet->setCellValue("AO{$row}", $s['penghasilan_ibu'] ?? '');
                $sheet->setCellValue("AP{$row}", $s['no_hp_ortu'] ?? ($s['telepon'] ?? ''));
                // Data Wali
                $sheet->setCellValue("AQ{$row}", $s['nama_wali'] ?? '');
                $sheet->setCellValue("AR{$row}", $s['nik_wali'] ?? '');
                $sheet->setCellValue("AS{$row}", (!empty($s['tgl_lahir_wali']) && $s['tgl_lahir_wali'] !== '0000-00-00') ? date('Y', strtotime($s['tgl_lahir_wali'])) : '');
                $sheet->setCellValue("AT{$row}", $s['pdd_wali'] ?? '');
                $sheet->setCellValue("AU{$row}", $s['pekerjaan_wali'] ?? '');
                $sheet->setCellValue("AV{$row}", $s['penghasilan_wali'] ?? '');
                // Asal Sekolah
                $sheet->setCellValue("AW{$row}", $s['nama_sekolah'] ?? '');
                $sheet->setCellValue("AX{$row}", $s['npsn_sekolah'] ?? '');
                $sheet->setCellValue("AY{$row}", $s['jenjang_sekolah'] ?? '');
                $sheet->setCellValue("AZ{$row}", $s['status_sekolah'] ?? '');
                $sheet->setCellValue("BA{$row}", $s['lokasi_sekolah'] ?? '');
                // Kesejahteraan
                $sheet->setCellValue("BB{$row}", $s['no_kks'] ?? '');
                $sheet->setCellValue("BC{$row}", $s['no_pkh'] ?? '');
                $sheet->setCellValue("BD{$row}", $s['no_kip'] ?? '');
                // Status
                $sheet->setCellValue("BE{$row}", $s['status_verifikasi'] ?? '');
                $sheet->setCellValue("BF{$row}", isset($s['tgl_siswa']) ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '');
                // Tambahan
                $sheet->setCellValue("BG{$row}", $s['jalur_pendaftaran'] ?? '');
                $sheet->setCellValue("BH{$row}", $s['jarak'] ?? '');
                $sheet->setCellValue("BI{$row}", $s['trans'] ?? '');
                $sheet->setCellValue("BJ{$row}", $s['tempat_lahir_ayah'] ?? '');
                $sheet->setCellValue("BK{$row}", $s['tgl_lahir_ayah'] ?? '');
                $sheet->setCellValue("BL{$row}", $s['tempat_lahir_ibu'] ?? '');
                $sheet->setCellValue("BM{$row}", $s['tgl_lahir_ibu'] ?? '');
                $sheet->setCellValue("BN{$row}", $s['komp_ahli'] ?? '');
                $sheet->setCellValue("BO{$row}", $s['tgl_lahir_wali'] ?? '');
                $row++;
                $index++;
            }

            $offset += $limit;
        }

        // Apply borders to all data cells
        $lastRow = $row - 1;
        if ($lastRow >= 1) {
            $dataRange = "A1:{$lastCol}{$lastRow}";
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
        }

        // Auto-size columns
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Freeze header row
        $sheet->freezePane('A2');

        // Generate filename
        $filename = 'Data_Biodata_Siswa_' . date('Y-m-d') . '.xlsx';

        // Set response headers and output
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
