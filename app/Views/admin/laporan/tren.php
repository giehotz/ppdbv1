<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Tren Pendaftar
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">trending_up</span> Detail Perbandingan Tren Pendaftar
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$arah = $tren['arah'] ?? 'stabil';
$badgeArah = [
    'naik'   => ['text-emerald-700 bg-emerald-50 border-emerald-200/70 dark:text-emerald-400 dark:bg-emerald-500/10 dark:border-emerald-500/20', 'trending_up'],
    'turun'  => ['text-red-700 bg-red-50 border-red-200/70 dark:text-red-400 dark:bg-red-500/10 dark:border-red-500/20', 'trending_down'],
    'stabil' => ['text-gray-700 bg-gray-50 border-gray-200/70 dark:text-gray-300 dark:bg-gray-800/60 dark:border-gray-700', 'remove'],
][$arah];
?>

<!-- Header / Back -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/50 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-xs">insights</span>
                    <?= esc($tren['th_prev'] ?: '-') ?> &bull; <?= esc($tren['th_active']) ?>
                </span>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-2xl">
                Pertumbuhan Jumlah Pendaftar
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                Perbandingan jumlah siswa yang mendaftar pada tahun ajaran berjalan dengan tahun sebelumnya.
            </p>
        </div>
        <div class="flex items-center gap-3 self-stretch md:self-auto justify-end">
            <a href="<?= base_url('admin/laporan') ?>"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 px-4 py-2.5 text-xs font-bold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-all duration-200">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali ke Laporan
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400"><?= esc($tren['th_prev'] ?: '-') ?></span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tahun Sebelumnya</span>
            <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                <?= number_format($tren['previous']['total']) ?> <span class="text-sm font-semibold text-gray-400">siswa</span>
            </h4>
            <div class="mt-2 flex items-center gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400">L: <?= number_format($tren['previous']['L']) ?></span>
                <span class="inline-flex items-center gap-1 text-pink-600 dark:text-pink-400">P: <?= number_format($tren['previous']['P']) ?></span>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">group_add</span>
            </div>
            <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400"><?= esc($tren['th_active']) ?></span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tahun Aktif</span>
            <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                <?= number_format($tren['current']['total']) ?> <span class="text-sm font-semibold text-gray-400">siswa</span>
            </h4>
            <div class="mt-2 flex items-center gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400">L: <?= number_format($tren['current']['L']) ?></span>
                <span class="inline-flex items-center gap-1 text-pink-600 dark:text-pink-400">P: <?= number_format($tren['current']['P']) ?></span>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border <?= $badgeArah[0] ?> p-5 shadow-theme-xs transition-all hover:shadow-theme-md sm:col-span-3 md:col-span-1 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl <?= $arah === 'naik' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' : ($arah === 'turun' ? 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') ?>">
                <span class="material-symbols-outlined text-2xl"><?= $badgeArah[1] ?></span>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-xs font-bold <?= $badgeArah[0] ?>">
                <?= $tren['pct'] ?>%
            </span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium">Selisih Jumlah</span>
            <h4 class="mt-1 text-2xl lg:text-3xl font-bold">
                <?= $tren['selisih'] >= 0 ? '+' : '' ?><?= number_format($tren['selisih']) ?> <span class="text-sm font-semibold">siswa</span>
            </h4>
            <p class="mt-2 text-xs font-semibold capitalize"><?= $arah ?> dari tahun sebelumnya</p>
        </div>
    </div>
</div>

<!-- Line Chart Detail -->
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100 dark:border-gray-800 pb-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 text-white shadow-sm shadow-indigo-500/30">
                <span class="material-symbols-outlined text-lg">show_chart</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Visualisasi Tren Pendaftar</h3>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Total, Laki-laki &amp; Perempuan antar tahun ajaran</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <!-- Chart type toggle -->
            <div class="inline-flex rounded-lg bg-gray-100 p-1 dark:bg-gray-800">
                <button type="button" id="btnTypeBar" class="inline-flex items-center gap-1 rounded-md px-2.5 py-1 text-xs font-bold text-gray-800 bg-white shadow-sm dark:bg-gray-700 dark:text-white transition-all">
                    <span class="material-symbols-outlined text-sm">bar_chart</span>
                    <span>Batang</span>
                </button>
                <button type="button" id="btnTypeLine" class="inline-flex items-center gap-1 rounded-md px-2.5 py-1 text-xs font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-all">
                    <span class="material-symbols-outlined text-sm">show_chart</span>
                    <span>Garis</span>
                </button>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 border border-gray-200 px-2.5 py-1 text-[11px] font-semibold text-gray-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                <span class="material-symbols-outlined text-sm">legend_toggle</span>
                <?= esc($tren['th_prev'] ?: '-') ?> &rarr; <?= esc($tren['th_active']) ?>
            </span>
        </div>
    </div>

    <?php
    $seri = ['total' => 'Total Pendaftar', 'L' => 'Laki-laki', 'P' => 'Perempuan'];
    ?>
    <div class="relative mx-auto max-w-3xl h-64 sm:h-72 w-full">
        <canvas id="trenChart"></canvas>
    </div>

    <!-- Legend with values (Interactive) -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
        <?php foreach ($seri as $key => $nama): ?>
            <?php
            $prevV = $tren['previous'][$key] ?? 0;
            $currV = $tren['current'][$key] ?? 0;
            $diff  = $currV - $prevV;
            $up    = $diff > 0;
            $bg    = ['total' => 'bg-indigo-50 border-indigo-200/70 dark:bg-indigo-500/10 dark:border-indigo-500/20',
                      'L'     => 'bg-blue-50 border-blue-200/70 dark:bg-blue-500/10 dark:border-blue-500/20',
                      'P'     => 'bg-pink-50 border-pink-200/70 dark:bg-pink-500/10 dark:border-pink-500/20'][$key];
            ?>
            <div id="legend-card-<?= $key ?>" role="button" title="Klik untuk tampilkan/sembunyikan di chart" class="cursor-pointer select-none rounded-xl border <?= $bg ?> p-3.5 transition-all duration-200 hover:scale-[1.01] active:scale-[0.99]">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-800 dark:text-gray-200">
                        <span class="h-2.5 w-2.5 rounded-full <?= ['total'=>'bg-indigo-500','L'=>'bg-blue-500','P'=>'bg-pink-500'][$key] ?>"></span>
                        <?= $nama ?>
                    </span>
                    <span class="inline-flex items-center gap-0.5 text-[11px] font-bold <?= $up ? 'text-emerald-600' : ($diff < 0 ? 'text-red-600' : 'text-gray-500') ?>">
                        <span class="material-symbols-outlined text-xs"><?= $up ? 'arrow_upward' : ($diff < 0 ? 'arrow_downward' : 'remove') ?></span>
                        <?= $diff > 0 ? '+' : '' ?><?= number_format($diff) ?>
                    </span>
                </div>
                <div class="mt-2 flex items-baseline justify-between text-xs font-semibold text-gray-500 dark:text-gray-400">
                    <span><?= esc($tren['th_prev'] ?: '-') ?>: <b class="text-gray-900 dark:text-white"><?= number_format($prevV) ?></b></span>
                    <span>&rarr;</span>
                    <span><?= esc($tren['th_active']) ?>: <b class="text-gray-900 dark:text-white"><?= number_format($currV) ?></b></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Detail Table -->
<div class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
            <span class="material-symbols-outlined text-lg">table_chart</span>
        </div>
        <h3 class="text-base font-bold text-gray-800 dark:text-white">Rincian Data Per Tahun</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50 dark:bg-gray-800/40">
                    <th class="py-3 px-5">Indikator</th>
                    <th class="py-3 px-5 text-center"><?= esc($tren['th_prev'] ?: '-') ?></th>
                    <th class="py-3 px-5 text-center"><?= esc($tren['th_active']) ?></th>
                    <th class="py-3 px-5 text-center">Selisih</th>
                    <th class="py-3 px-5 text-center">Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php
                $rows = [
                    'total' => 'Total Siswa',
                    'L'     => 'Laki-laki',
                    'P'     => 'Perempuan',
                ];
                foreach ($rows as $key => $label):
                    $prev = $tren['previous'][$key] ?? 0;
                    $curr = $tren['current'][$key] ?? 0;
                    $diff = $curr - $prev;
                    $pct  = $prev > 0 ? round($diff / $prev * 100, 1) : 0;
                    $up   = $diff > 0;
                ?>
                <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                    <td class="py-3.5 px-5 font-semibold text-gray-800 dark:text-gray-200"><?= $label ?></td>
                    <td class="py-3.5 px-5 text-center text-gray-600 dark:text-gray-300"><?= number_format($prev) ?></td>
                    <td class="py-3.5 px-5 text-center font-bold text-gray-900 dark:text-white"><?= number_format($curr) ?></td>
                    <td class="py-3.5 px-5 text-center font-semibold <?= $up ? 'text-emerald-600' : ($diff < 0 ? 'text-red-600' : 'text-gray-500') ?>">
                        <?= $diff > 0 ? '+' : '' ?><?= number_format($diff) ?>
                    </td>
                    <td class="py-3.5 px-5 text-center">
                        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[11px] font-bold <?= $up ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20' : ($diff < 0 ? 'bg-red-50 text-red-700 border border-red-200/70 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20' : 'bg-gray-50 text-gray-600 border border-gray-200/70 dark:bg-gray-800/60 dark:text-gray-300 dark:border-gray-700') ?>">
                            <span class="material-symbols-outlined text-xs"><?= $up ? 'trending_up' : ($diff < 0 ? 'trending_down' : 'remove') ?></span>
                            <?= $pct ?>%
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
(() => {
    const isDark = document.documentElement.classList.contains('dark');
    const labels = [<?= json_encode($tren['th_prev'] ?: '-') ?>, <?= json_encode($tren['th_active']) ?>];

    const prevTotal = <?= (int)($tren['previous']['total'] ?? 0) ?>;
    const currTotal = <?= (int)($tren['current']['total'] ?? 0) ?>;
    const prevL     = <?= (int)($tren['previous']['L'] ?? 0) ?>;
    const currL     = <?= (int)($tren['current']['L'] ?? 0) ?>;
    const prevP     = <?= (int)($tren['previous']['P'] ?? 0) ?>;
    const currP     = <?= (int)($tren['current']['P'] ?? 0) ?>;

    // Grouped Bar Datasets (Default) - Laki-laki and Perempuan appear side-by-side without overlapping!
    const barDatasets = [
        {
            label: 'Total Pendaftar',
            data: [prevTotal, currTotal],
            backgroundColor: '#6366f1',
            borderRadius: 6,
            borderSkipped: false,
            maxBarThickness: 32,
        },
        {
            label: 'Laki-laki',
            data: [prevL, currL],
            backgroundColor: '#3b82f6',
            borderRadius: 6,
            borderSkipped: false,
            maxBarThickness: 32,
        },
        {
            label: 'Perempuan',
            data: [prevP, currP],
            backgroundColor: '#ec4899',
            borderRadius: 6,
            borderSkipped: false,
            maxBarThickness: 32,
        }
    ];

    // Line Datasets - with distinct dashed stroke & diamond point for Laki-laki so it is visible even if values overlap!
    const lineDatasets = [
        {
            label: 'Total Pendaftar',
            data: [prevTotal, currTotal],
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,0.08)',
            borderWidth: 3,
            tension: 0.3,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointStyle: 'circle',
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#6366f1',
            pointBorderWidth: 3,
            fill: false,
        },
        {
            label: 'Laki-laki',
            data: [prevL, currL],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.08)',
            borderWidth: 3,
            borderDash: [6, 4],
            tension: 0.3,
            pointRadius: 7,
            pointHoverRadius: 9,
            pointStyle: 'rectRot',
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#3b82f6',
            pointBorderWidth: 3,
            fill: false,
        },
        {
            label: 'Perempuan',
            data: [prevP, currP],
            borderColor: '#ec4899',
            backgroundColor: 'rgba(236,72,153,0.08)',
            borderWidth: 3,
            tension: 0.3,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointStyle: 'circle',
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#ec4899',
            pointBorderWidth: 3,
            fill: false,
        }
    ];

    let currentType = 'bar';

    const ctx = document.getElementById('trenChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: barDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        boxHeight: 8,
                        padding: 14,
                        font: { size: 12, weight: '600' },
                        color: isDark ? '#9ca3af' : '#6b7280'
                    }
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { weight: 'bold', size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString('id-ID')} siswa`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { weight: '700', size: 12 },
                        color: isDark ? '#9ca3af' : '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: isDark ? 'rgba(255,255,255,0.06)' : '#f3f4f6'
                    },
                    ticks: {
                        font: { weight: '600', size: 11 },
                        color: isDark ? '#9ca3af' : '#9ca3af',
                        callback: v => v.toLocaleString('id-ID')
                    }
                }
            }
        }
    });

    // Toggle Bar / Line chart type
    const btnBar = document.getElementById('btnTypeBar');
    const btnLine = document.getElementById('btnTypeLine');

    const activeClass = 'inline-flex items-center gap-1 rounded-md px-2.5 py-1 text-xs font-bold text-gray-800 bg-white shadow-sm dark:bg-gray-700 dark:text-white transition-all';
    const inactiveClass = 'inline-flex items-center gap-1 rounded-md px-2.5 py-1 text-xs font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-all';

    function setChartType(type) {
        if (currentType === type) return;
        currentType = type;

        if (type === 'bar') {
            chart.config.type = 'bar';
            chart.data.datasets = barDatasets;
            btnBar.className = activeClass;
            btnLine.className = inactiveClass;
        } else {
            chart.config.type = 'line';
            chart.data.datasets = lineDatasets;
            btnLine.className = activeClass;
            btnBar.className = inactiveClass;
        }
        chart.update();
    }

    if (btnBar) btnBar.addEventListener('click', () => setChartType('bar'));
    if (btnLine) btnLine.addEventListener('click', () => setChartType('line'));

    // Card click to toggle visibility
    const datasetIndexMap = { 'total': 0, 'L': 1, 'P': 2 };
    Object.entries(datasetIndexMap).forEach(([key, idx]) => {
        const card = document.getElementById('legend-card-' + key);
        if (card) {
            card.addEventListener('click', () => {
                const isVisible = chart.isDatasetVisible(idx);
                chart.setDatasetVisibility(idx, !isVisible);
                chart.update();
                card.style.opacity = !isVisible ? '1' : '0.45';
            });
        }
    });
})();
</script>
<?= $this->endSection() ?>