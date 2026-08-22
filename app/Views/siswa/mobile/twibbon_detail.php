<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Buat Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Buat Twibbon<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .cropper-container { width: 100% !important; height: 100% !important; }
    .cropper-view-box, .cropper-face { border-radius: 0%; outline: none !important; }
    .cropper-line, .cropper-point { display: none !important; }
    .cropper-modal { background-color: rgba(0,0,0,0.1) !important; opacity: 0.8 !important; }

    .scroll-x { -webkit-overflow-scrolling: touch; scrollbar-width: none; }
    .scroll-x::-webkit-scrollbar { display: none; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pb-4">

    <!-- Campaign Info Glass -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-4 mb-4">
        <h2 class="font-bold text-slate-900 text-sm"><?= esc($campaign['title']) ?></h2>
        <p class="text-[10px] text-slate-500 mt-1.5 leading-relaxed"><?= nl2br(esc($campaign['description'])) ?></p>
    </div>

    <!-- Editor Canvas Glass -->
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 overflow-hidden mb-4">
        <div class="relative w-full editor-box" id="editor-container" style="aspect-ratio: <?= (int)($frame['width'] ?? 1) ?> / <?= (int)($frame['height'] ?? 1) ?>">
            <div id="image-wrapper" class="w-full h-full absolute inset-0">
                <img id="image-to-crop" src="" class="max-w-full hidden">
            </div>
            <img src="<?= base_url($frame['file_path']) ?>" alt="Frame" id="frame-overlay" class="absolute inset-0 w-full h-full object-contain z-20 pointer-events-none">
            <div id="upload-placeholder" class="absolute inset-0 z-30 flex flex-col items-center justify-center p-6 text-center bg-white/95 backdrop-blur-sm cursor-pointer active:bg-white/100 transition-all" onclick="document.getElementById('photo-input').click()">
                <div class="w-14 h-14 bg-emerald-50/80 rounded-full flex items-center justify-center text-emerald-600 mb-3 border border-emerald-200/50">
                    <i class="fas fa-cloud-upload-alt text-xl"></i>
                </div>
                <h4 class="text-slate-900 font-bold text-sm">Pilih Foto</h4>
                <p class="text-[10px] text-slate-500 mt-1 px-4">PNG, JPG, WebP — maks. 5MB</p>
            </div>
        </div>

        <!-- Controls Glass -->
        <div id="editor-controls" class="scroll-x flex gap-2 px-4 py-3 overflow-x-auto hidden bg-slate-50/30 border-t border-slate-200/20">
            <button onclick="zoom(0.1)" class="shrink-0 bg-white/60 backdrop-blur-sm active:bg-emerald-100/80 text-slate-700 px-4 py-2.5 rounded-xl transition text-[10px] font-semibold flex items-center gap-1.5 border border-slate-200/30 active:scale-95">
                <i class="fas fa-search-plus"></i> Perbesar
            </button>
            <button onclick="zoom(-0.1)" class="shrink-0 bg-white/60 backdrop-blur-sm active:bg-emerald-100/80 text-slate-700 px-4 py-2.5 rounded-xl transition text-[10px] font-semibold flex items-center gap-1.5 border border-slate-200/30 active:scale-95">
                <i class="fas fa-search-minus"></i> Perkecil
            </button>
            <button onclick="rotate(-90)" class="shrink-0 bg-white/60 backdrop-blur-sm active:bg-emerald-100/80 text-slate-700 px-4 py-2.5 rounded-xl transition text-[10px] font-semibold flex items-center gap-1.5 border border-slate-200/30 active:scale-95">
                <i class="fas fa-undo"></i> Kiri
            </button>
            <button onclick="rotate(90)" class="shrink-0 bg-white/60 backdrop-blur-sm active:bg-emerald-100/80 text-slate-700 px-4 py-2.5 rounded-xl transition text-[10px] font-semibold flex items-center gap-1.5 border border-slate-200/30 active:scale-95">
                <i class="fas fa-redo"></i> Kanan
            </button>
        </div>
    </div>

    <!-- Actions -->
    <input type="file" id="photo-input" accept="image/*" class="hidden" onchange="loadPhoto(event)">
    <div class="flex gap-3">
        <button onclick="document.getElementById('photo-input').click()" class="flex-1 bg-white/80 backdrop-blur-md border border-slate-200/50 text-slate-700 font-semibold py-3.5 rounded-xl active:bg-slate-50/80 transition text-xs flex items-center justify-center gap-2 shadow-sm active:scale-[0.97]">
            <i class="fas fa-image"></i> <span id="btn-select-text">Pilih Foto</span>
        </button>
        <button id="btn-download" onclick="processTwibbon('<?= $campaign['id'] ?>', '<?= esc($campaign['slug'], 'js') ?>')" disabled class="flex-1 bg-emerald-600 disabled:bg-slate-300/80 disabled:cursor-not-allowed text-white font-semibold py-3.5 rounded-xl active:bg-emerald-700 transition text-xs flex items-center justify-center gap-2 shadow-sm active:scale-[0.97]">
            <i class="fas fa-download"></i> Unduh
        </button>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden">
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-8 max-w-xs w-full mx-6 shadow-2xl flex flex-col items-center text-center">
        <div class="w-12 h-12 border-[3px] border-emerald-200 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
        <p class="font-semibold text-slate-900 text-sm">Memproses...</p>
        <p class="text-[10px] text-slate-500 mt-1">Menggabungkan foto dengan bingkai</p>
    </div>
</div>

<!-- Result Modal -->
<div id="result-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden px-4">
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl p-5 max-w-sm w-full shadow-2xl flex flex-col items-center">
        <h3 class="font-bold text-slate-900 text-sm text-center mb-3">Berhasil Dibuat!</h3>
        <div class="w-full max-w-[220px] aspect-square rounded-xl overflow-hidden border border-slate-200/50 shadow-inner mb-4">
            <img id="result-preview" src="" alt="Result" class="w-full h-full object-contain">
        </div>
        <a id="btn-real-download" href="" download class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl text-center transition active:bg-emerald-700 shadow-sm flex items-center justify-center gap-2 text-xs mb-2 active:scale-[0.97]">
            <i class="fas fa-cloud-download-alt"></i> Unduh
        </a>
        <button onclick="closeResultModal()" class="w-full bg-slate-100/80 backdrop-blur-sm active:bg-slate-200/80 text-slate-700 font-semibold py-3 rounded-xl transition text-xs active:scale-[0.97]">
            Buat Ulang
        </button>
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
        alert('Ukuran file maksimal 5MB.');
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
        document.getElementById('btn-select-text').innerText = 'Ganti';
        if (cropper) cropper.destroy();
        cropper = new Cropper(img, {
            aspectRatio: FRAME_RATIO, viewMode: 1, autoCropArea: 1,
            background: false, guides: false, center: false, highlight: false,
            cropBoxMovable: false, cropBoxResizable: false, dragMode: 'move',
        });
    };
    reader.readAsDataURL(selectedFile);
}
function zoom(r) { if (cropper) cropper.zoom(r); }
function rotate(d) { if (cropper) cropper.rotate(d); }

function processTwibbon(campaignId, slug) {
    if (!cropper || !selectedFile) return;
    document.getElementById('loading-modal').classList.remove('hidden');
    const data = cropper.getData(true);
    const fd = new FormData();
    fd.append('photo', selectedFile);
    fd.append('campaign_id', campaignId);
    fd.append('x', data.x);
    fd.append('y', data.y);
    fd.append('width', data.width);
    fd.append('height', data.height);
    fd.append('rotate', data.rotate);
    fetch('<?= base_url('siswa/twibbon/process') ?>', {
        method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
        } else alert('Error: ' + res.message);
    })
    .catch(() => {
        document.getElementById('loading-modal').classList.add('hidden');
        alert('Koneksi gagal. Coba lagi.');
    });
}
function closeResultModal() { document.getElementById('result-modal').classList.add('hidden'); }
</script>
<?= $this->endSection() ?>
