<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Pesan Terkirim<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Pesan Pribadi Terkirim
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6 flex justify-between items-center flex-wrap gap-4">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Pesan Terkirim</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Riwayat pemberitahuan dan komunikasi langsung dengan calon peserta didik.</p>
        </div>
        
        <a href="<?= base_url('verifikator/pesan/create') ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-500 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">send</span>
            <span>Tulis Pesan Baru</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-5">Penerima (Siswa)</th>
                    <th class="py-3.5 px-5">Subjek &amp; Cuplikan Pesan</th>
                    <th class="py-3.5 px-5">Waktu Kirim</th>
                    <th class="py-3.5 px-5 text-center">Status</th>
                    <th class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($pesan)) : ?>
                    <?php foreach ($pesan as $p) : 
                        $inisial = mb_substr(trim($p['nama_penerima']), 0, 1);
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= esc($inisial) ?>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white"><?= esc($p['nama_penerima']) ?></span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-gray-900 dark:text-white"><?= esc($p['subjek']) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500 truncate max-w-sm mt-0.5">
                                    <?= esc(substr(strip_tags($p['isi_pesan']), 0, 60)) ?>...
                                </div>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap text-gray-500 dark:text-gray-400 font-medium">
                                <?= date('d/m/Y H:i', strtotime($p['created_at'])) ?>
                            </td>
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <?php if ($p['status'] === 'read') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                        <span class="material-symbols-outlined text-xs">done_all</span> Dibaca
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                                        <span class="material-symbols-outlined text-xs">check</span> Terkirim
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1">
                                    <a href="<?= base_url('verifikator/pesan/detail/' . $p['id_pesan']) ?>"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/15 transition-colors"
                                        title="Buka Pesan">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                    <form method="post" action="<?= base_url('verifikator/pesan/delete/' . $p['id_pesan']) ?>"
                                        data-confirm="Yakin ingin menghapus pesan ini?"
                                        class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/15 transition-colors"
                                            title="Hapus Pesan">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="py-12 px-5 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl mb-2 text-gray-300 dark:text-gray-600">mark_email_unread</span>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">Belum ada riwayat pesan terkirim.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
