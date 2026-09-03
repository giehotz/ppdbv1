<!-- Tab: Kesejahteraan -->
<div id="content-kesejahteraan" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Program Bantuan Kesejahteraan</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Isi nomor kartu bantuan sosial pemerintah jika keluarga Anda terdaftar sebagai penerima manfaat (kosongkan jika tidak ada).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">No. Kartu Keluarga Sejahtera (KKS)</label>
            <input type="text" name="no_kks" value="<?= esc($siswa['no_kks'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="Kosongkan jika tidak memiliki KKS">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">No. Program Keluarga Harapan (PKH)</label>
            <input type="text" name="no_pkh" value="<?= esc($siswa['no_pkh'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="Kosongkan jika tidak memiliki PKH">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">No. Kartu Indonesia Pintar (KIP)</label>
            <input type="text" name="no_kip" value="<?= esc($siswa['no_kip'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="Kosongkan jika tidak memiliki KIP">
        </div>
    </div>
</div>
