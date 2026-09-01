<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Upload Berkas<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dokumen Persyaratan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <!-- Header Notice -->
    <div class="rounded-2xl border border-brand-200 bg-brand-50/60 p-3.5 dark:border-brand-900/40 dark:bg-brand-950/20 text-xs flex items-start gap-2.5">
        <span class="material-symbols-outlined text-brand-600 dark:text-brand-400 text-lg mt-0.5 shrink-0">info</span>
        <p class="text-brand-800 dark:text-brand-300 text-[11px] leading-relaxed">
            Unggah dokumen asli / fotokopi legalisir dalam format <strong>PDF, JPG, atau PNG</strong> (maksimal 2MB per berkas).
        </p>
    </div>

    <!-- Document Cards -->
    <div class="space-y-3">
        <?php foreach ($requiredDocs as $jenis => $label): ?>
            <?php $isUploaded = isset($uploadedBerkas[$jenis]); ?>
            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
                
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="material-symbols-outlined text-base <?= $isUploaded ? 'text-emerald-500' : 'text-gray-400' ?>">
                            <?= $isUploaded ? 'task' : 'description' ?>
                        </span>
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate"><?= esc($label) ?></h4>
                    </div>

                    <?php if ($isUploaded): ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 shrink-0">
                            <span class="material-symbols-outlined text-xs">check_circle</span> Terunggah
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 shrink-0">
                            <span class="material-symbols-outlined text-xs">warning</span> Belum
                        </span>
                    <?php endif; ?>
                </div>

                <?php if ($isUploaded): ?>
                    <!-- Uploaded File Card -->
                    <?php 
                    $fileUrl = base_url('uploads/berkas/' . rawurlencode($siswa['nisn']) . '/' . rawurlencode($uploadedBerkas[$jenis]['nama_file']));
                    $ext = strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION));
                    $isPdf = ($ext === 'pdf');
                    ?>
                    <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-2.5 dark:border-gray-800 dark:bg-gray-850/40 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="material-symbols-outlined text-xl text-brand-500 shrink-0"><?= $isPdf ? 'picture_as_pdf' : 'image' ?></span>
                            <div class="min-w-0">
                                <p class="text-xs font-mono font-bold text-gray-800 dark:text-gray-200 truncate"><?= esc($uploadedBerkas[$jenis]['nama_file']) ?></p>
                                <span class="text-[10px] text-gray-400"><?= number_format(($uploadedBerkas[$jenis]['ukuran_file'] ?? 0) / 1024, 1) ?> KB</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="<?= $fileUrl ?>" target="_blank" rel="noopener"
                               class="flex h-7 w-7 items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-700 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                            <form action="<?= base_url('siswa/berkas/delete/' . $uploadedBerkas[$jenis]['id_berkas']) ?>" method="post"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');" class="inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 border border-red-200 text-red-600 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400 shadow-theme-xs">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Replace form trigger -->
                    <details class="text-xs">
                        <summary class="cursor-pointer text-[11px] font-semibold text-amber-600 hover:underline">Ganti dengan file baru...</summary>
                        <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="mt-2 space-y-2">
                            <?= csrf_field() ?>
                            <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                            <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                                class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-500 file:text-white cursor-pointer">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1 rounded-lg bg-brand-500 py-1.5 text-xs font-bold text-white shadow-theme-xs">
                                <span>Unggah File Baru</span>
                            </button>
                        </form>
                    </details>

                <?php else: ?>
                    <!-- Upload form -->
                    <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
                        <?= csrf_field() ?>
                        <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                            class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 cursor-pointer rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-0.5">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1 rounded-xl bg-brand-500 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                            <span class="material-symbols-outlined text-sm">cloud_upload</span>
                            <span>Upload Dokumen</span>
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>
