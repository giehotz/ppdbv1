    <form id="form-jadwal" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="jadwal">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Section</label>
                <input type="text" name="content[title]" value="<?= esc($sections['jadwal']['title']['content_value'] ?? '') ?>" placeholder="Jadwal Pelaksanaan" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Tahap 1 -->
                <div class="border rounded-lg p-4 border-green-300 bg-green-50">
                    <h4 class="font-semibold mb-3 text-green-700"><i class="fas fa-flag mr-1"></i> Tahap 1</h4>
                    <div class="space-y-2">
                        <input type="text" name="content[tahap1_judul]" placeholder="Judul (cth: Pendaftaran Online)" value="<?= esc($sections['jadwal']['tahap1_judul']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap1_tanggal]" placeholder="Tanggal (cth: 01 Mei - 15 Mei 2024)" value="<?= esc($sections['jadwal']['tahap1_tanggal']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap1_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap1_keterangan']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                    </div>
                </div>
                <!-- Tahap 2 -->
                <div class="border rounded-lg p-4 border-yellow-300 bg-yellow-50">
                    <h4 class="font-semibold mb-3 text-yellow-700"><i class="fas fa-flag mr-1"></i> Tahap 2</h4>
                    <div class="space-y-2">
                        <input type="text" name="content[tahap2_judul]" placeholder="Judul (cth: Verifikasi Berkas)" value="<?= esc($sections['jadwal']['tahap2_judul']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap2_tanggal]" placeholder="Tanggal" value="<?= esc($sections['jadwal']['tahap2_tanggal']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap2_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap2_keterangan']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                    </div>
                </div>
                <!-- Tahap 3 -->
                <div class="border rounded-lg p-4 border-blue-300 bg-blue-50">
                    <h4 class="font-semibold mb-3 text-blue-700"><i class="fas fa-flag mr-1"></i> Tahap 3</h4>
                    <div class="space-y-2">
                        <input type="text" name="content[tahap3_judul]" placeholder="Judul (cth: Pengumuman Hasil)" value="<?= esc($sections['jadwal']['tahap3_judul']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap3_tanggal]" placeholder="Tanggal" value="<?= esc($sections['jadwal']['tahap3_tanggal']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                        <input type="text" name="content[tahap3_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap3_keterangan']['content_value'] ?? '') ?>" class="w-full border-gray-300 rounded-md py-2 px-3 border text-sm">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Jadwal
            </button>
        </div>
    </form>
