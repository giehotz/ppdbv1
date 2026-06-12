<!DOCTYPE html>
<html class="light scroll-smooth" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $content['navbar']['nama_sekolah'] ?? 'PPDB Online - Madrasah Al-Maqam' ?></title>
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="<?= $content['navbar']['nama_sekolah'] ?? 'PPDB Online - Madrasah Al-Maqam' ?>">
    <meta property="og:description" content="<?= $content['hero']['subheadline'] ?? 'Penerimaan Peserta Didik Baru (PPDB)' ?>">
    <?php if (!empty($web['logo_sekolah'])): ?>
        <meta property="og:image" content="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>">
    <?php endif; ?>

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= current_url() ?>">
    <meta property="twitter:title" content="<?= $content['navbar']['nama_sekolah'] ?? 'PPDB Online - Madrasah Al-Maqam' ?>">
    <meta property="twitter:description" content="<?= $content['hero']['subheadline'] ?? 'Penerimaan Peserta Didik Baru (PPDB)' ?>">
    <?php if (!empty($web['logo_sekolah'])): ?>
        <meta property="twitter:image" content="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary-fixed-dim": "#9ad1cb",
                        "secondary": "#735c00",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#ffe088",
                        "surface": "#f7f9fb",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed-variant": "#144f4b",
                        "inverse-surface": "#2d3133",
                        "tertiary": "#2e6560",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-fixed-variant": "#005137",
                        "primary-fixed": "#85f8c4",
                        "surface-dim": "#d8dadc",
                        "primary-container": "#00855d",
                        "on-surface": "#191c1e",
                        "surface-tint": "#006c4a",
                        "tertiary-container": "#487e79",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#e6e8ea",
                        "on-primary-fixed": "#002114",
                        "surface-container-highest": "#e0e3e5",
                        "surface-bright": "#f7f9fb",
                        "surface-container": "#eceef0",
                        "on-tertiary-container": "#f3fffd",
                        "on-secondary-fixed-variant": "#574500",
                        "on-surface-variant": "#3d4a42",
                        "tertiary-fixed": "#b5ede7",
                        "background": "#f7f9fb",
                        "on-secondary": "#ffffff",
                        "on-primary-container": "#f5fff7",
                        "primary-fixed-dim": "#68dba9",
                        "primary": "#006948",
                        "secondary-container": "#fed65b",
                        "outline-variant": "#bccac0",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "inverse-on-surface": "#eff1f3",
                        "on-background": "#191c1e",
                        "on-tertiary-fixed": "#00201e",
                        "inverse-primary": "#68dba9",
                        "on-secondary-container": "#745c00",
                        "outline": "#6d7a72",
                        "on-error": "#ffffff",
                        "on-secondary-fixed": "#241a00",
                        "surface-variant": "#e0e3e5",
                        "surface-container-low": "#f2f4f6",
                        "secondary-fixed-dim": "#e9c349"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Plus Jakarta Sans", "sans-serif"],
                        "label": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .signature-gradient {
            background: linear-gradient(135deg, #006948 0%, #00855d 100%);
        }
        .glass-nav {
            background: rgba(247, 249, 251, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .asymmetric-card {
            border-top-left-radius: 0;
        }
        .marquee {
            display: flex;
            overflow: hidden;
            user-select: none;
            gap: 2rem;
        }
        .marquee-content {
            flex-shrink: 0;
            display: flex;
            justify-content: space-around;
            min-width: 100%;
            gap: 2rem;
            animation: scroll 30s linear infinite;
        }
        @keyframes scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-100%); }
        }
        .marquee-content:hover {
            animation-play-state: paused;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #00855d; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #006948; }
        
        /* Mobile menu */
        #mobile-menu {
            transition: all 0.3s ease-in-out;
            transform-origin: top;
        }
        #mobile-menu.hidden {
            opacity: 0;
            transform: scaleY(0);
            display: none;
        }
        #mobile-menu:not(.hidden) {
            opacity: 1;
            transform: scaleY(1);
            display: block;
        }
        
        /* Lightbox */
        #lightbox { transition: opacity 0.3s ease-out; }
        #lightbox.hidden { opacity: 0; pointer-events: none; }
        #lightbox:not(.hidden) { opacity: 1; pointer-events: auto; }
    </style>
</head>

<body class="bg-surface font-body text-on-surface">

    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-50 glass-nav shadow-sm border-b border-surface-variant">
        <div class="flex justify-between items-center px-4 md:px-8 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center group">
                    <?php if (!empty($web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-10 h-10 object-contain mr-2 transform group-hover:scale-105 transition duration-300">
                    <?php else: ?>
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-sm mr-2 transform group-hover:scale-105 transition duration-300">
                            <?= mb_substr($content['navbar']['nama_sekolah'] ?? 'M', 0, 1) ?>
                        </div>
                    <?php endif; ?>
                    <span class="text-xl font-bold text-emerald-900 tracking-tighter font-headline line-clamp-1 group-hover:text-primary transition-colors">
                        <?= $content['navbar']['nama_sekolah'] ?? 'Madrasah Al-Maqam' ?>
                    </span>
                </a>
            </div>

            <div class="hidden md:flex space-x-6 lg:space-x-8 items-center">
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-emerald-800 border-b-2 border-amber-400 pb-1" href="#home">Home</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#schedule">Schedule</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#requirements">Requirements</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#contact">Contact</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="<?= base_url('pendaftar') ?>">Applicant Data</a>
                <?php endif; ?>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                <a href="<?= base_url('login') ?>" class="text-sm font-semibold text-primary hover:opacity-80 transition-all cursor-pointer">Login</a>
                <a href="<?= base_url('auth/register') ?>" class="signature-gradient text-white px-6 py-2.5 rounded-md text-sm font-bold shadow-sm hover:opacity-90 transition-transform active:scale-95 cursor-pointer text-center">Register</a>
            </div>

            <div class="md:hidden flex items-center">
                <button id="menu-btn" class="text-on-surface hover:text-primary p-2 focus:outline-none rounded-lg transition">
                    <span class="material-symbols-outlined text-2xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-surface-variant bg-surface shadow-xl absolute w-full left-0 overflow-hidden">
            <div class="px-4 py-4 space-y-1">
                <a href="#home" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Home</a>
                <a href="#schedule" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Schedule</a>
                <a href="#requirements" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Requirements</a>
                <a href="#contact" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Contact</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Applicant Data</a>
                <?php endif; ?>

                <div class="border-t border-surface-variant pt-4 mt-2 flex flex-col gap-3 px-2">
                    <a href="<?= base_url('login') ?>" class="flex items-center justify-center bg-surface-container-low text-primary font-bold py-3 rounded-xl hover:bg-surface-container-high transition">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="flex items-center justify-center signature-gradient text-white font-bold py-3 rounded-xl hover:opacity-90 transition shadow-sm">Daftar / Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <?php
    $heroBg = $content['hero']['background_image'] ?? '';
    // Use tets.html default majestic building if background is empty
    $defaultHeroImg = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBaGwRezDHKTlslJMLtEkKT1oJK6kHr8WyPM95skUKz27uqQKt3ZbxW7NUtWEgGQ52LWYX1WMh7gCEnCvuLx8qgi_51LFo9wbif2AMp_0d2XbLcnMwLguOKZDmZv8FREhO549Qc04NCjYa1MTN0xTjV5cN2z9oWHZ1K5hfylr1jLormBtLk_A5be-wYjF1gdvWdU7NpYPSutgKI7b_17JPeJC8kVEmlTpSc52-zskYoFI4wRpjCQ6GmNOYRIuyWISUYOCeTYyMJL7A';
    $bgUrl = !empty($heroBg) ? base_url($heroBg) : $defaultHeroImg;
    ?>
    <header id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16 scroll-mt-20">
        <div class="absolute inset-0 z-0 bg-primary">
            <img alt="Hero Background" class="w-full h-full object-cover scale-105 opacity-60" src="<?= $bgUrl ?>" />
            <div class="absolute inset-0 bg-gradient-to-br from-primary/90 via-primary/60 to-transparent"></div>
        </div>
        
        <!-- Decorative abstract shapes from old hero integrated into new layout subtly -->
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-primary-fixed rounded-full mix-blend-overlay filter blur-[100px] opacity-20"></div>

        <div class="relative z-10 max-w-5xl px-8 text-center flex flex-col items-center">
            <span class="inline-block bg-secondary-fixed text-on-secondary-fixed px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 shadow-sm">
                Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?>
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold text-white font-headline leading-tight tracking-tight mb-8 drop-shadow-sm">
                <?= $content['hero']['headline'] ?? 'Wujudkan Masa Depan Gemilang di <span class="text-secondary-fixed">Madrasah Al-Maqam</span>' ?>
            </h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-12 font-light leading-relaxed">
                <?= $content['hero']['subheadline'] ?? 'Mencetak generasi rabbani yang unggul dalam ilmu pengetahuan dan berakhlak mulia melalui kurikulum integratif dan lingkungan islami yang asri.' ?>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center w-full sm:w-auto">
                <a href="<?= $content['hero']['cta_link'] ?? base_url('auth/register') ?>" class="bg-secondary-fixed text-on-secondary-fixed px-10 py-4 rounded-md font-bold text-lg hover:scale-105 transition-transform shadow-[0_0_20px_rgba(254,214,91,0.3)] flex justify-center items-center">
                    <?= $content['hero']['cta_text'] ?? 'Daftar Sekarang' ?>
                </a>
                <a href="#requirements" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-10 py-4 rounded-md font-bold text-lg hover:bg-white/20 transition-all flex justify-center items-center">
                    Pelajari Persyaratan
                </a>
            </div>
        </div>
        
        <!-- Scroll down indicator -->
        <a href="#fitur" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/70 hover:text-white transition animate-bounce">
            <span class="material-symbols-outlined text-4xl">keyboard_arrow_down</span>
        </a>
    </header>

    <!-- Features Section (Bento Grid) -->
    <?php if (!empty($fitur)): ?>
    <section id="fitur" class="py-24 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Mengapa Memilih Kami?</h2>
            <div class="h-1 w-24 bg-secondary mx-auto"></div>
            <p class="text-on-surface-variant mt-4 text-lg">Keunggulan dan fasilitas yang kami tawarkan untuk menunjang pendidikan Ananda.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php foreach ($fitur as $f): 
                // We assume $f['ikon'] has font-awesome class, e.g., 'fas fa-school'. 
                // We'll use an <i> tag to ensure it works, but apply our new styling classes.
                $ikonClass = $f['ikon'] ?? 'fas fa-star';
            ?>
            <div class="md:col-span-2 p-8 bg-surface-container-low rounded-xl asymmetric-card group hover:bg-primary-container transition-colors duration-500 shadow-sm hover:shadow-lg border border-transparent hover:border-primary-fixed-dim/30">
                <div class="mb-6 h-12 flex items-center">
                    <?php if (strpos($ikonClass, 'fa') !== false): ?>
                        <i class="<?= esc($ikonClass) ?> text-4xl text-primary group-hover:text-white transition-colors duration-500"></i>
                    <?php else: ?>
                        <!-- Fallback to material symbols if someone types 'school' instead of 'fas fa-school' -->
                        <span class="material-symbols-outlined text-4xl text-primary group-hover:text-white transition-colors duration-500" data-icon="<?= esc($ikonClass) ?>"><?= esc($ikonClass) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-on-surface group-hover:text-white transition-colors duration-500"><?= esc($f['judul']) ?></h3>
                <p class="text-on-surface-variant group-hover:text-white/80 leading-relaxed transition-colors duration-500"><?= esc($f['deskripsi']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Schedule Section (Timeline) -->
    <section class="py-24 bg-surface-container-lowest border-y border-surface-variant scroll-mt-20" id="schedule">
        <div class="max-w-4xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase mb-4">Timeline</span>
                <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4"><?= $content['jadwal']['title'] ?? 'Jadwal Pelaksanaan PPDB' ?></h2>
                <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
                <p class="text-on-surface-variant text-lg">Pastikan Anda tidak melewatkan setiap tahapan penting proses pendaftaran kami.</p>
            </div>

            <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-outline-variant/30">
                
                <!-- Phase 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-surface bg-primary text-white shadow-md shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <span class="material-symbols-outlined text-sm font-bold" data-icon="app_registration">app_registration</span>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-xl bg-surface shadow-sm border-l-4 border-primary/50 hover:border-primary transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-bold text-primary text-lg"><?= $content['jadwal']['tahap1_judul'] ?? 'Pendaftaran Online' ?></span>
                        </div>
                        <div class="flex items-center gap-2 mb-2 text-primary font-semibold text-sm">
                            <span class="material-symbols-outlined text-base">calendar_month</span>
                            <span><?= $content['jadwal']['tahap1_tanggal'] ?? '01 Mei - 15 Mei 2024' ?></span>
                        </div>
                        <p class="text-on-surface-variant text-sm mt-2 leading-relaxed"><?= $content['jadwal']['tahap1_keterangan'] ?? 'Melalui website resmi PPDB' ?></p>
                    </div>
                </div>

                <!-- Phase 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-surface bg-secondary text-white shadow-md shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <span class="material-symbols-outlined text-sm font-bold" data-icon="assignment_ind">assignment_ind</span>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-xl bg-surface-container-low shadow-sm border-l-4 border-secondary/50 hover:border-secondary transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-bold text-primary text-lg"><?= $content['jadwal']['tahap2_judul'] ?? 'Verifikasi Berkas' ?></span>
                        </div>
                        <div class="flex items-center gap-2 mb-2 text-secondary font-semibold text-sm">
                            <span class="material-symbols-outlined text-base">calendar_month</span>
                            <span><?= $content['jadwal']['tahap2_tanggal'] ?? '17 Mei - 20 Mei 2024' ?></span>
                        </div>
                        <p class="text-on-surface-variant text-sm mt-2 leading-relaxed"><?= $content['jadwal']['tahap2_keterangan'] ?? 'Datang langsung ke Madrasah membawa berkas asli' ?></p>
                    </div>
                </div>

                <!-- Phase 3 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-surface bg-tertiary text-white shadow-md shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <span class="material-symbols-outlined text-sm font-bold" data-icon="campaign">campaign</span>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[45%] p-6 rounded-xl bg-surface shadow-sm border-l-4 border-tertiary/50 hover:border-tertiary transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-bold text-primary text-lg"><?= $content['jadwal']['tahap3_judul'] ?? 'Pengumuman Hasil' ?></span>
                        </div>
                        <div class="flex items-center gap-2 mb-2 text-tertiary font-semibold text-sm">
                            <span class="material-symbols-outlined text-base">calendar_month</span>
                            <span><?= $content['jadwal']['tahap3_tanggal'] ?? '25 Mei 2024' ?></span>
                        </div>
                        <p class="text-on-surface-variant text-sm mt-2 leading-relaxed"><?= $content['jadwal']['tahap3_keterangan'] ?? 'Dilihat melalui website atau papan pengumuman' ?></p>
                    </div>
                </div>

            </div>
        </div>
    </section>
