<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?></title>

    <?php
    $page_title = 'Daftar Pendaftar';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" />
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </noscript>

    <style>
        :root {
            --neo-black: #000000;
            --neo-yellow: #FFE600;
            --neo-cyan: #00D2FF;
            --neo-lime: #A3E635;
            --neo-pink: #FF6B8B;
            --neo-purple: #C084FC;
            --neo-orange: #FF9F1C;
            --neo-bg: #FFFDF5;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--neo-bg);
        }

        .font-heading {
            font-family: 'Space Grotesk', 'Plus Jakarta Sans', sans-serif;
        }

        .neo-box {
            border: 3px solid #000000;
            box-shadow: 5px 5px 0px 0px #000000;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .neo-box-sm {
            border: 2px solid #000000;
            box-shadow: 3px 3px 0px 0px #000000;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .neo-box-lg {
            border: 4px solid #000000;
            box-shadow: 8px 8px 0px 0px #000000;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .neo-btn {
            border: 3px solid #000000;
            box-shadow: 4px 4px 0px 0px #000000;
            font-weight: 800;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .neo-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #000000;
        }

        .neo-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #000000;
        }

        .neo-card-hover:hover {
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0px 0px #000000;
        }

        .bg-neo-dots {
            background-image: radial-gradient(#000000 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }

        .bg-neo-grid {
            background-image:
                linear-gradient(to right, rgba(0, 0, 0, 0.07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* Marquee Animation */
        .marquee-ticker {
            display: flex;
            width: max-content;
            animation: neo-scroll-ticker 25s linear infinite;
        }

        @keyframes neo-scroll-ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Mobile Menu */
        #mobile-menu {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: top;
            max-height: 0;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            overflow: hidden;
        }

        #mobile-menu.open {
            max-height: 600px;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* CI4 Pager (Neo-Brutal) */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        .pagination li a, .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-size: 0.8125rem;
            font-weight: 800;
            border-radius: 0.625rem;
            text-decoration: none;
            color: #000000;
            background-color: #ffffff;
            border: 2px solid #000000;
            box-shadow: 2px 2px 0px 0px #000000;
            transition: all 0.15s ease-in-out;
        }
        .pagination li a:hover {
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px 0px #000000;
            background-color: var(--neo-yellow);
        }
        .pagination li a:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #000000;
        }
        .pagination li.active span {
            color: #000000 !important;
            background-color: var(--neo-yellow) !important;
            border-color: #000000 !important;
            box-shadow: 4px 4px 0px 0px #000000;
        }
        .pagination li.disabled span {
            opacity: 0.5;
            box-shadow: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #FFE600;
            border-left: 2px solid #000;
        }

        ::-webkit-scrollbar-thumb {
            background: #000000;
            border: 2px solid #FFE600;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FF6B8B;
        }

        @media (hover: none) and (pointer: coarse) {
            .neo-card-hover:hover {
                transform: none !important;
                box-shadow: 5px 5px 0px 0px #000000 !important;
            }
            .neo-btn:hover {
                transform: none !important;
                box-shadow: 4px 4px 0px 0px #000000 !important;
            }
            .neo-btn:active {
                transform: translate(2px, 2px) !important;
                box-shadow: 0px 0px 0px 0px #000000 !important;
            }
            .pagination li a:hover {
                transform: none !important;
                box-shadow: 2px 2px 0px 0px #000000 !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            .marquee-ticker {
                animation: none !important;
            }
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .marquee-ticker, #navbar, #mobile-menu, .neo-btn, #backToTopBtn, footer {
                display: none !important;
            }
            .neo-box, .neo-box-lg, .neo-box-sm {
                border: 1px solid black !important;
                box-shadow: none !important;
            }
        }

        @media (max-width: 639.98px) {
            .pagination li a, .pagination li span {
                min-width: 2.25rem;
                height: 2.25rem;
                border-width: 2px;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
            .neo-btn {
                border-width: 2px !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
            }
            .neo-btn:active {
                transform: translate(1.5px, 1.5px) !important;
                box-shadow: 0px 0px 0px 0px #000 !important;
            }
            #backToTopBtn {
                width: 2.5rem !important;
                height: 2.5rem !important;
                bottom: 1rem !important;
                right: 1rem !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
        }
    </style>
</head>

<body class="bg-[#FFFDF5] text-black antialiased selection:bg-[#FFE600] selection:text-black flex flex-col min-h-screen">

    <!-- TOP TICKER BAR -->
    <div class="bg-[#FFE600] border-b-2 border-black py-1.5 overflow-hidden font-extrabold text-xs tracking-wider uppercase select-none">
        <div class="marquee-ticker whitespace-nowrap">
            <span class="inline-flex items-center gap-4 mx-4">
                <span>🎓 DAFTAR CALON PESERTA DIDIK PUBLIK</span>
                <span>★</span>
                <span>TRANSPARANSI DATA PPDB</span>
                <span>★</span>
                <span>PRIVASI TERSENSOR OTOMATIS</span>
                <span>★</span>
                <span><?= esc($content['navbar']['nama_sekolah'] ?? 'PPDB ONLINE') ?></span>
                <span>★</span>
            </span>
            <span class="inline-flex items-center gap-4 mx-4" aria-hidden="true">
                <span>🎓 DAFTAR CALON PESERTA DIDIK PUBLIK</span>
                <span>★</span>
                <span>TRANSPARANSI DATA PPDB</span>
                <span>★</span>
                <span>PRIVASI TERSENSOR OTOMATIS</span>
                <span>★</span>
                <span><?= esc($content['navbar']['nama_sekolah'] ?? 'PPDB ONLINE') ?></span>
                <span>★</span>
            </span>
        </div>
    </div>

    <!-- NAVBAR -->
    <header id="navbar" class="sticky top-0 z-50 bg-white border-b-[3px] border-black transition-all duration-200">
        <div class="container mx-auto px-3 md:px-6 py-1.5 md:py-3 flex items-center justify-between">

            <!-- Logo & Brand -->
            <a href="<?= base_url('/') ?>" class="flex items-center gap-2 md:gap-3 group min-w-0 shrink-0 whitespace-nowrap">
                <?php if (!empty($web['logo_sekolah'])): ?>
                    <div class="navbar-logo w-9 h-9 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] p-1 flex items-center justify-center group-hover:rotate-6 transition-transform shrink-0">
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-full h-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="navbar-logo w-9 h-9 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black font-black text-lg md:text-xl group-hover:rotate-6 transition-transform shrink-0">
                        <?= mb_substr(esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'P'), 0, 1) ?>
                    </div>
                <?php endif; ?>
                <div class="hidden md:flex flex-col min-w-0 navbar-brand-text">
                    <span class="school-name font-heading font-black text-sm md:text-xl tracking-tight text-black line-clamp-1 group-hover:text-[#FF6B8B] transition-colors">
                        <?= esc($content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?>
                    </span>
                    <span class="school-sub text-[9px] md:text-[10px] font-extrabold uppercase tracking-widest text-gray-600">Data Pendaftar Publik</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-1 font-bold text-sm">
                <a href="<?= base_url('/') ?>#beranda" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FFE600] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Beranda</a>
                <a href="<?= base_url('/') ?>#jadwal" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#00D2FF] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Jadwal</a>
                <a href="<?= base_url('/') ?>#syarat" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FF6B8B] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Syarat</a>
                <a href="<?= base_url('/') ?>#kontak" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FF9F1C] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="px-4 py-2 rounded-lg border-2 border-black bg-[#FFE600] shadow-[2px_2px_0px_0px_#000] transition-all flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Data Pendaftar</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-1.5 md:gap-3 shrink-0">
                <a href="<?= base_url('login') ?>" class="inline-flex neo-btn bg-white hover:bg-gray-100 text-black py-1.5 md:py-2 px-3 md:px-5 rounded-xl text-xs md:text-sm shadow-[2px_2px_0px_0px_#000]">
                    <i class="fas fa-sign-in-alt mr-1 md:mr-2"></i> Login
                </a>
                <a href="<?= base_url('auth/register') ?>" class="navbar-cta-register neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-1.5 md:py-2 px-3 md:px-6 rounded-xl text-xs md:text-sm shadow-[2px_2px_0px_0px_#000]">
                    <i class="fas fa-rocket mr-1 md:mr-2"></i> Daftar
                </a>

                <button class="lg:hidden p-2 md:p-2.5 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FFE600] transition-all" id="menu-btn" aria-label="Toggle Menu">
                    <i class="fas fa-bars text-base md:text-lg w-5 text-center"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="lg:hidden border-t-[3px] border-black bg-[#FFFDF5] px-4 py-5 shadow-2xl">
            <div class="space-y-2 font-bold text-sm">
                <a href="<?= base_url('/') ?>#beranda" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FFE600] transition">🏠 Beranda</a>
                <a href="<?= base_url('/') ?>#jadwal" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#00D2FF] transition">📅 Jadwal PPDB</a>
                <a href="<?= base_url('/') ?>#syarat" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FF6B8B] transition">📋 Persyaratan</a>
                <a href="<?= base_url('/') ?>#kontak" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FF9F1C] transition">📞 Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-[#FFE600] shadow-[2px_2px_0px_0px_#000] transition font-black">📊 Cek Data Pendaftar</a>
                <?php endif; ?>

                <div class="pt-3 border-t-2 border-black grid grid-cols-2 gap-3">
                    <a href="<?= base_url('login') ?>" class="neo-btn bg-white text-black py-2.5 rounded-xl text-center">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="neo-btn bg-[#FFE600] text-black py-2.5 rounded-xl text-center">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="relative py-8 md:py-14 border-b-[3px] border-black bg-neo-grid overflow-hidden">
        <div class="hidden lg:block absolute top-10 left-10 -rotate-6 z-0">
            <span class="inline-block px-4 py-2 bg-[#FF6B8B] text-white font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                👁️ Transparansi PPDB
            </span>
        </div>
        <div class="hidden lg:block absolute top-16 right-12 rotate-6 z-0">
            <span class="inline-block px-4 py-2 bg-[#00D2FF] text-black font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                🔒 Privasi Terlindungi
            </span>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center flex flex-col items-center">
                <div class="inline-flex items-center gap-2 px-3 md:px-5 py-1.5 md:py-2 rounded-full bg-[#FFE600] border-2 border-black shadow-[4px_4px_0px_0px_#000] mb-4 md:mb-6 font-black text-[10px] md:text-sm tracking-wider uppercase transform hover:scale-105 transition-transform">
                    <i class="fas fa-sparkles text-black"></i>
                    <span>Data Publik &amp; Transparansi PPDB</span>
                </div>

                <h1 class="font-heading font-black text-2xl sm:text-4xl md:text-6xl leading-[1.15] tracking-tight text-black mb-4 md:mb-6">
                    Daftar Calon Peserta Didik
                </h1>

                <div class="bg-white p-4 md:p-6 rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] mb-8 max-w-2xl text-center">
                    <p class="text-sm md:text-base font-bold text-gray-800 leading-relaxed">
                        Menampilkan data peserta yang telah terdaftar pada sistem PPDB. Demi kepatuhan privasi data, sebagian nomor NISN dan Nama Lengkap <span class="text-[#FF6B8B] underline decoration-[3px]">disamarkan</span> secara otomatis.
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 w-full max-w-3xl">
                    <div class="bg-[#BAE6FD] p-4 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center gap-3 neo-card-hover">
                        <div class="w-11 h-11 bg-white rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center shrink-0">
                            <i class="fas fa-users text-lg"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-[10px] font-black uppercase text-gray-800">Total Ditampilkan</div>
                            <div class="font-heading font-black text-lg text-black"><?= !empty($pendaftar) ? count($pendaftar) : 0 ?> Data</div>
                        </div>
                    </div>
                    <div class="bg-[#BBF7D0] p-4 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center gap-3 neo-card-hover">
                        <div class="w-11 h-11 bg-white rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center shrink-0">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-[10px] font-black uppercase text-gray-800">Status Sistem</div>
                            <div class="font-heading font-black text-lg text-black"><?= esc($web['status_ppdb'] ?? 'Buka') ?></div>
                        </div>
                    </div>
                    <div class="bg-[#FBCFE8] p-4 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center gap-3 neo-card-hover">
                        <div class="w-11 h-11 bg-white rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center shrink-0">
                            <i class="fas fa-lock text-lg"></i>
                        </div>
                        <div class="text-left">
                            <div class="text-[10px] font-black uppercase text-gray-800">Perlindungan Privasi</div>
                            <div class="font-heading font-black text-lg text-black">Tersensor Otomatis</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH + TABLE -->
    <main class="flex-grow py-8 md:py-14 px-4 md:px-6">
        <div class="container mx-auto max-w-6xl">

            <!-- Search Card -->
            <div class="bg-white rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] p-4 md:p-6 mb-8 neo-box">
                <form action="<?= base_url('pendaftar') ?>" method="get" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-black">
                            <i class="fas fa-search"></i>
                        </div>
                        <input
                            type="text"
                            name="q"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari berdasarkan NISN atau Nama Lengkap calon siswa..."
                            class="w-full pl-10 pr-4 py-3 bg-[#FFFDF5] border-2 border-black rounded-xl text-sm font-bold text-black placeholder:text-gray-500 focus:bg-white focus:shadow-[4px_4px_0px_0px_#000] focus:-translate-x-0.5 focus:-translate-y-0.5 focus:outline-none transition-all"
                        >
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button type="submit" class="flex-1 sm:flex-none neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-3 px-6 rounded-xl text-sm">
                            <i class="fas fa-search mr-2"></i>
                            <span>Cari Data</span>
                        </button>
                        <?php if(!empty($search)): ?>
                            <a href="<?= base_url('pendaftar') ?>" title="Reset Filter Pencarian" class="inline-flex items-center justify-center h-11 w-11 rounded-xl bg-[#FF6B8B] hover:bg-[#FF6B8B] text-white border-2 border-black shadow-[2px_2px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[0px_0px_0px_0px_#000] transition-all">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] overflow-hidden">

                <?php if (!empty($search)): ?>
                    <div class="bg-[#FEF08A] border-b-2 border-black px-5 py-3.5 flex items-center justify-between text-xs sm:text-sm">
                        <div class="flex items-center gap-2 font-bold text-black">
                            <i class="fas fa-info-circle"></i>
                            <span>Hasil pencarian untuk kata kunci: <strong class="underline decoration-[3px]"><?= esc($search) ?></strong></span>
                        </div>
                        <a href="<?= base_url('pendaftar') ?>" class="font-black text-black underline decoration-[2px] hover:bg-[#00D2FF] px-2 py-0.5 rounded transition-all">
                            Hapus Filter
                        </a>
                    </div>
                <?php endif; ?>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#FFE600] border-b-2 border-black text-black text-xs font-black uppercase tracking-wider">
                                <th class="py-4 px-5 text-center w-16">No</th>
                                <th class="py-4 px-5">NISN</th>
                                <th class="py-4 px-5">Nama Lengkap</th>
                                <th class="py-4 px-5 text-center w-40">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-black">
                            <?php if (empty($pendaftar)): ?>
                                <tr>
                                    <td colspan="4" class="py-16 px-6 text-center bg-[#FFFDF5]">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                            <div class="w-16 h-16 bg-[#E5E7EB] rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center mb-3">
                                                <i class="fas fa-folder-open text-2xl"></i>
                                            </div>
                                            <h3 class="font-heading font-black text-base text-black mb-1">
                                                Tidak Ada Data Ditemukan
                                            </h3>
                                            <p class="text-xs font-bold text-gray-600 leading-relaxed mb-5">
                                                <?= !empty($search) ? 'Pencarian tidak menemukan pendaftar yang sesuai dengan kata kunci.' : 'Saat ini belum ada data pendaftar yang masuk ke sistem.' ?>
                                            </p>
                                            <?php if(!empty($search)): ?>
                                                <a href="<?= base_url('pendaftar') ?>" class="neo-btn bg-[#00D2FF] text-black py-2.5 px-5 rounded-xl text-xs">
                                                    <i class="fas fa-redo-alt mr-2"></i>
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
                                    $badgeBg = ($no - 1) % 5;
                                    $badgeColors = ['bg-[#FFE600]', 'bg-[#BAE6FD]', 'bg-[#BBF7D0]', 'bg-[#FBCFE8]', 'bg-[#DDD6FE]'];
                                ?>
                                    <tr class="hover:bg-[#FFF3C4] transition-colors">
                                        <td class="py-3.5 px-5 text-xs font-black text-gray-500 text-center">
                                            <?= $no++ ?>
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <div class="inline-flex items-center gap-2">
                                                <span class="h-7 w-7 rounded-lg bg-[#FDE68A] border-2 border-black flex items-center justify-center text-xs">
                                                    <i class="fas fa-id-card text-[10px]"></i>
                                                </span>
                                                <span class="font-mono text-xs sm:text-sm font-extrabold text-black tracking-wider">
                                                    <?= esc($p['nisn']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-full <?= $badgeColors[$badgeBg] ?> border-2 border-black flex items-center justify-center font-black text-xs shrink-0">
                                                    <?= esc($namaAwal) ?>
                                                </div>
                                                <span class="font-extrabold text-xs sm:text-sm text-black">
                                                    <?= esc($p['nama_lengkap']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-[#BBF7D0] border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                                                <i class="fas fa-check-circle text-sm"></i>
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
                <div class="p-5 border-t-2 border-black bg-white flex justify-center">
                    <?= $pager->links('pendaftar', 'default_full') ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- CTA Banner -->
            <div class="mt-8 rounded-2xl bg-[#FFE600] border-[3px] border-black shadow-[6px_6px_0px_0px_#000] p-6 md:p-8 bg-neo-dots flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-heading font-black text-lg md:text-2xl text-black mb-1">
                        Belum mendaftar sebagai Calon Peserta Didik?
                    </h3>
                    <p class="text-xs sm:text-sm font-bold text-gray-900 leading-relaxed max-w-xl">
                        Daftarkan diri Anda sekarang juga sebelum batas waktu pendaftaran berakhir. Proses cepat, mudah, dan online!
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0 w-full sm:w-auto justify-end">
                    <a href="<?= base_url('auth/register') ?>" class="w-full sm:w-auto text-center neo-btn bg-black hover:bg-black text-[#FFE600] px-6 py-3 rounded-xl text-sm">
                        <i class="fas fa-file-signature mr-2"></i>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-black text-white pt-14 pb-8 mt-auto border-t-[4px] border-black">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-10 border-b-2 border-white/20 items-center">
                <div class="md:col-span-8 flex flex-col items-start">
                    <div class="flex items-center gap-3 mb-3">
                        <?php if (!empty($web['logo_sekolah'])): ?>
                            <div class="w-11 h-11 bg-[#FFE600] rounded-xl border-2 border-white p-1 flex items-center justify-center shadow-[3px_3px_0px_0px_#FFF]">
                                <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-full h-full object-contain">
                            </div>
                        <?php endif; ?>
                        <h3 class="font-heading font-black text-xl md:text-2xl text-white tracking-tight">
                            <?= esc($content['footer']['nama_sekolah'] ?? $content['navbar']['nama_sekolah'] ?? $web['nama_sekolah'] ?? 'PPDB Online') ?>
                        </h3>
                    </div>
                    <p class="text-gray-400 font-semibold text-sm max-w-lg leading-relaxed">
                        Data pendaftar publik dihadirkan untuk menjaga transparansi dan kepercayaan masyarakat terhadap proses PPDB.
                    </p>
                </div>
                <div class="md:col-span-4 flex flex-col md:items-end justify-between gap-6">
                    <div class="flex flex-wrap gap-2 md:justify-end">
                        <a href="<?= base_url('/') ?>" class="px-4 py-2 rounded-lg border-2 border-white bg-white text-black font-black text-xs hover:bg-[#FFE600] shadow-[2px_2px_0px_0px_#FFF] transition-all">Beranda</a>
                        <a href="<?= base_url('login') ?>" class="px-4 py-2 rounded-lg border-2 border-white bg-white text-black font-black text-xs hover:bg-[#FFE600] shadow-[2px_2px_0px_0px_#FFF] transition-all">Login Siswa</a>
                    </div>
                </div>
            </div>
            <div class="pt-6 flex flex-col sm:flex-row justify-between items-center text-xs font-bold text-gray-400 gap-3">
                <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? '') ?>. <?= esc($content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.') ?></p>
                <div class="flex items-center gap-2">
                    <a href="<?= base_url('pendaftar') ?>" class="text-[#FFE600] hover:underline font-black">Data Pendaftar</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP -->
    <button id="backToTopBtn" class="fixed bottom-6 right-6 z-40 bg-[#FFE600] text-black w-12 h-12 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-lg hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[0px_0px_0px_0px_#000] transition-all opacity-0 invisible" aria-label="Kembali ke atas">
        <i class="fas fa-arrow-up font-black"></i>
    </button>

    <!-- GLOBAL SCRIPTS -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = menuBtn.querySelector('i');

        menuBtn.addEventListener('click', () => {
            if (!mobileMenu.classList.contains('open')) {
                mobileMenu.classList.add('open');
                menuIcon.classList.replace('fa-bars', 'fa-times');
            } else {
                mobileMenu.classList.remove('open');
                menuIcon.classList.replace('fa-times', 'fa-bars');
            }
        });

        const backToTopBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible');
                backToTopBtn.classList.add('opacity-0', 'invisible');
            }
        });
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>

</html>