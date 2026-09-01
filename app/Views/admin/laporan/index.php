<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Laporan & Analisis
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">analytics</span> Laporan & Analisis Data
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Card -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/50 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-xs">insights</span>
                    Rekapitulasi Data
                </span>
                <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">&bull; Real-time Statistik</span>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-2xl">
                Analisis & Rekap Data PPDB
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl">
                Rangkuman statistik demografi, verifikasi berkas, status kelulusan, dan sebaran asal calon peserta didik.
            </p>
        </div>

        <div class="flex items-center gap-3 self-stretch md:self-auto justify-end">
            <a href="<?= base_url('admin/laporan/cetak') ?>" target="_blank"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">print</span>
                <span>Cetak Laporan PDF</span>
            </a>
        </div>
    </div>
</div>

<!-- Key Metric Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6 mb-6">
    <!-- Card 1: Total Pendaftar -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
                Total Data
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pendaftar</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($statistik['total_pendaftar'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium">Semua Jalur</p>
        </div>
    </div>

    <!-- Card 2: Terverifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">verified</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                Valid
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Terverifikasi</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($statistik['terverifikasi'] ?? 0) ?></h4>
            </div>
            <?php 
                $pctVerif = ($statistik['total_pendaftar'] ?? 0) > 0 ? round((($statistik['terverifikasi'] ?? 0) / $statistik['total_pendaftar']) * 100) : 0;
            ?>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold"><?= $pctVerif ?>% selesai</p>
        </div>
    </div>

    <!-- Card 3: Menunggu Verifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">hourglass_top</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                Antrean
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Menunggu Review</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($statistik['menunggu'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-amber-600 dark:text-amber-400 font-medium">Perlu Cek</p>
        </div>
    </div>

    <!-- Card 4: Ditolak -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-600 dark:bg-red-500/15 dark:text-red-400 border border-red-200/50 dark:border-red-500/20">
                Ditolak
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Ditolak</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($statistik['ditolak'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-red-500 dark:text-red-400 font-medium">Tidak Lolos</p>
        </div>
    </div>
</div>

<!-- Section: Demografi & Jalur Pendaftaran -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Card: Status & Demografi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Demografi & Status Kelulusan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sebaran gender dan rekap kelulusan siswa</p>
            </div>
            <span class="material-symbols-outlined text-brand-500 text-2xl">pie_chart</span>
        </div>

        <!-- Gender Breakdown -->
        <div class="mb-6">
            <div class="flex items-center justify-between text-xs font-semibold mb-2">
                <span class="text-gray-700 dark:text-gray-300">Komposisi Jenis Kelamin</span>
                <span class="text-gray-400">Total: <?= ($gender['L'] ?? 0) + ($gender['P'] ?? 0) ?> Siswa</span>
            </div>

            <?php 
                $totalGender = ($gender['L'] ?? 0) + ($gender['P'] ?? 0);
                $pctL = $totalGender > 0 ? round((($gender['L'] ?? 0) / $totalGender) * 100) : 0;
                $pctP = $totalGender > 0 ? round((($gender['P'] ?? 0) / $totalGender) * 100) : 0;
            ?>

            <div class="flex justify-between items-center text-xs mb-2">
                <span class="inline-flex items-center gap-1.5 font-bold text-blue-600 dark:text-blue-400">
                    <span class="material-symbols-outlined text-sm">male</span>
                    Laki-laki (<?= $gender['L'] ?? 0 ?>) &bull; <?= $pctL ?>%
                </span>
                <span class="inline-flex items-center gap-1.5 font-bold text-pink-600 dark:text-pink-400">
                    <?= $pctP ?>% &bull; Perempuan (<?= $gender['P'] ?? 0 ?>)
                    <span class="material-symbols-outlined text-sm">female</span>
                </span>
            </div>

            <!-- Progress Bar Split -->
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-3.5 overflow-hidden flex shadow-inner">
                <div class="bg-blue-500 transition-all duration-500" style="width: <?= $pctL ?>%" title="Laki-laki: <?= $pctL ?>%"></div>
                <div class="bg-pink-500 transition-all duration-500" style="width: <?= $pctP ?>%" title="Perempuan: <?= $pctP ?>%"></div>
            </div>
        </div>

        <!-- Kelulusan Status Boxes -->
        <div>
            <span class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-3">Hasil Seleksi & Kelulusan</span>
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-xl border border-emerald-200/70 bg-emerald-50/50 dark:border-emerald-500/20 dark:bg-emerald-500/10 p-3.5 text-center">
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400"><?= number_format($kelulusan['lulus'] ?? 0) ?></p>
                    <p class="text-[11px] font-semibold text-emerald-800 dark:text-emerald-300 uppercase tracking-wider mt-0.5">Lulus</p>
                </div>

                <div class="rounded-xl border border-red-200/70 bg-red-50/50 dark:border-red-500/20 dark:bg-red-500/10 p-3.5 text-center">
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400"><?= number_format($kelulusan['tidak_lulus'] ?? 0) ?></p>
                    <p class="text-[11px] font-semibold text-red-800 dark:text-red-300 uppercase tracking-wider mt-0.5">Tidak Lulus</p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/60 p-3.5 text-center">
                    <p class="text-2xl font-bold text-gray-700 dark:text-gray-300"><?= number_format($kelulusan['belum_diproses'] ?? 0) ?></p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-0.5">Belum Diproses</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card: Jalur Pendaftaran -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Jalur Pendaftaran</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Distribusi siswa berdasarkan jalur pendaftaran</p>
            </div>
            <span class="material-symbols-outlined text-brand-500 text-2xl">alt_route</span>
        </div>

        <div class="space-y-4">
            <?php if (empty($jalur)): ?>
                <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                    <span class="material-symbols-outlined text-3xl mb-1">inbox</span>
                    <p class="text-xs">Belum ada data jalur pendaftaran.</p>
                </div>
            <?php else: ?>
                <?php 
                $barColors = ['bg-brand-500', 'bg-emerald-500', 'bg-amber-500', 'bg-purple-500', 'bg-blue-500'];
                $i = 0;
                foreach ($jalur as $name => $count): 
                    $total = $statistik['total_pendaftar'] ?? 1;
                    $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                    $color = $barColors[$i % count($barColors)];
                    $i++;
                ?>
                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($name) ?></span>
                        <span class="font-semibold text-gray-500 dark:text-gray-400">
                            <b><?= number_format($count) ?></b> Siswa (<?= $pct ?>%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2.5 overflow-hidden">
                        <div class="<?= $color ?> h-2.5 rounded-full transition-all duration-500" style="width: <?= $pct ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Section: Top Asal Sekolah & Top Kecamatan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Top 5 Asal Sekolah -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500 text-xl">school</span>
                    Top 5 Asal Sekolah
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sekolah penyumbang pendaftar terbanyak</p>
            </div>
            <span class="text-xs font-semibold text-gray-400">Peringkat</span>
        </div>

        <?php if (empty($topSekolah)): ?>
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <span class="material-symbols-outlined text-3xl mb-1">school</span>
                <p class="text-xs">Belum ada data asal sekolah.</p>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($topSekolah as $index => $sekolah): ?>
                <li class="py-3 flex justify-between items-center hover:bg-gray-50/60 dark:hover:bg-gray-800/30 rounded-xl px-2.5 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 pr-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-xs font-bold text-gray-700 dark:text-gray-300">
                            <?= $index + 1 ?>
                        </span>
                        <span class="font-semibold text-xs md:text-sm text-gray-900 dark:text-white truncate">
                            <?= strtoupper(esc($sekolah['nama_sekolah'])) ?>
                        </span>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                        <?= number_format($sekolah['total']) ?> Siswa
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Top 5 Sebaran Wilayah (Kecamatan) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500 text-xl">location_on</span>
                    Top 5 Sebaran Kecamatan
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Wilayah asal pendaftar tertinggi</p>
            </div>
            <span class="text-xs font-semibold text-gray-400">Peringkat</span>
        </div>

        <?php if (empty($topWilayah)): ?>
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <span class="material-symbols-outlined text-3xl mb-1">map</span>
                <p class="text-xs">Belum ada data wilayah kecamatan.</p>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($topWilayah as $index => $wilayah): ?>
                <li class="py-3 flex justify-between items-center hover:bg-gray-50/60 dark:hover:bg-gray-800/30 rounded-xl px-2.5 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 pr-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-xs font-bold text-gray-700 dark:text-gray-300">
                            <?= $index + 1 ?>
                        </span>
                        <span class="font-semibold text-xs md:text-sm text-gray-900 dark:text-white truncate">
                            <?= ucwords(strtolower(esc($wilayah['kec']))) ?>
                        </span>
                    </div>
                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
                        <?= number_format($wilayah['total']) ?> Pendaftar
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
