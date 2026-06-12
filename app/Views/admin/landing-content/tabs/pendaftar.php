    <form id="form-pendaftar" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="pendaftar">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Tampil Halaman Pendaftar Publik</label>
                <select name="content[is_visible]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <option value="1" <?= (isset($sections['pendaftar']['is_visible']['content_value']) && $sections['pendaftar']['is_visible']['content_value'] == '1') ? 'selected' : '' ?>>Tampilkan Menu & Halaman Pendaftar</option>
                    <option value="0" <?= (!isset($sections['pendaftar']['is_visible']['content_value']) || $sections['pendaftar']['is_visible']['content_value'] == '0') ? 'selected' : '' ?>>Sembunyikan</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih apakah halaman daftar pendaftar dapat diakses publik atau tidak.</p>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Pengaturan Pendaftar
            </button>
        </div>
    </form>
