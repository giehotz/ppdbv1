<?= $this->extend('pindahan/layouts/siswa_pindahan') ?>

<?= $this->section('title') ?>Status Pendaftaran<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">rule</span> Status Pendaftaran Siswa Pindahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Status Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center">
        <?php
        $statusVerif = $pindahan['status_verifikasi'] ?? 'Menunggu';
        if ($statusVerif === 'Terverifikasi') {
            $badgeBg = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/40';
            $icon = 'verified';
            $statusTitle = 'Pendaftaran Terverifikasi';
            $desc = 'Data dan berkas pindahan Anda telah berhasil diverifikasi oleh panitia.';
        } elseif ($statusVerif === 'Ditolak') {
            $badgeBg = 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 border-red-200 dark:border-red-800/40';
            $icon = 'cancel';
            $statusTitle = 'Pendaftaran Ditolak / Perlu Perbaikan';
            $desc = 'Data atau berkas Anda belum memenuhi syarat. Silakan perbaiki sesuai catatan di bawah.';
        } else {
            $badgeBg = 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border-amber-200 dark:border-amber-800/40';
            $icon = 'hourglass_top';
            $statusTitle = 'Menunggu Antrean Verifikasi';
            $desc = 'Pendaftaran Anda tersimpan dan sedang menunggu pemeriksaan oleh verifikator.';
        }
        ?>

        <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl border <?= $badgeBg ?> shadow-theme-sm mx-auto mb-4">
            <span class="material-symbols-outlined text-4xl"><?= $icon ?></span>
        </div>
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2"><?= $statusTitle ?></h3>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-lg mx-auto leading-relaxed"><?= $desc ?></p>

        <?php if (!empty($pindahan['catatan_verifikasi'])): ?>
            <div class="mt-5 max-w-xl mx-auto rounded-xl border border-red-200 bg-red-50/70 p-4 text-left dark:border-red-900/40 dark:bg-red-950/20 text-xs">
                <div class="flex items-center gap-1.5 font-bold text-red-800 dark:text-red-300 mb-1">
                    <span class="material-symbols-outlined text-base">info</span> Catatan Perbaikan:
                </div>
                <p class="text-red-700 dark:text-red-400 italic pl-5">"<?= esc($pindahan['catatan_verifikasi']) ?>"</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Rincian Data -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">id_card</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Rincian Data Pendaftar</h4>
            </div>
            <span class="font-mono text-xs font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2.5 py-1 rounded-lg border border-brand-200 dark:border-brand-800/40">
                <?= esc($pindahan['no_pendaftaran'] ?? '-') ?>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3.5">
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">NISN</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white font-mono"><?= esc($pindahan['nisn'] ?? '-') ?></span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">NIK</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white font-mono"><?= esc($pindahan['nik'] ?? '-') ?></span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Jenis Kelamin</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white"><?= ($pindahan['jk'] ?? '') === 'L' ? 'Laki-laki' : (($pindahan['jk'] ?? '') === 'P' ? 'Perempuan' : '-') ?></span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40 sm:col-span-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Nama Lengkap</span>
                <span class="text-sm font-bold text-gray-900 dark:text-white"><?= esc($pindahan['nama_lengkap'] ?? '-') ?></span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Tempat, Tanggal Lahir</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white">
                    <?= esc($pindahan['tempat_lahir'] ?? '-') ?>, <?= !empty($pindahan['tgl_lahir']) ? date('d/m/Y', strtotime($pindahan['tgl_lahir'])) : '-' ?>
                </span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Jenjang Asal</span>
                <span class="text-xs font-bold text-gray-900 dark:text-white"><?= esc($pindahan['jenjang_sekolah_asal'] ?? '-') ?></span>
            </div>
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Status Verifikasi</span>
                <span class="text-xs font-bold <?= $statusVerif === 'Terverifikasi' ? 'text-emerald-600' : ($statusVerif === 'Ditolak' ? 'text-red-600' : 'text-amber-600') ?>"><?= esc($statusVerif) ?></span>
            </div>
        </div>
    </div>

    <!-- Berkas Status -->
    <?php if (!empty($berkasWajib)): ?>
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
                <span class="material-symbols-outlined text-brand-500">upload_file</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Status Berkas Wajib</h4>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                        <div class="<?= $berkasWajib['lengkap'] ? 'bg-gradient-to-r from-emerald-500 to-teal-500' : 'bg-gradient-to-r from-amber-500 to-orange-500' ?> h-3 rounded-full transition-all duration-500" style="width: <?= $berkasWajib['total'] > 0 ? round(($berkasWajib['sudah'] / $berkasWajib['total']) * 100) : 0 ?>%"></div>
                    </div>
                </div>
                <span class="text-xs font-bold text-gray-700 dark:text-gray-300 shrink-0"><?= $berkasWajib['sudah'] ?>/<?= $berkasWajib['total'] ?> berkas</span>
            </div>
            <?php if (!$berkasWajib['lengkap']): ?>
                <a href="<?= base_url('siswa/pindahan/berkas') ?>" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:underline">Unggah Berkas <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Riwayat Verifikasi -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
            <span class="material-symbols-outlined text-brand-500">history</span>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Verifikasi</h4>
        </div>
        <?php if (!empty($verifikasiRiwayat)): ?>
            <div class="space-y-3">
                <?php foreach ($verifikasiRiwayat as $rv): ?>
                    <?php $stColor = match (strtolower($rv['ket'] ?? '')) { 'terverifikasi' => 'bg-emerald-50 text-emerald-700', 'ditolak' => 'bg-red-50 text-red-700', default => 'bg-gray-50 text-gray-600' }; ?>
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/20">
                        <span class="material-symbols-outlined text-gray-400 mt-0.5 text-lg">schedule</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-900 dark:text-white"><?= esc($rv['ket'] ?? '-') ?> <span class="font-normal text-gray-400">· <?= esc($rv['verifikator'] ?? '-') ?></span></p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400"><?= nl2br(esc($rv['isi'] ?? '-')) ?></p>
                            <span class="text-[10px] text-gray-400"><?= esc($rv['created_at'] ?? $rv['tgl_verifikasi'] ?? '-') ?></span>
                        </div>
                        <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-[10px] font-semibold <?= $stColor ?>"><?= esc($rv['ket'] ?? '-') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="py-6 text-center">
                <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-600">history_toggle_off</span>
                <p class="text-xs text-gray-400 mt-2">Belum ada riwayat verifikasi.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>