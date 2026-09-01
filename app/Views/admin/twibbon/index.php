<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Twibbon
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">wallpaper</span> Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Kampanye Twibbon</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola bingkai promosi media sosial dan pantau statistik unduhan calon siswa</p>
    </div>

    <div class="flex items-center gap-2.5">
        <a href="<?= base_url('admin/twibbon/setting') ?>"
           class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">settings</span>
            <span>Pengaturan</span>
        </a>
        <a href="<?= base_url('admin/twibbon/create') ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">add</span>
            <span>Tambah Kampanye</span>
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3.5 px-4">Bingkai</th>
                    <th class="py-3.5 px-4">Nama Kampanye</th>
                    <th class="py-3.5 px-4">Periode Tayang</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Total Unduhan</th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (empty($campaigns)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2">wallpaper</span>
                            <p class="text-xs">Belum ada kampanye twibbon yang dibuat.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($campaigns as $c): ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <?php if (!empty($c['frame']['file_path'])): ?>
                                    <div class="h-14 w-14 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-800 shadow-theme-xs">
                                        <img src="<?= base_url($c['frame']['file_path']) ?>" alt="Frame" class="h-full w-full object-cover hover:scale-105 transition-transform duration-200">
                                    </div>
                                <?php else: ?>
                                    <div class="h-14 w-14 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex items-center justify-center text-gray-400">
                                        <span class="material-symbols-outlined text-2xl">image</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 max-w-xs md:max-w-sm">
                                <div class="font-bold text-gray-900 dark:text-white truncate"><?= esc($c['title']) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500 truncate mt-0.5"><?= strip_tags($c['description'] ?: 'Tidak ada deskripsi') ?></div>
                                <div class="mt-1">
                                    <a href="<?= base_url('twibbon/' . $c['slug']) ?>" target="_blank"
                                       class="inline-flex items-center gap-1 text-[11px] font-semibold text-brand-600 dark:text-brand-400 hover:underline">
                                        <span>Lihat Halaman Publik</span>
                                        <span class="material-symbols-outlined text-xs">open_in_new</span>
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-400">
                                <?php if ($c['start_date'] || $c['end_date']): ?>
                                    <div><span class="text-gray-400">Mulai:</span> <?= $c['start_date'] ? date('d M Y', strtotime($c['start_date'])) : '-' ?></div>
                                    <div class="mt-0.5"><span class="text-gray-400">Selesai:</span> <?= $c['end_date'] ? date('d M Y', strtotime($c['end_date'])) : '-' ?></div>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-gray-500">
                                        <span class="material-symbols-outlined text-xs">all_inclusive</span> Selamanya
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <?php
                                $today = date('Y-m-d');
                                $activeDate = true;
                                if ($c['start_date'] && $c['start_date'] > $today) $activeDate = false;
                                if ($c['end_date'] && $c['end_date'] < $today) $activeDate = false;

                                if ($c['is_active'] && $activeDate): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap font-mono font-bold text-gray-900 dark:text-white">
                                <?= number_format($c['total_downloads']) ?> <span class="text-xs font-normal text-gray-400">kali</span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="<?= base_url('admin/twibbon/stats/' . $c['id']) ?>"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25 transition"
                                       title="Statistik Kampanye">
                                        <span class="material-symbols-outlined text-base">monitoring</span>
                                    </a>
                                    <a href="<?= base_url('admin/twibbon/edit/' . $c['id']) ?>"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-500/15 dark:text-amber-400 dark:hover:bg-amber-500/25 transition"
                                       title="Edit">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </a>
                                    <form action="<?= base_url('admin/twibbon/delete/' . $c['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kampanye ini?');" class="inline">
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
