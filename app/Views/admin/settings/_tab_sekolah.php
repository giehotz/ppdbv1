<!-- Card 2: Identitas Sekolah -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Identitas Sekolah</h3>
    </div>
    <div class="p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
            <input type="text" name="nama_sekolah" value="<?= $web['nama_sekolah'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NSM</label>
                <input type="text" name="nsm" value="<?= $web['nsm'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                <input type="text" name="npsn" value="<?= $web['npsn'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Logo Sekolah</label>
            <div class="flex items-center space-x-4">
                <?php if ($web['logo_sekolah']): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" class="h-12 w-12 object-contain border p-1 rounded">
                <?php endif; ?>
                <input type="file" name="logo_sekolah" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
        </div>
    </div>
</div>

<!-- Card 3: Alamat & Kontak -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Alamat & Kontak</h3>
    </div>
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="alamat_sekolah" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"><?= $web['alamat_sekolah'] ?></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <input type="text" name="kecamatan" value="<?= $web['kecamatan'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" value="<?= $web['kabupaten'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="provinsi" value="<?= $web['provinsi'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="telepon" value="<?= $web['telepon'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="<?= $web['email'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="text" name="website" value="<?= $web['website'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
                <div class="pt-4 mt-4 border-t border-gray-200">
                    <h4 class="text-sm font-bold text-gray-900 mb-3"><i class="fab fa-whatsapp text-green-500"></i> Integrasi Grup WhatsApp Siswa</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link Grup WhatsApp</label>
                            <input type="url" name="link_grup_wa" placeholder="https://chat.whatsapp.com/..." value="<?= esc($web['link_grup_wa'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                            <p class="mt-1 text-xs text-gray-500">Link undangan grup WhatsApp untuk siswa baru.</p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="tampil_grup_wa" id="tampil_grup_wa" value="1" <?= (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1) ? 'checked' : '' ?> class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="tampil_grup_wa" class="ml-2 block text-sm text-gray-900">
                                Tampilkan Tombol Grup WhatsApp di Dashboard Siswa
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card 4: Kepala Sekolah -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Kepala Sekolah</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Sekolah</label>
            <input type="text" name="nama_kepala" value="<?= $web['nama_kepala'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">NIP Kepala Sekolah</label>
            <input type="text" name="nip_kepala" value="<?= $web['nip_kepala'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
        </div>
    </div>
</div>
