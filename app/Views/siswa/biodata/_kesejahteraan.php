<!-- Tab: Kesejahteraan -->
<div id="content-kesejahteraan" class="tab-content hidden">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Data Kesejahteraan</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">No. KKS (Kartu Keluarga Sejahtera)</label>
            <input type="text" name="no_kks" value="<?= esc($siswa['no_kks'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kosongkan jika tidak ada">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">No. PKH (Program Keluarga Harapan)</label>
            <input type="text" name="no_pkh" value="<?= esc($siswa['no_pkh'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kosongkan jika tidak ada">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">No. KIP (Kartu Indonesia Pintar)</label>
            <input type="text" name="no_kip" value="<?= esc($siswa['no_kip'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kosongkan jika tidak ada">
        </div>
    </div>
</div>
