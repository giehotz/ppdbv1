<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">settings</span>
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Sistem PPDB</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pengaturan istilah sistem, penamaan pendaftaran, status penerimaan, dan format nomor peserta.</p>
        </div>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Istilah Pendaftaran (Alias Sistem)</label>
            <input type="text" name="app_alias" value="<?= $web['app_alias'] ?? 'PPDB' ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl border border-brand-100 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-brand-500 text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Gunakan kolom ini untuk mengganti istilah PPDB menjadi SPMB, PMBM, atau istilah lainnya.<br>
                    <strong>Pilihan Istilah:</strong> ini akan ikut memengaruhi Judul pada Tab Browser, Teks pada Tombol Pendaftaran, dan Header pada Laporan PDF / Kartu Ujian.
                </p>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kepanjangan Istilah (Nama Lengkap Sistem)</label>
            <input type="text" name="app_name" value="<?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?>" placeholder="Misal: Penerimaan Peserta Didik Baru"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Status Pendaftaran</label>
                <select name="status_ppdb"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="Buka" <?= ($web['status_ppdb'] == 'Buka') ? 'selected' : '' ?>>Buka</option>
                    <option value="Tutup" <?= ($web['status_ppdb'] == 'Tutup') ? 'selected' : '' ?>>Tutup</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Semester</label>
                <select name="semester"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="Ganjil" <?= ($web['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= ($web['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Format No. Pendaftaran</label>
            <input type="text" name="format_no_daftar" value="<?= esc($web['format_no_daftar'] ?? 'PPDB-{TAHUN}-{URUT}') ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl border border-brand-100 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-brand-500 text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Gunakan format berikut (gunakan kurung kurawal): <br>
                    <strong>{TAHUN}</strong> = Tahun (misal: <?= date('Y') ?>) &bull;
                    <strong>{BULAN}</strong> = Bulan (misal: <?= date('m') ?>) &bull;
                    <strong>{URUT}</strong> = Nomor urut otomatis (misal: 0001)
                </p>
            </div>
        </div>
    </div>
</div>
