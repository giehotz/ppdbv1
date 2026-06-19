<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">format_list_bulleted</span>
        <h3 class="text-lg font-bold text-on-surface">Data Referensi</h3>
    </div>
    <div class="p-6">
        <div class="mb-5">
            <label class="block text-sm font-bold text-on-surface mb-1.5">Pilihan Rentang Penghasilan Orang Tua</label>
            <p class="text-xs text-on-surface-variant mb-3">Masukkan satu pilihan per baris. Urutan di sini akan menentukan urutan pilihan pada form pendaftaran/biodata siswa.</p>
            <textarea name="penghasilan_list" rows="8"
                      class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-mono" placeholder="Masukkan satu pilihan per baris..."><?= esc($penghasilan_list ?? '') ?></textarea>
        </div>
        <div class="flex items-start gap-2 p-3 bg-tertiary-container/20 rounded-lg border border-tertiary/10">
            <span class="material-symbols-outlined text-tertiary text-base flex-shrink-0 mt-0.5">lightbulb</span>
            <div>
                <p class="text-xs font-bold text-tertiary">Contoh Format:</p>
                <pre class="text-xs text-tertiary mt-1 leading-relaxed">&lt; Rp. 500.000
Rp. 500.000 - Rp. 1.000.000
Rp. 1.000.000 - Rp. 2.000.000
&gt; Rp. 2.000.000</pre>
            </div>
        </div>
    </div>
</div>
