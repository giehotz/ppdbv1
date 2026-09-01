<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">description</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengaturan Kop Surat / Dokumen</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Logo Kiri -->
            <div class="col-span-1 md:col-span-2">
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Logo Kiri</label>
                <div class="flex items-center gap-4">
                    <?php if (!empty($kop['logo_kiri'])) : ?>
                        <img src="<?= base_url('uploads/kop/' . $kop['logo_kiri']) ?>" alt="Logo Kop" class="h-20 object-contain bg-gray-50 dark:bg-gray-800 rounded-xl p-2 border border-gray-200 dark:border-gray-700">
                    <?php else : ?>
                        <div class="h-20 w-20 flex items-center justify-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 text-xs text-center p-2">
                            Belum ada logo
                        </div>
                    <?php endif; ?>
                    <div class="flex-1">
                        <input type="file" name="logo_kiri" id="logo_kiri" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:file:bg-brand-500/15 dark:file:text-brand-400" accept="image/png, image/jpeg, image/jpg">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                    </div>
                </div>
            </div>

            <!-- Kementerian Pusat -->
            <div class="col-span-1 md:col-span-2">
                <label for="kementerian_pusat" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kementerian Pusat</label>
                <input type="text" name="kementerian_pusat" id="kementerian_pusat" value="<?= old('kementerian_pusat', $kop['kementerian_pusat'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="KEMENTERIAN AGAMA REPUBLIK INDONESIA">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Ukuran font 12 pada cetakan.</p>
            </div>

            <!-- Kementerian Kabupaten -->
            <div class="col-span-1 md:col-span-2">
                <label for="kementerian_kabupaten" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kementerian Kabupaten</label>
                <input type="text" name="kementerian_kabupaten" id="kementerian_kabupaten" value="<?= old('kementerian_kabupaten', $kop['kementerian_kabupaten'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="KANTOR KEMENTERIAN AGAMA KABUPATEN TANGGAMUS">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Ukuran font 12 pada cetakan.</p>
            </div>

            <!-- Nama Madrasah -->
            <div class="col-span-1 md:col-span-2">
                <label for="nama_madrasah_kop" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Nama Madrasah / Sekolah</label>
                <input type="text" name="nama_madrasah_kop" id="nama_madrasah_kop" value="<?= old('nama_madrasah_kop', $kop['nama_madrasah'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="MADRASAH IBTIDAIYAH NEGERI 2 TANGGAMUS">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Ukuran font 12 pada cetakan.</p>
            </div>

            <!-- Alamat Madrasah -->
            <div class="col-span-1">
                <label for="alamat_madrasah_kop" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Alamat Lengkap</label>
                <textarea name="alamat_madrasah_kop" id="alamat_madrasah_kop" rows="3" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="Jln. Lap. Ampera No. 109 Purwodadi Kec. Gisting Kab. Tanggamus (0729) 347578 35378"><?= old('alamat_madrasah_kop', $kop['alamat_madrasah'] ?? '') ?></textarea>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Ukuran font 9 pada cetakan.</p>
            </div>

            <!-- Email Madrasah -->
            <div class="col-span-1">
                <label for="email_madrasah_kop" class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Email</label>
                <input type="text" name="email_madrasah_kop" id="email_madrasah_kop" value="<?= old('email_madrasah_kop', $kop['email_madrasah'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="Email : minduatanggamus@gmail.com">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Ukuran font 9 pada cetakan.</p>
            </div>
        </div>
    </div>
</div>
