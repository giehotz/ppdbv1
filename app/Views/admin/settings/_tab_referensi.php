<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">format_list_bulleted</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Data Referensi</h3>
    </div>
    <div class="p-6">
        <div class="mb-5">
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Pilihan Rentang Penghasilan Orang Tua</label>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Masukkan satu pilihan per baris. Urutan di sini akan menentukan urutan pilihan pada form pendaftaran/biodata siswa.</p>
            <textarea name="penghasilan_list" rows="8"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all font-mono" placeholder="Masukkan satu pilihan per baris..."><?= esc($penghasilan_list ?? '') ?></textarea>
        </div>
        <div class="flex items-start gap-2 p-3 bg-amber-50 dark:bg-amber-500/10 rounded-xl border border-amber-200 dark:border-amber-500/20">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-base flex-shrink-0 mt-0.5">lightbulb</span>
            <div>
                <p class="text-xs font-bold text-amber-700 dark:text-amber-300">Contoh Format:</p>
                <pre class="text-xs text-amber-600 dark:text-amber-400 mt-1 leading-relaxed">&lt; Rp. 500.000
Rp. 500.000 - Rp. 1.000.000
Rp. 1.000.000 - Rp. 2.000.000
&gt; Rp. 2.000.000</pre>
            </div>
        </div>
    </div>
</div>
