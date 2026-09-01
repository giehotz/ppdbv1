<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pesan Pribadi Terkirim
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">mail</span> Pesan Pribadi Terkirim
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pesan Keluar</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Riwayat pesan langsung dan pemberitahuan khusus yang dikirimkan ke calon peserta didik</p>
    </div>

    <a href="<?= base_url('admin/pesan/create') ?>"
       class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all active:scale-[0.97]">
        <span class="material-symbols-outlined text-base">send</span>
        <span>Buat Pesan Baru</span>
    </a>
</div>

<!-- Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3.5 px-4">Penerima Pesan</th>
                    <th class="py-3.5 px-4">Subjek & Rangkuman</th>
                    <th class="py-3.5 px-4">Waktu Terkirim</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (!empty($pesan)) : ?>
                    <?php foreach ($pesan as $p) : ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold font-mono text-sm">
                                        <?= strtoupper(substr($p['nama_penerima'] ?? 'S', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white"><?= esc($p['nama_penerima']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 max-w-xs md:max-w-md">
                                <div class="font-bold text-gray-900 dark:text-white truncate"><?= esc($p['subjek']) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500 truncate mt-0.5">
                                    <?= substr(strip_tags($p['isi_pesan']), 0, 70) ?>...
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= date('d/m/Y H:i', strtotime($p['created_at'])) ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <?php if ($p['status'] == 'read') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="material-symbols-outlined text-xs">done_all</span> Dibaca
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                                        <span class="material-symbols-outlined text-xs">check</span> Terkirim
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="<?= base_url('admin/pesan/detail/' . $p['id_pesan']) ?>"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                                       title="Lihat Detail Pesan">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                    <form method="post" action="<?= base_url('admin/pesan/delete/' . $p['id_pesan']) ?>"
                                          data-confirm="Yakin ingin menghapus pesan ini?"
                                          class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 transition"
                                                title="Hapus">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2">mark_email_unread</span>
                            <p class="text-xs">Belum ada pesan pribadi yang dikirimkan.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
