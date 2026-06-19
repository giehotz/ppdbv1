<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Informasi Akun Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: #1e293b; display: flex; justify-content: center; padding: 2rem; }
        .page { background: #fff; width: 100%; max-w: 800px; padding: 3rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); position: relative; }
        .header { display: flex; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 1.5rem; margin-bottom: 2rem; }
        .header img { height: 70px; margin-right: 1.5rem; }
        .header-text h1 { font-size: 1.5rem; font-weight: 800; margin: 0; color: #0f172a; text-transform: uppercase; }
        .header-text p { font-size: 0.875rem; margin: 0.25rem 0 0; color: #64748b; }
        .title { text-align: center; margin-bottom: 2.5rem; }
        .title h2 { font-size: 1.25rem; font-weight: 700; margin: 0; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #1e293b; display: inline-block; padding-bottom: 0.25rem; }
        .info-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 2rem; margin-bottom: 2rem; }
        .info-row { display: flex; margin-bottom: 1rem; font-size: 1rem; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { width: 180px; font-weight: 600; color: #475569; }
        .info-colon { width: 20px; font-weight: 600; color: #475569; }
        .info-value { flex: 1; font-weight: 700; color: #0f172a; }
        .info-value.password { font-family: monospace; font-size: 1.2rem; letter-spacing: 0.1em; background: #e2e8f0; padding: 0.25rem 0.5rem; border-radius: 0.25rem; }
        .warning { border-left: 4px solid #ef4444; background: #fef2f2; padding: 1rem; border-radius: 0.5rem; font-size: 0.875rem; color: #991b1b; line-height: 1.5; }
        .footer { margin-top: 3rem; text-align: right; font-size: 0.875rem; color: #475569; }
        .print-btn { position: fixed; bottom: 2rem; right: 2rem; background: #2563eb; color: #fff; border: none; padding: 1rem 2rem; font-size: 1rem; font-weight: 600; border-radius: 9999px; cursor: pointer; box-shadow: 0 4px 6px -1px rgb(37 99 235 / 0.5); display: flex; align-items: center; gap: 0.5rem; transition: background 0.2s; }
        .print-btn:hover { background: #1d4ed8; }
        .back-btn { position: fixed; bottom: 2rem; left: 2rem; background: #64748b; color: #fff; text-decoration: none; padding: 1rem 2rem; font-size: 1rem; font-weight: 600; border-radius: 9999px; box-shadow: 0 4px 6px -1px rgb(100 116 139 / 0.5); transition: background 0.2s; display: flex; align-items: center; gap: 0.5rem; }
        .back-btn:hover { background: #475569; }
        @media print {
            body { background: #fff; padding: 0; }
            .page { box-shadow: none; border-radius: 0; padding: 0; max-width: 100%; }
            .print-btn, .back-btn { display: none; }
        }
    </style>
</head>
<body>

    <a href="<?= base_url('verifikator/siswa') ?>" class="back-btn">
        &larr; Kembali ke Daftar Siswa
    </a>

    <button onclick="window.print()" class="print-btn">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z"></path></svg>
        Cetak Dokumen
    </button>

    <div class="page">
        <!-- Optional: Integrate with KOP Helper if available, or static header -->
        <div class="header">
            <?php 
            // Coba ambil logo dari tabel setting_kop (jika ada helper)
            // fallback ke logo statis
            $db = \Config\Database::connect();
            $kop = $db->table('setting_kop')->get()->getRowArray();
            ?>
            <?php if (!empty($kop['logo_kiri']) && file_exists(FCPATH . 'uploads/kop/' . $kop['logo_kiri'])): ?>
                <img src="<?= base_url('uploads/kop/' . $kop['logo_kiri']) ?>" alt="Logo">
            <?php else: ?>
                <div style="width: 70px; height: 70px; background: #e2e8f0; border-radius: 50%; margin-right: 1.5rem;"></div>
            <?php endif; ?>
            
            <div class="header-text">
                <h1>PANITIA PENERIMAAN PESERTA DIDIK BARU</h1>
                <p><?= esc($kop['nama_instansi'] ?? 'Instansi Pendidikan') ?></p>
            </div>
        </div>

        <div class="title">
            <h2>INFORMASI AKUN PENDAFTARAN SISWA</h2>
        </div>

        <div class="info-card">
            <div class="info-row">
                <div class="info-label">No. Pendaftaran</div>
                <div class="info-colon">:</div>
                <div class="info-value"><?= esc($siswa['no_pendaftaran']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-colon">:</div>
                <div class="info-value"><?= esc($siswa['nama_lengkap']) ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">NISN (Username)</div>
                <div class="info-colon">:</div>
                <div class="info-value"><?= esc($siswa['nisn']) ?></div>
            </div>
            <div class="info-row" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #cbd5e1;">
                <div class="info-label">Password Sementara</div>
                <div class="info-colon">:</div>
                <div class="info-value"><span class="password">[Dibuat oleh Verifikator]</span></div>
            </div>
        </div>

        <div class="warning">
            <strong>PENTING:</strong><br>
            Slip informasi ini berisi data kredensial akun untuk login ke portal PPDB Online. Harap simpan slip ini dengan baik. Gunakan <b>NISN</b> sebagai Username dan Password yang telah diinformasikan oleh Verifikator saat pendaftaran. Segera ganti password Anda setelah berhasil login pertama kali demi keamanan akun.
        </div>

        <div class="footer">
            <p>Dicetak oleh: <?= esc(session()->get('nama_lengkap')) ?> (Verifikator)</p>
            <p>Tanggal: <?= date('d/m/Y H:i') ?></p>
        </div>
    </div>

</body>
</html>
