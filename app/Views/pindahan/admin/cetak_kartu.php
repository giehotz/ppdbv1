<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Pelajar - SISWA PINDAHAN - <?= esc($pindahan['nama_lengkap']) ?></title>
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
        .btn-close { background-color: #ef4444; color: white; }
        .btn-close:hover { background-color: #dc2626; }

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
            overflow: hidden;
            background-color: #f9fafb;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Info Styles */
        .info-box {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-label-main {
            background-color: var(--primary-color);
            color: white;
            font-size: 8px;
            font-weight: 800;
            text-align: center;
            padding: 3px 0;
            border-radius: 3px;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            font-size: 7.5px;
            padding: 1.5px 0;
            vertical-align: top;
            color: var(--text-dark);
        }

        .td-label {
            width: 30%;
            font-weight: 700;
            color: #4b5563;
        }

        .td-separator {
            width: 5px;
            padding-right: 3px !important;
        }

        .td-value {
            font-weight: 600;
        }

        .qr-front {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 10mm;
            height: 10mm;
            background: white;
            padding: 1.5px;
            border: 0.5px solid #ddd;
            border-radius: 2px;
            z-index: 10;
        }

        /* Back Card Styles */
        .back-container {
            padding: 12px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .rules-text {
            font-size: 7px;
            color: #4b5563;
            line-height: 1.4;
        }

        .rules-text ol {
            margin: 5px 0;
            padding-left: 12px;
        }

        .footer-back {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
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
            margin-bottom: 2px;
        }

        .sig-title {
            font-size: 7.5px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .sig-image-wrapper {
            position: relative;
            height: 12mm;
            margin: 2px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sig-stempel {
            position: absolute;
            height: 18mm;
            width: auto;
            left: 50%;
            transform: translateX(-70%) rotate(-5deg);
            opacity: 0.8;
            z-index: 1;
        }

        .sig-ttd {
            position: relative;
            height: 12mm;
            z-index: 2;
        }

        .sig-name {
            font-size: 8px;
            font-weight: bold;
            text-decoration: underline;
        }

        .sig-nip {
            font-size: 7px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <div class="controls no-print">
        <button class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Sekarang
        </button>
        <button class="btn btn-close" onclick="closeOrBack()">
            <i class="fas fa-times"></i> Tutup Halaman
        </button>
    </div>

    <!-- FRONT SIDE -->
    <div class="card-container" style="<?php if (!empty($layout['bg_depan'])): ?>background-image: url('<?= base_url('uploads/kartu/' . $layout['bg_depan']) ?>'); background-size: cover;<?php endif; ?>">
        <div class="card-bg-overlay"></div>
        
        <div class="card-header">
            <?php if (!empty($instansi['logo_sekolah'])): ?>
                <img src="<?= base_url('uploads/logo/' . $instansi['logo_sekolah']) ?>" class="header-logo" alt="Logo">
            <?php endif; ?>
            <div class="header-text">
                <h3>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
                <h1><?= esc($instansi['nama_sekolah'] ?? 'NAMA INSTANSI SEKOLAH') ?></h1>
                <p><?= esc($instansi['alamat_sekolah'] ?? 'Alamat instansi belum diatur') ?></p>
            </div>
        </div>

        <div class="card-content">
            <div class="photo-box">
                <?php
                    helper('kop');
                    $fotoSrc = '';
                    if (empty($fotoBerkas)) {
                        $fotoBerkas = \Config\Database::connect()->table('tbl_berkas_pindahan')
                            ->where('id_pindahan', $pindahan['id_pindahan'])
                            ->where('jenis_berkas', 'foto_siswa')
                            ->get()->getRowArray();
                    }

                    $candidates = [];
                    if (!empty($fotoBerkas['path_file'])) {
                        $candidates[] = $fotoBerkas['path_file'];
                    }
                    if (!empty($fotoBerkas['nama_file'])) {
                        $candidates[] = 'uploads/berkas/' . ($pindahan['nisn'] ?? '') . '/' . $fotoBerkas['nama_file'];
                    }
                    if (!empty($pindahan['foto'])) {
                        if (str_starts_with($pindahan['foto'], 'uploads/')) {
                            $candidates[] = $pindahan['foto'];
                        } else {
                            $candidates[] = 'uploads/berkas/' . ($pindahan['nisn'] ?? '') . '/' . $pindahan['foto'];
                        }
                    }
                    if (!empty($pindahan['foto_berkas'])) {
                        $candidates[] = $pindahan['foto_berkas'];
                    }

                    foreach ($candidates as $cand) {
                        $candClean = ltrim($cand, '/');
                        if (is_file(FCPATH . $candClean)) {
                            $fotoSrc = function_exists('image_to_base64') ? image_to_base64($candClean) : '';
                            if (empty($fotoSrc)) {
                                $fotoSrc = base_url($candClean);
                            }
                            break;
                        }
                    }

                    if (empty($fotoSrc)) {
                        $fotoSrc = 'https://ui-avatars.com/api/?name=' . urlencode($pindahan['nama_lengkap'] ?? 'S') . '&background=1e3a8a&color=fff&size=128';
                    }
                ?>
                <img src="<?= $fotoSrc ?>" alt="Pas Foto Siswa">
            </div>

            <div class="info-box">
                <div class="card-label-main">KARTU TANDA PESERTA SISWA PINDAHAN</div>
                <table class="details-table">
                    <tr>
                        <td class="td-label">No. Daftar</td>
                        <td class="td-separator">:</td>
                        <td class="td-value"><?= esc($pindahan['no_pendaftaran'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">NISN</td>
                        <td class="td-separator">:</td>
                        <td class="td-value"><?= esc($pindahan['nisn'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">Nama</td>
                        <td class="td-separator">:</td>
                        <td class="td-value"><?= esc(strtoupper($pindahan['nama_lengkap'] ?? '')) ?></td>
                    </tr>
                    <tr>
                        <td class="td-label">TTL</td>
                        <td class="td-separator">:</td>
                        <td class="td-value">
                            <?= esc($pindahan['tempat_lahir'] ?? '-') ?>, 
                            <?= $pindahan['tgl_lahir'] ? date('d/m/Y', strtotime($pindahan['tgl_lahir'])) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-label">Jalur</td>
                        <td class="td-separator">:</td>
                        <td class="td-value">Pindahan</td>
                    </tr>
                    <tr>
                        <td class="td-label">Jenjang Asal</td>
                        <td class="td-separator">:</td>
                        <td class="td-value"><?= esc($pindahan['jenjang_sekolah_asal'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="qr-front">
            <img src="<?= generate_qr_base64(base_url('verify/siswa-pindahan/' . ($pindahan['no_pendaftaran'] ?? 'invalid')), 60, 1) ?>" style="width:100%; height: 100%; display: block;" alt="QR">
        </div>
    </div>

    <!-- BACK SIDE -->
    <div class="card-container" style="background-color: #ffffff; <?php if (!empty($layout['bg_belakang'])): ?>background-image: url('<?= base_url('uploads/kartu/' . $layout['bg_belakang']) ?>'); background-size: cover;<?php endif; ?>">
        <div class="back-container">
            <div class="rules-section">
                <div style="font-size: 8px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 2px; margin-bottom: 4px; color: var(--primary-color);">
                    TATA TERTIB & KETENTUAN
                </div>
                <div class="rules-text">
                    <ol>
                        <li>Kartu ini adalah tanda pengenal resmi siswa <?= esc($instansi['nama_sekolah'] ?? 'Sekolah') ?>.</li>
                        <li>Wajib dibawa selama berada di lingkungan sekolah.</li>
                        <li>Apabila menemukan kartu ini, harap dikembalikan ke alamat sekolah.</li>
                        <li>Penggunaan kartu oleh orang lain adalah pelanggaran berat.</li>
                    </ol>
                </div>
            </div>

            <div class="footer-back">
                <div class="qr-side">
                    <div class="qr-back-large">
                        <img src="<?= generate_qr_base64(base_url('verify/siswa-pindahan/' . ($pindahan['no_pendaftaran'] ?? 'invalid')), 120, 5, $qr['ecc_level'] ?? 'M') ?>" style="width:100%; height: 100%; display: block;" alt="QR">
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
                    <div class="sig-date"><?= esc($ttd['kota_ttd'] ?? $instansi['kab'] ?? 'Kabupaten') ?>, <?= $tglIndo ?></div>
                    <div class="sig-title"><?= esc($ttd['jabatan'] ?? 'Kepala Madrasah') ?></div>
                    
                    <div class="sig-image-wrapper">
                        <?php if (!empty($ttd['file_cap'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_cap']) ?>" class="sig-stempel" alt="Stempel">
                        <?php endif; ?>

                        <?php if (!empty($ttd['file_ttd'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_ttd']) ?>" class="sig-ttd" alt="TTD">
                        <?php endif; ?>
                    </div>

                    <div class="sig-name"><?= esc($ttd['nama_pejabat'] ?? 'Nama Kepala Sekolah') ?></div>
                    <div class="sig-nip">NIP. <?= esc($ttd['nip_pejabat'] ?? '-') ?></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeOrBack() {
            try {
                window.open('', '_self', '');
                window.close();
            } catch (e) {}

            setTimeout(function () {
                if (!window.closed) {
                    if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
                        window.location.href = document.referrer;
                    } else {
                        window.location.href = '<?= base_url('admin/pindahan') ?>';
                    }
                }
            }, 150);
        }
    </script>
</body>
</html>