<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Buat Twibbon - <?= esc($campaign['title']) ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">auto_fix_high</span> Buat Twibbon
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .cropper-container { width: 100% !important; height: 100% !important; }
    .cropper-view-box, .cropper-face { border-radius: 0%; outline: none !important; }
    .cropper-line, .cropper-point { display: none !important; }
    .cropper-modal { background-color: rgba(0,0,0,0.1) !important; opacity: 0.8 !important; }
    #editor-container { max-width: 420px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Editor Area (Left) -->
        <div class="lg:col-span-6 flex flex-col items-center">
            <div class="relative w-full max-w-[420px] bg-gray-50 dark:bg-gray-900 rounded-2xl shadow-theme-md overflow-hidden border border-gray-200 dark:border-gray-800" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
                <div id="image-wrapper" class="w-full h-full absolute inset-0">
                    <img id="image-to-crop" src="" class="max-w-full hidden">
                </div>
                <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">
                
                <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center bg-white/95 dark:bg-gray-900/95 hover:bg-white dark:hover:bg-gray-900 cursor-pointer transition-all duration-200" onclick="document.getElementById('photo-input').click()">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 mb-3 shadow-theme-xs border border-brand-200/60 dark:border-brand-500/20">
                        <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pilih Foto Anda</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-[220px]">Klik untuk mengunggah foto (PNG/JPG/WebP, maks. 5MB).</p>
                </div>
            </div>

            <!-- Editor Controls -->
            <div id="editor-controls" class="w-full max-w-[420px] grid grid-cols-4 gap-2 mt-4 hidden">
                <button type="button" onclick="zoom(0.1)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors" title="Perbesar">
                    <span class="material-symbols-outlined text-base">zoom_in</span>
                </button>
                <button type="button" onclick="zoom(-0.1)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors" title="Perkecil">
                    <span class="material-symbols-outlined text-base">zoom_out</span>
                </button>
                <button type="button" onclick="rotate(-90)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors" title="Putar Kiri">
                    <span class="material-symbols-outlined text-base">rotate_left</span>
                </button>
                <button type="button" onclick="rotate(90)" class="inline-flex items-center justify-center h-10 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors" title="Putar Kanan">
                    <span class="material-symbols-outlined text-base">rotate_right</span>
                </button>
            </div>
        </div>

        <!-- Info & Actions Area (Right) -->
        <div class="lg:col-span-6 space-y-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?= esc($campaign['title']) ?></h3>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Petunjuk Penggunaan:</h4>
                <ul class="text-xs text-gray-600 dark:text-gray-300 space-y-2.5">
                    <li class="flex items-start gap-2.5">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-[10px] shrink-0 mt-0.5">1</span>
                        <span>Klik bingkai atau tombol <strong>Pilih Foto</strong> untuk memasukkan foto Anda.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-[10px] shrink-0 mt-0.5">2</span>
                        <span>Geser, perbesar (*zoom*), atau putar foto agar pas dengan posisi bingkai.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-[10px] shrink-0 mt-0.5">3</span>
                        <span>Klik <strong>Unduh Twibbon</strong> untuk memproses dan menyimpan hasil gambar.</span>
                    </li>
                </ul>

                <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">

                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <button type="button" onclick="document.getElementById('photo-input').click()"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white py-3 px-4 text-xs font-bold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors">
                        <span class="material-symbols-outlined text-base">photo_library</span>
                        <span id="btn-select-text">Pilih Foto</span>
                    </button>
                    
                    <button type="button" id="btn-download" onclick="processTwibbon('<?= $campaign['id'] ?>', '<?= esc($campaign['slug'], 'js') ?>')"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 py-3 px-4 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors disabled:opacity-40 disabled:cursor-not-allowed" disabled>
                        <span class="material-symbols-outlined text-base">download</span>
                        <span>Unduh Twibbon</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 z-9999 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 max-w-xs w-full shadow-2xl border border-gray-200 dark:border-gray-800 text-center flex flex-col items-center">
        <span class="material-symbols-outlined text-4xl animate-spin text-brand-500 mb-3">progress_activity</span>
        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Memproses Twibbon</h4>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Menggabungkan foto Anda dengan bingkai resolusi tinggi...</p>
    </div>
</div>

<!-- Result Modal -->
<div id="result-modal" class="fixed inset-0 z-9999 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col items-center">
        <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 mb-4">
            <span class="material-symbols-outlined text-xl">verified</span>
            <h4 class="text-base font-bold text-gray-900 dark:text-white">Twibbon Siap Diunduh!</h4>
        </div>

        <div class="w-full max-w-[260px] aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 mb-5">
            <img id="result-preview" src="" alt="Twibbon Result" class="w-full h-full object-contain">
        </div>

        <div class="w-full space-y-2">
            <a id="btn-save-image" href="#" download="twibbon-<?= esc($campaign['slug']) ?>.png"
               class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 py-3 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                <span class="material-symbols-outlined text-base">download</span>
                <span>Simpan Gambar</span>
            </a>
            <button type="button" onclick="closeResultModal()"
                    class="w-full inline-flex items-center justify-center py-2.5 text-xs font-semibold text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper = null;
const frameWidth = <?= (int)($frame['width'] ?? 1080) ?>;
const frameHeight = <?= (int)($frame['height'] ?? 1080) ?>;

function loadPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const image = document.getElementById('image-to-crop');
        image.src = e.target.result;
        image.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
        document.getElementById('editor-controls').classList.remove('hidden');
        document.getElementById('btn-download').disabled = false;
        document.getElementById('btn-select-text').textContent = 'Ganti Foto';

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {
            aspectRatio: frameWidth / frameHeight,
            viewMode: 0,
            dragMode: 'move',
            autoCropArea: 1,
            restore: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            toggleDragModeOnDblclick: false,
        });
    };
    reader.readAsDataURL(file);
}

function zoom(ratio) {
    if (cropper) cropper.zoom(ratio);
}

function rotate(degree) {
    if (cropper) cropper.rotate(degree);
}

function processTwibbon(campaignId, slug) {
    if (!cropper) return;

    document.getElementById('loading-modal').classList.remove('hidden');

    const cropData = cropper.getData(true);
    const canvas = cropper.getCroppedCanvas({
        width: frameWidth,
        height: frameHeight,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });

    const croppedBase64 = canvas.toDataURL('image/png');

    fetch('<?= base_url('siswa/twibbon/process') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
        },
        body: JSON.stringify({
            campaign_id: campaignId,
            image_data: croppedBase64
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('loading-modal').classList.add('hidden');
        if (data.success && data.image_url) {
            document.getElementById('result-preview').src = data.image_url;
            document.getElementById('btn-save-image').href = data.image_url;
            document.getElementById('result-modal').classList.remove('hidden');
        } else {
            alert(data.message || 'Gagal memproses twibbon.');
        }
    })
    .catch(err => {
        document.getElementById('loading-modal').classList.add('hidden');
        alert('Terjadi kesalahan saat memproses gambar.');
    });
}

function closeResultModal() {
    document.getElementById('result-modal').classList.add('hidden');
}
</script>

<?= $this->endSection() ?>
