<!-- F. Riwayat Verifikasi -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
            <span class="material-symbols-outlined text-lg">history</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">F. Riwayat Verifikasi</h3>
    </div>

    <div class="p-5 md:p-6">
        <?php if (!empty($verifLogs)) : ?>
            <div class="space-y-3">
                <?php foreach ($verifLogs as $log) : ?>
                    <?php
                    $ketLog = $log['ket'] ?? '';
                    if ($ketLog === 'Terverifikasi') :
                        $badgeLog = '<span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/15 dark:text-emerald-400 px-2 py-0.5 rounded-full">Terverifikasi</span>';
                        $dotLog = 'bg-emerald-500';
                        $borderLog = 'border-emerald-100 dark:border-emerald-950/40';
                    elseif ($ketLog === 'Ditolak') :
                        $badgeLog = '<span class="text-[10px] font-bold text-red-600 bg-red-50 dark:bg-red-500/15 dark:text-red-400 px-2 py-0.5 rounded-full">Ditolak</span>';
                        $dotLog = 'bg-red-500';
                        $borderLog = 'border-red-100 dark:border-red-950/40';
                    else :
                        $badgeLog = '<span class="text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-500/15 dark:text-amber-400 px-2 py-0.5 rounded-full">Menunggu</span>';
                        $dotLog = 'bg-amber-500';
                        $borderLog = 'border-gray-100 dark:border-gray-800';
                    endif;
                    ?>
                    <div class="flex gap-3 rounded-xl border <?= $borderLog ?> bg-gray-50/60 dark:bg-gray-800/30 p-3.5">
                        <div class="shrink-0 flex flex-col items-center">
                            <span class="h-2.5 w-2.5 rounded-full <?= $dotLog ?> mt-1"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <?= $badgeLog ?>
                                <span class="text-[11px] text-gray-400 dark:text-gray-500">
                                    <?= !empty($log['tgl_verifikasi']) && strtotime($log['tgl_verifikasi']) ? date('d/m/Y H:i', strtotime($log['tgl_verifikasi'])) : '-' ?>
                                </span>
                            </div>
                            <?php if (!empty($log['verifikator'])) : ?>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium mt-1">oleh: <?= esc($log['verifikator']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($log['isi'])) : ?>
                                <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 leading-relaxed"><?= esc($log['isi']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-6">Belum ada riwayat verifikasi.</p>
        <?php endif; ?>
    </div>
</div>