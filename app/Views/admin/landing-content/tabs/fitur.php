    <div id="form-fitur" class="tab-content p-6 hidden">
        <div class="mb-6">
            <h4 class="text-lg font-bold mb-4">Daftar Keunggulan</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Ikon</th>
                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Deskripsi</th>
                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Urutan</th>
                            <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Aktif</th>
                            <th class="py-2 px-4 border-b text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($fitur)): ?>
                            <?php foreach ($fitur as $f): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b text-sm"><i class="<?= $f['ikon'] ?> text-green-600"></i></td>
                                    <td class="py-2 px-4 border-b text-sm font-medium"><?= esc($f['judul']) ?></td>
                                    <td class="py-2 px-4 border-b text-sm text-gray-500"><?= esc($f['deskripsi']) ?></td>
                                    <td class="py-2 px-4 border-b text-sm"><?= $f['urutan'] ?></td>
                                    <td class="py-2 px-4 border-b text-sm">
                                        <?php if ($f['is_active']): ?>
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Ya</span>
                                        <?php else: ?>
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Tidak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b text-right text-sm">
                                        <button onclick='editFitur(<?= json_encode($f) ?>)' class="text-blue-600 hover:text-blue-900 mr-2"><i class="fas fa-edit"></i></button>
                                        <a href="<?= base_url('admin/landing-content/deleteFitur/' . $f['fitur_id']) ?>" data-confirm="Yakin hapus?" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada data keunggulan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="border-t pt-6">
            <h4 class="text-lg font-bold mb-4" id="fitur-form-title">Tambah Keunggulan Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveFitur') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="fitur_id" id="fitur_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="judul" id="fitur_judul" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="urutan" id="fitur_urutan" value="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ikon (Font Awesome Class)</label>
                    <div class="flex gap-2">
                        <input type="text" name="ikon" id="fitur_ikon" placeholder="fas fa-star" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                        <a href="https://fontawesome.com/v5/search?m=free" target="_blank" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded flex items-center" title="Cari Ikon"><i class="fas fa-search"></i></a>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Contoh: <code>fas fa-book</code>, <code>fas fa-users</code>, <code>fas fa-mosque</code></p>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="fitur_deskripsi" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="fitur_is_active" value="1" checked class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex gap-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <button type="button" onclick="resetFiturForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition duration-200">
                        Batal / Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
