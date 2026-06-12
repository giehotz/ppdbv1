        <!-- Tab: Tanda Tangan -->
        <div id="ttd" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Stempel & Pejabat Penandatangan</h3>
            <form action="<?= base_url('admin/setting-kartu/saveTandaTangan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_ttd" value="<?= esc($ttd['id_ttd'] ?? '') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kota Ditetapkan</label>
                        <input type="text" name="kota_ttd" value="<?= esc($ttd['kota_ttd'] ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Pengesahan (Tampil di kartu)</label>
                        <input type="date" name="tgl_ttd" value="<?= esc($ttd['tgl_ttd'] ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pejabat (Kepala / Dekan)</label>
                        <input type="text" name="nama_pejabat" value="<?= esc($ttd['nama_pejabat'] ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP Jabatan</label>
                        <input type="text" name="nip_pejabat" value="<?= esc($ttd['nip_pejabat'] ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Teks Jabatan</label>
                        <input type="text" name="jabatan" value="<?= esc($ttd['jabatan'] ?? 'Kepala Madrasah') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>

                    <div class="mt-4 border p-4 rounded bg-gray-50 flex flex-col items-center">
                        <label class="block text-sm font-medium text-gray-700 w-full mb-2">Scan Tanda Tangan (PNG transparan disarankan)</label>
                        <?php if (!empty($ttd['file_ttd'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_ttd']) ?>" class="h-20 object-contain mb-2 border p-1 bg-white" alt="Tanda Tangan">
                        <?php endif; ?>
                        <input type="file" name="file_ttd" accept="image/png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                    </div>

                    <div class="mt-4 border p-4 rounded bg-gray-50 flex flex-col items-center">
                        <label class="block text-sm font-medium text-gray-700 w-full mb-2">Scan Cap Stempel (PNG transparan)</label>
                        <?php if (!empty($ttd['file_cap'])): ?>
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_cap']) ?>" class="h-20 object-contain mb-2 border p-1 bg-white" alt="Cap">
                        <?php endif; ?>
                        <input type="file" name="file_cap" accept="image/png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Simpan Legalitas TTD</button>
                </div>
            </form>
        </div>
