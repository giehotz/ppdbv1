<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Twibbon - <?= esc($campaign['title']) ?> - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?></title>
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

    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (TailAdmin tokens) -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    
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
            background-color: rgba(0, 0, 0, 0.1) !important;
            opacity: 0.8 !important;
        }
        .bg-checkerboard {
            background-color: #f9fafb;
            background-image: 
                linear-gradient(45deg, #e5e7eb 25%, transparent 25%), 
                linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), 
                linear-gradient(45deg, transparent 75%, #e5e7eb 75%), 
                linear-gradient(-45deg, transparent 75%, #e5e7eb 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-gray-50 text-gray-900 antialiased">

    <!-- Top Navbar -->
    <header class="w-full bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200 shadow-theme-xs">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="<?= base_url('twibbon') ?>" class="flex items-center gap-2.5">
                <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-8 w-auto">
                <?php else: ?>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white font-bold shadow-theme-xs">
                        <span class="material-symbols-outlined text-lg">school</span>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="text-sm sm:text-base font-extrabold text-gray-900 tracking-tight block leading-none"><?= esc($web['app_name'] ?? 'PPDB Online') ?></span>
                    <span class="text-[10px] text-gray-500"><?= esc($web['nama_sekolah'] ?? 'Portal PPDB') ?></span>
                </div>
            </a>
            
            <a href="<?= base_url('twibbon') ?>" 
               class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-theme-xs transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Daftar Kampanye</span>
            </a>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 py-8 sm:py-10 px-4 max-w-5xl w-full mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Column 1: Editor Canvas -->
            <div class="md:col-span-6 flex flex-col items-center">
                <div class="relative w-full max-w-[420px] bg-checkerboard rounded-2xl shadow-theme-md overflow-hidden border border-gray-200" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
                    
                    <!-- User Image Container -->
                    <div id="image-wrapper" class="w-full h-full absolute inset-0">
                        <img id="image-to-crop" src="" class="max-w-full hidden">
                    </div>

                    <!-- Frame PNG Overlay -->
                    <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">

                    <!-- Empty State Upload Trigger -->
                    <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center cursor-pointer transition-all duration-200 bg-white/90 hover:bg-white/95 backdrop-blur-xs" onclick="document.getElementById('photo-input').click()">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 mb-3 shadow-theme-xs border border-brand-200/60">
                            <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900">Pilih Foto Terbaik Anda</h4>
                        <p class="text-[11px] text-gray-500 mt-1 max-w-[240px]">Klik di sini untuk mengunggah foto wajah (PNG, JPG, WebP maks. 5MB).</p>
                    </div>
                </div>

                <!-- Control Buttons -->
                <div id="editor-controls" class="w-full max-w-[420px] grid grid-cols-4 gap-2 mt-3 hidden">
                    <button type="button" onclick="zoom(0.1)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 shadow-theme-xs" title="Perbesar">
                        <span class="material-symbols-outlined text-lg">zoom_in</span>
                    </button>
                    <button type="button" onclick="zoom(-0.1)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 shadow-theme-xs" title="Perkecil">
                        <span class="material-symbols-outlined text-lg">zoom_out</span>
                    </button>
                    <button type="button" onclick="rotate(-90)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 shadow-theme-xs" title="Putar Kiri">
                        <span class="material-symbols-outlined text-lg">rotate_left</span>
                    </button>
                    <button type="button" onclick="rotate(90)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 shadow-theme-xs" title="Putar Kanan">
                        <span class="material-symbols-outlined text-lg">rotate_right</span>
                    </button>
                </div>
            </div>

            <!-- Column 2: Information & Processing -->
            <div class="md:col-span-6 space-y-5">
                
                <!-- Campaign Description -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs space-y-2">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 leading-tight"><?= esc($campaign['title']) ?></h2>
                    <p class="text-xs sm:text-sm text-gray-500 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
                </div>

                <!-- Steps Guide -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 pb-2 border-b border-gray-100">
                        Panduan Penggunaan
                    </h3>

                    <div class="space-y-3 text-xs text-gray-600">
                        <div class="flex items-start gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-brand-50 text-brand-600 font-bold text-xs shrink-0">1</span>
                            <span class="mt-0.5">Klik area bingkai di sebelah kiri atau tombol <b>Pilih Foto</b> untuk mengunggah foto Anda.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-brand-50 text-brand-600 font-bold text-xs shrink-0">2</span>
                            <span class="mt-0.5">Geser, perbesar, atau putar foto hingga posisinya pas di dalam lubang bingkai twibbon.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-brand-50 text-brand-600 font-bold text-xs shrink-0">3</span>
                            <span class="mt-0.5">Klik tombol <b>Unduh Twibbon</b> untuk memproses dan menyimpan hasil gambar ke perangkat Anda.</span>
                        </div>
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">
                    
                    <div class="flex gap-2.5 pt-2">
                        <button type="button" onclick="document.getElementById('photo-input').click()" 
                                class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white py-3 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-theme-xs transition-colors">
                            <span class="material-symbols-outlined text-base">photo_library</span>
                            <span id="btn-select-text">Pilih Foto</span>
                        </button>
                        
                        <button type="button" id="btn-download" onclick="processTwibbon()" 
                                class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 disabled:opacity-40 disabled:cursor-not-allowed text-white py-3 text-xs font-bold shadow-theme-xs transition-colors" disabled>
                            <span class="material-symbols-outlined text-base">download</span>
                            <span>Unduh Twibbon</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Modal Loading Overlay -->
    <div id="loading-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl p-8 max-w-xs w-full shadow-2xl flex flex-col items-center text-center">
            <span class="material-symbols-outlined text-4xl animate-spin text-brand-500 mb-2">progress_activity</span>
            <h3 class="font-bold text-gray-900 text-sm">Memproses Twibbon</h3>
            <p class="text-[11px] text-gray-400 mt-1">Sedang menggabungkan foto Anda dengan bingkai resmi...</p>
        </div>
    </div>

    <!-- Modal Success / Hasil -->
    <div id="result-modal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl flex flex-col items-center">
            <h3 class="font-bold text-gray-900 text-base text-center mb-3 flex items-center gap-1.5 text-emerald-600">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                Twibbon Berhasil Dibuat!
            </h3>
            
            <div class="w-full max-w-[260px] aspect-square rounded-xl overflow-hidden border border-gray-200 shadow-inner mb-4 bg-gray-50">
                <img id="result-preview" src="" alt="Twibbon Result" class="w-full h-full object-cover">
            </div>

            <div class="w-full flex flex-col gap-2">
                <a id="btn-real-download" href="" download class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 text-xs shadow-theme-xs transition-colors">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span>Unduh Gambar</span>
                </a>
                <button type="button" onclick="closeResultModal()" class="w-full inline-flex items-center justify-center py-2 text-xs font-semibold text-gray-500 hover:text-gray-700">
                    Buat Ulang / Ganti Foto
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-gray-500">
            <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Cropper.js & Script -->
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
                        autoCropArea: 1,
                        background: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        dragMode: 'move',
                        zoom: function(event) {
                            if (event.detail.ratio < 0.1) {
                                event.preventDefault();
                            }
                        }
                    });
                };
                reader.readAsDataURL(selectedFile);
            }
        }

        function zoom(ratio) {
            if (cropper) cropper.zoom(ratio);
        }

        function rotate(degree) {
            if (cropper) cropper.rotate(degree);
        }

        function processTwibbon() {
            if (!cropper || !selectedFile) return;

            document.getElementById('loading-modal').classList.remove('hidden');

            const data = cropper.getData(true);
            const formData = new FormData();
            formData.append('photo', selectedFile);
            formData.append('campaign_id', '<?= $campaign['id'] ?>');
            formData.append('x', data.x);
            formData.append('y', data.y);
            formData.append('width', data.width);
            formData.append('height', data.height);
            formData.append('rotate', data.rotate);

            fetch('<?= base_url('twibbon/process') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(res => {
                document.getElementById('loading-modal').classList.add('hidden');

                if (res.status === 'success') {
                    document.getElementById('result-preview').src = res.download_url;
                    
                    const downloadBtn = document.getElementById('btn-real-download');
                    downloadBtn.href = res.download_url;
                    downloadBtn.setAttribute('download', '<?= esc($campaign['slug']) ?>_twibbon.jpg');

                    document.getElementById('result-modal').classList.remove('hidden');

                    const link = document.createElement('a');
                    link.href = res.download_url;
                    link.download = 'twibbon_<?= esc($campaign['slug']) ?>.jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                } else {
                    alert('Error: ' + res.message);
                }
            })
            .catch(err => {
                document.getElementById('loading-modal').classList.add('hidden');
                alert('Terjadi kesalahan koneksi server.');
                console.error(err);
            });
        }

        function closeResultModal() {
            document.getElementById('result-modal').classList.add('hidden');
        }
    </script>
</body>
</html>
