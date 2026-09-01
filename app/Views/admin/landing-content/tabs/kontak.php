    <form id="form-kontak" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="kontak">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Section</label>
                <input type="text" name="content[title]" value="<?= esc($sections['kontak']['title']['content_value'] ?? '') ?>" placeholder="Hubungi Kami" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Madrasah</label>
                <textarea name="content[alamat]" rows="2" placeholder="Jl. Raya No. 123, Kabupaten Tanggamus, Lampung" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"><?= esc($sections['kontak']['alamat']['content_value'] ?? '') ?></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp Display (Nama & Nomor)</label>
                    <input type="text" name="content[whatsapp_nama]" value="<?= esc($sections['kontak']['whatsapp_nama']['content_value'] ?? '') ?>" placeholder="+62 812-3456-7890 (Bpk. Ahmad)" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor WA (tanpa +, untuk link)</label>
                    <input type="text" name="content[whatsapp_number]" value="<?= esc($sections['kontak']['whatsapp_number']['content_value'] ?? '') ?>" placeholder="6281234567890" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Google Maps (Embed iframe)</label>
                <textarea name="content[google_maps]" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white font-mono"><?= esc($sections['kontak']['google_maps']['content_value'] ?? '') ?></textarea>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Buka Google Maps > Bagikan > Sematkan Peta, lalu salin HTML dan tempel di sini.</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Kontak
            </button>
        </div>
    </form>
