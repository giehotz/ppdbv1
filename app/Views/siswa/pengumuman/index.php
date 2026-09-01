<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Pengumuman<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">campaign</span> Pengumuman &amp; Informasi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header Banner -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 border border-brand-200/60 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-2xl">campaign</span>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Pusat Informasi &amp; Pengumuman</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Dapatkan informasi resmi terbaru seputar tahapan seleksi, berkas, dan pengumuman madrasah.</p>
            </div>
        </div>
    </div>

    <?php if (empty($announcements)): ?>
        <!-- Empty State -->
        <div class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl">notifications_off</span>
            </div>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Belum Ada Pengumuman</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm mx-auto">Saat ini belum ada pengumuman yang dipublikasikan oleh panitia. Silakan periksa kembali secara berkala.</p>
        </div>
    <?php else: ?>
        <!-- Announcements List -->
        <div class="grid grid-cols-1 gap-4 md:gap-5">
            <?php foreach ($announcements as $announcement): ?>
                <?php
                $typeMap = [
                    'general' => [
                        'label' => 'Informasi Umum',
                        'icon' => 'info',
                        'pill' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/15 dark:text-blue-400 dark:border-blue-800/40',
                        'border' => 'border-l-blue-500',
                    ],
                    'ujian' => [
                        'label' => 'Jadwal / Ujian',
                        'icon' => 'assignment',
                        'pill' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/15 dark:text-amber-400 dark:border-amber-800/40',
                        'border' => 'border-l-amber-500',
                    ],
                    'kelulusan' => [
                        'label' => 'Kelulusan',
                        'icon' => 'school',
                        'pill' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400 dark:border-emerald-800/40',
                        'border' => 'border-l-emerald-500',
                    ],
                ];
                $typeConfig = $typeMap[$announcement['tipe']] ?? [
                    'label' => ucfirst($announcement['tipe']),
                    'icon' => 'campaign',
                    'pill' => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
                    'border' => 'border-l-brand-500',
                ];
                ?>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] border-l-4 <?= $typeConfig['border'] ?>">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider border <?= $typeConfig['pill'] ?>">
                                <span class="material-symbols-outlined text-[12px]"><?= $typeConfig['icon'] ?></span>
                                <?= esc($typeConfig['label']) ?>
                            </span>
                        </div>

                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-xs">calendar_today</span>
                            <?= date('d F Y', strtotime($announcement['publish_date'])) ?>
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3">
                        <?= esc($announcement['judul']) ?>
                    </h3>

                    <!-- Content -->
                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed space-y-2 bg-gray-50/60 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-100 dark:border-gray-800">
                        <?= nl2br(esc($announcement['isi_pengumuman'] ?? '')) ?>
                    </div>

                    <?php if (!empty($announcement['lampiran'])): ?>
                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            <span class="text-xs text-gray-400 dark:text-gray-500 inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">attachment</span>
                                Lampiran berkas tersedia
                            </span>
                            <a href="<?= base_url('uploads/pengumuman/' . $announcement['lampiran']) ?>"
                               target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-brand-50 px-3.5 py-2 text-xs font-bold text-brand-600 hover:bg-brand-100 dark:bg-brand-500/15 dark:text-brand-400 dark:hover:bg-brand-500/25 transition-colors shadow-theme-xs">
                                <span class="material-symbols-outlined text-sm">download</span>
                                <span>Unduh Lampiran</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>