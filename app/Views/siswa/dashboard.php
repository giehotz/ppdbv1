<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Dashboard Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">dashboard</span> Dashboard Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$nisnSiswa = $siswa['nisn'] ?? session()->get('nisn');
$fotoSiswa = $siswa['foto'] ?? session()->get('foto');
$pathFoto = 'uploads/berkas/' . $nisnSiswa . '/' . $fotoSiswa;
$adaFoto = !empty($fotoSiswa) && file_exists(FCPATH . $pathFoto);
$inisial = mb_substr(trim($siswa['nama_lengkap'] ?? 'S'), 0, 1);
?>

<!-- Welcome Banner (TailAdmin Card Style) -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 md:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
        
        <!-- Left Side: Profile & Details -->
        <div class="flex items-start sm:items-center gap-4 sm:gap-5 flex-1">
            <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl overflow-hidden bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-2xl sm:text-3xl shrink-0 border border-brand-200/60 dark:border-brand-500/20 shadow-theme-xs">
                <?php if ($adaFoto) : ?>
                    <img src="<?= base_url($pathFoto) ?>" alt="Foto Profil" class="w-full h-full object-cover">
                <?php else : ?>
                    <?= esc($inisial) ?>
                <?php endif; ?>
            </div>

            <div class="space-y-2 flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200 dark:border-brand-800/50 font-mono">
                        <span class="material-symbols-outlined text-xs">badge</span>
                        <?= esc($siswa['no_pendaftaran']) ?>
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300 font-mono">
                        <span class="material-symbols-outlined text-xs">fingerprint</span>
                        NISN: <?= esc($siswa['nisn'] ?? '-') ?>
                    </span>
                </div>

                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:text-3xl dark:text-white truncate">
                    Halo, <?= esc($siswa['nama_lengkap']) ?>! 👋
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                    Selamat datang di portal Penerimaan Peserta Didik Baru. Lengkapi biodata, upload berkas persyaratan, dan pantau status kelulusan Anda di sini.
                </p>

                <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                    <div class="pt-2">
                        <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all duration-200 active:scale-[0.97]">
                            <i class="fab fa-whatsapp text-sm"></i>
                            <span>Bergabung ke Grup WhatsApp Siswa</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Side: Hasil Seleksi Widget -->
        <div class="shrink-0 flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40 text-center min-w-[220px]">
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Hasil Seleksi</span>
            
            <?php if (($siswa['status_lulus'] ?? '') === 'Lulus') : ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1.5 text-sm font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 mb-3">
                    <span class="material-symbols-outlined text-base text-emerald-600 dark:text-emerald-400">check_circle</span>
                    <span>LULUS SELEKSI</span>
                </span>
                <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-1.5 w-full rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.97]">
                    <span class="material-symbols-outlined text-sm">print</span>
                    <span>Cetak Surat Kelulusan</span>
                </a>
            <?php elseif (($siswa['status_lulus'] ?? '') === 'Tidak Lulus') : ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-1.5 text-sm font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                    <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">cancel</span>
                    <span>TIDAK LULUS</span>
                </span>
            <?php else : ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-4 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                    <span class="material-symbols-outlined text-base text-amber-600 dark:text-amber-400">hourglass_top</span>
                    <span>PROSES SELEKSI</span>
                </span>
                <span class="text-[11px] text-gray-400 dark:text-gray-500 mt-2">Menunggu Pengumuman</span>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- 3 Status Metric Cards (TailAdmin Cards) -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 md:gap-6 mb-6">
    <!-- Status Verifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">verified_user</span>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                Verifikasi Berkas
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Status Validasi</span>
                <div class="mt-1">
                    <?php if (($siswa['status_verifikasi'] ?? '') === 'Terverifikasi') : ?>
                        <span class="text-base font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">check_circle</span> Terverifikasi
                        </span>
                    <?php elseif (($siswa['status_verifikasi'] ?? '') === 'Ditolak') : ?>
                        <span class="text-base font-bold text-red-600 dark:text-red-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">cancel</span> Berkas Ditolak
                        </span>
                    <?php else : ?>
                        <span class="text-base font-bold text-amber-600 dark:text-amber-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-base">hourglass_top</span> Menunggu Review
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?= base_url('siswa/status') ?>" class="text-[11px] font-semibold text-brand-600 hover:underline dark:text-brand-400">
                Detail &rarr;
            </a>
        </div>
    </div>

    <!-- Kelengkapan Biodata -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6 relative group">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">pie_chart</span>
            </div>
            <span class="text-lg font-mono font-extrabold text-brand-600 dark:text-brand-400"><?= (int) ($completionPercentage ?? 0) ?>%</span>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                <span>Kelengkapan Biodata</span>
                <span class="text-[11px] font-bold <?= ($completionPercentage ?? 0) == 100 ? 'text-emerald-600' : 'text-amber-600' ?>">
                    <?= ($completionPercentage ?? 0) == 100 ? 'Lengkap' : 'Belum Lengkap' ?>
                </span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                <div class="h-2 rounded-full transition-all duration-700 <?= ($completionPercentage ?? 0) == 100 ? 'bg-emerald-500' : 'bg-brand-500' ?>" style="width: <?= (int) ($completionPercentage ?? 0) ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Tanggal Registrasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6 sm:col-span-2 lg:col-span-1">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">event_available</span>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                Tercatat
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Registrasi</span>
                <h4 class="mt-1 text-base font-bold text-gray-900 dark:text-white">
                    <?= !empty($siswa['tgl_siswa']) && strtotime($siswa['tgl_siswa']) ? date('d F Y', strtotime($siswa['tgl_siswa'])) : '-' ?>
                </h4>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500">Sesi Aktif</p>
        </div>
    </div>
</div>

<!-- Menu Utama (TailAdmin Grid Cards) -->
<div class="mb-6">
    <div class="flex items-center gap-2 mb-4">
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
            <span class="material-symbols-outlined text-base">apps</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Menu Utama Pendaftaran</h3>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 md:gap-4">
        <?php
        $menus = [
            [
                'url' => 'siswa/biodata', 'icon' => 'edit_note', 'label' => 'Biodata Siswa',
                'bg' => 'bg-blue-50 dark:bg-blue-500/15', 'text' => 'text-blue-600 dark:text-blue-400',
            ],
            [
                'url' => 'siswa/berkas', 'icon' => 'upload_file', 'label' => 'Upload Berkas',
                'bg' => 'bg-emerald-50 dark:bg-emerald-500/15', 'text' => 'text-emerald-600 dark:text-emerald-400',
            ],
            [
                'url' => 'siswa/cetak-formulir', 'icon' => 'picture_as_pdf', 'label' => 'Cetak Formulir',
                'bg' => 'bg-rose-50 dark:bg-rose-500/15', 'text' => 'text-rose-600 dark:text-rose-400',
                'is_cetak' => true,
            ],
            [
                'url' => 'siswa/status', 'icon' => 'rule', 'label' => 'Status Pendaftaran',
                'bg' => 'bg-amber-50 dark:bg-amber-500/15', 'text' => 'text-amber-600 dark:text-amber-400',
            ],
            [
                'url' => 'siswa/pengumuman', 'icon' => 'campaign', 'label' => 'Pengumuman',
                'bg' => 'bg-purple-50 dark:bg-purple-500/15', 'text' => 'text-purple-600 dark:text-purple-400',
            ],
        ];

        foreach ($menus as $menu) :
            $isCetak  = !empty($menu['is_cetak']);
            $isLocked = $isCetak && isset($completionPercentage) && $completionPercentage < 100;

            $url    = $isLocked ? '#' : base_url($menu['url']);
            $target = ($isCetak && !$isLocked) ? 'target="_blank" rel="noopener"' : '';
            $onClick = $isLocked ? 'onclick="alert(\'Silahkan lengkapi biodata 100% untuk mencetak formulir pendaftaran.\'); return false;"' : '';
        ?>
            <a href="<?= $url ?>"
               <?= $target ?> <?= $onClick ?>
               class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all duration-200 dark:border-gray-800 dark:bg-white/[0.03] text-center flex flex-col items-center justify-center
                      <?= $isLocked ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-theme-md hover:-translate-y-0.5 hover:border-brand-500/40' ?>">
                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl <?= $menu['bg'] ?> <?= $menu['text'] ?> group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl"><?= $menu['icon'] ?></span>
                </div>
                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors flex items-center justify-center gap-1">
                    <?= esc($menu['label']) ?>
                    <?php if ($isLocked) : ?>
                        <span class="material-symbols-outlined text-[12px] text-gray-400">lock</span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Informasi Penting Card -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
            <span class="material-symbols-outlined text-base">lightbulb</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Petunjuk &amp; Informasi Penting</h3>
    </div>
    <div class="p-5 md:p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start gap-3 p-4 rounded-xl border border-blue-100 bg-blue-50/50 dark:border-blue-900/30 dark:bg-blue-950/20">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl shrink-0 mt-0.5">info</span>
                <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                    Pastikan seluruh isian formulir biodata sudah <strong>lengkap dan benar</strong> sebelum divalidasi oleh petugas verifikator.
                </p>
            </div>
            
            <div class="flex items-start gap-3 p-4 rounded-xl border border-emerald-100 bg-emerald-50/50 dark:border-emerald-900/30 dark:bg-emerald-950/20">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl shrink-0 mt-0.5">cloud_upload</span>
                <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                    Upload berkas dokumen fisik dalam format <strong>PDF, JPG, atau PNG</strong> dengan ukuran maksimal 2MB per file.
                </p>
            </div>
            
            <div class="flex items-start gap-3 p-4 rounded-xl border border-purple-100 bg-purple-50/50 dark:border-purple-900/30 dark:bg-purple-950/20">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-xl shrink-0 mt-0.5">notifications_active</span>
                <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                    Pantau status verifikasi dan informasi pengumuman seleksi secara berkala melalui dashboard ini.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>