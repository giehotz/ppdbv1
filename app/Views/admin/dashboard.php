<?= $this->extend('layouts/admin') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Overview<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white relative overflow-hidden">
    <div class="relative z-10">
        <h2 class="text-2xl font-bold mb-1">Selamat Datang di Dashboard Admin</h2>
        <p class="text-emerald-50">Pantau dan kelola seluruh aktivitas Penerimaan Peserta Didik Baru dengan mudah.</p>
    </div>
    <div class="relative z-10 mt-4 md:mt-0">
        <div class="bg-white/20 backdrop-blur-md rounded-xl px-4 py-2 border border-white/30 flex items-center gap-3">
            <i class="far fa-calendar-alt text-lg"></i>
            <span class="font-medium"><?= date('l, d F Y') ?></span>
        </div>
    </div>
    <div class="absolute right-0 top-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
    <div class="absolute right-32 bottom-0 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-lg shadow-blue-500/30 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-6 -top-6 text-white opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i class="fas fa-users text-9xl"></i>
        </div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm text-blue-100 font-medium tracking-wide uppercase mb-1">Total Pendaftar</p>
                <div class="text-4xl font-extrabold text-white mb-2"><?= $totalPendaftar ?></div>
                <p class="text-xs text-blue-200 flex items-center"><i class="fas fa-arrow-up mr-1"></i> Semua data masuk</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 text-white"><i class="fas fa-users text-xl"></i></div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg shadow-emerald-500/30 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-6 -top-6 text-white opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i class="fas fa-check-circle text-9xl"></i>
        </div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm text-emerald-100 font-medium tracking-wide uppercase mb-1">Terverifikasi</p>
                <div class="text-4xl font-extrabold text-white mb-2"><?= $terverifikasi ?></div>
                <p class="text-xs text-emerald-200 flex items-center"><i class="fas fa-shield-check mr-1"></i> Berkas valid</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 text-white"><i class="fas fa-check-double text-xl"></i></div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl shadow-lg shadow-amber-500/30 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-6 -top-6 text-white opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i class="fas fa-clock text-9xl"></i>
        </div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm text-amber-50 font-medium tracking-wide uppercase mb-1">Menunggu</p>
                <div class="text-4xl font-extrabold text-white mb-2"><?= $pending ?></div>
                <p class="text-xs text-amber-100 flex items-center"><i class="fas fa-hourglass-half mr-1"></i> Perlu diproses</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 text-white"><i class="fas fa-spinner text-xl"></i></div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl shadow-lg shadow-red-500/30 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-6 -top-6 text-white opacity-10 group-hover:scale-110 transition-transform duration-500">
            <i class="fas fa-times-circle text-9xl"></i>
        </div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm text-rose-100 font-medium tracking-wide uppercase mb-1">Ditolak</p>
                <div class="text-4xl font-extrabold text-white mb-2"><?= $ditolak ?></div>
                <p class="text-xs text-rose-200 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> Perlu review</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 text-white"><i class="fas fa-ban text-xl"></i></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $lakiLaki ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-mars text-blue-500"></i> Laki-laki</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $perempuan ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-venus text-pink-500"></i> Perempuan</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $lulus ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-graduation-cap text-green-600"></i> Lulus</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $berkasMasuk ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-file-alt text-blue-600"></i> Berkas Masuk</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $berkasValid ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-check-circle text-emerald-600"></i> Berkas Valid</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $pendingUnlock ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-unlock-alt text-amber-600"></i> Buka Kunci</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $pengumumanAktif ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-bullhorn text-purple-600"></i> Pengumuman</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-gray-800"><?= $jalurOnline ?></div>
        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-globe text-cyan-600"></i> Online</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
        <div class="flex items-center gap-3 mb-5">
            <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fas fa-chart-line"></i></div>
            <h3 class="font-bold text-gray-800">Pendaftar 7 Hari Terakhir</h3>
        </div>
        <?php $maxVal = max($trendData) ?: 1; ?>
        <div class="flex items-end gap-2 h-32">
            <?php foreach ($trendData as $i => $val): ?>
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-xs font-bold text-gray-600"><?= $val ?></span>
                    <div class="w-full rounded-md bg-green-500 transition-all duration-500 hover:bg-green-600"
                         style="height: <?= ($val / $maxVal) * 100 ?>%; min-height: <?= $val > 0 ? '4px' : '0' ?>"></div>
                    <span class="text-xs text-gray-400"><?= $trendLabels[$i] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="bg-purple-100 text-purple-600 p-2 rounded-lg"><i class="fas fa-school"></i></div>
            <h3 class="font-bold text-gray-800">Sekolah Terbanyak</h3>
        </div>
        <?php if (!empty($topSchools)): ?>
            <?php $maxSchool = max(array_column($topSchools, 'jumlah')) ?: 1; ?>
            <div class="space-y-3">
                <?php foreach ($topSchools as $s): ?>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 truncate"><?= esc($s['nama_sekolah']) ?></span>
                            <span class="font-bold text-gray-800"><?= $s['jumlah'] ?></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full h-2 transition-all"
                                 style="width: <?= ($s['jumlah'] / $maxSchool) * 100 ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-400 text-sm text-center py-6">Belum ada data sekolah.</p>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full flex flex-col overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fas fa-user-plus"></i></div>
                <h3 class="font-bold text-gray-800 text-lg">Pendaftar Terbaru</h3>
            </div>
            <a href="<?= base_url('admin/siswa') ?>"
               class="text-sm bg-white border border-gray-200 text-gray-600 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 px-4 py-2 rounded-lg font-medium transition-all">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs tracking-wider border-b border-gray-100">
                        <th class="py-4 px-4 font-semibold">Siswa</th>
                        <th class="py-4 px-4 font-semibold">Status</th>
                        <th class="py-4 px-4 font-semibold text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    <?php if (!empty($recentStudents)) : ?>
                        <?php foreach ($recentStudents as $s) : ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors group">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 flex items-center justify-center font-bold text-sm shadow-inner shrink-0">
                                            <?= strtoupper(substr($s['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors"><?= esc($s['nama_lengkap']) ?></p>
                                            <p class="text-xs text-gray-500"><?= esc($s['no_pendaftaran']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <?php $sv = $s['status_verifikasi'] ?? ''; ?>
                                    <?php if ($sv === 'Terverifikasi'): ?>
                                        <span class="inline-flex items-center bg-emerald-50 text-emerald-600 py-1 px-2.5 rounded-md text-xs font-semibold border border-emerald-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></div> Terverifikasi
                                        </span>
                                    <?php elseif ($sv === 'Ditolak'): ?>
                                        <span class="inline-flex items-center bg-red-50 text-red-600 py-1 px-2.5 rounded-md text-xs font-semibold border border-red-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></div> Ditolak
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center bg-amber-50 text-amber-600 py-1 px-2.5 rounded-md text-xs font-semibold border border-amber-100">
                                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></div> Menunggu
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-right text-gray-500 text-xs">
                                    <?= $s['tgl_siswa'] ? date('d M Y', strtotime($s['tgl_siswa'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="3" class="py-10 px-6 text-center text-gray-400">Belum ada data pendaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 h-full flex flex-col overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="bg-purple-100 text-purple-600 p-2 rounded-lg"><i class="fas fa-history"></i></div>
                <h3 class="font-bold text-gray-800 text-lg">Log Aktivitas Terbaru</h3>
            </div>
            <a href="<?= base_url('admin/log_aktivitas') ?>"
               class="text-sm bg-white border border-gray-200 text-gray-600 hover:text-purple-600 hover:border-purple-200 hover:bg-purple-50 px-4 py-2 rounded-lg font-medium transition-all">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs tracking-wider border-b border-gray-100">
                        <th class="py-4 px-4 font-semibold">Pengguna</th>
                        <th class="py-4 px-4 font-semibold">Akses</th>
                        <th class="py-4 px-4 font-semibold text-right">Waktu Login</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    <?php if (!empty($activeUsers)) : ?>
                        <?php foreach ($activeUsers as $u) : ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors group">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="relative shrink-0 mr-3">
                                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm"
                                                 src="https://ui-avatars.com/api/?name=<?= urlencode($u['nama_lengkap']) ?>&background=random"
                                                 alt="<?= esc($u['nama_lengkap']) ?>" />
                                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                                        </div>
                                        <p class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors"><?= esc($u['nama_lengkap']) ?></p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <?php $lvl = $u['level'] ?? ''; ?>
                                    <?php if ($lvl === 'admin'): ?>
                                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">Admin</span>
                                    <?php elseif ($lvl === 'siswa'): ?>
                                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Siswa</span>
                                    <?php else: ?>
                                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">Verifikator</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="inline-flex flex-col items-end">
                                        <span class="text-gray-800 font-medium text-xs"><?= date('d M Y', strtotime($u['last_login'])) ?></span>
                                        <span class="text-gray-500 text-xs flex items-center mt-0.5">
                                            <i class="far fa-clock mr-1"></i> <?= date('H:i', strtotime($u['last_login'])) ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="3" class="py-10 px-6 text-center text-gray-400">Belum ada aktivitas login.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($latestAnnouncements)) : ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
        <div class="bg-amber-100 text-amber-600 p-2 rounded-lg"><i class="fas fa-bullhorn"></i></div>
        <h3 class="font-bold text-gray-800">Pengumuman Aktif</h3>
    </div>
    <div class="divide-y divide-gray-100">
        <?php foreach ($latestAnnouncements as $a) : ?>
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 rounded-full bg-green-500 mt-2 shrink-0"></div>
                    <div>
                        <p class="font-semibold text-gray-800"><?= esc($a['judul']) ?></p>
                        <p class="text-sm text-gray-500 mt-0.5"><?= substr(strip_tags($a['isi_pengumuman']), 0, 120) ?>...</p>
                        <p class="text-xs text-gray-400 mt-1">
                            <i class="far fa-calendar-alt mr-1"></i> <?= $a['publish_date'] ? date('d M Y H:i', strtotime($a['publish_date'])) : 'Sekarang' ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="<?= base_url('admin/siswa') ?>"
       class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4 group">
        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center shrink-0 group-hover:bg-blue-200 transition-colors">
            <i class="fas fa-user-graduate text-blue-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-800">Calon Siswa</p>
            <p class="text-xs text-gray-400">Kelola data siswa</p>
        </div>
    </a>
    <a href="<?= base_url('admin/berkas') ?>"
       class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4 group">
        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-200 transition-colors">
            <i class="fas fa-file-alt text-emerald-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-800">Berkas</p>
            <p class="text-xs text-gray-400">Validasi berkas siswa</p>
        </div>
    </a>
    <a href="<?= base_url('admin/kelulusan') ?>"
       class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4 group">
        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center shrink-0 group-hover:bg-amber-200 transition-colors">
            <i class="fas fa-graduation-cap text-amber-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-800">Kelulusan</p>
            <p class="text-xs text-gray-400">Atur status kelulusan</p>
        </div>
    </a>
    <a href="<?= base_url('admin/pengumuman') ?>"
       class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4 group">
        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center shrink-0 group-hover:bg-purple-200 transition-colors">
            <i class="fas fa-bullhorn text-purple-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-800">Pengumuman</p>
            <p class="text-xs text-gray-400">Buat pengumuman</p>
        </div>
    </a>
</div>

<?= $this->endSection() ?>
