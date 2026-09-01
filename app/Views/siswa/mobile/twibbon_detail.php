<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Buat Twibbon<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Editor Twibbon<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .cropper-container { width: 100% !important; height: 100% !important; }
    .cropper-view-box, .cropper-face { border-radius: 0%; outline: none !important; }
    .cropper-line, .cropper-point { display: none !important; }
    .cropper-modal { background-color: rgba(0,0,0,0.1) !important; opacity: 0.8 !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <!-- Campaign info -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-xs font-bold text-gray-900 dark:text-white"><?= esc($campaign['title']) ?></h3>
        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
    </div>

    <!-- Canvas Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
        <div class="relative w-full rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
            <div id="image-wrapper" class="w-full h-full absolute inset-0">
                <img id="image-to-crop" src="" class="max-w-full hidden">
            </div>
            <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">
            
            <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center bg-white/95 dark:bg-gray-900/95 cursor-pointer transition-all" onclick="document.getElementById('photo-input').click()">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 mb-2 border border-brand-200/60 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-2xl">add_photo_alternate</span>
                </div>
                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Pilih Foto</h4>
                <p class="text-[10px] text-gray-400 mt-0.5">PNG / JPG / WebP (maks. 5MB)</p>
            </div>
        </div>

        <!-- Controls -->
        <div id="editor-controls" class="grid grid-cols-4 gap-1.5 hidden pt-1">
            <button type="button" onclick="zoom(0.1)" class="inline-flex items-center justify-center h-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-base">zoom_in</span>
            </button>
            <button type="button" onclick="zoom(-0.1)" class="inline-flex items-center justify-center h-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-base">zoom_out</span>
            </button>
            <button type="button" onclick="rotate(-90)" class="inline-flex items-center justify-center h-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-base">rotate_left</span>
            </button>
            <button type="button" onclick="rotate(90)" class="inline-flex items-center justify-center h-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-base">rotate_right</span>
            </button>
        </div>
    </div>

    <!-- Actions -->
    <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">
    <div class="flex gap-2">
        <button type="button" onclick="document.getElementById('photo-input').click()"
            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white py-3 text-xs font-bold text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <span class="material-symbols-outlined text-base">photo_library</span>
            <span id="btn-select-text">Pilih Foto</span>
        </button>
        <button type="button" id="btn-download" onclick="processTwibbon('<?= $campaign['id'] ?>', '<?= esc($campaign['slug'], 'js') ?>')"
            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 py-3 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 disabled:opacity-40 disabled:cursor-not-allowed" disabled>
            <span class="material-symbols-outlined text-base">download</span>
            <span>Unduh</span>
        </button>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 z-9999 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 max-w-xs w-full shadow-2xl text-center flex flex-col items-center">
        <span class="material-symbols-outlined text-4xl animate-spin text-brand-500 mb-2">progress_activity</span>
        <h4 class="text-xs font-bold text-gray-900 dark:text-white">Memproses Twibbon</h4>
        <p class="text-[10px] text-gray-400 mt-0.5">Sedang menggabungkan foto dengan bingkai...</p>
    </div>
</div>

<!-- Result Modal -->
<div id="result-modal" class="fixed inset-0 z-9999 bg-black/70 backdrop-blur-sm flex items-center justify-center hidden p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 max-w-xs w-full shadow-2xl flex flex-col items-center">
        <h4 class="text-xs font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-1 text-emerald-600">
            <span class="material-symbols-outlined text-base">check_circle</span>
            Twibbon Siap!
        </h4>
        <div class="w-full max-w-[200px] aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 mb-4 bg-gray-50 dark:bg-gray-800">
            <img id="result-preview" src="" alt="Result" class="w-full h-full object-contain">
        </div>
        <div class="w-full space-y-1.5">
            <a id="btn-real-download" href="#" download="twibbon-<?= esc($campaign['slug']) ?>.png"
               class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700">
                <span class="material-symbols-outlined text-base">download</span>
                <span>Simpan Gambar</span>
            </a>
            <button type="button" onclick="closeResultModal()"
                    class="w-full inline-flex items-center justify-center py-2 text-xs font-semibold text-gray-500">
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

        if (cropper) cropper.destroy();

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

function zoom(ratio) { if (cropper) cropper.zoom(ratio); }
function rotate(degree) { if (cropper) cropper.rotate(degree); }

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
            document.getElementById('btn-real-download').href = data.image_url;
            document.getElementById('result-modal').classList.remove('hidden');
        } else {
            alert(data.message || 'Gagal memproses twibbon.');
        }
    })
    .catch(err => {
        document.getElementById('loading-modal').classList.add('hidden');
        alert('Terjadi kesalahan saat memproses twibbon.');
    });
}

function closeResultModal() {
    document.getElementById('result-modal').classList.add('hidden');
}
</script>

<?= $this->endSection() ?>
