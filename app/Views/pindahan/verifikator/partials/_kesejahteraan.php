<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center gap-2.5 mb-4">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
            <span class="material-symbols-outlined text-lg">card_membership</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Bantuan Kesejahteraan</h3>
    </div>

    <div class="space-y-3 text-xs">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
            <span class="text-gray-500 dark:text-gray-400 font-semibold">No. KKS</span>
            <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_kks'] ?? '' ?: '-') ?></span>
        </div>
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
            <span class="text-gray-500 dark:text-gray-400 font-semibold">No. PKH</span>
            <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_pkh'] ?? '' ?: '-') ?></span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-gray-500 dark:text-gray-400 font-semibold">No. KIP</span>
            <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_kip'] ?? '' ?: '-') ?></span>
        </div>
    </div>
</div>