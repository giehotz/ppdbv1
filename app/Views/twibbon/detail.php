<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Twibbon - <?= esc($campaign['title']) ?> - <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?></title>
    <meta name="description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Buat Twibbon - <?= esc($campaign['title']) ?>">
    <meta property="og:description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">
    <meta property="og:image" content="<?= base_url($frame['file_path']) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Buat Twibbon - <?= esc($campaign['title']) ?>">
    <meta name="twitter:description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">
    <meta name="twitter:image" content="<?= base_url($frame['file_path']) ?>">

    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>?v=<?= @filemtime(FCPATH . 'favicon.ico') ?>">
    
    <!-- Google Fonts: Space Grotesk & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

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

        /* Cropper customizations */
        .cropper-container {
            width: 100% !important;
            height: 100% !important;
        }
        .cropper-view-box,
        .cropper-face {
            border-radius: 0%;
            outline: none !important;
        }
        .cropper-line, .cropper-point {
            display: none !important;
        }
        .cropper-modal {
            background-color: transparent !important;
            opacity: 0 !important;
        }
        .cropper-bg {
            background-image: none !important;
            background: transparent !important;
        }
        .cropper-crop-box {
            outline: none !important;
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
                <span>🎨 TWIBBON STUDIO</span>
                <span>★</span>
                <span>KAMPANYE: <?= strtoupper(esc($campaign['title'])) ?></span>
                <span>★</span>
                <span><?= esc($web['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>UNGGAH FOTO, ATUR POSISI, & UNDUH HASILNYA</span>
                <span>★</span>
                <span>GRATIS TANPA WATERMARK</span>
                <span>★</span>
            </span>
            <span class="inline-flex items-center gap-4 mx-4" aria-hidden="true">
                <span>🎨 TWIBBON STUDIO</span>
                <span>★</span>
                <span>KAMPANYE: <?= strtoupper(esc($campaign['title'])) ?></span>
                <span>★</span>
                <span><?= esc($web['nama_sekolah'] ?? 'MIN 2 TANGGAMUS') ?></span>
                <span>★</span>
                <span>UNGGAH FOTO, ATUR POSISI, & UNDUH HASILNYA</span>
                <span>★</span>
                <span>GRATIS TANPA WATERMARK</span>
                <span>★</span>
            </span>
        </div>
    </div>

    <!-- NAVBAR (Neobrutalism) -->
    <nav class="sticky top-0 z-40 bg-white border-b-[3px] border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <!-- Brand -->
            <a href="<?= base_url('twibbon') ?>" class="flex items-center gap-3 group">
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
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-gray-700">Twibbon Creator Studio</span>
                </div>
            </a>

            <!-- Back to List -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="<?= base_url('twibbon') ?>" 
                   class="neo-btn bg-white hover:bg-gray-100 text-black py-2 px-3.5 sm:px-4 rounded-xl text-xs shadow-[2px_2px_0px_0px_#000]">
                    <i class="fas fa-arrow-left mr-1.5"></i>
                    <span>Daftar Kampanye</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN WORKSPACE -->
    <main class="flex-1 py-10 sm:py-14 px-4 sm:px-6 max-w-6xl w-full mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- COLUMN 1: TWIBBON STUDIO CANVAS -->
            <div class="lg:col-span-6 flex flex-col items-center">
                
                <!-- Main Frame Box (Neobrutalist) -->
                <div class="neo-box-lg bg-white rounded-3xl p-3 sm:p-4 max-w-[460px] w-full">
                    
                    <!-- Header inside canvas box -->
                    <div class="flex items-center justify-between pb-3 mb-3 border-b-2 border-dashed border-black text-xs font-black">
                        <span class="bg-[#FFE600] px-2 py-0.5 rounded border border-black uppercase tracking-wider text-[10px]">
                            Canvas Preview
                        </span>
                        <span class="text-gray-700 font-mono text-[11px]">
                            <?= (int)($frame['width'] ?? 1080) ?> &times; <?= (int)($frame['height'] ?? 1080) ?> PX
                        </span>
                    </div>

                    <!-- Canvas Area -->
                    <div class="relative w-full bg-checkerboard rounded-2xl overflow-hidden border-3 border-black shadow-inner" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
                        
                        <!-- User Image Container for Cropper -->
                        <div id="image-wrapper" class="w-full h-full absolute inset-0">
                            <img id="image-to-crop" src="" class="max-w-full hidden">
                        </div>

                        <!-- Frame PNG Overlay -->
                        <img src="<?= base_url($frame['file_path']) ?>" alt="Bingkai Twibbon" id="frame-overlay" crossorigin="anonymous" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">

                        <!-- Empty State Upload Trigger (Neo Clickable) -->
                        <div id="upload-placeholder" 
                             class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center cursor-pointer transition-all duration-200 bg-[#FFFDF5]/90 hover:bg-[#FFE600]/25 backdrop-blur-[2px]" 
                             onclick="document.getElementById('photo-input').click()">
                            
                            <div class="w-20 h-20 rounded-2xl bg-[#FFE600] text-black border-3 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-3xl mb-4 group-hover:rotate-6 transition-transform">
                                <i class="fas fa-camera"></i>
                            </div>
                            
                            <span class="bg-[#00D2FF] text-black font-black text-[11px] uppercase px-3 py-1 rounded-md border-2 border-black shadow-[2px_2px_0px_0px_#000] -rotate-1 mb-2">
                                Klik Untuk Unggah
                            </span>

                            <h4 class="font-heading font-black text-lg text-black mt-1">Pilih Foto Terbaik Anda</h4>
                            <p class="text-xs font-semibold text-gray-600 mt-1 max-w-[240px] leading-relaxed">
                                Format JPG, PNG, atau WebP (Maksimal 5MB).
                            </p>
                        </div>
                    </div>

                    <!-- Control Tool Buttons (Shown after photo uploaded) -->
                    <div id="editor-controls" class="grid grid-cols-4 gap-2.5 mt-4 pt-3 border-t-2 border-dashed border-black hidden">
                        <button type="button" onclick="zoom(0.1)" 
                                class="neo-btn bg-[#A3E635] hover:bg-[#86efac] text-black h-11 rounded-xl text-sm border-2 border-black shadow-[3px_3px_0px_0px_#000]" 
                                title="Perbesar Foto">
                            <i class="fas fa-search-plus mr-1"></i> <span class="hidden sm:inline text-xs font-black">Zoom +</span>
                        </button>
                        <button type="button" onclick="zoom(-0.1)" 
                                class="neo-btn bg-[#00D2FF] hover:bg-[#67e8f9] text-black h-11 rounded-xl text-sm border-2 border-black shadow-[3px_3px_0px_0px_#000]" 
                                title="Perkecil Foto">
                            <i class="fas fa-search-minus mr-1"></i> <span class="hidden sm:inline text-xs font-black">Zoom -</span>
                        </button>
                        <button type="button" onclick="rotate(-90)" 
                                class="neo-btn bg-[#FF6B8B] hover:bg-[#f472b6] text-black h-11 rounded-xl text-sm border-2 border-black shadow-[3px_3px_0px_0px_#000]" 
                                title="Putar 90° ke Kiri">
                            <i class="fas fa-undo mr-1"></i> <span class="hidden sm:inline text-xs font-black">Kiri</span>
                        </button>
                        <button type="button" onclick="rotate(90)" 
                                class="neo-btn bg-[#FFE600] hover:bg-[#fde047] text-black h-11 rounded-xl text-sm border-2 border-black shadow-[3px_3px_0px_0px_#000]" 
                                title="Putar 90° ke Kanan">
                            <i class="fas fa-redo mr-1"></i> <span class="hidden sm:inline text-xs font-black">Kanan</span>
                        </button>
                    </div>

                </div>

            </div>

            <!-- COLUMN 2: CAMPAIGN INFO & GUIDE -->
            <div class="lg:col-span-6 space-y-6">
                
                <!-- Campaign Title Card -->
                <div class="neo-box bg-white rounded-3xl p-6 sm:p-7 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="bg-[#C084FC] text-black font-black text-[11px] px-3 py-1 rounded-md border-2 border-black shadow-[2px_2px_0px_0px_#000] uppercase -rotate-1">
                            ★ Kampanye Terpilih
                        </span>
                        <span class="bg-[#A3E635] text-black font-bold text-[10px] px-2.5 py-0.5 rounded border border-black">
                            Resmi
                        </span>
                    </div>

                    <h2 class="font-heading font-black text-2xl sm:text-4xl text-black leading-tight">
                        <?= esc($campaign['title']) ?>
                    </h2>

                    <p class="text-xs sm:text-sm font-semibold text-gray-700 leading-relaxed">
                        <?= nl2br(esc($campaign['description'] ?: 'Ikuti dan ramaikan penerimaan peserta didik baru dengan memasang foto profil Anda pada bingkai ini!')) ?>
                    </p>
                </div>

                <!-- Panduan & Actions Card -->
                <div class="neo-box bg-[#FFFDF5] rounded-3xl p-6 sm:p-7 space-y-6">
                    <div class="border-b-2 border-black pb-3 flex items-center justify-between">
                        <h3 class="font-heading font-black text-sm uppercase tracking-wider text-black flex items-center gap-2">
                            <i class="fas fa-list-ol text-base text-[#FF9F1C]"></i>
                            <span>Cara Menggunakan</span>
                        </h3>
                        <span class="text-xs font-extrabold text-gray-500">3 Langkah Mudah</span>
                    </div>

                    <!-- Step list -->
                    <div class="space-y-4 text-xs font-bold text-gray-800">
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-xl bg-[#FFE600] text-black border-2 border-black shadow-[2px_2px_0px_0px_#000] font-black flex items-center justify-center shrink-0">
                                1
                            </div>
                            <div class="mt-1">
                                <span class="text-black font-black">Unggah Foto:</span> Klik area bingkai atau tombol <strong>Pilih Foto</strong> di bawah untuk memilih foto dari perangkat Anda.
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-xl bg-[#00D2FF] text-black border-2 border-black shadow-[2px_2px_0px_0px_#000] font-black flex items-center justify-center shrink-0">
                                2
                            </div>
                            <div class="mt-1">
                                <span class="text-black font-black">Sesuaikan Posisi:</span> Geser, perbesar, atau putar foto agar posisinya pas di dalam lubang bingkai twibbon.
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-xl bg-[#A3E635] text-black border-2 border-black shadow-[2px_2px_0px_0px_#000] font-black flex items-center justify-center shrink-0">
                                3
                            </div>
                            <div class="mt-1">
                                <span class="text-black font-black">Unduh & Bagikan:</span> Klik tombol <strong>Unduh Twibbon</strong> untuk memproses gambar dan langsung menyimpannya ke galeri perangkat.
                            </div>
                        </div>
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">
                    
                    <!-- Action Buttons -->
                    <div class="pt-4 border-t-2 border-dashed border-black flex flex-col sm:flex-row gap-3">
                        <button type="button" 
                                onclick="document.getElementById('photo-input').click()" 
                                class="flex-1 neo-btn bg-white hover:bg-gray-100 text-black py-3.5 px-5 rounded-2xl border-3 border-black shadow-[4px_4px_0px_0px_#000] font-black text-xs">
                            <i class="fas fa-folder-open mr-2 text-sm text-[#FF9F1C]"></i>
                            <span id="btn-select-text">Pilih Foto</span>
                        </button>
                        
                        <button type="button" 
                                id="btn-download" 
                                onclick="processTwibbon()" 
                                class="flex-1 neo-btn bg-[#A3E635] hover:bg-[#86efac] disabled:opacity-40 disabled:cursor-not-allowed text-black py-3.5 px-5 rounded-2xl border-3 border-black shadow-[4px_4px_0px_0px_#000] font-black text-xs" 
                                disabled>
                            <i class="fas fa-download mr-2 text-sm"></i>
                            <span>Unduh Twibbon</span>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- MODAL LOADING OVERLAY (Neobrutalism) -->
    <div id="loading-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center hidden p-4">
        <div class="neo-box-lg bg-[#FFFDF5] rounded-3xl p-8 max-w-xs w-full text-center space-y-4 animate-bounce">
            <div class="w-16 h-16 bg-[#FFE600] rounded-2xl border-3 border-black shadow-[3px_3px_0px_0px_#000] flex items-center justify-center text-2xl text-black mx-auto">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-black text-lg text-black">Memproses Twibbon...</h3>
                <p class="text-xs font-semibold text-gray-600">Menggabungkan foto terbaik Anda dengan bingkai resmi.</p>
            </div>
        </div>
    </div>

    <!-- MODAL SUCCESS / HASIL (Neobrutalism) -->
    <div id="result-modal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center hidden p-3 sm:p-4 overflow-y-auto" onclick="if(event.target === this) closeResultModal()">
        <div class="relative neo-box-lg bg-[#FFFDF5] rounded-3xl p-5 sm:p-7 max-w-md w-full text-center space-y-4 max-h-[95vh] overflow-y-auto my-auto shadow-[8px_8px_0px_0px_#000]">
            
            <!-- Tombol Keluar (X) -->
            <button type="button" onclick="closeResultModal()" 
                    class="absolute top-3.5 right-3.5 w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#FF6B8B] hover:bg-[#f43f5e] text-white border-2 border-black shadow-[2px_2px_0px_0px_#000] flex items-center justify-center font-black text-xs sm:text-sm transition-transform hover:scale-105 active:scale-95 z-20" 
                    title="Tutup Modal">
                <i class="fas fa-times"></i>
            </button>

            <!-- Header Badge -->
            <div class="pt-1">
                <span class="bg-[#A3E635] text-black font-black text-xs sm:text-sm uppercase px-3.5 py-1 rounded-xl border-2 border-black shadow-[3px_3px_0px_0px_#000] inline-block -rotate-1">
                    <i class="fas fa-check-circle mr-1.5"></i> Twibbon Siap Diunduh!
                </span>
                <p class="text-[11px] sm:text-xs font-semibold text-gray-600 mt-1.5">Gambar kualitas tinggi telah selesai digabungkan.</p>
            </div>
            
            <!-- Result Image Preview -->
            <div class="w-full max-w-[210px] sm:max-w-[240px] aspect-square rounded-2xl overflow-hidden border-3 border-black shadow-[4px_4px_0px_0px_#000] mx-auto bg-checkerboard">
                <img id="result-preview" src="" alt="Hasil Twibbon" class="w-full h-full object-cover">
            </div>

            <!-- Main Download Action -->
            <div class="w-full pt-1">
                <a id="btn-real-download" href="" download 
                   class="w-full neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black font-black py-3 px-5 rounded-2xl border-3 border-black shadow-[3px_3px_0px_0px_#000] text-xs sm:text-sm">
                    <i class="fas fa-download mr-2"></i>
                    <span>Unduh Gambar Sekarang</span>
                </a>
            </div>

            <!-- Social Media Quick Share Strip -->
            <div class="pt-2.5 border-t-2 border-dashed border-black">
                <p class="text-[11px] font-black uppercase tracking-wider text-black mb-2.5 flex items-center justify-center gap-1.5">
                    <i class="fas fa-share-nodes text-[#FF6B8B]"></i>
                    <span>Bagikan ke Media Sosial</span>
                </p>

                <div class="flex items-center justify-center gap-2 max-w-sm mx-auto">
                    <!-- WhatsApp -->
                    <button type="button" onclick="shareToSocial('whatsapp')" 
                            class="flex-1 neo-btn bg-[#22C55E] hover:bg-[#16a34a] text-white h-10 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000]" 
                            title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp text-base"></i>
                    </button>

                    <!-- Facebook -->
                    <button type="button" onclick="shareToSocial('facebook')" 
                            class="flex-1 neo-btn bg-[#1877F2] hover:bg-[#0d6efd] text-white h-10 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000]" 
                            title="Bagikan ke Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </button>

                    <!-- Twitter / X -->
                    <button type="button" onclick="shareToSocial('twitter')" 
                            class="flex-1 neo-btn bg-black hover:bg-neutral-800 text-white h-10 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000]" 
                            title="Bagikan ke X (Twitter)">
                        <i class="fab fa-x-twitter text-sm"></i>
                    </button>

                    <!-- Telegram -->
                    <button type="button" onclick="shareToSocial('telegram')" 
                            class="flex-1 neo-btn bg-[#0088cc] hover:bg-[#0077b5] text-white h-10 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000]" 
                            title="Bagikan ke Telegram">
                        <i class="fab fa-telegram-plane text-sm"></i>
                    </button>

                    <!-- Copy / Native Share -->
                    <button type="button" onclick="shareToSocial('native')" 
                            class="flex-1 neo-btn bg-[#00D2FF] hover:bg-[#06b6d4] text-black h-10 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000]" 
                            title="Salin Tautan / Bagikan">
                        <i class="fas fa-link text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Reset / Close Button -->
            <div class="pt-1">
                <button type="button" onclick="closeResultModal()" 
                        class="w-full neo-btn bg-white hover:bg-gray-100 text-black font-extrabold py-2 px-4 rounded-xl border-2 border-black shadow-[2px_2px_0px_0px_#000] text-xs">
                    <i class="fas fa-redo mr-1.5"></i>
                    <span>Buat Ulang / Ganti Foto</span>
                </button>
            </div>
        </div>
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

    <!-- Cropper.js & Script Logic -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        const FRAME_W = <?= (int)($frame['width'] ?? 1080) ?>;
        const FRAME_H = <?= (int)($frame['height'] ?? 1080) ?>;
        const FRAME_RATIO = FRAME_W / FRAME_H;

        let cropper = null;
        let selectedFile = null;

        function loadPhoto(event) {
            const files = event.target.files;
            if (files && files.length > 0) {
                selectedFile = files[0];
                
                if (selectedFile.size > 5 * 1024 * 1024) {
                    alert('Ukuran file foto terlalu besar. Maksimal 5MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('image-to-crop');
                    img.src = e.target.result;
                    img.classList.remove('hidden');

                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('editor-controls').classList.remove('hidden');
                    document.getElementById('btn-download').removeAttribute('disabled');
                    document.getElementById('btn-select-text').innerText = 'Ganti Foto';

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(img, {
                        aspectRatio: FRAME_RATIO,
                        viewMode: 0,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        modal: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        toggleDragModeOnDblclick: false,
                        ready: function() {
                            syncCropBox();
                        }
                    });
                };
                reader.readAsDataURL(selectedFile);
            }
        }

        function syncCropBox() {
            if (!cropper) return;
            const containerData = cropper.getContainerData();
            cropper.setCropBoxData({
                left: 0,
                top: 0,
                width: containerData.width,
                height: containerData.height
            });
        }

        function zoom(ratio) {
            if (cropper) {
                cropper.zoom(ratio);
                syncCropBox();
            }
        }

        function rotate(degree) {
            if (cropper) {
                cropper.rotate(degree);
                syncCropBox();
            }
        }

        function processTwibbon() {
            if (!cropper || !selectedFile) return;

            document.getElementById('loading-modal').classList.remove('hidden');

            syncCropBox();

            // 1. Dapatkan kanvas foto yang di-crop, di-zoom, dan dirotasi secara presisi oleh Cropper
            const croppedCanvas = cropper.getCroppedCanvas({
                width: FRAME_W,
                height: FRAME_H,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!croppedCanvas) {
                document.getElementById('loading-modal').classList.add('hidden');
                alert('Gagal memproses gambar foto. Silakan coba unggah ulang.');
                return;
            }

            // 2. Gabungkan foto dengan bingkai PNG secara 100% presisi (WYSIWYG)
            const finalCanvas = document.createElement('canvas');
            finalCanvas.width = FRAME_W;
            finalCanvas.height = FRAME_H;
            const ctx = finalCanvas.getContext('2d');

            // Isi latar belakang putih
            ctx.fillStyle = '#FFFFFF';
            ctx.fillRect(0, 0, FRAME_W, FRAME_H);

            // Gambar foto pengguna
            ctx.drawImage(croppedCanvas, 0, 0, FRAME_W, FRAME_H);

            // Muat dan gambar bingkai overlay transparan
            const frameImg = new Image();
            frameImg.crossOrigin = 'anonymous';
            frameImg.onload = function() {
                ctx.drawImage(frameImg, 0, 0, FRAME_W, FRAME_H);

                // Export gambar kualitas tinggi JPEG 95%
                const finalDataUrl = finalCanvas.toDataURL('image/jpeg', 0.95);

                // Tampilkan hasil di modal preview langsung
                currentDownloadUrl = finalDataUrl;
                document.getElementById('result-preview').src = finalDataUrl;

                const downloadBtn = document.getElementById('btn-real-download');
                downloadBtn.href = finalDataUrl;
                downloadBtn.setAttribute('download', 'twibbon_<?= esc($campaign['slug']) ?>.jpg');

                document.getElementById('loading-modal').classList.add('hidden');
                document.getElementById('result-modal').classList.remove('hidden');

                // Trigger unduh otomatis ke browser
                const autoLink = document.createElement('a');
                autoLink.href = finalDataUrl;
                autoLink.download = 'twibbon_<?= esc($campaign['slug']) ?>.jpg';
                document.body.appendChild(autoLink);
                autoLink.click();
                document.body.removeChild(autoLink);

                // Kirim hasil akhir ke server untuk dicatat ke database & folder results
                const formData = new FormData();
                formData.append('campaign_id', '<?= $campaign['id'] ?>');
                formData.append('image_data', finalDataUrl);
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                fetch('<?= base_url('twibbon/process') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.download_url) {
                        currentDownloadUrl = data.download_url;
                        downloadBtn.href = data.download_url;
                    }
                })
                .catch(err => {
                    console.log('Background server sync:', err);
                });
            };

            frameImg.onerror = function() {
                document.getElementById('loading-modal').classList.add('hidden');
                alert('Gagal memuat bingkai twibbon.');
            };

            // Menggunakan gambar bingkai yang ada di halaman
            frameImg.src = document.getElementById('frame-overlay').src;
        }

        let currentDownloadUrl = '';

        function closeResultModal() {
            document.getElementById('result-modal').classList.add('hidden');
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeResultModal();
            }
        });

        // Quick Share to Social Media
        function shareToSocial(platform) {
            const title = <?= json_encode($campaign['title']) ?>;
            const text = 'Saya sudah memasang Twibbon Resmi "' + title + '" di <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>! Ayo pasang foto terbaikmu sekarang juga!';
            const pageUrl = window.location.href;

            switch (platform) {
                case 'whatsapp':
                    window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(text + '\n' + pageUrl), '_blank');
                    break;
                case 'facebook':
                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(pageUrl) + '&quote=' + encodeURIComponent(text), '_blank');
                    break;
                case 'twitter':
                    window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(pageUrl), '_blank');
                    break;
                case 'telegram':
                    window.open('https://t.me/share/url?url=' + encodeURIComponent(pageUrl) + '&text=' + encodeURIComponent(text), '_blank');
                    break;
                case 'native':
                    if (navigator.share) {
                        navigator.share({
                            title: 'Twibbon ' + title,
                            text: text,
                            url: pageUrl
                        }).catch(() => {});
                    } else {
                        navigator.clipboard.writeText(pageUrl).then(() => {
                            alert('Tautan kampanye twibbon berhasil disalin!');
                        }).catch(() => {
                            alert('Gagal menyalin tautan.');
                        });
                    }
                    break;
            }
        }
    </script>
</body>
</html>
