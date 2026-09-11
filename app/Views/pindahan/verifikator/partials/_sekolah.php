<!-- C. Sekolah Asal & Alasan Pindah -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
            <span class="material-symbols-outlined text-lg">swap_horiz</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">C. Sekolah Asal dan Alasan Pindah</h3>
    </div>

    <div class="p-5 md:p-6 grid grid-cols-1 gap-5 text-xs">
        <!-- Sekolah Asal -->
        <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900/50 dark:bg-blue-950/30">
            <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-base">school</span>
                <span>Sekolah Asal</span>
            </h4>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Nama Sekolah</span>
                    <span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_sekolah_asal'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">NPSN</span>
                    <span class="font-mono text-gray-800 dark:text-gray-200"><?= esc($siswa['npsn_sekolah_asal'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Jenjang</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-200"><?= esc($siswa['jenjang_sekolah_asal'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Kelas Terakhir</span>
                    <span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['kelas_sekolah_asal'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Tahun Masuk - Keluar</span>
                    <span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['tahun_masuk_sekolah_asal'] ?? '-') ?> - <?= esc($siswa['tahun_keluar_sekolah_asal'] ?? '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Alamat Sekolah Asal</span>
                    <span class="text-gray-800 dark:text-gray-200 leading-relaxed block"><?= esc($siswa['alamat_sekolah_asal'] ?? '' ?: '-') ?></span>
                </div>
            </div>
        </div>

        <!-- Alasan Pindah -->
        <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 dark:border-emerald-900/50 dark:bg-emerald-950/30">
            <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-base">flag</span>
                <span>Alasan Pindah</span>
            </h4>
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Kategori</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-200"><?= esc($siswa['alasan_pindah_kategori'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 block text-[10px] uppercase">Keterangan</span>
                    <span class="text-gray-800 dark:text-gray-200 leading-relaxed block"><?= esc($siswa['alasan_pindah'] ?? '' ?: '-') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>