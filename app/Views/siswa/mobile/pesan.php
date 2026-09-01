<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Kotak Masuk<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Kotak Masuk Pesan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <!-- Header Banner -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0">
                <span class="material-symbols-outlined text-xl">inbox</span>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-900 dark:text-white">Pesan &amp; Notifikasi</h3>
                <p class="text-[10px] text-gray-400"><?= count($pesan ?? []) ?> pesan terdaftar</p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="space-y-2.5">
        <?php if (!empty($pesan)): ?>
            <?php foreach ($pesan as $p): ?>
                <?php 
                $isUnread = ($p['status'] ?? '') === 'unread';
                $inisial = mb_substr(trim($p['nama_pengirim'] ?? 'P'), 0, 1);
                ?>
                <a href="<?= base_url('siswa/pesan/detail/' . $p['id_pesan']) ?>"
                   class="block rounded-2xl border border-gray-200 bg-white p-3.5 shadow-theme-xs transition-all active:scale-[0.98] dark:border-gray-800 dark:bg-white/[0.03] <?= $isUnread ? 'border-brand-300 dark:border-brand-500/40 bg-brand-50/20' : '' ?>">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl font-bold text-xs shrink-0 <?= $isUnread ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' ?>">
                            <?= esc($inisial) ?>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="text-xs font-bold text-gray-900 dark:text-white truncate"><?= esc($p['nama_pengirim']) ?></span>
                                    <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[8px] font-bold <?= ($p['pengirim_type'] ?? '') === 'admin' ? 'bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400' : 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400' ?>">
                                        <?= ucfirst($p['pengirim_type'] ?? 'Panitia') ?>
                                    </span>
                                </div>
                                <?php if ($isUnread): ?>
                                    <span class="h-2 w-2 rounded-full bg-brand-500 shrink-0"></span>
                                <?php endif; ?>
                            </div>

                            <p class="text-xs <?= $isUnread ? 'font-bold text-brand-600 dark:text-brand-400' : 'font-semibold text-gray-800 dark:text-gray-200' ?> truncate">
                                <?= esc($p['subjek']) ?>
                            </p>
                            <p class="text-[10px] text-gray-400 truncate mt-0.5">
                                <?= esc(substr(strip_tags($p['isi_pesan'] ?? ''), 0, 70)) ?>...
                            </p>
                            <span class="text-[9px] text-gray-400 block mt-1">
                                <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-2">
                    <span class="material-symbols-outlined text-2xl">mail</span>
                </div>
                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Kotak Masuk Kosong</h4>
                <p class="text-[10px] text-gray-400 mt-0.5">Belum ada pesan dari panitia.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
