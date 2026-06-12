        <!-- Tab: Printer -->
        <div id="printer" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Kalibrasi Mesin & Kertas Print</h3>
            <form action="<?= base_url('admin/setting-kartu/savePrinter') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id_printer" value="<?= esc($printer['id_printer'] ?? '') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Kerapatan Cetak (DPI/PPI Resolution)</label>
                        <input type="number" name="dpi" value="<?= esc($printer['dpi'] ?? 300) ?>" class="mt-1 block max-w-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                        <span class="text-xs text-green-600 block mt-1"><i class="fas fa-info-circle"></i> Resolusi umum untuk print adalah 300 DPI.</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Batas Margin Kiri di Kertas (cm)</label>
                        <input type="number" step="0.01" name="margin_kiri" value="<?= esc($printer['margin_kiri'] ?? 0.5) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Batas Margin Atas di Kertas (cm)</label>
                        <input type="number" step="0.01" name="margin_atas" value="<?= esc($printer['margin_atas'] ?? 0.5) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jarak Kanan antar Kartu (X-Gap cm)</label>
                        <input type="number" step="0.01" name="margin_kartu_kanan" value="<?= esc($printer['margin_kartu_kanan'] ?? 0.1) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jarak Bawah antar Kartu (Y-Gap cm)</label>
                        <input type="number" step="0.01" name="margin_kartu_bawah" value="<?= esc($printer['margin_kartu_bawah'] ?? 0.1) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Margin Depan - Belakang saat dicetak berdampingan (cm)</label>
                        <input type="number" step="0.01" name="margin_depan_belakang" value="<?= esc($printer['margin_depan_belakang'] ?? 0) ?>" class="mt-1 block max-w-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Simpan Setrip Printer</button>
                </div>
            </form>
        </div>
