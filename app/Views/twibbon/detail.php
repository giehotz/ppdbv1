<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Twibbon - <?= esc($campaign['title']) ?> - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?></title>
    <meta name="description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">

    <!-- Open Graph / Facebook / WhatsApp / Telegram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Buat Twibbon - <?= esc($campaign['title']) ?>">
    <meta property="og:description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">
    <meta property="og:image" content="<?= base_url($frame['file_path']) ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="<?= esc($frame['width'] ?? '1080') ?>">
    <meta property="og:image:height" content="<?= esc($frame['height'] ?? '1080') ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= current_url() ?>">
    <meta name="twitter:title" content="Buat Twibbon - <?= esc($campaign['title']) ?>">
    <meta name="twitter:description" content="<?= esc(strip_tags($campaign['description'] ?: 'Ikut serta dalam kampanye twibbon kami dengan memasang foto profil Anda di bingkai ini.')) ?>">
    <meta name="twitter:image" content="<?= base_url($frame['file_path']) ?>">

    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        /* Cropper customizations to hide default UI and lay it behind frame */
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
<body class="min-h-screen flex flex-col justify-between">

    <!-- Top Navbar -->
    <header class="w-full glass sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="<?= base_url('twibbon') ?>" class="flex items-center gap-2">
                <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-8 w-auto">
                <?php endif; ?>
                <span class="text-xl font-extrabold text-emerald-800 tracking-tight"><?= esc($web['app_name'] ?? 'PPDB Online') ?></span>
            </a>
            <a href="<?= base_url('twibbon') ?>" class="text-emerald-700 hover:text-emerald-950 font-bold text-sm flex items-center gap-1">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 py-10 px-4 max-w-5xl w-full mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Column 1: Editor Canvas -->
            <div class="md:col-span-6 flex flex-col items-center">
                <div class="relative w-full max-w-[420px] bg-checkerboard rounded-2xl shadow-xl overflow-hidden border border-emerald-100" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
                    
                    <!-- User Image Container -->
                    <div id="image-wrapper" class="w-full h-full absolute inset-0">
                        <img id="image-to-crop" src="" class="max-w-full hidden">
                    </div>

                    <!-- Frame PNG Overlay (Stops pointer events so we can drag the cropper underneath) -->
                    <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">

                    <!-- Empty State Upload Trigger (Placed on top of the frame overlay with a semi-transparent white background) -->
                    <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center cursor-pointer transition-all duration-200 hover:bg-white/80" style="background-color: rgba(255, 255, 255, 0.75);" onclick="document.getElementById('photo-input').click()">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 mb-4 shadow-sm border border-emerald-100">
                            <i class="fas fa-cloud-upload-alt text-2xl"></i>
                        </div>
                        <h4 class="text-emerald-900 font-bold text-base">Pilih Foto Terbaik Anda</h4>
                        <p class="text-xs text-emerald-700 mt-2 max-w-[240px] opacity-80">Klik di sini untuk mengunggah foto wajah (PNG, JPG, JPEG, atau WebP, maks. 5MB).</p>
                    </div>
                </div>

                <!-- Control Buttons (Hidden until image selected) -->
                <div id="editor-controls" class="w-full max-w-[420px] grid grid-cols-4 gap-2 mt-4 hidden">
                    <button onclick="zoom(0.1)" class="bg-white hover:bg-emerald-50 border border-emerald-100 text-emerald-800 py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Perbesar">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button onclick="zoom(-0.1)" class="bg-white hover:bg-emerald-50 border border-emerald-100 text-emerald-800 py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Perkecil">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button onclick="rotate(-90)" class="bg-white hover:bg-emerald-50 border border-emerald-100 text-emerald-800 py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Putar Kiri">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button onclick="rotate(90)" class="bg-white hover:bg-emerald-50 border border-emerald-100 text-emerald-800 py-2.5 rounded-xl transition duration-150 flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Putar Kanan">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>

            <!-- Column 2: Information & Processing -->
            <div class="md:col-span-6 space-y-6">
                <div class="glass rounded-2xl p-6 shadow-md">
                    <h2 class="text-2xl font-bold text-emerald-950 leading-tight"><?= esc($campaign['title']) ?></h2>
                    <p class="text-emerald-900 text-sm mt-3 opacity-80 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
                </div>

                <div class="glass rounded-2xl p-6 shadow-md space-y-4">
                    <h3 class="text-sm font-extrabold uppercase text-emerald-800 tracking-wider">Langkah-langkah:</h3>
                    <ul class="text-xs text-emerald-900 space-y-2.5 opacity-90">
                        <li class="flex gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center font-bold text-[10px] shrink-0 text-emerald-800">1</span> <span>Klik area kotak di sebelah kiri atau tombol "Pilih Foto" untuk mengunggah foto Anda.</span></li>
                        <li class="flex gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center font-bold text-[10px] shrink-0 text-emerald-800">2</span> <span>Gunakan mouse/touch untuk menggeser, memperbesar, atau memutar foto agar posisinya pas dengan lubang bingkai.</span></li>
                        <li class="flex gap-2.5"><span class="w-5 h-5 rounded-full bg-emerald-100 border border-emerald-300 flex items-center justify-center font-bold text-[10px] shrink-0 text-emerald-800">3</span> <span>Klik tombol "Unduh Twibbon" untuk menyimpan hasilnya di perangkat Anda.</span></li>
                    </ul>

                    <!-- File input -->
                    <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">
                    
                    <div class="flex gap-3 mt-6">
                        <button onclick="document.getElementById('photo-input').click()" class="flex-1 bg-white hover:bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold py-3.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-sm text-sm">
                            <i class="fas fa-image"></i> <span id="btn-select-text">Pilih Foto</span>
                        </button>
                        <button id="btn-download" onclick="processTwibbon()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-400 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-md text-sm" disabled>
                            <i class="fas fa-download"></i> Unduh Twibbon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Loading Overlay -->
    <div id="loading-modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl flex flex-col items-center text-center">
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
            <h3 class="font-bold text-emerald-950 text-lg">Memproses Twibbon Anda</h3>
            <p class="text-xs text-emerald-800 mt-2 opacity-80">Mohon tunggu beberapa detik, server sedang menggabungkan foto Anda dengan bingkai...</p>
        </div>
    </div>

    <!-- Modal Success / Hasil -->
    <div id="result-modal" class="fixed inset-0 z-50 bg-black bg-opacity-65 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl flex flex-col items-center">
            <h3 class="font-bold text-emerald-950 text-xl text-center mb-4">Twibbon Berhasil Dibuat!</h3>
            
            <div class="w-full max-w-[280px] aspect-square rounded-xl overflow-hidden border shadow-inner mb-6 relative">
                <img id="result-preview" src="" alt="Twibbon Result" class="w-full h-full object-cover">
            </div>

            <div class="w-full flex flex-col gap-3">
                <a id="btn-real-download" href="" download class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-center transition duration-200 shadow-md flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-cloud-download-alt"></i> Unduh Gambar
                </a>
                <button onclick="closeResultModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl transition duration-200 text-sm">
                    Buat Ulang / Ganti Foto
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full glass py-6 border-t mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-emerald-800 opacity-75">
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
                
                // Validate size (5MB)
                if (selectedFile.size > 5 * 1024 * 1024) {
                    alert('Ukuran file foto terlalu besar. Maksimal 5MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('image-to-crop');
                    img.src = e.target.result;
                    img.classList.remove('hidden');

                    // Hide placeholder and show controls
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('editor-controls').classList.remove('hidden');
                    document.getElementById('btn-download').removeAttribute('disabled');
                    document.getElementById('btn-select-text').innerText = 'Ganti Foto';

                    // Destroy old cropper if exists
                    if (cropper) {
                        cropper.destroy();
                    }

                    // Initialize Cropper.js
                    cropper = new Cropper(img, {
                        aspectRatio: FRAME_RATIO,
                        viewMode: 0, // Allow zooming out smaller than crop box
                        autoCropArea: 1, // Crop box is maximum width/height of container
                        background: false,
                        guides: false,
                        center: false,
                        highlight: false,
                        cropBoxMovable: false,
                        cropBoxResizable: false,
                        dragMode: 'move', // Allow panning the image
                        zoom: function(event) {
                            // Prevent zoom out below 10% (0.1 ratio) of the original image
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
            if (cropper) {
                cropper.zoom(ratio);
            }
        }

        function rotate(degree) {
            if (cropper) {
                cropper.rotate(degree);
            }
        }

        function processTwibbon() {
            if (!cropper || !selectedFile) return;

            // Show loading modal
            document.getElementById('loading-modal').classList.remove('hidden');

            const data = cropper.getData(true); // Get integer crop details
            const formData = new FormData();
            formData.append('photo', selectedFile);
            formData.append('campaign_id', '<?= $campaign['id'] ?>');
            formData.append('x', data.x);
            formData.append('y', data.y);
            formData.append('width', data.width);
            formData.append('height', data.height);
            formData.append('rotate', data.rotate);

            // Fetch AJAX Request
            fetch('<?= base_url('twibbon/process') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(res => {
                // Hide loading modal
                document.getElementById('loading-modal').classList.add('hidden');

                if (res.status === 'success') {
                    // Set up result preview & download link
                    document.getElementById('result-preview').src = res.download_url;
                    
                    const downloadBtn = document.getElementById('btn-real-download');
                    downloadBtn.href = res.download_url;
                    downloadBtn.setAttribute('download', '<?= esc($campaign['slug']) ?>_twibbon.jpg');

                    // Show success modal
                    document.getElementById('result-modal').classList.remove('hidden');

                    // Trigger auto download
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
