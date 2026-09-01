    <form id="form-syarat" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="syarat">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Section</label>
                <input type="text" name="content[title]" value="<?= esc($sections['syarat']['title']['content_value'] ?? '') ?>" placeholder="Persyaratan Pendaftaran" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <div class="rounded-2xl border border-gray-200 p-5 dark:border-gray-700">
                <h4 class="font-semibold mb-4 text-gray-800 dark:text-gray-200 flex items-center gap-1.5"><i class="fas fa-list-ol text-brand-500"></i> Daftar Persyaratan</h4>
                <div class="space-y-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="flex items-center gap-3">
                            <span class="bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"><?= $i ?></span>
                            <input type="text" name="content[item<?= $i ?>]" value="<?= esc($sections['syarat']["item{$i}"]['content_value'] ?? '') ?>" placeholder="Persyaratan ke-<?= $i ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        </div>
                    <?php endfor; ?>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-3"><i class="fas fa-info-circle mr-1"></i>Kosongkan field jika tidak ingin ditampilkan</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Persyaratan
            </button>
        </div>
    </form>
