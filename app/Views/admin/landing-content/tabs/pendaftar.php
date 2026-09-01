    <form id="form-pendaftar" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="pendaftar">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status Tampil Halaman Pendaftar Publik</label>
                <select name="content[is_visible]" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    <option value="1" <?= (isset($sections['pendaftar']['is_visible']['content_value']) && $sections['pendaftar']['is_visible']['content_value'] === '1') ? 'selected' : '' ?>>Tampilkan Menu & Halaman Pendaftar</option>
                    <option value="0" <?= (!isset($sections['pendaftar']['is_visible']['content_value']) || $sections['pendaftar']['is_visible']['content_value'] === '0') ? 'selected' : '' ?>>Sembunyikan</option>
                </select>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Pilih apakah halaman daftar pendaftar dapat diakses publik atau tidak.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Pengaturan Pendaftar
            </button>
        </div>
    </form>
