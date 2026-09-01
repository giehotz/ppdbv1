<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Status Pendaftaran<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Status Pendaftaran<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    
    <!-- Status Card (TailAdmin Mobile Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center">
        <?php
        $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
        if ($statusVerif === 'Terverifikasi') {
            $badgeBg = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/40';
            $icon = 'verified';
            $statusTitle = 'Pendaftaran Terverifikasi';
            $desc = 'Selamat! Berkas dan data Anda telah dinyatakan lengkap dan valid oleh panitia PPDB.';
        } elseif ($statusVerif === 'Ditolak' || $statusVerif === 'rejected') {
            $badgeBg = 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 border-red-200 dark:border-red-800/40';
            $icon = 'cancel';
            $statusTitle = 'Pendaftaran Perlu Perbaikan';
            $desc = 'Data pendaftaran Anda belum memenuhi syarat atau memerlukan perbaikan berkas.';
        } else {
            $badgeBg = 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border-amber-200 dark:border-amber-800/40';
            $icon = 'hourglass_top';
            $statusTitle = 'Menunggu Antrean Verifikasi';
            $desc = 'Data Anda sedang dalam antrean pemeriksaan berkas oleh verifikator.';
        }
        ?>

        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl border <?= $badgeBg ?> shadow-theme-xs mx-auto mb-3">
            <span class="material-symbols-outlined text-3xl"><?= $icon ?></span>
        </div>

        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">
            <?= $statusTitle ?>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed max-w-xs mx-auto">
            <?= $desc ?>
        </p>

        <?php if (!empty($siswa['catatan_verifikasi'])): ?>
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50/70 p-3 text-left dark:border-red-900/40 dark:bg-red-950/20 text-xs">
                <span class="font-bold text-red-800 dark:text-red-300 block mb-0.5">Catatan Perbaikan:</span>
                <p class="text-red-700 dark:text-red-400 italic">"<?= esc($siswa['catatan_verifikasi']) ?>"</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Student Detail Grid -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-2.5">
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-800">
            Rincian Pendaftar
        </h4>

        <div class="flex justify-between items-center py-1 text-xs">
            <span class="text-gray-400">No. Pendaftaran:</span>
            <span class="font-mono font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2 py-0.5 rounded-md">
                <?= esc($siswa['no_pendaftaran'] ?? '-') ?>
            </span>
        </div>

        <div class="flex justify-between items-center py-1 text-xs border-t border-gray-100 dark:border-gray-800">
            <span class="text-gray-400">NISN:</span>
            <span class="font-mono font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nisn'] ?? '-') ?></span>
        </div>

        <div class="flex justify-between items-center py-1 text-xs border-t border-gray-100 dark:border-gray-800">
            <span class="text-gray-400">Nama Lengkap:</span>
            <span class="font-bold text-gray-900 dark:text-white truncate max-w-[180px]"><?= esc($siswa['nama_lengkap'] ?? '-') ?></span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="grid grid-cols-2 gap-2.5">
        <a href="<?= base_url('siswa/biodata') ?>"
           class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white p-3 text-xs font-bold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 shadow-theme-xs">
            <span class="material-symbols-outlined text-base text-brand-500">edit_note</span>
            <span>Biodata</span>
        </a>

        <a href="<?= base_url('siswa/berkas') ?>"
           class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white p-3 text-xs font-bold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 shadow-theme-xs">
            <span class="material-symbols-outlined text-base text-emerald-500">upload_file</span>
            <span>Berkas</span>
        </a>
    </div>

    <?php
    $isLocked = isset($completionPercentage) && $completionPercentage < 100;
    $url = $isLocked ? '#' : base_url('siswa/cetak-formulir');
    $target = $isLocked ? '' : 'target="_blank" rel="noopener"';
    $onClick = $isLocked ? 'onclick="alert(\'Silahkan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : '';
    ?>
    <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?>
       class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 text-white p-3.5 text-xs font-bold shadow-theme-xs transition-all <?= $isLocked ? 'opacity-50 cursor-not-allowed' : '' ?>">
        <span class="material-symbols-outlined text-lg">print</span>
        <span>Cetak Formulir Pendaftaran</span>
    </a>

</div>

<?= $this->endSection() ?>
