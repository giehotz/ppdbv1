<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Upload Berkas
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Upload Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="flex items-center p-3 mb-4 text-emerald-800 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-check-circle mr-2 text-emerald-500"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-3 mb-4 text-rose-800 bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-exclamation-triangle mr-2 text-rose-500"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Info Box Glass -->
<div class="bg-blue-50/80 backdrop-blur-sm border-l-4 border-blue-400 p-3 mb-4 rounded-xl">
    <div class="flex items-start">
        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-2"></i>
        <p class="text-[10px] text-blue-700">
            <strong>Petunjuk:</strong> Upload file JPG, PNG, atau PDF (max 2MB).
        </p>
    </div>
</div>

<!-- Document Upload Cards -->
<div class="space-y-3">
    <?php foreach ($requiredDocs as $jenis => $label): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-bold text-slate-800 flex items-center">
                    <i class="fas fa-file-alt text-emerald-600 mr-2"></i>
                    <?= $label ?>
                </h3>
                <?php if (isset($uploadedBerkas[$jenis])): ?>
                    <span class="px-2 py-1 bg-emerald-100/80 text-emerald-700 text-[10px] font-bold rounded-full flex items-center border border-emerald-200/30">
                        <i class="fas fa-check-circle mr-1"></i>Uploaded
                    </span>
                <?php else: ?>
                    <span class="px-2 py-1 bg-slate-100/80 text-slate-500 text-[10px] font-bold rounded-full flex items-center border border-slate-200/30">
                        <i class="fas fa-exclamation-circle mr-1"></i>Belum
                    </span>
                <?php endif; ?>
            </div>

            <?php if (isset($uploadedBerkas[$jenis])): ?>
                <!-- Display uploaded file -->
                <div class="bg-slate-50/60 backdrop-blur-sm rounded-xl p-3 mb-3 border border-slate-200/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 flex-1 min-w-0">
                            <div class="w-9 h-9 bg-emerald-100/80 rounded-xl flex items-center justify-center flex-shrink-0">
                                <?php
                                $ext = pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION);
                                if ($ext == 'pdf'):
                                ?>
                                    <i class="fas fa-file-pdf text-rose-600 text-base"></i>
                                <?php else: ?>
                                    <i class="fas fa-file-image text-emerald-600 text-base"></i>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[10px] font-semibold text-slate-800 truncate"><?= $uploadedBerkas[$jenis]['nama_file'] ?></p>
                                <p class="text-[10px] text-slate-500"><?= number_format($uploadedBerkas[$jenis]['ukuran_file'] / 1024, 2) ?> KB</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-2">
                            <?php 
                                $fileUrl = base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $uploadedBerkas[$jenis]['nama_file']);
                                $isPdf = (strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION)) == 'pdf') ? 'true' : 'false';
                            ?>
                            <button type="button" onclick="openPreview('<?= $fileUrl ?>', '<?= esc($label) ?>', <?= $isPdf ?>)" class="w-7 h-7 flex items-center justify-center bg-blue-100/80 text-blue-600 rounded-xl hover:bg-blue-200/80 active:scale-90 transition">
                                <i class="fas fa-eye text-[11px]"></i>
                            </button>
                            <form action="<?= base_url('siswa/berkas/delete/' . $uploadedBerkas[$jenis]['id_berkas']) ?>" method="post" class="inline" data-confirm="Yakin hapus berkas ini?">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-7 h-7 flex items-center justify-center bg-rose-100/80 text-rose-600 rounded-xl hover:bg-rose-200/80 active:scale-90 transition">
                                    <i class="fas fa-trash text-[11px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Replace file form -->
                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">

                    <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-[10px] text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-semibold file:bg-emerald-50/80 file:text-emerald-700 file:active:bg-emerald-100/80">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold py-2 rounded-xl transition text-xs active:scale-[0.97]">
                        <i class="fas fa-sync-alt mr-1"></i>Ganti File
                    </button>
                </form>
            <?php else: ?>
                <!-- Upload form -->
                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">

                    <div class="border-2 border-dashed border-slate-200/80 rounded-xl p-4 text-center bg-slate-50/30">
                        <i class="fas fa-cloud-upload-alt text-xl text-slate-300 mb-2"></i>
                        <p class="text-[10px] text-slate-500 mb-2">Tap untuk memilih file</p>
                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-[10px] text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-semibold file:bg-emerald-50/80 file:text-emerald-700 file:active:bg-emerald-100/80" required>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold py-2 rounded-xl transition text-xs active:scale-[0.97]">
                        <i class="fas fa-upload mr-1"></i>Upload <?= $label ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Preview Berkas -->
<div id="previewModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl w-full max-w-3xl overflow-hidden flex flex-col shadow-2xl" style="max-height: 90vh;">
        <div class="flex justify-between items-center p-4 border-b border-slate-100/50">
            <h3 class="font-bold text-slate-800 text-sm" id="previewTitle">Preview Berkas</h3>
            <button type="button" onclick="closePreview()" class="w-7 h-7 flex items-center justify-center rounded-full bg-slate-100/80 text-slate-600 hover:bg-rose-100/80 hover:text-rose-600 transition-colors active:scale-90">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="flex-1 overflow-auto bg-slate-50/30 flex items-center justify-center p-4 relative" id="previewContent">
            <!-- Content injected via JS -->
        </div>
    </div>
</div>

<style>
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down { animation: fadeInDown 0.3s ease-out forwards; }
</style>

<script>
function openPreview(url, title, isPdf) {
    document.getElementById('previewTitle').textContent = title;
    const content = document.getElementById('previewContent');
    
    content.innerHTML = '<div class="absolute inset-0 flex items-center justify-center text-slate-400"><i class="fas fa-circle-notch fa-spin text-2xl"></i></div>';
    
    if (isPdf) {
        content.innerHTML += `<iframe src="${url}" class="w-full rounded-xl border border-slate-200/50 relative z-10 bg-white" style="height: 70vh;" onload="this.previousSibling.style.display='none'"></iframe>`;
    } else {
        content.innerHTML += `<img src="${url}" class="max-w-full rounded-xl object-contain relative z-10 shadow-sm" style="max-height: 70vh;" onload="this.previousSibling.style.display='none'">`;
    }
    
    document.getElementById('previewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
    document.getElementById('previewContent').innerHTML = '';
    document.body.style.overflow = 'auto';
}
</script>

<?= $this->endSection() ?>
