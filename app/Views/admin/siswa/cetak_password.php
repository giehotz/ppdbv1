<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Password Baru - <?= esc($data['nama']) ?></title>
    <style>
        /* A4 Layout Styling - Kertas Kecil (Misal potong A4 atau 10x15cm) */
        @page {
            size: A4;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
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
            border: 2px dashed #ccc;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .paper-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-width: 100%;
                border: none;
            }
            .print-btn {
                display: none !important;
            }
        }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 14px;
            background-color: #059669;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-lg { font-size: 16pt; font-weight: bold; margin-bottom: 5px; }
        .text-md { font-size: 12pt; margin-bottom: 15px; }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12pt;
        }
        .detail-table td {
            padding: 8px 0;
        }
        .password-box {
            font-size: 24pt;
            font-family: monospace;
            background: #f8f9fa;
            border: 2px solid #333;
            padding: 15px;
            text-align: center;
            letter-spacing: 5px;
            font-weight: bold;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info {
            font-size: 10pt;
            color: #555;
            text-align: justify;
            margin-top: 20px;
        }
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body onload="window.print()">

    <button class="print-btn" onclick="window.print()">Cetak Resi Password</button>

    <div class="paper-container">
        <!-- KOP Surat -->
        <?php helper('kop'); ?>
        <?= render_kop_surat() ?>

        <div class="text-center">
            <div class="text-lg">KREDENSIAL AKUN SEMENTARA</div>
            <div class="text-md">PENERIMAAN PESERTA DIDIK BARU</div>
        </div>

        <table class="detail-table">
            <tr>
                <td style="width: 150px;">Nama Siswa</td>
                <td style="width: 10px;">:</td>
                <td style="font-weight: bold;"><?= esc($data['nama']) ?></td>
            </tr>
            <tr>
                <td>No. Pendaftaran</td>
                <td>:</td>
                <td><?= esc($data['no_daftar']) ?></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td><?= esc($data['nisn']) ?></td>
            </tr>
        </table>

        <div class="password-box">
            <?= esc($data['password']) ?>
        </div>

        <div class="text-center" style="margin-top: -10px; margin-bottom: 30px; font-weight: bold;">
            ( PASSWORD BARU ANDA )
        </div>

        <div class="info">
            <strong>PERHATIAN:</strong><br>
            Password di atas telah direset oleh Panitia / Administrator. Harap simpan dokumen ini atau ingat baik-baik password tersebut. Sangat disarankan untuk <u>segera mengganti password ini</u> di menu Profil Anda setelah Anda berhasil masuk ke dalam sistem.
        </div>

        <hr>

        <table style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;">
                    <div>Dikeluarkan pada: <?= esc($data['tanggal']) ?></div>
                    <div style="margin-top: 50px;"><strong>Panitia PPDB</strong></div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
