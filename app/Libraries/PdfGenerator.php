<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    public function generate(string $viewPath, array $data, string $filename, bool $download = false): void
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'sans-serif');
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view($viewPath, $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if ($download) {
            $dompdf->stream($filename, ['Attachment' => true]);
        } else {
            $dompdf->stream($filename, ['Attachment' => false]);
        }
    }

    /**
     * Generate kuitansi PDF for a given siswa id.
     * This helper collects required data and calls generate().
     *
     * @param int $siswaId
     * @param bool $download
     * @return void
     * @throws \InvalidArgumentException when siswa not found
     * @throws \RuntimeException when not all tagihan are lunas
     */
    public function generateKuitansiForSiswa(int $siswaId, bool $download = false): void
    {
        $siswaModel = new \App\Models\SiswaModel();
        $tagihanModel = new \App\Models\TagihanSiswaModel();
        $pembayaranModel = new \App\Models\PembayaranModel();

        $siswa = $siswaModel->find($siswaId);
        if (!$siswa) {
            throw new \InvalidArgumentException('Data siswa tidak ditemukan.');
        }

        $totalTagihan = $tagihanModel->getTotalTagihan($siswaId);
        $totalLunas = $tagihanModel->getTotalLunas($siswaId);
        $tagihan = $tagihanModel->getTagihanBySiswa($siswaId);
        $riwayatBayar = $pembayaranModel->getRiwayatBySiswa($siswaId);

        if (!$tagihanModel->isAllLunas($siswaId)) {
            throw new \RuntimeException('Kuitansi hanya bisa dicetak setelah semua tagihan lunas.');
        }

        $filename = 'kuitansi_' . ($siswa['no_pendaftaran'] ?? $siswaId) . '.pdf';

        $this->generate('siswa/kuitansi_pdf', [
            'siswa' => $siswa,
            'tagihan' => $tagihan,
            'totalTagihan' => $totalTagihan,
            'totalLunas' => $totalLunas,
            'riwayatBayar' => $riwayatBayar,
        ], $filename, $download);
    }
}
