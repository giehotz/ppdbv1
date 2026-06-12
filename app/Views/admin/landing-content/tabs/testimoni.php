    <div id="form-testimoni" class="tab-content p-6 hidden">
        <div class="mb-6">
            <h4 class="text-lg font-bold mb-4">Daftar Testimoni</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (!empty($testimoni)): ?>
                    <?php foreach ($testimoni as $t): ?>
                        <div class="bg-white border rounded-lg p-4 shadow-sm relative group">
                            <div class="flex items-center mb-3">
                                <?php if ($t['avatar']): ?>
                                    <img src="<?= base_url($t['avatar']) ?>" class="w-10 h-10 rounded-full object-cover mr-3">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-3 text-gray-500"><i class="fas fa-user"></i></div>
                                <?php endif; ?>
                                <div>
                                    <h5 class="font-bold text-sm"><?= esc($t['nama']) ?></h5>
                                    <p class="text-xs text-gray-500"><?= esc($t['peran']) ?></p>
                                </div>
                            </div>
                            <div class="mb-2 text-yellow-400 text-xs">
                                <?php for ($i = 0; $i < $t['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
                            </div>
                            <p class="text-sm text-gray-600 italic">"<?= esc($t['isi']) ?>"</p>

                            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <button onclick='editTestimoni(<?= json_encode($t) ?>)' class="bg-gray-100 p-1 rounded text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></button>
                                <a href="<?= base_url('admin/landing-content/deleteTestimoni/' . $t['testimoni_id']) ?>" data-confirm="Yakin hapus?" class="bg-gray-100 p-1 rounded text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 col-span-3 text-center py-4">Belum ada data testimoni.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="border-t pt-6">
            <h4 class="text-lg font-bold mb-4" id="testimoni-form-title">Tambah Testimoni Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveTestimoni') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="testimoni_id" id="testimoni_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" id="testimoni_nama" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peran / Status</label>
                        <input type="text" name="peran" id="testimoni_peran" placeholder="Misal: Alumni 2023, Wali Murid" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select name="rating" id="testimoni_rating" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                        <option value="5">5 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="1">1 Bintang</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil (Avatar)</label>
                    <input type="file" name="avatar" id="testimoni_avatar" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm border p-2">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WebP. Maks 2MB. Rasio 1:1 disarankan.</p>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Testimoni</label>
                    <textarea name="isi" id="testimoni_isi" rows="3" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="testimoni_is_active" value="1" checked class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <button type="button" onclick="resetTestimoniForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition duration-200">
                        Batal / Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
