<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Kelulusan - <?= $siswa['nama_lengkap'] ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #000;
        }

        p {
            line-height: 1;
            /* Spasi 1.5 kali ukuran font */
        }

        .container {
            width: 100%;
            max-width: 210mm;
            /* A4 width */
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header-inner {
            display: table;
            width: 100%;
        }

        .header-logo {
            display: table-cell;
            vertical-align: middle;
            width: 100px;
        }

        .header-logo img {
            height: 90px;
            width: auto;
        }

        .header-text {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .header-spacer {
            display: table-cell;
            width: 100px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 14px;
        }

        .content {
            margin-bottom: 40px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 30px;
            text-decoration: underline;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        table td {
            padding: 5px 0;
            vertical-align: top;
            font-size: 16px;
        }

        .label {
            width: 200px;
        }

        .separator {
            width: 20px;
        }

        .status-box {
            border: 3px double #16a34a;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 30px auto;
            text-transform: uppercase;
            width: 300px;
            color: #16a34a;
        }

        .footer-container {
            margin-top: 50px;
            width: 100%;
        }

        .footer-table {
            width: 100%;
            margin-left: 0;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 50%;
            vertical-align: bottom;
            padding: 0;
        }

        .qr-cell {
            text-align: center;
            padding-left: 30px;
        }

        .qr-cell img {
            width: 100px;
            height: 100px;
            border: 2px solid #000;
            padding: 2px;
        }

        .qr-cell p {
            font-size: 11px;
            margin-top: 5px;
            font-style: italic;
        }

        .signature-cell {
            text-align: center;
            padding-right: 30px;
        }

        .signature-cell p {
            margin: 5px 0;
        }

        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }

        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                max-width: none;
                padding: 0;
                border: none;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <?php helper('kop'); ?>
        <?= render_kop_surat() ?>

        <div class="content">
            <div class="title">SURAT KETERANGAN LULUS SELEKSI</div>

            <p>Berdasarkan hasil seleksi <?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?> (<?= $app_alias ?? 'PPDB' ?>) Tahun Pelajaran <?= $web['th_pelajaran'] ?>, Panitia <?= $app_alias ?? 'PPDB' ?> <?= $web['nama_sekolah'] ?> menyatakan bahwa:</p>

            <table>
                <tr>
                    <td class="label">No. Pendaftaran</td>
                    <td class="separator">:</td>
                    <td><?= $siswa['no_pendaftaran'] ?></td>
                </tr>
                <tr>
                    <td class="label">NISN</td>
                    <td class="separator">:</td>
                    <td><?= $siswa['nisn'] ?></td>
                </tr>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td><?= strtoupper($siswa['nama_lengkap']) ?></td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="separator">:</td>
                    <td><?= $siswa['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($siswa['tgl_lahir'])) ?></td>
                </tr>
                <tr>
                    <td class="label">Nama Orang Tua</td>
                    <td class="separator">:</td>
                    <td><?= $siswa['nama_ayah'] ?></td>
                </tr>
                <tr>
                    <td class="label">Asal Sekolah</td>
                    <td class="separator">:</td>
                    <td><?= $siswa['nama_sekolah'] ?></td>
                </tr>
            </table>

            <p>Dinyatakan:</p>

            <div class="status-box ">
                LULUS SELEKSI
            </div>

            <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <div class="footer-container">
            <table class="footer-table">
                <tr>
                    <td class="qr-cell">
                        <?php
                        $qrData = "No: " . $siswa['no_pendaftaran'] . "\nNama: " . $siswa['nama_lengkap'] . "\nNISN: " . $siswa['nisn'] . "\nStatus: LULUS";
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);
                        ?>
                        <img src="<?= $qrUrl ?>" alt="QR Code Verifikasi">
                        <p>Scan untuk Verifikasi Panitia</p>
                    </td>
                    <td class="signature-cell">
                        <?php
                        $bulanIndo = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                        $tglCetak = date('d') . ' ' . $bulanIndo[(int)date('m')] . ' ' . date('Y');
                        ?>
                        <p><?= $web['kabupaten'] ?>, <?= $tglCetak ?></p>
                        <p>Kepala Madrasah,</p>
                        <br>TTD<br>
                        <p><strong><?= $web['nama_kepala'] ?></strong></p>
                        <p>NIP. <?= $web['nip_kepala'] ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <button class="print-btn" onclick="window.print()">Cetak</button>
    </div>

</body>

</html>