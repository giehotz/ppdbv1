<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Upload Berkas<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">upload_file</span> Upload Berkas Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalWajib = count($requiredDocs);
$totalUploaded = count($uploadedBerkas);
$percentComplete = $totalWajib > 0 ? round(($totalUploaded / $totalWajib) * 100) : 0;

$docIcons = [
    'kk' => 'family_restroom',
    'akte' => 'child_care',
    'ijazah' => 'school',
    'foto' => 'account_box',
    'ktp_ortu' => 'badge',
    'kip' => 'card_membership',
    'surat_pindah' => 'move_to_inbox',
];
?>

<!-- Header Summary & Progress Banner (TailAdmin Card Style) -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
        
        <div class="flex items-start sm:items-center gap-4 flex-1">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 border border-brand-200/60 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-2xl">folder_shared</span>
            </div>

            <div class="space-y-1 flex-1">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                    Kelengkapan Dokumen Pendaftaran
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                    Unggah seluruh dokumen persyaratan asli dalam format foto/scan yang jelas untuk diverifikasi oleh panitia.
                </p>
                <div class="pt-1 flex flex-wrap items-center gap-3 text-[11px] font-medium text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs text-brand-500">picture_as_pdf</span>
                        Format: JPG, PNG, PDF
                    </span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs text-brand-500">speed</span>
                        Maksimal 2 MB / file
                    </span>
                </div>
            </div>
        </div>

        <!-- Progress Widget -->
        <div class="shrink-0 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40 p-4 min-w-[200px]">
            <div class="flex items-center justify-between text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                <span>Progress Unggah</span>
                <span class="font-mono text-brand-600 dark:text-brand-400 font-bold"><?= $totalUploaded ?> / <?= $totalWajib ?> Berkas</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden mb-1.5">
                <div class="h-2 rounded-full transition-all duration-700 <?= $percentComplete == 100 ? 'bg-emerald-500' : 'bg-brand-500' ?>" style="width: <?= $percentComplete ?>%"></div>
            </div>
            <p class="text-[10px] text-right font-medium <?= $percentComplete == 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' ?>">
                <?= $percentComplete == 100 ? 'Dokumen Wajib Lengkap ✓' : 'Sisa ' . ($totalWajib - $totalUploaded) . ' berkas belum diunggah' ?>
            </p>
        </div>

    </div>
</div>

<!-- Document List Grid -->
<div class="space-y-4">
    <?php foreach ($requiredDocs as $jenis => $label): ?>
        <?php
        $isUploaded = isset($uploadedBerkas[$jenis]);
        $berkasItem = $isUploaded ? $uploadedBerkas[$jenis] : null;
        $iconName = $docIcons[$jenis] ?? 'description';
        $statusVerif = $berkasItem['status_verifikasi'] ?? 'pending';
        ?>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="p-5 md:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-5">

                <!-- 1. Document Info & Badges -->
                <div class="flex items-start gap-4 flex-1">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl shrink-0 <?= $isUploaded ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400' ?>">
                        <span class="material-symbols-outlined text-2xl"><?= $iconName ?></span>
                    </div>

                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">
                                <?= esc($label) ?>
                            </h4>
                            
                            <?php if ($isUploaded): ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    Terunggah
                                </span>

                                <?php if ($statusVerif === 'valid'): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                        <span class="material-symbols-outlined text-[12px]">verified</span>
                                        Valid
                                    </span>
                                <?php elseif ($statusVerif === 'invalid'): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[10px] font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                        <span class="material-symbols-outlined text-[12px]">error</span>
                                        Ditolak
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-[10px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-[12px]">hourglass_empty</span>
                                        Menunggu Review
                                    </span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                    <span class="material-symbols-outlined text-[12px]">warning</span>
                                    Wajib Diunggah
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if ($isUploaded): ?>
                            <?php 
                            $ext = strtolower(pathinfo($berkasItem['nama_file'], PATHINFO_EXTENSION));
                            $fileSizeKb = !empty($berkasItem['ukuran_file']) ? number_format($berkasItem['ukuran_file'] / 1024, 1) : '-';
                            ?>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <span class="truncate max-w-[200px] sm:max-w-xs font-semibold text-gray-700 dark:text-gray-300" title="<?= esc($berkasItem['nama_file']) ?>">
                                    <?= esc($berkasItem['nama_file']) ?>
                                </span>
                                <span>•</span>
                                <span><?= $fileSizeKb ?> KB</span>
                                <span>•</span>
                                <span class="uppercase font-bold text-brand-600 dark:text-brand-400"><?= $ext ?></span>
                            </div>

                            <?php if (!empty($berkasItem['catatan']) && $statusVerif === 'invalid'): ?>
                                <div class="mt-1 flex items-start gap-1.5 text-xs text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 p-2 rounded-lg border border-red-200 dark:border-red-900/50">
                                    <span class="material-symbols-outlined text-sm shrink-0">info</span>
                                    <span><strong>Catatan Verifikator:</strong> <?= esc($berkasItem['catatan']) ?></span>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                Berkas belum diunggah. Silakan pilih file dokumen asli Anda.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 2. Action Area -->
                <div class="w-full lg:w-auto shrink-0">
                    <?php if ($isUploaded): ?>
                        <!-- State: Uploaded Controls -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <?php
                                $fileUrl = base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $berkasItem['nama_file']);
                                $isPdf = ($ext === 'pdf') ? 'true' : 'false';
                                ?>

                                <!-- Preview Button -->
                                <button type="button"
                                    onclick="openPreview('<?= $fileUrl ?>', '<?= esc($label) ?>', <?= $isPdf ?>)"
                                    class="inline-flex items-center justify-center gap-1.5 h-9 rounded-xl border border-gray-200 bg-white px-3.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 shadow-theme-xs transition-colors"
                                    title="Lihat Berkas">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                    <span>Lihat</span>
                                </button>

                                <!-- Replace Toggle Button -->
                                <button type="button"
                                    onclick="document.getElementById('form-replace-<?= $jenis ?>').classList.toggle('hidden')"
                                    class="inline-flex items-center justify-center gap-1.5 h-9 rounded-xl border border-amber-200 bg-amber-50 px-3.5 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 shadow-theme-xs transition-colors"
                                    title="Ganti Berkas">
                                    <span class="material-symbols-outlined text-base">sync</span>
                                    <span>Ganti</span>
                                </button>

                                <!-- Delete Form -->
                                <form action="<?= base_url('siswa/berkas/delete/' . $berkasItem['id_berkas']) ?>" method="post"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas <?= esc($label) ?>?');" class="inline">
                                    <?= csrf_field() ?>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400 shadow-theme-xs transition-colors"
                                        title="Hapus Berkas">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Replace Form (Hidden Toggle) -->
                            <div id="form-replace-<?= $jenis ?>" class="hidden mt-2 p-3 rounded-xl border border-gray-200 bg-gray-50/80 dark:border-gray-700 dark:bg-gray-800/60">
                                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form space-y-2">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                                            class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-500 file:text-white hover:file:bg-brand-600 cursor-pointer">
                                        <button type="submit" class="inline-flex items-center justify-center gap-1 h-8 rounded-lg bg-gray-900 px-3 text-xs font-bold text-white hover:bg-black dark:bg-brand-500 dark:hover:bg-brand-600 shrink-0 shadow-theme-xs">
                                            <span>Unggah Pengganti</span>
                                        </button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="upload-progress hidden pt-1">
                                        <div class="flex items-center justify-between text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1">
                                            <span class="upload-status">Mengupload...</span>
                                            <span class="upload-percent font-mono">0%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="upload-bar bg-brand-500 h-1.5 rounded-full transition-all duration-200" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- State: Empty Upload Input -->
                        <div class="w-full lg:min-w-[320px]">
                            <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <div class="flex-1">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                                            class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-1">
                                    </div>
                                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 h-10 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 text-xs font-bold text-white shadow-theme-xs transition-colors shrink-0">
                                        <span class="material-symbols-outlined text-base">cloud_upload</span>
                                        <span>Upload</span>
                                    </button>
                                </div>

                                <!-- Progress Bar -->
                                <div class="upload-progress hidden mt-2">
                                    <div class="flex items-center justify-between text-[11px] font-bold text-gray-500 dark:text-gray-400 mb-1">
                                        <span class="upload-status">Mengupload berkas...</span>
                                        <span class="upload-percent font-mono text-brand-600 dark:text-brand-400">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                        <div class="upload-bar bg-brand-500 h-2 rounded-full transition-all duration-200" style="width: 0%"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Preview Berkas (TailAdmin Style) -->
<div id="previewModal" class="fixed inset-0 z-99999 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4 lg:p-6 transition-opacity">
    <div class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2" id="previewTitle">
                <span class="material-symbols-outlined text-brand-500">visibility</span>
                <span>Preview Berkas</span>
            </h3>
            <button type="button" onclick="closePreview()" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <div class="flex-1 overflow-auto bg-gray-100 dark:bg-gray-950 flex items-center justify-center p-4 relative min-h-[400px]" id="previewContent">
            <!-- Content Injected via JS -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.berkas-upload-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const progressWrapper = this.querySelector('.upload-progress');
            if (!progressWrapper) return this.submit();

            const progressBar = progressWrapper.querySelector('.upload-bar');
            const percentText = progressWrapper.querySelector('.upload-percent');
            const statusText = progressWrapper.querySelector('.upload-status');

            // Disable button during upload
            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-base animate-spin">progress_activity</span><span>Mengunggah...</span>';
            progressWrapper.classList.remove('hidden');
            progressBar.style.width = '0%';

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const pct = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = pct + '%';
                    percentText.textContent = pct + '%';
                    if (pct < 100) {
                        statusText.textContent = 'Mengupload berkas...';
                    } else {
                        statusText.textContent = 'Memproses & menyimpan file...';
                    }
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    statusText.textContent = 'Upload berhasil!';
                    progressBar.style.width = '100%';
                    progressBar.classList.remove('bg-brand-500');
                    progressBar.classList.add('bg-emerald-500');
                    percentText.textContent = '100%';
                    setTimeout(function() { window.location.reload(); }, 600);
                } else {
                    statusText.textContent = 'Upload gagal!';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });

            xhr.addEventListener('error', function() {
                statusText.textContent = 'Koneksi terputus saat upload.';
                progressBar.classList.remove('bg-brand-500');
                progressBar.classList.add('bg-red-500');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });

            xhr.open('POST', form.action, true);
            xhr.send(formData);
        });
    });
});

function openPreview(url, title, isPdf) {
    const titleEl = document.getElementById('previewTitle');
    titleEl.innerHTML = `<span class="material-symbols-outlined text-brand-500">visibility</span> <span>Preview: ${title}</span>`;
    const content = document.getElementById('previewContent');
    
    content.innerHTML = '<div class="flex flex-col items-center justify-center text-gray-400 gap-2"><span class="material-symbols-outlined text-3xl animate-spin text-brand-500">progress_activity</span><span class="text-xs font-semibold">Memuat Dokumen...</span></div>';
    
    if (isPdf) {
        content.innerHTML = `<iframe src="${url}" class="w-full h-[70vh] rounded-xl border border-gray-200 dark:border-gray-800 bg-white"></iframe>`;
    } else {
        content.innerHTML = `<img src="${url}" class="max-w-full max-h-[70vh] rounded-xl object-contain shadow-theme-sm bg-white p-2 border border-gray-200 dark:border-gray-800">`;
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