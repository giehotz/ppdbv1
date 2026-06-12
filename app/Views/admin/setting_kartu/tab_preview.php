        <!-- Tab: Preview Kartu -->
        <div id="preview" class="tab-content hidden h-[800px]">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Pratinjau Hasil Cetak Kartu</h3>
                <a href="<?= base_url('admin/setting-kartu/preview') ?>" target="_blank" class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded transition flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                </a>
            </div>

            <div class="bg-gray-200 border border-gray-300 rounded-lg w-full h-full overflow-hidden relative">
                <iframe src="<?= base_url('admin/setting-kartu/preview') ?>" class="w-full h-full border-0 absolute inset-0"></iframe>
            </div>
        </div>
