    <form id="form-navbar" class="tab-content p-6" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="navbar">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah / Madrasah</label>
                <input type="text" name="content[nama_sekolah]" value="<?= esc($sections['navbar']['nama_sekolah']['content_value'] ?? '') ?>" placeholder="MIN 2 Tanggamus" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Navbar
            </button>
        </div>
    </form>
