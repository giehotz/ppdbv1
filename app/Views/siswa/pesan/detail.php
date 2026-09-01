<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Detail Pesan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Detail Pesan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$inisial = mb_substr(trim($pesan['nama_pengirim'] ?? 'P'), 0, 1);
?>

<div class="max-w-4xl mx-auto space-y-5">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        
        <!-- Header bar -->
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">mark_email_read</span>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                    <?= esc($pesan['subjek']) ?>
                </h3>
            </div>
            <a href="<?= base_url('siswa/pesan') ?>" class="h-8 w-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </a>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <!-- Sender info card -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-lg border border-brand-200/60 dark:border-brand-500/30 shrink-0">
                        <?= esc($inisial) ?>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                                <?= esc($pesan['nama_pengirim']) ?>
                            </h4>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold <?= ($pesan['pengirim_type'] ?? '') === 'admin' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400' ?>">
                                <?= ucfirst($pesan['pengirim_type'] ?? 'Panitia') ?>
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Pengirim Resmi Panitia PPDB</p>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1 text-xs font-mono text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/60 px-3 py-1.5 rounded-xl border border-gray-100 dark:border-gray-700 w-fit">
                    <span class="material-symbols-outlined text-sm text-gray-400">schedule</span>
                    <?= date('d F Y, H:i', strtotime($pesan['created_at'])) ?> WIB
                </span>
            </div>

            <!-- Message content -->
            <div class="rounded-2xl border border-gray-100 bg-gray-50/70 p-5 md:p-6 text-xs sm:text-sm text-gray-800 dark:border-gray-800 dark:bg-gray-850/50 dark:text-gray-200 leading-relaxed space-y-3 min-h-[200px]">
                <?= nl2br(esc($pesan['isi_pesan'])) ?>
            </div>

            <!-- Footer Action -->
            <div class="flex justify-between items-center pt-2">
                <a href="<?= base_url('siswa/pesan') ?>"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Kembali ke Kotak Masuk</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
