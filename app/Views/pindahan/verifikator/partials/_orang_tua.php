<!-- D. Data Orang Tua & Wali -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
            <span class="material-symbols-outlined text-lg">family_restroom</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">D. Data Orang Tua &amp; Wali</h3>
    </div>

    <div class="p-5 md:p-6 space-y-6 text-xs">
        <!-- Ayah -->
        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
            <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-base">man</span>
                <span>Data Ayah Kandung</span>
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div><span class="text-gray-400 block text-[10px] uppercase">Nama Ayah</span><span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_ayah'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Status</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['status_ayah'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">NIK Ayah</span><span class="font-mono text-gray-800 dark:text-gray-200"><?= esc($siswa['nik_ayah'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Pendidikan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pdd_ayah'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_ayah'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Penghasilan</span><span class="font-semibold text-emerald-600 dark:text-emerald-400"><?= esc($siswa['penghasilan_ayah'] ?? '' ?: '-') ?></span></div>
            </div>
        </div>

        <!-- Ibu -->
        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
            <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-pink-600 dark:text-pink-400">
                <span class="material-symbols-outlined text-base">woman</span>
                <span>Data Ibu Kandung</span>
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div><span class="text-gray-400 block text-[10px] uppercase">Nama Ibu</span><span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_ibu'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Status</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['status_ibu'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">NIK Ibu</span><span class="font-mono text-gray-800 dark:text-gray-200"><?= esc($siswa['nik_ibu'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Pendidikan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pdd_ibu'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_ibu'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Penghasilan</span><span class="font-semibold text-emerald-600 dark:text-emerald-400"><?= esc($siswa['penghasilan_ibu'] ?? '' ?: '-') ?></span></div>
            </div>
        </div>

        <!-- Wali -->
        <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
            <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-base">supervisor_account</span>
                <span>Data Wali (Opsional)</span>
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div><span class="text-gray-400 block text-[10px] uppercase">Nama Wali</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_wali'] ?? '' ?: '-') ?></span></div>
                <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_wali'] ?? '' ?: '-') ?></span></div>
            </div>
        </div>

        <!-- Kontak Darurat -->
        <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/60 dark:border-emerald-900/50 dark:bg-emerald-950/30 flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300 block mb-0.5">Kontak Darurat (No. WhatsApp Ortu/Wali)</span>
                <span class="font-mono text-base font-extrabold text-emerald-900 dark:text-emerald-200"><?= esc($siswa['no_hp_ortu'] ?? '' ?: '-') ?></span>
            </div>
            <span class="material-symbols-outlined text-2xl text-emerald-600 dark:text-emerald-400">call</span>
        </div>
    </div>
</div>