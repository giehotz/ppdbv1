<!-- Header Section -->
<div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
        <div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Siswa Pindahan</h3>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data pendaftaran siswa pindahan, kelengkapan berkas, dan verifikasi.</p>
            <div class="flex flex-wrap items-center gap-2.5 w-full xl:w-auto">
                <form action="<?= base_url('admin/pindahan') ?>" method="get" class="inline-flex items-center gap-2 shrink-0">
                    <input type="hidden" name="sort" value="<?= esc($sort ?? 'ASC') ?>">
                    <input type="hidden" name="tab" value="<?= esc($currentTab ?? 'all') ?>">

                    <!-- Filter Tahun Pelajaran -->
                    <select name="th_pelajaran" onchange="this.form.submit()"
                            class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 cursor-pointer shrink-0">
                        <?php foreach (($tahunList ?? []) as $t): ?>
                            <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= ($selectedTh === $t['tahun_pelajaran']) ? 'selected' : '' ?>>
                                TP: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '★ (Aktif)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="all" <?= ($selectedTh === 'all') ? 'selected' : '' ?>>Semua Tahun Pelajaran</option>
                    </select>

                    <!-- Integrated Search Bar -->
                    <div class="inline-flex items-center h-9 rounded-lg border border-gray-200 bg-gray-50/50 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/50 overflow-hidden focus-within:border-brand-500 shrink-0">
                        <div class="pl-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-search text-xs"></i>
                        </div>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="h-full w-40 sm:w-56 bg-transparent py-1.5 px-2.5 text-xs text-gray-800 placeholder:text-gray-400 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder:text-gray-500">
                        <?php if (!empty($search)) : ?>
                            <a href="<?= base_url('admin/pindahan') ?>?th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
                               class="flex items-center justify-center h-full px-2 text-gray-400 hover:text-red-500 transition-colors"
                               title="Reset Pencarian">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        <?php endif; ?>
                        <button type="submit"
                                class="inline-flex items-center justify-center h-full bg-gray-900 px-3.5 text-xs font-semibold text-white transition-colors hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 shrink-0">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($selectedTh) && $selectedTh !== $activeTh && $selectedTh !== 'all'): ?>
        <div class="mt-3 px-3 py-2 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-lg flex items-center justify-between text-xs text-amber-800 dark:text-amber-300">
            <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm">inventory_2</span>
                <span>Anda sedang melihat <strong>Arsip Riwayat TP <?= esc($selectedTh) ?></strong> (bukan tahun pelajaran aktif).</span>
            </div>
            <a href="<?= base_url('admin/pindahan') ?>" class="font-bold underline hover:text-amber-900">Kembali ke TP Aktif (<?= esc($activeTh) ?>)</a>
        </div>
    <?php endif; ?>
</div>