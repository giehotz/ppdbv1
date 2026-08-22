<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Buat Twibbon - <?= esc($campaign['title']) ?><?= $this->endSection() ?>

<?= $this->section('page_title') ?>Buat Twibbon<?= $this->endSection() ?>

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
<div class="max-w-5xl mx-auto pb-12 px-4">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">

        <!-- Editor -->
        <div class="md:col-span-6 flex flex-col items-center">
            <div class="relative w-full max-w-[420px] bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
                <div id="image-wrapper" class="w-full h-full absolute inset-0">
                    <img id="image-to-crop" src="" class="max-w-full hidden">
                </div>
                <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">
                <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center bg-white bg-opacity-95 hover:bg-opacity-100 cursor-pointer transition-all duration-200" onclick="document.getElementById('photo-input').click()">
                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 mb-4 shadow-sm border border-emerald-100">
                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                    </div>
                    <h4 class="text-gray-900 font-bold text-base">Pilih Foto Terbaik Anda</h4>
                    <p class="text-xs text-gray-500 mt-2 max-w-[240px]">Klik untuk mengunggah foto (PNG/JPG/WebP, maks. 5MB).</p>
                </div>
            </div>

            <div id="editor-controls" class="w-full max-w-[420px] grid grid-cols-4 gap-2 mt-4 hidden">
                <button onclick="zoom(0.1)" class="bg-white hover:bg-emerald-50 border border-gray-200 text-gray-700 py-2.5 rounded-xl transition flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Perbesar">
                    <i class="fas fa-search-plus"></i>
                </button>
                <button onclick="zoom(-0.1)" class="bg-white hover:bg-emerald-50 border border-gray-200 text-gray-700 py-2.5 rounded-xl transition flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Perkecil">
                    <i class="fas fa-search-minus"></i>
                </button>
                <button onclick="rotate(-90)" class="bg-white hover:bg-emerald-50 border border-gray-200 text-gray-700 py-2.5 rounded-xl transition flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Putar Kiri">
                    <i class="fas fa-undo"></i>
                </button>
                <button onclick="rotate(90)" class="bg-white hover:bg-emerald-50 border border-gray-200 text-gray-700 py-2.5 rounded-xl transition flex items-center justify-center gap-1 text-sm font-semibold shadow-sm" title="Putar Kanan">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>

        <!-- Info & Actions -->
        <div class="md:col-span-6 space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900"><?= esc($campaign['title']) ?></h2>
                <p class="text-gray-600 text-sm mt-3 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wider">Langkah-langkah:</h3>
                <ul class="text-sm text-gray-600 space-y-3">
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">1</span> Klik area di atas atau tombol "Pilih Foto" untuk mengunggah foto Anda.</li>
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">2</span> Geser, perbesar, atau putar foto agar pas dengan bingkai.</li>
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">3</span> Klik "Unduh Twibbon" untuk menyimpan hasilnya.</li>
                </ul>

                <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">

                <div class="flex gap-3 mt-4">
                    <button onclick="document.getElementById('photo-input').click()" class="flex-1 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-image"></i> <span id="btn-select-text">Pilih Foto</span>
                    </button>
                    <button id="btn-download" onclick="processTwibbon('<?= $campaign['id'] ?>', '<?= esc($campaign['slug'], 'js') ?>')" class="flex-1 bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-sm" disabled>
                        <i class="fas fa-download"></i> Unduh Twibbon
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl flex flex-col items-center text-center">
        <div class="w-14 h-14 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
        <h3 class="font-bold text-gray-900 text-lg">Memproses Twibbon</h3>
        <p class="text-xs text-gray-500 mt-2">Mohon tunggu, server sedang menggabungkan foto Anda dengan bingkai...</p>
    </div>
</div>

<!-- Result Modal -->
<div id="result-modal" class="fixed inset-0 z-50 bg-black/65 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl flex flex-col items-center">
        <h3 class="font-bold text-gray-900 text-xl text-center mb-4">Twibbon Berhasil Dibuat!</h3>
        <div class="w-full max-w-[280px] aspect-square rounded-xl overflow-hidden border shadow-inner mb-6">
            <img id="result-preview" src="" alt="Twibbon Result" class="w-full h-full object-contain">
        </div>
        <div class="w-full flex flex-col gap-3">
            <a id="btn-real-download" href="" download class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-center transition shadow-md flex items-center justify-center gap-2 text-sm">
                <i class="fas fa-cloud-download-alt"></i> Unduh Gambar
            </a>
            <button onclick="closeResultModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">
                Buat Ulang / Ganti Foto
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
const FRAME_W = <?= (int)($frame['width'] ?? 1080) ?>;
const FRAME_H = <?= (int)($frame['height'] ?? 1080) ?>;
const FRAME_RATIO = FRAME_W / FRAME_H;

let cropper = null;
let selectedFile = null;

function loadPhoto(event) {
    const files = event.target.files;
    if (!files || !files[0]) return;

    selectedFile = files[0];
    if (selectedFile.size > 5 * 1024 * 1024) {
        alert('Ukuran file foto maksimal 5MB.');
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

        if (cropper) cropper.destroy();

        cropper = new Cropper(img, {
            aspectRatio: FRAME_RATIO,
            viewMode: 1,
            autoCropArea: 1,
            background: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: false,
            cropBoxResizable: false,
            dragMode: 'move',
        });
    };
    reader.readAsDataURL(selectedFile);
}

function zoom(ratio) { if (cropper) cropper.zoom(ratio); }
function rotate(degree) { if (cropper) cropper.rotate(degree); }

function processTwibbon(campaignId, slug) {
    if (!cropper || !selectedFile) return;

    document.getElementById('loading-modal').classList.remove('hidden');

    const data = cropper.getData(true);
    const formData = new FormData();
    formData.append('photo', selectedFile);
    formData.append('campaign_id', campaignId);
    formData.append('x', data.x);
    formData.append('y', data.y);
    formData.append('width', data.width);
    formData.append('height', data.height);
    formData.append('rotate', data.rotate);

    fetch('<?= base_url('siswa/twibbon/process') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        document.getElementById('loading-modal').classList.add('hidden');
        if (res.status === 'success') {
            document.getElementById('result-preview').src = res.download_url;
            const btn = document.getElementById('btn-real-download');
            btn.href = res.download_url;
            btn.setAttribute('download', slug + '_twibbon.jpg');
            document.getElementById('result-modal').classList.remove('hidden');

            const link = document.createElement('a');
            link.href = res.download_url;
            link.download = slug + '_twibbon.jpg';
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
<?= $this->endSection() ?>
