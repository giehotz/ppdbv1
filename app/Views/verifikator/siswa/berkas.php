<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Lengkapi Berkas Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pendaftaran Siswa Offline<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-5xl mx-auto mb-8">
    <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Langkah 3: Unggah Berkas</h2>
            <p class="text-slate-500 text-sm mt-1">Siswa: <span class="font-bold text-blue-600"><?= esc($siswa['nama_lengkap']) ?></span> (<?= esc($siswa['nisn']) ?>)</p>
        </div>
        <div class="hidden sm:flex text-sm font-semibold text-slate-400 gap-4">
            <span class="text-green-600"><i class="fas fa-check-circle"></i> Akun</span>
            <span class="text-green-600"><i class="fas fa-check-circle"></i> Biodata</span>
            <span class="text-blue-600 border-b-2 border-blue-600 pb-1">3. Berkas</span>
            <span>4. Selesai</span>
        </div>
    </div>
</div>

<!-- Notification Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="flex items-center p-4 mb-6 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl animate-fade-in">
        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 mr-3">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
        <p class="text-sm font-bold"><?= session()->getFlashdata('success') ?></p>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-4 mb-6 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl animate-fade-in">
        <div class="flex-shrink-0 w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 mr-3">
            <i class="fas fa-exclamation-triangle text-xl"></i>
        </div>
        <p class="text-sm font-bold"><?= session()->getFlashdata('error') ?></p>
    </div>
<?php endif; ?>

<!-- Instructions Banner -->
<div class="relative overflow-hidden bg-emerald-900 rounded-2xl shadow-lg mb-8 group">
    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500 opacity-20 rounded-full -mr-16 -mt-16 blur-2xl"></div>
    <div class="relative p-6 flex flex-col md:flex-row items-center gap-6">
        <div class="hidden md:flex w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md items-center justify-center text-emerald-300 border border-white/20 shadow-inner">
            <i class="fas fa-lightbulb text-2xl"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-white font-extrabold text-lg mb-1">Panduan Unggah Dokumen</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-emerald-100/80 text-xs mt-3">
                <div class="flex items-center gap-2">
                    <i class="fas fa-file-pdf text-emerald-400"></i> Format: <strong class="text-emerald-50">JPG, PNG, PDF</strong>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-weight-hanging text-emerald-400"></i> Ukuran Maks: <strong class="text-emerald-50">2 MB</strong>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-eye text-emerald-400"></i> Kualitas: <strong class="text-emerald-50">Harus Terbaca</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="space-y-6">
    <?php foreach ($requiredDocs as $jenis => $label): ?>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="p-6 md:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-8">

                <!-- 1. Document Info & Status -->
                <div class="flex-1">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 <?= isset($uploadedBerkas[$jenis]) ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' ?>">
                            <i class="fas <?= isset($uploadedBerkas[$jenis]) ? 'fa-file-signature' : 'fa-file-upload' ?> text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800"><?= $label ?></h3>
                            <div class="mt-2 flex items-center gap-2">
                                <?php if (isset($uploadedBerkas[$jenis])): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black tracking-widest uppercase bg-emerald-500 text-white shadow-sm shadow-emerald-200">
                                        <i class="fas fa-check-circle mr-1.5"></i> Terunggah
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">
                                        <?= strtoupper(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION)) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black tracking-widest uppercase bg-amber-500 text-white shadow-sm shadow-amber-200 animate-pulse">
                                        <i class="fas fa-exclamation-circle mr-1.5 text-[8px]"></i> Wajib Upload
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Form / Action Area -->
                <div class="w-full lg:w-auto">
                    <?php if (isset($uploadedBerkas[$jenis])): ?>
                        <!-- STATE: UPLOADED -->
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <div class="flex flex-col sm:flex-row items-center gap-5">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <?php $ext = strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION)); ?>
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm border border-slate-200">
                                        <i class="fas <?= $ext == 'pdf' ? 'fa-file-pdf text-rose-500' : 'fa-image text-blue-500' ?>"></i>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-sm font-bold text-slate-700 truncate max-w-[150px]" title="<?= $uploadedBerkas[$jenis]['nama_file'] ?>">
                                            <?= $uploadedBerkas[$jenis]['nama_file'] ?>
                                        </p>
                                        <p class="text-[10px] text-slate-400 font-medium">
                                            Ukuran: <?= number_format($uploadedBerkas[$jenis]['ukuran_file'] / 1024, 1) ?> KB
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <?php 
                                        $fileUrl = base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $uploadedBerkas[$jenis]['nama_file']);
                                        $isPdf = (strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION)) == 'pdf') ? 'true' : 'false';
                                    ?>
                                    <button type="button" onclick="openPreview('<?= $fileUrl ?>', '<?= esc($label) ?>', <?= $isPdf ?>)" class="flex-1 sm:flex-none inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:text-blue-600 hover:border-blue-200 p-2.5 rounded-xl text-sm transition-all duration-200 shadow-sm" title="Lihat Berkas">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button type="button" onclick="document.getElementById('form-replace-<?= $jenis ?>').classList.toggle('hidden')" class="flex-1 sm:flex-none inline-flex items-center justify-center bg-white border border-slate-200 text-slate-700 hover:text-amber-600 hover:border-amber-200 p-2.5 rounded-xl text-sm transition-all duration-200 shadow-sm" title="Ganti Berkas">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>

                                    <form action="<?= base_url('verifikator/siswa/berkasDelete/' . $siswa['id_siswa']) ?>" method="post" class="flex-1 sm:flex-none" data-confirm="Yakin ingin menghapus berkas ini?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_berkas" value="<?= $uploadedBerkas[$jenis]['id_berkas'] ?>">
                                        <button type="submit" class="w-full inline-flex items-center justify-center bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white p-2.5 rounded-xl text-sm transition-all duration-200 shadow-sm" title="Hapus Berkas">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div id="form-replace-<?= $jenis ?>" class="hidden mt-4 pt-4 border-t border-slate-200 animate-fade-in-down">
                                <form action="<?= base_url('verifikator/siswa/berkasUpload/' . $siswa['id_siswa']) ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form flex flex-col sm:flex-row items-center gap-3">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                    <div class="flex-1 w-full">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer" required>
                                    </div>
                                    <button type="submit" class="w-full sm:w-auto bg-slate-800 hover:bg-black text-white px-5 py-2 rounded-xl text-xs font-bold transition shadow-md whitespace-nowrap">
                                        Update Dokumen
                                    </button>
                                </form>
                                <!-- Progress Bar for Replace -->
                                <div class="upload-progress hidden mt-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-bold text-slate-700 upload-status">Mengupload...</span>
                                        <span class="text-xs font-bold text-slate-700 upload-percent">0%</span>
                                    </div>
                                    <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="upload-bar bg-gradient-to-r from-blue-400 to-blue-600 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- STATE: EMPTY (Enhanced Dropzone Area) -->
                        <div class="relative group">
                            <form action="<?= base_url('verifikator/siswa/berkasUpload/' . $siswa['id_siswa']) ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-6 hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-300">
                                <?= csrf_field() ?>
                                <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">

                                <div class="flex flex-col md:flex-row items-center gap-4">
                                    <div class="flex-1 w-full min-w-[200px]">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Pilih File Anda</label>
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-2xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-white file:text-blue-600 file:shadow-sm hover:file:bg-blue-50 cursor-pointer border border-slate-100 rounded-2xl transition-all" required>
                                    </div>
                                    <button type="submit" class="w-full md:w-auto mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 hover:scale-105 active:scale-95 text-white font-extrabold py-3.5 px-6 rounded-2xl text-xs uppercase tracking-widest transition-all duration-300 shadow-lg shadow-blue-200 flex justify-center items-center gap-2">
                                        <i class="fas fa-cloud-upload-alt text-base"></i> Upload
                                    </button>
                                </div>
                            </form>
                            <!-- Progress Bar for New Upload -->
                            <div class="upload-progress hidden mt-4">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-bold text-blue-700 upload-status">Mengupload...</span>
                                    <span class="text-xs font-bold text-blue-700 upload-percent">0%</span>
                                </div>
                                <div class="w-full bg-blue-100 rounded-full h-3 overflow-hidden">
                                    <div class="upload-bar bg-gradient-to-r from-blue-400 to-blue-600 h-3 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="flex justify-between items-center mt-8 pt-6 border-t border-slate-200 max-w-5xl mx-auto">
    <a href="<?= base_url('verifikator/siswa/biodata/' . $siswa['id_siswa']) ?>" class="flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-6 rounded-xl transition duration-200">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Biodata
    </a>

    <a href="<?= base_url('verifikator/siswa/cetak-akun/' . $siswa['id_siswa']) ?>" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-8 rounded-xl transition duration-200 shadow-md shadow-blue-600/30">
        Selesai & Cetak Informasi Akun <i class="fas fa-print ml-2"></i>
    </a>
</div>

<style>
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-10px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-down { animation: fade-in-down 0.3s ease-out; }
@keyframes progressPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
.upload-bar {
    animation: progressPulse 1.5s ease-in-out infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.berkas-upload-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const container = this.closest('.relative, .group, [id^="form-replace"]') || this.parentElement;
            const progressWrapper = container.querySelector('.upload-progress');
            const progressBar = progressWrapper.querySelector('.upload-bar');
            const percentText = progressWrapper.querySelector('.upload-percent');
            const statusText = progressWrapper.querySelector('.upload-status');

            // Disable form
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengupload...';
            progressWrapper.classList.remove('hidden');
            progressBar.style.width = '0%';

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const pct = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = pct + '%';
                    percentText.textContent = pct + '%';
                    if (pct < 100) {
                        statusText.textContent = 'Mengupload...';
                    } else {
                        statusText.textContent = 'Memproses file...';
                        progressBar.style.animation = 'none';
                    }
                }
            });

            xhr.addEventListener('load', function() {
                statusText.textContent = 'Upload berhasil!';
                progressBar.style.width = '100%';
                progressBar.classList.remove('from-blue-400', 'to-blue-600', 'from-amber-400', 'to-amber-600');
                progressBar.classList.add('from-emerald-400', 'to-emerald-600');
                progressBar.style.animation = 'none';
                percentText.textContent = '100%';
                setTimeout(function() { window.location.reload(); }, 800);
            });

            xhr.addEventListener('error', function() {
                statusText.textContent = 'Upload gagal! Silakan coba lagi.';
                progressBar.classList.remove('from-blue-400', 'to-blue-600', 'from-amber-400', 'to-amber-600');
                progressBar.classList.add('from-red-400', 'to-red-600');
                progressBar.style.animation = 'none';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-redo mr-2"></i> Coba Lagi';
            });

            xhr.open('POST', form.action, true);
            xhr.send(formData);
        });
    });
});
</script>

<!-- Modal Preview Berkas -->
<div id="previewModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 lg:p-10 transition-opacity">
    <div class="bg-white rounded-3xl w-full max-w-5xl overflow-hidden flex flex-col shadow-2xl animate-fade-in-down" style="max-height: 90vh;">
        <div class="flex justify-between items-center p-5 md:p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xl font-black text-slate-800 flex items-center gap-3" id="previewTitle">
                <i class="fas fa-eye text-blue-500"></i> Preview Berkas
            </h3>
            <button type="button" onclick="closePreview()" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all duration-200 shadow-sm">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="flex-1 overflow-auto bg-slate-100/50 flex items-center justify-center p-4 md:p-8 relative" id="previewContent">
            <!-- Content injected via JS -->
        </div>
    </div>
</div>

<script>
function openPreview(url, title, isPdf) {
    const titleEl = document.getElementById('previewTitle');
    titleEl.innerHTML = `<i class="fas fa-eye text-blue-500"></i> Preview: ${title}`;
    const content = document.getElementById('previewContent');
    
    // Loading state while iframe/image loads
    content.innerHTML = '<div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 gap-3"><i class="fas fa-circle-notch fa-spin text-4xl text-blue-500"></i><span class="text-sm font-bold animate-pulse">Memuat Dokumen...</span></div>';
    
    if (isPdf) {
        content.innerHTML += `<iframe src="${url}" class="w-full rounded-2xl border border-slate-200 relative z-10 bg-white shadow-sm" style="height: 75vh;" onload="this.previousSibling.style.display='none'"></iframe>`;
    } else {
        content.innerHTML += `<img src="${url}" class="max-w-full rounded-2xl object-contain relative z-10 shadow-sm bg-white p-2 border border-slate-200" style="max-height: 75vh;" onload="this.previousSibling.style.display='none'">`;
    }
    
    document.getElementById('previewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
    document.getElementById('previewContent').innerHTML = ''; // Clear iframe/image to free memory
    document.body.style.overflow = 'auto'; // Restore scrolling
}
</script>

<?= $this->endSection() ?>