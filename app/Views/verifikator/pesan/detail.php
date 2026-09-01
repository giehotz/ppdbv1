<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Detail Pesan Terkirim<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Detail Pesan Terkirim
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] max-w-3xl">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-lg">mark_email_read</span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                <?= esc($pesan['subjek']) ?>
            </h3>
        </div>
        
        <a href="<?= base_url('verifikator/pesan') ?>" class="p-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" title="Kembali">
            <span class="material-symbols-outlined text-base">close</span>
        </a>
    </div>

    <div class="p-5 md:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 mb-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-sm shrink-0">
                    <?= mb_substr(trim($pesan['nama_penerima']), 0, 1) ?>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">Penerima: <?= esc($pesan['nama_penerima']) ?></h4>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400 dark:text-gray-500">Status:</span>
                        <?php if ($pesan['status'] === 'read') : ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                <span class="material-symbols-outlined text-xs">done_all</span> Telah Dibaca
                            </span>
                        <?php else : ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                <span class="material-symbols-outlined text-xs">check</span> Belum Dibaca
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500 font-medium self-start sm:self-center">
                <span class="material-symbols-outlined text-sm">schedule</span>
                <span><?= date('d M Y, H:i', strtotime($pesan['created_at'])) ?> WIB</span>
            </div>
        </div>

        <div class="bg-gray-50/70 dark:bg-gray-800/40 p-5 rounded-xl border border-gray-100 dark:border-gray-800 min-h-[180px] text-xs text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap font-sans">
<?= esc($pesan['isi_pesan']) ?>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center flex-wrap gap-3">
            <form method="post" action="<?= base_url('verifikator/pesan/delete/' . $pesan['id_pesan']) ?>"
                data-confirm="Yakin ingin menghapus riwayat pesan ini?"
                class="inline">
                <?= csrf_field() ?>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 text-xs font-semibold transition-colors active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">delete</span>
                    <span>Hapus Pesan</span>
                </button>
            </form>

            <a href="<?= base_url('verifikator/pesan/create') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-500 hover:bg-brand-600 text-xs font-bold text-white shadow-theme-xs transition-colors active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">send</span>
                <span>Kirim Pesan Lain</span>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
