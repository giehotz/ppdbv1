    <form id="form-footer" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="footer">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Sekolah di Footer</label>
                <input type="text" name="content[nama_sekolah]" value="<?= esc($sections['footer']['nama_sekolah']['content_value'] ?? '') ?>" placeholder="MIN 2 Tanggamus" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Copyright</label>
                <input type="text" name="content[copyright]" value="<?= esc($sections['footer']['copyright']['content_value'] ?? '') ?>" placeholder="Official Website <?= $app_alias ?? 'PPDB' ?>. All rights reserved." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fab fa-facebook-f mr-1.5 text-blue-600"></i> Facebook Link</label>
                    <input type="text" name="content[facebook_link]" value="<?= esc($sections['footer']['facebook_link']['content_value'] ?? '') ?>" placeholder="https://facebook.com/..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fab fa-instagram mr-1.5 text-pink-600"></i> Instagram Link</label>
                    <input type="text" name="content[instagram_link]" value="<?= esc($sections['footer']['instagram_link']['content_value'] ?? '') ?>" placeholder="https://instagram.com/..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fab fa-tiktok mr-1.5 text-gray-800 dark:text-gray-300"></i> TikTok Link</label>
                    <input type="text" name="content[tiktok_link]" value="<?= esc($sections['footer']['tiktok_link']['content_value'] ?? '') ?>" placeholder="https://tiktok.com/@..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"><i class="fab fa-youtube mr-1.5 text-red-600"></i> YouTube Link</label>
                    <input type="text" name="content[youtube_link]" value="<?= esc($sections['footer']['youtube_link']['content_value'] ?? '') ?>" placeholder="https://youtube.com/..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Footer
            </button>
        </div>
    </form>
