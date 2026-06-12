<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (empty($announcements)): ?>
    <div class="bg-white rounded-2xl shadow-sm p-8 flex flex-col items-center justify-center text-center mt-4">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-bullhorn text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-base font-bold text-gray-800 mb-1">Belum Ada Pengumuman</h3>
        <p class="text-xs text-gray-500">Tidak ada pengumuman yang tersedia saat ini.</p>
    </div>
<?php else: ?>
    <div class="space-y-4 pb-4">
        <?php foreach ($announcements as $announcement): ?>
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden active:scale-[0.99] transition-transform">
                <!-- Header -->
                <div class="p-4 border-b border-gray-100">
                    <?php
                    $typeColors = [
                        'general' => 'blue',
                        'ujian' => 'yellow',
                        'kelulusan' => 'green'
                    ];
                    $typeIcons = [
                        'general' => 'fa-bullhorn',
                        'ujian' => 'fa-file-alt',
                        'kelulusan' => 'fa-graduation-cap'
                    ];
                    $color = $typeColors[$announcement['tipe']] ?? 'gray';
                    $icon = $typeIcons[$announcement['tipe']] ?? 'fa-bullhorn';
                    ?>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-<?= $color ?>-50 text-<?= $color ?>-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-<?= $color ?>-100 uppercase tracking-wide flex items-center">
                            <i class="fas <?= $icon ?> mr-1.5"></i><?= $announcement['tipe'] ?>
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium">
                            <?= date('d M Y', strtotime($announcement['publish_date'])) ?>
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-gray-800 leading-tight">
                        <?= esc($announcement['judul']) ?>
                    </h3>
                </div>

                <!-- Content -->
                <div class="p-4 bg-gray-50/30">
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?= esc((string)($announcement['isi_pengumuman'] ?? '')) ?></p>

                    <?php if (!empty($announcement['lampiran'])): ?>
                        <div class="mt-4">
                            <a href="<?= base_url('uploads/pengumuman/' . $announcement['lampiran']) ?>" 
                               target="_blank" 
                               class="flex items-center justify-center gap-2 w-full bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2.5 rounded-xl text-xs transition">
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
