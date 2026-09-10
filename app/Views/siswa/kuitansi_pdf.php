<?php helper('kop'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kuitansi Pembayaran - <?= esc($siswa['no_pendaftaran']) ?></title>
    <style>
        :root {
            --ink: #1a1a1a;
            --muted: #555555;
            --line: #222222;
            --line-soft: #d0d0d0;
            --brand: #0f7a5c;
            --brand-soft: #eaf7f2;
            --total-bg: #1f8a4c;
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: var(--ink);
        }

        .sheet {
            max-width: 780px;
            margin: 0 auto;
        }

        /* ===== KOP SURAT ===== */
        .kop-wrap {
            margin-bottom: 6px;
        }

        /* ===== TITLE BAR ===== */
        .title-bar {
            text-align: center;
            margin: 14px 0 16px;
        }

        .title-bar h1 {
            display: inline-block;
            margin: 0;
            font-size: 22px;
            letter-spacing: 2px;
            color: var(--brand);
            text-transform: uppercase;
            padding-bottom: 6px;
            border-bottom: 3px solid var(--brand);
        }

        .title-bar p {
            margin: 4px 0 0;
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.5px;
        }

        /* ===== INFO GRID (2 kolom, seperti Bill To / Invoice No) ===== */
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .info-grid td {
            vertical-align: top;
            width: 50%;
            padding: 0;
        }

        .info-block .info-heading {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
            font-size: 11px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 2px;
        }

        .info-row .lbl,
        .info-row .val {
            display: table-cell;
        }

        .info-row .lbl {
            width: 95px;
            color: var(--ink);
        }

        .info-row .val {
            font-weight: 600;
        }

        .info-right {
            text-align: left;
        }

        .info-right .info-row .lbl {
            width: 110px;
        }

        /* ===== ITEMS TABLE ===== */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            border: 1px solid var(--line);
            font-size: 11px;
        }

        table.items th,
        table.items td {
            border: 1px solid var(--line-soft);
            padding: 6px 8px;
            text-align: left;
        }

        table.items th {
            background: #f0f0f0;
            font-weight: bold;
            border: 1px solid var(--line);
            text-align: center;
            font-size: 10px;
            text-transform: uppercase;
        }

        table.items td:first-child,
        table.items th:first-child {
            text-align: center;
            width: 40px;
        }

        table.items td:last-child,
        table.items th:last-child {
            text-align: right;
        }

        /* ===== TOTAL SUMMARY (mirip Total Before Tax / Grand Total) ===== */
        .summary-wrap {
            width: 100%;
            margin: 10px 0 18px;
        }

        .summary-table {
            width: 260px;
            margin-left: auto;
            border-collapse: collapse;
            font-size: 11px;
        }

        .summary-table td {
            padding: 6px 10px;
            border: 1px solid var(--line-soft);
        }

        .summary-table td:first-child {
            text-align: left;
        }

        .summary-table td:last-child {
            text-align: right;
            width: 130px;
        }

        .summary-table tr.grand td {
            background: var(--total-bg);
            color: #ffffff;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid var(--total-bg);
        }

        .status-tag {
            display: inline-block;
            margin-top: 6px;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffffff;
            background: var(--total-bg);
            padding: 3px 10px;
            border-radius: 3px;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 4px 0 6px;
            color: var(--ink);
        }

        /* ===== FOOTER: DETAIL / SIGNATURE (mirip Detail Payment / Director) ===== */
        .footer-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .footer-grid td {
            vertical-align: top;
            width: 50%;
        }

        .footer-left .foot-heading {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 6px;
        }

        .footer-right {
            text-align: center;
        }

        .footer-right .company-name {
            font-weight: bold;
            margin-bottom: 48px;
        }

        .footer-right .signature-line {
            border-top: 1px solid var(--ink);
            display: inline-block;
            min-width: 170px;
            padding-top: 4px;
            font-weight: bold;
        }

        .footer-right .signature-role {
            font-size: 10px;
            color: var(--muted);
        }

        .tiny-note {
            margin-top: 10px;
            font-size: 9px;
            color: var(--muted);
        }
    </style>
</head>
<body>
<div class="sheet">

    <div class="kop-wrap">
        <?= render_kop_surat() ?>
    </div>

    <div class="title-bar">
        <h1>Kuitansi Pembayaran</h1>
        <p>Pendaftaran Calon Siswa Baru</p>
    </div>

    <table class="info-grid">
        <tr>
            <td>
                <div class="info-block">
                    <div class="info-heading">Diterima Dari</div>
                    <div class="info-row"><span class="lbl">Nama Lengkap</span><span class="val">: <?= esc($siswa['nama_lengkap']) ?></span></div>
                    <div class="info-row"><span class="lbl">NISN</span><span class="val">: <?= esc($siswa['nisn'] ?? '-') ?></span></div>
                </div>
            </td>
            <td class="info-right">
                <div class="info-block">
                    <div class="info-row"><span class="lbl">No. Pendaftaran</span><span class="val">: <?= esc($siswa['no_pendaftaran']) ?></span></div>
                    <div class="info-row"><span class="lbl">Tanggal Cetak</span><span class="val">: <?= date('d/m/Y') ?></span></div>
                    <div class="info-row"><span class="lbl">Status</span><span class="val">: <strong style="color:#1f8a4c;">LUNAS</strong></span></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Rincian Tagihan</div>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($tagihan as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($t['nama_item']) ?></td>
                    <td>Rp <?= number_format($t['harga_satuan'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary-wrap">
        <table class="summary-table">
            <tr>
                <td>Total Tagihan</td>
                <td>Rp <?= number_format($totalTagihan, 0, ',', '.') ?></td>
            </tr>
            <tr class="grand">
                <td>TOTAL PEMBAYARAN</td>
                <td>Rp <?= number_format($totalLunas ?? $totalBayar ?? $totalTagihan, 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <div class="section-title">Riwayat Pembayaran</div>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($riwayatBayar as $bayar): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="text-align:left;"><?= date('d/m/Y', strtotime($bayar['tanggal'])) ?></td>
                    <td style="text-align:left;"><?= esc($bayar['metode'] ?? '-') ?></td>
                    <td>Rp <?= number_format($bayar['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="footer-grid">
        <tr>
            <td class="footer-left">
                <div class="foot-heading">Keterangan</div>
                <div>Status Pembayaran: <strong style="color:#1f8a4c;">LUNAS</strong></div>
                <p class="tiny-note">Kuitansi ini sah dan diterbitkan secara resmi oleh sistem PPDB.<br>Dikeluarkan pada tanggal <?= date('d/m/Y') ?>.</p>
            </td>
            <td class="footer-right">
                <div class="company-name">Panitia PPDB</div>
                <div class="signature-line">Verifikator</div><br>
                <div class="signature-role">Petugas Keuangan</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>