    <form id="form-syarat" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="syarat">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Section</label>
                <input type="text" name="content[title]" value="<?= esc($sections['syarat']['title']['content_value'] ?? '') ?>" placeholder="Persyaratan Pendaftaran" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>

            <div class="border rounded-lg p-4">
                <h4 class="font-semibold mb-3"><i class="fas fa-list-ol mr-1"></i> Daftar Persyaratan</h4>
                <div class="space-y-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="flex items-center gap-3">
                            <span class="bg-green-100 text-green-700 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"><?= $i ?></span>
                            <input type="text" name="content[item<?= $i ?>]" value="<?= esc($sections['syarat']["item{$i}"]['content_value'] ?? '') ?>" placeholder="Persyaratan ke-<?= $i ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        </div>
                    <?php endfor; ?>
                </div>
                <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle mr-1"></i>Kosongkan field jika tidak ingin ditampilkan</p>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Persyaratan
            </button>
        </div>
    </form>
