<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Statistik Twibbon - <?= esc($campaign['title']) ?><?= $this->endSection() ?>

<?= $this->section('page_title') ?>Statistik Twibbon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between bg-white rounded-lg shadow-md p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800"><?= esc($campaign['title']) ?></h2>
            <p class="text-sm text-gray-500">Statistik dan riwayat unduhan twibbon kampanye.</p>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 text-sm flex items-center gap-1">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Stats Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase font-bold tracking-wider opacity-75">Total Unduhan</p>
                    <h3 class="text-3xl font-extrabold mt-1"><?= number_format($total_downloads) ?></h3>
                </div>
                <i class="fas fa-download text-4xl opacity-30"></i>
            </div>
            <p class="text-xs mt-3 opacity-90">Total foto twibbon yang berhasil diunduh pengunjung</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Status Kampanye</p>
                    <h3 class="text-xl font-bold text-gray-800 mt-2">
                        <?php
                        $today = date('Y-m-d');
                        $activeDate = true;
                        if ($campaign['start_date'] && $campaign['start_date'] > $today) $activeDate = false;
                        if ($campaign['end_date'] && $campaign['end_date'] < $today) $activeDate = false;
                        if ($campaign['is_active'] && $activeDate):
                        ?>
                            <span class="text-green-600">Aktif</span>
                        <?php else: ?>
                            <span class="text-red-600">Non-Aktif</span>
                        <?php endif; ?>
                    </h3>
                </div>
                <i class="fas fa-toggle-on text-4xl text-gray-200"></i>
            </div>
            <p class="text-xs text-gray-500 mt-3">
                <?php if ($campaign['start_date'] || $campaign['end_date']): ?>
                    Periode: <?= $campaign['start_date'] ? date('d M Y', strtotime($campaign['start_date'])) : '-' ?> s.d <?= $campaign['end_date'] ? date('d M Y', strtotime($campaign['end_date'])) : '-' ?>
                <?php else: ?>
                    Berlaku selamanya
                <?php endif; ?>
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Link Publik</p>
                    <a href="<?= base_url('twibbon/' . $campaign['slug']) ?>" target="_blank" class="text-blue-600 hover:underline font-bold text-sm block mt-2 truncate max-w-[200px]">
                        twibbon/<?= esc($campaign['slug']) ?>
                    </a>
                </div>
                <i class="fas fa-link text-3xl text-gray-200"></i>
            </div>
            <p class="text-xs text-gray-500 mt-3">Tautan langsung halaman pembuat twibbon</p>
        </div>
    </div>

    <!-- Daily Breakdown and History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daily Stats Table -->
        <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-1">
            <h3 class="text-md font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-day text-green-600"></i> Unduhan 14 Hari Terakhir
            </h3>
            <div class="max-h-[350px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Tanggal</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-500 uppercase tracking-wider text-xs">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($daily_stats)): ?>
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-gray-400">Tidak ada data untuk periode ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($daily_stats as $stat): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-700"><?= date('d M Y', strtotime($stat['date'])) ?></td>
                                    <td class="px-4 py-2 text-right font-bold text-gray-900"><?= number_format($stat['count']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Logs Table -->
        <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2">
            <h3 class="text-md font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-green-600"></i> Riwayat 100 Unduhan Terakhir
            </h3>
            <div class="max-h-[350px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-500 uppercase tracking-wider">User Agent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($recent_downloads)): ?>
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada riwayat unduhan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_downloads as $log): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-600"><?= date('d M Y H:i:s', strtotime($log['created_at'])) ?></td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-900 font-medium"><?= esc($log['ip_address']) ?></td>
                                    <td class="px-4 py-2 truncate max-w-xs text-gray-500" title="<?= esc($log['user_agent']) ?>"><?= esc($log['user_agent']) ?></td>
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
