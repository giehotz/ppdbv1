<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Data PPDB</title>
    <style>
        /* A4 Layout Styling */
        @page {
            size: A4;
            margin: 15mm 20mm; /* Atur margin bawaan browser untuk halaman cetak */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
            background-color: #eee;
        }
        .paper-container {
            max-width: 210mm;
            padding: 20mm;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            box-sizing: border-box;
            position: relative;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .paper-container {
                margin: 0;
                padding: 0; /* Padding dihilangkan karena @page sudah memiliki margin */
                box-shadow: none;
                max-width: 100%;
            }
            .print-btn {
                display: none;
            }
            /* Menghindari baris tabel/blok terpotong di tengah halaman */
            .signature-container {
                page-break-inside: avoid;
            }
            tr {
                page-break-inside: avoid;
            }
        }

        /* Top controls */
        .controls {
            text-align: center;
            margin-top: 20px;
        }
        .print-btn {
            background-color: #059669;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }
        .print-btn:hover {
            background-color: #047857;
        }

        /* Typography */
        h2.report-title {
            text-align: center;
            font-size: 14pt;
            text-decoration: underline;
            margin-top: 1px;
            margin-bottom: 1px;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
        }
        .report-subtitle {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 25px;
            font-family: Arial, sans-serif;
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            font-size: 11pt;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 10px;
        }
        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .table-small-text th, .table-small-text td {
            font-size: 10pt;
            padding: 4px 6px;
        }
        .section-title {
            font-weight: bold;
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin-bottom: 8px;
            margin-top: 15px;
            background-color: #e0e0e0;
            padding: 4px 8px;
            border: 1px solid #000;
        }

        /* Signatures */
        .signature-container {
            margin-top: 50px;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 11pt;
        }
        .signature-box {
            width: 40%;
            float: right;
            text-align: center;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="controls">
        <button onclick="window.print()" class="print-btn">
            Cetak Laporan PDF
        </button>
    </div>

    <div class="paper-container">
        <!-- KOP Surat Standard -->
        <?php helper('kop'); ?>
        <?= render_kop_surat() ?>

        <h2 class="report-title">Laporan Analisis Data Pendaftar</h2>
        <div class="report-subtitle">Tanggal Cetak: <?= $waktu_cetak ?></div>

        <div class="section-title">A. DAFTAR SELURUH PENDAFTAR</div>
        <table class="data-table table-small-text">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">No. Daftar</th>
                    <th style="width: 15%;">NISN</th>
                    <th style="width: 30%;">Nama Lengkap</th>
                    <th style="width: 5%;">L/P</th>
                    <th style="width: 20%;">Asal Sekolah</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($semua_siswa)): ?>
                    <tr><td colspan="7" style="text-align: center; font-style: italic;">Belum ada data pendaftar</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach($semua_siswa as $s): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++ ?></td>
                        <td style="text-align: center;"><?= esc($s['no_pendaftaran']) ?></td>
                        <td style="text-align: center;"><?= esc($s['nisn']) ?></td>
                        <td><?= esc($s['nama_lengkap']) ?></td>
                        <td style="text-align: center;"><?= esc($s['jk']) ?></td>
                        <td><?= esc($s['nama_sekolah'] ?? '-') ?></td>
                        <td style="text-align: center;"><?= esc($s['status_verifikasi'] ?? 'Menunggu') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="section-title">B. RINGKASAN UMUM</div>
        <table class="data-table">
            <tr>
                <th style="width: 50%; text-align: left;">Keterangan</th>
                <th>Jumlah Siswa</th>
            </tr>
            <tr>
                <td>Total Pendaftar</td>
                <td style="text-align: center; font-weight: bold;"><?= $statistik['total_pendaftar'] ?></td>
            </tr>
            <tr>
                <td>Status: Terverifikasi</td>
                <td style="text-align: center;"><?= $statistik['terverifikasi'] ?></td>
            </tr>
            <tr>
                <td>Status: Menunggu Validasi</td>
                <td style="text-align: center;"><?= $statistik['menunggu'] ?></td>
            </tr>
            <tr>
                <td>Status: Ditolak</td>
                <td style="text-align: center;"><?= $statistik['ditolak'] ?></td>
            </tr>
        </table>

        <div class="section-title">C. STATUS KELULUSAN & DEMOGRAFI</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <table class="data-table">
                        <tr>
                            <th colspan="2">Status Kelulusan</th>
                        </tr>
                        <tr>
                            <td>Lulus</td>
                            <td style="text-align: center; font-weight: bold;"><?= $kelulusan['lulus'] ?></td>
                        </tr>
                        <tr>
                            <td>Tidak Lulus</td>
                            <td style="text-align: center;"><?= $kelulusan['tidak_lulus'] ?></td>
                        </tr>
                        <tr>
                            <td>Belum Diproses</td>
                            <td style="text-align: center;"><?= $kelulusan['belum_diproses'] ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <table class="data-table">
                        <tr>
                            <th colspan="2">Jenis Kelamin</th>
                        </tr>
                        <tr>
                            <td>Laki-laki</td>
                            <td style="text-align: center;"><?= $gender['L'] ?></td>
                        </tr>
                        <tr>
                            <td>Perempuan</td>
                            <td style="text-align: center;"><?= $gender['P'] ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Total</th>
                            <th><?= $gender['L'] + $gender['P'] ?></th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="section-title">D. JALUR PENDAFTARAN</div>
        <table class="data-table">
            <tr>
                <th style="width: 50%; text-align: left;">Jalur</th>
                <th>Jumlah Pendaftar</th>
            </tr>
            <?php if(empty($jalur)): ?>
                <tr>
                    <td colspan="2" style="text-align: center; font-style: italic;">Belum ada data</td>
                </tr>
            <?php else: ?>
                <?php foreach($jalur as $name => $count): ?>
                <tr>
                    <td><?= $name ?></td>
                    <td style="text-align: center;"><?= $count ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <div class="section-title">E. TOP 5 ASAL SEKOLAH & WILAYAH</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <table class="data-table">
                        <tr>
                            <th style="text-align: left;">Top 5 Asal Sekolah</th>
                            <th style="width: 30%;">Jumlah</th>
                        </tr>
                        <?php if(empty($topSekolah)): ?>
                            <tr><td colspan="2" style="text-align: center; font-style: italic;">Belum ada data</td></tr>
                        <?php else: ?>
                            <?php foreach($topSekolah as $sekolah): ?>
                            <tr>
                                <td><?= strtoupper($sekolah['nama_sekolah']) ?></td>
                                <td style="text-align: center;"><?= $sekolah['total'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <table class="data-table">
                        <tr>
                            <th style="text-align: left;">Top 5 Kecamatan</th>
                            <th style="width: 30%;">Jumlah</th>
                        </tr>
                        <?php if(empty($topWilayah)): ?>
                            <tr><td colspan="2" style="text-align: center; font-style: italic;">Belum ada data</td></tr>
                        <?php else: ?>
                            <?php foreach($topWilayah as $wilayah): ?>
                            <tr>
                                <td><?= ucwords(strtolower($wilayah['kec'])) ?></td>
                                <td style="text-align: center;"><?= $wilayah['total'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Signature -->
        <div class="signature-container clearfix">
            <div class="signature-box">
                <p>Dicetak pada: <?= date('d M Y') ?></p>
                <p style="margin-bottom: 70px;">Administrator / Panitia PPDB,</p>
                <p style="font-weight: bold; text-decoration: underline;"><?= strtoupper($dicetak_oleh) ?></p>
            </div>
        </div>

    </div>
</body>
</html>
