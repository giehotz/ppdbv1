<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Pesan Terkirim
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Detail Pesan Terkirim
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">drafts</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        <?= esc($pesan['subjek']) ?>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi rincian pesan terkirim</p>
                </div>
            </div>
            <a href="<?= base_url('admin/pesan') ?>"
               class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>

        <div class="p-6 md:p-8">
            <!-- Recipient & Meta Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold font-mono text-base">
                        <?= strtoupper(substr($pesan['nama_penerima'] ?? 'S', 0, 1)) ?>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">Kepada: <?= esc($pesan['nama_penerima']) ?></h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Status:</span>
                            <?php if ($pesan['status'] == 'read') : ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                    <span class="material-symbols-outlined text-xs">done_all</span> Telah Dibaca Siswa
                                </span>
                            <?php else : ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                                    <span class="material-symbols-outlined text-xs">check</span> Belum Dibaca
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-gray-500 dark:text-gray-400 font-mono self-start sm:self-center">
                    <span class="material-symbols-outlined text-xs align-middle mr-0.5">schedule</span>
                    <?= date('d M Y, H:i', strtotime($pesan['created_at'])) ?> WIB
                </div>
            </div>

            <!-- Message Body -->
            <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-6 text-sm text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed min-h-[160px]">
<?= esc($pesan['isi_pesan']) ?>
            </div>

            <!-- Action Bar -->
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <form method="post" action="<?= base_url('admin/pesan/delete/' . $pesan['id_pesan']) ?>"
                      data-confirm="Yakin ingin menghapus pesan ini?"
                      class="inline">
                    <?= csrf_field() ?>
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-500/20 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 px-4 py-2.5 text-xs font-bold transition active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">delete</span>
                        <span>Hapus Pesan</span>
                    </button>
                </form>

                <a href="<?= base_url('admin/pesan/create') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">send</span>
                    <span>Tulis Pesan Baru</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
