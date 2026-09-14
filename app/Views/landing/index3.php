<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($content['navbar']['nama_sekolah'] ?? 'PPDB Online - MIN 2 Tanggamus') ?></title>

    <?php
    // Set page_title for the SEO partial to use
    $page_title = $content['navbar']['nama_sekolah'] ?? 'PPDB Online';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'" />
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    </noscript>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.2.4/purify.min.js" defer></script>

    <style>
        :root {
            --clr-primary: #10b981;
            --clr-primary-dark: #047857;
            --clr-gold: #f59e0b;
            --clr-bg: #f0fdf8;
            --nav-height: 80px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--clr-bg);
            color: #1a2e2a;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Sora', sans-serif;
        }

        /* ========== NAVBAR ========== */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.12);
            transition: all 0.3s ease;
        }
        .navbar-glass.scrolled {
            background: rgba(255, 255, 255, 0.97);
            box-shadow: 0 4px 32px -8px rgba(6, 78, 59, 0.12);
        }

        .nav-link {
            position: relative;
            font-weight: 600;
            color: #374151;
            transition: color 0.25s;
            padding: 4px 0;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--clr-primary);
            border-radius: 99px;
            transition: width 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--clr-primary-dark);
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

        /* ========== HERO ========== */
        .hero-parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        @media (max-width: 768px) {
            .hero-parallax { background-attachment: scroll; }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            border-radius: 99px;
            color: #d1fae5;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 36px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #1c0a00;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 99px;
            box-shadow: 0 8px 32px -8px rgba(245, 158, 11, 0.55);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px -8px rgba(245, 158, 11, 0.65);
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .btn-outline-white {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 36px;
            background: rgba(255,255,255,0.08);
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 99px;
            border: 1.5px solid rgba(255,255,255,0.35);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-outline-white:hover {
            background: rgba(255,255,255,0.18);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            border-radius: 99px;
            box-shadow: 0 8px 28px -8px rgba(16, 185, 129, 0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-green:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px -8px rgba(16, 185, 129, 0.6);
        }

        /* ========== CARDS ========== */
        .feature-card {
            background: #fff;
            border: 1px solid rgba(16,185,129,0.1);
            border-radius: 24px;
            padding: 36px 32px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 20px -4px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #34d399);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px -12px rgba(16, 185, 129, 0.18);
            border-color: rgba(16,185,129,0.25);
        }
        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .schedule-card {
            background: #fff;
            border-radius: 24px;
            padding: 36px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 24px -8px rgba(0,0,0,0.06);
            transition: all 0.35s ease;
            position: relative;
            overflow: hidden;
        }
        .schedule-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px -12px rgba(0,0,0,0.12);
        }

        .syarat-card {
            background: #fff;
            border: 1px solid rgba(16,185,129,0.08);
            border-radius: 20px;
            padding: 24px 28px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            transition: all 0.3s ease;
            box-shadow: 0 2px 16px -4px rgba(0,0,0,0.04);
        }
        .syarat-card:hover {
            border-color: rgba(16,185,129,0.3);
            box-shadow: 0 8px 32px -8px rgba(16,185,129,0.14);
            transform: translateX(6px);
        }

        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.4rem;
        }

        /* ========== SECTION LABELS ========== */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            background: rgba(16,185,129,0.1);
            color: #059669;
            border-radius: 99px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border: 1px solid rgba(16,185,129,0.2);
        }

        /* ========== DIVIDER ========== */
        .section-divider {
            width: 48px;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399);
            border-radius: 99px;
            margin: 16px 0;
        }

        /* ========== MARQUEE ========== */
        .marquee-container {
            overflow: hidden;
            mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
        }
        .marquee-track {
            display: flex;
            width: max-content;
            animation: marquee 40s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        .testimoni-card {
            width: 360px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid rgba(16,185,129,0.1);
            border-radius: 24px;
            padding: 32px;
            margin: 0 12px;
            box-shadow: 0 4px 24px -8px rgba(0,0,0,0.06);
        }

        /* ========== GALLERY ========== */
        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            aspect-ratio: 1;
            position: relative;
            background: #1e293b;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .gallery-item:hover img {
            transform: scale(1.08);
        }
        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
            opacity: 0.6;
            transition: opacity 0.35s;
        }
        .gallery-item:hover .gallery-overlay { opacity: 0.9; }
        .gallery-info {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 20px;
            transform: translateY(8px);
            transition: transform 0.35s ease;
        }
        .gallery-item:hover .gallery-info { transform: translateY(0); }

        /* ========== LIGHTBOX ========== */
        #lightbox {
            transition: opacity 0.3s ease;
        }

        /* ========== CONTACT ========== */
        .contact-info-block {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        /* ========== FOOTER ========== */
        .social-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .social-btn:hover {
            transform: translateY(-3px);
            background: rgba(255,255,255,0.18);
        }

        /* ========== BACK TO TOP ========== */
        #backToTopBtn {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========== SCROLLBAR ========== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0fdf8; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 99px; }

        /* ========== SCROLL REVEAL ========== */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }

        /* ========== POPUP ========== */
        #announcement-popup {
            display: none;
        }

        /* Mobile menu transition */
        #mobile-menu {
            transition: max-height 0.35s ease, opacity 0.3s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #mobile-menu.open {
            max-height: 600px;
            opacity: 1;
        }

        /* Scroll indicator */
        @keyframes bounce-slow {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }
        .scroll-indicator {
            animation: bounce-slow 2s ease-in-out infinite;
        }

        /* Number badge */
        .step-number {
            font-family: 'Sora', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1;
            opacity: 0.1;
        }

        /* Focus visible */
        *:focus-visible {
            outline: 2px solid #10b981;
            outline-offset: 3px;
            border-radius: 4px;
        }
    </style>
</head>

<body class="antialiased selection:bg-emerald-200 selection:text-emerald-900">

    <!-- ============================
         NAVBAR
    ============================= -->
    <nav id="navbar" class="navbar-glass fixed w-full top-0 z-50" style="height: var(--nav-height);">
        <div class="container mx-auto px-4 md:px-8 h-full flex items-center justify-between">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 group flex-shrink-0">
                <?php if (!empty($web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo"
                         class="w-10 h-10 object-contain transition-transform duration-300 group-hover:scale-110">
                <?php else: ?>
                    <div class="w-10 h-10 rounded-2xl bg-primary-800 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        <?= mb_substr(esc($content['navbar']['nama_sekolah'] ?? 'M'), 0, 1) ?>
                    </div>
                <?php endif; ?>
                <span class="font-display font-bold text-lg text-gray-900 group-hover:text-primary-700 transition-colors leading-tight">
                    <?= esc($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?>
                </span>
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#beranda" class="nav-link">Beranda</a>
                <a href="#jadwal" class="nav-link">Jadwal</a>
                <a href="#syarat" class="nav-link">Persyaratan</a>
                <a href="#kontak" class="nav-link">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="nav-link">Data Pendaftar</a>
                <?php endif; ?>
            </div>

            <!-- Desktop Action Buttons -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="<?= base_url('login') ?>"
                   class="px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-full hover:border-primary-400 hover:text-primary-700 transition-all duration-300">
                    Masuk
                </a>
                <a href="<?= base_url('auth/register') ?>"
                   class="btn-green text-sm px-6 py-2.5">
                    <i class="fas fa-pen-to-square"></i>
                    Daftar PPDB
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <button id="menu-btn" class="lg:hidden p-2.5 text-gray-700 hover:bg-primary-50 rounded-xl transition-colors duration-200" aria-label="Menu">
                <i id="menu-icon" class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden bg-white border-t border-gray-100">
            <div class="container mx-auto px-4 py-4 flex flex-col gap-1">
                <a href="#beranda" class="mobile-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-primary-50 text-gray-700 font-semibold transition-colors">
                    <i class="fas fa-home text-primary-500 w-5"></i> Beranda
                </a>
                <a href="#jadwal" class="mobile-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-primary-50 text-gray-700 font-semibold transition-colors">
                    <i class="fas fa-calendar-days text-primary-500 w-5"></i> Jadwal
                </a>
                <a href="#syarat" class="mobile-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-primary-50 text-gray-700 font-semibold transition-colors">
                    <i class="fas fa-list-check text-primary-500 w-5"></i> Persyaratan
                </a>
                <a href="#kontak" class="mobile-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-primary-50 text-gray-700 font-semibold transition-colors">
                    <i class="fas fa-phone text-primary-500 w-5"></i> Kontak
                </a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="mobile-link flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-primary-50 text-gray-700 font-semibold transition-colors">
                        <i class="fas fa-users text-primary-500 w-5"></i> Data Pendaftar
                    </a>
                <?php endif; ?>
                <div class="grid grid-cols-2 gap-3 pt-4 mt-2 border-t border-gray-100">
                    <a href="<?= base_url('login') ?>" class="py-3 text-center border border-gray-200 rounded-2xl font-semibold text-gray-700 hover:border-primary-400 hover:text-primary-700 transition-all">Masuk</a>
                    <a href="<?= base_url('auth/register') ?>" class="py-3 text-center bg-primary-600 text-white rounded-2xl font-semibold hover:bg-primary-700 transition-all">Daftar PPDB</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================
         HERO SECTION
    ============================= -->
    <?php
    $heroBg = $content['hero']['background_image'] ?? '';
    $heroStyle = '';
    if (!empty($heroBg)) {
        $heroStyle = "background-image: url('" . base_url($heroBg) . "');";
    }
    ?>
    <header id="beranda" class="relative min-h-screen flex items-center hero-parallax overflow-hidden"
            style="<?= $heroStyle ?> background-color: #022c22; padding-top: var(--nav-height);">

        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-950/90 via-primary-900/85 to-slate-950/90"></div>

        <!-- Decorative orbs -->
        <div class="orb w-[500px] h-[500px] bg-primary-500/20 top-[-100px] right-[-80px]"></div>
        <div class="orb w-[400px] h-[400px] bg-amber-400/15 bottom-[-80px] left-[-60px]"></div>
        <div class="orb w-[280px] h-[280px] bg-teal-400/15 top-[40%] right-[15%]"></div>

        <!-- Subtle grid pattern -->
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: linear-gradient(rgba(255,255,255,0.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 48px 48px;"></div>

        <div class="container mx-auto px-6 md:px-10 relative z-10 py-20">
            <div class="max-w-4xl mx-auto text-center">

                <!-- Badge -->
                <div class="hero-badge mb-8 reveal">
                    <i class="fas fa-graduation-cap text-primary-300"></i>
                    <span>Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?></span>
                </div>

                <!-- Headline -->
                <h1 class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-[1.08] tracking-tight mb-6 reveal reveal-delay-1">
                    <?= $content['hero']['headline'] ?? 'Penerimaan Peserta Didik Baru' ?>
                </h1>

                <!-- Subheadline -->
                <p class="text-lg md:text-xl text-primary-100/90 max-w-2xl mx-auto mb-10 leading-relaxed reveal reveal-delay-2">
                    <?= $content['hero']['subheadline'] ?? 'Mari bergabung bersama kami membentuk generasi mandiri, berprestasi, dan berakhlak mulia.' ?>
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center reveal reveal-delay-3">
                    <a href="<?= esc($content['hero']['cta_link'] ?? base_url('auth/register'), 'attr') ?>"
                       class="btn-primary text-lg px-10 py-5 w-full sm:w-auto">
                        <?= esc($content['hero']['cta_text'] ?? 'Daftar Sekarang') ?>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#syarat"
                       class="btn-outline-white text-base w-full sm:w-auto">
                        <i class="fas fa-clipboard-list"></i>
                        Lihat Persyaratan
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <a href="#fitur"
           class="scroll-indicator absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/50 hover:text-white/80 transition-colors">
            <span class="text-xs font-semibold tracking-widest uppercase">Scroll</span>
            <i class="fas fa-chevron-down text-lg"></i>
        </a>
    </header>

    <!-- ============================
         FITUR / KEUNGGULAN
    ============================= -->
    <?php if (!empty($fitur)): ?>
    <section id="fitur" class="py-24 bg-white relative -mt-10" style="border-radius: 3rem 3rem 0 0; z-index: 20;">
        <div class="container mx-auto px-6 md:px-10">
            <div class="text-center mb-16 reveal">
                <span class="section-label"><i class="fas fa-star"></i> Keunggulan Kami</span>
                <div class="section-divider mx-auto mt-4"></div>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Mengapa Memilih Kami?</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto leading-relaxed">
                    Keunggulan dan fasilitas terbaik untuk menunjang pendidikan karakter dan prestasi siswa.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($fitur as $idx => $f): ?>
                <div class="feature-card reveal" style="transition-delay: <?= ($idx % 3) * 0.1 ?>s;">
                    <div class="icon-box bg-primary-50 text-primary-600 mb-6">
                        <i class="<?= esc($f['ikon'] ?? 'fas fa-star') ?>"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-3"><?= esc($f['judul']) ?></h3>
                    <p class="text-gray-500 leading-relaxed text-sm"><?= esc($f['deskripsi']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================
         JADWAL PELAKSANAAN
    ============================= -->
    <section id="jadwal" class="py-24 bg-[#f0fdf8]">
        <div class="container mx-auto px-6 md:px-10">
            <div class="text-center mb-16 reveal">
                <span class="section-label"><i class="fas fa-calendar-check"></i> Timeline PPDB</span>
                <div class="section-divider mx-auto mt-4"></div>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">
                    <?= $content['jadwal']['title'] ?? 'Jadwal Pelaksanaan' ?>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">

                <!-- Tahap 1 -->
                <div class="schedule-card reveal">
                    <div class="flex items-start justify-between mb-6">
                        <span class="step-number text-primary-500">01</span>
                        <div class="icon-box bg-primary-100 text-primary-600">
                            <i class="fas fa-laptop"></i>
                        </div>
                    </div>
                    <div class="h-1 w-10 rounded-full bg-primary-400 mb-5"></div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-2">
                        <?= esc($content['jadwal']['tahap1_judul'] ?? 'Pendaftaran Online') ?>
                    </h3>
                    <p class="text-primary-700 font-semibold text-sm mb-2">
                        <i class="fas fa-calendar-days mr-1"></i>
                        <?= esc($content['jadwal']['tahap1_tanggal'] ?? '01 Mei – 15 Mei') ?>
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        <?= esc($content['jadwal']['tahap1_keterangan'] ?? 'Melalui website resmi PPDB') ?>
                    </p>
                </div>

                <!-- Tahap 2 -->
                <div class="schedule-card reveal reveal-delay-1">
                    <div class="flex items-start justify-between mb-6">
                        <span class="step-number text-amber-400">02</span>
                        <div class="icon-box bg-amber-50 text-amber-600">
                            <i class="fas fa-file-signature"></i>
                        </div>
                    </div>
                    <div class="h-1 w-10 rounded-full bg-amber-400 mb-5"></div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-2">
                        <?= esc($content['jadwal']['tahap2_judul'] ?? 'Verifikasi Berkas') ?>
                    </h3>
                    <p class="text-amber-700 font-semibold text-sm mb-2">
                        <i class="fas fa-calendar-days mr-1"></i>
                        <?= esc($content['jadwal']['tahap2_tanggal'] ?? '17 Mei – 20 Mei') ?>
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        <?= esc($content['jadwal']['tahap2_keterangan'] ?? 'Datang langsung ke Madrasah membawa berkas asli') ?>
                    </p>
                </div>

                <!-- Tahap 3 -->
                <div class="schedule-card reveal reveal-delay-2">
                    <div class="flex items-start justify-between mb-6">
                        <span class="step-number text-blue-400">03</span>
                        <div class="icon-box bg-blue-50 text-blue-600">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                    </div>
                    <div class="h-1 w-10 rounded-full bg-blue-400 mb-5"></div>
                    <h3 class="font-display text-xl font-bold text-gray-900 mb-2">
                        <?= esc($content['jadwal']['tahap3_judul'] ?? 'Pengumuman Hasil') ?>
                    </h3>
                    <p class="text-blue-700 font-semibold text-sm mb-2">
                        <i class="fas fa-calendar-days mr-1"></i>
                        <?= esc($content['jadwal']['tahap3_tanggal'] ?? '25 Mei 2024') ?>
                    </p>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        <?= esc($content['jadwal']['tahap3_keterangan'] ?? 'Dilihat melalui website atau papan pengumuman') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         PERSYARATAN
    ============================= -->
    <section id="syarat" class="py-24 bg-white">
        <div class="container mx-auto px-6 md:px-10">
            <div class="flex flex-col lg:flex-row gap-16">

                <!-- Left Sticky -->
                <div class="lg:w-5/12 lg:sticky lg:top-28 self-start">
                    <span class="section-label reveal"><i class="fas fa-clipboard-list"></i> Persyaratan</span>
                    <div class="section-divider mt-4 reveal"></div>
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 leading-tight reveal">
                        <?= $content['syarat']['title'] ?? 'Persyaratan Pendaftaran' ?>
                    </h2>
                    <p class="text-gray-500 mt-5 text-base leading-relaxed reveal">
                        Harap persiapkan dokumen-dokumen berikut untuk memperlancar proses pendaftaran.
                    </p>

                    <!-- Warning box -->
                    <div class="mt-8 p-6 bg-amber-50 border border-amber-200 rounded-3xl reveal">
                        <div class="flex gap-4">
                            <div class="icon-box bg-amber-100 text-amber-600 w-10 h-10 rounded-xl text-base flex-shrink-0">
                                <i class="fas fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-amber-800 text-sm">Perhatian Penting!</h4>
                                <p class="text-amber-700 text-sm mt-1 leading-relaxed">
                                    Semua berkas fisik wajib dibawa di dalam stopmap saat proses Verifikasi Berkas (Tahap 2).
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>"
                       class="mt-6 inline-flex items-center gap-2 bg-gray-900 hover:bg-primary-700 text-white px-7 py-3.5 rounded-full font-semibold text-sm transition-all duration-300 reveal">
                        <i class="fas fa-users"></i>
                        Cek Data Pendaftar Publik
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Right Grid -->
                <div class="lg:w-7/12 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php
                    $defaultSyarat = [
                        'Berusia minimal 6 tahun pada bulan Juli ' . date('Y') . '.',
                        'Fotocopy Akta Kelahiran (2 lembar).',
                        'Fotocopy Kartu Keluarga (KK) (2 lembar).',
                        'Fotocopy Ijazah TK/RA (jika ada).',
                        'Pas Foto ukuran 3x4 latar belakang merah (4 lembar).',
                        'Membawa map folder plastik kancing.'
                    ];
                    $icons = ['fa-child', 'fa-file-signature', 'fa-users', 'fa-graduation-cap', 'fa-camera-retro', 'fa-folder-open'];
                    $iconColors = [
                        ['bg-primary-100', 'text-primary-600'],
                        ['bg-blue-100', 'text-blue-600'],
                        ['bg-violet-100', 'text-violet-600'],
                        ['bg-amber-100', 'text-amber-600'],
                        ['bg-rose-100', 'text-rose-600'],
                        ['bg-teal-100', 'text-teal-600'],
                    ];
                    $idx = 0;
                    for ($i = 1; $i <= 6; $i++):
                        $syaratText = $content['syarat']["item{$i}"] ?? ($defaultSyarat[$i-1] ?? '');
                        if (empty($syaratText)) continue;
                        $iconClass = $icons[$idx % 6];
                        $colors = $iconColors[$idx % 6];
                    ?>
                    <div class="syarat-card reveal" style="transition-delay: <?= ($idx % 2) * 0.1 ?>s;">
                        <div class="icon-box <?= $colors[0] ?> <?= $colors[1] ?> w-11 h-11 rounded-2xl text-base">
                            <i class="fas <?= $iconClass ?>"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Syarat <?= $idx + 1 ?></span>
                            <p class="text-gray-700 font-medium text-sm mt-1 leading-relaxed"><?= esc($syaratText) ?></p>
                        </div>
                    </div>
                    <?php $idx++; endfor; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         GALERI
    ============================= -->
    <?php if (!empty($galeri)): ?>
    <section id="galeri" class="py-24 bg-primary-950 relative overflow-hidden">
        <!-- Decorative -->
        <div class="orb w-[400px] h-[400px] bg-primary-500/15 top-0 right-[-100px]"></div>
        <div class="orb w-[300px] h-[300px] bg-amber-500/10 bottom-0 left-0"></div>

        <div class="container mx-auto px-6 md:px-10 relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-14 reveal">
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 text-primary-300 rounded-full text-xs font-bold uppercase tracking-widest border border-white/10">
                        <i class="fas fa-images"></i> Galeri
                    </span>
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-white mt-4">Kegiatan Madrasah</h2>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($galeri as $g): ?>
                <div class="gallery-item reveal"
                     onclick="openLightbox('<?= base_url($g['gambar']) ?>', '<?= esc(addslashes($g['judul'])) ?>', '<?= esc(addslashes($g['deskripsi'] ?? '')) ?>')">
                    <img src="<?= base_url($g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" loading="lazy">
                    <div class="gallery-overlay"></div>
                    <div class="gallery-info">
                        <h3 class="text-white font-semibold text-sm leading-tight"><?= esc($g['judul']) ?></h3>
                        <?php if (!empty($g['deskripsi'])): ?>
                        <p class="text-white/70 text-xs mt-1 line-clamp-1"><?= esc($g['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================
         LIGHTBOX
    ============================= -->
    <div id="lightbox" class="hidden fixed inset-0 z-[9999] bg-black/96 backdrop-blur-2xl items-center justify-center p-4"
         onclick="if(event.target.id==='lightbox') closeLightbox()">
        <button onclick="closeLightbox()"
                class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-red-500/80 text-white rounded-2xl flex items-center justify-center text-xl transition-all duration-200"
                aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        <div class="max-w-5xl w-full" onclick="event.stopImmediatePropagation()">
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-3xl shadow-2xl">
            <div class="mt-5 bg-white/8 backdrop-blur-xl rounded-3xl px-8 py-5 text-center border border-white/10">
                <p id="lightbox-caption" class="text-white text-xl font-bold font-display"></p>
                <p id="lightbox-desc" class="text-white/60 text-sm mt-1.5"></p>
            </div>
        </div>
    </div>

    <!-- ============================
         TESTIMONI
    ============================= -->
    <?php if (!empty($testimoni)): ?>
    <section id="testimoni" class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6 md:px-10">
            <div class="text-center mb-14 reveal">
                <span class="section-label"><i class="fas fa-comment-dots"></i> Testimoni</span>
                <div class="section-divider mx-auto mt-4"></div>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Apa Kata Mereka?</h2>
            </div>
        </div>

        <div class="marquee-container">
            <div class="marquee-track">
                <?php
                $scrollTestimoni = array_merge($testimoni, $testimoni);
                foreach ($scrollTestimoni as $t):
                ?>
                <div class="testimoni-card">
                    <!-- Stars -->
                    <div class="flex gap-1 mb-5">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= $t['rating'] ? 'fas' : 'far' ?> fa-star text-amber-400 text-sm"></i>
                        <?php endfor; ?>
                    </div>
                    <!-- Quote mark -->
                    <div class="text-5xl text-primary-100 font-display leading-none mb-2">"</div>
                    <p class="text-gray-600 text-sm leading-relaxed flex-1 -mt-4"><?= esc($t['isi']) ?></p>
                    <!-- Author -->
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                        <img src="<?= !empty($t['avatar']) ? base_url($t['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=10b981&color=fff&bold=true' ?>"
                             alt="<?= esc($t['nama']) ?>"
                             class="w-11 h-11 rounded-2xl object-cover ring-2 ring-primary-100">
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm"><?= esc($t['nama']) ?></h4>
                            <p class="text-primary-600 text-xs font-medium mt-0.5"><?= esc($t['peran']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ============================
         KONTAK
    ============================= -->
    <section id="kontak" class="py-24 bg-[#f0fdf8]">
        <div class="container mx-auto px-6 md:px-10">

            <div class="text-center mb-14 reveal">
                <span class="section-label"><i class="fas fa-headset"></i> Hubungi Kami</span>
                <div class="section-divider mx-auto mt-4"></div>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Butuh Informasi?</h2>
            </div>

            <div class="max-w-6xl mx-auto">
                <!-- Contact Card -->
                <div class="bg-white rounded-4xl shadow-xl overflow-hidden flex flex-col lg:flex-row reveal">
                    <!-- Left: Info Panel -->
                    <div class="lg:w-5/12 bg-primary-900 p-10 md:p-14 text-white relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="orb w-72 h-72 bg-primary-500/25 -top-20 -right-20"></div>
                        <div class="orb w-48 h-48 bg-amber-400/15 bottom-10 -left-10"></div>

                        <div class="relative z-10">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 text-primary-200 rounded-full text-xs font-bold uppercase tracking-widest">
                                Informasi Kontak
                            </span>
                            <h3 class="font-display text-3xl font-bold mt-5 mb-10">Kami Siap Membantu</h3>

                            <div class="space-y-8">
                                <!-- Alamat -->
                                <div class="contact-info-block">
                                    <div class="icon-box bg-white/10 text-primary-200 w-12 h-12 rounded-2xl text-lg flex-shrink-0">
                                        <i class="fas fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <p class="text-primary-300 text-xs font-bold uppercase tracking-widest mb-1">Alamat Madrasah</p>
                                        <p class="text-white font-medium leading-snug">
                                            <?= esc($content['kontak']['alamat'] ?? 'Jl. Raya No. 123, Kab. Tanggamus, Lampung') ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="contact-info-block">
                                    <div class="icon-box bg-white/10 text-primary-200 w-12 h-12 rounded-2xl text-lg flex-shrink-0">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <p class="text-primary-300 text-xs font-bold uppercase tracking-widest mb-1">WhatsApp Panitia</p>
                                        <p class="text-white font-semibold text-xl">
                                            <?= esc($content['kontak']['whatsapp_nama'] ?? '+62 812-3456-7890') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: CTA Panel -->
                    <div class="lg:w-7/12 p-10 md:p-14 flex items-center">
                        <div class="text-center w-full max-w-sm mx-auto">
                            <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-8">
                                <i class="fab fa-whatsapp text-5xl text-primary-600"></i>
                            </div>
                            <h3 class="font-display text-2xl md:text-3xl font-bold text-gray-900">Chat Langsung Sekarang</h3>
                            <p class="text-gray-500 mt-3 text-sm leading-relaxed">
                                Hubungi panitia PPDB via WhatsApp untuk informasi lebih lanjut. Kami siap melayani Anda.
                            </p>

                            <?php $waNumber = $content['kontak']['whatsapp_number'] ?? '6281234567890'; ?>
                            <a href="https://wa.me/<?= esc($waNumber) ?>" target="_blank" rel="noopener noreferrer"
                               class="btn-green w-full mt-8 py-5 text-lg">
                                <i class="fab fa-whatsapp text-2xl"></i>
                                Chat via WhatsApp
                            </a>

                            <p class="text-gray-400 text-xs mt-4">
                                <i class="fas fa-clock mr-1"></i> Hari Kerja, Pukul 07.00 – 16.00 WIB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <?php if (!empty($content['kontak']['google_maps'])): ?>
                <div class="mt-8 rounded-4xl overflow-hidden shadow-xl border border-primary-100 reveal"
                     style="height: 400px;">
                    <?php
                    $mapsInput = trim($content['kontak']['google_maps'] ?? '');
                    $mapSrc = '';

                    if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/is', $mapsInput, $match)) {
                        $mapSrc = $match[1];
                    } elseif (filter_var($mapsInput, FILTER_VALIDATE_URL) || preg_match('/^https?:\/\//i', $mapsInput)) {
                        $mapSrc = $mapsInput;
                    }

                    if (!empty($mapSrc)) {
                        echo '<iframe src="' . esc($mapSrc, 'attr') . '" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                    } else {
                        echo $mapsInput;
                    }
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ============================
         FAQ SECTION
    ============================= -->
    <?php if (!empty($faqs)): ?>
    <section id="faq" class="py-24 bg-white relative">
        <div class="container mx-auto px-6 md:px-10">
            <div class="text-center mb-16 reveal">
                <span class="section-label"><i class="fas fa-question-circle"></i> Bantuan Cepat</span>
                <div class="section-divider mx-auto mt-4"></div>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-900 mt-2">Pusat FAQ</h2>
            </div>

            <div class="max-w-4xl mx-auto space-y-4">
                <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item bg-primary-50/50 rounded-3xl overflow-hidden reveal transition-all duration-300 hover:shadow-lg border border-primary-100/50">
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none focus:bg-white transition-colors group">
                        <span class="font-display font-bold text-lg text-gray-900 group-hover:text-primary-600 transition-colors"><?= esc((string)$faq['pertanyaan']) ?></span>
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-primary-500 shadow-sm transition-all duration-300 group-hover:bg-primary-600 group-hover:text-white shrink-0">
                            <i class="fas fa-chevron-down text-lg transition-transform duration-300 faq-icon"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden px-8 pb-8 text-gray-600 leading-relaxed text-base bg-white border-t border-primary-100/50 pt-5">
                        <?= nl2br(esc((string)$faq['jawaban'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const btn = item.querySelector('.faq-btn');
                const content = item.querySelector('.faq-content');
                const icon = item.querySelector('.faq-icon');
                
                btn.addEventListener('click', () => {
                    const isHidden = content.classList.contains('hidden');
                    
                    if (isHidden) {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                        btn.classList.add('bg-white');
                    } else {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                        btn.classList.remove('bg-white');
                    }
                });
            });
        });
    </script>
    <?php endif; ?>

    <!-- ============================
         FOOTER
    ============================= -->
    <footer class="bg-primary-950 text-white pt-16 pb-8 relative overflow-hidden">
        <!-- Decorative bg -->
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: linear-gradient(rgba(255,255,255,0.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 60px 60px;"></div>

        <div class="container mx-auto px-6 md:px-10 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 pb-10 border-b border-white/10">

                <!-- Brand -->
                <div class="flex items-center gap-4">
                    <?php if (!empty($web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-12 w-auto">
                    <?php else: ?>
                        <div class="w-12 h-12 bg-primary-700 rounded-2xl flex items-center justify-center font-bold text-xl">
                            <?= mb_substr(esc($content['footer']['nama_sekolah'] ?? $content['navbar']['nama_sekolah'] ?? 'M'), 0, 1) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="font-display font-bold text-xl leading-tight">
                            <?= esc($content['footer']['nama_sekolah'] ?? $content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?>
                        </h3>
                        <p class="text-primary-300 text-sm mt-0.5">Madrasah Ibtidaiyah Negeri</p>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="flex gap-3">
                    <a href="https://wa.me/<?= esc($content['kontak']['whatsapp_number'] ?? '') ?>" target="_blank"
                       class="social-btn hover:!bg-green-500" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <?php if (!empty($content['footer']['facebook_link'])): ?>
                    <a href="<?= esc($content['footer']['facebook_link'], 'attr') ?>" target="_blank"
                       class="social-btn hover:!bg-blue-600" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['instagram_link'])): ?>
                    <a href="<?= esc($content['footer']['instagram_link'], 'attr') ?>" target="_blank"
                       class="social-btn hover:!bg-pink-600" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['tiktok_link'])): ?>
                    <a href="<?= esc($content['footer']['tiktok_link'], 'attr') ?>" target="_blank"
                       class="social-btn hover:!bg-black" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['youtube_link'])): ?>
                    <a href="<?= esc($content['footer']['youtube_link'], 'attr') ?>" target="_blank"
                       class="social-btn hover:!bg-red-600" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-8 text-center text-primary-500 text-sm">
                &copy; <?= date('Y') ?>
                <?= esc($content['footer']['nama_sekolah'] ?? $content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?>
                &nbsp;&bull;&nbsp; Official PPDB Website
            </div>
        </div>
    </footer>

    <!-- ============================
         BACK TO TOP
    ============================= -->
    <button id="backToTopBtn"
            class="fixed bottom-6 right-6 btn-green w-13 h-13 p-3.5 rounded-2xl opacity-0 invisible z-50 shadow-glow-green"
            aria-label="Kembali ke atas">
        <i class="fas fa-arrow-up text-base"></i>
    </button>

    <!-- ============================
         ANNOUNCEMENT POPUP
    ============================= -->
    <div id="announcement-popup"
         class="fixed inset-0 z-[99999] bg-black/75 backdrop-blur-2xl items-center justify-center p-4">
        <div class="bg-white rounded-4xl shadow-2xl max-w-md w-full overflow-hidden">
            <div class="p-8" id="popup-content"></div>
            <div class="px-8 pb-8 flex justify-end">
                <button id="close-popup-btn"
                        class="btn-green gap-3 px-8 py-4">
                    Tutup
                    <span id="popup-countdown-text" class="font-mono text-sm"></span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ============================
         JAVASCRIPT
    ============================= -->
    <script>
    (function () {
        // ---- Navbar scroll ----
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        }, { passive: true });

        // ---- Mobile menu ----
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        let menuOpen = false;

        menuBtn.addEventListener('click', () => {
            menuOpen = !menuOpen;
            mobileMenu.classList.toggle('open', menuOpen);
            menuIcon.className = menuOpen ? 'fas fa-times text-xl' : 'fas fa-bars text-xl';
        });

        // ---- Close mobile menu on mobile link click ----
        document.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                menuOpen = false;
                mobileMenu.classList.remove('open');
                menuIcon.className = 'fas fa-bars text-xl';
            });
        });

        // ---- Smooth scroll ----
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 88;
                    const topPos = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: topPos, behavior: 'smooth' });
                }
            });
        });

        // ---- Active nav link ----
        const sections = document.querySelectorAll('section[id], header[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(sec => {
                if (window.scrollY >= sec.offsetTop - 120) {
                    current = sec.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                const isActive = link.getAttribute('href') === `#${current}`;
                link.classList.toggle('active', isActive);
            });
        }, { passive: true });

        // ---- Scroll reveal ----
        const revealEls = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(el => revealObserver.observe(el));

        // ---- Back to top ----
        const backToTop = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            const show = window.scrollY > 400;
            backToTop.classList.toggle('opacity-0', !show);
            backToTop.classList.toggle('invisible', !show);
            backToTop.classList.toggle('opacity-100', show);
            backToTop.classList.toggle('visible', show);
        }, { passive: true });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ---- Lightbox ----
        window.openLightbox = function(imgUrl, title, desc = '') {
            const lb = document.getElementById('lightbox');
            document.getElementById('lightbox-img').src = imgUrl;
            document.getElementById('lightbox-caption').textContent = title;
            document.getElementById('lightbox-desc').textContent = desc;
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
        };
        window.closeLightbox = function() {
            const lb = document.getElementById('lightbox');
            lb.classList.add('hidden');
            lb.classList.remove('flex');
            document.body.style.overflow = '';
        };
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
        });

        // ---- Announcement Popup ----
        <?php if (!empty($popups)): ?>
        const popups = <?= json_encode($popups) ?>;
        let currentPopupIndex = 0;

        function showPopup(index) {
            if (index >= popups.length) return;
            const popup = popups[index];
            const modal = document.getElementById('announcement-popup');
            const content = document.getElementById('popup-content');
            const closeBtn = document.getElementById('close-popup-btn');
            const countdownSpan = document.getElementById('popup-countdown-text');

            let html = '';
            if (popup.lampiran && /\.(jpg|jpeg|png|gif)$/i.test(popup.lampiran)) {
                html += `<img src="<?= base_url('uploads/pengumuman/') ?>${popup.lampiran}" class="w-full rounded-2xl mb-5 shadow-lg">`;
            }
            html += `<h3 class="font-display text-xl font-bold text-gray-900 mb-3">${popup.judul}</h3>`;
            html += `<div class="text-gray-600 text-sm leading-relaxed">${DOMPurify.sanitize(popup.isi_pengumuman)}</div>`;
            content.innerHTML = html;
            modal.style.display = 'flex';

            let countdown = parseInt(popup.popup_countdown) || 0;
            if (countdown > 0) {
                closeBtn.disabled = true;
                closeBtn.style.opacity = '0.6';
                countdownSpan.textContent = `(${countdown})`;
                const timer = setInterval(() => {
                    countdown--;
                    countdownSpan.textContent = countdown > 0 ? `(${countdown})` : '';
                    if (countdown <= 0) {
                        clearInterval(timer);
                        closeBtn.disabled = false;
                        closeBtn.style.opacity = '1';
                    }
                }, 1000);
            }

            closeBtn.onclick = () => {
                modal.style.display = 'none';
                if (currentPopupIndex + 1 < popups.length) {
                    currentPopupIndex++;
                    setTimeout(() => showPopup(currentPopupIndex), 400);
                }
            };
        }

        window.addEventListener('load', () => {
            setTimeout(() => showPopup(0), 1200);
        });
        <?php endif; ?>

    })();
    </script>

</body>
</html>