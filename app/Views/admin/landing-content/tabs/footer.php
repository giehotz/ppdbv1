    <form id="form-footer" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="footer">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah di Footer</label>
                <input type="text" name="content[nama_sekolah]" value="<?= esc($sections['footer']['nama_sekolah']['content_value'] ?? '') ?>" placeholder="MIN 2 Tanggamus" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Copyright</label>
                <input type="text" name="content[copyright]" value="<?= esc($sections['footer']['copyright']['content_value'] ?? '') ?>" placeholder="Official Website <?= $app_alias ?? 'PPDB' ?>. All rights reserved." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fab fa-facebook-f mr-1 text-blue-600"></i> Facebook Link</label>
                    <input type="text" name="content[facebook_link]" value="<?= esc($sections['footer']['facebook_link']['content_value'] ?? '') ?>" placeholder="https://facebook.com/..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fab fa-instagram mr-1 text-pink-600"></i> Instagram Link</label>
                    <input type="text" name="content[instagram_link]" value="<?= esc($sections['footer']['instagram_link']['content_value'] ?? '') ?>" placeholder="https://instagram.com/..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fab fa-tiktok mr-1 text-black"></i> TikTok Link</label>
                    <input type="text" name="content[tiktok_link]" value="<?= esc($sections['footer']['tiktok_link']['content_value'] ?? '') ?>" placeholder="https://tiktok.com/@..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"><i class="fab fa-youtube mr-1 text-red-600"></i> YouTube Link</label>
                    <input type="text" name="content[youtube_link]" value="<?= esc($sections['footer']['youtube_link']['content_value'] ?? '') ?>" placeholder="https://youtube.com/..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Footer
            </button>
        </div>
    </form>
