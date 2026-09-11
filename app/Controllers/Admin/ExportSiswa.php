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
            'AE' => 'Tempat Lahir Ayah',
            'AF' => 'Tanggal Lahir Ayah',
            'AG' => 'Pendidikan Ayah',
            'AH' => 'Pekerjaan Ayah',
            'AI' => 'Penghasilan Ayah',
            // Data Ibu
            'AJ' => 'Nama Ibu',
            'AK' => 'Status Ibu',
            'AL' => 'Tempat Lahir Ibu',
            'AM' => 'Tanggal Lahir Ibu',
            'AN' => 'Pendidikan Ibu',
            'AO' => 'Pekerjaan Ibu',
            'AP' => 'Penghasilan Ibu',
            'AQ' => 'No. HP Orang Tua',
            // Data Wali
            'AR' => 'Nama Wali',
            'AS' => 'NIK Wali',
            'AT' => 'Tempat Lahir Wali',
            'AU' => 'Tanggal Lahir Wali',
            'AV' => 'Pendidikan Wali',
            'AW' => 'Pekerjaan Wali',
            'AX' => 'Penghasilan Wali',
            // Asal Sekolah
            'AY' => 'Nama Sekolah',
            'AZ' => 'NPSN Sekolah',
            'BA' => 'Jenjang Sekolah',
            'BB' => 'Status Sekolah',
            'BC' => 'Lokasi Sekolah',
            // Kesejahteraan
            'BD' => 'No. KKS',
            'BE' => 'No. PKH',
            'BF' => 'No. KIP',
            // Status
            'BG' => 'Status Verifikasi',
            'BH' => 'Tanggal Input',
            // Tambahan
            'BI' => 'Jalur Pendaftaran',
            'BJ' => 'Jarak (km)',
            'BK' => 'Transportasi',
            'BL' => 'Kompetensi Keahlian',
        ];

        // Write headers
        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
        }

        // Style header row
        $lastCol = 'BL';
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
                $sheet->setCellValue("AE{$row}", $s['tempat_lahir_ayah'] ?? '');
                $sheet->setCellValue("AF{$row}", (!empty($s['tgl_lahir_ayah']) && $s['tgl_lahir_ayah'] !== '0000-00-00') ? date('Y/m/d', strtotime($s['tgl_lahir_ayah'])) : '');
                $sheet->setCellValue("AG{$row}", $s['pdd_ayah'] ?? ($s['pendidikan_ayah'] ?? ''));
                $sheet->setCellValue("AH{$row}", $s['pekerjaan_ayah'] ?? '');
                $sheet->setCellValue("AI{$row}", $s['penghasilan_ayah'] ?? '');
                // Data Ibu
                $sheet->setCellValue("AJ{$row}", $s['nama_ibu'] ?? '');
                $sheet->setCellValue("AK{$row}", $s['status_ibu'] ?? '');
                $sheet->setCellValue("AL{$row}", $s['tempat_lahir_ibu'] ?? '');
                $sheet->setCellValue("AM{$row}", (!empty($s['tgl_lahir_ibu']) && $s['tgl_lahir_ibu'] !== '0000-00-00') ? date('Y/m/d', strtotime($s['tgl_lahir_ibu'])) : '');
                $sheet->setCellValue("AN{$row}", $s['pdd_ibu'] ?? ($s['pendidikan_ibu'] ?? ''));
                $sheet->setCellValue("AO{$row}", $s['pekerjaan_ibu'] ?? '');
                $sheet->setCellValue("AP{$row}", $s['penghasilan_ibu'] ?? '');
                $sheet->setCellValue("AQ{$row}", $s['no_hp_ortu'] ?? ($s['telepon'] ?? ''));
                // Data Wali
                $sheet->setCellValue("AR{$row}", $s['nama_wali'] ?? '');
                $sheet->setCellValue("AS{$row}", $s['nik_wali'] ?? '');
                $sheet->setCellValue("AT{$row}", $s['tempat_lahir_wali'] ?? '');
                $sheet->setCellValue("AU{$row}", (!empty($s['tgl_lahir_wali']) && $s['tgl_lahir_wali'] !== '0000-00-00') ? date('Y/m/d', strtotime($s['tgl_lahir_wali'])) : '');
                $sheet->setCellValue("AV{$row}", $s['pdd_wali'] ?? '');
                $sheet->setCellValue("AW{$row}", $s['pekerjaan_wali'] ?? '');
                $sheet->setCellValue("AX{$row}", $s['penghasilan_wali'] ?? '');
                // Asal Sekolah
                $sheet->setCellValue("AY{$row}", $s['nama_sekolah'] ?? '');
                $sheet->setCellValue("AZ{$row}", $s['npsn_sekolah'] ?? '');
                $sheet->setCellValue("BA{$row}", $s['jenjang_sekolah'] ?? '');
                $sheet->setCellValue("BB{$row}", $s['status_sekolah'] ?? '');
                $sheet->setCellValue("BC{$row}", $s['lokasi_sekolah'] ?? '');
                // Kesejahteraan
                $sheet->setCellValue("BD{$row}", $s['no_kks'] ?? '');
                $sheet->setCellValue("BE{$row}", $s['no_pkh'] ?? '');
                $sheet->setCellValue("BF{$row}", $s['no_kip'] ?? '');
                // Status
                $sheet->setCellValue("BG{$row}", $s['status_verifikasi'] ?? '');
                $sheet->setCellValue("BH{$row}", isset($s['tgl_siswa']) ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '');
                // Tambahan
                $sheet->setCellValue("BI{$row}", $s['jalur_pendaftaran'] ?? '');
                $sheet->setCellValue("BJ{$row}", $s['jarak'] ?? '');
                $sheet->setCellValue("BK{$row}", $s['trans'] ?? '');
                $sheet->setCellValue("BL{$row}", $s['komp_ahli'] ?? '');
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
