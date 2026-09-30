<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Laporan & Analisis Data
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<div class="flex items-center gap-2">
    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
        <i class="fas fa-chart-pie text-sm"></i>
    </div>
    <span>Laporan & Analisis Data</span>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Command Header Terpadu -->
<div class="mb-6 rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 border border-brand-200/80 dark:bg-brand-500/10 dark:text-brand-300 dark:border-brand-500/20">
                    <i class="fas fa-chart-line text-[11px]"></i>
                    Rekapitulasi Eksekutif
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 border border-slate-200/80 dark:bg-slate-800/80 dark:text-slate-300 dark:border-slate-700/60" title="Tahun Ajaran Terpilih">
                    <i class="fas fa-calendar-alt text-[11px] text-slate-500 dark:text-slate-400"></i>
                    TP <?= esc(($selectedTh === 'all') ? 'Semua Tahun' : $selectedTh) ?>
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200/80 dark:bg-emerald-500/10 dark:text-emerald-300 dark:border-emerald-500/20">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Data
                </span>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl dark:text-white">
                Analisis & Rekap Data PPDB
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 max-w-2xl leading-relaxed">
                Pantau metrik rekapitulasi pendaftaran, verifikasi berkas, komparasi tren antar tahun, dan sebaran demografi secara menyeluruh.
            </p>
        </div>

        <!-- Filter & Aksi Ekspor -->
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <!-- Filter Tahun Ajaran -->
            <form method="GET" action="<?= base_url('admin/laporan') ?>" class="flex items-center">
                <div class="flex items-center h-10 rounded-xl border border-gray-200/90 bg-gray-50/90 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800/70 overflow-hidden focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-all">
                    <div class="pl-3 pr-1 text-brand-500 dark:text-brand-400 shrink-0 pointer-events-none flex items-center">
                        <i class="fas fa-calendar-alt text-xs"></i>
                    </div>
                    <select name="th_pelajaran" onchange="this.form.submit()"
                        class="h-full bg-transparent py-1.5 pl-2 pr-8 text-xs font-semibold text-gray-800 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 cursor-pointer">
                        <?php foreach (($tahunList ?? []) as $t): ?>
                            <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= (($selectedTh ?? '') === $t['tahun_pelajaran']) ? 'selected' : '' ?> class="text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                TP: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '★ (Aktif)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="all" <?= (($selectedTh ?? '') === 'all') ? 'selected' : '' ?> class="text-gray-800 dark:bg-gray-800 dark:text-gray-100">Semua Tahun Ajaran</option>
                    </select>
                </div>
            </form>

            <!-- Quick Print Browser -->
            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200/90 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/80 px-3.5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-200 shadow-theme-xs transition-all active:scale-[0.98]"
                title="Cetak Halaman (Ctrl+P)">
                <i class="fas fa-print text-xs text-gray-500 dark:text-gray-400"></i>
                <span class="hidden sm:inline">Print</span>
            </button>

            <!-- Cetak PDF Formal -->
            <a href="<?= base_url('admin/laporan/cetak?th_pelajaran=' . urlencode($selectedTh)) ?>" target="_blank"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:shadow-theme-sm transition-all duration-150 active:scale-[0.98]">
                <i class="fas fa-file-pdf text-xs"></i>
                <span>Cetak Laporan PDF</span>
            </a>
        </div>
    </div>
</div>

<!-- Key Metric Cards Terintegrasi Delta Tren -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6 mb-6">
    <!-- Card 1: Total Pendaftar -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-theme-xs transition-all duration-200 hover:border-blue-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] md:p-6 group">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/15 dark:text-blue-400 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                <i class="fas fa-users text-xl"></i>
            </div>
            <?php
            $arah = $tren['arah'] ?? 'stabil';
            $badgeDelta = [
                'naik'   => ['bg-emerald-50 text-emerald-700 border-emerald-200/70 dark:bg-emerald-500/10 dark:text-emerald-300 dark:border-emerald-500/20', 'fa-arrow-up'],
                'turun'  => ['bg-rose-50 text-rose-700 border-rose-200/70 dark:bg-rose-500/10 dark:text-rose-300 dark:border-rose-500/20', 'fa-arrow-down'],
                'stabil' => ['bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700', 'fa-minus'],
            ][$arah];
            ?>
            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold border <?= $badgeDelta[0] ?> tabular-nums" title="Perubahan vs Tahun Ajaran Sebelumnya">
                <i class="fas <?= $badgeDelta[1] ?> text-[10px]"></i>
                <?= $tren['selisih'] >= 0 ? '+' : '' ?><?= $tren['pct'] ?>%
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pendaftar</span>
                <h4 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white tabular-nums">
                    <?= number_format($statistik['total_pendaftar'] ?? 0) ?>
                </h4>
            </div>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                <?= $tren['selisih'] >= 0 ? '+' : '' ?><?= number_format($tren['selisih']) ?> vs TA Lalu
            </p>
        </div>
    </div>

    <!-- Card 2: Terverifikasi -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-theme-xs transition-all duration-200 hover:border-emerald-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] md:p-6 group">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white dark:bg-emerald-500/15 dark:text-emerald-400 dark:group-hover:bg-emerald-500 dark:group-hover:text-white">
                <i class="fas fa-check-double text-xl"></i>
            </div>
            <?php 
                $totalSiswa = $statistik['total_pendaftar'] ?? 0;
                $pctVerif = $totalSiswa > 0 ? round((($statistik['terverifikasi'] ?? 0) / $totalSiswa) * 100) : 0;
            ?>
            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-300 dark:border-emerald-500/20 tabular-nums">
                <i class="fas fa-shield-alt text-[10px]"></i> Berkas Valid
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Terverifikasi</span>
                <h4 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white tabular-nums">
                    <?= number_format($statistik['terverifikasi'] ?? 0) ?>
                </h4>
            </div>
            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 tabular-nums">
                <?= $pctVerif ?>% Selesai
            </p>
        </div>
    </div>

    <!-- Card 3: Menunggu Verifikasi -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-theme-xs transition-all duration-200 hover:border-amber-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] md:p-6 group">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white dark:bg-amber-500/15 dark:text-amber-400 dark:group-hover:bg-amber-500 dark:group-hover:text-white">
                <i class="fas fa-hourglass-half text-xl"></i>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 border border-amber-100 dark:bg-amber-500/10 dark:text-amber-300 dark:border-amber-500/20">
                <i class="fas fa-clock text-[10px]"></i> Antrean
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Menunggu Review</span>
                <h4 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white tabular-nums">
                    <?= number_format($statistik['menunggu'] ?? 0) ?>
                </h4>
            </div>
            <a href="<?= base_url('admin/siswa') ?>" class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300 transition-colors">
                <span>Tinjau</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>

    <!-- Card 4: Ditolak -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-theme-xs transition-all duration-200 hover:border-rose-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] md:p-6 group">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition-colors group-hover:bg-rose-600 group-hover:text-white dark:bg-rose-500/15 dark:text-rose-400 dark:group-hover:bg-rose-500 dark:group-hover:text-white">
                <i class="fas fa-ban text-xl"></i>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 border border-rose-100 dark:bg-rose-500/10 dark:text-rose-300 dark:border-rose-500/20">
                <i class="fas fa-times-circle text-[10px]"></i> Ditolak
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Ditolak</span>
                <h4 class="mt-1 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white tabular-nums">
                    <?= number_format($statistik['ditolak'] ?? 0) ?>
                </h4>
            </div>
            <p class="text-xs font-medium text-rose-600 dark:text-rose-400">Perlu Perbaikan</p>
        </div>
    </div>
</div>

<!-- Modul Perbandingan Tahun Ajaran & Tren Komparatif -->
<div class="mb-6 rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between border-b border-gray-100 dark:border-gray-800 pb-4 mb-5">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <i class="fas fa-chart-line text-base"></i>
            </div>
            <div>
                <h3 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">Perbandingan & Tren Pertumbuhan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Komparasi pendaftar: Tahun Sebelumnya (<?= esc($tren['th_prev'] ?: '-') ?>) vs Tahun Aktif (<?= esc($tren['th_active']) ?>)
                </p>
            </div>
        </div>
        <a href="<?= base_url('admin/laporan/tren?th_pelajaran=' . urlencode($selectedTh)) ?>"
           class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
            <span>Lihat Detail Analisis Tren</span>
            <i class="fas fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Tile 1: Tahun Sebelumnya -->
        <div class="rounded-xl border border-gray-200/80 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/40">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tahun Sebelumnya (<?= esc($tren['th_prev'] ?: '-') ?>)</span>
            <p class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mt-1 tabular-nums">
                <?= number_format($tren['previous']['total'] ?? 0) ?> <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Siswa</span>
            </p>
            <div class="mt-2.5 flex items-center gap-3 text-xs font-medium">
                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 tabular-nums">
                    <i class="fas fa-mars text-[10px]"></i> <?= number_format($tren['previous']['L'] ?? 0) ?> L
                </span>
                <span class="inline-flex items-center gap-1 text-pink-600 dark:text-pink-400 tabular-nums">
                    <i class="fas fa-venus text-[10px]"></i> <?= number_format($tren['previous']['P'] ?? 0) ?> P
                </span>
            </div>
        </div>

        <!-- Tile 2: Tahun Aktif -->
        <div class="rounded-xl border border-gray-200/80 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/40">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tahun Aktif (<?= esc($tren['th_active']) ?>)</span>
            <p class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mt-1 tabular-nums">
                <?= number_format($tren['current']['total'] ?? 0) ?> <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Siswa</span>
            </p>
            <div class="mt-2.5 flex items-center gap-3 text-xs font-medium">
                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 tabular-nums">
                    <i class="fas fa-mars text-[10px]"></i> <?= number_format($tren['current']['L'] ?? 0) ?> L
                </span>
                <span class="inline-flex items-center gap-1 text-pink-600 dark:text-pink-400 tabular-nums">
                    <i class="fas fa-venus text-[10px]"></i> <?= number_format($tren['current']['P'] ?? 0) ?> P
                </span>
            </div>
        </div>

        <!-- Tile 3: Selisih & Status Pertumbuhan -->
        <div class="rounded-xl border <?= $badgeDelta[0] ?> p-4 flex flex-col justify-between">
            <span class="text-xs font-medium">Perubahan Pendaftar</span>
            <div class="mt-1">
                <p class="text-2xl font-extrabold tracking-tight tabular-nums">
                    <?= $tren['selisih'] >= 0 ? '+' : '' ?><?= number_format($tren['selisih'] ?? 0) ?> Siswa
                </p>
                <div class="mt-1.5 flex items-center gap-1 text-xs font-semibold">
                    <i class="fas <?= $badgeDelta[1] ?> text-[11px]"></i>
                    <span><?= $tren['pct'] ?>% <?= ucfirst($arah) ?> vs TA Sebelumnya</span>
                </div>
            </div>
        </div>

        <!-- Tile 4: Mini Sparkline SVG Komparatif -->
        <div class="rounded-xl border border-gray-200/80 bg-white p-4 dark:border-gray-800 dark:bg-transparent flex flex-col justify-between">
            <?php
            $seri = ['total' => 'Total', 'L' => 'Laki-laki', 'P' => 'Perempuan'];
            $maxV = max(array_merge(array_values($tren['previous']), array_values($tren['current']))) ?: 1;
            $w = 200; $h = 75; $pad = 10; $ch = $h - $pad * 2;
            ?>
            <div class="w-full flex-1 flex items-center">
                <svg viewBox="0 0 <?= $w ?> <?= $h ?>" class="w-full h-full" role="img" aria-label="Grafik tren pendaftar komparatif">
                    <?php foreach ($seri as $key => $nama): ?>
                        <?php
                        $prevV = $tren['previous'][$key] ?? 0;
                        $currV = $tren['current'][$key] ?? 0;
                        $warna = ['total' => '#465fff', 'L' => '#3b82f6', 'P' => '#ec4899'][$key];
                        $p1x = $pad; $p1y = $pad + $ch - ($prevV / $maxV) * $ch;
                        $p2x = $w - $pad; $p2y = $pad + $ch - ($currV / $maxV) * $ch;
                        ?>
                        <line x1="<?= $p1x ?>" y1="<?= $p1y ?>" x2="<?= $p2x ?>" y2="<?= $p2y ?>" stroke="<?= $warna ?>" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="<?= $p1x ?>" cy="<?= $p1y ?>" r="3.5" fill="#fff" stroke="<?= $warna ?>" stroke-width="2"/>
                        <circle cx="<?= $p2x ?>" cy="<?= $p2y ?>" r="3.5" fill="#fff" stroke="<?= $warna ?>" stroke-width="2"/>
                    <?php endforeach; ?>
                </svg>
            </div>
            <div class="mt-2 flex items-center justify-between text-[11px] font-semibold text-gray-500 dark:text-gray-400">
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-brand-500"></span>Total</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-blue-500"></span>L</span>
                <span class="inline-flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-pink-500"></span>P</span>
            </div>
        </div>
    </div>
</div>

<!-- Symmetric Analytics Grid - Baris 1: Demografi & Jalur Pendaftaran -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Card Kiri: Demografi & Status Seleksi -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col justify-between">
        <div>
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                        <i class="fas fa-venus-mars text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">Demografi Gender & Status Seleksi</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Proporsi gender pendaftar dan hasil kelulusan</p>
                    </div>
                </div>
            </div>

            <!-- Gender Breakdown -->
            <div class="mb-6">
                <?php 
                    $totalGender = ($gender['L'] ?? 0) + ($gender['P'] ?? 0);
                    $pctL = $totalGender > 0 ? round((($gender['L'] ?? 0) / $totalGender) * 100) : 0;
                    $pctP = $totalGender > 0 ? round((($gender['P'] ?? 0) / $totalGender) * 100) : 0;
                ?>
                <div class="flex items-center justify-between text-xs mb-2 font-semibold">
                    <span class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                        <i class="fas fa-mars text-sm"></i>
                        <span>Laki-laki: <?= number_format($gender['L'] ?? 0) ?> (<?= $pctL ?>%)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-pink-600 dark:text-pink-400">
                        <span>Perempuan: <?= number_format($gender['P'] ?? 0) ?> (<?= $pctP ?>%)</span>
                        <i class="fas fa-venus text-sm"></i>
                    </span>
                </div>

                <!-- Segmented Dual Progress Bar -->
                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-3 overflow-hidden flex shadow-inner">
                    <div class="bg-blue-500 transition-all duration-500" style="width: <?= $pctL ?>%" title="Laki-laki: <?= $pctL ?>%"></div>
                    <div class="bg-pink-500 transition-all duration-500" style="width: <?= $pctP ?>%" title="Perempuan: <?= $pctP ?>%"></div>
                </div>
            </div>

            <!-- Kelulusan Status Boxes -->
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                    Rekap Hasil Kelulusan Seleksi
                </span>
                <div class="grid grid-cols-3 gap-3">
                    <div class="rounded-xl border border-emerald-200/80 bg-emerald-50/60 p-3.5 text-center dark:border-emerald-500/20 dark:bg-emerald-500/10">
                        <p class="text-2xl font-extrabold tracking-tight text-emerald-700 dark:text-emerald-300 tabular-nums">
                            <?= number_format($kelulusan['lulus'] ?? 0) ?>
                        </p>
                        <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-200 mt-1">Lulus</p>
                    </div>

                    <div class="rounded-xl border border-rose-200/80 bg-rose-50/60 p-3.5 text-center dark:border-rose-500/20 dark:bg-rose-500/10">
                        <p class="text-2xl font-extrabold tracking-tight text-rose-700 dark:text-rose-300 tabular-nums">
                            <?= number_format($kelulusan['tidak_lulus'] ?? 0) ?>
                        </p>
                        <p class="text-xs font-semibold text-rose-800 dark:text-rose-200 mt-1">Tidak Lulus</p>
                    </div>

                    <div class="rounded-xl border border-gray-200/80 bg-gray-50/80 p-3.5 text-center dark:border-gray-700 dark:bg-gray-800/60">
                        <p class="text-2xl font-extrabold tracking-tight text-gray-800 dark:text-gray-200 tabular-nums">
                            <?= number_format($kelulusan['belum_diproses'] ?? 0) ?>
                        </p>
                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">Belum Diproses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Kanan: Distribusi Jalur Pendaftaran -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col justify-between">
        <div>
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <i class="fas fa-route text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">Distribusi Jalur Pendaftaran</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebaran pilihan jalur masuk calon siswa</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <?php if (empty($jalur)): ?>
                    <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                        <i class="fas fa-inbox text-3xl opacity-30 block mb-2"></i>
                        <p class="text-xs font-medium">Belum ada data jalur pendaftaran.</p>
                    </div>
                <?php else: ?>
                    <?php 
                    $barColors = ['bg-brand-500', 'bg-emerald-500', 'bg-amber-500', 'bg-blue-500', 'bg-indigo-500'];
                    $i = 0;
                    foreach ($jalur as $name => $count): 
                        $total = $statistik['total_pendaftar'] ?? 1;
                        $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                        $color = $barColors[$i % count($barColors)];
                        $i++;
                    ?>
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5 font-medium">
                            <span class="font-bold text-gray-900 dark:text-gray-100"><?= esc($name) ?></span>
                            <span class="text-gray-600 dark:text-gray-400 tabular-nums">
                                <b class="font-bold text-gray-900 dark:text-white"><?= number_format($count) ?></b> siswa (<?= $pct ?>%)
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2.5 overflow-hidden">
                            <div class="<?= $color ?> h-2.5 rounded-full transition-all duration-500 shadow-sm" style="width: <?= $pct ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Symmetric Analytics Grid - Baris 2: Top Asal Sekolah & Top Sebaran Wilayah -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 5 Asal Sekolah -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    <i class="fas fa-school text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">Top 5 Asal Sekolah</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sekolah penyumbang pendaftar terbanyak</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500">Peringkat</span>
        </div>

        <?php if (empty($topSekolah)): ?>
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <i class="fas fa-school text-3xl opacity-30 block mb-2"></i>
                <p class="text-xs font-medium">Belum ada data sekolah asal.</p>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($topSekolah as $index => $sekolah): ?>
                <li class="py-3 flex justify-between items-center hover:bg-gray-50/70 dark:hover:bg-gray-800/40 rounded-xl px-2.5 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 pr-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300 tabular-nums">
                            <?= $index + 1 ?>
                        </span>
                        <span class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-white truncate">
                            <?= strtoupper(esc($sekolah['nama_sekolah'])) ?>
                        </span>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-500/30 tabular-nums">
                        <?= number_format($sekolah['total']) ?> Siswa
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Top 5 Sebaran Wilayah (Kecamatan) -->
    <div class="rounded-2xl border border-gray-200/80 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600 dark:bg-teal-500/15 dark:text-teal-400">
                    <i class="fas fa-map-marked-alt text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold tracking-tight text-gray-900 dark:text-white">Top 5 Sebaran Kecamatan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Wilayah asal pendaftar tertinggi</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500">Peringkat</span>
        </div>

        <?php if (empty($topWilayah)): ?>
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <i class="fas fa-map-marker-alt text-3xl opacity-30 block mb-2"></i>
                <p class="text-xs font-medium">Belum ada data wilayah kecamatan.</p>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($topWilayah as $index => $wilayah): ?>
                <li class="py-3 flex justify-between items-center hover:bg-gray-50/70 dark:hover:bg-gray-800/40 rounded-xl px-2.5 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 pr-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300 tabular-nums">
                            <?= $index + 1 ?>
                        </span>
                        <span class="font-semibold text-xs sm:text-sm text-gray-900 dark:text-white truncate">
                            <?= ucwords(strtolower(esc($wilayah['kec']))) ?>
                        </span>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/60 dark:border-blue-500/30 tabular-nums">
                        <?= number_format($wilayah['total']) ?> Pendaftar
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
