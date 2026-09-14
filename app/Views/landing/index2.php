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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" />
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </noscript>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.2.4/purify.min.js" defer></script>

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

        /* Neo-Brutalist Shadow Utilities */
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

        /* Retro Dot Grid Background */
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
        .marquee-container {
            overflow: hidden;
            width: 100%;
            position: relative;
        }

        .marquee-content {
            display: flex;
            width: max-content;
            animation: neo-scroll-left 35s linear infinite;
        }

        .marquee-content:hover {
            animation-play-state: paused;
        }

        .marquee-ticker {
            display: flex;
            width: max-content;
            animation: neo-scroll-ticker 25s linear infinite;
        }

        @keyframes neo-scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
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

        /* ==========================================================================
           DEVICE-SPECIFIC MEDIA QUERIES (Neo-Brutalist Responsive System)
           ========================================================================== */

        /* 1. ALL MOBILE (<= 639.98px) — Unified mobile-first overrides */
        @media (max-width: 639.98px) {
            /* -- Navbar Mobile Compact -- */
            #navbar .container {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            .navbar-brand-text .school-name {
                font-size: 0.8rem !important;
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                display: block;
            }
            .navbar-brand-text .school-sub {
                font-size: 8px !important;
                letter-spacing: 0.05em !important;
            }
            .navbar-logo {
                width: 2.25rem !important;
                height: 2.25rem !important;
            }
            .navbar-cta-register {
                font-size: 0.7rem !important;
                padding: 0.4rem 0.75rem !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
            #menu-btn {
                width: 2.25rem !important;
                height: 2.25rem !important;
                padding: 0 !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
            #menu-btn i {
                font-size: 0.85rem !important;
            }

            /* -- Hero Mobile -- */
            #beranda {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
            #beranda .badge-pill {
                font-size: 0.6rem !important;
                padding: 0.35rem 0.75rem !important;
                margin-bottom: 1rem !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
            #beranda h1 {
                font-size: 1.6rem !important;
                line-height: 1.2 !important;
                margin-bottom: 1rem !important;
            }
            #beranda .hero-subheadline {
                padding: 1rem !important;
                border-width: 2px !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
                margin-bottom: 1.5rem !important;
            }
            #beranda .hero-subheadline p {
                font-size: 0.8rem !important;
                line-height: 1.5 !important;
            }
            .hero-cta-group {
                gap: 0.75rem !important;
            }
            .hero-cta-group .neo-btn {
                padding: 0.75rem 1rem !important;
                font-size: 0.85rem !important;
                border-width: 2px !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
                border-radius: 0.75rem !important;
            }
            .hero-stats-grid {
                gap: 0.5rem !important;
                margin-top: 1.5rem !important;
            }
            .hero-stats-grid > div {
                padding: 0.5rem !important;
                border-radius: 0.625rem !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
            .hero-stats-grid .font-heading {
                font-size: 1.25rem !important;
            }
            .hero-stats-grid .text-xs {
                font-size: 0.6rem !important;
            }

            /* -- Section Spacing Mobile -- */
            section {
                padding-top: 2.5rem !important;
                padding-bottom: 2.5rem !important;
            }
            section .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            /* -- Section Headers Mobile -- */
            .section-header {
                margin-bottom: 2rem !important;
            }
            .section-header h2 {
                font-size: 1.5rem !important;
                margin-bottom: 0.5rem !important;
            }
            .section-header p {
                font-size: 0.85rem !important;
            }

            /* -- Neo elements smaller -- */
            .neo-box, [class*='rounded-3xl'][class*='border-'] {
                border-width: 2px !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
                border-radius: 1rem !important;
            }
            .neo-box-lg {
                border-width: 2.5px !important;
                box-shadow: 4px 4px 0px 0px #000 !important;
            }
            .neo-btn {
                border-width: 2px !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
                min-height: 44px;
            }
            .neo-btn:hover {
                transform: none !important;
                box-shadow: 3px 3px 0px 0px #000 !important;
            }
            .neo-btn:active {
                transform: translate(1.5px, 1.5px) !important;
                box-shadow: 0px 0px 0px 0px #000 !important;
            }
            .neo-card-hover:hover {
                transform: none !important;
            }

            /* -- Feature Cards Mobile -- */
            #fitur .grid > div {
                padding: 1.25rem !important;
            }
            #fitur .grid > div .w-16 {
                width: 2.75rem !important;
                height: 2.75rem !important;
                margin-bottom: 0.75rem !important;
            }
            #fitur .grid > div h3 {
                font-size: 1.1rem !important;
            }

            /* -- Jadwal Cards Mobile -- */
            #jadwal .grid > div {
                padding: 1.25rem !important;
            }
            #jadwal .grid > div h3 {
                font-size: 1.1rem !important;
            }

            /* -- Syarat Section Mobile -- */
            #syarat h2 {
                font-size: 1.5rem !important;
            }
            #syarat .space-y-4 > div {
                padding: 1rem !important;
            }
            #syarat .space-y-4 > div .w-10 {
                width: 2rem !important;
                height: 2rem !important;
                font-size: 0.75rem !important;
            }
            #syarat .space-y-4 > div h4 {
                font-size: 0.9rem !important;
            }

            /* -- Galeri Mobile -- */
            #galeri .grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.75rem !important;
            }
            #galeri .grid > div {
                padding: 0.4rem !important;
                padding-bottom: 0.6rem !important;
            }
            #galeri .grid > div h4 {
                font-size: 0.75rem !important;
            }

            /* -- Kontak Mobile -- */
            #kontak .max-w-6xl {
                border-width: 2.5px !important;
                box-shadow: 4px 4px 0px 0px #000 !important;
                border-radius: 1.25rem !important;
            }
            #kontak .lg\:col-span-6:first-child {
                padding: 1.25rem !important;
            }
            #kontak h3 {
                font-size: 1.4rem !important;
            }

            /* -- FAQ Mobile -- */
            #faq .faq-btn {
                padding: 0.875rem 1rem !important;
                font-size: 0.85rem !important;
            }
            #faq .faq-btn .w-8 {
                width: 1.5rem !important;
                height: 1.5rem !important;
            }

            /* -- Testimonial Mobile -- */
            #testimoni .marquee-content > div {
                width: 280px !important;
                padding: 1.25rem !important;
            }

            /* -- Footer Mobile -- */
            footer {
                padding-top: 2rem !important;
                padding-bottom: 1.5rem !important;
            }
            footer h3 {
                font-size: 1.25rem !important;
            }

            /* -- Lightbox Mobile -- */
            #lightbox > div {
                padding: 0.75rem !important;
                border-width: 2.5px !important;
                box-shadow: 5px 5px 0px 0px #000 !important;
            }

            /* -- Typography Global -- */
            .font-heading {
                word-break: break-word;
            }
            .marquee-ticker {
                animation-duration: 18s !important;
            }

            /* -- Back to Top Mobile -- */
            #backToTopBtn {
                width: 2.5rem !important;
                height: 2.5rem !important;
                bottom: 1rem !important;
                right: 1rem !important;
                border-width: 2px !important;
                box-shadow: 2px 2px 0px 0px #000 !important;
            }
        }

        /* 1b. EXTRA SMALL PHONES (< 380px, e.g. Galaxy Fold, iPhone 5/SE/Mini) */
        @media (max-width: 379.98px) {
            .navbar-brand-text .school-name {
                max-width: 90px !important;
                font-size: 0.7rem !important;
            }
            .navbar-cta-register {
                font-size: 0.65rem !important;
                padding: 0.35rem 0.6rem !important;
            }
            #beranda h1 {
                font-size: 1.35rem !important;
            }
            h2 {
                font-size: 1.25rem !important;
            }
            #galeri .grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* 2. STANDARD MOBILE (Phones 380px - 639.98px) — additional tweaks */
        @media (min-width: 380px) and (max-width: 639.98px) {
            .navbar-brand-text .school-name {
                max-width: 140px !important;
                font-size: 0.85rem !important;
            }
            #beranda h1 {
                font-size: 1.75rem !important;
            }
            .marquee-ticker {
                animation-duration: 22s !important;
            }
        }

        /* 3. TABLETS (640px - 1023.98px) */
        @media (min-width: 640px) and (max-width: 1023.98px) {
            .neo-box {
                border-width: 3px;
                box-shadow: 5px 5px 0px 0px #000000;
            }
            .neo-box-lg {
                border-width: 3.5px;
                box-shadow: 6px 6px 0px 0px #000000;
            }
            .neo-btn {
                border-width: 3px;
                box-shadow: 4px 4px 0px 0px #000000;
            }
            .marquee-content {
                animation-duration: 30s !important;
            }
        }

        /* 4. LAPTOPS & STANDARD DESKTOP (1024px - 1279.98px) */
        @media (min-width: 1024px) and (max-width: 1279.98px) {
            .neo-box {
                border-width: 3px;
                box-shadow: 5px 5px 0px 0px #000000;
            }
            .neo-box-lg {
                border-width: 4px;
                box-shadow: 7px 7px 0px 0px #000000;
            }
            .neo-card-hover:hover {
                transform: translate(-3px, -3px);
                box-shadow: 7px 7px 0px 0px #000000;
            }
        }

        /* 5. LARGE SCREENS & 4K (>= 1280px) */
        @media (min-width: 1280px) {
            .neo-box {
                border-width: 3.5px;
                box-shadow: 6px 6px 0px 0px #000000;
            }
            .neo-box-lg {
                border-width: 4px;
                box-shadow: 8px 8px 0px 0px #000000;
            }
            .neo-card-hover:hover {
                transform: translate(-4px, -4px);
                box-shadow: 10px 10px 0px 0px #000000;
            }
            .container {
                max-width: 1280px !important;
            }
        }

        @media (min-width: 1536px) {
            .container {
                max-width: 1400px !important;
            }
        }

        /* 6. TOUCH DEVICES (Hover optimization) */
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
        }

        /* 7. PREFERS REDUCED MOTION (Accessibility) */
        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            .marquee-content, .marquee-ticker {
                animation: none !important;
            }
        }

        /* 8. PRINT STYLESHEET */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .marquee-ticker, #navbar, #mobile-menu, .neo-btn, #floating-cta, #back-to-top, footer {
                display: none !important;
            }
            .neo-box, .neo-box-lg, .neo-box-sm {
                border: 1px solid black !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="bg-[#FFFDF5] text-black antialiased selection:bg-[#FFE600] selection:text-black">

    <!-- TOP TICKER BAR -->
    <div class="bg-[#FFE600] border-b-2 border-black py-1.5 overflow-hidden font-extrabold text-xs tracking-wider uppercase select-none">
        <div class="marquee-ticker whitespace-nowrap">
            <span class="inline-flex items-center gap-4 mx-4">
                <span>⚡ PORTAL PENERIMAAN PESERTA DIDIK BARU (PPDB) ONLINE</span>
                <span>★</span>
                <span>TAHUN PELAJARAN <?= date('Y') ?>/<?= date('Y') + 1 ?></span>
                <span>★</span>
                <span>PENDAFTARAN RESMI DIBUKA</span>
                <span>★</span>
                <span><?= esc($content['navbar']['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>TERAKREDITASI & BERKUALITAS</span>
                <span>★</span>
            </span>
            <span class="inline-flex items-center gap-4 mx-4" aria-hidden="true">
                <span>⚡ PORTAL PENERIMAAN PESERTA DIDIK BARU (PPDB) ONLINE</span>
                <span>★</span>
                <span>TAHUN PELAJARAN <?= date('Y') ?>/<?= date('Y') + 1 ?></span>
                <span>★</span>
                <span>PENDAFTARAN RESMI DIBUKA</span>
                <span>★</span>
                <span><?= esc($content['navbar']['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>TERAKREDITASI & BERKUALITAS</span>
                <span>★</span>
            </span>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav id="navbar" class="sticky top-0 z-50 bg-white border-b-[3px] border-black transition-all duration-200">
        <div class="container mx-auto px-3 md:px-6 py-1.5 md:py-3 flex items-center justify-between">

            <!-- Logo & Brand -->
            <a href="#" class="flex items-center gap-2 md:gap-3 group min-w-0 shrink-0 whitespace-nowrap">
                <?php if (!empty($web['logo_sekolah'])): ?>
                    <div class="navbar-logo w-9 h-9 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] p-1 flex items-center justify-center group-hover:rotate-6 transition-transform shrink-0">
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-full h-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="navbar-logo w-9 h-9 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black font-black text-lg md:text-xl group-hover:rotate-6 transition-transform shrink-0">
                        <?= mb_substr(esc($content['navbar']['nama_sekolah'] ?? 'M'), 0, 1) ?>
                    </div>
                <?php endif; ?>
                <div class="hidden md:flex flex-col min-w-0 navbar-brand-text">
                    <span class="school-name font-heading font-black text-sm md:text-xl tracking-tight text-black line-clamp-1 group-hover:text-[#FF6B8B] transition-colors">
                        <?= esc($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?>
                    </span>
                    <span class="school-sub text-[9px] md:text-[10px] font-extrabold uppercase tracking-widest text-gray-600">PPDB Official Portal</span>
                </div>
            </a>

            <!-- Desktop Menu (Pills with Neo Hover) -->
            <div class="hidden lg:flex items-center space-x-1 font-bold text-sm">
                <a href="#beranda" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FFE600] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Beranda</a>
                <a href="#fitur" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#00D2FF] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Keunggulan</a>
                <a href="#jadwal" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#A3E635] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Jadwal</a>
                <a href="#syarat" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FF6B8B] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Syarat</a>
                <?php if (!empty($galeri)): ?>
                    <a href="#galeri" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#C084FC] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Galeri</a>
                <?php endif; ?>
                <a href="#kontak" class="px-4 py-2 rounded-lg border-2 border-transparent hover:border-black hover:bg-[#FF9F1C] hover:shadow-[2px_2px_0px_0px_#000] transition-all">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="px-4 py-2 rounded-lg border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FFE600] transition-all flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
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

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden p-2 md:p-2.5 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FFE600] transition-all" id="menu-btn" aria-label="Toggle Menu">
                    <i class="fas fa-bars text-base md:text-lg w-5 text-center"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="lg:hidden border-t-[3px] border-black bg-[#FFFDF5] px-4 py-5 shadow-2xl">
            <div class="space-y-2 font-bold text-sm">
                <a href="#beranda" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FFE600] transition">🏠 Beranda</a>
                <a href="#fitur" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#00D2FF] transition">⭐ Keunggulan</a>
                <a href="#jadwal" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#A3E635] transition">📅 Jadwal PPDB</a>
                <a href="#syarat" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FF6B8B] transition">📋 Persyaratan</a>
                <?php if (!empty($galeri)): ?>
                    <a href="#galeri" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#C084FC] transition">📸 Galeri Foto</a>
                <?php endif; ?>
                <a href="#kontak" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-white shadow-[2px_2px_0px_0px_#000] hover:bg-[#FF9F1C] transition">📞 Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="block py-2.5 px-4 rounded-xl border-2 border-black bg-[#FFE600] shadow-[2px_2px_0px_0px_#000] transition font-black">📊 Cek Data Pendaftar</a>
                <?php endif; ?>

                <div class="pt-3 border-t-2 border-black grid grid-cols-2 gap-3">
                    <a href="<?= base_url('login') ?>" class="neo-btn bg-white text-black py-2.5 rounded-xl text-center">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="neo-btn bg-[#FFE600] text-black py-2.5 rounded-xl text-center">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <?php $heroBg = $content['hero']['background_image'] ?? ''; ?>
    <header id="beranda" class="relative py-10 md:py-24 border-b-[3px] border-black overflow-hidden <?= empty($heroBg) ? 'bg-neo-grid' : '' ?>" <?= !empty($heroBg) ? 'style="background-image: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.9)), url(\'' . base_url($heroBg) . '\'); background-attachment: fixed; background-size: cover; background-position: center;"' : '' ?>>
        <!-- Floating Neo Stickers -->
        <div class="hidden lg:block absolute top-12 left-10 -rotate-6 z-0">
            <span class="inline-block px-4 py-2 bg-[#FF6B8B] text-white font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                ✨ 100% Online & Praktis
            </span>
        </div>
        <div class="hidden lg:block absolute top-20 right-12 rotate-6 z-0">
            <span class="inline-block px-4 py-2 bg-[#00D2FF] text-black font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                🎓 Kuota Terbatas!
            </span>
        </div>
        <div class="hidden lg:block absolute bottom-12 left-16 rotate-3 z-0">
            <span class="inline-block px-4 py-2 bg-[#A3E635] text-black font-black text-xs uppercase tracking-wider rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000]">
                🚀 Akreditasi Unggul
            </span>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center flex flex-col items-center">

                <!-- Badge Pill -->
                <div class="badge-pill inline-flex items-center gap-1.5 md:gap-2 px-3 md:px-5 py-1.5 md:py-2 rounded-full bg-[#FFE600] border-2 border-black shadow-[4px_4px_0px_0px_#000] mb-4 md:mb-8 font-black text-[10px] md:text-sm tracking-wider uppercase transform hover:scale-105 transition-transform">
                    <i class="fas fa-sparkles text-black"></i>
                    <span>Tahun Ajaran <?= date('Y') ?>/<?= date('Y') + 1 ?> &bull; PPDB RESMI</span>
                </div>

                <!-- Main Headline -->
                <h1 class="font-heading font-black text-2xl sm:text-4xl md:text-5xl lg:text-7xl leading-[1.15] tracking-tight text-black mb-4 md:mb-8">
                    <?= $content['hero']['headline'] ?? 'Penerimaan Peserta Didik Baru (PPDB)' ?>
                </h1>

                <!-- Subheadline on Neo Card (hidden if empty) -->
                <?php
                $subheadline = $content['hero']['subheadline'] ?? 'Mari bergabung bersama kami membentuk generasi mandiri, berprestasi, dan berakhlak mulia.';
                if (!empty(trim($subheadline))):
                ?>
                <div class="hero-subheadline bg-white p-4 md:p-8 rounded-2xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] mb-6 md:mb-10 max-w-2xl text-center">
                    <p class="text-sm md:text-xl font-bold text-gray-800 leading-relaxed">
                        <?= $subheadline ?>
                    </p>
                </div>
                <?php endif; ?>

                <!-- CTA Buttons -->
                <div class="hero-cta-group flex flex-col sm:flex-row gap-3 md:gap-4 w-full sm:w-auto justify-center items-center">
                    <a href="<?= esc($content['hero']['cta_link'] ?? base_url('auth/register'), 'attr') ?>"
                       class="neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-3 md:py-4 px-6 md:px-10 rounded-xl md:rounded-2xl text-base md:text-xl w-full sm:w-auto group">
                        <span><?= esc($content['hero']['cta_text'] ?? 'Daftar Sekarang') ?></span>
                        <i class="fas fa-arrow-right ml-2 md:ml-3 group-hover:translate-x-1.5 transition-transform"></i>
                    </a>
                    <a href="#syarat"
                       class="neo-btn bg-white hover:bg-gray-50 text-black py-3 md:py-4 px-6 md:px-8 rounded-xl md:rounded-2xl text-base md:text-xl w-full sm:w-auto">
                        <i class="fas fa-clipboard-check mr-2 text-[#FF6B8B]"></i>
                        <span>Cek Persyaratan</span>
                    </a>
                </div>

                <!-- Quick Stats Badges -->
                <div class="hero-stats-grid grid grid-cols-2 md:grid-cols-4 gap-2.5 md:gap-4 mt-8 md:mt-14 w-full max-w-3xl">
                    <div class="bg-[#BAE6FD] p-3 md:p-4 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] text-center">
                        <div class="font-heading font-black text-xl md:text-3xl text-black">A</div>
                        <div class="text-[10px] md:text-xs font-bold text-black uppercase mt-0.5 md:mt-1">Akreditasi</div>
                    </div>
                    <div class="bg-[#BBF7D0] p-3 md:p-4 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] text-center">
                        <div class="font-heading font-black text-xl md:text-3xl text-black">100%</div>
                        <div class="text-[10px] md:text-xs font-bold text-black uppercase mt-0.5 md:mt-1">Digital & Cepat</div>
                    </div>
                    <div class="bg-[#FED7AA] p-3 md:p-4 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] text-center">
                        <div class="font-heading font-black text-xl md:text-3xl text-black">Gratis</div>
                        <div class="text-[10px] md:text-xs font-bold text-black uppercase mt-0.5 md:mt-1">Biaya Formulir</div>
                    </div>
                    <div class="bg-[#FBCFE8] p-3 md:p-4 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] text-center">
                        <div class="font-heading font-black text-xl md:text-3xl text-black">24/7</div>
                        <div class="text-[10px] md:text-xs font-bold text-black uppercase mt-0.5 md:mt-1">Layanan Bantuan</div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- FITUR / KEUNGGULAN SECTION -->
    <?php if (!empty($fitur)): ?>
        <section id="fitur" class="py-12 md:py-20 bg-[#FFFDF5] border-b-[3px] border-black relative">
            <div class="container mx-auto px-4 md:px-6">

                <!-- Section Header -->
                <div class="section-header text-center mb-10 md:mb-16 max-w-2xl mx-auto">
                    <span class="inline-block px-3 md:px-4 py-1 md:py-1.5 bg-[#A3E635] text-black font-black text-[10px] md:text-xs uppercase tracking-widest rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] mb-3 md:mb-4">
                        ✨ KEUNGGULAN KAMI
                    </span>
                    <h2 class="font-heading font-black text-2xl md:text-5xl text-black mb-2 md:mb-4">Mengapa Memilih Kami?</h2>
                    <p class="text-sm md:text-lg font-bold text-gray-700">Fasilitas terbaik dan program unggulan untuk menunjang prestasi serta pembentukan karakter generasi berakhlak mulia.</p>
                </div>

                <!-- Cards Grid -->
                <?php
                $pastelColors = ['bg-[#FEF08A]', 'bg-[#BAE6FD]', 'bg-[#BBF7D0]', 'bg-[#FBCFE8]', 'bg-[#DDD6FE]', 'bg-[#FED7AA]'];
                ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                    <?php foreach ($fitur as $idx => $f):
                        $cardBg = $pastelColors[$idx % count($pastelColors)];
                    ?>
                        <div class="<?= $cardBg ?> p-8 rounded-3xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] neo-card-hover transition-all flex flex-col justify-between relative group">
                            <div>
                                <!-- Icon Box -->
                                <div class="w-16 h-16 bg-white rounded-2xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-black text-2xl mb-6 group-hover:rotate-6 transition-transform">
                                    <i class="<?= esc($f['ikon'] ?? 'fas fa-star') ?>"></i>
                                </div>
                                <h3 class="font-heading font-black text-2xl text-black mb-3 leading-snug"><?= esc($f['judul']) ?></h3>
                                <p class="font-medium text-gray-800 leading-relaxed text-sm md:text-base"><?= esc($f['deskripsi']) ?></p>
                            </div>
                            <div class="mt-6 pt-4 border-t-2 border-black/20 flex items-center justify-between text-xs font-black uppercase text-black">
                                <span>Keunggulan #<?= $idx + 1 ?></span>
                                <i class="fas fa-check-circle text-black text-base"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
    <?php endif; ?>

    <!-- JADWAL PELAKSANAAN SECTION -->
    <section id="jadwal" class="py-12 md:py-20 bg-[#FFE600] border-b-[3px] border-black relative bg-neo-dots">
        <div class="container mx-auto px-4 md:px-6">

            <!-- Header -->
            <div class="section-header text-center mb-10 md:mb-16 max-w-2xl mx-auto">
                <span class="inline-block px-3 md:px-4 py-1 md:py-1.5 bg-white text-black font-black text-[10px] md:text-xs uppercase tracking-widest rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] mb-3 md:mb-4">
                    📅 TIMELINE RESMI
                </span>
                <h2 class="font-heading font-black text-2xl md:text-5xl text-black mb-2 md:mb-4">
                    <?= $content['jadwal']['title'] ?? 'Jadwal Pelaksanaan' ?>
                </h2>
                <p class="text-sm md:text-lg font-bold text-black">Catat tanggal-tanggal krusial berikut agar Ananda tidak tertinggal setiap tahapan seleksi.</p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8 max-w-6xl mx-auto">

                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-3xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] neo-card-hover flex flex-col justify-between relative">
                    <div class="absolute -top-4 -right-3 bg-[#00D2FF] text-black font-black text-xs px-3 py-1 rounded-lg border-2 border-black shadow-[2px_2px_0px_0px_#000] rotate-3">
                        TAHAP 01
                    </div>
                    <div>
                        <div class="w-14 h-14 bg-[#BAE6FD] rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black text-2xl mb-6">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="font-heading font-black text-2xl text-black mb-3"><?= esc($content['jadwal']['tahap1_judul'] ?? 'Pendaftaran Online') ?></h3>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed mb-6"><?= esc($content['jadwal']['tahap1_keterangan'] ?? 'Pengisian formulir biodata mandiri melalui website resmi.') ?></p>
                    </div>
                    <div class="bg-[#BAE6FD] p-4 rounded-2xl border-2 border-black font-bold text-xs text-black flex items-center gap-2">
                        <i class="far fa-calendar-alt text-base"></i>
                        <span><?= esc($content['jadwal']['tahap1_tanggal'] ?? '01 Mei - 15 Mei 2024') ?></span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-3xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] neo-card-hover flex flex-col justify-between relative md:-translate-y-2">
                    <div class="absolute -top-4 -right-3 bg-[#FF6B8B] text-white font-black text-xs px-3 py-1 rounded-lg border-2 border-black shadow-[2px_2px_0px_0px_#000] -rotate-3">
                        TAHAP 02
                    </div>
                    <div>
                        <div class="w-14 h-14 bg-[#FBCFE8] rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black text-2xl mb-6">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h3 class="font-heading font-black text-2xl text-black mb-3"><?= esc($content['jadwal']['tahap2_judul'] ?? 'Verifikasi Berkas') ?></h3>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed mb-6"><?= esc($content['jadwal']['tahap2_keterangan'] ?? 'Penyerahan berkas fisik asli & fotokopi langsung ke madrasah.') ?></p>
                    </div>
                    <div class="bg-[#FBCFE8] p-4 rounded-2xl border-2 border-black font-bold text-xs text-black flex items-center gap-2">
                        <i class="far fa-calendar-alt text-base"></i>
                        <span><?= esc($content['jadwal']['tahap2_tanggal'] ?? '17 Mei - 20 Mei 2024') ?></span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-3xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] neo-card-hover flex flex-col justify-between relative">
                    <div class="absolute -top-4 -right-3 bg-[#A3E635] text-black font-black text-xs px-3 py-1 rounded-lg border-2 border-black shadow-[2px_2px_0px_0px_#000] rotate-3">
                        TAHAP 03
                    </div>
                    <div>
                        <div class="w-14 h-14 bg-[#BBF7D0] rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black text-2xl mb-6">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 class="font-heading font-black text-2xl text-black mb-3"><?= esc($content['jadwal']['tahap3_judul'] ?? 'Pengumuman Hasil') ?></h3>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed mb-6"><?= esc($content['jadwal']['tahap3_keterangan'] ?? 'Hasil kelulusan dapat dicek secara transparan via akun pendaftar.') ?></p>
                    </div>
                    <div class="bg-[#BBF7D0] p-4 rounded-2xl border-2 border-black font-bold text-xs text-black flex items-center gap-2">
                        <i class="far fa-calendar-alt text-base"></i>
                        <span><?= esc($content['jadwal']['tahap3_tanggal'] ?? '25 Mei 2024') ?></span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- PERSYARATAN SECTION -->
    <section id="syarat" class="py-12 md:py-20 bg-[#FFFDF5] border-b-[3px] border-black relative">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col lg:flex-row gap-8 md:gap-12 items-start">

                <!-- Left Column: Title & Info Box -->
                <div class="w-full lg:w-5/12 lg:sticky top-24 z-10 mb-8 lg:mb-0">
                    <span class="inline-block px-3 md:px-4 py-1 md:py-1.5 bg-[#FF6B8B] text-white font-black text-[10px] md:text-xs uppercase tracking-widest rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] mb-3 md:mb-4">
                        📋 DOKUMEN WAJIB
                    </span>
                    <h2 class="font-heading font-black text-2xl md:text-5xl text-black mb-4 md:mb-6 leading-tight">
                        <?= $content['syarat']['title'] ?? 'Persyaratan Pendaftaran' ?>
                    </h2>
                    <p class="text-sm md:text-lg font-bold text-gray-700 mb-6 md:mb-8">
                        Persiapkan berkas berikut dalam bentuk scan/foto jelas untuk upload sistem, serta dokumen fisik asli saat verifikasi.
                    </p>

                    <!-- Important Notice Box (Neo-Brutal) -->
                    <div class="bg-[#FEF08A] p-6 rounded-2xl border-[3px] border-black shadow-[5px_5px_0px_0px_#000] mb-6">
                        <div class="flex items-center gap-3 font-heading font-black text-lg text-black mb-2">
                            <span class="text-2xl">⚠️</span>
                            <span>Catatan Penting!</span>
                        </div>
                        <p class="text-sm font-bold text-gray-800 leading-relaxed">
                            Seluruh berkas fisik wajib dimasukkan ke dalam map snelhechter/folder plastik saat verifikasi langsung ke madrasah.
                        </p>
                    </div>

                    <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                        <a href="<?= base_url('pendaftar') ?>" class="neo-btn bg-[#00D2FF] text-black py-3.5 px-6 rounded-xl w-full text-center">
                            <i class="fas fa-search mr-2"></i>
                            <span>Cek Data Pendaftar Publik</span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Requirements Checklist -->
                <div class="w-full lg:w-7/12">
                    <div class="space-y-4">
                        <?php
                        $defaultSyarat = [
                            'Berusia minimal 6 tahun pada awal tahun pelajaran berjalan.',
                            'Fotokopi Akta Kelahiran calon peserta didik (2 lembar).',
                            'Fotokopi Kartu Keluarga (KK) yang masih berlaku (2 lembar).',
                            'Fotokopi KTP kedua orang tua/wali siswa.',
                            'Fotokopi Ijazah / Surat Keterangan Lulus TK/RA (jika ada).',
                            'Pas foto terbaru ukuran 3x4 berwarna (4 lembar).'
                        ];

                        $badgeColors = ['bg-[#FFE600]', 'bg-[#00D2FF]', 'bg-[#A3E635]', 'bg-[#FF6B8B]', 'bg-[#C084FC]', 'bg-[#FF9F1C]'];

                        for ($i = 1; $i <= 6; $i++):
                            $syaratText = $content['syarat']["item{$i}"] ?? ($defaultSyarat[$i - 1] ?? '');
                            if (empty($syaratText)) continue;
                            $bColor = $badgeColors[($i - 1) % count($badgeColors)];
                        ?>
                            <div class="bg-white p-5 md:p-6 rounded-2xl border-[3px] border-black shadow-[4px_4px_0px_0px_#000] neo-card-hover flex items-start gap-4">
                                <div class="<?= $bColor ?> w-12 h-12 flex items-center justify-center shrink-0 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000] font-black text-black text-base mt-0.5">
                                    0<?= $i ?>
                                </div>
                                <div>
                                    <h4 class="font-heading font-black text-lg text-black mb-1">Persyaratan Dokumen #<?= $i ?></h4>
                                    <p class="font-semibold text-gray-700 text-sm md:text-base leading-relaxed"><?= esc($syaratText) ?></p>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- GALERI FOTO SECTION -->
    <?php if (!empty($galeri)): ?>
        <section id="galeri" class="bg-[#000000] text-white border-b-[3px] border-black relative">
            <div class="max-w-7xl mx-auto px-4 py-16">

                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-14 gap-4">
                    <div>
                        <span class="inline-block px-4 py-1.5 bg-[#FFE600] text-black font-black text-xs uppercase tracking-widest rounded-lg border-2 border-white shadow-[3px_3px_0px_0px_#FFF] mb-3">
                            📸 DOKUMENTASI KEGIATAN
                        </span>
                        <h2 class="font-heading font-black text-3xl md:text-5xl text-white">Galeri Madrasah</h2>
                    </div>
                    <p class="text-gray-400 font-bold max-w-md">Kumpulan momen inspiratif, kegiatan belajar, serta prestasi para santri di lingkungan madrasah.</p>
                </div>

                <!-- Gallery Polaroid Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($galeri as $g): ?>
                        <div onclick="openLightbox('<?= base_url($g['gambar']) ?>', '<?= esc(addslashes($g['judul'])) ?>', '<?= esc(addslashes($g['deskripsi'] ?? '')) ?>')"
                             class="bg-white text-black p-3 pb-5 rounded-2xl border-[3px] border-white shadow-[5px_5px_0px_0px_#FFE600] hover:shadow-[7px_7px_0px_0px_#00D2FF] hover:-translate-y-2 transition-all cursor-pointer group">
                            <div class="aspect-[4/3] flex items-center justify-center rounded-xl overflow-hidden border-2 border-black mb-3 bg-[#FFFDF5] p-2">
                                <img src="<?= base_url($g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <h4 class="font-heading font-black text-base text-black line-clamp-1 group-hover:text-[#FF6B8B] transition-colors"><?= esc($g['judul']) ?></h4>
                            <?php if (!empty($g['deskripsi'])): ?>
                                <p class="text-xs font-semibold text-gray-600 line-clamp-1 mt-1"><?= esc($g['deskripsi']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
    <?php endif; ?>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox" class="fixed inset-0 z-[9999] hidden bg-black/80 backdrop-blur-sm items-center justify-center p-4" onclick="closeLightbox()">
        <div class="bg-white p-6 rounded-3xl border-[4px] border-black shadow-[10px_10px_0px_0px_#000] max-w-3xl w-full relative" onclick="event.stopPropagation()">
            <button onclick="closeLightbox()" class="absolute -top-4 -right-4 w-10 h-10 bg-[#FF6B8B] text-white rounded-full border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center font-black hover:scale-110 transition-transform">
                <i class="fas fa-times"></i>
            </button>
            <div class="rounded-2xl border-2 border-black mb-4 flex items-center justify-center bg-gray-100">
                <img id="lightbox-img" src="" alt="Gallery Image" class="mx-auto max-w-full max-h-[60vh] object-contain bg-gray-100">
            </div>
            <h3 id="lightbox-caption" class="font-heading font-black text-2xl text-black mb-1"></h3>
            <p id="lightbox-desc" class="text-sm font-semibold text-gray-700"></p>
        </div>
    </div>

    <!-- TESTIMONI SECTION -->
    <?php if (!empty($testimoni)): ?>
        <section id="testimoni" class="py-20 bg-[#BAE6FD] border-b-[3px] border-black relative overflow-hidden bg-neo-dots">
            <div class="container mx-auto px-4 md:px-6 mb-12 text-center">
                <span class="inline-block px-4 py-1.5 bg-white text-black font-black text-xs uppercase tracking-widest rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] mb-4">
                    💬 KATA WALI MURID
                </span>
                <h2 class="font-heading font-black text-3xl md:text-5xl text-black">Apa Kata Mereka?</h2>
            </div>

            <!-- Marquee Testimonial Row -->
            <div class="marquee-container">
                <div class="marquee-content py-4 gap-6 items-stretch">
                    <?php
                    $scrollTestimoni = array_merge($testimoni, $testimoni, $testimoni);
                    foreach ($scrollTestimoni as $t):
                    ?>
                        <div class="w-[340px] md:w-[400px] shrink-0 bg-white p-7 rounded-3xl border-[3px] border-black shadow-[6px_6px_0px_0px_#000] flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1 text-[#FF9F1C] text-sm mb-4">
                                    <?php for ($i = 0; $i < $t['rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="font-bold text-gray-900 text-sm md:text-base leading-relaxed mb-6">
                                    "<?= esc($t['isi']) ?>"
                                </p>
                            </div>
                            <div class="flex items-center gap-3 pt-4 border-t-2 border-black">
                                <img src="<?= !empty($t['avatar']) ? base_url($t['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=FFE600&color=000&bold=true' ?>" 
                                     alt="<?= esc($t['nama']) ?>" 
                                     class="w-12 h-12 rounded-xl border-2 border-black object-cover">
                                <div>
                                    <h4 class="font-heading font-black text-black text-base"><?= esc($t['nama']) ?></h4>
                                    <span class="text-xs font-extrabold uppercase px-2 py-0.5 rounded-md bg-[#FFE600] border border-black inline-block mt-0.5">
                                        <?= esc($t['peran']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- KONTAK & LOKASI SECTION -->
    <section id="kontak" class="py-20 bg-[#FFFDF5] border-b-[3px] border-black relative">
        <div class="container mx-auto px-4 md:px-6">

            <div class="max-w-6xl mx-auto bg-white rounded-3xl border-[4px] border-black shadow-[8px_8px_0px_0px_#000] overflow-hidden grid grid-cols-1 lg:grid-cols-12">

                <!-- Left: Info Column -->
                <div class="lg:col-span-6 p-8 md:p-12 bg-[#FFDE59] border-b-[3px] lg:border-b-0 lg:border-r-[3px] border-black flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-3 py-1 bg-black text-white font-black text-xs uppercase tracking-widest rounded-lg mb-4">
                            📍 KONTAK PANITIA
                        </span>
                        <h3 class="font-heading font-black text-3xl md:text-4xl text-black mb-4">Butuh Bantuan?</h3>
                        <p class="font-bold text-gray-800 text-sm md:text-base mb-8 leading-relaxed">
                            Hubungi panitia PPDB kami untuk pertanyaan seputar syarat, pembayaran, atau kendala pendaftaran online.
                        </p>

                        <div class="space-y-4">
                            <!-- Alamat -->
                            <div class="bg-white p-4 rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#00D2FF] border-2 border-black flex items-center justify-center shrink-0">
                                    <i class="fas fa-map-marked-alt text-black"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black uppercase text-gray-500">Alamat Madrasah</div>
                                    <div class="text-sm font-bold text-black"><?= esc($content['kontak']['alamat'] ?? 'Jl. Raya No. 123, Kab. Tanggamus, Lampung') ?></div>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="bg-white p-4 rounded-2xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#A3E635] border-2 border-black flex items-center justify-center shrink-0">
                                    <i class="fab fa-whatsapp text-black text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black uppercase text-gray-500">Kontak Person</div>
                                    <div class="text-sm font-bold text-black"><?= esc($content['kontak']['whatsapp_nama'] ?? '+62 812-3456-7890 (Panitia PPDB)') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $waNumber = $content['kontak']['whatsapp_number'] ?? '6281234567890'; ?>
                    <div class="mt-8">
                        <a href="https://wa.me/<?= esc($waNumber) ?>" target="_blank"
                           class="neo-btn bg-[#22C55E] hover:bg-[#16A34A] text-white py-3.5 px-6 rounded-2xl w-full text-center text-base">
                            <i class="fab fa-whatsapp text-xl mr-2"></i>
                            <span>Chat Langsung via WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Google Maps -->
                <div class="lg:col-span-6 p-6 md:p-8 bg-white flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-heading font-black text-xl text-black">Peta Lokasi</span>
                        <span class="text-xs font-black uppercase px-2.5 py-1 bg-[#A3E635] border border-black rounded-lg">📍 Google Maps</span>
                    </div>

                    <div class="w-full h-[320px] md:h-[380px] rounded-2xl border-[3px] border-black shadow-[4px_4px_0px_0px_#000] overflow-hidden bg-gray-100">
                        <?php if (!empty($content['kontak']['google_maps'])): ?>
                            <?php
                            $mapsInput = trim($content['kontak']['google_maps'] ?? '');
                            $mapSrc = '';

                            // 1. Jika input berupa tag <iframe> lengkap (embed code dari Google Maps)
                            if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/is', $mapsInput, $match)) {
                                $mapSrc = $match[1];
                            }
                            // 2. Jika input berupa URL langsung (https://...)
                            elseif (filter_var($mapsInput, FILTER_VALIDATE_URL) || preg_match('/^https?:\/\//i', $mapsInput)) {
                                $mapSrc = $mapsInput;
                            }

                            if (!empty($mapSrc)) {
                                echo '<iframe src="' . esc($mapSrc, 'attr') . '" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                            } else {
                                echo $mapsInput;
                            }
                            ?>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center font-bold text-gray-500">
                                Peta lokasi madrasah
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- FAQ SECTION -->
    <?php if (!empty($faqs)): ?>
        <section id="faq" class="py-12 md:py-20 bg-[#FFFDF5] border-b-[3px] border-black">
            <div class="container mx-auto px-4 md:px-6">

                <div class="section-header text-center mb-8 md:mb-14 max-w-2xl mx-auto">
                    <span class="inline-block px-3 md:px-4 py-1 md:py-1.5 bg-[#C084FC] text-black font-black text-[10px] md:text-xs uppercase tracking-widest rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] mb-3 md:mb-4">
                        ❓ TANYA JAWAB
                    </span>
                    <h2 class="font-heading font-black text-2xl md:text-5xl text-black">Pertanyaan Umum (FAQ)</h2>
                </div>

                <div class="max-w-3xl mx-auto space-y-4">
                    <?php foreach ($faqs as $idx => $faq): ?>
                        <div class="faq-item bg-white rounded-2xl border-[3px] border-black shadow-[4px_4px_0px_0px_#000] overflow-hidden transition-all">
                            <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center font-heading font-black text-base md:text-lg text-black hover:bg-[#FEF08A] transition-colors gap-4">
                                <span><?= esc((string)$faq['pertanyaan']) ?></span>
                                <div class="w-8 h-8 rounded-lg border-2 border-black bg-[#FFE600] flex items-center justify-center font-black text-sm shrink-0 faq-icon transition-transform">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </button>
                            <div class="faq-content hidden px-6 pb-6 pt-2 font-medium text-gray-800 leading-relaxed text-sm md:text-base border-t-2 border-black bg-gray-50">
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
                    const icon = item.querySelector('.faq-icon i');

                    btn.addEventListener('click', () => {
                        const isHidden = content.classList.contains('hidden');
                        if (isHidden) {
                            content.classList.remove('hidden');
                            icon.classList.replace('fa-plus', 'fa-minus');
                            btn.classList.add('bg-[#FEF08A]');
                        } else {
                            content.classList.add('hidden');
                            icon.classList.replace('fa-minus', 'fa-plus');
                            btn.classList.remove('bg-[#FEF08A]');
                        }
                    });
                });
            });
        </script>
    <?php endif; ?>

    <!-- FOOTER SECTION -->
    <footer class="bg-black text-white pt-16 pb-10 border-t-[4px] border-black">
        <div class="container mx-auto px-4 md:px-6">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b-2 border-white/20">

                <!-- Left: Branding -->
                <div class="md:col-span-6 flex flex-col items-start">
                    <div class="flex items-center gap-3 mb-4">
                        <?php if (!empty($web['logo_sekolah'])): ?>
                            <div class="w-12 h-12 bg-[#FFE600] rounded-xl border-2 border-white p-1 flex items-center justify-center shadow-[3px_3px_0px_0px_#FFF]">
                                <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-full h-full object-contain">
                            </div>
                        <?php endif; ?>
                        <div>
                            <h3 class="font-heading font-black text-2xl text-white tracking-tight">
                                <?= esc($content['footer']['nama_sekolah'] ?? ($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus')) ?>
                            </h3>
                            <span class="text-xs font-bold text-[#FFE600] tracking-wider uppercase">Mandiri, Berprestasi, Berakhlak Mulia</span>
                        </div>
                    </div>
                    <p class="text-gray-400 font-semibold text-sm max-w-md leading-relaxed mb-6">
                        Penerimaan Peserta Didik Baru Terpadu berbasis digital untuk kemudahan, kecepatan, dan transparansi pendaftaran madrasah.
                    </p>
                </div>

                <!-- Right: Social Links & Quick Actions -->
                <div class="md:col-span-6 flex flex-col md:items-end justify-between">
                    <div>
                        <h4 class="font-heading font-black text-sm uppercase tracking-widest text-[#FFE600] mb-4">Ikuti Kami</h4>
                        <div class="flex flex-wrap gap-2 md:justify-end">
                            <?php if (!empty($content['kontak']['whatsapp_number'])): ?>
                                <a href="https://wa.me/<?= esc($content['kontak']['whatsapp_number']) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-black border-2 border-black hover:bg-[#22C55E] hover:text-white shadow-[2px_2px_0px_0px_#FFF] flex items-center justify-center transition-all">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($content['footer']['facebook_link'])): ?>
                                <a href="<?= esc($content['footer']['facebook_link'], 'attr') ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-black border-2 border-black hover:bg-[#3B82F6] hover:text-white shadow-[2px_2px_0px_0px_#FFF] flex items-center justify-center transition-all">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($content['footer']['instagram_link'])): ?>
                                <a href="<?= esc($content['footer']['instagram_link'], 'attr') ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-black border-2 border-black hover:bg-[#EC4899] hover:text-white shadow-[2px_2px_0px_0px_#FFF] flex items-center justify-center transition-all">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($content['footer']['youtube_link'])): ?>
                                <a href="<?= esc($content['footer']['youtube_link'], 'attr') ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-black border-2 border-black hover:bg-[#EF4444] hover:text-white shadow-[2px_2px_0px_0px_#FFF] flex items-center justify-center transition-all">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs font-bold text-gray-400 gap-4">
                <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? '') ?>. <?= esc($content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.') ?></p>
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('login') ?>" class="text-[#FFE600] hover:underline font-black">Portal Petugas</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn" class="fixed bottom-6 right-6 z-40 bg-[#FFE600] text-black w-12 h-12 rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-lg hover:translate-x-[-2px] hover:translate-y-[-2px] hover:shadow-[6px_6px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[0px_0px_0px_0px_#000] transition-all opacity-0 invisible" aria-label="Kembali ke atas">
        <i class="fas fa-arrow-up font-black"></i>
    </button>

    <!-- ANNOUNCEMENT POPUP MODAL (Neo-Brutal) -->
    <?php if (!empty($popups)) : ?>
    <div id="announcement-popup" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/75 backdrop-blur-sm">
        <div class="bg-white rounded-3xl border-[4px] border-black shadow-[10px_10px_0px_0px_#000] max-w-lg w-full overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex items-center justify-between gap-3 mb-6 pb-4 border-b-2 border-black">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#FFE600] border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center text-black font-black">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h3 id="popup-title" class="font-heading font-black text-xl text-black line-clamp-1">Pengumuman Penting</h3>
                    </div>
                </div>
                
                <div id="popup-content" class="max-h-[50vh] overflow-y-auto font-medium text-gray-800 space-y-4 pr-1">
                    <!-- Injected by JS -->
                </div>
                
                <div class="mt-8 pt-4 border-t-2 border-black flex justify-end">
                    <button id="close-popup-btn" class="neo-btn bg-[#FFE600] text-black py-3 px-8 rounded-xl text-sm">
                        <span>Tutup Dialog</span>
                        <span id="popup-countdown-text"></span>
                        <i class="fas fa-times ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const popups = <?= json_encode($popups) ?>;
        let currentPopupIndex = 0;

        function showPopup(index) {
            if (index >= popups.length) return;

            const popup = popups[index];
            const modal = document.getElementById('announcement-popup');
            const contentContainer = document.getElementById('popup-content');
            const titleContainer = document.getElementById('popup-title');
            const closeBtn = document.getElementById('close-popup-btn');
            const countdownSpan = document.getElementById('popup-countdown-text');
            
            titleContainer.innerText = popup.judul;
            
            let html = '';
            if (popup.lampiran && (popup.lampiran.match(/\.(jpg|jpeg|png|gif)$/i))) {
                html += `<img src="<?= base_url('uploads/pengumuman/') ?>${popup.lampiran}" class="w-full rounded-xl mb-4 border-2 border-black shadow-[3px_3px_0px_0px_#000]">`;
            }
            html += `<div class="prose prose-sm max-w-none text-gray-800 font-medium leading-relaxed">${DOMPurify.sanitize(popup.isi_pengumuman)}</div>`;
            
            contentContainer.innerHTML = html;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            let countdown = parseInt(popup.popup_countdown) || 0;
            
            if (countdown > 0) {
                closeBtn.disabled = true;
                closeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                countdownSpan.innerText = ` (${countdown})`;
                
                const timer = setInterval(() => {
                    countdown--;
                    if (countdown <= 0) {
                        clearInterval(timer);
                        closeBtn.disabled = false;
                        closeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        countdownSpan.innerText = '';
                    } else {
                        countdownSpan.innerText = ` (${countdown})`;
                    }
                }, 1000);
            } else {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                countdownSpan.innerText = '';
            }

            closeBtn.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                
                if (currentPopupIndex + 1 < popups.length) {
                    currentPopupIndex++;
                    setTimeout(() => showPopup(currentPopupIndex), 300);
                }
            };
        }

        window.addEventListener('load', () => { setTimeout(() => showPopup(0), 800); });
    </script>
    <?php endif; ?>

    <!-- GLOBAL SCRIPTS -->
    <script>
        // Mobile Menu Toggle
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

        // Smooth Scroll & auto close mobile menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    mobileMenu.classList.remove('open');
                    menuIcon.classList.replace('fa-times', 'fa-bars');
                }
            });
        });

        // Lightbox Functions
        function openLightbox(imageUrl, title, desc = '') {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.getElementById('lightbox-caption');
            const lightboxDesc = document.getElementById('lightbox-desc');

            lightboxImg.src = imageUrl;
            lightboxCaption.innerText = title;
            lightboxDesc.innerText = desc;

            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeLightbox();
        });

        // Back to Top Button
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