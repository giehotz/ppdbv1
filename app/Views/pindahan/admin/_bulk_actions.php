<!-- Floating Bulk Action Bar -->
<div id="bulkActionBar" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 hidden transition-all duration-300 transform translate-y-10 opacity-0">
    <div class="flex items-center gap-3 bg-gray-900/95 dark:bg-gray-800/95 backdrop-blur-md text-white px-5 py-3 rounded-2xl shadow-2xl border border-gray-700/50">
        <div class="flex items-center gap-2 pr-3 border-r border-gray-700">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white" id="selectedCountBadge">0</span>
            <span class="text-xs font-semibold text-gray-200 whitespace-nowrap">Siswa Terpilih</span>
        </div>

        <div class="flex items-center gap-2">
            <!-- Verifikasi Massal -->
            <button type="button" onclick="openBulkVerifyModal()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                <i class="fas fa-check-double text-xs"></i>
                <span>Verifikasi Massal</span>
            </button>

            <!-- Hapus Massal -->
            <button type="button" onclick="openBulkDeleteModal()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                <i class="fas fa-trash-alt text-xs"></i>
                <span>Hapus Terpilih</span>
            </button>

            <!-- Deselect All -->
            <button type="button" onclick="clearSelection()"
                    class="p-1.5 rounded-xl text-gray-400 hover:text-white hover:bg-gray-800 transition-colors ml-1"
                    title="Batalkan Pilihan">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
</div>