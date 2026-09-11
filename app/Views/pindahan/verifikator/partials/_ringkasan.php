<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center gap-2.5 mb-4">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
            <span class="material-symbols-outlined text-lg">swap_horiz</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Ringkasan Perpindahan</h3>
    </div>

    <div class="space-y-3.5 text-xs">
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Jalur Pendaftaran</span>
            <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 text-xs mt-0.5">
                Pindahan
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Jenjang Asal</span>
            <span class="font-bold text-gray-900 dark:text-white block">
                <?= esc($siswa['jenjang_sekolah_asal'] ?? '-') ?>
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Grup Asal</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['grup_jenjang_asal'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Diterima di Kelas</span>
            <span class="inline-flex rounded-md bg-emerald-50 px-2 py-0.5 font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 text-xs mt-0.5">
                <?= esc($siswa['kelas_diterima'] ?? '' ?: '-') ?>
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Rata-rata Nilai Rapor</span>
            <span class="text-gray-800 dark:text-gray-200 block font-bold"><?= !empty($siswa['rata_rata_nilai']) ? number_format((float) $siswa['rata_rata_nilai'], 2) : '-' ?></span>
        </div>
    </div>
</div>