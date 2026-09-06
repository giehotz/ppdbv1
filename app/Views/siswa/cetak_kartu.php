<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Tanda Peserta PPDB - <?= esc($siswa['nama_lengkap']) ?></title>
    <style>
        /* A4 Page Setup */
        @page {
            size: A4;
            margin: 1cm;
        }

        :root {
            --primary-color: #1e3a8a; /* Deep Blue */
            --secondary-color: #10b981; /* Emerald */
            --text-dark: #1f2937;
            --text-light: #ffffff;
            --border-color: #e5e7eb;
        }

        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background-color: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Print Specific Styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
                display: block;
            }

            .no-print {
                display: none !important;
            }

            .card-wrapper {
                margin: 0 auto;
                padding-top: 1cm;
            }
            
            .card-container {
                box-shadow: none !important;
                border: 1px solid #eee !important;
                page-break-inside: avoid;
                margin-bottom: 10mm !important;
            }
        }

        /* Floating Controls */
        .controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-print { background-color: var(--secondary-color); color: white; }
        .btn-print:hover { background-color: #059669; transform: translateY(-1px); }
        .btn-close { background-color: #3b82f6; color: white; }
        .btn-close:hover { background-color: #2563eb; }

        /* Card Dimensions: 86mm x 54mm */
        .card-container {
            width: 86mm;
            height: 54mm;
            background-color: white;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            border: 1px solid #d1d5db;
        }

        /* Background pattern overlay */
        .card-bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 0;
            opacity: 0.1;
            pointer-events: none;
        }

        /* Header Layout */
        .card-header {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            padding: 6px 10px;
            background: linear-gradient(to right, #ffffff, #f8fafc);
            border-bottom: 1.5px solid var(--primary-color);
        }

        .header-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
            margin-right: 8px;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-text h3 {
            margin: 0;
            font-size: 7px;
            color: #4b5563;
            letter-spacing: 0.3px;
        }

        .header-text h1 {
            margin: 1px 0;
            font-size: 10px;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1.1;
        }

        .header-text p {
            margin: 0;
            font-size: 5.5px;
            color: #6b7280;
            line-height: 1.2;
        }

        /* Card Content Area */
        .card-content {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            padding: 8px;
            gap: 10px;
        }

        /* Photo Styles */
        .photo-box {
            width: 22mm;
            height: 30mm;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background-color: #f9fafb;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            font-size: 8px;
            color: #9ca3af;
            text-align: center;
        }

        /* Student Information Details */
        .info-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-type-title {
            font-size: 9px;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 1px 0;
            font-size: 7px;
            vertical-align: top;
        }

        .info-table .label {
            color: #4b5563;
            width: 50px;
            font-weight: 600;
        }

        .info-table .separator {
            width: 6px;
            text-align: center;
            color: #9ca3af;
        }

        .info-table .value {
            color: var(--text-dark);
            font-weight: 700;
        }

        /* Barcode Area at Front */
        .barcode-area {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f8fafc;
            padding: 2px 4px;
            border-radius: 3px;
            border: 1px solid #e2e8f0;
        }

        .barcode-text {
            font-family: 'Courier New', Courier, monospace;
            font-size: 7px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .qr-front {
            width: 12mm;
            height: 12mm;
        }

        /* BACK SIDE STYLES */
        .back-container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 8px;
            position: relative;
            z-index: 1;
        }

        .rules-section {
            font-size: 6px;
            color: #374151;
            line-height: 1.3;
        }

        .rules-text ol {
            margin: 0;
            padding-left: 12px;
        }

        .rules-text li {
            margin-bottom: 2px;
        }

        .footer-back {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: auto;
        }

        .qr-side {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            margin-bottom: 2px;
            margin-left: 2px;
        }

        .qr-text {
            font-size: 5.5px;
            font-weight: 700;
            color: #4b5563;
            letter-spacing: 0.2px;
        }

        .qr-back-large {
            width: 16mm;
            height: 16mm;
            border: 1px solid #d1d5db;
            padding: 2px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .signature-area {
            text-align: center;
            min-width: 40mm;
        }

        .sig-date {
            font-size: 7.5px;
            color: #4b5563;
        }

        .sig-title {
            font-size: 7.5px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .sig-image-wrapper {
            position: relative;
            height: 12mm;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sig-stempel {
            position: absolute;
            left: 2mm;
            height: 11mm;
            opacity: 0.8;
            mix-blend-mode: multiply;
            z-index: 2;
        }

        .sig-ttd {
            height: 11mm;
            z-index: 1;
            position: relative;
        }

        .sig-name {
            font-size: 7.5px;
            font-weight: 800;
            color: #111827;
            text-decoration: underline;
        }

        .sig-nip {
            font-size: 7px;
            color: #4b5563;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <div class="controls no-print">
        <button class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Kartu Sekarang
        </button>
        <a href="<?= base_url('siswa/dashboard') ?>" class="btn btn-close">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- FRONT SIDE -->
    <div class="card-container" style="<?php if (!empty($layout['bg_depan'])): ?>background-image: url('<?= base_url('uploads/kartu/' . $layout['bg_depan']) ?>'); background-size: cover;<?php endif; ?>">
        <div class="card-bg-overlay"></div>
        
        <div class="card-header">
            <?php if (!empty($instansi['logo_sekolah'])): ?>
                <img src="<?= base_url('uploads/logo/' . $instansi['logo_sekolah']) ?>" class="header-logo" alt="Logo">
            <?php endif; ?>
            <div class="header-text">
                <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU</h3>
                <h1><?= esc($instansi['nama_sekolah'] ?? 'NAMA INSTANSI SEKOLAH') ?></h1>
                <p><?= esc($instansi['alamat_sekolah'] ?? 'Alamat instansi belum diatur') ?></p>
            </div>
        </div>

        <div class="card-content">
            <div class="photo-box">
                <?php if (!empty($siswa['foto_berkas']) && file_exists(FCPATH . $siswa['foto_berkas'])): ?>
                    <img src="<?= base_url($siswa['foto_berkas']) ?>" alt="Foto Siswa">
                <?php elseif (!empty($siswa['foto']) && file_exists(FCPATH . 'uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto'])): ?>
                    <img src="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto']) ?>" alt="Foto Siswa">
                <?php else: ?>
                    <div class="photo-placeholder">
                        <i class="fas fa-user fa-2x" style="margin-bottom: 2px;"></i><br>
                        FOTO 3x4
                    </div>
                <?php endif; ?>
            </div>

            <div class="info-box">
                <div class="card-type-title">KARTU TANDA PESERTA PPDB</div>
                
                <table class="info-table">
                    <tr>
                        <td class="label">No. Daftar</td>
                        <td class="separator">:</td>
                        <td class="value" style="color: var(--primary-color); font-family: monospace;"><?= esc($siswa['no_pendaftaran'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">NISN</td>
                        <td class="separator">:</td>
                        <td class="value" style="font-family: monospace;"><?= esc($siswa['nisn'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">Nama</td>
                        <td class="separator">:</td>
                        <td class="value"><?= esc($siswa['nama_lengkap'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">TTL</td>
                        <td class="separator">:</td>
                        <td class="value">
                            <?= esc($siswa['tempat_lahir'] ?? '-') ?>, 
                            <?= !empty($siswa['tgl_lahir']) ? date('d/m/Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Jalur</td>
                        <td class="separator">:</td>
                        <td class="value"><?= esc($siswa['jalur_pendaftaran'] ?? 'Reguler') ?></td>
                    </tr>
                </table>

                <div class="barcode-area">
                    <span class="barcode-text"><?= esc($siswa['no_pendaftaran'] ?? '-') ?></span>
                    <div class="qr-front">
                        <img src="<?= generate_qr_base64(base_url('verify/' . ($siswa['no_pendaftaran'] ?? 'invalid')), 60, 1) ?>" style="width:100%; height:100%;" alt="QR Mini">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BACK SIDE -->
    <div class="card-container" style="background-color: #ffffff; <?php if (!empty($layout['bg_belakang'])): ?>background-image: url('<?= base_url('uploads/kartu/' . $layout['bg_belakang']) ?>'); background-size: cover;<?php endif; ?>">
        <div class="back-container">
            <div class="rules-section">
                <div style="font-size: 8px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 2px; margin-bottom: 4px; color: var(--primary-color);">
                    TATA TERTIB &amp; KETENTUAN PESERTA PPDB
                </div>
                <div class="rules-text">
                    <ol>
                        <li>Kartu ini adalah bukti resmi pendaftaran calon peserta didik baru di <?= esc($instansi['nama_sekolah'] ?? 'Sekolah') ?>.</li>
                        <li>Wajib dibawa saat pelaksanaan tes/ujian seleksi, wawancara, atau verifikasi berkas fisik.</li>
                        <li>Peserta wajib hadir paling lambat 15 menit sebelum kegiatan seleksi dimulai.</li>
                        <li>Jaga kartu ini dengan baik hingga rangkaian proses penerimaan dan daftar ulang selesai.</li>
                    </ol>
                </div>
            </div>

            <div class="footer-back">
                <div class="qr-side">
                    <div class="qr-back-large">
                        <img src="<?= generate_qr_base64(base_url('verify/' . ($siswa['no_pendaftaran'] ?? 'invalid')), 120, 5, $qr['ecc_level'] ?? 'M') ?>" style="width:100%; height: 100%; display: block;" alt="QR">
                    </div>
                    <span class="qr-text">Scan Verifikasi</span>
                </div>

                <div class="signature-area">
                    <?php
                    $bulanIndo = [
                        'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
                        'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
                        'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober',
                        'November' => 'November', 'December' => 'Desember'
                    ];
                    $tglTtd = !empty($ttd['tgl_ttd']) ? date('d F Y', strtotime($ttd['tgl_ttd'])) : date('d F Y');
                    $tglIndo = strtr($tglTtd, $bulanIndo);
                    ?>
                    <div class="sig-date"><?= esc($ttd['kota_ttd'] ?? $instansi['kabupaten'] ?? $instansi['kab'] ?? 'Kabupaten') ?>, <?= $tglIndo ?></div>
                    <div class="sig-title"><?= esc($ttd['jabatan'] ?? 'Ketua Panitia PPDB') ?></div>
                    
                    <div class="sig-image-wrapper">
                        <?php if (!empty($ttd['file_cap'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_cap']) ?>" class="sig-stempel" alt="Stempel">
                        <?php endif; ?>

                        <?php if (!empty($ttd['file_ttd'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_ttd']) ?>" class="sig-ttd" alt="TTD">
                        <?php endif; ?>
                    </div>

                    <div class="sig-name"><?= esc($ttd['nama_pejabat'] ?? $instansi['nama_kepala'] ?? 'Nama Kepala Sekolah') ?></div>
                    <div class="sig-nip">NIP. <?= esc($ttd['nip_pejabat'] ?? $instansi['nip_kepala'] ?? '-') ?></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
