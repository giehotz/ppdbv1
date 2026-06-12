        <!-- Tab: Instansi -->
        <div id="instansi" class="tab-content block">
            <div class="flex justify-between items-center mb-4 pb-2 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Identitas Instansi (Kop Kartu)</h3>
                <a href="<?= base_url('admin/settings') ?>" class="text-sm bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-3 rounded transition flex items-center gap-1">
                    <i class="fas fa-edit"></i> Ubah di Identitas Sekolah
                </a>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i> Data kop Instansi / Sekolah kini terintegrasi langsung dengan menu <strong>Identitas Sekolah</strong> utama untuk mencegah input berulang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-lg border border-gray-200">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Instansi / Sekolah</label>
                    <p class="text-gray-900 font-medium text-lg border-b border-gray-200 pb-1"><?= esc($instansi['nama_sekolah'] ?? '-') ?></p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</label>
                    <p class="text-gray-900 border-b border-gray-200 pb-1">
                        <?= esc($instansi['alamat_sekolah'] ?? '-') ?><br>
                        Kec. <?= esc($instansi['kecamatan'] ?? '-') ?>, Kab. <?= esc($instansi['kabupaten'] ?? '-') ?>, <?= esc($instansi['provinsi'] ?? '-') ?>
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</label>
                    <p class="text-gray-900 border-b border-gray-200 pb-1"><?= esc($instansi['telepon'] ?? '-') ?></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Website</label>
                    <p class="text-gray-900 border-b border-gray-200 pb-1"><?= esc($instansi['website'] ?? '-') ?></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                    <p class="text-gray-900 border-b border-gray-200 pb-1"><?= esc($instansi['email'] ?? '-') ?></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Logo Instansi</label>
                    <div class="mt-2">
                        <?php if (!empty($instansi['logo_sekolah'])): ?>
                            <img src="<?= base_url('uploads/logo/' . $instansi['logo_sekolah']) ?>" class="h-20 object-contain border bg-white p-1 rounded" alt="Logo">
                        <?php else: ?>
                            <span class="text-gray-400 italic">Belum ada logo</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
