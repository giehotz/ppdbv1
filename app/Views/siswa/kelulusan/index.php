<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Pengumuman Kelulusan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">school</span> Hasil Seleksi &amp; Kelulusan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto space-y-6">
    
    <!-- Main Result Card (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 md:p-10 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center overflow-hidden relative">
        
        <?php if (isset($web['pengumuman_aktif']) && $web['pengumuman_aktif'] == 1) : ?>
            
            <?php if (($siswa['status_lulus'] ?? '') === 'Lulus') : ?>
                <!-- CASE 1: LULUS SELEKSI -->
                <div class="space-y-6">
                    <div class="inline-flex h-24 w-24 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-500/30 shadow-theme-sm mx-auto">
                        <span class="material-symbols-outlined text-5xl">verified</span>
                    </div>

                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1 text-xs font-bold uppercase tracking-wider text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                            <span class="material-symbols-outlined text-sm">celebration</span>
                            Hasil Seleksi Diumumkan
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Selamat! Anda Dinyatakan <span class="text-emerald-600 dark:text-emerald-400">LULUS</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                            Selamat atas keberhasilan Anda lolos dalam proses seleksi <?= esc($app_alias ?? 'PPDB') ?> di <?= esc($web['nama_sekolah'] ?? 'Madrasah/Sekolah') ?>.
                        </p>
                    </div>

                    <!-- Student Detail Grid Box -->
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/70 p-5 dark:border-gray-800 dark:bg-gray-850/50 max-w-md mx-auto text-left space-y-3">
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-200/60 dark:border-gray-700/60">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Nama Lengkap</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap']) ?></span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-200/60 dark:border-gray-700/60">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">No. Pendaftaran</span>
                            <span class="font-mono text-xs font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2 py-0.5 rounded-lg border border-brand-200 dark:border-brand-800/40">
                                <?= esc($siswa['no_pendaftaran']) ?>
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-1.5">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">NISN</span>
                            <span class="font-mono text-xs font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nisn'] ?? '-') ?></span>
                        </div>
                    </div>

                    <!-- Print Action Button -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.98] w-full sm:w-auto">
                            <span class="material-symbols-outlined text-base">print</span>
                            <span>Cetak Surat Bukti Kelulusan</span>
                        </a>

                        <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                            <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-all w-full sm:w-auto">
                                <i class="fab fa-whatsapp text-emerald-600 dark:text-emerald-400 text-base"></i>
                                <span>Grup WhatsApp Siswa Lulus</span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Petunjuk Daftar Ulang -->
                    <div class="rounded-xl border border-emerald-200/70 bg-emerald-50/50 p-4 text-left dark:border-emerald-900/40 dark:bg-emerald-950/20 text-xs space-y-1.5">
                        <div class="flex items-center gap-1.5 font-bold text-emerald-800 dark:text-emerald-300">
                            <span class="material-symbols-outlined text-base">info</span>
                            <span>Langkah Selanjutnya:</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed pl-5">
                            Silakan cetak dan simpan <strong>Surat Bukti Kelulusan</strong> di atas, lalu lakukan proses daftar ulang sesuai jadwal yang tertera pada surat atau pengumuman panitia.
                        </p>
                    </div>
                </div>

            <?php elseif (($siswa['status_lulus'] ?? '') === 'Tidak Lulus') : ?>
                <!-- CASE 2: TIDAK LULUS -->
                <div class="space-y-5 py-4">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/40 mx-auto">
                        <span class="material-symbols-outlined text-4xl">cancel</span>
                    </div>

                    <div class="space-y-1.5">
                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-0.5 text-xs font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                            Pengumuman Seleksi
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Mohon Maaf, Belum Lulus
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                            Berdasarkan hasil penilaian panitia seleksi <?= esc($app_alias ?? 'PPDB') ?>, Anda dinyatakan <strong>belum berhasil lolos</strong> pada periode ini.
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-850 max-w-sm mx-auto text-xs text-gray-600 dark:text-gray-400">
                        <p class="italic">"Jangan berkecil hati, tetap semangat belajar dan terus berjuang untuk meraih masa depan yang gemilang."</p>
                    </div>
                </div>

            <?php else : ?>
                <!-- CASE 3: DALAM PROSES -->
                <div class="space-y-5 py-4">
                    <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/40 mx-auto">
                        <span class="material-symbols-outlined text-4xl animate-pulse">hourglass_top</span>
                    </div>

                    <div class="space-y-1.5">
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-0.5 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                            Tahap Seleksi Berjalan
                        </span>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Proses Seleksi Sedang Berlangsung
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                            Data berkas dan formulir pendaftaran Anda sedang dalam tahap verifikasi serta perankingan oleh panitia penerimaan siswa baru.
                        </p>
                    </div>

                    <?php if (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                        <div class="inline-block rounded-xl border border-amber-200 bg-amber-50/60 p-4 text-xs dark:border-amber-900/40 dark:bg-amber-950/20">
                            <span class="text-amber-800 dark:text-amber-300 block font-medium">Jadwal Rilis Pengumuman:</span>
                            <span class="text-sm font-bold text-amber-900 dark:text-amber-200 mt-0.5 block font-mono">
                                <?= date('d F Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        <?php else : ?>
            <!-- CASE 4: BELUM DIUMUMKAN / PENGUMUMAN NONAKTIF -->
            <div class="space-y-5 py-6">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200 dark:border-blue-800/40 mx-auto">
                    <span class="material-symbols-outlined text-4xl">campaign</span>
                </div>

                <div class="space-y-1.5">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                        Pengumuman Belum Dibuka
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                        Hasil seleksi penerimaan siswa baru saat ini belum dipublikasikan secara resmi oleh panitia.
                    </p>
                </div>

                <?php if (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <div class="rounded-2xl border border-brand-200 bg-brand-50/60 p-5 dark:border-brand-900/40 dark:bg-brand-950/20 max-w-sm mx-auto text-center space-y-1">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-brand-700 dark:text-brand-300">Estimasi Jadwal Pengumuman</span>
                        <p class="text-base font-bold text-gray-900 dark:text-white font-mono">
                            <?= date('d F Y', strtotime($web['tgl_pengumuman'])) ?>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pukul <?= date('H:i', strtotime($web['tgl_pengumuman'])) ?> WIB</p>
                    </div>
                <?php else : ?>
                    <p class="text-xs text-gray-400 dark:text-gray-500 italic">
                        Pantau akun pendaftaran Anda atau portal informasi resmi madrasah secara berkala.
                    </p>
                <?php endif; ?>
            </div>

        <?php endif; ?>

        <!-- Footer Navigation Link -->
        <div class="mt-8 pt-5 border-t border-gray-100 dark:border-gray-800 text-center">
            <a href="<?= base_url('siswa/dashboard') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Kembali ke Dashboard Siswa</span>
            </a>
        </div>

    </div>

</div>

<?= $this->endSection() ?>