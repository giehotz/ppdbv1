<!-- Tab: Berkas -->
<div id="content-berkas" class="tab-content hidden pt-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800">Upload Dokumen Pendukung</h3>
        <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full border border-gray-200">
            <i class="fas fa-file-signature mr-1"></i> Data Kelengkapan
        </span>
    </div>

    <!-- Alert Petunjuk: Menggunakan Flex untuk layout internal -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-5 mb-8 rounded-r-xl shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-bold text-blue-900 mb-1">Petunjuk Upload Dokumen:</h4>
                <ul class="text-sm text-blue-800 space-y-1 opacity-90">
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-xs"></i> Format file yang didukung: <span class="font-bold ml-1 text-blue-900 underline decoration-blue-300">JPG, PNG, atau PDF</span></li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-xs"></i> Ukuran maksimal per file adalah <span class="font-bold ml-1 text-blue-900">2MB</span></li>
                    <li class="flex items-center"><i class="fas fa-check-circle mr-2 text-xs"></i> Pastikan hasil scan dokumen terlihat jelas dan tidak terpotong</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Wrapper List Berkas dengan Grid 1 Kolom -->
    <div class="grid grid-cols-1 gap-5">
        <?php foreach ($requiredDocs as $jenis => $label): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:border-blue-400 hover:shadow-md transition-all duration-300 group">
                
                <!-- Main Grid Container: 12 Kolom pada layar besar -->
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-6 p-5">
                    
                    <!-- SISI KIRI: Informasi Dokumen (Col: 5) -->
                    <div class="lg:col-span-5 flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-500 group-hover:border-blue-100 transition-colors shrink-0 shadow-inner">
                            <i class="fas <?= isset($uploadedBerkas[$jenis]) ? 'fa-file-check' : 'fa-file-upload' ?> text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-base font-bold text-gray-800 leading-tight mb-1 truncate" title="<?= $label ?>">
                                <?= $label ?>
                            </h4>
                            <div class="flex items-center">
                                <?php if (isset($uploadedBerkas[$jenis])): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700 border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i> Terupload
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-200">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Wajib Upload
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: Action Area (Col: 7) -->
                    <div class="lg:col-span-7 h-full flex flex-col justify-center">
                        <?php if (isset($uploadedBerkas[$jenis])): ?>
                            <!-- STATE: FILE SUDAH ADA -->
                            <div class="flex flex-col md:flex-row items-center gap-4 bg-gray-50 p-3 rounded-xl border border-gray-100 group-hover:bg-white group-hover:border-blue-100 transition-all">
                                
                                <!-- Preview Info -->
                                <div class="flex items-center flex-1 min-w-0 w-full">
                                    <?php 
                                        $ext = strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION));
                                        $iconClass = ($ext == 'pdf') ? 'fa-file-pdf text-red-500' : 'fa-file-image text-blue-500';
                                    ?>
                                    <div class="w-10 h-10 rounded bg-white flex items-center justify-center shadow-sm shrink-0 mr-3">
                                        <i class="fas <?= $iconClass ?> text-xl"></i>
                                    </div>
                                    <div class="truncate">
                                        <p class="text-xs font-bold text-gray-700 truncate mb-0.5" title="<?= $uploadedBerkas[$jenis]['nama_file'] ?>">
                                            <?= $uploadedBerkas[$jenis]['nama_file'] ?>
                                        </p>
                                        <p class="text-[10px] text-gray-500 font-medium">
                                            Ukuran: <?= number_format($uploadedBerkas[$jenis]['ukuran_file'] / 1024, 1) ?> KB
                                        </p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2 shrink-0 w-full md:w-auto justify-end border-t md:border-t-0 pt-3 md:pt-0 border-gray-200">
                                    <a href="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $uploadedBerkas[$jenis]['nama_file']) ?>" 
                                       target="_blank" 
                                       class="flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all shadow-sm"
                                       title="Lihat Berkas">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button type="button" 
                                            onclick="document.getElementById('form-ganti-<?= $jenis ?>').classList.toggle('hidden')" 
                                            class="flex items-center justify-center w-9 h-9 bg-white border border-gray-200 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg transition-all shadow-sm"
                                            title="Ganti Berkas">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>

                                    <form action="<?= base_url('siswa/berkas/delete/' . $uploadedBerkas[$jenis]['id_berkas']) ?>" 
                                          method="post" 
                                          class="inline" 
                                          data-confirm="Apakah Anda yakin ingin menghapus dokumen ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" 
                                                class="flex items-center justify-center w-9 h-9 bg-white border border-red-100 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all shadow-sm"
                                                title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Form Ganti (Hidden Grid) -->
                            <div id="form-ganti-<?= $jenis ?>" class="hidden mt-3 p-4 bg-amber-50 rounded-xl border-2 border-dashed border-amber-200 animate-fadeIn">
                                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form flex flex-col sm:flex-row items-center gap-3">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                    <div class="w-full flex-1">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" 
                                               class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-200 file:text-amber-800 hover:file:bg-amber-300 cursor-pointer" required>
                                    </div>
                                    <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                                        Update File
                                    </button>
                                </form>
                                <!-- Progress Bar for Replace -->
                                <div class="upload-progress hidden mt-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-bold text-amber-700 upload-status">Mengupload...</span>
                                        <span class="text-xs font-bold text-amber-700 upload-percent">0%</span>
                                    </div>
                                    <div class="w-full bg-amber-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="upload-bar bg-gradient-to-r from-amber-400 to-amber-600 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- STATE: BELUM UPLOAD (Empty Card Grid) -->
                            <div class="relative group/upload">
                                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                        <div class="sm:col-span-3">
                                            <div class="relative flex items-center">
                                                <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" 
                                                       class="block w-full text-sm text-gray-500 border border-gray-300 rounded-xl
                                                              file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0
                                                              file:text-xs file:font-black file:bg-blue-600 file:text-white
                                                              hover:file:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-all" required>
                                            </div>
                                        </div>
                                        <button type="submit" 
                                                class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-black py-2.5 px-4 rounded-xl text-xs uppercase tracking-widest transition-all duration-300 shadow-sm flex justify-center items-center">
                                            <i class="fas fa-cloud-upload-alt mr-2 text-base"></i> Upload
                                        </button>
                                    </div>
                                </form>
                                <!-- Progress Bar for New Upload -->
                                <div class="upload-progress hidden mt-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-bold text-blue-700 upload-status">Mengupload...</span>
                                        <span class="text-xs font-bold text-blue-700 upload-percent">0%</span>
                                    </div>
                                    <div class="w-full bg-blue-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="upload-bar bg-gradient-to-r from-blue-400 to-blue-600 h-2.5 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div> <!-- End Grid Parent -->
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease-out forwards;
}
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
    document.querySelectorAll('#content-berkas .berkas-upload-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const container = this.closest('.relative, [class*="form-ganti"]') || this.parentElement;
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