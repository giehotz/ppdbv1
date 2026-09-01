<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Pengumuman<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pusat Informasi<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <?php if (empty($announcements)): ?>
        <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-3">
                <span class="material-symbols-outlined text-2xl">campaign</span>
            </div>
            <h4 class="text-xs font-bold text-gray-800 dark:text-white">Belum Ada Pengumuman</h4>
            <p class="text-[11px] text-gray-400 mt-0.5">Informasi panitia akan muncul di sini.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($announcements as $announcement): ?>
                <?php
                $typeMap = [
                    'general' => [
                        'label' => 'Umum',
                        'icon' => 'info',
                        'pill' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/15 dark:text-blue-400',
                        'border' => 'border-l-blue-500',
                    ],
                    'ujian' => [
                        'label' => 'Ujian',
                        'icon' => 'assignment',
                        'pill' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/15 dark:text-amber-400',
                        'border' => 'border-l-amber-500',
                    ],
                    'kelulusan' => [
                        'label' => 'Kelulusan',
                        'icon' => 'school',
                        'pill' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/15 dark:text-emerald-400',
                        'border' => 'border-l-emerald-500',
                    ],
                ];
                $typeConfig = $typeMap[$announcement['tipe']] ?? [
                    'label' => ucfirst($announcement['tipe']),
                    'icon' => 'campaign',
                    'pill' => 'bg-gray-100 text-gray-700 border-gray-200',
                    'border' => 'border-l-brand-500',
                ];
                ?>
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] border-l-4 <?= $typeConfig['border'] ?> space-y-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border <?= $typeConfig['pill'] ?>">
                            <span class="material-symbols-outlined text-[11px]"><?= $typeConfig['icon'] ?></span>
                            <?= esc($typeConfig['label']) ?>
                        </span>
                        <span class="text-[10px] text-gray-400">
                            <?= date('d M Y', strtotime($announcement['publish_date'])) ?>
                        </span>
                    </div>

                    <h4 class="text-xs font-bold text-gray-900 dark:text-white leading-snug">
                        <?= esc($announcement['judul']) ?>
                    </h4>

                    <div class="text-[11px] text-gray-600 dark:text-gray-300 leading-relaxed bg-gray-50/70 dark:bg-gray-800/40 p-3 rounded-xl border border-gray-100 dark:border-gray-800">
                        <?= nl2br(esc($announcement['isi_pengumuman'] ?? '')) ?>
                    </div>

                    <?php if (!empty($announcement['lampiran'])): ?>
                        <div class="pt-2">
                            <a href="<?= base_url('uploads/pengumuman/' . $announcement['lampiran']) ?>" target="_blank" rel="noopener"
                               class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 py-2 text-xs font-bold transition-colors">
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
