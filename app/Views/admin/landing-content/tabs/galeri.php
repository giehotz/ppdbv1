    <div id="form-galeri" class="tab-content p-6 hidden">
        <!-- Gallery Grid -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                <div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white">Daftar Galeri</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola foto galeri Landing Page</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <?php if (!empty($galeri)): ?>
                    <?php foreach ($galeri as $g): ?>
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden bg-white dark:bg-white/[0.03] shadow-theme-xs hover:shadow-theme-md transition-all relative group">
                            <img src="<?= base_url($g['gambar']) ?>" class="w-full h-32 object-cover">
                            <div class="p-3">
                                <h5 class="font-bold text-sm text-gray-900 dark:text-white truncate"><?= esc($g['judul']) ?></h5>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5"><?= esc($g['deskripsi']) ?></p>
                            </div>
                            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <button onclick='editGaleri(<?= json_encode($g) ?>)' class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-theme-xs text-brand-500 hover:text-brand-600 transition-colors" title="Edit"><i class="fas fa-edit text-xs"></i></button>
                                <form method="post" action="<?= base_url('admin/landing-content/deleteGaleri/' . $g['galeri_id']) ?>" data-confirm="Yakin hapus?" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-theme-xs text-red-500 hover:text-red-600 transition-colors" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                                </form>
                            </div>
                            <?php if (!$g['is_active']): ?>
                                <div class="absolute top-2 left-2 inline-flex rounded-full bg-red-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-theme-xs">Non-Aktif</div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-4 py-8 text-center">
                        <div class="text-gray-400 dark:text-gray-500">
                            <i class="fas fa-images text-2xl mb-2"></i>
                            <p class="text-sm">Belum ada data galeri.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Add/Edit -->
        <div class="rounded-2xl border border-gray-200 p-6 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-5 pb-3 border-b border-gray-200 dark:border-gray-700" id="galeri-form-title">Tambah Galeri Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveGaleri') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="galeri_id" id="galeri_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Foto</label>
                        <input type="text" name="judul" id="galeri_judul" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Urutan</label>
                        <input type="number" name="urutan" id="galeri_urutan" value="0" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Gambar</label>
                    <input type="file" name="gambar" id="galeri_gambar" accept="image/*" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm shadow-theme-xs file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Format: JPG, PNG, WebP. Maks 2MB.</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1 hidden" id="galeri_gambar_note">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="galeri_deskripsi" rows="2" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="galeri_is_active" value="1" checked class="rounded border-gray-300 text-brand-500 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-500/20 dark:border-gray-600 dark:bg-gray-800">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="resetGaleriForm()" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-5 rounded-xl border border-gray-200 shadow-theme-xs transition-all duration-200 text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700">
                        Batal / Reset
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
