    <form id="form-kontak" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="kontak">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Section</label>
                <input type="text" name="content[title]" value="<?= esc($sections['kontak']['title']['content_value'] ?? '') ?>" placeholder="Hubungi Kami" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Madrasah</label>
                <textarea name="content[alamat]" rows="2" placeholder="Jl. Raya No. 123, Kabupaten Tanggamus, Lampung" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"><?= esc($sections['kontak']['alamat']['content_value'] ?? '') ?></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Display (Nama & Nomor)</label>
                    <input type="text" name="content[whatsapp_nama]" value="<?= esc($sections['kontak']['whatsapp_nama']['content_value'] ?? '') ?>" placeholder="+62 812-3456-7890 (Bpk. Ahmad)" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WA (tanpa +, untuk link)</label>
                    <input type="text" name="content[whatsapp_number]" value="<?= esc($sections['kontak']['whatsapp_number']['content_value'] ?? '') ?>" placeholder="6281234567890" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Google Maps (Embed iframe)</label>
                <textarea name="content[google_maps]" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border font-mono text-sm"><?= esc($sections['kontak']['google_maps']['content_value'] ?? '') ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Buka Google Maps > Bagikan > Sematkan Peta, lalu salin HTML dan tempel di sini.</p>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Kontak
            </button>
        </div>
    </form>
