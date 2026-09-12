<?= $this->extend('pindahan/layouts/siswa_pindahan') ?>

<?= $this->section('title') ?>Dashboard Siswa Pindahan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">swap_horiz</span> Dashboard Siswa Pindahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$nl = $pindahan['nama_lengkap'] ?? 'Siswa';
$inisial = mb_substr(trim($nl), 0, 1);
$fotoPath = '';
$adaFoto = false;
if (!empty($pindahan['foto'])) {
    $fotoPath = str_starts_with($pindahan['foto'], 'uploads/')
        ? $pindahan['foto']
        : 'uploads/berkas/' . ($pindahan['nisn'] ?? '') . '/' . $pindahan['foto'];
    $adaFoto = file_exists(FCPATH . $fotoPath);
}
$completion = (int) ($completionPercentage ?? 0);
$isFinal = (($pindahan['status_pendaftaran'] ?? '') === 'Final');
$isApproved = (($pindahan['status_verifikasi'] ?? '') === 'Terverifikasi');
$isRejected = (($pindahan['status_verifikasi'] ?? '') === 'Ditolak');
$berkasWajibLengkap = !empty($berkasWajib['lengkap']);
?>

<!-- 1. SMART ACTION ALERT BANNER -->
<?php if (!empty($smartAlert)): ?>
    <?php
    $alertBgs = [
        'danger'  => 'border-red-200 bg-gradient-to-r from-red-50 to-white text-red-900 dark:border-red-900/40 dark:from-red-950/30 dark:to-transparent dark:text-red-300',
        'warning' => 'border-amber-200 bg-gradient-to-r from-amber-50 to-white text-amber-900 dark:border-amber-900/40 dark:from-amber-950/30 dark:to-transparent dark:text-amber-300',
        'info'    => 'border-blue-200 bg-gradient-to-r from-blue-50 to-white text-blue-900 dark:border-blue-900/40 dark:from-blue-950/30 dark:to-transparent dark:text-blue-300',
    ];
    $iconColors = [
        'danger'  => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-500/20',
        'warning' => 'text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/20',
        'info'    => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-500/20',
    ];
    $bgStyle = $alertBgs[$smartAlert['type']] ?? $alertBgs['info'];
    $iconStyle = $iconColors[$smartAlert['type']] ?? $iconColors['info'];
    ?>
    <div class="mb-6 rounded-2xl border p-4 sm:p-5 shadow-theme-xs <?= $bgStyle ?>">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5 flex-1">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?= $iconStyle ?>">
                    <span class="material-symbols-outlined text-2xl"><?= esc($smartAlert['icon']) ?></span>
                </div>
                <div class="space-y-0.5">
                    <h4 class="text-sm font-bold tracking-tight"><?= esc($smartAlert['title']) ?></h4>
                    <p class="text-xs opacity-90 leading-relaxed max-w-3xl"><?= esc($smartAlert['message']) ?></p>
                </div>
            </div>
            <?php if (!empty($smartAlert['btn_url'])): ?>
                <div class="shrink-0 w-full sm:w-auto">
                    <a href="<?= esc($smartAlert['btn_url']) ?>"
                       class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all active:scale-[0.98] <?= esc($smartAlert['btn_color']) ?>">
                        <span><?= esc($smartAlert['btn_text']) ?></span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- 2. WELCOME PROFILE BANNER -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 md:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
        <div class="flex items-start sm:items-center gap-4 sm:gap-5 flex-1">
            <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl overflow-hidden bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-2xl sm:text-3xl shrink-0 border border-brand-200/60 dark:border-brand-500/20 shadow-theme-xs">
                <?php if ($adaFoto): ?>
                    <img src="<?= base_url($fotoPath) ?>" alt="Foto Profil" class="w-full h-full object-cover">
                <?php else: ?>
                    <?= esc($inisial) ?>
                <?php endif; ?>
            </div>
            <div class="space-y-2 flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200 dark:border-brand-800/50 font-mono">
                        <span class="material-symbols-outlined text-xs">badge</span>
                        <?= esc($pindahan['no_pendaftaran'] ?? '-') ?>
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300 font-mono">
                        <span class="material-symbols-outlined text-xs">fingerprint</span>
                        NISN: <?= esc($pindahan['nisn'] ?? '-') ?>
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40">
                        <span class="material-symbols-outlined text-xs">route</span>
                        Jalur: Siswa Pindahan
                    </span>
                </div>
                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:text-3xl dark:text-white truncate">Halo, <?= esc($nl) ?>! 👋</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                    Selamat datang di portal Siswa Pindahan <?= esc($web['nama_sekolah'] ?? '') ?>. Lengkapi biodata, unggah berkas pindah, dan pantau status verifikasi Anda.
                </p>
                <?php if (($web['tampil_grup_wa'] ?? 0) == 1 && !empty($web['link_grup_wa'])): ?>
                    <div class="pt-1">
                        <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.97]">
                            <i class="fab fa-whatsapp text-sm"></i><span>Grup WhatsApp</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status ringkasan -->
        <div class="shrink-0 flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40 text-center min-w-[220px]">
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2">Status Pendaftaran</span>
            <?php if ($isApproved): ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1.5 text-sm font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                    <span class="material-symbols-outlined text-base text-emerald-600 dark:text-emerald-400">verified</span> TERVERIFIKASI
                </span>
            <?php elseif ($isRejected): ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-1.5 text-sm font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                    <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">cancel</span> DITOLAK
                </span>
                <a href="<?= base_url('siswa/pindahan/status') ?>" class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold text-red-600 dark:text-red-400 hover:underline">
                    Lihat Catatan <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            <?php else: ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-4 py-1.5 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                    <span class="material-symbols-outlined text-base text-amber-600 dark:text-amber-400">hourglass_top</span>
                    <?= $isFinal ? 'DALAM PROSES VERIFIKASI' : 'BELUM FINAL' ?>
                </span>
                <span class="text-[11px] text-gray-400 dark:text-gray-500 mt-2"><?= $isFinal ? 'Data Anda sedang antre verifikasi' : 'Selesaikan biodata & berkas Anda' ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 3. KELENGKAPAN & JENJANG SUMMARY -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Progress Kelengkapan -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">donut_large</span>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Kelengkapan Biodata</h4>
            </div>
            <span class="text-sm font-black font-mono <?= $completion < 100 ? 'text-amber-500 dark:text-amber-400' : 'text-emerald-500 dark:text-emerald-400' ?>"><?= $completion ?>%</span>
        </div>
        <div class="w-full bg-gray-200/70 dark:bg-gray-700/60 rounded-full h-3 overflow-hidden">
            <div class="<?= $completion < 100 ? 'bg-gradient-to-r from-amber-500 to-orange-500' : 'bg-gradient-to-r from-emerald-500 to-teal-500' ?> h-3 rounded-full transition-all duration-500" style="width: <?= $completion ?>%"></div>
        </div>
        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-3">
            <?php if ($completion < 100): ?>
                Terdapat <span class="font-bold text-amber-600 dark:text-amber-400"><?= count($incompleteFields ?? []) ?></span> kolom wajib belum lengkap.
            <?php else: ?>
                <span class="text-emerald-600 dark:text-emerald-400 font-bold">Formulir 100% lengkap!</span>
            <?php endif; ?>
        </p>
        <a href="<?= base_url('siswa/pindahan/biodata') ?>" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-colors">
            <span class="material-symbols-outlined text-base">edit_note</span>
            <span><?= $completion < 100 ? 'Lengkapi Biodata' : 'Tinjau Biodata' ?></span>
        </a>
    </div>

    <!-- Sekolah Asal -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-brand-500">swap_horiz</span>
            <h4 class="text-sm font-bold uppercase tracking-wider text-gray-800 dark:text-white">Sekolah Asal</h4>
        </div>
        <?php if (!empty($pindahan['jenjang_sekolah_asal']) || !empty($pindahan['nama_sekolah_asal'])): ?>
            <div class="flex items-center justify-center gap-3 py-3">
                <div class="flex-1 text-center">
                    <span class="inline-flex mx-auto h-14 w-14 rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-950/50 dark:text-brand-400 items-center justify-center shadow-xs">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </span>
                    <h5 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mt-3 leading-snug break-words" title="<?= esc($pindahan['nama_sekolah_asal'] ?? '') ?>">
                        <?= esc(!empty($pindahan['nama_sekolah_asal']) ? $pindahan['nama_sekolah_asal'] : 'Nama Sekolah Belum Diisi') ?>
                    </h5>
                    <?php if (!empty($pindahan['jenjang_sekolah_asal'])): ?>
                        <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <span class="material-symbols-outlined text-sm text-brand-500">domain</span>
                            <span>Jenjang: <?= esc($pindahan['jenjang_sekolah_asal']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="py-6 text-center">
                <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-600">swap_horiz</span>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2">Isi sekolah asal pada formulir biodata.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Berkas -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">upload_file</span>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Berkas Persyaratan</h4>
            </div>
            <span class="text-sm font-black font-mono <?= $berkasWajibLengkap ? 'text-emerald-500 dark:text-emerald-400' : 'text-amber-500 dark:text-amber-400' ?>">
                <?= esc(($berkasWajib['sudah'] ?? 0) . '/' . ($berkasWajib['total'] ?? count($requiredDocs ?? []))) ?>
            </span>
        </div>
        <div class="w-full bg-gray-200/70 dark:bg-gray-700/60 rounded-full h-3 overflow-hidden">
            <div class="<?= $berkasWajibLengkap ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-amber-500 to-orange-500' ?> h-3 rounded-full transition-all duration-500" style="width: <?= $berkasWajib['total'] > 0 ? round(($berkasWajib['sudah'] / $berkasWajib['total']) * 100) : 0 ?>%"></div>
        </div>
        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-3">
            <?= count($berkasList ?? []) ?> file terunggah dari total <?= count($requiredDocs ?? []) ?> jenis dokumen tersedia.
        </p>
        <button type="button" onclick="window.location.href='<?= base_url('siswa/pindahan/berkas') ?>'" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
            <span class="material-symbols-outlined text-base">folder_open</span>
            <span>Kelola Berkas Pindahan</span>
        </button>
    </div>
</div>

<!-- 4. MENU UTAMA -->
<div class="mb-6">
    <div class="flex items-center gap-2 mb-4">
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
            <span class="material-symbols-outlined text-base">apps</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Menu Utama</h3>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3.5 md:gap-4">
        <?php
        $menus = [
            ['url' => 'siswa/pindahan/biodata',   'icon' => 'edit_note',        'label' => 'Biodata',      'card' => 'bg-gradient-to-br from-blue-500 to-blue-700'],
            ['url' => 'siswa/pindahan/berkas',    'icon' => 'upload_file',      'label' => 'Upload Berkas','card' => 'bg-gradient-to-br from-emerald-500 to-teal-700'],
            ['url' => 'siswa/pindahan/status',    'icon' => 'rule',             'label' => 'Status',       'card' => 'bg-gradient-to-br from-amber-500 to-orange-600'],
            ['url' => 'siswa/pindahan/cetak-formulir', 'icon' => 'picture_as_pdf', 'label' => 'Cetak Formulir', 'card' => 'bg-gradient-to-br from-rose-500 to-pink-700', 'is_cetak' => true],
            ['url' => 'siswa/pindahan/cetak-kartu', 'icon' => 'badge',          'label' => 'Cetak Kartu',  'card' => 'bg-gradient-to-br from-indigo-500 to-violet-700', 'is_cetak' => true],
        ];
        foreach ($menus as $menu) :
            $isLocked = !empty($menu['is_cetak']) && $completion < 100;
            $lockMsg  = 'Silakan lengkapi biodata 100% terlebih dahulu.';
            $url    = $isLocked ? '#' : base_url($menu['url']);
            $target = ($isCetak ?? $isLocked) ? '' : '';
            if (!empty($menu['is_cetak']) && !$isLocked) $target = 'target="_blank" rel="noopener"';
            $onClick = $isLocked ? 'onclick="alert(\'' . esc($lockMsg) . '\'); return false;"' : '';
        ?>
            <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?>
               class="group rounded-2xl <?= $menu['card'] ?> p-4 sm:p-5 shadow-theme-md transition-all duration-200 text-white text-center flex flex-col items-center justify-center <?= $isLocked ? 'opacity-60 cursor-not-allowed' : 'hover:shadow-theme-lg hover:-translate-y-0.5 hover:brightness-110' ?>">
                <div class="mb-2.5 flex h-11 w-11 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl"><?= $menu['icon'] ?></span>
                </div>
                <span class="text-xs font-bold text-white flex items-center justify-center gap-1 text-balance">
                    <?= esc($menu['label']) ?>
                    <?php if ($isLocked): ?><span class="material-symbols-outlined text-[12px] text-white/70">lock</span><?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- 5. RIWAYAT VERIFIKASI -->
<div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
        <span class="material-symbols-outlined text-brand-500">history</span>
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Riwayat Verifikasi</h4>
    </div>
    <?php if (!empty($verifikasiRiwayat)): ?>
        <div class="space-y-3">
            <?php foreach ($verifikasiRiwayat as $rv): ?>
                <?php
                $stColor = match (strtolower($rv['ket'] ?? '')) {
                    'terverifikasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-800/40',
                    'ditolak'       => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/15 dark:text-red-400 dark:border-red-800/40',
                    'menunggu'      => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/15 dark:text-amber-400 dark:border-amber-800/40',
                    default         => 'bg-gray-50 text-gray-600 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                };
                ?>
                <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/20">
                    <span class="material-symbols-outlined text-gray-400 mt-0.5 text-lg">schedule</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-900 dark:text-white"><?= esc($rv['ket'] ?? '-') ?> <span class="font-normal text-gray-400">· <?= esc($rv['verifikator'] ?? '-') ?></span></p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400"><?= nl2br(esc($rv['isi'] ?? '-')) ?></p>
                        <span class="text-[10px] text-gray-400"><?= esc($rv['created_at'] ?? $rv['tgl_verifikasi'] ?? '-') ?></span>
                    </div>
                    <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full border text-[10px] font-semibold <?= $stColor ?>"><?= esc($rv['ket'] ?? '-') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="py-6 text-center">
            <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-600">history_toggle_off</span>
            <p class="text-xs text-gray-400 mt-2">Belum ada riwayat verifikasi. Status akan muncul setelah panitia memproses data Anda.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>