<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $content['navbar']['nama_sekolah'] ?? 'PPDB Online - MIN 2 Tanggamus' ?></title>

    <?php
    // Set page_title for the SEO partial to use
    $page_title = $content['navbar']['nama_sekolah'] ?? 'PPDB Online';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        madrasah: '#064e3b', // emerald-900 equivalent
                    }
                }
            }
        }
    </script>

    <style>
        .hero-parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media (max-width: 768px) {
            .hero-parallax {
                background-attachment: scroll;
            }
        }

        /* Marquee Animation for Testimonial */
        .marquee-container {
            overflow: hidden;
            width: 100%;
            position: relative;
            mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        }

        .marquee-content {
            display: flex;
            width: max-content;
            animation: scroll-left 40s linear infinite;
        }

        .marquee-content:hover {
            animation-play-state: paused;
        }

        .marquee-item {
            width: 380px;
            flex-shrink: 0;
            padding: 0 1rem;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .marquee-item {
                width: 320px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-200 selection:text-emerald-900">

    <!-- NAVBAR -->
    <nav id="navbar" class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-6 py-3 flex justify-between items-center">

            <!-- Logo -->
            <a href="#" class="flex items-center space-x-3 group">
                <?php if (!empty($web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-10 h-10 md:w-11 md:h-11 object-contain transform group-hover:scale-105 transition duration-300">
                <?php else: ?>
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-madrasah rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md transform group-hover:scale-105 transition duration-300">
                        <?= mb_substr($content['navbar']['nama_sekolah'] ?? 'M', 0, 1) ?>
                    </div>
                <?php endif; ?>
                <span class="font-bold text-base md:text-xl tracking-tight text-gray-900 line-clamp-1 group-hover:text-emerald-700 transition-colors">
                    <?= $content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus' ?>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8 font-medium text-gray-600">
                <a href="#beranda" class="hover:text-emerald-600 transition">Beranda</a>
                <a href="#jadwal" class="hover:text-emerald-600 transition">Jadwal</a>
                <a href="#syarat" class="hover:text-emerald-600 transition">Syarat</a>
                <a href="#kontak" class="hover:text-emerald-600 transition">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="hover:text-emerald-600 transition">Data Pendaftar</a>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="<?= base_url('login') ?>" class="hidden sm:inline-flex items-center justify-center bg-white text-gray-700 font-bold py-2 px-5 rounded-full border border-gray-200 hover:bg-gray-50 hover:text-emerald-600 transition duration-300 text-sm shadow-sm">
                    Login
                </a>
                <a href="<?= base_url('auth/register') ?>" class="hidden sm:inline-flex items-center justify-center bg-emerald-600 text-white font-bold py-2 px-6 rounded-full hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-500/30 transform hover:-translate-y-0.5 transition duration-300 text-sm">
                    Daftar PPDB
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden text-gray-600 p-2 focus:outline-none rounded-lg hover:bg-gray-100 transition" id="menu-btn">
                    <i class="fas fa-bars text-xl w-6"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-100 bg-white shadow-xl absolute w-full left-0 overflow-hidden origin-top transition-all duration-300">
            <div class="px-4 py-4 space-y-1">
                <a href="#beranda" class="block py-3 px-4 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 font-semibold text-gray-700 transition">Beranda</a>
                <a href="#jadwal" class="block py-3 px-4 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 font-semibold text-gray-700 transition">Jadwal</a>
                <a href="#syarat" class="block py-3 px-4 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 font-semibold text-gray-700 transition">Syarat</a>
                <a href="#kontak" class="block py-3 px-4 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 font-semibold text-gray-700 transition">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="block py-3 px-4 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 font-semibold text-gray-700 transition">Data Pendaftar</a>
                <?php endif; ?>

                <div class="border-t border-gray-100 pt-4 mt-2 grid grid-cols-2 gap-3 sm:hidden px-2">
                    <a href="<?= base_url('login') ?>" class="flex items-center justify-center bg-gray-100 text-gray-700 font-bold py-2.5 rounded-xl hover:bg-gray-200 transition">Login</a>
                    <a href="<?= base_url('auth/register') ?>" class="flex items-center justify-center bg-emerald-600 text-white font-bold py-2.5 rounded-xl hover:bg-emerald-700 transition shadow-md shadow-emerald-500/20">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <?php
    $heroBg = $content['hero']['background_image'] ?? '';
    $heroStyle = '';
    $heroClass = 'relative bg-emerald-900 text-white overflow-hidden min-h-screen flex items-center justify-center pt-20';
    if (!empty($heroBg)) {
        $heroStyle = "background-image: url('" . base_url($heroBg) . "');";
        $heroClass .= ' hero-parallax';
    }
    ?>
    <header id="beranda" class="<?= $heroClass ?>" style="<?= $heroStyle ?>">
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-madrasah/80 to-slate-900/90 mix-blend-multiply"></div>

        <!-- Animated Background Shapes -->
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-emerald-500 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse"></div>
        <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>

        <div class="container mx-auto px-4 relative z-10 text-center flex flex-col items-center justify-center">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-emerald-100 font-semibold tracking-wider text-xs md:text-sm mb-6 uppercase shadow-lg">
                <i class="fas fa-graduation-cap mr-2"></i>Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?>
            </span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight tracking-tight max-w-4xl text-transparent bg-clip-text bg-gradient-to-r from-white via-emerald-50 to-emerald-200 drop-shadow-sm">
                <?= $content['hero']['headline'] ?? 'Penerimaan Peserta Didik Baru (PPDB)' ?>
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl text-emerald-100/90 mb-10 max-w-2xl font-medium leading-relaxed">
                <?= $content['hero']['subheadline'] ?? 'Mari bergabung bersama kami membentuk generasi mandiri, berprestasi, dan berakhlak mulia.' ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 w-full sm:w-auto">
                <a href="<?= $content['hero']['cta_link'] ?? base_url('auth/register') ?>"
                    class="bg-yellow-500 hover:bg-yellow-400 text-yellow-950 font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-[0_0_20px_rgba(234,179,8,0.4)] hover:shadow-[0_0_30px_rgba(234,179,8,0.6)] transform hover:-translate-y-1 text-lg flex items-center justify-center group">
                    <?= $content['hero']['cta_text'] ?? 'Daftar Sekarang' ?>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#syarat"
                    class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/30 text-white font-bold py-4 px-10 rounded-full transition-all duration-300 text-lg flex items-center justify-center">
                    Cek Persyaratan
                </a>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <a href="#fitur" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/50 hover:text-white transition animate-bounce">
            <i class="fas fa-chevron-down text-2xl"></i>
        </a>
    </header>

    <!-- FITUR / KEUNGGULAN -->
    <?php if (!empty($fitur)): ?>
        <section id="fitur" class="py-24 bg-white relative z-20 -mt-6 rounded-t-[2.5rem] shadow-xl">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
                    <div class="w-20 h-1.5 bg-emerald-500 mx-auto rounded-full mb-4"></div>
                    <p class="text-gray-500 max-w-2xl mx-auto text-lg">Keunggulan dan fasilitas yang kami tawarkan untuk menunjang pendidikan karakter dan prestasi siswa.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($fitur as $f): ?>
                        <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-2 transition-all duration-400 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transform scale-150 transition-all duration-500">
                                <i class="<?= esc($f['ikon'] ?? 'fas fa-star') ?> text-8xl text-emerald-500"></i>
                            </div>
                            <div class="w-16 h-16 bg-white shadow-sm rounded-2xl flex items-center justify-center text-emerald-600 mb-6 text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-400 relative z-10 border border-emerald-50">
                                <i class="<?= esc($f['ikon'] ?? 'fas fa-star') ?>"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-gray-800 relative z-10"><?= $f['judul'] ?></h3>
                            <p class="text-gray-500 leading-relaxed relative z-10"><?= $f['deskripsi'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- JADWAL PELAKSANAAN -->
    <section id="jadwal" class="py-24 bg-slate-50 relative overflow-hidden border-y border-slate-200/60">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 font-bold tracking-wider text-xs mb-3 uppercase shadow-sm">Timeline PPDB</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4"><?= $content['jadwal']['title'] ?? 'Jadwal Pelaksanaan' ?></h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-emerald-400 to-emerald-600 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-500 max-w-2xl mx-auto">Catat tanggal penting berikut agar Anda tidak tertinggal setiap tahapan proses pendaftaran.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-8 relative max-w-6xl mx-auto">
                <!-- Connecting Line (Desktop only) -->
                <div class="hidden md:block absolute top-[45%] left-10 right-10 h-0.5 bg-emerald-200 z-0"></div>

                <!-- Tahap 1 -->
                <div class="relative z-10 bg-white p-8 lg:p-10 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group flex flex-col h-full">
                    <div class="absolute -top-6 -right-6 text-9xl text-gray-50 opacity-5 font-black group-hover:text-emerald-50 transition-colors">1</div>
                    <div class="bg-emerald-100 w-16 h-16 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-bold mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300 group-hover:bg-emerald-600 group-hover:text-white shadow-sm border border-emerald-50">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <div class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Tahap 1</div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-800 line-clamp-2"><?= $content['jadwal']['tahap1_judul'] ?? 'Pendaftaran Online' ?></h3>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <div class="flex items-center space-x-3 mb-2 text-gray-600">
                                <i class="far fa-calendar-alt text-emerald-500 w-5"></i>
                                <span class="font-semibold text-gray-800"><?= $content['jadwal']['tahap1_tanggal'] ?? '01 Mei - 15 Mei 2024' ?></span>
                            </div>
                            <div class="flex items-start space-x-3 text-gray-500">
                                <i class="fas fa-info-circle text-emerald-500 w-5 mt-1"></i>
                                <span class="text-sm leading-relaxed"><?= $content['jadwal']['tahap1_keterangan'] ?? 'Melalui website resmi PPDB' ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2 -->
                <div class="relative z-10 bg-white p-8 lg:p-10 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group md:mt-12 flex flex-col h-full">
                    <div class="absolute -top-6 -right-6 text-9xl text-gray-50 opacity-5 font-black group-hover:text-yellow-50 transition-colors">2</div>
                    <div class="bg-yellow-100 w-16 h-16 rounded-2xl flex items-center justify-center text-yellow-600 text-2xl font-bold mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300 group-hover:bg-yellow-500 group-hover:text-white shadow-sm border border-yellow-50">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <div class="text-xs font-bold text-yellow-600 uppercase tracking-widest mb-2">Tahap 2</div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-800 line-clamp-2"><?= $content['jadwal']['tahap2_judul'] ?? 'Verifikasi Berkas' ?></h3>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <div class="flex items-center space-x-3 mb-2 text-gray-600">
                                <i class="far fa-calendar-alt text-yellow-500 w-5"></i>
                                <span class="font-semibold text-gray-800"><?= $content['jadwal']['tahap2_tanggal'] ?? '17 Mei - 20 Mei 2024' ?></span>
                            </div>
                            <div class="flex items-start space-x-3 text-gray-500">
                                <i class="fas fa-info-circle text-yellow-500 w-5 mt-1"></i>
                                <span class="text-sm leading-relaxed"><?= $content['jadwal']['tahap2_keterangan'] ?? 'Datang langsung ke Madrasah membawa berkas asli' ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tahap 3 -->
                <div class="relative z-10 bg-white p-8 lg:p-10 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group flex flex-col h-full">
                    <div class="absolute -top-6 -right-6 text-9xl text-gray-50 opacity-5 font-black group-hover:text-blue-50 transition-colors">3</div>
                    <div class="bg-blue-100 w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 text-2xl font-bold mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300 group-hover:bg-blue-600 group-hover:text-white shadow-sm border border-blue-50">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <div class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Tahap 3</div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-800 line-clamp-2"><?= $content['jadwal']['tahap3_judul'] ?? 'Pengumuman Hasil' ?></h3>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <div class="flex items-center space-x-3 mb-2 text-gray-600">
                                <i class="far fa-calendar-alt text-blue-500 w-5"></i>
                                <span class="font-semibold text-gray-800"><?= $content['jadwal']['tahap3_tanggal'] ?? '25 Mei 2024' ?></span>
                            </div>
                            <div class="flex items-start space-x-3 text-gray-500">
                                <i class="fas fa-info-circle text-blue-500 w-5 mt-1"></i>
                                <span class="text-sm leading-relaxed"><?= $content['jadwal']['tahap3_keterangan'] ?? 'Dilihat melalui website atau papan pengumuman' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PERSYARATAN -->
    <section id="syarat" class="py-24 bg-white relative">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-16 items-start">

                <!-- Left Title Area -->
                <div class="w-full lg:w-1/3 lg:sticky lg:top-32">
                    <span class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 font-bold tracking-wider text-xs mb-3 uppercase shadow-sm">Information</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight"><?= $content['syarat']['title'] ?? 'Persyaratan Pendaftaran' ?></h2>
                    <p class="text-gray-500 mb-8 text-lg">Harap persiapkan dokumen-dokumen berikut untuk memperlancar proses pendaftaran Ananda tercinta.</p>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-amber-100 text-6xl opacity-50"><i class="fas fa-exclamation-triangle"></i></div>
                        <h4 class="font-bold text-amber-800 mb-2 relative z-10 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i> Perhatian Penting!
                        </h4>
                        <p class="text-sm text-amber-700 relative z-10">Semua berkas fisik wajib dibawa di dalam stopmap saat proses <span class="font-bold">Verifikasi Berkas (Tahap 2)</span> ke madrasah.</p>
                    </div>

                    <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                        <a href="<?= base_url('pendaftar') ?>" class="inline-flex items-center justify-center bg-gray-900 hover:bg-emerald-600 text-white font-semibold py-3.5 px-6 rounded-xl shadow-md transition-all duration-300 group w-full sm:w-auto">
                            <i class="fas fa-search mr-2"></i>
                            <span>Cek Data Pendaftar Publik</span>
                            <i class="fas fa-arrow-right ml-2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Right Grid Area -->
                <div class="w-full lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <?php
                        $defaultSyarat = [
                            'Berusia minimal 6 tahun pada bulan Juli 2024.',
                            'Fotocopy Akta Kelahiran (2 lembar).',
                            'Fotocopy Kartu Keluarga (KK) (2 lembar).',
                            'Fotocopy Ijazah TK/RA (jika ada).',
                            'Pas Foto ukuran 3x4 latar belakang merah (4 lembar).',
                            'Membawa map folder plastik kancing.'
                        ];

                        $icons = ['fa-child', 'fa-file-signature', 'fa-users', 'fa-graduation-cap', 'fa-camera-retro', 'fa-folder-open'];

                        $idx = 0;
                        for ($i = 1; $i <= 6; $i++):
                            $syaratText = $content['syarat']["item{$i}"] ?? ($defaultSyarat[$i - 1] ?? '');
                            if (empty($syaratText)) continue;
                            $iconClass = $icons[$idx % count($icons)];
                        ?>
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_4px_15px_rgb(0,0,0,0.02)] hover:shadow-lg hover:border-emerald-100 transition-all duration-300 flex items-start group">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors flex-shrink-0 mr-4">
                                    <i class="fas <?= $iconClass ?> text-xl"></i>
                                </div>
                                <div class="pt-1">
                                    <h4 class="text-gray-900 font-bold mb-1">Syarat <?= $idx + 1 ?></h4>
                                    <p class="text-gray-500 text-sm leading-relaxed"><?= $syaratText ?></p>
                                </div>
                            </div>
                        <?php
                            $idx++;
                        endfor;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERI -->
    <?php if (!empty($galeri)): ?>
        <section id="galeri" class="py-24 bg-slate-900 relative">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                    <div class="max-w-2xl text-left">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/10 text-emerald-400 font-bold tracking-wider text-xs mb-3 uppercase">Dokumentasi</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Galeri Kegiatan</h2>
                        <p class="text-gray-400">Intip berbagai keseruan dan kegiatan positif di lingkungan madrasah kami.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($galeri as $index => $g): ?>
                        <div onclick="openLightbox('<?= base_url($g['gambar']) ?>', '<?= esc(addslashes($g['judul'])) ?>', '<?= esc(addslashes($g['deskripsi'] ?? '')) ?>')"
                            class="group relative overflow-hidden rounded-2xl cursor-pointer aspect-square bg-slate-800">
                            <img src="<?= base_url($g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition duration-700 ease-out opacity-80 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-90 transition duration-300"></div>

                            <!-- Search Icon Overlay -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition duration-300 scale-50 group-hover:scale-100">
                                <i class="fas fa-search-plus text-xl"></i>
                            </div>

                            <div class="absolute bottom-0 left-0 w-full p-5 translate-y-4 group-hover:translate-y-0 transition duration-300">
                                <h3 class="text-white font-bold text-lg leading-tight drop-shadow-md"><?= esc($g['judul']) ?></h3>
                                <?php if (!empty($g['deskripsi'])): ?>
                                    <p class="text-gray-300 text-sm mt-1 opacity-0 group-hover:opacity-100 transition duration-300 delay-100 line-clamp-1"><?= esc($g['deskripsi']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox" class="fixed inset-0 z-[60] hidden bg-slate-900/95 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-red-500 rounded-full text-white flex items-center justify-center transition-colors z-10">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="max-w-5xl w-full relative flex flex-col items-center" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl border border-white/10">
            <div class="bg-black/50 backdrop-blur-md px-6 py-4 rounded-2xl mt-4 border border-white/10 text-center max-w-2xl w-full">
                <p id="lightbox-caption" class="text-white text-xl font-bold mb-1"></p>
                <p id="lightbox-desc" class="text-gray-300 text-sm"></p>
            </div>
        </div>
    </div>

    <!-- TESTIMONI -->
    <?php if (!empty($testimoni)): ?>
        <section id="testimoni" class="py-24 bg-white border-t border-gray-100 overflow-hidden relative">
            <div class="container mx-auto px-4 md:px-6 mb-12 relative z-10">
                <div class="text-center">
                    <span class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 font-bold tracking-wider text-xs mb-3 uppercase">Testimonials</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Apa Kata Mereka?</h2>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-emerald-400 to-emerald-600 mx-auto rounded-full"></div>
                </div>
            </div>

            <div class="marquee-container relative z-10">
                <div class="marquee-content py-4 items-stretch">
                    <?php
                    // Duplicate for infinite scroll
                    $scrollTestimoni = array_merge($testimoni, $testimoni, $testimoni);
                    foreach ($scrollTestimoni as $t):
                    ?>
                        <div class="marquee-item flex">
                            <div class="bg-slate-50 p-8 rounded-[2rem] hover:bg-white border border-slate-100 hover:border-emerald-100 hover:shadow-xl transition-all duration-300 flex flex-col justify-between w-full relative group">
                                <i class="fas fa-quote-right text-6xl text-gray-100 absolute top-6 right-6 group-hover:text-emerald-50 transition-colors"></i>
                                <div class="relative z-10">
                                    <div class="mb-5 text-amber-400 text-sm">
                                        <?php for ($i = 0; $i < $t['rating']; $i++) echo '<i class="fas fa-star mr-1"></i>'; ?>
                                        <?php for ($i = $t['rating']; $i < 5; $i++) echo '<i class="far fa-star text-gray-300 mr-1"></i>'; ?>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed font-medium mb-8">"<?= esc($t['isi']) ?>"</p>
                                </div>
                                <div class="flex items-center mt-auto border-t border-gray-200/60 pt-6 relative z-10">
                                    <img src="<?= !empty($t['avatar']) ? base_url($t['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=10b981&color=fff' ?>" alt="<?= esc($t['nama']) ?>" class="w-12 h-12 rounded-full object-cover">
                                    <div class="ml-4">
                                        <h4 class="font-bold text-gray-900 text-sm"><?= esc($t['nama']) ?></h4>
                                        <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider mt-0.5"><?= esc($t['peran']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- KONTAK -->
    <section id="kontak" class="py-24 bg-slate-50 relative overflow-hidden border-t border-slate-200/60">
        <!-- Decor -->
        <div class="absolute inset-0 pointer-events-none opacity-40 mix-blend-multiply" style="background-image: radial-gradient(#10b981 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="max-w-6xl mx-auto bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden flex flex-col lg:flex-row">

                <!-- Left: Contact Info -->
                <div class="w-full lg:w-5/12 bg-emerald-900 p-10 lg:p-14 text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-600 rounded-full mix-blend-screen filter blur-[80px] opacity-50 translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-screen filter blur-[80px] opacity-30 -translate-x-1/2 translate-y-1/2"></div>

                    <div class="relative z-10">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/10 text-emerald-100 font-bold tracking-wider text-xs mb-4 uppercase">Hubungi Kami</span>
                        <h3 class="text-3xl font-bold mb-6">Informasi Kontak</h3>
                        <p class="text-emerald-100/80 mb-12 leading-relaxed text-sm">Tim kami siap membantu Anda menjawab segala pertanyaan seputar proses pendaftaran peserta didik baru.</p>

                        <div class="space-y-8">
                            <div class="flex items-start group">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 mr-4 group-hover:bg-white group-hover:text-emerald-800 transition-colors">
                                    <i class="fas fa-map-marker-alt text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-emerald-200 text-xs uppercase tracking-wider mb-1">Alamat Madrasah</h4>
                                    <p class="text-white font-medium leading-relaxed"><?= $content['kontak']['alamat'] ?? 'Jl. Raya No. 123, Kab. Tanggamus, Lampung' ?></p>
                                </div>
                            </div>

                            <div class="flex items-start group">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 mr-4 group-hover:bg-white group-hover:text-emerald-800 transition-colors">
                                    <i class="fab fa-whatsapp text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-emerald-200 text-xs uppercase tracking-wider mb-1">WhatsApp Panitia</h4>
                                    <p class="text-white font-medium text-lg leading-relaxed"><?= $content['kontak']['whatsapp_nama'] ?? '+62 812-3456-7890 (Bpk. Ahmad)' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: CTA Area -->
                <div class="w-full lg:w-7/12 p-10 lg:p-16 flex items-center justify-center">
                    <div class="text-center w-full max-w-md mx-auto">
                        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-emerald-100 relative">
                            <div class="absolute inset-0 rounded-full border-4 border-emerald-500 border-dashed animate-[spin_10s_linear_infinite]"></div>
                            <i class="fab fa-whatsapp text-4xl text-emerald-600 relative z-10"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-4">Butuh Bantuan Cepat?</h3>
                        <p class="text-gray-500 mb-10 leading-relaxed">Klik tombol di bawah ini untuk terhubung langsung dengan admin kami via WhatsApp tanpa harus menyimpan nomor.</p>

                        <?php $waNumber = $content['kontak']['whatsapp_number'] ?? '6281234567890'; ?>
                        <a href="https://wa.me/<?= esc($waNumber) ?>" target="_blank"
                            class="inline-flex items-center justify-center w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-8 rounded-2xl transition-all hover:shadow-lg hover:shadow-emerald-500/30 transform hover:-translate-y-1 space-x-3 text-lg group">
                            <i class="fab fa-whatsapp text-2xl group-hover:rotate-12 transition-transform"></i>
                            <span>Chat via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Google Maps Area -->
            <?php if (!empty($content['kontak']['google_maps'])): ?>
                <div class="max-w-6xl mx-auto mt-12 bg-white rounded-[2.5rem] p-3 md:p-4 shadow-xl border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-6 left-6 md:top-8 md:left-8 z-20 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg border border-white/20 flex items-center gap-2 pointer-events-none">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold text-gray-800 tracking-wider">LOKASI KAMI</span>
                    </div>
                    <!-- Arbitrary Tailwind variants used to style the inner iframe regardless of user input -->
                    <div class="w-full h-[350px] md:h-[450px] rounded-[2rem] overflow-hidden [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0 saturate-[1.1] contrast-[1.05]">
                        <?= $content['kontak']['google_maps'] ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- FAQ SECTION -->
    <?php if (!empty($faqs)): ?>
    <section id="faq" class="py-24 bg-white relative overflow-hidden border-t border-slate-200/60">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block py-1 px-3 rounded-full bg-emerald-100 text-emerald-700 font-bold tracking-wider text-xs mb-3 uppercase shadow-sm">Bantuan Singkat</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Pusat Bantuan Umum (FAQ)</h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-emerald-400 to-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="max-w-4xl mx-auto space-y-4">
                <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item bg-slate-50 rounded-[1.5rem] border border-slate-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none focus:bg-white transition-colors group">
                        <span class="font-bold text-lg text-gray-800 group-hover:text-emerald-600 transition-colors"><?= esc((string)$faq['pertanyaan']) ?></span>
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                            <i class="fas fa-chevron-down transition-transform duration-300 faq-icon"></i>
                        </div>
                    </button>
                    <div class="faq-content hidden px-8 pb-8 text-gray-600 leading-relaxed text-md bg-white border-t border-slate-100 pt-5">
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

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-white pt-16 pb-8 border-t-[6px] border-emerald-500">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 pb-10 border-b border-white/10">
                <div class="mb-8 md:mb-0 text-center md:text-left flex flex-col items-center md:items-start">
                    <!-- Footer Logo -->
                    <div class="flex items-center space-x-3 mb-4">
                        <?php if (!empty($web['logo_sekolah'])): ?>
                            <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-10 h-10 object-contain bg-white rounded-lg p-1">
                        <?php endif; ?>
                        <h3 class="text-2xl font-bold tracking-tight"><?= $content['footer']['nama_sekolah'] ?? ($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?></h3>
                    </div>
                    <p class="text-gray-400 font-medium">Mandiri, Berprestasi, Berakhlak Mulia</p>
                </div>

                <div class="text-center md:text-right">
                    <h4 class="font-semibold text-gray-400 mb-4 uppercase tracking-wider text-xs">Temukan Kami di</h4>
                    <div class="flex space-x-3 justify-center md:justify-end">
                        <a href="<?= isset($content['kontak']['whatsapp_number']) && !empty($content['kontak']['whatsapp_number']) ? 'https://wa.me/' . esc($content['kontak']['whatsapp_number']) : '#' ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-emerald-500 flex items-center justify-center transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <?php if (!empty($content['footer']['facebook_link'])): ?>
                            <a href="<?= $content['footer']['facebook_link'] ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-blue-600 flex items-center justify-center transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($content['footer']['instagram_link'])): ?>
                            <a href="<?= $content['footer']['instagram_link'] ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-600 flex items-center justify-center transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($content['footer']['tiktok_link'])): ?>
                            <a href="<?= $content['footer']['tiktok_link'] ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-black flex items-center justify-center transition-colors">
                                <i class="fab fa-tiktok"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($content['footer']['youtube_link'])): ?>
                            <a href="<?= $content['footer']['youtube_link'] ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-red-600 flex items-center justify-center transition-colors">
                                <i class="fab fa-youtube"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? '') ?>. <?= $content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.' ?></p>
                <!-- <div class="mt-4 md:mt-0 space-x-4">
                    <a href="<?= base_url('login') ?>" class="hover:text-emerald-400 transition">Admin Login</a>
                </div> -->
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTopBtn" class="fixed bottom-6 right-6 bg-emerald-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center text-lg hover:bg-emerald-700 hover:shadow-emerald-500/40 hover:-translate-y-1 transition-all duration-300 z-50 opacity-0 invisible scale-75">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Announcement Popup Logic -->
    <?php if (!empty($popups)) : ?>
    <div id="announcement-popup" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all duration-300 scale-100 border border-gray-100">
            <div class="relative p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <i class="fas fa-bullhorn text-xl"></i>
                    </div>
                    <h3 id="popup-title" class="text-xl font-bold text-gray-900 line-clamp-2">Pengumuman Penting</h3>
                </div>
                
                <div id="popup-content" class="max-h-[60vh] overflow-y-auto custom-scrollbar text-gray-600 space-y-4">
                    <!-- Content will be injected by JS -->
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button id="close-popup-btn" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow hover:shadow-lg flex items-center gap-2 group">
                        <span>Tutup Dialog</span>
                        <span id="popup-countdown-text"></span>
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-300"></i>
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
                html += `<img src="<?= base_url('uploads/pengumuman/') ?>${popup.lampiran}" class="w-full rounded-lg mb-4 shadow-sm border border-gray-200">`;
            }
            html += `<div class="prose prose-sm prose-emerald max-w-none text-gray-600">${popup.isi_pengumuman}</div>`;
            
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

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md', 'bg-white/95');
                navbar.classList.remove('bg-white/90', 'shadow-sm');
            } else {
                navbar.classList.add('bg-white/90', 'shadow-sm');
                navbar.classList.remove('shadow-md', 'bg-white/95');
            }
        });

        // Mobile Menu Toggle
        const btn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = btn.querySelector('i');

        btn.addEventListener('click', () => {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
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
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Close mobile menu
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
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
            // Small delay to allow display:block to apply before animating opacity
            setTimeout(() => {
                lightbox.classList.add('opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('opacity-100');

            setTimeout(() => {
                lightbox.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300); // Wait for transition
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeLightbox();
        });

        // Back to Top functionality
        const backToTopBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('opacity-0', 'invisible', 'scale-75');
                backToTopBtn.classList.add('opacity-100', 'visible', 'scale-100');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible', 'scale-100');
                backToTopBtn.classList.add('opacity-0', 'invisible', 'scale-75');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>