    <div id="form-galeri" class="tab-content p-6 hidden">
        <div class="mb-6">
            <h4 class="text-lg font-bold mb-4">Daftar Galeri</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php if (!empty($galeri)): ?>
                    <?php foreach ($galeri as $g): ?>
                        <div class="border rounded-lg overflow-hidden bg-white shadow-sm hover:shadow-md transition relative group">
                            <img src="<?= base_url($g['gambar']) ?>" class="w-full h-32 object-cover">
                            <div class="p-3">
                                <h5 class="font-bold text-sm truncate"><?= esc($g['judul']) ?></h5>
                                <p class="text-xs text-gray-500 truncate"><?= esc($g['deskripsi']) ?></p>
                            </div>
                            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <button onclick='editGaleri(<?= json_encode($g) ?>)' class="bg-white p-1 rounded shadow text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                                <form method="post" action="<?= base_url('admin/landing-content/deleteGaleri/' . $g['galeri_id']) ?>" data-confirm="Yakin hapus?" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-white p-1 rounded shadow text-red-600 hover:text-red-800" style="border:none;cursor:pointer"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <?php if (!$g['is_active']): ?>
                                <div class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">Non-Aktif</div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 col-span-4 text-center py-4">Belum ada data galeri.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border-t pt-6">
            <h4 class="text-lg font-bold mb-4" id="galeri-form-title">Tambah Galeri Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveGaleri') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="galeri_id" id="galeri_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Foto</label>
                        <input type="text" name="judul" id="galeri_judul" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" id="galeri_urutan" value="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar</label>
                    <input type="file" name="gambar" id="galeri_gambar" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm border p-2">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WebP. Maks 2MB.</p>
                    <p class="text-xs text-orange-500 mt-1 hidden" id="galeri_gambar_note">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="galeri_deskripsi" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="galeri_is_active" value="1" checked class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <button type="button" onclick="resetGaleriForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition duration-200">
                        Batal / Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
