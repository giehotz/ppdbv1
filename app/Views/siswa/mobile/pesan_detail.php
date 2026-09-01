<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Detail Pesan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Baca Pesan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$inisial = mb_substr(trim($pesan['nama_pengirim'] ?? 'P'), 0, 1);
?>

<div class="space-y-4">
    <div class="rounded-2xl border border-gray-200 bg-white p-4.5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
        
        <!-- Header bar -->
        <div class="flex items-center justify-between gap-2 pb-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-xs font-bold text-gray-900 dark:text-white leading-snug">
                <?= esc($pesan['subjek']) ?>
            </h3>
            <a href="<?= base_url('siswa/pesan') ?>" class="h-7 w-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-base">close</span>
            </a>
        </div>

        <!-- Sender info -->
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-xs shrink-0">
                    <?= esc($inisial) ?>
                </div>
                <div class="min-w-0">
                    <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate"><?= esc($pesan['nama_pengirim']) ?></h4>
                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[8px] font-bold <?= ($pesan['pengirim_type'] ?? '') === 'admin' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400' ?>">
                        <?= ucfirst($pesan['pengirim_type'] ?? 'Panitia') ?>
                    </span>
                </div>
            </div>
            <span class="text-[9px] text-gray-400 font-mono shrink-0">
                <?= date('d/m/y H:i', strtotime($pesan['created_at'])) ?>
            </span>
        </div>

        <!-- Content -->
        <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40 text-xs text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap min-h-[140px]">
            <?= esc($pesan['isi_pesan']) ?>
        </div>

        <!-- Back Button -->
        <a href="<?= base_url('siswa/pesan') ?>"
           class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Kotak Masuk</span>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
