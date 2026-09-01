<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Kotak Masuk Pesan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Kotak Masuk Pesan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header Banner -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 border border-brand-200/60 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-2xl">inbox</span>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Pesan &amp; Notifikasi Pribadi</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Komunikasi resmi secara langsung antara panitia PPDB dan calon siswa.</p>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-3.5 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between">
            <h4 class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-wider">Daftar Pesan Masuk</h4>
            <span class="text-xs text-gray-400 font-mono"><?= count($pesan ?? []) ?> Pesan</span>
        </div>

        <?php if (!empty($pesan)) : ?>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php foreach ($pesan as $p) : ?>
                    <?php 
                    $isUnread = ($p['status'] ?? '') === 'unread';
                    $inisial = mb_substr(trim($p['nama_pengirim'] ?? 'P'), 0, 1);
                    ?>
                    <a href="<?= base_url('siswa/pesan/detail/' . $p['id_pesan']) ?>"
                       class="block p-4 sm:p-5 transition-colors duration-150 <?= $isUnread ? 'bg-brand-50/30 hover:bg-brand-50/60 dark:bg-brand-500/5 dark:hover:bg-brand-500/10' : 'hover:bg-gray-50/80 dark:hover:bg-gray-800/40' ?>">
                        <div class="flex items-start sm:items-center justify-between gap-4">
                            
                            <div class="flex items-start sm:items-center gap-3.5 flex-1 min-w-0">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl font-bold text-sm shrink-0 <?= $isUnread ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' ?>">
                                    <?= esc($inisial) ?>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <span class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                            <?= esc($p['nama_pengirim']) ?>
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold <?= ($p['pengirim_type'] ?? '') === 'admin' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400' ?>">
                                            <?= ucfirst($p['pengirim_type'] ?? 'Panitia') ?>
                                        </span>
                                        <?php if ($isUnread): ?>
                                            <span class="inline-flex items-center gap-1 rounded-full bg-brand-500 px-2 py-0.5 text-[9px] font-bold text-white uppercase tracking-wider">
                                                Baru
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <h5 class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-gray-200 truncate <?= $isUnread ? 'font-bold text-brand-600 dark:text-brand-400' : '' ?>">
                                        <?= esc($p['subjek']) ?>
                                    </h5>
                                    
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                        <?= esc(substr(strip_tags($p['isi_pesan'] ?? ''), 0, 100)) ?>...
                                    </p>
                                </div>
                            </div>

                            <div class="shrink-0 flex flex-col items-end gap-1.5 text-right">
                                <span class="text-[11px] font-medium text-gray-400 dark:text-gray-500 whitespace-nowrap">
                                    <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                </span>
                                <span class="material-symbols-outlined text-base text-gray-400">chevron_right</span>
                            </div>

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="p-12 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl">mail</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Kotak Masuk Kosong</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Belum ada pesan masuk dari panitia PPDB.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
