<?php
helper('kop');

// Format tanggal resmi Indonesia
$namaBulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];
$tglSekarang = (int)date('j');
$blnSekarang = $namaBulan[(int)date('n')] ?? date('F');
$thnSekarang = date('Y');
$tglCetakResmi = "{$tglSekarang} {$blnSekarang} {$thnSekarang}";

$appAlias = !empty($web['app_alias']) ? $web['app_alias'] : 'PPDB';
$appName  = !empty($web['app_name']) ? $web['app_name'] : 'Penerimaan Peserta Didik Baru';

$nomorSurat = '............................................................';

$namaSekolah = $web['nama_sekolah'] ?? 'Madrasah';
$namaKepala  = $web['nama_kepala'] ?? '';
$nipKepala   = $web['nip_kepala'] ?? '';
$kabupaten   = $web['kabupaten'] ?? 'Tanggamus';
$npsn        = $web['npsn'] ?? '-';
$nsm         = $web['nsm'] ?? '-';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resmi <?= esc($appAlias) ?> - <?= esc($namaSekolah) ?> (TP <?= esc($selectedTh) ?>)</title>
    <style>
        /* Pengaturan Kertas Standar Cetak Dinas (A4) */
        @page {
            size: A4 portrait;
            margin: 15mm 18mm 15mm 18mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.35;
            color: #111;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
        }

        /* Container Tampilan Preview */
        .paper-container {
            max-width: 210mm;
            padding: 18mm 20mm;
            margin: 25px auto 40px auto;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            min-height: 297mm;
            position: relative;
        }

        /* Kontrol Tombol Layar */
        .controls-bar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #1e293b;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .controls-title {
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .controls-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn {
            border: none;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s;
            font-family: Arial, sans-serif;
        }
        .btn-print {
            background-color: #0284c7;
            color: #fff;
        }
        .btn-print:hover {
            background-color: #0369a1;
        }
        .btn-back {
            background-color: #475569;
            color: #fff;
        }
        .btn-back:hover {
            background-color: #334155;
        }

        /* Gaya Khusus Mode Cetak */
        @media print {
            body {
                background-color: #fff !important;
            }
            .controls-bar {
                display: none !important;
            }
            .paper-container {
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .page-break {
                page-break-before: always;
            }
            .no-break {
                page-break-inside: avoid;
            }
            tr {
                page-break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
        }

        /* Tipografi Laporan Dinas */
        .doc-header {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 18px;
        }
        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 3px 0;
            line-height: 1.25;
        }
        .doc-number {
            font-size: 11pt;
            font-weight: normal;
            margin: 0 0 10px 0;
        }
        .doc-meta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-bottom: 16px;
            background: #fafafa;
            border: 1px solid #000;
        }
        .doc-meta-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .doc-meta-table td.label {
            width: 22%;
            font-weight: bold;
        }
        .doc-meta-table td.sep {
            width: 2%;
            text-align: center;
        }
        .doc-meta-table td.val {
            width: 26%;
        }

        /* Pengantar */
        .intro-text {
            text-align: justify;
            text-indent: 32px;
            margin-bottom: 16px;
            font-size: 11pt;
            line-height: 1.45;
        }

        /* Judul Bab / Bagian */
        .chapter-title {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 16px;
            margin-bottom: 6px;
            padding: 4px 8px;
            background-color: #f1f1f1;
            border: 1px solid #000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Tabel Data Kedinasan */
        .dinas-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10pt;
        }
        .dinas-table th, .dinas-table td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: middle;
        }
        .dinas-table th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 9.5pt;
        }
        .dinas-table td.center {
            text-align: center;
        }
        .dinas-table td.right {
            text-align: right;
        }
        .dinas-table td.bold {
            font-weight: bold;
        }
        .dinas-table tr.total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Rangkuman 2 Kolom */
        .two-column-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .two-column-table td.col {
            vertical-align: top;
            width: 50%;
        }
        .two-column-table td.col:first-child {
            padding-right: 8px;
        }
        .two-column-table td.col:last-child {
            padding-left: 8px;
        }

        /* Catatan / Rekomendasi */
        .notes-list {
            margin: 4px 0 16px 0;
            padding-left: 24px;
            font-size: 10.5pt;
            line-height: 1.4;
        }
        .notes-list li {
            margin-bottom: 4px;
            text-align: justify;
        }

        /* Tanda Tangan Kedinasan */
        .signature-wrapper {
            margin-top: 30px;
            width: 100%;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            text-align: center;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding: 0 15px;
        }
        .sig-date {
            margin-bottom: 6px;
        }
        .sig-role {
            font-weight: bold;
            margin-bottom: 65px; /* Ruang untuk tanda tangan & stempel */
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }
        .sig-nip {
            font-size: 10pt;
        }

        /* Lampiran */
        .lampiran-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .lampiran-tag {
            font-size: 10pt;
            font-style: italic;
            margin-bottom: 3px;
        }
        .lampiran-title {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .lampiran-sub {
            font-size: 10pt;
            margin-bottom: 12px;
        }

        /* Nominatif Table (Small text) */
        .nominatif-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-bottom: 15px;
        }
        .nominatif-table th, .nominatif-table td {
            border: 1px solid #000;
            padding: 3.5px 5px;
            line-height: 1.25;
        }
        .nominatif-table th {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: center;
        }

        /* Footer Halaman Dinas */
        .footer-note {
            font-size: 8.5pt;
            color: #555;
            border-top: 1px dashed #999;
            padding-top: 5px;
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

    <!-- Bar Kontrol Layar (Tidak ikut tercetak) -->
    <div class="controls-bar">
        <div class="controls-title">
            <span>&#128196; Preview Laporan Resmi Kedinasan <?= esc($appAlias) ?> - Tahun Ajaran <?= esc($selectedTh) ?></span>
        </div>
        <div class="controls-actions">
            <a href="<?= base_url('admin/laporan') ?>" class="btn btn-back">
                &larr; Kembali
            </a>
            <button onclick="window.print()" class="btn btn-print">
                &#128438; Cetak Dokumen / PDF
            </button>
        </div>
    </div>

    <!-- Halaman Dokumen Laporan Utama -->
    <div class="paper-container">

        <!-- KOP Surat Resmi Standard -->
        <?= render_kop_surat() ?>

        <!-- Judul dan Nomor Registrasi Dokumen -->
        <div class="doc-header">
            <div class="doc-title">
                LAPORAN RESMI REKAPITULASI DAN EVALUASI HASIL<br>
                <?= strtoupper(esc($appName)) ?> (<?= strtoupper(esc($appAlias)) ?>)<br>
                TAHUN PELAJARAN <?= esc($selectedTh) ?>
            </div>
            <div class="doc-number">
                Nomor: <?= esc($nomorSurat) ?>
            </div>
        </div>

        <!-- Tabel Identitas & Parameter Laporan -->
        <table class="doc-meta-table">
            <tr>
                <td class="label">Satuan Pendidikan</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($namaSekolah) ?></td>
                <td class="label">Tahun Pelajaran</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($selectedTh) ?></td>
            </tr>
            <tr>
                <td class="label">NPSN / NSM</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($npsn) ?> / <?= esc($nsm) ?></td>
                <td class="label">Status <?= esc($appAlias) ?></td>
                <td class="sep">:</td>
                <td class="val"><?= esc($web['status_ppdb'] ?? 'Selesai') ?></td>
            </tr>
            <tr>
                <td class="label">Kabupaten / Kota</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($kabupaten) ?></td>
                <td class="label">Waktu Rekap Data</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($waktu_cetak) ?> WIB</td>
            </tr>
        </table>

        <!-- Paragraf Pengantar Resmi -->
        <div class="intro-text">
            Berdasarkan keseluruhan tahapan pelaksanaan kegiatan <?= esc($appName) ?> (<?= esc($appAlias) ?>) Tahun Pelajaran <?= esc($selectedTh) ?> yang telah diselenggarakan secara tertib, transparan, dan akuntabel, bersama ini Panitia Pelaksana <?= esc($appAlias) ?> menyampaikan laporan resmi rekapitulasi data pendaftar, hasil verifikasi berkas administrasi, statistik demografi, sebaran jalur pendaftaran, pemetaan asal lembaga pengumpan, dan sebaran wilayah pendaftar sebagai berikut:
        </div>

        <!-- BAB I: REKAPITULASI UMUM PENDAFTARAN & VERIFIKASI -->
        <div class="chapter-title">I. REKAPITULASI PENDAFTARAN DAN STATUS VERIFIKASI BERKAS</div>
        <?php
        $totalPendaftar = (int)($statistik['total_pendaftar'] ?? 0);
        $terverifikasi  = (int)($statistik['terverifikasi'] ?? 0);
        $menunggu       = (int)($statistik['menunggu'] ?? 0);
        $ditolak        = (int)($statistik['ditolak'] ?? 0);

        $pctVerif = $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100, 1) : 0;
        $pctWait  = $totalPendaftar > 0 ? round(($menunggu / $totalPendaftar) * 100, 1) : 0;
        $pctRej   = $totalPendaftar > 0 ? round(($ditolak / $totalPendaftar) * 100, 1) : 0;
        ?>
        <table class="dinas-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 48%; text-align: left;">Indikator Status Pendaftaran</th>
                    <th style="width: 16%;">Jumlah Siswa</th>
                    <th style="width: 14%;">Persentase</th>
                    <th style="width: 16%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">1</td>
                    <td>Berkas Terverifikasi (Dinyatakan Lengkap &amp; Sah)</td>
                    <td class="center bold"><?= number_format($terverifikasi) ?></td>
                    <td class="center"><?= $pctVerif ?>%</td>
                    <td class="center">Memenuhi Syarat</td>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>Menunggu Verifikasi (Antrean Validasi Dokumen)</td>
                    <td class="center"><?= number_format($menunggu) ?></td>
                    <td class="center"><?= $pctWait ?>%</td>
                    <td class="center">Proses Evaluasi</td>
                </tr>
                <tr>
                    <td class="center">3</td>
                    <td>Berkas Ditolak (Tidak Memenuhi Persyaratan Administrasi)</td>
                    <td class="center"><?= number_format($ditolak) ?></td>
                    <td class="center"><?= $pctRej ?>%</td>
                    <td class="center">Diskualifikasi</td>
                </tr>
                <tr class="total-row">
                    <td class="center" colspan="2">TOTAL KESELURUHAN CALON PESERTA DIDIK TERDAFTAR</td>
                    <td class="center"><?= number_format($totalPendaftar) ?></td>
                    <td class="center">100.0%</td>
                    <td class="center">Akun Resmi</td>
                </tr>
            </tbody>
        </table>

        <!-- BAB II: TREN PERTUMBUHAN DIBANDING TAHUN SEBELUMNYA -->
        <?php if (!empty($tren)): ?>
        <div class="chapter-title">II. PERBANDINGAN TREN PERTUMBUHAN DENGAN TAHUN SEBELUMNYA</div>
        <table class="dinas-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 38%; text-align: left;">Kelompok Data</th>
                    <th style="width: 18%;">Tahun Lalu (<?= esc($tren['th_prev'] ?: '-') ?>)</th>
                    <th style="width: 18%;">Tahun Ini (<?= esc($tren['th_active']) ?>)</th>
                    <th style="width: 10%;">Selisih</th>
                    <th style="width: 10%;">Pertumbuhan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $trenRows = [
                    'total' => 'Total Keseluruhan Pendaftar',
                    'L'     => 'Pendaftar Laki-laki',
                    'P'     => 'Pendaftar Perempuan',
                ];
                $i = 1;
                foreach ($trenRows as $k => $lbl):
                    $pV = (int)($tren['previous'][$k] ?? 0);
                    $cV = (int)($tren['current'][$k] ?? 0);
                    $diff = $cV - $pV;
                    $pct = $pV > 0 ? round(($diff / $pV) * 100, 1) : ($cV > 0 ? 100 : 0);
                ?>
                <tr>
                    <td class="center"><?= $i++ ?></td>
                    <td class="<?= $k === 'total' ? 'bold' : '' ?>"><?= $lbl ?></td>
                    <td class="center"><?= number_format($pV) ?></td>
                    <td class="center bold"><?= number_format($cV) ?></td>
                    <td class="center"><?= $diff >= 0 ? '+' : '' ?><?= number_format($diff) ?></td>
                    <td class="center"><?= $diff >= 0 ? '+' : '' ?><?= $pct ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <!-- BAB III: STATISTIK DEMOGRAFI & STATUS SELEKSI -->
        <div class="chapter-title">III. STATISTIK DEMOGRAFI GENDER DAN HASIL KELULUSAN</div>
        <table class="two-column-table">
            <tr>
                <td class="col">
                    <table class="dinas-table">
                        <thead>
                            <tr>
                                <th colspan="4">Tabel 3.1: Demografi Jenis Kelamin</th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="text-align: left;">Jenis Kelamin</th>
                                <th style="width: 28%;">Jumlah</th>
                                <th style="width: 24%;">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $jmlL = (int)($gender['L'] ?? 0);
                            $jmlP = (int)($gender['P'] ?? 0);
                            $totG = $jmlL + $jmlP;
                            $pctL = $totG > 0 ? round(($jmlL / $totG) * 100, 1) : 0;
                            $pctP = $totG > 0 ? round(($jmlP / $totG) * 100, 1) : 0;
                            ?>
                            <tr>
                                <td class="center">1</td>
                                <td>Laki-laki (L)</td>
                                <td class="center bold"><?= number_format($jmlL) ?></td>
                                <td class="center"><?= $pctL ?>%</td>
                            </tr>
                            <tr>
                                <td class="center">2</td>
                                <td>Perempuan (P)</td>
                                <td class="center bold"><?= number_format($jmlP) ?></td>
                                <td class="center"><?= $pctP ?>%</td>
                            </tr>
                            <tr class="total-row">
                                <td class="center" colspan="2">Jumlah Keseluruhan</td>
                                <td class="center"><?= number_format($totG) ?></td>
                                <td class="center">100.0%</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class="col">
                    <table class="dinas-table">
                        <thead>
                            <tr>
                                <th colspan="4">Tabel 3.2: Rekapitulasi Status Kelulusan</th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="text-align: left;">Status Hasil</th>
                                <th style="width: 28%;">Jumlah</th>
                                <th style="width: 24%;">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lulus       = (int)($kelulusan['lulus'] ?? 0);
                            $tidakLulus  = (int)($kelulusan['tidak_lulus'] ?? 0);
                            $belumProses = (int)($kelulusan['belum_diproses'] ?? 0);
                            $totKel      = $lulus + $tidakLulus + $belumProses;

                            $pctLulus    = $totKel > 0 ? round(($lulus / $totKel) * 100, 1) : 0;
                            $pctTLulus   = $totKel > 0 ? round(($tidakLulus / $totKel) * 100, 1) : 0;
                            $pctBProses  = $totKel > 0 ? round(($belumProses / $totKel) * 100, 1) : 0;
                            ?>
                            <tr>
                                <td class="center">1</td>
                                <td>Lulus Seleksi</td>
                                <td class="center bold"><?= number_format($lulus) ?></td>
                                <td class="center"><?= $pctLulus ?>%</td>
                            </tr>
                            <tr>
                                <td class="center">2</td>
                                <td>Tidak Lulus</td>
                                <td class="center"><?= number_format($tidakLulus) ?></td>
                                <td class="center"><?= $pctTLulus ?>%</td>
                            </tr>
                            <tr>
                                <td class="center">3</td>
                                <td>Pending / Belum Diproses</td>
                                <td class="center"><?= number_format($belumProses) ?></td>
                                <td class="center"><?= $pctBProses ?>%</td>
                            </tr>
                            <tr class="total-row">
                                <td class="center" colspan="2">Jumlah Keseluruhan</td>
                                <td class="center"><?= number_format($totKel) ?></td>
                                <td class="center">100.0%</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- BAB IV: SEBARAN JALUR PENDAFTARAN -->
        <div class="chapter-title">IV. SEBARAN DATA BERDASARKAN JALUR PENDAFTARAN</div>
        <table class="dinas-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 50%; text-align: left;">Nama Jalur Pendaftaran</th>
                    <th style="width: 22%;">Jumlah Pendaftar</th>
                    <th style="width: 22%;">Persentase Kontribusi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jalur)): ?>
                    <tr><td colspan="4" class="center" style="font-style: italic;">Belum ada data pendaftar pada jalur pendaftaran</td></tr>
                <?php else: ?>
                    <?php
                    $totJalur = array_sum($jalur);
                    $noJ = 1;
                    foreach ($jalur as $namaJalur => $countJalur):
                        $pctJ = $totJalur > 0 ? round(($countJalur / $totJalur) * 100, 1) : 0;
                    ?>
                    <tr>
                        <td class="center"><?= $noJ++ ?></td>
                        <td><?= esc($namaJalur) ?></td>
                        <td class="center bold"><?= number_format($countJalur) ?></td>
                        <td class="center"><?= $pctJ ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td class="center" colspan="2">TOTAL SELURUH JALUR PENDAFTARAN</td>
                        <td class="center"><?= number_format($totJalur) ?></td>
                        <td class="center">100.0%</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- BAB V: ASAL SEKOLAH & SEBARAN WILAYAH -->
        <div class="chapter-title">V. PEMETAAN LEMBAGA PENGUMPAN DAN SEBARAN WILAYAH</div>
        <table class="two-column-table">
            <tr>
                <td class="col">
                    <table class="dinas-table">
                        <thead>
                            <tr>
                                <th colspan="3">Tabel 5.1: Top 5 Lembaga Asal Pengumpan</th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="text-align: left;">Nama Sekolah / Madrasah</th>
                                <th style="width: 28%;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($topSekolah)): ?>
                                <tr><td colspan="3" class="center" style="font-style: italic;">Tidak ada data asal sekolah</td></tr>
                            <?php else: ?>
                                <?php $nS = 1; foreach ($topSekolah as $sek): ?>
                                <tr>
                                    <td class="center"><?= $nS++ ?></td>
                                    <td><?= esc(strtoupper($sek['nama_sekolah'])) ?></td>
                                    <td class="center bold"><?= number_format($sek['total']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </td>
                <td class="col">
                    <table class="dinas-table">
                        <thead>
                            <tr>
                                <th colspan="3">Tabel 5.2: Top 5 Sebaran Wilayah (Kecamatan)</th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">No</th>
                                <th style="text-align: left;">Kecamatan Tempat Tinggal</th>
                                <th style="width: 28%;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($topWilayah)): ?>
                                <tr><td colspan="3" class="center" style="font-style: italic;">Tidak ada data sebaran wilayah</td></tr>
                            <?php else: ?>
                                <?php $nW = 1; foreach ($topWilayah as $wil): ?>
                                <tr>
                                    <td class="center"><?= $nW++ ?></td>
                                    <td><?= esc(ucwords(strtolower($wil['kec']))) ?></td>
                                    <td class="center bold"><?= number_format($wil['total']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- BAB VI: CATATAN DAN REKOMENDASI TINDAK LANJUT -->
        <div class="chapter-title">VI. CATATAN EVALUASI DAN REKOMENDASI TINDAK LANJUT</div>
        <ol class="notes-list">
            <li>Bagi calon peserta didik baru yang telah dinyatakan <strong>LULUS SELEKSI</strong>, diwajibkan untuk segera menyelesaikan registrasi atau tahapan <strong>Daftar Ulang</strong> sesuai dengan ketentuan batas waktu kalender kedinasan.</li>
            <li>Calon peserta didik yang masih berstatus <strong>Menunggu Verifikasi</strong> diharapkan segera mengonfirmasi dan melengkapi dokumen persyaratan administratif fisik maupun digital kepada tim panitia verifikator.</li>
            <li>Laporan ini diterbitkan secara sah berdasarkan rekaman data elektronik pada pangkalan data sistem <?= esc($appAlias) ?> resmi per tanggal pencetakan dan dapat dipergunakan sebagai bahan pelaporan pertanggungjawaban kedinasan.</li>
        </ol>

        <!-- LEMBAR PENGESAHAN KEDINASAN -->
        <div class="signature-wrapper no-break">
            <table class="signature-table">
                <tr>
                    <td>
                        <div class="sig-date">&nbsp;</div>
                        <div class="sig-role">
                            Mengetahui / Memeriksa,<br>
                            Ketua Panitia <?= esc($appAlias) ?>
                        </div>
                        <div class="sig-name"><?= esc($dicetak_oleh) ?></div>
                        <div class="sig-nip">Koordinator Pelaksana</div>
                    </td>
                    <td>
                        <div class="sig-date">
                            <?= esc($kabupaten) ?>, <?= $tglCetakResmi ?>
                        </div>
                        <div class="sig-role">
                            Kepala Madrasah / Sekolah,
                        </div>
                        <div class="sig-name"><?= esc(!empty($namaKepala) ? $namaKepala : '......................................................') ?></div>
                        <div class="sig-nip">NIP. <?= esc(!empty($nipKepala) ? $nipKepala : '......................................................') ?></div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Catatan Kaki Laporan Utama -->
        <div class="footer-note">
            <span>Sistem Informasi <?= esc($appAlias) ?> Online &bull; <?= esc($namaSekolah) ?></span>
            <span>Dicetak oleh: <?= esc($dicetak_oleh) ?> &bull; <?= esc($waktu_cetak) ?> WIB</span>
        </div>

    </div>

    <!-- HALAMAN LAMPIRAN: DAFTAR NOMINATIF PESERTA DIDIK BARU (DNP) -->
    <div class="paper-container page-break">

        <!-- KOP Surat Resmi pada Halaman Lampiran -->
        <?= render_kop_surat() ?>

        <div class="lampiran-header">
            <div class="lampiran-tag">Lampiran Laporan Resmi <?= esc($appAlias) ?></div>
            <div class="lampiran-title">DAFTAR NOMINATIF CALON PESERTA DIDIK BARU (DNP)</div>
            <div class="lampiran-sub">Tahun Pelajaran <?= esc($selectedTh) ?> &bull; Tanggal Rekapitulasi: <?= esc($waktu_cetak) ?> WIB</div>
        </div>

        <table class="nominatif-table">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 14%;">No. Registrasi</th>
                    <th style="width: 12%;">NISN</th>
                    <th style="width: 25%; text-align: left;">Nama Lengkap Calon Siswa</th>
                    <th style="width: 5%;">L/P</th>
                    <th style="width: 12%;">Jalur</th>
                    <th style="width: 16%; text-align: left;">Asal Lembaga/Sekolah</th>
                    <th style="width: 12%;">Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($semua_siswa)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; font-style: italic; padding: 12px;">
                            Tidak ada data calon peserta didik yang terdaftar pada periode tahun pelajaran ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $noS = 1; foreach ($semua_siswa as $s): ?>
                    <tr>
                        <td style="text-align: center;"><?= $noS++ ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= esc($s['no_pendaftaran']) ?></td>
                        <td style="text-align: center;"><?= esc($s['nisn'] ?: '-') ?></td>
                        <td><?= esc($s['nama_lengkap']) ?></td>
                        <td style="text-align: center;"><?= esc($s['jk'] ?? '-') ?></td>
                        <td style="text-align: center;"><?= esc($s['jalur_pendaftaran'] ?? 'Reguler') ?></td>
                        <td><?= esc(!empty($s['nama_sekolah']) ? strtoupper($s['nama_sekolah']) : '-') ?></td>
                        <td style="text-align: center;"><?= esc($s['status_verifikasi'] ?? 'Menunggu') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pengesahan Singkat Lampiran -->
        <div class="signature-wrapper no-break" style="margin-top: 20px;">
            <table class="signature-table" style="font-size: 10pt;">
                <tr>
                    <td style="text-align: left; padding-left: 20px;">
                        <p style="margin: 0; font-size: 9pt; color: #444;">
                            * DNP ini merupakan lampiran yang tidak terpisahkan dari Laporan Resmi <?= esc($appAlias) ?>.<br>
                            * Data diperbarui secara *real-time* dari sistem registrasi daring.
                        </p>
                    </td>
                    <td style="text-align: center;">
                        <div class="sig-date"><?= esc($kabupaten) ?>, <?= $tglCetakResmi ?></div>
                        <div class="sig-role" style="margin-bottom: 50px;">
                            Penanggung Jawab Data / Panitia <?= esc($appAlias) ?>,
                        </div>
                        <div class="sig-name"><?= esc($dicetak_oleh) ?></div>
                        <div class="sig-nip">Koordinator Verifikator</div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Catatan Kaki Lampiran -->
        <div class="footer-note">
            <span>Lampiran DNP &bull; <?= esc($namaSekolah) ?></span>
            <span>Halaman Lampiran Resmi &bull; <?= esc($waktu_cetak) ?> WIB</span>
        </div>

    </div>

</body>
</html>
