<!-- Status Filter Tabs / Pills -->
<div class="border-b border-gray-100 px-5 py-3 dark:border-gray-800 bg-gray-50/40 dark:bg-gray-800/20 flex flex-wrap items-center gap-2">
    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 mr-1 flex items-center gap-1.5">
        <i class="fas fa-filter text-[10px]"></i> Status:
    </span>

    <?php
    $baseFilterUrl = base_url('admin/pindahan') . '?th_pelajaran=' . urlencode($selectedTh ?? '') . '&search=' . urlencode($search ?? '') . '&sort=' . esc($sort ?? 'ASC');
    $tabs = [
        'all' => [
            'label' => 'Semua',
            'count' => $statusCounts['all'] ?? 0,
            'badgeClass' => 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
            'activeClass' => 'bg-gray-900 text-white dark:bg-white dark:text-gray-900 shadow-sm',
        ],
        'menunggu' => [
            'label' => 'Menunggu Verifikasi',
            'count' => $statusCounts['menunggu'] ?? 0,
            'badgeClass' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-200',
            'activeClass' => 'bg-amber-500 text-white shadow-sm',
        ],
        'incomplete' => [
            'label' => 'Biodata Belum Lengkap',
            'count' => $statusCounts['incomplete'] ?? 0,
            'badgeClass' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-200',
            'activeClass' => 'bg-rose-500 text-white shadow-sm',
        ],
        'terverifikasi' => [
            'label' => 'Terverifikasi',
            'count' => $statusCounts['terverifikasi'] ?? 0,
            'badgeClass' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200',
            'activeClass' => 'bg-emerald-600 text-white shadow-sm',
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'count' => $statusCounts['ditolak'] ?? 0,
            'badgeClass' => 'bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200',
            'activeClass' => 'bg-red-600 text-white shadow-sm',
        ],
    ];
    ?>

    <?php foreach ($tabs as $k => $t): ?>
        <?php $isActive = (($currentTab ?? 'all') === $k); ?>
        <a href="<?= $baseFilterUrl ?>&tab=<?= $k ?>"
           class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium transition-all <?= $isActive ? $t['activeClass'] : 'bg-white dark:bg-gray-800/80 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/40' ?>">
            <span><?= $t['label'] ?></span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold <?= $isActive ? 'bg-white/25 text-inherit' : $t['badgeClass'] ?>">
                <?= number_format($t['count']) ?>
            </span>
        </a>
    <?php endforeach; ?>
</div>