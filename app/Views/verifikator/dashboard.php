<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Dashboard Verifikator<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">dashboard</span> Dashboard Verifikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$total = max($total_pendaftar, 1);
$verifikasiProgress = round(($terverifikasi + $ditolak) / $total * 100);
?>

<!-- Welcome Banner (TailAdmin Card Style) -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 md:p-7 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
        <div class="space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sesi Verifikator Aktif
                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200 dark:border-brand-800/50">
                    <span class="material-symbols-outlined text-xs">verified_user</span>
                    Verifikasi Dokumen &amp; Data Siswa
                </span>
            </div>
            <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:text-3xl dark:text-white">
                Selamat Datang, <?= esc(session()->get('nama_lengkap') ?: session()->get('username') ?: 'Verifikator') ?>! 👋
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                Periksa kelengkapan berkas fisik/digital pendaftar, validasi data biodata, dan kelola antrean pembukaan kunci secara real-time.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <div class="flex items-center gap-2.5 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-xs font-semibold text-gray-700 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-base text-brand-500">calendar_today</span>
                <span><?= date('l, d F Y') ?></span>
            </div>
            <a href="<?= base_url('verifikator/berkas') ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-all duration-200 active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">fact_check</span>
                <span>Mulai Verifikasi</span>
            </a>
        </div>
    </div>
</div>

<!-- Verification Progress Card (TailAdmin Style) -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-xl">trending_up</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Progress Verifikasi Berkas</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400"><?= number_format($verifikasiProgress) ?>% dari total <?= number_format($total_pendaftar) ?> pendaftar telah diproses</p>
            </div>
        </div>
        <span class="text-xl font-extrabold text-brand-600 dark:text-brand-400 font-mono"><?= $verifikasiProgress ?>%</span>
    </div>
    
    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-3.5 overflow-hidden p-0.5">
        <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-brand-600 transition-all duration-700 shadow-theme-xs" style="width: <?= $verifikasiProgress ?>%"></div>
    </div>
    
    <div class="flex justify-between mt-2 text-[11px] font-semibold text-gray-400 dark:text-gray-500">
        <span>0% Dimulai</span>
        <span>50% Target</span>
        <span>100% Selesai</span>
    </div>
</div>

<!-- Key Stat Cards (TailAdmin Metric Cards) -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6 mb-6">
    <!-- Total Pendaftar -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
            <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                Semua Siswa
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pendaftar</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($total_pendaftar) ?></h4>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500">Dalam Sistem</p>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">hourglass_top</span>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                Perlu Review
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($menunggu_verifikasi) ?></h4>
            </div>
            <a href="<?= base_url('verifikator/berkas') ?>" class="text-[11px] font-semibold text-amber-600 hover:underline dark:text-amber-400">
                Proses &rarr;
            </a>
        </div>
    </div>

    <!-- Terverifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                Dokumen Valid
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Terverifikasi</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($terverifikasi) ?></h4>
            </div>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">
                <?= $total > 1 ? round(($terverifikasi / $total) * 100) : 0 ?>% dari total
            </p>
        </div>
    </div>

    <!-- Ditolak / Invalid -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                Perlu Perbaikan
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Ditolak</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($ditolak) ?></h4>
            </div>
            <p class="text-[11px] text-red-600 dark:text-red-400 font-semibold">
                <?= $total > 1 ? round(($ditolak / $total) * 100) : 0 ?>% dari total
            </p>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mb-6">
    
    <!-- Pendaftar Terbaru (Left Area - 4 Cols) -->
    <div class="lg:col-span-4 rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden flex flex-col">
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pendaftar Terbaru</h3>
            </div>
            <a href="<?= base_url('verifikator/siswa') ?>" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-xs">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:bg-gray-800/30 dark:text-gray-500">
                        <th class="py-3.5 px-5">No. Daftar</th>
                        <th class="py-3.5 px-5">Nama Calon Siswa</th>
                        <th class="py-3.5 px-5 hidden sm:table-cell">Jurusan</th>
                        <th class="py-3.5 px-5">Tgl. Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                    <?php if (!empty($recentStudents)) : ?>
                        <?php foreach ($recentStudents as $s) : 
                            $inisial = mb_substr(trim($s['nama_lengkap']), 0, 1);
                        ?>
                            <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <span class="inline-flex rounded-lg bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        <?= esc($s['no_pendaftaran']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="h-7 w-7 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                            <?= esc($inisial) ?>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 dark:text-white block"><?= esc($s['nama_lengkap']) ?></span>
                                            <?php if (!empty($s['nisn'])): ?>
                                                <span class="text-[11px] text-gray-400 dark:text-gray-500 font-mono">NISN: <?= esc($s['nisn']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 hidden sm:table-cell">
                                    <?php $jurusan = $s['komp_ahli'] ?? '-'; ?>
                                    <?php if ($jurusan !== '-'): ?>
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-300 px-2 py-0.5 rounded-md">
                                            <span class="material-symbols-outlined text-[12px]">school</span>
                                            <?= esc($jurusan) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-gray-500 dark:text-gray-400 font-medium">
                                    <?= !empty($s['tgl_siswa']) && strtotime($s['tgl_siswa']) ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="py-12 px-5 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-gray-300 dark:text-gray-600">inbox</span>
                                    <p class="text-xs font-semibold">Belum ada data pendaftar baru</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Action & Breakdown (Right Area - 3 Cols) -->
    <div class="lg:col-span-3 space-y-6">
        
        <!-- Aksi Cepat (TailAdmin Cards) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-lg">bolt</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Aksi Cepat Verifikator</h3>
            </div>
            
            <div class="grid grid-cols-2 gap-2.5">
                <a href="<?= base_url('verifikator/siswa') ?>"
                    class="flex flex-col items-center justify-center p-3.5 rounded-xl bg-blue-50/50 border border-blue-100 hover:bg-blue-100/60 dark:bg-blue-500/10 dark:border-blue-500/20 dark:hover:bg-blue-500/20 transition-all group text-center">
                    <span class="material-symbols-outlined text-2xl text-blue-600 dark:text-blue-400 mb-1.5 group-hover:scale-110 transition-transform">how_to_reg</span>
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Data Siswa</span>
                </a>
                
                <a href="<?= base_url('verifikator/berkas') ?>"
                    class="flex flex-col items-center justify-center p-3.5 rounded-xl bg-emerald-50/50 border border-emerald-100 hover:bg-emerald-100/60 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:hover:bg-emerald-500/20 transition-all group text-center">
                    <span class="material-symbols-outlined text-2xl text-emerald-600 dark:text-emerald-400 mb-1.5 group-hover:scale-110 transition-transform">folder_managed</span>
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Verifikasi Berkas</span>
                </a>
                
                <a href="<?= base_url('verifikator/pesan/create') ?>"
                    class="flex flex-col items-center justify-center p-3.5 rounded-xl bg-purple-50/50 border border-purple-100 hover:bg-purple-100/60 dark:bg-purple-500/10 dark:border-purple-500/20 dark:hover:bg-purple-500/20 transition-all group text-center">
                    <span class="material-symbols-outlined text-2xl text-purple-600 dark:text-purple-400 mb-1.5 group-hover:scale-110 transition-transform">send</span>
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Kirim Pesan</span>
                </a>
                
                <a href="<?= base_url('verifikator/unlockrequest') ?>"
                    class="flex flex-col items-center justify-center p-3.5 rounded-xl bg-amber-50/50 border border-amber-100 hover:bg-amber-100/60 dark:bg-amber-500/10 dark:border-amber-500/20 dark:hover:bg-amber-500/20 transition-all group text-center">
                    <span class="material-symbols-outlined text-2xl text-amber-600 dark:text-amber-400 mb-1.5 group-hover:scale-110 transition-transform">lock_open</span>
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Buka Kunci</span>
                </a>
            </div>
        </div>

        <!-- Ringkasan Status Verifikasi -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                    <span class="material-symbols-outlined text-lg">pie_chart</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Rincian Status Berkas</h3>
            </div>

            <div class="space-y-3.5">
                <!-- Terverifikasi -->
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Terverifikasi
                        </span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            <?= number_format($terverifikasi) ?> <span class="text-gray-400 font-normal">(<?= round(($terverifikasi / $total) * 100) ?>%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: <?= round(($terverifikasi / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Menunggu -->
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Menunggu Verifikasi
                        </span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            <?= number_format($menunggu_verifikasi) ?> <span class="text-gray-400 font-normal">(<?= round(($menunggu_verifikasi / $total) * 100) ?>%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                        <div class="bg-amber-400 h-2 rounded-full" style="width: <?= round(($menunggu_verifikasi / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Ditolak -->
                <div>
                    <div class="flex items-center justify-between mb-1 text-xs">
                        <span class="font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Berkas Ditolak
                        </span>
                        <span class="font-bold text-gray-900 dark:text-white">
                            <?= number_format($ditolak) ?> <span class="text-gray-400 font-normal">(<?= round(($ditolak / $total) * 100) ?>%)</span>
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                        <div class="bg-red-500 h-2 rounded-full" style="width: <?= round(($ditolak / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Total Container -->
                <div class="pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Total Keseluruhan</span>
                    <span class="text-sm font-extrabold text-brand-600 dark:text-brand-400"><?= number_format($total_pendaftar) ?> Siswa</span>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
