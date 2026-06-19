<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Dashboard Verifikator
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Verifikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$total = max($total_pendaftar, 1);
$verifikasiProgress = round(($terverifikasi + $ditolak) / $total * 100);
?>

<!-- Welcome Banner -->
<div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-6 md:p-8 mb-8 text-white">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-60 h-60 bg-white rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-300 rounded-full blur-3xl"></div>
    </div>
    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex w-16 h-16 bg-white/20 backdrop-blur rounded-full items-center justify-center">
                <i class="fas fa-user-check text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-white">Selamat Datang, <?= esc(session()->get('nama_lengkap')) ?>!</h2>
                <p class="text-white/80 mt-1">Anda login sebagai <span class="font-semibold text-white">Verifikator</span>. Silakan periksa data siswa dan berkas pendaftaran.</p>
            </div>
        </div>
        <div class="flex items-center gap-3 text-sm bg-white/10 backdrop-blur rounded-xl px-4 py-2.5 shrink-0">
            <i class="fas fa-calendar-alt text-white/70"></i>
            <span class="text-white/80"><?= date('l, d F Y') ?></span>
        </div>
    </div>
</div>

<!-- Verification Progress Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                <i class="fas fa-chart-line text-sm"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">Progress Verifikasi</h3>
                <p class="text-xs text-gray-400"><?= number_format($verifikasiProgress) ?>% dari <?= $total_pendaftar ?> pendaftar telah diverifikasi</p>
            </div>
        </div>
        <span class="text-lg font-bold text-gray-800"><?= $verifikasiProgress ?>%</span>
    </div>
    <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 via-indigo-500 to-indigo-700 transition-all duration-700" style="width: <?= $verifikasiProgress ?>%"></div>
    </div>
    <div class="flex justify-between mt-2 text-xs text-gray-400">
        <span>0%</span>
        <span>50%</span>
        <span>100%</span>
    </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                <i class="fas fa-users text-blue-600 text-lg"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= number_format($total_pendaftar) ?></span>
        </div>
        <p class="text-sm font-medium text-gray-500">Total Pendaftar</p>
        <div class="mt-2 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-blue-500 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                <i class="fas fa-clock text-amber-600 text-lg"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= number_format($menunggu_verifikasi) ?></span>
        </div>
        <p class="text-sm font-medium text-gray-500">Menunggu Verifikasi</p>
        <div class="mt-2 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-amber-400 rounded-full" style="width: <?= $total > 1 ? round($menunggu_verifikasi / $total * 100) : 0 ?>%"></div>
        </div>
    </div>

    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= number_format($terverifikasi) ?></span>
        </div>
        <p class="text-sm font-medium text-gray-500">Terverifikasi</p>
        <div class="mt-2 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-emerald-500 rounded-full" style="width: <?= $total > 1 ? round($terverifikasi / $total * 100) : 0 ?>%"></div>
        </div>
    </div>

    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                <i class="fas fa-times-circle text-red-600 text-lg"></i>
            </div>
            <span class="text-3xl font-bold text-gray-800"><?= number_format($ditolak) ?></span>
        </div>
        <p class="text-sm font-medium text-gray-500">Ditolak</p>
        <div class="mt-2 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-red-500 rounded-full" style="width: <?= $total > 1 ? round($ditolak / $total * 100) : 0 ?>%"></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mb-6">
    <!-- Pendaftar Terbaru -->
    <div class="lg:col-span-4 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Pendaftar Terbaru</h3>
            </div>
            <a href="<?= base_url('verifikator/siswa') ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
                Lihat Semua <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-500 text-xs font-semibold uppercase tracking-wider">
                        <th class="py-3.5 px-6">No. Daftar</th>
                        <th class="py-3.5 px-6">Nama Siswa</th>
                        <th class="py-3.5 px-6 hidden sm:table-cell">Jurusan</th>
                        <th class="py-3.5 px-6">Tgl. Daftar</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php if (!empty($recentStudents)) : ?>
                        <?php foreach ($recentStudents as $s) : ?>
                            <tr class="border-t border-gray-50 hover:bg-blue-50/40 transition-colors">
                                <td class="py-3.5 px-6">
                                    <span class="font-mono text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-medium"><?= esc($s['no_pendaftaran']) ?></span>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="font-medium text-gray-800"><?= esc($s['nama_lengkap']) ?></span>
                                    <?php if (!empty($s['nisn'])): ?>
                                        <span class="text-xs text-gray-400 block">NISN: <?= esc($s['nisn']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-6 hidden sm:table-cell">
                                    <?php $jurusan = $s['komp_ahli'] ?? '-'; ?>
                                    <?php if ($jurusan !== '-'): ?>
                                        <span class="inline-flex items-center gap-1 text-xs bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full font-medium">
                                            <i class="fas fa-graduation-cap text-[10px]"></i>
                                            <?= esc($jurusan) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="text-gray-600 text-xs"><?= !empty($s['tgl_siswa']) && strtotime($s['tgl_siswa']) ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="py-12 px-6 text-center">
                                <div class="flex flex-col items-center text-gray-400">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                    <p class="font-medium text-gray-500">Belum ada data pendaftar</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aksi Cepat & Info -->
    <div class="lg:col-span-3 space-y-6">
        <!-- Aksi Cepat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800">Aksi Cepat</h3>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-2 gap-3">
                    <a href="<?= base_url('verifikator/siswa') ?>"
                        class="flex flex-col items-center justify-center p-4 rounded-xl bg-blue-50/50 border border-blue-200 hover:bg-blue-50 hover:border-blue-400 hover:shadow-md transition-all duration-300 group">
                        <i class="fas fa-user-check text-2xl text-blue-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold text-blue-700">Verifikasi Siswa</span>
                    </a>
                    <a href="<?= base_url('verifikator/berkas') ?>"
                        class="flex flex-col items-center justify-center p-4 rounded-xl bg-emerald-50/50 border border-emerald-200 hover:bg-emerald-50 hover:border-emerald-400 hover:shadow-md transition-all duration-300 group">
                        <i class="fas fa-file-signature text-2xl text-emerald-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold text-emerald-700">Verifikasi Berkas</span>
                    </a>
                    <a href="<?= base_url('verifikator/pesan/create') ?>"
                        class="flex flex-col items-center justify-center p-4 rounded-xl bg-purple-50/50 border border-purple-200 hover:bg-purple-50 hover:border-purple-400 hover:shadow-md transition-all duration-300 group">
                        <i class="fas fa-paper-plane text-2xl text-purple-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold text-purple-700">Kirim Pesan</span>
                    </a>
                    <a href="<?= base_url('verifikator/unlockrequest') ?>"
                        class="flex flex-col items-center justify-center p-4 rounded-xl bg-amber-50/50 border border-amber-200 hover:bg-amber-50 hover:border-amber-400 hover:shadow-md transition-all duration-300 group">
                        <i class="fas fa-unlock-alt text-2xl text-amber-600 mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-semibold text-amber-700">Buka Kunci</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ringkasan Verifikasi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-chart-pie text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800">Ringkasan Status</h3>
                </div>
            </div>
            <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                <!-- Terverifikasi -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            Terverifikasi
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800"><?= number_format($terverifikasi) ?></span>
                            <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md min-w-[3rem] text-center"><?= round(($terverifikasi / $total) * 100) ?>%</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: <?= round(($terverifikasi / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Menunggu -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <i class="fas fa-clock text-amber-500"></i>
                            Menunggu
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800"><?= number_format($menunggu_verifikasi) ?></span>
                            <span class="text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-md min-w-[3rem] text-center"><?= round(($menunggu_verifikasi / $total) * 100) ?>%</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-amber-400 h-2 rounded-full" style="width: <?= round(($menunggu_verifikasi / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Ditolak -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <i class="fas fa-times-circle text-red-500"></i>
                            Ditolak
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800"><?= number_format($ditolak) ?></span>
                            <span class="text-xs font-semibold text-red-700 bg-red-50 border border-red-100 px-2 py-0.5 rounded-md min-w-[3rem] text-center"><?= round(($ditolak / $total) * 100) ?>%</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: <?= round(($ditolak / $total) * 100) ?>%"></div>
                    </div>
                </div>

                <!-- Total -->
                <div class="pt-3 border-t border-gray-100">
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3 border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-500">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Total Pendaftar</span>
                        </div>
                        <span class="text-lg font-bold text-indigo-600"><?= number_format($total_pendaftar) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
