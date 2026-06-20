<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (empty($announcements)): ?>
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-8 flex flex-col items-center justify-center text-center mt-4">
        <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-bullhorn text-slate-300 text-2xl"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Pengumuman</h3>
        <p class="text-xs text-slate-500">Tidak ada pengumuman yang tersedia saat ini.</p>
    </div>
<?php else: ?>
    <div class="space-y-4 pb-4">
        <?php foreach ($announcements as $announcement): ?>
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 overflow-hidden active:scale-[0.98] transition-transform">
                <div class="p-4 border-b border-slate-100/50">
                    <?php
                    $typeColors = [
                        'general' => 'blue',
                        'ujian' => 'amber',
                        'kelulusan' => 'emerald'
                    ];
                    $typeIcons = [
                        'general' => 'fa-bullhorn',
                        'ujian' => 'fa-file-alt',
                        'kelulusan' => 'fa-graduation-cap'
                    ];
                    $color = $typeColors[$announcement['tipe']] ?? 'slate';
                    $icon = $typeIcons[$announcement['tipe']] ?? 'fa-bullhorn';
                    ?>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-<?= $color ?>-50/80 text-<?= $color ?>-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-<?= $color ?>-200/50 uppercase tracking-wide flex items-center">
                            <i class="fas <?= $icon ?> mr-1.5"></i><?= $announcement['tipe'] ?>
                        </span>
                        <span class="text-[10px] text-slate-400 font-medium">
                            <?= date('d M Y', strtotime($announcement['publish_date'])) ?>
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 leading-tight">
                        <?= esc($announcement['judul']) ?>
                    </h3>
                </div>

                <div class="p-4 bg-slate-50/30">
                    <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line"><?= esc((string)($announcement['isi_pengumuman'] ?? '')) ?></p>

                    <?php if (!empty($announcement['lampiran'])): ?>
                        <div class="mt-3">
                            <a href="<?= base_url('uploads/pengumuman/' . $announcement['lampiran']) ?>" 
                               target="_blank" 
                               class="flex items-center justify-center gap-2 w-full bg-emerald-50/80 hover:bg-emerald-100/80 text-emerald-700 font-semibold py-2.5 rounded-xl text-xs transition active:scale-[0.97]">
                                <i class="fas fa-paperclip"></i> Lihat Lampiran
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
