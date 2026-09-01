<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Status Pendaftaran<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">rule</span> Status Pendaftaran Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Status Card (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center">
        
        <?php
        $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
        if ($statusVerif === 'Terverifikasi') {
            $badgeBg = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/40';
            $icon = 'verified';
            $statusTitle = 'Pendaftaran Terverifikasi';
            $desc = 'Selamat! Data dan berkas pendaftaran Anda telah berhasil diverifikasi dan dinyatakan valid oleh petugas panitia PPDB.';
        } elseif ($statusVerif === 'Ditolak' || $statusVerif === 'rejected') {
            $badgeBg = 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 border-red-200 dark:border-red-800/40';
            $icon = 'cancel';
            $statusTitle = 'Pendaftaran Ditolak / Perlu Perbaikan';
            $desc = 'Mohon maaf, berkas atau data Anda belum memenuhi syarat. Silakan cek catatan perbaikan di bawah dan perbarui data Anda.';
        } else {
            $badgeBg = 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border-amber-200 dark:border-amber-800/40';
            $icon = 'hourglass_top';
            $statusTitle = 'Menunggu Antrean Verifikasi';
            $desc = 'Pendaftaran Anda telah tersimpan dan sedang menunggu pemeriksaan berkas oleh petugas verifikator PPDB.';
        }
        ?>

        <!-- Visual Badge -->
        <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl border <?= $badgeBg ?> shadow-theme-sm mx-auto mb-4">
            <span class="material-symbols-outlined text-4xl"><?= $icon ?></span>
        </div>

        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">
            <?= $statusTitle ?>
        </h3>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-lg mx-auto leading-relaxed">
            <?= $desc ?>
        </p>

        <!-- Catatan Penolakan / Catatan Verifikasi -->
        <?php if (!empty($siswa['catatan_verifikasi'])): ?>
            <div class="mt-5 max-w-xl mx-auto rounded-xl border border-red-200 bg-red-50/70 p-4 text-left dark:border-red-900/40 dark:bg-red-950/20 text-xs">
                <div class="flex items-center gap-1.5 font-bold text-red-800 dark:text-red-300 mb-1">
                    <span class="material-symbols-outlined text-base">info</span>
                    <span>Catatan Perbaikan Panitia:</span>
                </div>
                <p class="text-red-700 dark:text-red-400 italic pl-5">
                    "<?= esc($siswa['catatan_verifikasi']) ?>"
                </p>
            </div>
        <?php endif; ?>

    </div>

    <!-- Student Detail Grid (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">id_card</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Rincian Data Pendaftar</h4>
            </div>
            <span class="font-mono text-xs font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2.5 py-1 rounded-lg border border-brand-200 dark:border-brand-800/40">
                <?= esc($siswa['no_pendaftaran'] ?? '-') ?>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">NISN</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white font-mono"><?= esc($siswa['nisn'] ?? '-') ?></span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">NIK</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white font-mono"><?= esc($siswa['nik'] ?? '-') ?></span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40 sm:col-span-2 md:col-span-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Jenis Kelamin</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white">
                    <?= ($siswa['jk'] ?? '') === 'L' ? 'Laki-laki' : (($siswa['jk'] ?? '') === 'P' ? 'Perempuan' : '-') ?>
                </span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40 sm:col-span-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Nama Lengkap</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap'] ?? '-') ?></span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-1">Tempat, Tanggal Lahir</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white">
                    <?= esc($siswa['tempat_lahir'] ?? '-') ?>, <?= !empty($siswa['tgl_lahir']) ? date('d/m/Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Action Shortcuts -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <a href="<?= base_url('siswa/biodata') ?>"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white p-4 text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-brand-600 hover:border-brand-500/40 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-200 dark:hover:bg-gray-800 shadow-theme-xs transition-all">
            <span class="material-symbols-outlined text-xl text-brand-500">edit_note</span>
            <span>Periksa Biodata</span>
        </a>

        <a href="<?= base_url('siswa/berkas') ?>"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white p-4 text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-brand-600 hover:border-brand-500/40 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-200 dark:hover:bg-gray-800 shadow-theme-xs transition-all">
            <span class="material-symbols-outlined text-xl text-emerald-500">upload_file</span>
            <span>Dokumen Berkas</span>
        </a>

        <?php
        $isLocked = isset($completionPercentage) && $completionPercentage < 100;
        $cetakUrl = $isLocked ? '#' : base_url('siswa/cetak-formulir');
        $cetakTarget = $isLocked ? '' : 'target="_blank" rel="noopener"';
        $cetakClick = $isLocked ? 'onclick="alert(\'Silahkan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : '';
        ?>
        <a href="<?= $cetakUrl ?>" <?= $cetakTarget ?> <?= $cetakClick ?>
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 p-4 text-xs font-bold text-white shadow-theme-xs transition-all <?= $isLocked ? 'opacity-50 cursor-not-allowed' : '' ?>">
            <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
            <span>Cetak Formulir PDF</span>
        </a>
    </div>

</div>

<?= $this->endSection() ?>