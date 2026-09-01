    <form id="form-hero" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="hero">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Headline <span class="text-xs text-gray-400 dark:text-gray-500 font-normal">(mendukung HTML & CSS)</span></label>
                <input type="text" name="content[headline]" value="<?= $sections['hero']['headline']['content_value'] ?? '' ?>" placeholder="Penerimaan Peserta Didik Baru (<?= $app_alias ?? 'PPDB' ?>) Tahun Pelajaran <?= date('Y') ?>/<?= date('Y') + 1 ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subheadline <span class="text-xs text-gray-400 dark:text-gray-500 font-normal">(mendukung HTML & CSS)</span></label>
                <textarea name="content[subheadline]" rows="3" placeholder="Wujudkan generasi cerdas..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"><?= $sections['hero']['subheadline']['content_value'] ?? '' ?></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol CTA - Teks</label>
                    <input type="text" name="content[cta_text]" value="<?= esc($sections['hero']['cta_text']['content_value'] ?? '') ?>" placeholder="Daftar Sekarang" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tombol CTA - Link</label>
                    <input type="text" name="content[cta_link]" value="<?= esc($sections['hero']['cta_link']['content_value'] ?? '') ?>" placeholder="<?= base_url('auth/register') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>

            <!-- Background Image Upload -->
            <div class="rounded-2xl border border-gray-200 p-5 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
                <label class="mb-3 block text-sm font-semibold text-gray-700 dark:text-gray-300"><i class="fas fa-image mr-1.5 text-brand-500"></i> Gambar Background Hero (Parallax)</label>
                <?php $currentHeroBg = $sections['hero']['background_image']['content_value'] ?? ''; ?>
                <div id="hero-preview" class="mb-3 <?= empty($currentHeroBg) ? 'hidden' : '' ?>">
                    <div class="relative inline-block">
                        <img id="hero-preview-img" src="<?= !empty($currentHeroBg) ? base_url($currentHeroBg) : '' ?>" class="max-h-48 rounded-xl shadow-theme-sm border border-gray-200 dark:border-gray-700">
                        <button type="button" onclick="removeHeroImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center transition shadow-theme-xs" title="Hapus gambar">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
                <div id="hero-upload-area" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-brand-500 transition cursor-pointer <?= !empty($currentHeroBg) ? 'hidden' : '' ?>" onclick="document.getElementById('hero-file-input').click()">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 dark:text-gray-500 mb-2"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Klik untuk upload gambar</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">JPG, PNG, WebP (Maks. 2MB, rekomendasi 1920x800px)</p>
                </div>
                <input type="file" id="hero-file-input" accept="image/*" class="hidden" onchange="uploadHeroImage(this)">
                <input type="hidden" name="content[background_image]" id="hero-bg-value" value="<?= $currentHeroBg ?>">
                <div id="hero-upload-progress" class="hidden mt-3">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-brand-500 h-2 rounded-full transition-all" style="width: 0%" id="hero-progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Hero
            </button>
        </div>
    </form>
