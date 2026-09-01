<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftar - <?= esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?></title>
    
    <?php
    $page_title = 'Daftar Pendaftar';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- TailAdmin CSS & App Tailwind CSS -->
    <link rel="preload" as="style" href="<?= base_url('assets/tailadmin/css/tailadmin.css') ?>">
    <link rel="preload" as="style" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/tailadmin/css/tailadmin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- TailAdmin JS -->
    <script defer src="<?= base_url('assets/tailadmin/js/tailadmin.js') ?>"></script>

    <!-- Dark Mode Init Script -->
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .heading-font { 
            font-family: 'Outfit', sans-serif; 
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }

        /* CI4 Pager Styling with TailAdmin System */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 0.375rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        .pagination li a, .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.35rem;
            height: 2.35rem;
            padding: 0 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: #4b5563;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
        }
        .dark .pagination li a, .dark .pagination li span {
            color: #9ca3af;
            background-color: #1f2937;
            border-color: #374151;
        }
        .pagination li a:hover {
            color: #465fff;
            background-color: #eff2fe;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }
        .dark .pagination li a:hover {
            color: #818cf8;
            background-color: #312e81/40;
            border-color: #4338ca;
        }
        .pagination li.active span {
            z-index: 1;
            color: #ffffff !important;
            background: linear-gradient(135deg, #465fff 0%, #3641f5 100%) !important;
            border-color: #465fff !important;
            box-shadow: 0 4px 12px rgba(70, 95, 255, 0.25);
        }
        .dark .pagination li.active span {
            color: #ffffff !important;
            background: linear-gradient(135deg, #465fff 0%, #3641f5 100%) !important;
            border-color: #465fff !important;
            box-shadow: 0 4px 14px rgba(70, 95, 255, 0.35);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-gray-950 dark:text-gray-200 flex flex-col min-h-screen antialiased transition-colors duration-200">

    <!-- NAVBAR (TailAdmin Style) -->
    <header class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/90 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/90 transition-colors">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 sm:h-18 items-center justify-between gap-4">
                
                <!-- Brand / Logo -->
                <a href="<?= base_url('/') ?>" class="flex items-center gap-3 group">
                    <?php if (!empty($web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-9 w-9 sm:h-10 sm:w-10 object-contain rounded-xl bg-white p-1 border border-gray-200 dark:border-gray-700 shadow-theme-xs transition-transform group-hover:scale-105">
                    <?php else: ?>
                        <div class="h-9 w-9 sm:h-10 sm:w-10 bg-brand-500 rounded-xl flex items-center justify-center text-white font-bold text-base sm:text-lg shadow-theme-xs transition-transform group-hover:scale-105">
                            <?= mb_substr(esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'P'), 0, 1) ?>
                        </div>
                    <?php endif; ?>
                    <div class="flex flex-col">
                        <span class="heading-font font-bold text-sm sm:text-base md:text-lg text-gray-900 dark:text-white leading-tight tracking-tight">
                            <?= esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?>
                        </span>
                        <span class="text-[11px] font-medium text-brand-500 dark:text-brand-400 leading-none">
                            Portal Pendaftar Publik
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="<?= base_url('/') ?>#beranda" class="px-3.5 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-500 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Beranda
                    </a>
                    <a href="<?= base_url('/') ?>#jadwal" class="px-3.5 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-500 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Jadwal
                    </a>
                    <a href="<?= base_url('/') ?>#syarat" class="px-3.5 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-500 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Syarat
                    </a>
                    <a href="<?= base_url('/') ?>#kontak" class="px-3.5 py-2 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-brand-500 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        Kontak
                    </a>
                    <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                        <a href="<?= base_url('pendaftar') ?>" class="px-3.5 py-2 text-sm font-bold text-brand-500 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 rounded-lg border border-brand-200 dark:border-brand-500/20">
                            Data Pendaftar
                        </a>
                    <?php endif; ?>
                </nav>

                <!-- Actions & Dark Mode -->
                <div class="flex items-center gap-2 sm:gap-3">
                    
                    <!-- Dark Mode Toggler -->
                    <button
                        id="theme-toggle"
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white shadow-theme-xs"
                        title="Ganti Tema (Dark / Light Mode)"
                    >
                        <!-- Sun Icon (shown in dark mode) -->
                        <span class="material-symbols-outlined text-xl hidden dark:block text-amber-400">light_mode</span>
                        <!-- Moon Icon (shown in light mode) -->
                        <span class="material-symbols-outlined text-xl dark:hidden text-gray-600">dark_mode</span>
                    </button>

                    <!-- Auth Buttons -->
                    <a href="<?= base_url('login') ?>" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-xs md:text-sm font-bold text-gray-700 dark:text-gray-200 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-xl transition-all border border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-base">login</span>
                        <span>Masuk</span>
                    </a>
                    <a href="<?= base_url('auth/register') ?>" class="hidden sm:inline-flex items-center gap-1.5 px-4.5 py-2 text-xs md:text-sm font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-theme-xs hover:shadow-theme-sm transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined text-base">how_to_reg</span>
                        <span>Daftar Akun</span>
                    </a>

                    <!-- Hamburger Button (Mobile) -->
                    <button 
                        id="menu-btn" 
                        type="button"
                        class="lg:hidden flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors shadow-theme-xs"
                        aria-label="Menu"
                    >
                        <span class="material-symbols-outlined text-xl">menu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 px-4 py-4 space-y-1 shadow-theme-lg">
            <a href="<?= base_url('/') ?>#beranda" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold text-sm">
                <span class="material-symbols-outlined text-base text-gray-400">home</span>
                <span>Beranda</span>
            </a>
            <a href="<?= base_url('/') ?>#jadwal" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold text-sm">
                <span class="material-symbols-outlined text-base text-gray-400">calendar_month</span>
                <span>Jadwal</span>
            </a>
            <a href="<?= base_url('/') ?>#syarat" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold text-sm">
                <span class="material-symbols-outlined text-base text-gray-400">description</span>
                <span>Syarat</span>
            </a>
            <a href="<?= base_url('/') ?>#kontak" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold text-sm">
                <span class="material-symbols-outlined text-base text-gray-400">support_agent</span>
                <span>Kontak</span>
            </a>
            <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                <a href="<?= base_url('pendaftar') ?>" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl bg-brand-50 dark:bg-brand-500/15 text-brand-500 dark:text-brand-400 font-bold text-sm">
                    <span class="material-symbols-outlined text-base">group</span>
                    <span>Data Pendaftar</span>
                </a>
            <?php endif; ?>

            <div class="border-t border-gray-100 dark:border-gray-800 pt-3 mt-2 grid grid-cols-2 gap-2 sm:hidden">
                <a href="<?= base_url('login') ?>" class="flex items-center justify-center gap-1.5 text-center bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-bold py-2.5 px-4 rounded-xl text-sm border border-gray-200 dark:border-gray-700">
                    <span class="material-symbols-outlined text-base">login</span>
                    <span>Masuk</span>
                </a>
                <a href="<?= base_url('auth/register') ?>" class="flex items-center justify-center gap-1.5 text-center bg-brand-500 text-white font-bold py-2.5 px-4 rounded-xl text-sm shadow-theme-xs">
                    <span class="material-symbols-outlined text-base">how_to_reg</span>
                    <span>Daftar</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-6xl">
            
            <!-- Page Header Section -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="inline-flex items-center gap-2 py-1 px-3.5 rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-xs mb-3 border border-brand-200/60 dark:border-brand-500/20 shadow-theme-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                    <span>Data Publik &amp; Transparansi PPDB</span>
                </div>
                <h1 class="heading-font text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-3 tracking-tight">
                    Daftar Calon Peserta Didik
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    Menampilkan data peserta yang telah terdaftar pada sistem PPDB. Demi kepatuhan privasi data, sebagian nomor NISN dan Nama Lengkap <span class="font-semibold text-gray-700 dark:text-gray-200">disamarkan</span> secara otomatis.
                </p>
            </div>

            <!-- Stats Overview Chips -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-4 shadow-theme-xs flex items-center gap-3.5">
                    <div class="h-11 w-11 rounded-xl bg-brand-50 dark:bg-brand-500/15 text-brand-500 dark:text-brand-400 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">groups</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Total Ditampilkan</span>
                        <span class="heading-font text-lg font-bold text-gray-900 dark:text-white">
                            <?= !empty($pendaftar) ? count($pendaftar) : 0 ?> Data per halaman
                        </span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-4 shadow-theme-xs flex items-center gap-3.5">
                    <div class="h-11 w-11 rounded-xl bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Status Sistem</span>
                        <span class="heading-font text-lg font-bold text-gray-900 dark:text-white">
                            <?= esc($web['status_ppdb'] ?? 'Buka') ?> (Aktif)
                        </span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-4 shadow-theme-xs flex items-center gap-3.5">
                    <div class="h-11 w-11 rounded-xl bg-blue-50 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">security</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Perlindungan Privasi</span>
                        <span class="heading-font text-lg font-bold text-gray-900 dark:text-white">
                            Tersensor Otomatis
                        </span>
                    </div>
                </div>
            </div>

            <!-- Search Card Section (TailAdmin Style) -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-4 sm:p-6 mb-8 shadow-theme-xs">
                <form action="<?= base_url('pendaftar') ?>" method="get" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-xl">search</span>
                        </div>
                        <input 
                            type="text" 
                            name="q" 
                            value="<?= esc($search ?? '') ?>" 
                            placeholder="Cari berdasarkan NISN atau Nama Lengkap calon siswa..." 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:bg-white dark:focus:bg-gray-800 focus:border-brand-500 dark:focus:border-brand-400 focus:ring-4 focus:ring-brand-500/10 focus:outline-none transition-all"
                        >
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button 
                            type="submit" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 px-6 rounded-xl shadow-theme-xs hover:shadow-theme-sm transition-all active:scale-[0.98] text-sm"
                        >
                            <span class="material-symbols-outlined text-lg">search</span>
                            <span>Cari Data</span>
                        </button>
                        <?php if(!empty($search)): ?>
                            <a 
                                href="<?= base_url('pendaftar') ?>" 
                                title="Reset Filter Pencarian" 
                                class="inline-flex items-center justify-center h-11 w-11 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 transition-colors"
                            >
                                <span class="material-symbols-outlined text-lg">close</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Card Section (TailAdmin Style) -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-theme-sm overflow-hidden">
                
                <?php if (!empty($search)): ?>
                    <div class="bg-brand-50/70 dark:bg-brand-500/10 border-b border-brand-100 dark:border-brand-500/20 px-5 py-3.5 flex items-center justify-between text-xs sm:text-sm">
                        <div class="flex items-center gap-2 text-brand-700 dark:text-brand-300">
                            <span class="material-symbols-outlined text-lg">info</span>
                            <span>Hasil pencarian untuk kata kunci: <strong class="font-bold underline"><?= esc($search) ?></strong></span>
                        </div>
                        <a href="<?= base_url('pendaftar') ?>" class="text-brand-600 dark:text-brand-400 font-semibold hover:underline text-xs">
                            Hapus Filter
                        </a>
                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <th class="py-4 px-5 text-center w-16">No</th>
                                <th class="py-4 px-5">NISN</th>
                                <th class="py-4 px-5">Nama Lengkap</th>
                                <th class="py-4 px-5 text-center w-40">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <?php if (empty($pendaftar)): ?>
                                <tr>
                                    <td colspan="4" class="py-16 px-6 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-3 text-gray-400 dark:text-gray-500 shadow-theme-xs">
                                                <span class="material-symbols-outlined text-3xl">folder_off</span>
                                            </div>
                                            <h3 class="heading-font text-base font-bold text-gray-800 dark:text-gray-200 mb-1">
                                                Tidak Ada Data Ditemukan
                                            </h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                                                <?= !empty($search) ? 'Pencarian tidak menemukan pendaftar yang sesuai dengan kata kunci.' : 'Saat ini belum ada data pendaftar yang masuk ke sistem.' ?>
                                            </p>
                                            <?php if(!empty($search)): ?>
                                                <a href="<?= base_url('pendaftar') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-brand-500 bg-brand-50 dark:bg-brand-500/15 border border-brand-200 dark:border-brand-500/30 hover:bg-brand-100 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">restart_alt</span>
                                                    <span>Lihat Semua Data</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                $page = isset($_GET['page_pendaftar']) ? (int)$_GET['page_pendaftar'] : 1;
                                $no = ($page - 1) * 20 + 1;
                                foreach ($pendaftar as $p): 
                                    $namaAwal = mb_substr(trim($p['nama_lengkap']), 0, 1);
                                ?>
                                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/50 transition-colors">
                                        
                                        <!-- No -->
                                        <td class="py-3.5 px-5 text-xs text-gray-400 dark:text-gray-500 text-center font-medium">
                                            <?= $no++ ?>
                                        </td>
                                        
                                        <!-- NISN -->
                                        <td class="py-3.5 px-5">
                                            <div class="inline-flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 flex items-center justify-center text-xs">
                                                    <span class="material-symbols-outlined text-sm">badge</span>
                                                </span>
                                                <span class="font-mono text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 tracking-wider">
                                                    <?= esc($p['nisn']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Nama Lengkap -->
                                        <td class="py-3.5 px-5">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0 border border-brand-100 dark:border-brand-500/20">
                                                    <?= esc($namaAwal) ?>
                                                </div>
                                                <span class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-white">
                                                    <?= esc($p['nama_lengkap']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="py-3.5 px-5 text-center">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-500/20 shadow-theme-xs">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Terdaftar</span>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if (!empty($pendaftar) && $pager->getPageCount('pendaftar') > 1): ?>
                <div class="p-5 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 flex justify-center">
                    <?= $pager->links('pendaftar', 'default_full') ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Call to Action Banner -->
            <div class="mt-8 rounded-2xl bg-gradient-to-r from-brand-500 to-brand-600 p-6 sm:p-8 text-white shadow-theme-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="heading-font text-lg sm:text-xl font-bold mb-1">
                        Belum mendaftar sebagai Calon Peserta Didik?
                    </h3>
                    <p class="text-xs sm:text-sm text-white/80 leading-relaxed max-w-xl">
                        Daftarkan diri Anda sekarang juga sebelum batas waktu pendaftaran berakhir. Proses cepat, mudah, dan online!
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0 w-full sm:w-auto justify-end">
                    <a href="<?= base_url('auth/register') ?>" class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 bg-white text-brand-600 hover:bg-gray-50 font-bold px-6 py-3 rounded-xl shadow-theme-xs transition-all active:scale-[0.98] text-sm">
                        <span class="material-symbols-outlined text-lg">edit_document</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER (TailAdmin Style) -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 pt-8 pb-6 mt-auto transition-colors">
        <div class="container mx-auto max-w-6xl px-4 text-center">
            <div class="flex items-center justify-center gap-2.5 mb-2">
                <span class="heading-font font-bold text-base text-gray-900 dark:text-white">
                    <?= esc($content['footer']['nama_sekolah'] ?? $content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?>
                </span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
                &copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? 'Madrasah') ?>. <?= esc($content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.') ?>
            </p>
            <div class="flex items-center justify-center gap-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                <a href="<?= base_url('/') ?>" class="hover:text-brand-500 dark:hover:text-brand-400 transition-colors">Beranda</a>
                <span>&bull;</span>
                <a href="<?= base_url('pendaftar') ?>" class="text-brand-500 dark:text-brand-400 font-bold">Data Pendaftar</a>
                <span>&bull;</span>
                <a href="<?= base_url('login') ?>" class="hover:text-brand-500 dark:hover:text-brand-400 transition-colors">Login Siswa</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Dark Mode Toggle Button Logic
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
            });
        }
    </script>
</body>
</html>
