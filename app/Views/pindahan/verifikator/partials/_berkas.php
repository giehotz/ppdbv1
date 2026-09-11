<!-- E. Berkas Terunggah -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                <span class="material-symbols-outlined text-lg">folder_open</span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">E. Berkas Terunggah</h3>
        </div>
        <a href="<?= base_url('verifikator/pindahan/berkas/' . $siswa['id_pindahan']) ?>" class="text-xs font-bold text-brand-600 dark:text-brand-400 hover:underline inline-flex items-center gap-1">
            Kelola Berkas <span class="material-symbols-outlined text-xs">arrow_forward</span>
        </a>
    </div>

    <div class="p-5 md:p-6">
        <?php if ($berkasWajibArr !== null) : ?>
            <div class="mb-4 flex flex-wrap items-center gap-3 text-xs">
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 px-3 py-1.5 font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <span class="material-symbols-outlined text-sm text-brand-500">inventory_2</span>
                    Berkas Wajib: <strong><?= $berkasWajibArr['sudah'] ?> / <?= $berkasWajibArr['total'] ?></strong>
                </span>
                <?php if (!empty($berkasWajibArr['lengkap'])) : ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                        <span class="material-symbols-outlined text-xs">check_circle</span> Lengkap
                    </span>
                <?php else : ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                        <span class="material-symbols-outlined text-xs">pending</span> Sisa <?= count($berkasWajibArr['kurang']) ?> berkas
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($berkasArr)) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <?php foreach ($berkasArr as $jenis => $bk) : ?>
                    <?php
                    $statusBk = $bk['status_verifikasi'] ?? 'pending';

                    if ($statusBk === 'valid') :
                        $badgeBk = '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/15 dark:text-emerald-400 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800/40"><span class="material-symbols-outlined text-xs">check_circle</span> Tervalidasi</span>';
                    elseif ($statusBk === 'invalid') :
                        $badgeBk = '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 dark:bg-red-500/15 dark:text-red-400 px-2 py-0.5 rounded-full border border-red-200 dark:border-red-800/40"><span class="material-symbols-outlined text-xs">cancel</span> Ditolak</span>';
                    else :
                        $badgeBk = '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-500/15 dark:text-amber-400 px-2 py-0.5 rounded-full border border-amber-200 dark:border-amber-800/40"><span class="material-symbols-outlined text-xs">pending</span> Menunggu</span>';
                    endif;
                    ?>
                    <div class="flex items-center justify-between gap-2 rounded-xl border border-gray-100 bg-gray-50/60 dark:border-gray-800 dark:bg-gray-800/30 px-3.5 py-2.5">
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 block truncate"><?= esc($bk['nama_file'] ?? $jenis) ?></span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 block"><?= esc($bk['jenis_berkas'] ?? $jenis) ?></span>
                        </div>
                        <?= $badgeBk ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-6">Belum ada berkas yang diunggah.</p>
        <?php endif; ?>
    </div>
</div>