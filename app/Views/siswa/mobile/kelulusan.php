<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Hasil Kelulusan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pengumuman Kelulusan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center">
        
        <?php if (isset($web['pengumuman_aktif']) && $web['pengumuman_aktif'] == 1) : ?>
            <?php if (($siswa['status_lulus'] ?? '') === 'Lulus') : ?>
                <!-- CASE: LULUS -->
                <div class="space-y-4">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 shadow-theme-xs mx-auto">
                        <span class="material-symbols-outlined text-4xl">verified</span>
                    </div>

                    <div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                            Dinyatakan Lulus
                        </span>
                        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mt-1">
                            Selamat! Anda <span class="text-emerald-600 dark:text-emerald-400">LULUS</span>
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Selamat atas keberhasilan Anda lolos seleksi penerimaan siswa baru.
                        </p>
                    </div>

                    <!-- Student info box -->
                    <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40 text-left space-y-2 text-xs">
                        <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-gray-400">Nama:</span>
                            <span class="font-bold text-gray-900 dark:text-white truncate max-w-[170px]"><?= esc($siswa['nama_lengkap']) ?></span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-gray-400">No. Daftar:</span>
                            <span class="font-mono font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2 py-0.5 rounded">
                                <?= esc($siswa['no_pendaftaran']) ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-gray-400">NISN:</span>
                            <span class="font-mono font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nisn'] ?? '-') ?></span>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="space-y-2 pt-1">
                        <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" rel="noopener"
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 py-3 text-xs font-bold text-white shadow-theme-xs transition-colors">
                            <span class="material-symbols-outlined text-base">print</span>
                            <span>Cetak Surat Bukti Kelulusan</span>
                        </a>

                        <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                            <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener"
                               class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 transition-colors">
                                <i class="fab fa-whatsapp text-emerald-600"></i>
                                <span>Grup WhatsApp Siswa Lulus</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif (($siswa['status_lulus'] ?? '') === 'Tidak Lulus') : ?>
                <!-- CASE: TIDAK LULUS -->
                <div class="py-4 space-y-3">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/40 mx-auto">
                        <span class="material-symbols-outlined text-3xl">cancel</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Mohon Maaf, Belum Lulus</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed px-2">
                        Anda dinyatakan belum lolos pada periode seleksi ini. Tetap semangat dan pantang menyerah!
                    </p>
                </div>

            <?php else : ?>
                <!-- CASE: PROSES -->
                <div class="py-4 space-y-3">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/40 mx-auto">
                        <span class="material-symbols-outlined text-3xl animate-pulse">hourglass_top</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Dalam Proses Seleksi</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                        Data kelulusan Anda sedang dalam tahap penentuan oleh panitia.
                    </p>
                    <?php if (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                        <div class="rounded-xl border border-amber-200 bg-amber-50/60 p-3 dark:border-amber-900/40 dark:bg-amber-950/20 text-xs">
                            <span class="text-amber-800 dark:text-amber-300 block text-[10px] font-medium">Jadwal Pengumuman:</span>
                            <span class="font-bold text-amber-900 dark:text-amber-200 font-mono"><?= date('d F Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <!-- CASE: BELUM DIBUKA -->
            <div class="py-6 space-y-3">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40 mx-auto">
                    <span class="material-symbols-outlined text-3xl">campaign</span>
                </div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengumuman Belum Dibuka</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto leading-relaxed">
                    Hasil seleksi penerimaan siswa baru belum dipublikasikan oleh panitia.
                </p>

                <?php if (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <div class="rounded-xl border border-brand-200 bg-brand-50/60 p-3.5 dark:border-brand-900/40 dark:bg-brand-950/20 text-center">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-brand-700 dark:text-brand-300 block mb-1">Rencana Pengumuman</span>
                        <p class="text-sm font-bold font-mono text-gray-900 dark:text-white"><?= date('d F Y', strtotime($web['tgl_pengumuman'])) ?></p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Pukul <?= date('H:i', strtotime($web['tgl_pengumuman'])) ?> WIB</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
