<!-- Tab: Berkas -->
<div id="content-berkas" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Upload Dokumen Pendukung</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Unggah berkas asli dalam format PDF, JPG, atau PNG (Maks 2MB).</p>
        </div>
        <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
            <span class="material-symbols-outlined text-sm">verified_user</span>
            <span>Dokumen Wajib</span>
        </span>
    </div>

    <!-- Wrapper List Berkas -->
    <div class="space-y-3">
        <?php foreach ($requiredDocs as $jenis => $label): ?>
            <?php $isUploaded = isset($uploadedBerkas[$jenis]); ?>
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-theme-xs transition-all hover:border-brand-500/40 dark:border-gray-800 dark:bg-white/[0.02]">
                
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <!-- Dokumen Info -->
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl shrink-0 <?= $isUploaded ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' ?>">
                            <span class="material-symbols-outlined text-2xl"><?= $isUploaded ? 'task' : 'upload_file' ?></span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white truncate">
                                <?= esc($label) ?>
                            </h4>
                            <div class="flex items-center gap-2 mt-0.5">
                                <?php if ($isUploaded): ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                        <span class="material-symbols-outlined text-xs">check_circle</span> Terunggah
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 dark:text-amber-400">
                                        <span class="material-symbols-outlined text-xs">warning</span> Belum Diunggah
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Action Area -->
                    <div class="w-full lg:w-auto shrink-0">
                        <?php if ($isUploaded): ?>
                            <!-- File Controls -->
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <?php 
                                    $ext = strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION));
                                    $fileUrl = base_url('uploads/berkas/' . rawurlencode($siswa['nisn']) . '/' . rawurlencode($uploadedBerkas[$jenis]['nama_file']));
                                    ?>
                                    
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-400 font-mono">
                                        <span class="truncate max-w-[140px]" title="<?= esc($uploadedBerkas[$jenis]['nama_file']) ?>">
                                            <?= esc($uploadedBerkas[$jenis]['nama_file']) ?>
                                        </span>
                                        <span class="uppercase font-bold text-brand-600 dark:text-brand-400 text-[10px]"><?= $ext ?></span>
                                    </div>

                                    <a href="<?= $fileUrl ?>" target="_blank" rel="noopener"
                                       class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors"
                                       title="Lihat Berkas">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>

                                    <button type="button" 
                                            onclick="document.getElementById('form-ganti-<?= $jenis ?>').classList.toggle('hidden')" 
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 shadow-theme-xs transition-colors"
                                            title="Ganti Berkas">
                                        <span class="material-symbols-outlined text-base">sync</span>
                                    </button>

                                    <form action="<?= isset($berkasDeleteUrl) ? $berkasDeleteUrl . $uploadedBerkas[$jenis]['id_berkas'] : base_url('siswa/berkas/delete/' . $uploadedBerkas[$jenis]['id_berkas']) ?>" 
                                          method="post" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas ini?');"
                                          class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400 shadow-theme-xs transition-colors"
                                                title="Hapus Berkas">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Form Ganti (Hidden) -->
                                <div id="form-ganti-<?= $jenis ?>" class="hidden p-3 rounded-xl border border-gray-200 bg-gray-50/80 dark:border-gray-700 dark:bg-gray-800/60">
                                    <form action="<?= $berkasUploadUrl ?? base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                                               class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-500 file:text-white cursor-pointer">
                                        <button type="submit" class="inline-flex items-center justify-center h-8 rounded-lg bg-gray-900 px-3 text-xs font-bold text-white hover:bg-black dark:bg-brand-500 dark:hover:bg-brand-600 shrink-0">
                                            <span>Update</span>
                                        </button>
                                    </form>
                                    <!-- Progress Bar -->
                                    <div class="upload-progress hidden pt-1">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="upload-bar bg-brand-500 h-1.5 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- Empty Upload Form -->
                            <form action="<?= $berkasUploadUrl ?? base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="berkas-upload-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required
                                           class="block w-full sm:w-64 text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 cursor-pointer rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-0.5">
                                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 h-8.5 rounded-lg bg-brand-500 hover:bg-brand-600 px-3.5 text-xs font-bold text-white shadow-theme-xs transition-colors shrink-0">
                                        <span class="material-symbols-outlined text-sm">cloud_upload</span>
                                        <span>Upload</span>
                                    </button>
                                </div>

                                <!-- Progress Bar -->
                                <div class="upload-progress hidden mt-1.5">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                        <div class="upload-bar bg-brand-500 h-1.5 rounded-full transition-all duration-200" style="width: 0%"></div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>