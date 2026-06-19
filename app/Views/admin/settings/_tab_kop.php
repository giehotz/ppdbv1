<h2 class="text-xl font-bold text-on-surface mb-6">Pengaturan Kop Surat / Dokumen</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Logo Kiri -->
    <div class="col-span-1 md:col-span-2">
        <label class="block text-sm font-semibold text-on-surface mb-2">Logo Kiri</label>
        <div class="flex items-center gap-4">
            <?php if (!empty($kop['logo_kiri'])) : ?>
                <img src="<?= base_url('uploads/kop/' . $kop['logo_kiri']) ?>" alt="Logo Kop" class="h-20 object-contain bg-surface-container rounded-lg p-2 border border-surface-variant">
            <?php else : ?>
                <div class="h-20 w-20 flex items-center justify-center bg-surface-container rounded-lg border border-surface-variant text-on-surface-variant text-xs text-center p-2">
                    Belum ada logo
                </div>
            <?php endif; ?>
            <div class="flex-1">
                <input type="file" name="logo_kiri" id="logo_kiri" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm" accept="image/png, image/jpeg, image/jpg">
                <p class="text-xs text-on-surface-variant mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
            </div>
        </div>
    </div>

    <!-- Kementerian Pusat -->
    <div class="col-span-1 md:col-span-2">
        <label for="kementerian_pusat" class="block text-sm font-semibold text-on-surface mb-2">Kementerian Pusat</label>
        <input type="text" name="kementerian_pusat" id="kementerian_pusat" value="<?= old('kementerian_pusat', $kop['kementerian_pusat'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors" placeholder="KEMENTERIAN AGAMA REPUBLIK INDONESIA">
        <p class="text-xs text-on-surface-variant mt-1">Ukuran font 12 pada cetakan.</p>
    </div>

    <!-- Kementerian Kabupaten -->
    <div class="col-span-1 md:col-span-2">
        <label for="kementerian_kabupaten" class="block text-sm font-semibold text-on-surface mb-2">Kementerian Kabupaten</label>
        <input type="text" name="kementerian_kabupaten" id="kementerian_kabupaten" value="<?= old('kementerian_kabupaten', $kop['kementerian_kabupaten'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors" placeholder="KANTOR KEMENTERIAN AGAMA KABUPATEN TANGGAMUS">
        <p class="text-xs text-on-surface-variant mt-1">Ukuran font 12 pada cetakan.</p>
    </div>

    <!-- Nama Madrasah -->
    <div class="col-span-1 md:col-span-2">
        <label for="nama_madrasah_kop" class="block text-sm font-semibold text-on-surface mb-2">Nama Madrasah / Sekolah</label>
        <input type="text" name="nama_madrasah_kop" id="nama_madrasah_kop" value="<?= old('nama_madrasah_kop', $kop['nama_madrasah'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors" placeholder="MADRASAH IBTIDAIYAH NEGERI 2 TANGGAMUS">
        <p class="text-xs text-on-surface-variant mt-1">Ukuran font 12 pada cetakan.</p>
    </div>

    <!-- Alamat Madrasah -->
    <div class="col-span-1">
        <label for="alamat_madrasah_kop" class="block text-sm font-semibold text-on-surface mb-2">Alamat Lengkap</label>
        <textarea name="alamat_madrasah_kop" id="alamat_madrasah_kop" rows="3" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors" placeholder="Jln. Lap. Ampera No. 109 Purwodadi Kec. Gisting Kab. Tanggamus (0729) 347578 35378"><?= old('alamat_madrasah_kop', $kop['alamat_madrasah'] ?? '') ?></textarea>
        <p class="text-xs text-on-surface-variant mt-1">Ukuran font 9 pada cetakan.</p>
    </div>

    <!-- Email Madrasah -->
    <div class="col-span-1">
        <label for="email_madrasah_kop" class="block text-sm font-semibold text-on-surface mb-2">Email</label>
        <input type="text" name="email_madrasah_kop" id="email_madrasah_kop" value="<?= old('email_madrasah_kop', $kop['email_madrasah'] ?? '') ?>" class="w-full px-4 py-3 rounded-xl bg-surface border border-surface-variant focus:ring-2 focus:ring-primary focus:border-primary transition-colors" placeholder="Email : minduatanggamus@gmail.com">
        <p class="text-xs text-on-surface-variant mt-1">Ukuran font 9 pada cetakan.</p>
    </div>
</div>
