        <!-- Tab: QR -->
        <div id="qr" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Konfigurasi Barcode / QR Code</h3>
            <form action="<?= base_url('admin/setting-kartu/saveQr') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_qr" value="<?= esc($qr['id_qr'] ?? '') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Versi QR Array</label>
                        <select name="version" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($qr['version'] ?? 4) == $i ? 'selected' : '' ?>>Versi <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tingkat Toleransi Error (ECC)</label>
                        <select name="ecc_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                            <option value="L" <?= ($qr['ecc_level'] ?? 'M') == 'L' ? 'selected' : '' ?>>Low (7%)</option>
                            <option value="M" <?= ($qr['ecc_level'] ?? 'M') == 'M' ? 'selected' : '' ?>>Medium (15%)</option>
                            <option value="Q" <?= ($qr['ecc_level'] ?? 'M') == 'Q' ? 'selected' : '' ?>>Quartile (25%)</option>
                            <option value="H" <?= ($qr['ecc_level'] ?? 'M') == 'H' ? 'selected' : '' ?>>High (30%)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ukuran Tampil (Pixel)</label>
                        <input type="number" name="size_pixel" value="<?= esc($qr['size_pixel'] ?? 100) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tepi Kosong (Padding margin)</label>
                        <input type="number" name="padding_tepi" value="<?= esc($qr['padding_tepi'] ?? 2) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Posisi QR Code Pada Kartu</label>
                        <select name="posisi_kartu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                            <option value="Depan" <?= ($qr['posisi_kartu'] ?? 'Depan') == 'Depan' ? 'selected' : '' ?>>Bagian Depan</option>
                            <option value="Belakang" <?= ($qr['posisi_kartu'] ?? 'Depan') == 'Belakang' ? 'selected' : '' ?>>Bagian Belakang</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Global URL / Teks Cadangan (Jika QR Anggota kosong)</label>
                        <input type="text" name="global_text" value="<?= esc($qr['global_text'] ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Simpan Pengaturan QR</button>
                </div>
            </form>
        </div>
