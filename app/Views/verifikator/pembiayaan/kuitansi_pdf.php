<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kuitansi Pembayaran - <?= esc($siswa['no_pendaftaran']) ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 15px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; font-size: 11px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 150px; font-weight: bold; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.items th, table.items td { border: 1px solid #ccc; padding: 8px 10px; text-align: left; }
        table.items th { background: #f5f5f5; font-size: 11px; text-transform: uppercase; }
        table.items td:last-child, table.items th:last-child { text-align: right; }
        .total-box { background: #f0fdf4; border: 2px solid #22c55e; padding: 15px; text-align: center; margin: 20px 0; border-radius: 8px; }
        .total-box h3 { margin: 0; color: #16a34a; font-size: 20px; }
        .footer { margin-top: 40px; text-align: right; font-size: 11px; color: #666; }
        .signature { margin-top: 60px; text-align: right; }
        .signature-line { border-top: 1px solid #333; width: 200px; margin-left: auto; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Kuitansi Pembayaran</h2>
        <p>Pendaftaran Calon Siswa</p>
    </div>

    <table class="info-table">
        <tr>
            <td>No. Pendaftaran</td>
            <td>: <?= esc($siswa['no_pendaftaran']) ?></td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>: <?= esc($siswa['nama_lengkap']) ?></td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: <?= esc($siswa['nisn'] ?? '-') ?></td>
        </tr>
    </table>

    <h3 style="font-size: 13px; margin-bottom: 10px;">Rincian Tagihan</h3>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th style="text-align:right">Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($tagihan as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($t['nama_item']) ?></td>
                    <td style="text-align:right">Rp <?= number_format($t['harga_satuan'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight:bold; background:#f5f5f5;">
                <td colspan="2" style="text-align:right">Total Tagihan</td>
                <td style="text-align:right">Rp <?= number_format($totalTagihan, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="total-box">
        <p style="margin:0 0 5px; font-size:12px; color:#16a34a;">TOTAL PEMBAYARAN</p>
        <h3>Rp <?= number_format($totalBayar, 0, ',', '.') ?></h3>
        <p style="margin:5px 0 0; font-size:11px; color:#15803d;">LUNAS</p>
    </div>

    <h3 style="font-size: 13px; margin-bottom: 10px;">Riwayat Pembayaran</h3>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th style="text-align:right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($riwayatBayar as $bayar): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($bayar['tanggal'])) ?></td>
                    <td><?= esc($bayar['metode'] ?? '-') ?></td>
                    <td style="text-align:right">Rp <?= number_format($bayar['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 11px; color: #666;">
        Dikeluarkan pada tanggal <?= date('d/m/Y') ?>
    </p>

    <div class="signature">
        <div class="signature-line">
            <strong>Verifikator</strong>
        </div>
    </div>
</body>
</html>
