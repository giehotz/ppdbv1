<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LogAktivitas extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel();
    }

    public function index()
    {
        $data = [
            'logs' => $this->logModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('admin/log_aktivitas/index', $data);
    }

    public function clear()
    {
        $confirm = $this->request->getPost('confirm_text');
        if ($confirm !== 'HAPUS LOG') {
            session()->setFlashdata('error', 'Penghapusan ditolak. Teks konfirmasi tidak sesuai.');
            return redirect()->to('/admin/log_aktivitas');
        }

        $this->logModel->emptyTable();
        
        // Catat log bahwa admin menghapus log
        catat_log('Hapus Log', 'Semua riwayat log aktivitas telah dihapus');

        session()->setFlashdata('success', 'Semua log aktivitas berhasil dihapus.');
        return redirect()->to('/admin/log_aktivitas');
    }

    public function exportExcel()
    {
        $role = $this->request->getGet('role');
        $tindakan = $this->request->getGet('tindakan');
        $keyword = $this->request->getGet('keyword');

        // Initialize model again without pagination features
        $logs = $this->logModel->getLogs($role, $tindakan, $keyword)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Log Aktivitas');

        $headers = [
            'A' => 'No',
            'B' => 'Waktu',
            'C' => 'Pengguna',
            'D' => 'Role',
            'E' => 'Tindakan',
            'F' => 'Keterangan',
            'G' => 'IP Address',
            'H' => 'User Agent'
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
        }

        // Style header row
        $sheet->getStyle('A1:H1')->applyFromArray([
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

        $row = 2;
        $no = 1;

        if (!empty($logs)) {
            foreach ($logs as $log) {
                $sheet->setCellValue("A{$row}", $no++);
                $sheet->setCellValue("B{$row}", $log['created_at']);
                $sheet->setCellValue("C{$row}", $log['nama_user']);
                $sheet->setCellValue("D{$row}", $log['role']);
                $sheet->setCellValue("E{$row}", $log['tindakan']);
                $sheet->setCellValue("F{$row}", $log['keterangan']);
                $sheet->setCellValue("G{$row}", $log['ip_address']);
                $sheet->setCellValue("H{$row}", $log['user_agent']);
                $row++;
            }
            
            // Apply borders
            $sheet->getStyle("A1:H" . ($row - 1))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
        }

        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Log_Aktivitas_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
