<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Verifikasi Dokumen Resmi') ?> - <?= esc($instansi['nama_instansi'] ?? 'PPDB') ?></title>

    <?php
    $page_title = $title ?? 'Verifikasi Dokumen Resmi';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS (TailAdmin tokens) -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 22px;
            line-height: 1;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        .pulse-valid {
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 12px rgba(16, 185, 129, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body class="bg-gray-100/70 text-gray-800 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="max-w-md w-full rounded-2xl border border-gray-200 bg-white shadow-theme-md overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        
        <!-- Header Banner -->
        <div class="p-6 text-center <?= $status === 'success' ? 'bg-gradient-to-b from-emerald-50/70 to-transparent' : 'bg-gradient-to-b from-red-50/70 to-transparent' ?>">
            <?php if ($status === 'success'): ?>
                <!-- SUCCESS STATE -->
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-theme-sm pulse-valid mb-4">
                    <span class="material-symbols-outlined text-4xl">verified</span>
                </div>
                
                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-500/30">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Dokumen Asli &amp; Valid
                </span>
                
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mt-2 mb-0.5">TERCATAT RESMI</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto">
                    Data siswa ini terdaftar secara sah di sistem <?= esc($instansi['nama_instansi'] ?? 'Madrasah/Sekolah') ?>
                </p>
                
                <!-- Student Avatar & Name -->
                <div class="my-5">
                    <?php
                    $photoSrc = null;
                    if (!empty($siswa['foto_berkas'])) {
                        $photoSrc = base_url(esc($siswa['foto_berkas']));
                    } elseif (!empty($siswa['foto'])) {
                        $photoSrc = base_url('uploads/berkas/' . esc($siswa['nisn']) . '/' . esc($siswa['foto']));
                    }
                    ?>
                    
                    <div class="h-24 w-20 mx-auto rounded-2xl overflow-hidden shadow-theme-xs border-2 border-emerald-500 bg-gray-100 dark:bg-gray-800 mb-3">
                        <?php if ($photoSrc): ?>
                            <img src="<?= $photoSrc ?>" alt="Foto Siswa" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center font-bold text-xl text-emerald-700 bg-emerald-50">
                                <?= strtoupper(substr($siswa['nama_lengkap'] ?? 'S', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="text-base font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap']) ?></h3>
                    <span class="inline-flex items-center gap-1 text-xs font-mono font-bold text-brand-600 dark:text-brand-400 mt-0.5">
                        <span class="material-symbols-outlined text-xs">badge</span>
                        <?= esc($siswa['no_pendaftaran']) ?>
                    </span>
                </div>
                
                <!-- Data Detail List -->
                <div class="rounded-2xl border border-gray-200/80 bg-gray-50/70 p-4 text-left dark:border-gray-800 dark:bg-gray-800/40 text-xs space-y-2.5">
                    <div class="flex justify-between items-center border-b border-gray-200/60 dark:border-gray-800 pb-2">
                        <span class="text-gray-500 dark:text-gray-400">NISN</span>
                        <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['nisn'] ?? '-') ?></span>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-200/60 dark:border-gray-800 pb-2">
                        <span class="text-gray-500 dark:text-gray-400">Status Kelulusan</span>
                        <?php if ($siswa['status_lulus'] === 'Lulus'): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400">
                                <span class="material-symbols-outlined text-xs">check</span>
                                LULUS
                            </span>
                        <?php elseif ($siswa['status_lulus'] === 'Tidak Lulus'): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-bold text-red-700 border border-red-200 dark:bg-red-500/15 dark:text-red-400">
                                <span class="material-symbols-outlined text-xs">close</span>
                                TIDAK LULUS
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-bold text-amber-700 border border-amber-200 dark:bg-amber-500/15 dark:text-amber-400">
                                <span class="material-symbols-outlined text-xs">hourglass_top</span>
                                PROSES SELEKSI
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="flex justify-between items-start pt-0.5">
                        <span class="text-gray-500 dark:text-gray-400 shrink-0">Asal Sekolah</span>
                        <span class="font-semibold text-gray-900 dark:text-white text-right max-w-[65%] leading-snug">
                            <?= esc($siswa['nama_sekolah'] ?? '-') ?>
                        </span>
                    </div>
                </div>

            <?php else: ?>
                <!-- ERROR STATE -->
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-red-500 text-white shadow-theme-sm mb-4">
                    <span class="material-symbols-outlined text-4xl">gpp_bad</span>
                </div>
                
                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-red-700 border border-red-200 dark:bg-red-500/15 dark:text-red-400 dark:border-red-500/30">
                    <span class="material-symbols-outlined text-sm">warning</span>
                    Data Tidak Ditemukan
                </span>

                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mt-2 mb-2">TIDAK VALID</h2>
                
                <div class="rounded-2xl border border-red-200 bg-red-50/70 p-4 text-xs text-red-700 dark:border-red-900/40 dark:bg-red-950/20 leading-relaxed mb-4">
                    <?= esc($message ?? 'Data tidak ditemukan atau nomor verifikasi QR tidak terdaftar pada sistem.') ?>
                </div>

                <p class="text-[11px] text-gray-400 leading-tight">
                    Waspada terhadap pemalsuan dokumen atau tanda bukti pendaftaran yang tidak terverifikasi.
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Footer Action -->
        <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100 dark:border-gray-800 dark:bg-gray-900/40 text-center">
            <a href="<?= base_url() ?>" 
               class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors">
                <span class="material-symbols-outlined text-base">home</span>
                <span>Kembali ke Beranda PPDB</span>
            </a>
        </div>
        
    </div>

</body>
</html>
