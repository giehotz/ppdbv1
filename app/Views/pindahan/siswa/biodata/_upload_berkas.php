<!-- Tab: Berkas (Pindahan) -->
<div id="content-berkas" class="tab-content hidden space-y-6">
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                    <span class="material-symbols-outlined text-lg">upload_file</span>
                </span>
                <span>Unggah Berkas Persyaratan Pindahan</span>
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Format: PDF, JPG, atau PNG. Maksimal 2MB per file.</p>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/50">
            <span class="material-symbols-outlined text-sm">verified_user</span>
            <span>Dokumen Wajib</span>
        </span>
    </div>

    <div class="space-y-4">
        <?php foreach (($requiredDocs ?? []) as $jenis => $label): ?>
            <?php $isUploaded = isset($uploadedBerkas[$jenis]); ?>
            <?php
            $isWajib = in_array($jenis, \App\Models\Pindahan\BerkasPindahanModel::JENIS_WAJIB, true);
            $uploadUrl = $uploadUrl ?? base_url('siswa/pindahan/berkas/upload');
            $deleteUrl = $deleteUrl ?? base_url('siswa/pindahan/berkas/delete/');
            ?>
            <div class="rounded-2xl border <?= $isUploaded ? 'border-emerald-100 dark:border-emerald-950/40' : ($isWajib ? 'border-amber-100 dark:border-amber-950/40' : 'border-gray-100 dark:border-gray-800') ?> bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md dark:bg-gray-800/40">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 flex-1 min-w-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl shrink-0 <?= $isUploaded ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-gray-100 text-gray-400 dark:bg-gray-700/60 dark:text-gray-400' ?>">
                            <span class="material-symbols-outlined text-2xl"><?= $isUploaded ? 'task' : 'upload_file' ?></span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                <?= esc($label) ?>
                                <?php if ($isWajib): ?>
                                    <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <?php if ($isUploaded): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-400">
                                        <span class="material-symbols-outlined text-xs">check_circle</span> Sudah Terunggah
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold <?= $isWajib ? 'text-amber-600 dark:text-amber-400' : 'text-gray-400 dark:text-gray-500' ?>">
                                        <span class="material-symbols-outlined text-xs"><?= $isWajib ? 'warning' : 'info' ?></span>
                                        <?= $isWajib ? 'Belum Diunggah (Wajib)' : 'Opsional' ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-auto shrink-0">
                        <?php if ($isUploaded): ?>
                            <div class="flex flex-col gap-2.5">
                                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                    <?php
                                    $nisnPindahan = $pindahan['nisn'] ?? '';
                                    $ext = strtolower(pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION));
                                    $fileUrl = base_url('uploads/berkas/' . rawurlencode($nisnPindahan) . '/' . rawurlencode($uploadedBerkas[$jenis]['nama_file']));
                                    ?>
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300 font-mono">
                                        <span class="material-symbols-outlined text-sm text-gray-400">description</span>
                                        <span class="truncate max-w-[150px]" title="<?= esc($uploadedBerkas[$jenis]['nama_file']) ?>"><?= esc($uploadedBerkas[$jenis]['nama_file']) ?></span>
                                        <span class="uppercase font-bold text-brand-600 dark:text-brand-400 text-[10px] px-1.5 py-0.5 rounded bg-brand-50 dark:bg-brand-500/20"><?= $ext ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <a href="<?= $fileUrl ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors shadow-sm" title="Lihat Dokumen">
                                            <span class="material-symbols-outlined text-base">visibility</span>
                                        </a>
                                        <button type="button" onclick="document.getElementById('form-ganti-<?= $jenis ?>').classList.toggle('hidden')" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 transition-colors shadow-sm" title="Ganti Berkas">
                                            <span class="material-symbols-outlined text-base">sync</span>
                                        </button>
                                        <form action="<?= $deleteUrl . $uploadedBerkas[$jenis]['id_berkas_pindahan'] ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus berkas ini?');" class="inline m-0">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400 transition-colors shadow-sm" title="Hapus">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div id="form-ganti-<?= $jenis ?>" class="hidden p-3.5 rounded-2xl border border-gray-200 bg-gray-50/80 dark:border-gray-700 dark:bg-gray-800/60">
                                    <form action="<?= $uploadUrl ?>" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                        <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-500 file:text-white cursor-pointer">
                                        <button type="submit" class="inline-flex items-center justify-center gap-1 h-9 rounded-xl bg-gray-900 px-4 text-xs font-bold text-white hover:bg-black dark:bg-brand-500 dark:hover:bg-brand-600 shrink-0 shadow-sm transition-colors">
                                            <span class="material-symbols-outlined text-sm">cloud_upload</span> Unggah Ulang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <form action="<?= $uploadUrl ?>" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                                <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full sm:w-64 text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-1">
                                <button type="submit" class="inline-flex items-center justify-center gap-1.5 h-9 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 text-xs font-bold text-white shadow-sm shadow-brand-500/20 transition-all shrink-0">
                                    <span class="material-symbols-outlined text-base">cloud_upload</span> Unggah
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>