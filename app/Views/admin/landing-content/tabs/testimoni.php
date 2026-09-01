    <div id="form-testimoni" class="tab-content p-6 hidden">
        <!-- Testimoni Cards -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                <div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white">Daftar Testimoni</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola testimoni yang ditampilkan di Landing Page</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (!empty($testimoni)): ?>
                    <?php foreach ($testimoni as $t): ?>
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-5 shadow-theme-xs relative group transition-all hover:shadow-theme-md">
                            <div class="flex items-center mb-3">
                                <?php if ($t['avatar']): ?>
                                    <img src="<?= base_url($t['avatar']) ?>" class="w-10 h-10 rounded-full object-cover mr-3 border-2 border-gray-100 dark:border-gray-700">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center mr-3 text-brand-500 dark:text-brand-400"><i class="fas fa-user text-sm"></i></div>
                                <?php endif; ?>
                                <div>
                                    <h5 class="font-bold text-sm text-gray-900 dark:text-white"><?= esc($t['nama']) ?></h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?= esc($t['peran']) ?></p>
                                </div>
                            </div>
                            <div class="mb-2 text-amber-400 text-xs">
                                <?php for ($i = 0; $i < $t['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 italic">"<?= esc($t['isi']) ?>"</p>

                            <div class="absolute top-3 right-3 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                                <button onclick='editTestimoni(<?= json_encode($t) ?>)' class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-theme-xs text-brand-500 hover:text-brand-600 border border-gray-100 dark:border-gray-700 transition-colors" title="Edit"><i class="fas fa-edit text-xs"></i></button>
                                <form method="post" action="<?= base_url('admin/landing-content/deleteTestimoni/' . $t['testimoni_id']) ?>" data-confirm="Yakin hapus?" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="bg-white dark:bg-gray-800 p-1.5 rounded-lg shadow-theme-xs text-red-500 hover:text-red-600 border border-gray-100 dark:border-gray-700 transition-colors" title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 py-8 text-center">
                        <div class="text-gray-400 dark:text-gray-500">
                            <i class="fas fa-comments text-2xl mb-2"></i>
                            <p class="text-sm">Belum ada data testimoni.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Add/Edit -->
        <div class="rounded-2xl border border-gray-200 p-6 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-5 pb-3 border-b border-gray-200 dark:border-gray-700" id="testimoni-form-title">Tambah Testimoni Baru</h4>
            <form action="<?= base_url('admin/landing-content/saveTestimoni') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="testimoni_id" id="testimoni_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                        <input type="text" name="nama" id="testimoni_nama" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Peran / Status</label>
                        <input type="text" name="peran" id="testimoni_peran" placeholder="Misal: Alumni 2023, Wali Murid" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                    <select name="rating" id="testimoni_rating" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <option value="5">5 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="3">3 Bintang</option>
                        <option value="2">2 Bintang</option>
                        <option value="1">1 Bintang</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Profil (Avatar)</label>
                    <input type="file" name="avatar" id="testimoni_avatar" accept="image/*" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm shadow-theme-xs file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Format: JPG, PNG, WebP. Maks 2MB. Rasio 1:1 disarankan.</p>
                </div>
                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Testimoni</label>
                    <textarea name="isi" id="testimoni_isi" rows="3" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"></textarea>
                </div>
                <div class="mt-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="testimoni_is_active" value="1" checked class="rounded border-gray-300 text-brand-500 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-500/20 dark:border-gray-600 dark:bg-gray-800">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tampilkan di Landing Page</span>
                    </label>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="resetTestimoniForm()" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-5 rounded-xl border border-gray-200 shadow-theme-xs transition-all duration-200 text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700">
                        Batal / Reset
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
