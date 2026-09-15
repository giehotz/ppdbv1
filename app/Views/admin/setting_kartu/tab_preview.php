<!-- Tab: Preview Kartu -->
<div id="preview" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Pratinjau Hasil Cetak Kartu</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Lihat hasil rendering kartu dengan data dan layout saat ini</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="reloadCardPreview()" class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold text-xs py-2 px-3.5 shadow-theme-xs transition active:scale-[0.97]" title="Muat ulang pratinjau kartu">
                    <span class="material-symbols-outlined text-sm">refresh</span>
                    <span>Muat Ulang</span>
                </button>
                <a href="<?= base_url('admin/setting-kartu/preview') ?>" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold text-xs py-2 px-4 shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                    <span>Buka di Tab Baru</span>
                </a>
            </div>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 w-full overflow-hidden relative shadow-inner" style="height: 750px;">
            <iframe id="previewCardIframe" src="<?= base_url('admin/setting-kartu/preview') ?>" class="w-full h-full border-0 absolute inset-0"></iframe>
        </div>
    </div>
</div>
