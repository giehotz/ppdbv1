<?php helper(['cetak', 'kop']); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - <?= $siswa['nama_lengkap'] ?></title>
    <style>
        @media print {
            .no-print { display: none !important; }
            @page { size: A4; margin: 0.5cm; }
            body { background: white; margin: 0; padding: 0; }
            .paper-container { box-shadow: none; padding: 0; }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #1e293b;
            max-width: 210mm;
            margin: 0 auto;
            padding: 5px;
            background: #f1f5f9;
            line-height: normal;
        }
        .paper-container {
            background: #fff;
            padding: 10px 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 4px;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .section-title {
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 11px;
            background: linear-gradient(135deg, #059669, #3b82f6);
            color: #fff;
            padding: 3px 8px;
            margin-top: 5px;
            margin-bottom: 3px;
            border-radius: 3px;
            letter-spacing: 0.5px;
        }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 1.5px 4px; vertical-align: top; }
        .lbl { width: 100px; font-family: Arial, sans-serif; font-size: 10px; color: #475569; font-weight: 600; }
        .sep { width: 8px; text-align: center; color: #94a3b8; }
        .val { color: #1e293b; }
        .val-bold { color: #0f172a; font-weight: bold; }
        .photo-box {
            width: 2.5cm; height: 3.2cm;
            border: 2px solid #059669;
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px; background: #f8fafc; overflow: hidden;
        }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        .signature-section { margin-top: 10px; page-break-inside: avoid; }
        .note-box { border: 1px solid #cbd5e1; border-left: 4px solid #059669; padding: 4px 8px; font-size: 10px; font-family: Arial, sans-serif; background: #f0fdf4; border-radius: 3px; }
        .header-table { width: 100%; border-bottom: 3px double #059669; margin-bottom: 5px; padding-bottom: 4px; }
        .header-logo { width: 70px; text-align: left; }
        .header-logo img { width: 55px; height: auto; }
        .header-content { text-align: center; }
        .school-name { font-size: 14px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #059669; }
        .school-address { font-size: 9px; font-family: Arial, sans-serif; color: #475569; }
        .print-btn-container { text-align: center; margin-bottom: 10px; }
        .print-btn {
            background: linear-gradient(135deg, #059669, #2563eb); color: white; padding: 8px 20px; border: none; border-radius: 8px;
            cursor: pointer; font-size: 13px; font-weight: bold; font-family: Arial, sans-serif;
            box-shadow: 0 4px 8px rgba(5,150,105,0.3);
        }
        .print-btn:hover { background: linear-gradient(135deg, #047857, #1d4ed8); }
        .footer-system { text-align: center; margin-top: 8px; font-size: 8px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 3px; font-family: Arial, sans-serif; }
        .form-title { color: #059669; margin-bottom: 4px; }
        .sub-title { color: #475569; font-size: 10px; }
        .parent-header { font-size: 10px; color: #059669; font-weight: bold; border-bottom: 1px dotted #cbd5e1; padding-bottom: 2px; margin-bottom: 2px; display: block; }
        .status-badge { display: inline-block; padding: 1px 8px; border-radius: 3px; font-weight: bold; font-size: 10px; }
        .status-terverifikasi { background: #dcfce7; color: #166534; }
        .status-ditolak { background: #fce4ec; color: #991b1b; }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .kop-line { color: #059669; }
    </style>
</head>
<body>

<div class="no-print print-btn-container">
    <button onclick="window.print()" class="print-btn">Cetak Formulir Ini</button>
</div>

<div class="paper-container">

    <?php helper('kop'); ?>
    <?= render_kop_surat() ?>

    <div class="text-center form-title">
        <b style="font-size: 13px;">FORMULIR PENDAFTARAN SISWA BARU</b><br>
        <span class="sub-title">Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?></span>
    </div>

    <!-- A. DATA PRIBADI -->
    <div class="section-title">A. DATA PRIBADI SISWA</div>
    <table>
        <tr>
            <td style="width: 3cm; vertical-align: top; padding-right: 8px;">
                <?php
                    $fotoBerkas = \Config\Database::connect()->table('tbl_berkas')
                        ->where('id_siswa', $siswa['id_siswa'])
                        ->where('jenis_berkas', 'foto')
                        ->get()->getRowArray();
                ?>
                <div class="photo-box">
                    <?php if (!empty($fotoBerkas['nama_file'])): ?>
                        <?php 
                        $fotoPath = 'uploads/berkas/' . $siswa['nisn'] . '/' . $fotoBerkas['nama_file'];
                        $fotoSrc = image_to_base64($fotoPath);
                        if (empty($fotoSrc)) {
                            $fotoSrc = base_url($fotoPath);
                        }
                        ?>
                        <img src="<?= $fotoSrc ?>">
                    <?php else: ?>
                        <div class="text-center font-bold" style="color: #ccc; font-family: Arial;">Pas Foto 3x4</div>
                    <?php endif; ?>
                </div>
            </td>
            <td style="vertical-align: top;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; vertical-align: top; padding-right: 8px;">
                            <table>
                                <tr><td class="lbl">No. Pendaftaran</td><td class="sep">:</td><td class="val-bold"><?= $siswa['no_pendaftaran'] ?></td></tr>
                                <tr><td class="lbl">NISN</td><td class="sep">:</td><td class="val"><?= $siswa['nisn'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Nama Lengkap</td><td class="sep">:</td><td class="val-bold" style="color:#059669;"><?= strtoupper($siswa['nama_lengkap']) ?></td></tr>
                                <tr><td class="lbl">NIK</td><td class="sep">:</td><td class="val"><?= $siswa['nik'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Jenis Kelamin</td><td class="sep">:</td><td class="val"><?= $siswa['jk'] == 'L' ? 'Laki-laki' : ($siswa['jk'] == 'P' ? 'Perempuan' : '-') ?></td></tr>
                                <tr><td class="lbl">Tempat, Tgl Lahir</td><td class="sep">:</td><td class="val"><?= ($siswa['tempat_lahir'] ?? '-') ?>, <?= !empty($siswa['tgl_lahir']) && strtotime($siswa['tgl_lahir']) ? date('d-m-Y', strtotime($siswa['tgl_lahir'])) : '-' ?></td></tr>
                                <tr><td class="lbl">Agama</td><td class="sep">:</td><td class="val"><?= $siswa['agama'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">No. HP / Email</td><td class="sep">:</td><td class="val"><?= $siswa['no_hp_siswa'] ?? '-' ?> / <?= $siswa['email'] ?? '-' ?></td></tr>
                            </table>
                        </td>
                        <td style="width: 50%; vertical-align: top; padding-left: 8px; border-left: 1px solid #ccc;">
                            <table>
                                <tr><td class="lbl">No. KK</td><td class="sep">:</td><td class="val"><?= $siswa['no_kk'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Jalur Pendaftaran</td><td class="sep">:</td><td class="val"><?= $siswa['jalur_pendaftaran'] ?? '-' ?></td></tr>
                                <tr><td class="lbl" style="vertical-align: top;">Alamat</td><td class="sep" style="vertical-align: top;">:</td><td class="val"><?= $siswa['alamat_siswa'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Desa / Kelurahan</td><td class="sep">:</td><td class="val"><?= $siswa['desa'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Kecamatan</td><td class="sep">:</td><td class="val"><?= $siswa['kec'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Kabupaten / Kota</td><td class="sep">:</td><td class="val"><?= $siswa['kab'] ?? '-' ?></td></tr>
                                <tr><td class="lbl">Provinsi</td><td class="sep">:</td><td class="val"><?= $siswa['prov'] ?? '-' ?></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- B. ASAL SEKOLAH -->
    <div class="section-title">B. ASAL SEKOLAH</div>
    <table>
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <table>
                    <tr><td class="lbl">Nama Sekolah</td><td class="sep">:</td><td class="val-bold"><?= $siswa['nama_sekolah'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">NPSN</td><td class="sep">:</td><td class="val"><?= $siswa['npsn_sekolah'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">Jenjang / Status</td><td class="sep">:</td><td class="val"><?= $siswa['jenjang_sekolah'] ?? '-' ?> / <?= $siswa['status_sekolah'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">Kompetensi Keahlian</td><td class="sep">:</td><td class="val"><?= $siswa['komp_ahli'] ?? '-' ?></td></tr>
                </table>
            </td>
            <td style="width: 40%; vertical-align: top;">
                <table>
                    <tr><td class="lbl">No. KKS</td><td class="sep">:</td><td class="val"><?= $siswa['no_kks'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">No. PKH</td><td class="sep">:</td><td class="val"><?= $siswa['no_pkh'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">No. KIP</td><td class="sep">:</td><td class="val"><?= $siswa['no_kip'] ?? '-' ?></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- C. ORANG TUA / WALI -->
    <div class="section-title">C. DATA ORANG TUA / WALI</div>
    <table>
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 15px;">
                <span class="parent-header">1. AYAH</span>
                <table>
                    <tr><td class="lbl">Nama</td><td class="sep">:</td><td class="val"><?= $siswa['nama_ayah'] ?? '-' ?> <?= !empty($siswa['status_ayah']) ? '<span style="color:#64748b;font-size:10px;">(' . $siswa['status_ayah'] . ')</span>' : '' ?></td></tr>
                    <tr><td class="lbl">Pekerjaan</td><td class="sep">:</td><td class="val"><?= $siswa['pekerjaan_ayah'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">Penghasilan</td><td class="sep">:</td><td class="val"><?= $siswa['penghasilan_ayah'] ?? '-' ?></td></tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; padding-left: 15px; border-left: 1px solid #e2e8f0;">
                <span class="parent-header">2. IBU</span>
                <table>
                    <tr><td class="lbl">Nama</td><td class="sep">:</td><td class="val"><?= $siswa['nama_ibu'] ?? '-' ?> <?= !empty($siswa['status_ibu']) ? '<span style="color:#64748b;font-size:10px;">(' . $siswa['status_ibu'] . ')</span>' : '' ?></td></tr>
                    <tr><td class="lbl">Pekerjaan</td><td class="sep">:</td><td class="val"><?= $siswa['pekerjaan_ibu'] ?? '-' ?></td></tr>
                    <tr><td class="lbl">Penghasilan</td><td class="sep">:</td><td class="val"><?= $siswa['penghasilan_ibu'] ?? '-' ?></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="margin-top: 2px;">
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr><td class="lbl" style="width: 70px;">No. HP Ortu</td><td class="sep">:</td><td class="val-bold" style="color:#059669;"><?= $siswa['no_hp_ortu'] ?? '-' ?></td></tr>
                </table>
            </td>
            <td style="width: 50%;">
                <?php if (!empty($siswa['nama_wali'])): ?>
                <table>
                    <tr><td class="lbl" style="width: 70px;">3. WALI</td><td class="sep">:</td><td class="val"><?= $siswa['nama_wali'] ?> (<?= $siswa['pekerjaan_wali'] ?? '-' ?>)</td></tr>
                </table>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- D. STATUS PENDAFTARAN -->
    <div class="section-title">D. STATUS PENDAFTARAN</div>
    <table>
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr><td class="lbl">Tanggal Daftar</td><td class="sep">:</td><td class="val"><?= !empty($siswa['tgl_siswa']) && strtotime($siswa['tgl_siswa']) ? date('d-m-Y H:i', strtotime($siswa['tgl_siswa'])) : '-' ?></td></tr>
                    <tr><td class="lbl">Lokasi Sekolah</td><td class="sep">:</td><td class="val"><?= $siswa['lokasi_sekolah'] ?? '-' ?></td></tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table>
                    <tr><td class="lbl">Status Verifikasi</td><td class="sep">:</td>
                        <td>
                            <?php $st = $siswa['status_verifikasi'] ?? 'Menunggu'; ?>
                            <span class="status-badge status-<?= strtolower($st) == 'terverifikasi' ? 'terverifikasi' : (strtolower($st) == 'ditolak' ? 'ditolak' : 'menunggu') ?>"><?= $st ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    <table class="signature-section">
        <tr>
            <td style="width: 55%; vertical-align: bottom;">
                <div class="note-box">
                    <b>Catatan:</b> Dokumen ini bukti pendaftaran yang sah. Lengkapi berkas fisik ke sekolah.
                </div>
            </td>
            <td style="width: 45%; text-align: center; vertical-align: bottom;">
                <div style="margin-bottom: 4px;">
                    <?= $web['kabupaten'] ?? 'Tempat' ?>, <?= date('d-m-Y') ?><br>
                    Calon Siswa,
                </div>
                <?php $qr_url = base_url('verify/' . ($siswa['no_pendaftaran'] ?? 'invalid')); ?>
                <div style="margin-bottom: 4px;">
                    <img src="<?= generate_qr_base64($qr_url, 80, 2) ?>" style="width: 50px; height: 50px;" alt="QR">
                </div>
                <div><b style="color:#059669;"><?= strtoupper($siswa['nama_lengkap']) ?></b></div>
                <div>NISN. <?= $siswa['nisn'] ?? '-' ?></div>
            </td>
        </tr>
    </table>

    <div class="footer-system">
        Dicetak dari Sistem <?= $app_alias ?? 'PPDB' ?> Online <?= $web['nama_sekolah'] ?? 'Sekolah' ?> tanggal <?= date('d-m-Y H:i:s') ?>
    </div>

</div>
</body>
</html>