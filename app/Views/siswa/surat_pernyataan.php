<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan - <?= esc($siswa['nama_lengkap']) ?></title>
    <style>
        @media print {
            .no-print { display: none !important; }
            @page { size: A4; margin: 1cm 1.5cm; }
            body { background: white; margin: 0; padding: 0; }
            .paper-container { box-shadow: none; padding: 0; border: none; }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #111827;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px 10px;
            background: #f3f4f6;
            line-height: 1.4;
        }
        .paper-container {
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .font-bold { font-weight: bold; }
        
        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #1f2937;
            margin-bottom: 16px;
            padding-bottom: 8px;
        }
        .kop-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }
        .kop-text h3 {
            margin: 0;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .kop-text h2 {
            margin: 2px 0;
            font-size: 16px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: 1px;
        }
        .kop-text p {
            margin: 1px 0;
            font-size: 10px;
            color: #4b5563;
        }

        .doc-title {
            text-align: center;
            margin: 14px 0 16px;
        }
        .doc-title h1 {
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .doc-title span {
            font-size: 10px;
            color: #4b5563;
        }

        table.biodata {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px;
        }
        table.biodata td {
            padding: 2.5px 4px;
            vertical-align: top;
            font-size: 11.5px;
        }
        .lbl { width: 140px; }
        .sep { width: 10px; text-align: center; }
        .val { font-weight: 600; }

        .points-list {
            margin: 8px 0 12px;
            padding-left: 20px;
        }
        .points-list li {
            margin-bottom: 5px;
            text-align: justify;
            font-size: 11.5px;
        }

        /* Signatures */
        .sig-container {
            margin-top: 25px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 45%;
            text-align: center;
            font-size: 11.5px;
        }
        .materai-box {
            width: 75px;
            height: 45px;
            border: 1px dashed #9ca3af;
            margin: 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #6b7280;
            text-align: center;
            line-height: 1.1;
            border-radius: 3px;
        }
        .sig-space {
            height: 45px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
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
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .btn-print { background-color: #059669; color: white; }
        .btn-print:hover { background-color: #047857; }
        .btn-close { background-color: #3b82f6; color: white; }
        .btn-close:hover { background-color: #2563eb; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <div class="controls no-print">
        <button class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Surat Pernyataan
        </button>
        <a href="<?= base_url('siswa/dashboard') ?>" class="btn btn-close">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="paper-container">
        <!-- Kop Surat -->
        <table class="kop-table">
            <tr>
                <td style="width: 75px; text-align: center; vertical-align: middle;">
                    <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="kop-logo">
                    <?php endif; ?>
                </td>
                <td class="kop-text text-center" style="vertical-align: middle;">
                    <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h3>
                    <h2><?= esc($web['nama_sekolah'] ?? 'NAMA SEKOLAH / MADRASAH') ?></h2>
                    <p>
                        <?= esc($web['alamat_sekolah'] ?? '') ?>
                        <?= !empty($web['kecamatan']) ? ', Kec. ' . esc($web['kecamatan']) : '' ?>
                        <?= !empty($web['kabupaten']) ? ', ' . esc($web['kabupaten']) : '' ?>
                    </p>
                    <p>
                        NPSN: <?= esc($web['npsn'] ?? '-') ?> | NSM: <?= esc($web['nsm'] ?? '-') ?> 
                        <?php if (!empty($web['telepon'])): ?> | Telp: <?= esc($web['telepon']) ?><?php endif; ?>
                        <?php if (!empty($web['email'])): ?> | Email: <?= esc($web['email']) ?><?php endif; ?>
                    </p>
                </td>
            </tr>
        </table>

        <!-- Judul -->
        <div class="doc-title">
            <h1>SURAT PERNYATAAN CALON PESERTA DIDIK BARU<br>DAN ORANG TUA / WALI</h1>
            <span>Tahun Pelajaran <?= esc($web['th_pelajaran'] ?? date('Y') . '/' . (date('Y')+1)) ?></span>
        </div>

        <p class="text-justify" style="margin-bottom: 4px;">
            Yang bertanda tangan di bawah ini:
        </p>

        <!-- Data Calon Siswa -->
        <table class="biodata">
            <tr>
                <td class="lbl">Nama Calon Siswa</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['nama_lengkap']) ?></td>
            </tr>
            <tr>
                <td class="lbl">Nomor Pendaftaran</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['no_pendaftaran']) ?></td>
            </tr>
            <tr>
                <td class="lbl">NISN</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['nisn'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="lbl">Tempat, Tanggal Lahir</td>
                <td class="sep">:</td>
                <td class="val">
                    <?= esc($siswa['tempat_lahir'] ?? '-') ?>, 
                    <?= !empty($siswa['tgl_lahir']) ? date('d F Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
                </td>
            </tr>
            <tr>
                <td class="lbl">Jenis Kelamin</td>
                <td class="sep">:</td>
                <td class="val"><?= ($siswa['jk'] ?? '') === 'L' ? 'Laki-laki' : (($siswa['jk'] ?? '') === 'P' ? 'Perempuan' : '-') ?></td>
            </tr>
            <tr>
                <td class="lbl">Alamat Tempat Tinggal</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['alamat_siswa'] ?? '-') ?>, <?= esc($siswa['desa'] ?? '') ?>, <?= esc($siswa['kec'] ?? '') ?>, <?= esc($siswa['kab'] ?? '') ?></td>
            </tr>
        </table>

        <p class="text-justify" style="margin-bottom: 4px; margin-top: 8px;">
            Bersama Orang Tua / Wali Murid:
        </p>

        <!-- Data Orang Tua -->
        <table class="biodata">
            <tr>
                <td class="lbl">Nama Orang Tua / Wali</td>
                <td class="sep">:</td>
                <td class="val"><?= esc(!empty($siswa['nama_ayah']) ? $siswa['nama_ayah'] : (!empty($siswa['nama_wali']) ? $siswa['nama_wali'] : $siswa['nama_ibu'] ?? '-')) ?></td>
            </tr>
            <tr>
                <td class="lbl">Nomor HP / WhatsApp</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['no_hp_ortu'] ?? $siswa['no_hp_siswa'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="lbl">Pekerjaan</td>
                <td class="sep">:</td>
                <td class="val"><?= esc($siswa['pekerjaan_ayah'] ?? $siswa['pekerjaan_wali'] ?? $siswa['pekerjaan_ibu'] ?? '-') ?></td>
            </tr>
        </table>

        <p class="text-justify" style="margin: 10px 0 6px;">
            Menyatakan dengan sesungguhnya dan penuh kesadaran bahwa apabila saya diterima sebagai peserta didik di <strong><?= esc($web['nama_sekolah'] ?? 'Madrasah/Sekolah') ?></strong>, maka saya:
        </p>

        <ol class="points-list">
            <li>Akan menaati dan mematuhi seluruh peraturan, tata tertib, dan ketentuan kedisiplinan yang berlaku di lingkungan <?= esc($web['nama_sekolah'] ?? 'sekolah') ?>.</li>
            <li>Mengikuti seluruh proses pembelajaran, kegiatan kurikuler, kokurikuler, dan ekstrakurikuler dengan penuh kesungguhan dan tanggung jawab.</li>
            <li>Menjaga nama baik diri sendiri, keluarga, para guru, dan almamater sekolah, baik di dalam maupun di luar lingkungan sekolah.</li>
            <li>Tidak akan terlibat dalam segala bentuk perbuatan yang melanggar hukum dan norma sosial (seperti narkoba, tawuran, pornografi, perundungan/bullying, dan tindakan asusila).</li>
            <li>Bersedia menerima sanksi teguran, peringatan, skorsing, hingga dikembalikan kepada orang tua/wali murid apabila saya terbukti melanggar tata tertib sekolah.</li>
            <li>Seluruh berkas dokumen dan informasi data pendaftaran yang kami serahkan adalah benar, sah, dan dapat dipertanggungjawabkan di hadapan hukum.</li>
        </ol>

        <p class="text-justify" style="margin-top: 8px;">
            Demikian surat pernyataan ini kami buat dan tanda tangani dengan sebenarnya, dalam keadaan sadar tanpa ada paksaan maupun tekanan dari pihak manapun, untuk dipergunakan sebagaimana mestinya.
        </p>

        <!-- Signature Section -->
        <?php
        $bulanIndo = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
            'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober',
            'November' => 'November', 'December' => 'Desember'
        ];
        $tglHariIni = strtr(date('d F Y'), $bulanIndo);
        $kota = !empty($web['kabupaten']) ? $web['kabupaten'] : 'Kabupaten';
        ?>

        <div class="sig-container">
            <div class="sig-box">
                <p style="margin: 0;">Mengetahui / Menyetujui,</p>
                <p style="margin: 2px 0 6px; font-weight: bold;">Orang Tua / Wali Murid</p>
                <div class="materai-box">
                    MATERAI<br>Rp 10.000
                </div>
                <p class="sig-name" style="margin-top: 8px;">
                    ( <?= esc(!empty($siswa['nama_ayah']) ? $siswa['nama_ayah'] : (!empty($siswa['nama_wali']) ? $siswa['nama_wali'] : $siswa['nama_ibu'] ?? '..................................')) ?> )
                </p>
            </div>

            <div class="sig-box">
                <p style="margin: 0;"><?= esc($kota) ?>, <?= $tglHariIni ?></p>
                <p style="margin: 2px 0 6px; font-weight: bold;">Yang Membuat Pernyataan,<br>Calon Peserta Didik</p>
                <div class="sig-space"></div>
                <p class="sig-name" style="margin-top: 8px;">
                    ( <?= esc($siswa['nama_lengkap']) ?> )
                </p>
            </div>
        </div>
    </div>

</body>
</html>
