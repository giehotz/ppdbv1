<!DOCTYPE html>
<html class="light scroll-smooth" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $content['navbar']['nama_sekolah'] ?? 'PPDB Online - Madrasah Al-Maqam' ?><?= ($seo_global['meta_title_suffix'] ?? '') ?></title>
    
    <?php
    // Set page_title for the SEO partial to use
    $page_title = $content['navbar']['nama_sekolah'] ?? 'PPDB Online';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

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
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-emerald-800 border-b-2 border-amber-400 pb-1" href="#home">Beranda</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#schedule">Jadwal</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#requirements">Persyaratan</a>
                <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="#contact">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a class="nav-link font-['Plus_Jakarta_Sans'] font-semibold text-sm tracking-tight text-slate-600 hover:text-emerald-700 transition-all duration-300" href="<?= base_url('pendaftar') ?>">Data Pendaftar</a>
                <?php endif; ?>
            </div>

            <div class="hidden sm:flex items-center gap-4">
                <a href="<?= base_url('login') ?>" class="text-sm font-semibold text-primary hover:opacity-80 transition-all cursor-pointer">Masuk</a>
                <a href="<?= base_url('auth/register') ?>" class="signature-gradient text-white px-6 py-2.5 rounded-md text-sm font-bold shadow-sm hover:opacity-90 transition-transform active:scale-95 cursor-pointer text-center">Daftar</a>
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
                <a href="#home" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Beranda</a>
                <a href="#schedule" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Jadwal</a>
                <a href="#requirements" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Persyaratan</a>
                <a href="#contact" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="block py-3 px-4 rounded-xl hover:bg-surface-container-low hover:text-primary font-semibold text-on-surface transition">Data Pendaftar</a>
                <?php endif; ?>

                <div class="border-t border-surface-variant pt-4 mt-2 flex flex-col gap-3 px-2">
                    <a href="<?= base_url('login') ?>" class="flex items-center justify-center bg-surface-container-low text-primary font-bold py-3 rounded-xl hover:bg-surface-container-high transition">Masuk</a>
                    <a href="<?= base_url('auth/register') ?>" class="flex items-center justify-center signature-gradient text-white font-bold py-3 rounded-xl hover:opacity-90 transition shadow-sm">Daftar</a>
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
    <!-- Requirements Section -->
    <section class="py-24 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20" id="requirements">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-6"><?= $content['syarat']['title'] ?? 'Persyaratan Dokumen' ?></h2>
                <p class="text-on-surface-variant mb-8 text-lg">Siapkan dokumen digital atau berkas fisik berikut sebelum memulai pengisian formulir pendaftaran online.</p>
                <div class="space-y-4">
                    <?php
                    $defaultSyarat = [
                        'Berusia minimal 6 tahun pada bulan Juli.',
                        'Fotocopy Akta Kelahiran.',
                        'Fotocopy Kartu Keluarga (KK).',
                        'Fotocopy Ijazah TK/RA (jika ada).',
                        'Pas Foto ukuran 3x4.',
                        'Membawa map folder plastik kancing saat verifikasi.'
                    ];
                    
                    for ($i = 1; $i <= 6; $i++):
                        $syaratText = $content['syarat']["item{$i}"] ?? '';
                        if (empty($syaratText) && isset($defaultSyarat[$i - 1])) $syaratText = $defaultSyarat[$i - 1];
                        if (empty($syaratText)) continue;
                    ?>
                    <div class="flex items-start gap-4 p-4 bg-surface-container-low rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <span class="material-symbols-outlined text-primary mt-1" data-icon="check_circle" data-weight="fill" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <div>
                            <p class="font-bold text-on-surface">Syarat <?= $i ?></p>
                            <p class="text-sm text-on-surface-variant leading-relaxed"><?= esc($syaratText) ?></p>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                <div class="mt-8">
                    <a href="<?= base_url('pendaftar') ?>" class="inline-flex items-center gap-2 bg-surface-container-highest text-primary font-bold px-6 py-3 rounded-md hover:bg-surface-variant transition-colors shadow-sm">
                        <span class="material-symbols-outlined">search</span>
                        Cek Data Pendaftar Publik
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div class="bg-surface-container-highest h-48 rounded-xl overflow-hidden shadow-sm">
                        <img alt="Student Registration" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC10MVSel-cz0bBJVliTvHNWDtEU21QZJaqxUjq5nzp4Eoi1PDEozsBFUlJsyejhfzgZrMST4cZ3TV3UnP9G5rtORQZo2lio97siedRuhzbutNYobZ_kp3oSPRi3igWjKSNoiMwR3_dCO1b484eHXAb1HVqEXiFfNCzmxtgWg4DCnrLB0eu2TFRUYdqxAWtvV90nOe5yOGgdKjEtSRDsn7HimDYttp4-MKJEAG_RJfaldDTCtcF24zPJ4R3R7Kiy_Nh5fQVYPFi4nJd"/>
                    </div>
                    <div class="bg-secondary-fixed h-64 rounded-xl flex items-center justify-center p-8 shadow-sm">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-5xl text-on-secondary-fixed mb-4" data-icon="info">info</span>
                            <p class="font-bold text-on-secondary-fixed">Siapkan berkas asli saat jadwal verifikasi tiba.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 pt-8">
                    <div class="bg-primary h-64 rounded-xl flex items-center justify-center p-8 text-white shadow-sm">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-5xl mb-4" data-icon="folder_special">folder_special</span>
                            <p class="font-bold">Pastikan data yang diinputkan sesuai dengan dokumen resmi.</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-highest h-48 rounded-xl overflow-hidden shadow-sm">
                        <img alt="Document Setup" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrliBk067FrEmLUGzDeKPibJ5qWL3MNUlRBnBbpM_UClk1GLe3-Rrtq8HVPPcE3ONBpAdjSRe_vNnD5dkRRcUZdpWz-9DKxPi4GwnwABZAOSljDcZaQ61QQi5j7Tav8bauEc1mZFM3Nem8qL7ZABr0eDlqAmDsmCWh1PiXKX4QBMXYBSTKQx-gFH3aOZMoylr4L_dnkhfqO5BG2jF6eoLarPob4HwYKQOlO9GEoK3M8u9KkEiPIYfGSwo3q27_-aViGpHKj2A6tL0Q"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery (Masonry style) -->
    <?php if (!empty($galeri)): ?>
    <section class="py-24 bg-surface-container-low scroll-mt-20" id="galeri">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Galeri Aktivitas</h2>
                <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
                <p class="text-on-surface-variant">Dokumentasi kegiatan dan fasilitas di lingkungan madrasah kami.</p>
            </div>
            
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                <?php foreach ($galeri as $index => $g): ?>
                <div onclick="openLightbox('<?= base_url($g['gambar']) ?>', '<?= esc(addslashes($g['judul'])) ?>', '<?= esc(addslashes($g['deskripsi'] ?? '')) ?>')"
                     class="relative group overflow-hidden rounded-xl cursor-pointer shadow-sm hover:shadow-lg transition-shadow">
                    <img src="<?= base_url($g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" class="w-full h-auto group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-primary/85 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-6 text-center">
                        <span class="material-symbols-outlined text-white text-3xl mb-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-100">zoom_in</span>
                        <p class="text-white font-bold text-lg leading-tight drop-shadow-md transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75"><?= esc($g['judul']) ?></p>
                        <?php if (!empty($g['deskripsi'])): ?>
                            <p class="text-white/80 text-sm mt-2 line-clamp-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150"><?= esc($g['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox" class="fixed inset-0 z-[100] hidden bg-black/90 flex flex-col items-center justify-center p-4 transition-opacity duration-300" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-error rounded-full text-white flex items-center justify-center transition-colors z-[101]">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="max-w-5xl w-full relative flex flex-col items-center" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl">
            <div class="bg-surface-variant/10 backdrop-blur-md px-6 py-4 rounded-2xl mt-4 border border-white/10 text-center max-w-2xl w-full">
                <p id="lightbox-caption" class="text-white text-xl font-bold mb-1 font-headline"></p>
                <p id="lightbox-desc" class="text-surface-dim text-sm line-clamp-3"></p>
            </div>
        </div>
    </div>

    <!-- Testimonials (Marquee) -->
    <?php if (!empty($testimoni)): ?>
    <section class="py-24 overflow-hidden bg-surface scroll-mt-20" id="testimoni">
        <div class="text-center mb-16 px-4">
            <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Suara Mereka</h2>
            <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
            <p class="text-on-surface-variant">Apa kata wali Murid dan alumni tentang Madrasah kami.</p>
        </div>
        
        <div class="marquee relative">
            <!-- Fade masks for smooth edges -->
            <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-surface to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-surface to-transparent z-10"></div>
            
            <div class="marquee-content py-4">
                <?php 
                // Duplicate for infinite scroll loop effect
                $scrollTestimoni = array_merge($testimoni, $testimoni);
                foreach ($scrollTestimoni as $t): 
                ?>
                <div class="w-80 md:w-96 p-8 bg-surface-container-low rounded-xl border border-outline-variant/20 flex-shrink-0 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="material-symbols-outlined text-6xl text-primary/5 absolute top-4 right-4" data-icon="format_quote">format_quote</span>
                    <div class="flex items-center gap-4 mb-6 relative z-10">
                        <img src="<?= !empty($t['avatar']) ? base_url($t['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=006948&color=fff' ?>" alt="<?= esc($t['nama']) ?>" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <div>
                            <p class="font-bold text-on-surface"><?= esc($t['nama']) ?></p>
                            <p class="text-xs text-primary font-bold uppercase tracking-wider mt-0.5"><?= esc($t['peran']) ?></p>
                        </div>
                    </div>
                    <div class="mb-4 text-secondary text-sm">
                        <?php for($i=0; $i<$t['rating']; $i++) echo '<i class="fas fa-star mr-1"></i>'; ?>
                        <?php for($i=$t['rating']; $i<5; $i++) echo '<i class="far fa-star text-outline-variant mr-1"></i>'; ?>
                    </div>
                    <p class="italic text-on-surface-variant leading-relaxed text-sm relative z-10">"<?= esc($t['isi']) ?>"</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Contact & Map -->
    <section class="py-24 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20" id="contact">
        <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm grid lg:grid-cols-2 border border-surface-variant">
            <div class="p-8 md:p-12 border-b lg:border-b-0 lg:border-r border-surface-variant">
                <h2 class="text-3xl font-bold text-primary mb-8 font-headline">Hubungi Kami</h2>
                <div class="space-y-8">
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="location_on">location_on</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Alamat Kampus</p>
                            <p class="text-on-surface-variant leading-relaxed"><?= $content['kontak']['alamat'] ?? 'Jl. Raya No. 123, Kab. Tanggamus' ?></p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="mail">mail</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Email</p>
                            <p class="text-on-surface-variant font-medium">info@madrasah.sch.id</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="phone_iphone">phone_iphone</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">WhatsApp Hotline</p>
                            <p class="text-on-surface-variant font-medium"><?= $content['kontak']['whatsapp_nama'] ?? '+62 812-3456-7890 (Panitia)' ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 flex">
                    <?php $waNumber = $content['kontak']['whatsapp_number'] ?? '6281234567890'; ?>
                    <a href="https://wa.me/<?= esc($waNumber) ?>" target="_blank" class="flex items-center justify-center w-full lg:w-auto gap-3 bg-[#25D366] text-white px-8 py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-[#25D366]/30 hover:-translate-y-1 transition-all">
                        <i class="fab fa-whatsapp text-2xl"></i>
                        <span>Chat via WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <div class="h-80 lg:h-auto bg-surface-variant relative">
                <?php if (!empty($content['kontak']['google_maps'])): ?>
                    <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0 saturate-[1.1] contrast-[1.05]">
                        <?= $content['kontak']['google_maps'] ?>
                    </div>
                <?php else: ?>
                    <img class="w-full h-full object-cover grayscale opacity-50" data-alt="map block placeholder" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3MnA1hCd7z6LZiMZygXHMEqdD4iV5PSKRiCzKmj0tZ53hw1XYFxyRmcGjy1NZuT1Mj-kz3WFDxQvJKqtKx78aHQGGZc0el5yOcfl6Q93WGnRDfJ6ZPPUPglNA3RswqneUqlCf02C00ii2aw7ww-N4VsWPTg9BPSlUcxugyTxqTXTOEH7aVLoj6A4-BI7hgV3t2EPXSgMpmEyhBkpIgRQ13TUIaPQyWX0bo3bl8VyFdopCxYCqHB11gs5dHAwubD_2Md28UQLhlvXp"/>
                    <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant bg-surface/50 backdrop-blur-sm">
                        <p class="font-bold flex items-center gap-2"><span class="material-symbols-outlined">map</span> Peta belum dikonfigurasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <?php if (!empty($faqs)): ?>
    <section class="py-24 px-4 sm:px-8 max-w-4xl mx-auto scroll-mt-20" id="faq">
        <div class="text-center mb-16">
            <span class="inline-block bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-bold tracking-widest uppercase mb-4">Bantuan Singkat</span>
            <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Pusat Bantuan Umum (FAQ)</h2>
            <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
            <p class="text-on-surface-variant text-lg">Temukan jawaban untuk pertanyaan yang paling sering diajukan seputar pendaftaran.</p>
        </div>

        <div class="space-y-4">
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item bg-surface-container-low rounded-xl border border-surface-variant overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none focus:bg-surface-container-high transition-colors">
                    <span class="font-bold text-lg text-primary"><?= esc((string)$faq['pertanyaan']) ?></span>
                    <span class="material-symbols-outlined text-primary transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-on-surface-variant leading-relaxed text-md bg-surface-container-lowest border-t border-surface-variant/50 pt-4">
                    <?= nl2br(esc((string)$faq['jawaban'])) ?>
                </div>
            </div>
            <?php endforeach; ?>
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
                    // Toggle current item
                    const isHidden = content.classList.contains('hidden');
                    
                    if (isHidden) {
                        content.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                        btn.classList.add('bg-surface-container-highest');
                    } else {
                        content.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                        btn.classList.remove('bg-surface-container-highest');
                    }
                });
            });
        });
    </script>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white w-full border-t-[4px] border-secondary-fixed">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 px-8 py-16 w-full max-w-7xl mx-auto">
            
            <!-- Branding -->
            <div class="md:col-span-5">
                <div class="flex items-center gap-4 mb-6">
                    <?php if (!empty($web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-12 h-12 object-contain bg-white rounded-lg p-1">
                    <?php endif; ?>
                    <span class="text-xl font-extrabold text-white block tracking-tight"><?= $content['footer']['nama_sekolah'] ?? ($content['navbar']['nama_sekolah'] ?? 'Madrasah Al-Maqam') ?></span>
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-emerald-100/70 mb-8 max-w-sm">
                    Mencetak generasi rabbani yang unggul dalam ilmu pengetahuan dan berakhlak mulia melalui kurikulum integratif dan lingkungan islami yang asri.
                </p>
                <div class="flex gap-4">
                    <?php if (!empty($content['footer']['facebook_link'])): ?>
                        <a href="<?= esc($content['footer']['facebook_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['instagram_link'])): ?>
                        <a href="<?= esc($content['footer']['instagram_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['tiktok_link'])): ?>
                        <a href="<?= esc($content['footer']['tiktok_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-black transition-colors">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['youtube_link'])): ?>
                        <a href="<?= esc($content['footer']['youtube_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-red-600 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="md:col-span-3">
                <h4 class="font-bold text-secondary-fixed mb-6 uppercase tracking-wider text-xs">Pintasan Informasi</h4>
                <ul class="space-y-4 font-body text-sm">
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#home">Beranda PPDB</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#schedule">Jadwal Seleksi</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#requirements">Panduan Syarat</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="<?= base_url('auth/register') ?>">Formulir Pendaftaran</a></li>
                </ul>
            </div>
            
            <!-- Subscribe / Contact Info -->
            <div class="md:col-span-4">
                <h4 class="font-bold text-secondary-fixed mb-6 uppercase tracking-wider text-xs">Bantuan Segera</h4>
                <p class="text-emerald-100/70 text-sm mb-6 leading-relaxed">Punya pertanyaan mendesak terkait kendala sistem pendaftaran? Tim IT kami siap membantu.</p>
                <div class="inline-flex rounded-xl overflow-hidden shadow-lg w-full">
                    <div class="bg-emerald-800 text-sm px-4 py-3 w-full flex items-center gap-3 text-emerald-100">
                        <i class="fas fa-envelope text-lg opacity-50"></i>
                        <span>ppdb@madrasah.sch.id</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-emerald-800/50 py-6 text-center text-sm font-medium text-emerald-100/50">
            <?= esc($web['nama_sekolah'] ?? '') ?> &copy; <?= date('Y') ?> <?= $content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.' ?>
        </div>
    </footer>

    <!-- Announcement Popup Logic -->
    <?php if (!empty($popups)) : ?>
    <div id="announcement-popup" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-surface rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all duration-300 scale-100">
            <div class="relative p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-surface-variant">
                    <span class="material-symbols-outlined text-primary text-3xl shrink-0" data-icon="campaign">campaign</span>
                    <h3 id="popup-title" class="text-xl font-bold font-headline text-on-surface line-clamp-2">Pengumuman Penting</h3>
                </div>
                
                <div id="popup-content" class="max-h-[60vh] overflow-y-auto custom-scrollbar text-on-surface-variant space-y-4">
                    <!-- Content will be injected by JS -->
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button id="close-popup-btn" class="signature-gradient text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-sm hover:shadow-md flex items-center gap-2 group">
                        <span>Tutup Dialog</span>
                        <span id="popup-countdown-text"></span>
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-300 opacity-70 group-hover:opacity-100"></i>
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
                html += `<img src="<?= base_url('uploads/pengumuman/') ?>${popup.lampiran}" class="w-full rounded-lg mb-4 shadow-sm border border-surface-variant">`;
            }
            html += `<div class="prose prose-sm prose-emerald max-w-none">${popup.isi_pengumuman}</div>`;
            
            contentContainer.innerHTML = html;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            let countdown = parseInt(popup.popup_countdown) || 0;
            
            if (countdown > 0) {
                closeBtn.disabled = true;
                closeBtn.classList.add('opacity-50', 'cursor-not-allowed', 'grayscale');
                countdownSpan.innerText = ` (${countdown})`;
                
                const timer = setInterval(() => {
                    countdown--;
                    if (countdown <= 0) {
                        clearInterval(timer);
                        closeBtn.disabled = false;
                        closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'grayscale');
                        countdownSpan.innerText = '';
                    } else {
                        countdownSpan.innerText = ` (${countdown})`;
                    }
                }, 1000);
            } else {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'grayscale');
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

        window.addEventListener('load', () => { setTimeout(() => showPopup(0), 1000); });
    </script>
    <?php endif; ?>

    <!-- Scripts Interactions -->
    <script>
        // Navbar scroll effect
        const navbar = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md');
                navbar.classList.remove('shadow-sm', 'border-b');
            } else {
                navbar.classList.add('shadow-sm', 'border-b');
                navbar.classList.remove('shadow-md');
            }
        });

        // Mobile Menu Toggle
        const btn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        btn.addEventListener('click', () => {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                menuIcon.innerText = 'close';
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.innerText = 'menu';
            }
        });

        // Smooth scroll & close menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    const offset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        menuIcon.innerText = 'menu';
                    }
                }
            });
        });

        // Lightbox Functions
        function openLightbox(imageUrl, title, desc = '') {
            const lightbox = document.getElementById('lightbox');
            document.getElementById('lightbox-img').src = imageUrl;
            document.getElementById('lightbox-caption').innerText = title;
            document.getElementById('lightbox-desc').innerText = desc;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeLightbox();
        });

        // Active nav link highlighting
        const sections = document.querySelectorAll('section[id], header[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 150;
                const sectionBottom = sectionTop + section.offsetHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('text-emerald-700', 'border-b-2', 'border-amber-400', 'pb-1');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('text-emerald-700', 'border-b-2', 'border-amber-400', 'pb-1');
                }
            });
        });
    </script>
</body>
</html>
