<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pindahan - <?= esc($pindahan['nama_lengkap']) ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 12mm 10mm 12mm;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; margin: 0; padding: 0; }
            .paper-container { box-shadow: none !important; border: none !important; padding: 0 !important; width: 100% !important; max-width: 100% !important; }
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.25;
            color: #111827;
            background: #f1f5f9;
            margin: 0;
            padding: 20px 0;
        }
        .paper-container {
            background: #fff;
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 16mm 16mm 14mm 16mm;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }
        .no-print-bar {
            max-width: 210mm;
            margin: 0 auto 12px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .btn-print { background: #0f172a; color: #fff; }
        .btn-print:hover { background: #1e293b; }
        .btn-back { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
        .btn-back:hover { background: #f8fafc; }

        /* Document Header */
        .doc-header {
            text-align: center;
            margin: 10px 0 14px 0;
            border-bottom: 1.5px solid #111827;
            padding-bottom: 6px;
        }
        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin: 0;
        }
        .doc-subtitle {
            font-size: 10pt;
            margin: 2px 0 0 0;
            font-style: italic;
        }

        /* Section Headings */
        .section-header {
            font-family: Arial, sans-serif;
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 4px solid #0f172a;
            padding: 3px 8px;
            margin: 8px 0 5px 0;
        }

        /* Form Tables */
        table.form-grid {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table.form-grid td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .lbl {
            width: 135px;
            color: #1f2937;
            font-weight: 600;
        }
        .sep {
            width: 10px;
            text-align: center;
            color: #4b5563;
        }
        .val {
            color: #111827;
        }
        .val-strong {
            font-weight: bold;
            color: #000;
        }

        /* Photo Box */
        .photo-frame {
            width: 3cm;
            height: 4cm;
            border: 1px solid #64748b;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            color: #94a3b8;
            line-height: 1.3;
        }

        /* Status & Badges */
        .badge-status {
            display: inline-block;
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
            font-weight: bold;
            padding: 1px 8px;
            border: 1px solid #334155;
            border-radius: 3px;
        }

        /* Statement Box */
        .statement-box {
            border: 1px solid #cbd5e1;
            background: #fcfcfc;
            padding: 6px 10px;
            font-size: 8.5pt;
            font-style: italic;
            margin-top: 10px;
            line-height: 1.35;
        }

        /* Signatures */
        .sign-table {
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }
        .sign-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 10pt;
        }
        .sign-role {
            font-weight: 600;
            margin-bottom: 8px;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .sign-qr {
            width: 58px;
            height: 58px;
            margin: 4px auto;
        }

        /* Footer Info */
        .doc-footer {
            margin-top: 16px;
            padding-top: 4px;
            border-top: 1px dashed #cbd5e1;
            font-family: Arial, sans-serif;
            font-size: 7.5pt;
            color: #64748b;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="no-print no-print-bar">
    <a href="javascript:history.back()" class="btn btn-back">&larr; Kembali</a>
    <button onclick="window.print()" class="btn btn-print">&#128438; Cetak Formulir (A4)</button>
</div>

<div class="paper-container">

    <!-- Kop Surat Resmi -->
    <?php helper(['kop', 'url']); ?>
    <?= render_kop_surat() ?>

    <!-- Judul Dokumen -->
    <div class="doc-header">
        <h1 class="doc-title">Formulir Pendaftaran Peserta Didik Pindahan</h1>
        <p class="doc-subtitle">Tahun Pelajaran <?= esc($web['th_pelajaran'] ?? date('Y').'/'.(date('Y')+1)) ?></p>
    </div>

    <!-- I. DATA PRIBADI SISWA -->
    <div class="section-header">I. Data Pribadi Siswa</div>
    <table class="form-grid">
        <tr>
            <!-- Kolom Isian Biodata -->
            <td style="width: 78%; padding-right: 12px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">No. Pendaftaran</td>
                        <td class="sep">:</td>
                        <td class="val-strong font-mono"><?= esc($pindahan['no_pendaftaran']) ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">NISN / NIK</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['nisn'] ?? '-') ?> / <?= esc($pindahan['nik'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Nama Lengkap</td>
                        <td class="sep">:</td>
                        <td class="val-strong" style="font-size: 10.5pt; text-transform: uppercase;"><?= esc($pindahan['nama_lengkap']) ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Jenis Kelamin</td>
                        <td class="sep">:</td>
                        <td class="val"><?= ($pindahan['jk'] ?? '') == 'L' ? 'Laki-laki' : (($pindahan['jk'] ?? '') == 'P' ? 'Perempuan' : '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Tempat, Tanggal Lahir</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['tempat_lahir'] ?? '-') ?>, <?= !empty($pindahan['tgl_lahir']) && strtotime($pindahan['tgl_lahir']) ? date('d F Y', strtotime($pindahan['tgl_lahir'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Agama</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['agama'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Nomor KK</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['no_kk'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">No. Telepon / HP Siswa</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['no_hp_siswa'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Email Siswa</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['email'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Alamat Tempat Tinggal</td>
                        <td class="sep">:</td>
                        <td class="val">
                            <?= esc($pindahan['alamat_siswa'] ?? '-') ?><br>
                            Desa/Kel. <?= esc($pindahan['desa'] ?? '-') ?>, Kec. <?= esc($pindahan['kec'] ?? '-') ?><br>
                            Kab/Kota <?= esc($pindahan['kab'] ?? '-') ?>, Prov. <?= esc($pindahan['prov'] ?? '-') ?>
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Pas Foto 3x4 -->
            <td style="width: 22%; text-align: center; vertical-align: top;">
                <?php
                    $fotoBerkas = \Config\Database::connect()->table('tbl_berkas_pindahan')
                        ->where('id_pindahan', $pindahan['id_pindahan'])
                        ->where('jenis_berkas', 'foto_siswa')
                        ->get()->getRowArray();
                ?>
                <div class="photo-frame">
                    <?php 
                        $fotoRelPath = '';
                        if (!empty($fotoBerkas['path_file']) && is_file(FCPATH . $fotoBerkas['path_file'])) {
                            $fotoRelPath = $fotoBerkas['path_file'];
                        } elseif (!empty($fotoBerkas['nama_file']) && is_file(FCPATH . 'uploads/berkas/' . ($pindahan['nisn'] ?? '') . '/' . $fotoBerkas['nama_file'])) {
                            $fotoRelPath = 'uploads/berkas/' . ($pindahan['nisn'] ?? '') . '/' . $fotoBerkas['nama_file'];
                        } elseif (!empty($pindahan['foto']) && is_file(FCPATH . $pindahan['foto'])) {
                            $fotoRelPath = $pindahan['foto'];
                        }
                    ?>
                    <?php if (!empty($fotoRelPath)): ?>
                        <?php 
                        $fotoSrc = function_exists('image_to_base64') ? image_to_base64($fotoRelPath) : '';
                        if (empty($fotoSrc)) {
                            $fotoSrc = base_url($fotoRelPath);
                        }
                        ?>
                        <img src="<?= $fotoSrc ?>" alt="Pas Foto">
                    <?php else: ?>
                        <div class="photo-placeholder">
                            PAS FOTO<br>3 x 4 cm
                        </div>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    </table>

    <!-- II. RIWAYAT SEKOLAH ASAL & TUJUAN -->
    <div class="section-header">II. Riwayat Sekolah Asal &amp; Rencana Masuk</div>
    <table class="form-grid">
        <tr>
            <td style="width: 50%; padding-right: 8px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">Nama Sekolah Asal</td>
                        <td class="sep">:</td>
                        <td class="val-strong"><?= esc($pindahan['nama_sekolah_asal'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">NPSN Sekolah Asal</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['npsn_sekolah_asal'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Jenjang Sekolah Asal</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['jenjang_sekolah_asal'] ?? '-') ?></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 8px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">Diterima di Tingkat/Kelas</td>
                        <td class="sep">:</td>
                        <td class="val-strong"><?= esc($pindahan['kelas_diterima'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Jurusan / Kompetensi</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['komp_ahli'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Jalur Pendaftaran</td>
                        <td class="sep">:</td>
                        <td class="val-strong">Pindahan / Mutasi</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- III. DATA ORANG TUA / WALI -->
    <div class="section-header">III. Data Orang Tua / Wali</div>
    <table class="form-grid">
        <tr>
            <!-- Ayah -->
            <td style="width: 50%; padding-right: 8px;">
                <table class="form-grid">
                    <tr>
                        <td colspan="3" style="font-weight: bold; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px;">
                            A. Data Ayah Kandung
                        </td>
                    </tr>
                    <tr>
                        <td class="lbl" style="width: 100px;">Nama Ayah</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['nama_ayah'] ?? '-') ?> <?= !empty($pindahan['status_ayah']) ? '('.esc($pindahan['status_ayah']).')' : '' ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Pekerjaan</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['pekerjaan_ayah'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Penghasilan</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['penghasilan_ayah'] ?? '-') ?></td>
                    </tr>
                </table>
            </td>

            <!-- Ibu -->
            <td style="width: 50%; padding-left: 8px;">
                <table class="form-grid">
                    <tr>
                        <td colspan="3" style="font-weight: bold; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px;">
                            B. Data Ibu Kandung
                        </td>
                    </tr>
                    <tr>
                        <td class="lbl" style="width: 100px;">Nama Ibu</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['nama_ibu'] ?? '-') ?> <?= !empty($pindahan['status_ibu']) ? '('.esc($pindahan['status_ibu']).')' : '' ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Pekerjaan</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['pekerjaan_ibu'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Penghasilan</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['penghasilan_ibu'] ?? '-') ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 4px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">No. HP Orang Tua</td>
                        <td class="sep">:</td>
                        <td class="val-strong"><?= esc($pindahan['no_hp_ortu'] ?? '-') ?></td>
                        <?php if (!empty($pindahan['nama_wali'])): ?>
                            <td class="lbl" style="width: 90px; padding-left: 12px;">Nama Wali</td>
                            <td class="sep">:</td>
                            <td class="val"><?= esc($pindahan['nama_wali']) ?> (<?= esc($pindahan['pekerjaan_wali'] ?? '-') ?>)</td>
                        <?php endif; ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- IV. STATUS PENDAFTARAN & BANTUAN SOSIAL -->
    <div class="section-header">IV. Administrasi &amp; Status Pendaftaran</div>
    <table class="form-grid">
        <tr>
            <td style="width: 50%; padding-right: 8px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">Tanggal Pendaftaran</td>
                        <td class="sep">:</td>
                        <td class="val"><?= !empty($pindahan['tgl_pindahan']) && strtotime($pindahan['tgl_pindahan']) ? date('d-m-Y H:i', strtotime($pindahan['tgl_pindahan'])).' WIB' : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">Status Verifikasi</td>
                        <td class="sep">:</td>
                        <td class="val">
                            <span class="badge-status">
                                <?= esc($pindahan['status_verifikasi'] ?? 'Menunggu') ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 8px;">
                <table class="form-grid">
                    <tr>
                        <td class="lbl">No. KIP / PIP</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['no_kip'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="lbl">No. KKS / PKH</td>
                        <td class="sep">:</td>
                        <td class="val"><?= esc($pindahan['no_kks'] ?? '-') ?> / <?= esc($pindahan['no_pkh'] ?? '-') ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Pernyataan -->
    <div class="statement-box">
        <strong>Pernyataan:</strong> Saya menyatakan bahwa seluruh data yang tercantum dalam formulir ini adalah benar dan sah sesuai dokumen asli. Apabila di kemudian hari ditemukan ketidaksesuaian data, saya bersedia menerima sanksi dan keputusan pembatalan pendaftaran sesuai ketentuan sekolah.
    </div>

    <!-- V. PENGESAHAN & TANDA TANGAN -->
    <table class="sign-table">
        <tr>
            <td>
                Mengetahui,<br>
                <span class="sign-role">Orang Tua / Wali Siswa</span>
                <div style="height: 52px;"></div>
                <div class="sign-name">( <?= esc(!empty($pindahan['nama_ayah']) ? $pindahan['nama_ayah'] : (!empty($pindahan['nama_ibu']) ? $pindahan['nama_ibu'] : '...........................................')) ?> )</div>
            </td>
            <td>
                <?= esc($web['kabupaten'] ?? 'Tempat') ?>, <?= date('d F Y') ?><br>
                <span class="sign-role">Calon Peserta Didik</span>
                <?php 
                    $qr_url = base_url('verify/siswa-pindahan/' . ($pindahan['no_pendaftaran'] ?? 'invalid')); 
                    $qr_src = function_exists('generate_qr_base64') ? generate_qr_base64($qr_url, 80, 2) : '';
                ?>
                <div style="height: 52px; display: flex; align-items: center; justify-content: center;">
                    <?php if (!empty($qr_src)): ?>
                        <img src="<?= $qr_src ?>" class="sign-qr" alt="QR Verifikasi">
                    <?php endif; ?>
                </div>
                <div class="sign-name"><?= esc(strtoupper($pindahan['nama_lengkap'])) ?></div>
                <div style="font-size: 8.5pt;">NISN. <?= esc($pindahan['nisn'] ?? '-') ?></div>
            </td>
        </tr>
    </table>

    <!-- Footer Sistem -->
    <div class="doc-footer">
        <span>Dokumen Resmi Sistem Informasi PPDB - <?= esc($web['nama_sekolah'] ?? 'Sekolah') ?></span>
        <span>Dicetak pada: <?= date('d/m/Y H:i:s') ?> WIB</span>
    </div>

</div>

</body>
</html>