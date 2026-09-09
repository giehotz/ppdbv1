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
$isLockedCard = !($canPrintCard ?? false);
?>

<!-- 1. SMART ACTION ALERT BANNER -->
<?php if (!empty($smartAlert)): ?>
    <?php
    $alertBgs = [
        'danger'  => 'border-red-200 bg-gradient-to-r from-red-50 to-white text-red-900 dark:border-red-900/40 dark:from-red-950/30 dark:to-transparent dark:text-red-300',
        'warning' => 'border-amber-200 bg-gradient-to-r from-amber-50 to-white text-amber-900 dark:border-amber-900/40 dark:from-amber-950/30 dark:to-transparent dark:text-amber-300',
        'info'    => 'border-blue-200 bg-gradient-to-r from-blue-50 to-white text-blue-900 dark:border-blue-900/40 dark:from-blue-950/30 dark:to-transparent dark:text-blue-300',
        'billing' => 'border-indigo-200 bg-gradient-to-r from-indigo-50 to-white text-indigo-900 dark:border-indigo-900/40 dark:from-indigo-950/30 dark:to-transparent dark:text-indigo-300',
        'success' => 'border-emerald-200 bg-gradient-to-r from-emerald-50 to-white text-emerald-900 dark:border-emerald-900/40 dark:from-emerald-950/30 dark:to-transparent dark:text-emerald-300',
    ];
    $iconColors = [
        'danger'  => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-500/20',
        'warning' => 'text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/20',
        'info'    => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-500/20',
        'billing' => 'text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-500/20',
        'success' => 'text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-500/20',
    ];
    $bgStyle = $alertBgs[$smartAlert['type']] ?? $alertBgs['info'];
    $iconStyle = $iconColors[$smartAlert['type']] ?? $iconColors['info'];
    ?>
    <div class="mb-6 rounded-2xl border p-4 sm:p-5 shadow-theme-xs <?= $bgStyle ?> transition-all animate-fade-in">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5 flex-1">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?= $iconStyle ?>">
                    <span class="material-symbols-outlined text-2xl"><?= $smartAlert['icon'] ?></span>
                </div>
                <div class="space-y-0.5">
                    <h4 class="text-sm font-bold tracking-tight">
                        <?= esc($smartAlert['title']) ?>
                    </h4>
                    <p class="text-xs opacity-90 leading-relaxed max-w-3xl">
                        <?= esc($smartAlert['message']) ?>
                    </p>
                </div>
            </div>
            <?php if (!empty($smartAlert['btn_url'])): ?>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="<?= esc($smartAlert['btn_url']) ?>"
                       class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all active:scale-[0.98] <?= $smartAlert['btn_color'] ?>">
                        <span><?= esc($smartAlert['btn_text']) ?></span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- 2. INTERACTIVE PPDB MILESTONE STEPPER (Visual Progress Tracker) -->
<?php if (!empty($milestones) && ($web['stepper_aktif'] ?? '1') == '1'): ?>
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-2.5">
            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-base">alt_route</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Alur &amp; Tahapan Pendaftaran (PPDB Stepper)</h3>
                <p class="text-[11px] text-gray-400 dark:text-gray-500">Pantau perkembangan tahapan Anda dari awal pendaftaran hingga daftar ulang</p>
            </div>
        </div>
        <span class="hidden sm:inline-flex text-[11px] font-semibold text-brand-600 bg-brand-50 dark:bg-brand-500/15 dark:text-brand-400 px-3 py-1 rounded-full">
            Tahun Pelajaran <?= esc($web['th_pelajaran'] ?? '2025/2026') ?>
        </span>
    </div>

    <!-- Horizontal Stepper Track -->
    <div class="relative overflow-x-auto no-scrollbar pb-2">
        <div class="flex items-start justify-between min-w-[720px] gap-2">
            <?php foreach ($milestones as $idx => $m): ?>
                <?php
                $isComp = $m['status'] === 'completed';
                $isCurr = $m['status'] === 'current';
                $isWarn = $m['status'] === 'warning';
                $isDang = $m['status'] === 'danger';
                
                if ($isComp) {
                    $circleClass = 'bg-emerald-500 text-white border-emerald-500 shadow-sm';
                    $badgeClass  = 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-800/40';
                    $stepIcon    = 'check';
                } elseif ($isCurr) {
                    $circleClass = 'bg-brand-500 text-white border-brand-500 ring-4 ring-brand-100 dark:ring-brand-900/40 shadow-sm animate-pulse';
                    $badgeClass  = 'bg-brand-50 text-brand-700 border-brand-200 dark:bg-brand-500/15 dark:text-brand-400 dark:border-brand-800/40';
                    $stepIcon    = $m['icon'];
                } elseif ($isWarn) {
                    $circleClass = 'bg-amber-500 text-white border-amber-500';
                    $badgeClass  = 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/15 dark:text-amber-400 dark:border-amber-800/40';
                    $stepIcon    = 'warning';
                } elseif ($isDang) {
                    $circleClass = 'bg-red-500 text-white border-red-500';
                    $badgeClass  = 'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/15 dark:text-red-400 dark:border-red-800/40';
                    $stepIcon    = 'close';
                } else {
                    $circleClass = 'bg-gray-100 text-gray-400 border-gray-200 dark:bg-gray-800 dark:text-gray-500 dark:border-gray-700';
                    $badgeClass  = 'bg-gray-50 text-gray-500 border-gray-200 dark:bg-gray-800/50 dark:text-gray-400 dark:border-gray-700';
                    $stepIcon    = $m['icon'];
                }
                ?>
                <div class="flex-1 flex flex-col items-center text-center relative group">
                    <!-- Connecting line to next step -->
                    <?php if ($idx < count($milestones) - 1): ?>
                        <div class="absolute top-4 left-1/2 w-full h-0.5 <?= $isComp ? 'bg-emerald-400' : 'bg-gray-200 dark:bg-gray-700' ?> -z-0"></div>
                    <?php endif; ?>

                    <!-- Step Circle Link -->
                    <?php if (!empty($m['url'])): ?>
                        <a href="<?= esc($m['url']) ?>" class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 text-xs font-bold transition-all hover:scale-110 <?= $circleClass ?>" title="<?= esc($m['title']) ?>">
                            <span class="material-symbols-outlined text-[15px]"><?= $stepIcon ?></span>
                        </a>
                    <?php else: ?>
                        <div class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 text-xs font-bold <?= $circleClass ?>">
                            <span class="material-symbols-outlined text-[15px]"><?= $stepIcon ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Step Title & Description -->
                    <div class="mt-2 space-y-1">
                        <span class="block text-[11px] font-bold text-gray-900 dark:text-white leading-tight">
                            <?= esc($m['title']) ?>
                        </span>
                        <span class="inline-block px-2 py-0.5 rounded-full border text-[9px] font-medium leading-none <?= $badgeClass ?>">
                            <?= esc($m['description']) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- 3. WELCOME PROFILE BANNER -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 md:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
        
        <!-- Left: Profile & Details -->
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
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40">
                        <span class="material-symbols-outlined text-xs">route</span>
                        Jalur: <?= esc($siswa['jalur_pendaftaran'] ?? 'Reguler') ?>
                    </span>
                </div>

                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:text-3xl dark:text-white truncate">
                    Halo, <?= esc($siswa['nama_lengkap']) ?>! 👋
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                    Selamat datang di portal resmi Penerimaan Peserta Didik Baru <?= esc($web['nama_sekolah'] ?? '') ?>. Pantau tahapan dan lengkapi berkas Anda secara mandiri.
                </p>

                <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                    <div class="pt-1">
                        <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all duration-200 active:scale-[0.97]">
                            <i class="fab fa-whatsapp text-sm"></i>
                            <span>Bergabung ke Grup WhatsApp Calon Siswa</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Hasil Seleksi & Cetak Kartu Widget -->
        <div class="shrink-0 flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40 text-center min-w-[240px]">
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Hasil Seleksi</span>
            
            <?php if (($siswa['status_lulus'] ?? '') === 'Lulus') : ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1.5 text-sm font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 mb-3">
                    <span class="material-symbols-outlined text-base text-emerald-600 dark:text-emerald-400">check_circle</span>
                    <span>LULUS SELEKSI</span>
                </span>
                <div class="flex flex-col gap-2 w-full">
                    <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-1.5 w-full rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.97]">
                        <span class="material-symbols-outlined text-sm">print</span>
                        <span>Cetak Bukti Lulus</span>
                    </a>
                    <a href="<?= base_url('siswa/daftar-ulang') ?>" class="inline-flex items-center justify-center gap-1.5 w-full rounded-xl bg-brand-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-all active:scale-[0.97]">
                        <span class="material-symbols-outlined text-sm">backpack</span>
                        <span>Konfirmasi Daftar Ulang</span>
                    </a>
                </div>
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

<!-- 4. MENU UTAMA PENDAFTARAN (Enhanced Grid dengan Kartu Peserta) -->
<div class="mb-6">
    <div class="flex items-center gap-2 mb-4">
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
            <span class="material-symbols-outlined text-base">apps</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Menu Utama Pendaftaran</h3>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 md:gap-4">
        <?php
        $menus = [
            [
                'url' => 'siswa/biodata', 'icon' => 'edit_note', 'label' => 'Biodata Siswa',
                'card' => 'bg-gradient-to-br from-blue-500 to-blue-700',
            ],
            [
                'url' => 'siswa/berkas', 'icon' => 'upload_file', 'label' => 'Upload Berkas',
                'card' => 'bg-gradient-to-br from-emerald-500 to-teal-700',
            ],
            [
                'url' => 'siswa/cetak-kartu', 'icon' => 'badge', 'label' => 'Cetak Kartu Peserta',
                'card' => 'bg-gradient-to-br from-indigo-500 to-violet-700',
                'is_kartu' => true,
            ],
            [
                'url' => 'siswa/cetak-formulir', 'icon' => 'picture_as_pdf', 'label' => 'Cetak Formulir',
                'card' => 'bg-gradient-to-br from-rose-500 to-pink-700',
                'is_cetak' => true,
            ],
            [
                'url' => 'siswa/status', 'icon' => 'rule', 'label' => 'Status Pendaftaran',
                'card' => 'bg-gradient-to-br from-amber-500 to-orange-600',
            ],
            [
                'url' => 'siswa/pengumuman', 'icon' => 'campaign', 'label' => 'Pengumuman',
                'card' => 'bg-gradient-to-br from-purple-500 to-fuchsia-700',
            ],
        ];

        foreach ($menus as $menu) :
            $isCetak = !empty($menu['is_cetak']);
            $isKartu = !empty($menu['is_kartu']);
            $isLocked = false;
            $lockMsg  = '';

            if ($isCetak && ($completionPercentage ?? 0) < 100) {
                $isLocked = true;
                $lockMsg  = 'Silakan lengkapi biodata 100% untuk mencetak formulir.';
            } elseif ($isKartu && $isLockedCard) {
                $isLocked = true;
                $lockMsg  = 'Kartu Peserta dapat dicetak setelah biodata mencapai kelengkapan 100%.';
            }

            $url    = $isLocked ? '#' : base_url($menu['url']);
            $target = ($isCetak || $isKartu) && !$isLocked ? 'target="_blank" rel="noopener"' : '';
            $onClick = $isLocked ? 'onclick="alert(\'' . esc($lockMsg) . '\'); return false;"' : '';
        ?>
            <a href="<?= $url ?>"
               <?= $target ?> <?= $onClick ?>
               class="group rounded-2xl <?= $menu['card'] ?> p-4 sm:p-5 shadow-theme-md transition-all duration-200 text-white text-center flex flex-col items-center justify-center
                      <?= $isLocked ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-theme-lg hover:-translate-y-0.5 hover:brightness-110' ?>">
                <div class="mb-2.5 flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl"><?= $menu['icon'] ?></span>
                </div>
                <span class="text-xs font-bold text-white flex items-center justify-center gap-1 text-balance">
                    <?= esc($menu['label']) ?>
                    <?php if ($isLocked) : ?>
                        <span class="material-symbols-outlined text-[12px] text-white/70">lock</span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- 6. ROW: COUNTDOWN & JADWAL UJIAN + PUSAT UNDUHAN TEMPLATE DOKUMEN -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    
    <!-- Widget Countdown & Jadwal Ujian / Pengumuman -->
    <?php
    $ujianAktif = ($web['ujian_aktif'] ?? '0') == '1';
    $tglUjian = $web['tgl_ujian'] ?? null;
    $targetCountdown = null;
    $countdownTitle  = 'Jadwal Seleksi PPDB';
    $countdownDesc   = 'Jadwal ujian belum ditetapkan oleh panitia.';

    if ($ujianAktif && !empty($tglUjian) && strtotime($tglUjian) > time()) {
        $targetCountdown = $tglUjian;
        $countdownTitle  = 'Hitung Mundur Ujian Seleksi';
        $countdownDesc   = 'Pelaksanaan ujian seleksi calon santri/siswa baru.';
    } elseif (($web['pengumuman_aktif'] ?? '0') == '1' && !empty($web['tgl_pengumuman']) && strtotime($web['tgl_pengumuman']) > time()) {
        $targetCountdown = $web['tgl_pengumuman'];
        $countdownTitle  = 'Hitung Mundur Pengumuman Kelulusan';
        $countdownDesc   = 'Waktu pengumuman hasil seleksi penerimaan.';
    }
    ?>
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500">timer</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white"><?= esc($countdownTitle) ?></h4>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    Jadwal Resmi
                </span>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4"><?= esc($countdownDesc) ?></p>

            <?php if (!empty($targetCountdown)): ?>
                <!-- Countdown Timer Display -->
                <div class="grid grid-cols-4 gap-2 text-center mb-5" id="countdown-timer" data-target="<?= esc($targetCountdown) ?>">
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-2.5 dark:border-gray-700 dark:bg-gray-800/40">
                        <span id="cd-days" class="block text-xl font-extrabold font-mono text-brand-600 dark:text-brand-400">00</span>
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">Hari</span>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-2.5 dark:border-gray-700 dark:bg-gray-800/40">
                        <span id="cd-hours" class="block text-xl font-extrabold font-mono text-brand-600 dark:text-brand-400">00</span>
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">Jam</span>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-2.5 dark:border-gray-700 dark:bg-gray-800/40">
                        <span id="cd-minutes" class="block text-xl font-extrabold font-mono text-brand-600 dark:text-brand-400">00</span>
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">Menit</span>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-2.5 dark:border-gray-700 dark:bg-gray-800/40">
                        <span id="cd-seconds" class="block text-xl font-extrabold font-mono text-brand-600 dark:text-brand-400">00</span>
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">Detik</span>
                    </div>
                </div>
            <?php else: ?>
                <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50/50 p-4 text-center dark:border-gray-800 dark:bg-gray-800/20 mb-4">
                    <span class="material-symbols-outlined text-2xl text-gray-400 mb-1 block">event_upcoming</span>
                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                        <?= !empty($tglUjian) ? 'Jadwal Ujian: ' . date('d F Y', strtotime($tglUjian)) : 'Informasi tanggal ujian akan diumumkan oleh panitia.' ?>
                    </span>
                </div>
            <?php endif; ?>

            <!-- Ketentuan Ujian Singkat -->
            <div class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-emerald-600">check_circle</span>
                    <span>Wajib mencetak &amp; membawa <strong>Kartu Tanda Peserta PPDB</strong>.</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-emerald-600">check_circle</span>
                    <span>Mengenakan pakaian rapi, sopan, dan bersepatu.</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-emerald-600">check_circle</span>
                    <span>Hadir di lokasi tes minimal 15 menit sebelum ujian dimulai.</span>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
            <a href="<?= $isLockedCard ? '#' : base_url('siswa/cetak-kartu') ?>"
               <?= $isLockedCard ? 'onclick="alert(\'Silakan lengkapi biodata 100% untuk mencetak kartu peserta.\'); return false;"' : 'target="_blank" rel="noopener"' ?>
               class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-indigo-700 transition-colors <?= $isLockedCard ? 'opacity-60 cursor-not-allowed' : '' ?>">
                <span class="material-symbols-outlined text-base">badge</span>
                <span>Cetak Kartu Peserta Ujian Sekarang</span>
            </a>
        </div>
    </div>

    <!-- Pusat Unduh Template Dokumen & Panduan -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500">download_for_offline</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Pusat Unduhan Dokumen PPDB</h4>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    Format Resmi
                </span>
            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Unduh dan cetak formulir atau template surat pernyataan bermaterai yang telah diisi secara otomatis sesuai biodata Anda.
            </p>

            <div class="space-y-3">
                <!-- Doc 1: Surat Pernyataan Bermaterai -->
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-gray-50 transition-colors dark:border-gray-800 dark:bg-gray-800/20">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                            <span class="material-symbols-outlined text-xl">description</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-900 dark:text-white">Surat Pernyataan Calon Siswa &amp; Wali</h5>
                            <span class="text-[10px] text-gray-400">Siap cetak &amp; bubuhi materai 10.000</span>
                        </div>
                    </div>
                    <a href="<?= base_url('siswa/surat-pernyataan') ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">print</span>
                        <span>Cetak</span>
                    </a>
                </div>

                <!-- Doc 2: Formulir Pendaftaran Lengkap -->
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-gray-50 transition-colors dark:border-gray-800 dark:bg-gray-800/20">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 dark:bg-rose-500/15 dark:text-rose-400">
                            <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-900 dark:text-white">Formulir Pendaftaran Siswa</h5>
                            <span class="text-[10px] text-gray-400">Bukti resmi registrasi biodata</span>
                        </div>
                    </div>
                    <a href="<?= ($completionPercentage ?? 0) < 100 ? '#' : base_url('siswa/cetak-formulir') ?>"
                       <?= ($completionPercentage ?? 0) < 100 ? 'onclick="alert(\'Silakan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : 'target="_blank" rel="noopener"' ?>
                       class="inline-flex items-center gap-1 rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-bold text-white shadow-theme-xs hover:bg-rose-700 transition-colors <?= ($completionPercentage ?? 0) < 100 ? 'opacity-60 cursor-not-allowed' : '' ?>">
                        <span class="material-symbols-outlined text-sm">print</span>
                        <span>Cetak</span>
                    </a>
                </div>

                <!-- Doc 3: Panduan & Tata Tertib Siswa -->
                <div class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-gray-50 transition-colors dark:border-gray-800 dark:bg-gray-800/20">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                            <span class="material-symbols-outlined text-xl">menu_book</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-900 dark:text-white">Tata Tertib &amp; Panduan PPDB</h5>
                            <span class="text-[10px] text-gray-400">Pedoman umum pelaksanaan seleksi</span>
                        </div>
                    </div>
                    <a href="<?= base_url('siswa/pengumuman') ?>"
                       class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-bold text-white shadow-theme-xs hover:bg-blue-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                        <span>Lihat</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 text-[11px] text-gray-400 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-sm text-brand-500">info</span>
            <span>Bawa berkas cetak saat tahap verifikasi dokumen fisik di sekolah.</span>
        </div>
    </div>

</div>

<!-- 7. WIDGET RINGKASAN PEMBIAYAAN & REKENING PEMBAYARAN (Jika Fitur Aktif) -->
<?php if ($tampilPembiayaan && $totalTagihan > 0): ?>
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800 gap-3">
            <div class="flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Ringkasan Pembiayaan &amp; Pembayaran</h4>
                    <p class="text-[11px] text-gray-400">Informasi kewajiban biaya pendaftaran dan rekening tujuan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold px-3 py-1 rounded-full <?= $statusLunas ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300' ?>">
                    <?= $statusLunas ? 'LUNAS' : 'BELUM LUNAS' ?>
                </span>
                <?php if ($statusLunas): ?>
                    <a href="<?= base_url('siswa/pembiayaan/kuitansi') ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">print</span>
                        <span>Cetak Kuitansi</span>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('siswa/pembiayaan') ?>"
                       class="inline-flex items-center gap-1.5 rounded-xl bg-brand-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">payments</span>
                        <span>Bayar / Rincian</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Total Tagihan -->
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total Biaya</span>
                <h5 class="text-base font-extrabold text-gray-900 dark:text-white mt-1">
                    Rp <?= number_format($totalTagihan, 0, ',', '.') ?>
                </h5>
            </div>
            <!-- Terbayar -->
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Sudah Terbayar</span>
                <h5 class="text-base font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">
                    Rp <?= number_format($totalLunas, 0, ',', '.') ?>
                </h5>
            </div>
            <!-- Sisa Tagihan -->
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Sisa Tagihan</span>
                <h5 class="text-base font-extrabold <?= $statusLunas ? 'text-gray-500' : 'text-amber-600 dark:text-amber-400' ?> mt-1">
                    Rp <?= number_format($sisaTagihan, 0, ',', '.') ?>
                </h5>
            </div>
        </div>

        <!-- Rekening Info & Notice -->
        <div class="mt-4 p-4 rounded-xl border border-blue-100 bg-blue-50/50 dark:border-blue-900/30 dark:bg-blue-950/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl shrink-0">account_balance</span>
                <div>
                    <span class="text-gray-500 dark:text-gray-400 text-[11px]">Rekening Resmi Pembayaran:</span>
                    <p class="font-bold text-gray-900 dark:text-white">
                        Bank BRI / BSI: a.n. Panitia PPDB <?= esc($web['nama_sekolah'] ?? 'Madrasah') ?>
                    </p>
                </div>
            </div>
            <a href="<?= base_url('siswa/pembiayaan') ?>" class="inline-flex items-center gap-1 font-bold text-brand-600 dark:text-brand-400 hover:underline">
                <span>Panduan Transfer &amp; Upload Bukti</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- 8. ROW: HELPDESK CEPAT & ACCORDION FAQ TERINTEGRASI -->
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800 gap-3 mb-4">
        <div class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                <span class="material-symbols-outlined text-xl">help</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pusat Bantuan Cepat &amp; FAQ</h4>
                <p class="text-[11px] text-gray-400">Pertanyaan umum seputar tahapan pendaftaran, berkas, dan seleksi PPDB</p>
            </div>
        </div>

        <?php if (!empty($web['telepon'])): ?>
            <?php
            $cleanWa = preg_replace('/[^0-9]/', '', $web['telepon']);
            if (substr($cleanWa, 0, 1) === '0') {
                $cleanWa = '62' . substr($cleanWa, 1);
            }
            $waMsg = urlencode("Halo Panitia PPDB " . ($web['nama_sekolah'] ?? '') . ", saya calon siswa " . ($siswa['nama_lengkap'] ?? '') . " (No. Reg: " . ($siswa['no_pendaftaran'] ?? '') . "). Saya ingin bertanya mengenai proses pendaftaran.");
            ?>
            <a href="https://wa.me/<?= $cleanWa ?>?text=<?= $waMsg ?>" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                <i class="fab fa-whatsapp text-sm"></i>
                <span>Tanya Panitia (WhatsApp)</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- FAQ Accordion -->
    <div class="space-y-2.5">
        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $i => $faq): ?>
                <details class="group rounded-xl border border-gray-100 bg-gray-50/50 p-3.5 transition-all open:bg-white open:border-brand-200 open:shadow-theme-xs dark:border-gray-800 dark:bg-gray-800/30 dark:open:bg-gray-800/60">
                    <summary class="flex cursor-pointer items-center justify-between font-bold text-xs text-gray-800 dark:text-gray-200 list-none [&::-webkit-details-marker]:hidden select-none">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-500 text-base">help_outline</span>
                            <?= esc($faq['pertanyaan']) ?>
                        </span>
                        <span class="material-symbols-outlined text-gray-400 transition-transform duration-200 group-open:rotate-180 text-base">
                            expand_more
                        </span>
                    </summary>
                    <div class="mt-3 pl-6 text-xs text-gray-600 dark:text-gray-300 leading-relaxed border-t border-gray-100 pt-2.5 dark:border-gray-700/50">
                        <?= nl2br(esc($faq['jawaban'])) ?>
                    </div>
                </details>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="p-4 rounded-xl border border-dashed border-gray-200 text-center text-xs text-gray-400 dark:border-gray-800">
                Belum ada data FAQ yang dimuat. Jika Anda memiliki kendala, silakan hubungi panitia melalui kontak sekolah.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Countdown Timer JavaScript -->
<?php if (!empty($targetCountdown)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const timerElem = document.getElementById('countdown-timer');
    if (!timerElem) return;

    const targetDate = new Date(timerElem.getAttribute('data-target')).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            document.getElementById('cd-days').innerText = '00';
            document.getElementById('cd-hours').innerText = '00';
            document.getElementById('cd-minutes').innerText = '00';
            document.getElementById('cd-seconds').innerText = '00';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('cd-days').innerText = String(days).padStart(2, '0');
        document.getElementById('cd-hours').innerText = String(hours).padStart(2, '0');
        document.getElementById('cd-minutes').innerText = String(minutes).padStart(2, '0');
        document.getElementById('cd-seconds').innerText = String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>