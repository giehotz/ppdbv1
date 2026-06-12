    <form id="form-hero" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="hero">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Headline</label>
                <input type="text" name="content[headline]" value="<?= esc($sections['hero']['headline']['content_value'] ?? '') ?>" placeholder="Penerimaan Peserta Didik Baru (<?= $app_alias ?? 'PPDB' ?>) Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subheadline</label>
                <textarea name="content[subheadline]" rows="3" placeholder="Wujudkan generasi cerdas..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"><?= esc($sections['hero']['subheadline']['content_value'] ?? '') ?></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tombol CTA - Teks</label>
                    <input type="text" name="content[cta_text]" value="<?= esc($sections['hero']['cta_text']['content_value'] ?? '') ?>" placeholder="Daftar Sekarang" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tombol CTA - Link</label>
                    <input type="text" name="content[cta_link]" value="<?= esc($sections['hero']['cta_link']['content_value'] ?? '') ?>" placeholder="<?= base_url('auth/register') ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>

            <!-- Background Image Upload -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-image mr-1"></i> Gambar Background Hero (Parallax)</label>
                <?php $currentHeroBg = $sections['hero']['background_image']['content_value'] ?? ''; ?>
                <div id="hero-preview" class="mb-3 <?= empty($currentHeroBg) ? 'hidden' : '' ?>">
                    <div class="relative inline-block">
                        <img id="hero-preview-img" src="<?= !empty($currentHeroBg) ? base_url($currentHeroBg) : '' ?>" class="max-h-48 rounded-lg shadow border">
                        <button type="button" onclick="removeHeroImage()" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center hover:bg-red-700 transition shadow" title="Hapus gambar">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <div id="hero-upload-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition cursor-pointer <?= !empty($currentHeroBg) ? 'hidden' : '' ?>" onclick="document.getElementById('hero-file-input').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP (Maks. 2MB, rekomendasi 1920x800px)</p>
                </div>
                <input type="file" id="hero-file-input" accept="image/*" class="hidden" onchange="uploadHeroImage(this)">
                <input type="hidden" name="content[background_image]" id="hero-bg-value" value="<?= $currentHeroBg ?>">
                <div id="hero-upload-progress" class="hidden mt-2">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full transition-all" style="width: 0%" id="hero-progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Hero
            </button>
        </div>
    </form>
