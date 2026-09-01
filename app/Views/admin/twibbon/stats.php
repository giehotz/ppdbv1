<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Statistik Twibbon - <?= esc($campaign['title']) ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">monitoring</span> Statistik Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Header Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-2xl">analytics</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white"><?= esc($campaign['title']) ?></h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Statistik performa, riwayat unduhan, dan pelacakan log pengguna</p>
            </div>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>"
           class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- 3 Summary Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Unduhan -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Unduhan</span>
                <span class="material-symbols-outlined text-emerald-500 text-2xl">download_for_offline</span>
            </div>
            <h4 class="mt-3 text-3xl font-bold font-mono text-gray-900 dark:text-white"><?= number_format($total_downloads) ?></h4>
            <p class="mt-1 text-xs text-gray-400">Total foto twibbon berhasil diunduh publik</p>
        </div>

        <!-- Status Kampanye -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status Kampanye</span>
                <?php
                $today = date('Y-m-d');
                $activeDate = true;
                if ($campaign['start_date'] && $campaign['start_date'] > $today) $activeDate = false;
                if ($campaign['end_date'] && $campaign['end_date'] < $today) $activeDate = false;
                $isCurrentlyActive = $campaign['is_active'] && $activeDate;
                ?>
                <span class="material-symbols-outlined text-2xl <?= $isCurrentlyActive ? 'text-emerald-500' : 'text-red-500' ?>">
                    <?= $isCurrentlyActive ? 'check_circle' : 'cancel' ?>
                </span>
            </div>
            <h4 class="mt-3 text-xl font-bold <?= $isCurrentlyActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' ?>">
                <?= $isCurrentlyActive ? 'Aktif' : 'Non-Aktif' ?>
            </h4>
            <p class="mt-1 text-xs text-gray-400">
                <?php if ($campaign['start_date'] || $campaign['end_date']): ?>
                    <?= $campaign['start_date'] ? date('d M Y', strtotime($campaign['start_date'])) : '-' ?> s.d <?= $campaign['end_date'] ? date('d M Y', strtotime($campaign['end_date'])) : '-' ?>
                <?php else: ?>
                    Berlaku selamanya
                <?php endif; ?>
            </p>
        </div>

        <!-- Link Publik -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tautan Publik</span>
                <span class="material-symbols-outlined text-brand-500 text-2xl">link</span>
            </div>
            <div class="mt-3">
                <a href="<?= base_url('twibbon/' . $campaign['slug']) ?>" target="_blank"
                   class="font-mono text-sm font-bold text-brand-600 dark:text-brand-400 hover:underline truncate block">
                    /twibbon/<?= esc($campaign['slug']) ?>
                </a>
            </div>
            <p class="mt-1 text-xs text-gray-400">Tautan langsung halaman pembuat twibbon</p>
        </div>
    </div>

    <!-- Daily Breakdown & Recent Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daily Stats Table -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-1">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-3 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">date_range</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">14 Hari Terakhir</h4>
            </div>

            <div class="max-h-80 overflow-y-auto pr-1">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 text-[10px] uppercase font-bold text-gray-400">
                            <th class="py-2 text-left">Tanggal</th>
                            <th class="py-2 text-right">Unduhan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 font-mono">
                        <?php if (empty($daily_stats)): ?>
                            <tr>
                                <td colspan="2" class="py-8 text-center text-gray-400 font-sans">Belum ada data periode ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($daily_stats as $stat): ?>
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30">
                                    <td class="py-2.5 text-gray-700 dark:text-gray-300"><?= date('d M Y', strtotime($stat['date'])) ?></td>
                                    <td class="py-2.5 text-right font-bold text-emerald-600 dark:text-emerald-400"><?= number_format($stat['count']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Logs Table -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-2">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-3 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">history</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat 100 Unduhan Terakhir</h4>
            </div>

            <div class="max-h-80 overflow-y-auto pr-1">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 text-[10px] uppercase font-bold text-gray-400">
                            <th class="py-2 text-left">Waktu Akses</th>
                            <th class="py-2 text-left">IP Address</th>
                            <th class="py-2 text-left">Perangkat / Browser</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if (empty($recent_downloads)): ?>
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-400">Belum ada riwayat log unduhan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_downloads as $log): ?>
                                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30">
                                    <td class="py-2.5 whitespace-nowrap text-gray-600 dark:text-gray-400 font-mono text-[11px]"><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></td>
                                    <td class="py-2.5 whitespace-nowrap font-mono text-gray-900 dark:text-white"><?= esc($log['ip_address']) ?></td>
                                    <td class="py-2.5 truncate max-w-xs text-[11px] text-gray-500 dark:text-gray-400" title="<?= esc($log['user_agent']) ?>"><?= esc($log['user_agent']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
