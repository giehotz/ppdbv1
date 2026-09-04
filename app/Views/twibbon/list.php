<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampanye Twibbon Resmi - <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?></title>
    <meta name="description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda untuk <?= esc($web['nama_sekolah'] ?? 'sekolah kami') ?>!">

    <?php 
    $ogImage = base_url('favicon.ico');
    if (!empty($campaigns) && !empty($campaigns[0]['frame']['file_path'])) {
        $ogImage = base_url($campaigns[0]['frame']['file_path']);
    }
    ?>
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta property="og:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta property="og:image" content="<?= $ogImage ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta name="twitter:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta name="twitter:image" content="<?= $ogImage ?>">

    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>?v=<?= @filemtime(FCPATH . 'favicon.ico') ?>">
    
    <!-- Google Fonts: Space Grotesk & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

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
            color: #000000;
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

        /* Retro Dot & Grid Backgrounds */
        .bg-neo-dots {
            background-image: radial-gradient(#000000 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }

        .bg-neo-grid {
            background-image: 
                linear-gradient(to right, rgba(0, 0, 0, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.08) 1px, transparent 1px);
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

        @keyframes neo-scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Checkerboard for Twibbon transparent preview */
        .bg-checkerboard {
            background-color: #ffffff;
            background-image: 
                linear-gradient(45deg, #f1f1f1 25%, transparent 25%), 
                linear-gradient(-45deg, #f1f1f1 25%, transparent 25%), 
                linear-gradient(45deg, transparent 75%, #f1f1f1 75%), 
                linear-gradient(-45deg, transparent 75%, #f1f1f1 75%);
            background-size: 16px 16px;
            background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
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
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-[#FFFDF5] bg-neo-grid text-black antialiased">

    <!-- RUNNING TICKER (Neo-Brutalist Top Marquee) -->
    <div class="bg-[#FFE600] border-b-[3px] border-black py-2 marquee-container font-black text-xs uppercase tracking-widest text-black select-none z-50">
        <div class="marquee-content">
            <span class="inline-flex items-center gap-4 mx-4">
                <span>🎨 TWIBBON RESMI PPDB ONLINE</span>
                <span>★</span>
                <span>PASANG FOTO TERBAIKMU SEKARANG</span>
                <span>★</span>
                <span><?= esc($web['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>DUKUNG PENERIMAAN SISWA BARU</span>
                <span>★</span>
                <span>BAGIKAN KE STATUS WHATSAPP & INSTAGRAM</span>
                <span>★</span>
            </span>
            <span class="inline-flex items-center gap-4 mx-4" aria-hidden="true">
                <span>🎨 TWIBBON RESMI PPDB ONLINE</span>
                <span>★</span>
                <span>PASANG FOTO TERBAIKMU SEKARANG</span>
                <span>★</span>
                <span><?= esc($web['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>DUKUNG PENERIMAAN SISWA BARU</span>
                <span>★</span>
                <span>BAGIKAN KE STATUS WHATSAPP & INSTAGRAM</span>
                <span>★</span>
            </span>
        </div>
    </div>

    <!-- NAVBAR (Neobrutalism) -->
    <nav class="sticky top-0 z-40 bg-white border-b-[3px] border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <!-- Brand -->
            <a href="<?= base_url() ?>" class="flex items-center gap-3 group">
                <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] p-1 flex items-center justify-center group-hover:rotate-6 transition-transform shrink-0">
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-full h-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="w-10 h-10 md:w-11 md:h-11 bg-[#FFE600] rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-black font-black text-lg md:text-xl group-hover:rotate-6 transition-transform shrink-0">
                        <?= mb_substr(esc($web['nama_sekolah'] ?? 'M'), 0, 1) ?>
                    </div>
                <?php endif; ?>
                <div class="flex flex-col">
                    <span class="font-heading font-black text-base sm:text-lg text-black tracking-tight leading-tight group-hover:text-[#FF6B8B] transition-colors">
                        <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?>
                    </span>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-gray-700">Official Twibbon Hub</span>
                </div>
            </a>

            <!-- Nav Actions -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="<?= base_url() ?>" 
                   class="neo-btn bg-white hover:bg-gray-100 text-black py-2 px-3.5 sm:px-4 rounded-xl text-xs shadow-[2px_2px_0px_0px_#000]">
                    <i class="fas fa-home mr-1.5 text-xs"></i>
                    <span class="hidden sm:inline">Beranda PPDB</span>
                    <span class="sm:hidden">Beranda</span>
                </a>
                <a href="<?= base_url('login') ?>" 
                   class="neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-2 px-4 sm:px-5 rounded-xl text-xs shadow-[2px_2px_0px_0px_#000]">
                    <i class="fas fa-sign-in-alt mr-1.5 text-xs"></i>
                    <span>Masuk</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-1 py-10 sm:py-14 px-4 sm:px-6 max-w-7xl w-full mx-auto space-y-10">
        
        <!-- HERO HEADER (Neobrutalism) -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2">
                <span class="bg-[#00D2FF] text-black font-black text-xs uppercase px-3 py-1 rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] -rotate-1">
                    <i class="fas fa-magic mr-1"></i> Twibbon Campaign Studio
                </span>
                <span class="bg-[#A3E635] text-black font-black text-xs uppercase px-3 py-1 rounded-lg border-2 border-black shadow-[3px_3px_0px_0px_#000] rotate-2 hidden sm:inline-block">
                    ★ <?= count($campaigns ?? []) ?> Bingkai Aktif
                </span>
            </div>

            <h1 class="font-heading font-black text-3xl sm:text-5xl text-black tracking-tight leading-tight">
                PILIH BINGKAI & PASANG
                <span class="bg-[#FFE600] px-3 py-0.5 border-3 border-black shadow-[4px_4px_0px_0px_#000] inline-block -rotate-1 ml-1 text-black">
                    TWIBBON RESMI
                </span>
            </h1>

            <p class="text-sm sm:text-base font-semibold text-gray-700 max-w-2xl mx-auto leading-relaxed">
                Tunjukkan kebanggaan dan dukungan Anda untuk <strong><?= esc($web['nama_sekolah'] ?? 'Madrasah') ?></strong>. Pasang foto profil terbaik Anda secara gratis tanpa watermark!
            </p>
            
            <!-- Neo Search Bar -->
            <div class="pt-3 max-w-lg mx-auto relative">
                <div class="relative flex items-center bg-white border-3 border-black rounded-2xl shadow-[4px_4px_0px_0px_#000] focus-within:shadow-[6px_6px_0px_0px_#000] transition-all overflow-hidden">
                    <span class="pl-4 pr-2 text-black text-base">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search-campaign" placeholder="Ketik nama kampanye twibbon..."
                        class="h-12 w-full bg-transparent px-2 text-sm font-bold text-black placeholder:text-gray-400 focus:outline-none focus:ring-0">
                    <span class="pr-3 text-[10px] font-black uppercase text-gray-500 bg-[#FFFDF5] border border-black rounded-md px-2 py-1 mr-2 hidden sm:inline-block">
                        Filter
                    </span>
                </div>
            </div>
        </div>

        <!-- CAMPAIGN CARDS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="campaign-grid">
            <?php if (empty($campaigns)): ?>
                <!-- Empty State (Neobrutalism) -->
                <div class="col-span-full neo-box-lg bg-white rounded-3xl p-10 sm:p-14 text-center max-w-xl mx-auto space-y-4">
                    <div class="w-20 h-20 bg-[#FFE600] rounded-2xl border-3 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-3xl text-black mx-auto rotate-3">
                        <i class="fas fa-paint-roller"></i>
                    </div>
                    <div class="space-y-1">
                        <span class="bg-[#FF6B8B] text-white font-black text-xs uppercase px-3 py-1 rounded-md border-2 border-black shadow-[2px_2px_0px_0px_#000] inline-block -rotate-1">
                            Belum Ada Bingkai Aktif
                        </span>
                        <h3 class="font-heading font-black text-xl text-black mt-2">Segera Hadir Kampanye Menarik!</h3>
                        <p class="text-xs font-semibold text-gray-600 max-w-sm mx-auto">
                            Panitia sedang mempersiapkan bingkai twibbon resmi PPDB. Silakan kembali beberapa saat lagi.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="<?= base_url() ?>" class="neo-btn bg-[#00D2FF] hover:bg-[#00D2FF] text-black py-2.5 px-6 rounded-xl text-xs font-black">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php 
                $colors = ['#FFE600', '#00D2FF', '#A3E635', '#FF6B8B', '#C084FC', '#FF9F1C'];
                $i = 0;
                foreach ($campaigns as $c): 
                    $accentColor = $colors[$i % count($colors)];
                    $i++;
                ?>
                    <div class="campaign-card neo-box bg-white rounded-3xl flex flex-col justify-between overflow-hidden group hover:-translate-y-2 hover:shadow-[10px_10px_0px_0px_#000] transition-all duration-200">
                        <div>
                            <!-- Header Top Badge Stripe -->
                            <div class="px-5 py-2.5 border-b-[3px] border-black flex items-center justify-between" style="background-color: <?= $accentColor ?>;">
                                <span class="bg-black text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded border border-black shadow-[1px_1px_0px_0px_#FFF]">
                                    ★ TWIBBON RESMI
                                </span>
                                <span class="text-black font-black text-xs">
                                    <i class="far fa-heart group-hover:scale-125 transition-transform inline-block"></i>
                                </span>
                            </div>

                            <!-- Frame Preview Area (Transparent Checkerboard) -->
                            <div class="relative bg-checkerboard aspect-square border-b-[3px] border-black p-6 flex items-center justify-center overflow-hidden">
                                <?php if (!empty($c['frame']['file_path'])): ?>
                                    <img src="<?= base_url($c['frame']['file_path']) ?>" 
                                         alt="<?= esc($c['title']) ?>" 
                                         class="w-full h-full object-contain relative z-10 drop-shadow-[0_4px_8px_rgba(0,0,0,0.15)] group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-image text-5xl mb-2"></i>
                                        <span class="text-xs font-bold">Bingkai Default</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Sticker on Preview -->
                                <div class="absolute bottom-3 left-3 z-20">
                                    <span class="bg-white text-black font-black text-[10px] px-2 py-0.5 rounded border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                                        1080 &times; 1080 PX
                                    </span>
                                </div>
                            </div>

                            <!-- Content Details -->
                            <div class="p-5 sm:p-6 space-y-2.5">
                                <h3 class="font-heading font-black text-xl text-black truncate group-hover:text-[#FF6B8B] transition-colors" title="<?= esc($c['title']) ?>">
                                    <?= esc($c['title']) ?>
                                </h3>
                                <p class="text-xs font-semibold text-gray-700 line-clamp-2 leading-relaxed">
                                    <?= strip_tags($c['description'] ?: 'Ikuti kampanye twibbon resmi dengan memasang foto profil terbaik Anda untuk mendukung PPDB.') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Card Action Footer -->
                        <div class="p-5 sm:p-6 pt-0 space-y-3">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-800 pt-3 border-t-2 border-dashed border-black">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="far fa-calendar-alt text-black"></i>
                                    <span><?= $c['end_date'] ? 'Hingga ' . date('d M Y', strtotime($c['end_date'])) : 'Berlaku Selamanya' ?></span>
                                </span>
                                <span class="bg-[#A3E635] text-black font-black text-[10px] px-2 py-0.5 rounded border border-black">
                                    Aktif
                                </span>
                            </div>

                            <div class="flex items-center gap-2 pt-1">
                                <a href="<?= base_url('twibbon/' . $c['slug']) ?>"
                                   class="flex-1 neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-3 px-4 rounded-xl text-xs font-black shadow-[3px_3px_0px_0px_#000]">
                                    <i class="fas fa-camera mr-1.5"></i>
                                    <span>Buat Twibbon</span>
                                </a>

                                <button type="button" 
                                    onclick="shareCampaign('<?= esc($c['title'], 'js') ?>', '<?= base_url('twibbon/' . $c['slug']) ?>')"
                                    class="neo-btn bg-white hover:bg-[#00D2FF] text-black h-11 w-11 rounded-xl shadow-[3px_3px_0px_0px_#000]"
                                    title="Bagikan Tautan">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <!-- NEOBRUTALISM TOAST NOTIFICATION -->
    <div id="toast" class="fixed bottom-6 right-6 bg-[#000000] text-[#FFE600] border-3 border-[#FFE600] shadow-[5px_5px_0px_0px_#000] font-black text-xs px-5 py-3.5 rounded-2xl transform translate-y-12 opacity-0 pointer-events-none transition-all duration-300 z-50 flex items-center gap-3">
        <i class="fas fa-check-circle text-base text-[#A3E635]"></i>
        <span id="toast-message">Tautan berhasil disalin ke papan klip!</span>
    </div>

    <!-- NEOBRUTALISM FOOTER -->
    <footer class="bg-black text-white border-t-4 border-black mt-16">
        <!-- Accent Top Bar -->
        <div class="h-2 w-full bg-gradient-to-r from-[#FFE600] via-[#FF6B8B] to-[#00D2FF]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#FFE600] rounded-xl border-2 border-white shadow-[2px_2px_0px_0px_#FFF] flex items-center justify-center text-black font-black text-base shrink-0">
                        ★
                    </div>
                    <div>
                        <p class="font-heading font-black text-sm uppercase text-white tracking-wider">
                            <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?>
                        </p>
                        <p class="text-xs font-semibold text-gray-400">
                            Penerimaan Peserta Didik Baru Terpadu
                        </p>
                    </div>
                </div>

                <div class="text-xs font-bold text-gray-400">
                    <p>&copy; <?= date('Y') ?> All Rights Reserved. Designed with <span class="text-[#FF6B8B]">Neobrutalism</span>.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        // Live Search Filter
        const searchInput = document.getElementById('search-campaign');
        const campaignCards = document.querySelectorAll('.campaign-card');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().trim();
                campaignCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const desc = card.querySelector('p').textContent.toLowerCase();
                    if (title.includes(query) || desc.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Web Share & Clipboard API
        function shareCampaign(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Ayo buat twibbon resmi "' + title + '" di ' + '<?= esc($web['nama_sekolah'] ?? 'PPDB') ?>!',
                    url: url
                }).catch(err => {});
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Tautan kampanye berhasil disalin!');
                }).catch(() => {
                    alert('Gagal menyalin tautan.');
                });
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-12', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }
    </script>
</body>
</html>
