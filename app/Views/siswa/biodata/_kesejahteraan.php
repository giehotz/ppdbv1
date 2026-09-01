<!-- Tab: Kesejahteraan -->
<div id="content-kesejahteraan" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Program Bantuan Kesejahteraan</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Isi nomor kartu bantuan sosial pemerintah jika keluarga Anda terdaftar sebagai penerima manfaat (kosongkan jika tidak ada).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. Kartu Keluarga Sejahtera (KKS)</label>
            <input type="text" name="no_kks" value="<?= esc($siswa['no_kks'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="Kosongkan jika tidak memiliki KKS">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. Program Keluarga Harapan (PKH)</label>
            <input type="text" name="no_pkh" value="<?= esc($siswa['no_pkh'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="Kosongkan jika tidak memiliki PKH">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. Kartu Indonesia Pintar (KIP)</label>
            <input type="text" name="no_kip" value="<?= esc($siswa['no_kip'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="Kosongkan jika tidak memiliki KIP">
        </div>
    </div>
</div>
