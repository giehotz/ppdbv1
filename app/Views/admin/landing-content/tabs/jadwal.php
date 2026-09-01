    <form id="form-jadwal" class="tab-content p-6 hidden" action="<?= base_url('admin/landing-content/update') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="section" value="jadwal">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Section <span class="text-xs text-gray-400 dark:text-gray-500 font-normal">(mendukung HTML &amp; CSS seperti &lt;br&gt;)</span></label>
                <input type="text" name="content[title]" value="<?= esc($sections['jadwal']['title']['content_value'] ?? '') ?>" placeholder="Jadwal Pelaksanaan" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tahap 1 -->
                <div class="rounded-2xl border border-emerald-200 p-5 bg-emerald-50/50 dark:border-emerald-800/50 dark:bg-emerald-950/20">
                    <h4 class="font-semibold mb-3 text-emerald-700 dark:text-emerald-400 flex items-center gap-1.5"><i class="fas fa-flag text-xs"></i> Tahap 1</h4>
                    <div class="space-y-3">
                        <input type="text" name="content[tahap1_judul]" placeholder="Judul (cth: Pendaftaran Online)" value="<?= esc($sections['jadwal']['tahap1_judul']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap1_tanggal]" placeholder="Tanggal (cth: 01 Mei - 15 Mei 2024)" value="<?= esc($sections['jadwal']['tahap1_tanggal']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap1_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap1_keterangan']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <!-- Tahap 2 -->
                <div class="rounded-2xl border border-amber-200 p-5 bg-amber-50/50 dark:border-amber-800/50 dark:bg-amber-950/20">
                    <h4 class="font-semibold mb-3 text-amber-700 dark:text-amber-400 flex items-center gap-1.5"><i class="fas fa-flag text-xs"></i> Tahap 2</h4>
                    <div class="space-y-3">
                        <input type="text" name="content[tahap2_judul]" placeholder="Judul (cth: Verifikasi Berkas)" value="<?= esc($sections['jadwal']['tahap2_judul']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap2_tanggal]" placeholder="Tanggal" value="<?= esc($sections['jadwal']['tahap2_tanggal']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap2_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap2_keterangan']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <!-- Tahap 3 -->
                <div class="rounded-2xl border border-blue-200 p-5 bg-blue-50/50 dark:border-blue-800/50 dark:bg-blue-950/20">
                    <h4 class="font-semibold mb-3 text-blue-700 dark:text-blue-400 flex items-center gap-1.5"><i class="fas fa-flag text-xs"></i> Tahap 3</h4>
                    <div class="space-y-3">
                        <input type="text" name="content[tahap3_judul]" placeholder="Judul (cth: Pengumuman Hasil)" value="<?= esc($sections['jadwal']['tahap3_judul']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap3_tanggal]" placeholder="Tanggal" value="<?= esc($sections['jadwal']['tahap3_tanggal']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                        <input type="text" name="content[tahap3_keterangan]" placeholder="Keterangan singkat" value="<?= esc($sections['jadwal']['tahap3_keterangan']['content_value'] ?? '') ?>" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Jadwal
            </button>
        </div>
    </form>
