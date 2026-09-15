<?= $this->extend('layouts/admin') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('content') ?>

<!-- Welcome Banner (TailAdmin Card Style) -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Aktif
                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200 dark:border-brand-800/50">
                    <i class="fas fa-graduation-cap text-[11px]"></i>
                    <?= esc($app_alias ?? 'PPDB') ?> Online
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-0.5 text-xs font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300 border border-blue-200 dark:border-blue-800/50" title="Statistik dashboard hanya menampilkan pendaftar pada tahun ajaran ini">
                    <i class="fas fa-calendar-alt text-[11px]"></i>
                    TP <?= esc($activeYear ?? '2025/2026') ?>
                </span>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:text-3xl dark:text-white">
                Selamat Datang, <?= esc(session()->get('nama_lengkap') ?: session()->get('username') ?: 'Administrator') ?>! 👋
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                Pantau statistik pendaftaran, verifikasi berkas calon peserta didik, dan kelola seluruh aktivitas PPDB secara real-time.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <div class="flex items-center gap-2.5 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-xs font-semibold text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <i class="far fa-calendar-alt text-base text-brand-500"></i>
                <span><?= date('l, d F Y') ?></span>
            </div>
            <a href="<?= base_url('admin/siswa') ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-all duration-200 active:scale-[0.97]">
                <i class="fas fa-users text-xs"></i>
                Lihat Pendaftar
            </a>
        </div>
    </div>
</div>

<!-- Key Stat Cards (TailAdmin Metric Cards) -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6 mb-6">
    <!-- Card 1: Total Pendaftar -->
    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-blue-800/50 dark:bg-blue-500/10 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white dark:bg-blue-500/30 dark:text-blue-200">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-white/70 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                <i class="fas fa-database text-[10px]"></i> Total Data
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-blue-700/70 dark:text-blue-300/70">Total Pendaftar</span>
                <h4 class="mt-1 text-2xl font-bold text-blue-900 dark:text-white"><?= number_format($totalPendaftar) ?></h4>
            </div>
            <p class="text-[11px] text-blue-600/60 dark:text-blue-300/60">Semua Calon Siswa</p>
        </div>
    </div>

    <!-- Card 2: Terverifikasi -->
    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-emerald-800/50 dark:bg-emerald-500/10 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 text-white dark:bg-emerald-500/30 dark:text-emerald-200">
                <i class="fas fa-check-double text-xl"></i>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-white/70 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
                <i class="fas fa-shield-alt text-[10px]"></i> Berkas Valid
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-emerald-700/70 dark:text-emerald-300/70">Terverifikasi</span>
                <h4 class="mt-1 text-2xl font-bold text-emerald-900 dark:text-white"><?= number_format($terverifikasi) ?></h4>
            </div>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">
                <?= $totalPendaftar > 0 ? round(($terverifikasi / $totalPendaftar) * 100) : 0 ?>% dari total
            </p>
        </div>
    </div>

    <!-- Card 3: Menunggu Verifikasi -->
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-amber-800/50 dark:bg-amber-500/10 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 text-white dark:bg-amber-500/30 dark:text-amber-200">
                <i class="fas fa-hourglass-half text-xl"></i>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-white/70 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">
                <i class="fas fa-clock text-[10px]"></i> Perlu Cek
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-amber-700/70 dark:text-amber-300/70">Menunggu Review</span>
                <h4 class="mt-1 text-2xl font-bold text-amber-900 dark:text-white"><?= number_format($pending) ?></h4>
            </div>
            <a href="<?= base_url('admin/siswa') ?>" class="text-[11px] text-amber-600 hover:underline dark:text-amber-400 font-medium">
                Proses &rarr;
            </a>
        </div>
    </div>

    <!-- Card 4: Ditolak -->
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-red-800/50 dark:bg-red-500/10 md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-600 text-white dark:bg-red-500/30 dark:text-red-200">
                <i class="fas fa-ban text-xl"></i>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-white/70 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/20 dark:text-red-300">
                <i class="fas fa-times-circle text-[10px]"></i> Ditolak
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-red-700/70 dark:text-red-300/70">Berkas Ditolak</span>
                <h4 class="mt-1 text-2xl font-bold text-red-900 dark:text-white"><?= number_format($ditolak) ?></h4>
            </div>
            <p class="text-[11px] text-red-600/60 dark:text-red-300/60">Perlu Perbaikan</p>
        </div>
    </div>
</div>

<!-- Secondary Quick Stats Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($lakiLaki) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-mars text-blue-500"></i> Laki-laki
        </p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($perempuan) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-venus text-pink-500"></i> Perempuan
        </p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($lulus) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-graduation-cap text-emerald-500"></i> Lulus Seleksi
        </p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($berkasMasuk) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-file-alt text-indigo-500"></i> Berkas Masuk
        </p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($pendingUnlock) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-unlock-alt text-amber-500"></i> Buka Kunci
        </p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-3.5 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="text-lg font-bold text-gray-800 dark:text-white"><?= number_format($jalurOnline) ?></div>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 flex items-center justify-center gap-1">
            <i class="fas fa-globe text-brand-500"></i> Pendaftar Online
        </p>
    </div>
</div>

<!-- Charts & Analytics Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Bar Chart Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] lg:col-span-2 md:p-6">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                    <i class="fas fa-chart-bar text-base"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Tren Pendaftar 7 Hari Terakhir</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Aktivitas registrasi calon peserta didik</p>
                </div>
            </div>
            <span class="rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1 text-[11px] font-medium text-gray-600 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                7 Hari
            </span>
        </div>

        <?php $maxVal = max($trendData) ?: 1; ?>
        <div class="flex items-end gap-3 h-40 pt-4">
            <?php foreach ($trendData as $i => $val): ?>
                <div class="flex-1 flex flex-col items-center gap-2 group">
                    <span class="text-[11px] font-bold text-gray-600 group-hover:text-brand-500 dark:text-gray-400 dark:group-hover:text-brand-400 transition-colors">
                        <?= $val ?>
                    </span>
                    <div class="w-full rounded-lg bg-brand-500/20 group-hover:bg-brand-500 transition-all duration-300 flex items-end overflow-hidden"
                         style="height: 100px;">
                        <div class="w-full bg-brand-500 group-hover:bg-brand-600 transition-all rounded-t-md"
                             style="height: <?= ($val / $maxVal) * 100 ?>%; min-height: <?= $val > 0 ? '6px' : '0' ?>;"></div>
                    </div>
                    <span class="text-[11px] font-medium text-gray-400 dark:text-gray-500"><?= $trendLabels[$i] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top Schools Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] md:p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    <i class="fas fa-school text-base"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Asal Sekolah Terbanyak</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Top kontributor pendaftar</p>
                </div>
            </div>

            <?php if (!empty($topSchools)): ?>
                <?php $maxSchool = max(array_column($topSchools, 'jumlah')) ?: 1; ?>
                <div class="space-y-3 mt-4">
                    <?php foreach ($topSchools as $s): ?>
                        <div>
                            <div class="flex justify-between text-xs mb-1.5">
                                <span class="font-medium text-gray-700 dark:text-gray-300 truncate max-w-[180px]">
                                    <?= esc($s['nama_sekolah']) ?>
                                </span>
                                <span class="font-bold text-gray-900 dark:text-white"><?= $s['jumlah'] ?> siswa</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2 rounded-full transition-all duration-500"
                                     style="width: <?= ($s['jumlah'] / $maxSchool) * 100 ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="py-8 text-center text-xs text-gray-400 dark:text-gray-500">
                    <i class="fas fa-inbox text-3xl text-gray-300 dark:text-gray-700 mb-2"></i>
                    <p>Belum ada data sekolah asal.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 text-right">
            <a href="<?= base_url('admin/laporan') ?>" class="text-xs font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400 transition-colors">
                Laporan Lengkap &rarr;
            </a>
        </div>
    </div>
</div>

<!-- Tables Row: Pendaftar Terbaru & Log Aktivitas (Stack Atas Bawah) -->
<div class="flex flex-col gap-6 mb-6">
    <!-- Pendaftar Terbaru Table -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <i class="fas fa-user-plus text-sm"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Pendaftar Terbaru</h3>
            </div>
            <a href="<?= base_url('admin/siswa') ?>"
               class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500">
                        <th class="py-3 px-5">Siswa</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-5 text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                    <?php if (!empty($recentStudents)) : ?>
                        <?php foreach ($recentStudents as $s) : ?>
                            <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                                <td class="py-3 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 font-bold text-xs dark:bg-brand-500/15 dark:text-brand-400">
                                            <?= strtoupper(substr($s['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <div class="truncate">
                                            <p class="font-semibold text-gray-800 dark:text-gray-100 truncate"><?= esc($s['nama_lengkap']) ?></p>
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500"><?= esc($s['no_pendaftaran']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <?php $sv = $s['status_verifikasi'] ?? ''; ?>
                                    <?php if ($sv === 'Terverifikasi'): ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                        </span>
                                    <?php elseif ($sv === 'Ditolak'): ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-600 dark:bg-red-500/15 dark:text-red-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-5 text-right text-gray-500 dark:text-gray-400 text-[11px]">
                                    <?= $s['tgl_siswa'] ? date('d M Y', strtotime($s['tgl_siswa'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="3" class="py-8 px-5 text-center text-gray-400">Belum ada data pendaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Log Aktivitas Terbaru Table -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    <i class="fas fa-history text-sm"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Log Aktivitas Terbaru</h3>
            </div>
            <a href="<?= base_url('admin/log_aktivitas') ?>"
               class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-600 transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500">
                        <th class="py-3 px-5">Pengguna</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-5 text-right">Waktu Login</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                    <?php if (!empty($activeUsers)) : ?>
                        <?php foreach ($activeUsers as $u) : ?>
                            <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                                <td class="py-3 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="relative h-8 w-8 shrink-0 rounded-full ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($u['nama_lengkap']) ?>&background=random"
                                                 alt="<?= esc($u['nama_lengkap']) ?>" class="h-full w-full object-cover" />
                                        </div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-100 truncate"><?= esc($u['nama_lengkap']) ?></p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <?php $lvl = $u['level'] ?? ''; ?>
                                    <?php if ($lvl === 'admin'): ?>
                                        <span class="inline-flex rounded-md bg-purple-50 px-2 py-0.5 text-[11px] font-semibold text-purple-700 dark:bg-purple-500/15 dark:text-purple-400">Admin</span>
                                    <?php elseif ($lvl === 'siswa'): ?>
                                        <span class="inline-flex rounded-md bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Siswa</span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">Verifikator</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-5 text-right text-gray-500 dark:text-gray-400 text-[11px]">
                                    <div><?= date('d M Y', strtotime($u['last_login'])) ?></div>
                                    <div class="text-[10px] text-gray-400 dark:text-gray-500"><?= date('H:i', strtotime($u['last_login'])) ?> WIB</div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="3" class="py-8 px-5 text-center text-gray-400">Belum ada aktivitas login.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Navigation Action Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="<?= base_url('admin/siswa') ?>"
       class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs transition-all hover:border-brand-500/30 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center gap-3.5 group">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all dark:bg-blue-500/15 dark:text-blue-400">
            <i class="fas fa-user-graduate text-base"></i>
        </div>
        <div class="truncate">
            <p class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-brand-500 transition-colors">Calon Siswa</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate">Kelola data pendaftar</p>
        </div>
    </a>
    <a href="<?= base_url('admin/berkas') ?>"
       class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs transition-all hover:border-emerald-500/30 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center gap-3.5 group">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all dark:bg-emerald-500/15 dark:text-emerald-400">
            <i class="fas fa-file-alt text-base"></i>
        </div>
        <div class="truncate">
            <p class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-emerald-500 transition-colors">Berkas Siswa</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate">Validasi dokumen</p>
        </div>
    </a>
    <a href="<?= base_url('admin/kelulusan') ?>"
       class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs transition-all hover:border-amber-500/30 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center gap-3.5 group">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all dark:bg-amber-500/15 dark:text-amber-400">
            <i class="fas fa-graduation-cap text-base"></i>
        </div>
        <div class="truncate">
            <p class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-amber-500 transition-colors">Kelulusan</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate">Atur status kelulusan</p>
        </div>
    </a>
    <a href="<?= base_url('admin/pengumuman') ?>"
       class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs transition-all hover:border-purple-500/30 hover:shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center gap-3.5 group">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all dark:bg-purple-500/15 dark:text-purple-400">
            <i class="fas fa-bullhorn text-base"></i>
        </div>
        <div class="truncate">
            <p class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-purple-500 transition-colors">Pengumuman</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate">Buat informasi publik</p>
        </div>
    </a>
</div>

<?= $this->endSection() ?>
