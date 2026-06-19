<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - <?= $siswa['nama_lengkap'] ?></title>
    <style>
        /* Pengaturan Kertas dan Print */
        @media print {
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 0.5cm; /* Diperkecil dari 1cm agar area muat lebih banyak */
            }
            body {
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0;
                padding: 0;
            }
            .page-break {
                page-break-before: always;
            }
        }

        /* Tipografi dan Layout Dasar */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar dokumen resmi */
            font-size: 11px; /* Diperkecil dari 12px */
            color: #000;
            max-width: 210mm;
            margin: 0 auto;
            padding: 10px;
            background: #f9fafb; /* Sedikit abu-abu agar form terlihat seperti kertas di layar */
            line-height: 1.2; /* Merapatkan jarak antar baris */
        }

        .paper-container {
            background: #fff;
            padding: 15px 20px; /* Diperkecil agar hemat ruang */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Bayangan hanya tampil di layar, tidak di print */
        }

        @media print {
            .paper-container {
                box-shadow: none;
                padding: 0;
            }
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .mt-10 { margin-top: 10px; }
        .mb-5 { margin-bottom: 5px; }

        /* KOP Surat */
        .header-table {
            width: 100%;
            border-bottom: 3px double #000; /* Garis ganda terlihat lebih resmi */
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .header-logo { width: 90px; text-align: left; }
        .header-logo img { width: 70px; height: auto; } /* Logo sedikit diperkecil */
        .header-content { text-align: center; }
        .school-name { font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;}
        .school-address { font-size: 10px; font-family: Arial, sans-serif; margin-top: 3px;}

        /* Judul dan Foto */
        .form-title {
            text-align: center;
            margin-bottom: 10px;
        }
        .form-title h2 {
            margin: 0 0 3px 0;
            font-size: 14px;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .photo-box {
            width: 2.8cm; /* Pas foto sedikit diperkecil */
            height: 3.8cm;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            background: #fdfdfd;
            overflow: hidden;
        }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }

        /* Tabel Data */
        .section-title {
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 11px;
            background-color: #e5e7eb;
            padding: 3px 6px; /* Padding dikurangi */
            margin-top: 8px; /* Margin dikurangi */
            margin-bottom: 4px; /* Margin dikurangi */
            border: 1px solid #000;
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 2px 4px; vertical-align: top; } /* Merapatkan baris tabel */
        .label-col { width: 140px; font-family: Arial, sans-serif; font-size: 10.5px; }
        .sep-col { width: 10px; text-align: center; }

        /* Tabel Data Orang Tua (Layout Split 2 Kolom) */
        .parent-table-container { width: 100%; border-collapse: collapse; }
        .parent-table-container > tbody > tr > td { width: 50%; vertical-align: top; padding: 0; }
        .parent-inner-table { width: 100%; }
        .parent-inner-table td { padding: 1px 2px; } /* Jarak Data Ortu sangat dirapatkan */
        .parent-label { width: 90px; font-family: Arial, sans-serif; font-size: 10.5px; }

        /* Tanda Tangan */
        .signature-section {
            width: 100%;
            margin-top: 15px; /* Jarak ke tanda tangan didekatkan */
            page-break-inside: avoid;
        }
        .note-box {
            border: 1px solid #000;
            padding: 6px 10px;
            font-size: 10px;
            font-family: Arial, sans-serif;
        }

        /* Print Button */
        .print-btn-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .print-btn {
            background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 6px;
            cursor: pointer; font-size: 14px; font-weight: bold; font-family: Arial, sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: 0.2s;
        }
        .print-btn:hover { background: #1d4ed8; }

        /* Footer */
        .footer-system {
            text-align: center; margin-top: 15px; font-size: 9px; color: #555;
            border-top: 1px dashed #ccc; padding-top: 5px; font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>

    <div class="no-print print-btn-container">
        <button onclick="window.print()" class="print-btn">
            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 5px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Formulir Ini
        </button>
    </div>

    <!-- Container Dokumen Kertas -->
    <div class="paper-container">

        <!-- KOP Surat Standard -->
        <?php helper('kop'); ?>
        <?= render_kop_surat() ?>

        <!-- Judul -->
        <div class="form-title">
            <h2>Formulir Pendaftaran Siswa Baru</h2>
            <h2 style="text-decoration: none; text-transform: none; margin-bottom: 5px;">Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?></h2>
            <p class="font-bold">No. Reg : <?= $siswa['no_pendaftaran'] ?></p>
        </div>

        <!-- A. DATA PRIBADI -->
        <div class="section-title">A. DATA PRIBADI SISWA</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Kolom 1 -->
                <td style="width: 38%; vertical-align: top; padding-right: 5px;">
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">NISN</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nisn'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Nama Lengkap</td>
                            <td class="sep-col">:</td>
                            <td class="font-bold"><?= strtoupper($siswa['nama_lengkap']) ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">NIK</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nik'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Jenis Kelamin</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['jk'] == 'L' ? 'Laki-laki' : ($siswa['jk'] == 'P' ? 'Perempuan' : '-') ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Tmpt, Tgl Lahir</td>
                            <td class="sep-col">:</td>
                            <td><?= ($siswa['tempat_lahir'] ?? '-') . ', ' . ($siswa['tgl_lahir'] ? date('d-m-Y', strtotime($siswa['tgl_lahir'])) : '-') ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Agama</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['agama'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">No. Handphone</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['no_hp_siswa'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Email</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['email'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Kolom 2 -->
                <td style="width: 38%; vertical-align: top; padding-left: 5px; border-left: 1px solid #ccc;">
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">No. KK</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['no_kk'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Kepala Keluarga</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['kepala_keluarga'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Status Keluarga</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['status_keluarga'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Anak Ke / Sdr</td>
                            <td class="sep-col">:</td>
                            <td>Ke-<?= $siswa['anak_ke'] ?? '-' ?> dari <?= $siswa['jml_saudara'] ?? '-' ?> bersaudara</td>
                        </tr>
                        <tr>
                            <td class="parent-label">Hobi / Cita-cita</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['hobi'] ?? '-' ?> / <?= $siswa['cita'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">PAUD / TK</td>
                            <td class="sep-col">:</td>
                            <td>PAUD: <?= $siswa['paud'] ?? '-' ?>, TK: <?= $siswa['tk'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Kolom 3 (Photo) -->
                <td style="width: 3.5cm; vertical-align: top; text-align: right;">
                    <?php 
                        // Ambil foto dari tabel berkas
                        $fotoBerkas = \Config\Database::connect()->table('tbl_berkas')
                            ->where('id_siswa', $siswa['id_siswa'])
                            ->where('jenis_berkas', 'foto')
                            ->get()->getRowArray();
                    ?>
                    <div class="photo-box" style="margin-left: auto;">
                        <?php if (!empty($fotoBerkas['nama_file'])): ?>
                            <img src="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $fotoBerkas['nama_file']) ?>">
                        <?php else: ?>
                            <div class="text-center font-bold" style="color: #ccc; font-family: Arial;">Pas Foto<br>3 x 4</div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </table>

        <!-- B. DATA ASAL SEKOLAH -->
        <div class="section-title">B. DATA ASAL SEKOLAH</div>
        <table class="data-table">
            <tr>
                <td class="label-col">Nama Sekolah Asal</td>
                <td class="sep-col">:</td>
                <td class="font-bold"><?= $siswa['nama_sekolah'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">NPSN Sekolah</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['npsn_sekolah'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Jenjang / Status</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['jenjang_sekolah'] ?? '-' ?> / <?= $siswa['status_sekolah'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Lokasi Sekolah</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['lokasi_sekolah'] ?? '-' ?></td>
            </tr>
        </table>

        <!-- C. DATA ALAMAT -->
        <div class="section-title">C. ALAMAT TEMPAT TINGGAL</div>
        <table class="data-table">
            <tr>
                <td class="label-col">Alamat Lengkap</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['alamat_siswa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Kelurahan / Desa</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['desa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Kecamatan</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['kec'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Kabupaten / Kota</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['kab'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Provinsi</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['prov'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Kode Pos</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['kode_pos'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Jenis Tinggal</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['jenis_tinggal'] ?? '-' ?></td>
            </tr>
        </table>

        <!-- D. DATA ORANG TUA / WALI -->
        <div class="section-title">D. DATA ORANG TUA / WALI</div>
        <!-- Layout Split 2 Kolom untuk Ayah dan Ibu -->
        <table class="parent-table-container">
            <tr>
                <!-- Kolom Ayah -->
                <td style="padding-right: 15px;">
                    <div style="font-weight: bold; font-family: Arial; border-bottom: 1px dotted #999; margin-bottom: 5px;">1. DATA AYAH</div>
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">Nama Ayah</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nama_ayah'] ?? '-' ?> (<?= $siswa['status_ayah'] ?? '-' ?>)</td>
                        </tr>
                        <tr>
                            <td class="parent-label">NIK Ayah</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nik_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Tahun Lahir</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['th_lahir_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Pendidikan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pdd_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Pekerjaan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pekerjaan_ayah'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Penghasilan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['penghasilan_ayah'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>

                <!-- Kolom Ibu -->
                <td style="padding-left: 15px; border-left: 1px solid #eee;">
                    <div style="font-weight: bold; font-family: Arial; border-bottom: 1px dotted #999; margin-bottom: 5px;">2. DATA IBU</div>
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">Nama Ibu</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nama_ibu'] ?? '-' ?> (<?= $siswa['status_ibu'] ?? '-' ?>)</td>
                        </tr>
                        <tr>
                            <td class="parent-label">NIK Ibu</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nik_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Tahun Lahir</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['th_lahir_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Pendidikan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pdd_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Pekerjaan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pekerjaan_ibu'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Penghasilan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['penghasilan_ibu'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <?php if(!empty($siswa['nama_wali'])): ?>
        <div style="font-weight: bold; font-family: Arial; border-bottom: 1px dotted #999; margin-bottom: 5px; margin-top: 5px;">3. DATA WALI</div>
        <table class="parent-table-container">
            <tr>
                <td style="padding-right: 15px;">
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">Nama Wali</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nama_wali'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">NIK Wali</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['nik_wali'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Tahun Lahir</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['th_lahir_wali'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>
                <td style="padding-left: 15px; border-left: 1px solid #eee;">
                    <table class="parent-inner-table">
                        <tr>
                            <td class="parent-label">Pendidikan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pdd_wali'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Pekerjaan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['pekerjaan_wali'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td class="parent-label">Penghasilan</td>
                            <td class="sep-col">:</td>
                            <td><?= $siswa['penghasilan_wali'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php endif; ?>

        <!-- Kontak Darurat Ortu -->
        <table class="data-table" style="margin-top: 5px;">
            <tr>
                <td class="label-col" style="font-weight: bold;">No. HP Ortu/Wali</td>
                <td class="sep-col">:</td>
                <td class="font-bold"><?= $siswa['no_hp_ortu'] ?? '-' ?></td>
            </tr>
        </table>

        <!-- E. KESEJAHTERAAN -->
        <div class="section-title">E. KESEJAHTERAAN</div>
        <table class="data-table">
            <tr>
                <td class="label-col">No. KKS</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['no_kks'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">No. PKH</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['no_pkh'] ?? '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">No. KIP</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['no_kip'] ?? '-' ?></td>
            </tr>
        </table>

        <!-- F. STATUS PENDAFTARAN -->
        <div class="section-title">F. STATUS PENDAFTARAN</div>
        <table class="data-table">
            <tr>
                <td class="label-col">Tanggal Daftar</td>
                <td class="sep-col">:</td>
                <td><?= $siswa['tgl_siswa'] ? date('d-m-Y H:i', strtotime($siswa['tgl_siswa'])) : '-' ?></td>
            </tr>
            <tr>
                <td class="label-col">Status Verifikasi</td>
                <td class="sep-col">:</td>
                <td>
                    <?php if (($siswa['status_verifikasi'] ?? '') == 'Terverifikasi') : ?>
                        <b style="color: #166534;">SUDAH DIVERIFIKASI</b>
                    <?php elseif (($siswa['status_verifikasi'] ?? '') == 'Ditolak') : ?>
                        <b style="color: #991b1b;">DITOLAK</b>
                    <?php else : ?>
                        <b style="color: #9a3412;">MENUNGGU VERIFIKASI</b>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <!-- Section Tanda Tangan & Catatan -->
        <table class="signature-section">
            <tr>
                <td style="width: 55%; vertical-align: bottom;">
                    <div class="note-box">
                        <strong>Catatan Penting:</strong>
                        <ul style="margin: 3px 0 0 15px; padding: 0;">
                            <li>Simpan formulir pendaftaran ini sebagai bukti fisik yang sah.</li>
                            <li>Segera lengkapi berkas persyaratan fisik ke sekolah/madrasah.</li>
                            <li>Pantau terus status verifikasi dan kelulusan di website resmi.</li>
                        </ul>
                    </div>
                </td>
                <td style="width: 45%; text-align: center; vertical-align: bottom;">
                    <div style="margin-bottom: 10px;">
                        <?= $web['kabupaten'] ?? 'Tempat' ?>, <?= date('d-m-Y') ?> <br>
                        Calon Siswa,
                    </div>
                    <?php 
                        // Generate QR for validation
                        $qr_url = base_url('verify/' . ($siswa['no_pendaftaran'] ?? 'invalid'));
                    ?>
                    <div style="display: flex; justify-content: center; margin-bottom: 10px;">
                        <img src="<?= generate_qr_base64($qr_url, 100, 2) ?>" style="width: 65px; height: 65px;" alt="QR Validation">
                    </div>
                    <div class="font-bold" style="text-decoration: underline;">
                        <?= strtoupper($siswa['nama_lengkap']) ?>
                    </div>
                    <div>NISN. <?= $siswa['nisn'] ?? '-' ?></div>
                </td>
            </tr>
        </table>

        <!-- Footer Otomatis -->
        <div class="footer-system">
            *Dokumen ini dicetak otomatis dari Sistem <?= $app_alias ?? 'PPDB' ?> Online <?= $web['nama_sekolah'] ?? 'Sekolah' ?> pada tanggal <?= date('d-m-Y H:i:s') ?> WIB
        </div>

    </div> <!-- End Paper Container -->

</body>
</html>