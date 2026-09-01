    <div id="form-fitur" class="tab-content p-6 hidden">
        <!-- Data Table -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                <div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white">Daftar Keunggulan</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola keunggulan sekolah yang ditampilkan di Landing Page</p>
                </div>
            </div>
            <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Ikon</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Judul</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Deskripsi</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Urutan</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Aktif</th>
                            <th class="py-3 px-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        <?php if (!empty($fitur)): ?>
                            <?php foreach ($fitur as $f): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="py-3 px-4 text-sm"><i class="<?= $f['ikon'] ?> text-brand-500"></i></td>
                                    <td class="py-3 px-4 text-sm font-medium text-gray-900 dark:text-white"><?= esc($f['judul']) ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-400"><?= esc($f['deskripsi']) ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-300"><?= $f['urutan'] ?></td>
                                    <td class="py-3 px-4 text-sm">
                                        <?php if ($f['is_active']): ?>
                                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Ya</span>
                                        <?php else: ?>
                                            <span class="inline-flex rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">Tidak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-right text-sm">
                                        <button onclick='editFitur(<?= json_encode($f) ?>)' class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/15 transition-colors mr-1" title="Edit"><i class="fas fa-edit text-xs"></i></button>
                                        <form method="post" action="<?= base_url('admin/landing-content/deleteFitur/' . $f['fitur_id']) ?>" data-confirm="Yakin hapus?" style="display:inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-500/15 transition-colors" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center">
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-folder-open text-2xl mb-2"></i>
                                        <p class="text-sm">Belum ada data keunggulan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Add/Edit -->
        <div class="rounded-2xl border border-gray-200 p-6 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-5 pb-3 border-b border-gray-200 dark:border-gray-700" id="fitur-form-title">Tambah Keunggulan Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveFitur') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="fitur_id" id="fitur_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                        <input type="text" name="judul" id="fitur_judul" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Urutan</label>
                        <input type="number" name="urutan" id="fitur_urutan" value="0" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Ikon (Font Awesome Class)</label>
                    <div class="flex gap-2">
                        <input type="text" name="ikon" id="fitur_ikon" placeholder="fas fa-star" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <a href="https://fontawesome.com/v5/search?m=free" target="_blank" class="inline-flex items-center justify-center px-3 py-2.5 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors" title="Cari Ikon"><i class="fas fa-search"></i></a>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Contoh: <code class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">fas fa-book</code>, <code class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">fas fa-users</code>, <code class="bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-xs">fas fa-mosque</code></p>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Singkat</label>
                    <textarea name="deskripsi" id="fitur_deskripsi" rows="2" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="fitur_is_active" value="1" checked class="rounded border-gray-300 text-brand-500 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-500/20 dark:border-gray-600 dark:bg-gray-800">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="resetFiturForm()" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-5 rounded-xl border border-gray-200 shadow-theme-xs transition-all duration-200 text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700">
                        Batal / Reset
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
