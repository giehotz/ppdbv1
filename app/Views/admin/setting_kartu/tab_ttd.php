<!-- Tab: Tanda Tangan -->
<div id="ttd" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Stempel & Pejabat Penandatangan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Konfigurasi data legalitas, scan tanda tangan, dan cap stempel sekolah pada kartu</p>
        </div>

        <form action="<?= base_url('admin/setting-kartu/saveTandaTangan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id_ttd" value="<?= esc($ttd['id_ttd'] ?? '') ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Kota Ditetapkan
                    </label>
                    <input type="text" name="kota_ttd" value="<?= esc($ttd['kota_ttd'] ?? '') ?>" placeholder="Misal: Tanggamus"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Tanggal Pengesahan (Tampil di kartu)
                    </label>
                    <input type="date" name="tgl_ttd" value="<?= esc($ttd['tgl_ttd'] ?? '') ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Nama Pejabat (Kepala Sekolah / Madrasah)
                    </label>
                    <input type="text" name="nama_pejabat" value="<?= esc($ttd['nama_pejabat'] ?? '') ?>" placeholder="Nama lengkap beserta gelar"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        NIP Pejabat
                    </label>
                    <input type="text" name="nip_pejabat" value="<?= esc($ttd['nip_pejabat'] ?? '') ?>" placeholder="NIP / NUPTK"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Teks Jabatan
                    </label>
                    <input type="text" name="jabatan" value="<?= esc($ttd['jabatan'] ?? 'Kepala Madrasah') ?>" placeholder="Kepala Madrasah / Kepala Sekolah"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <!-- Signature Upload -->
                <div class="rounded-2xl border border-gray-200 bg-gray-50/60 dark:border-gray-700 dark:bg-gray-800/40 p-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2">Scan Tanda Tangan (PNG Transparan)</label>
                    <?php if (!empty($ttd['file_ttd'])): ?>
                        <div class="h-20 w-48 mx-auto mb-2 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-2 shadow-theme-xs flex items-center justify-center">
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_ttd']) ?>" class="max-h-full max-w-full object-contain" alt="Tanda Tangan">
                        </div>
                        <div class="flex justify-center mb-3">
                            <button type="button" class="text-xs text-red-500 hover:text-red-600 font-semibold inline-flex items-center gap-1 py-1 px-2.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors btn-delete-ttd" data-field="file_ttd" data-label="Tanda Tangan" data-id="<?= esc($ttd['id_ttd'] ?? '') ?>">
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Hapus Tanda Tangan
                            </button>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="file_ttd" accept="image/png"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                    <p class="mt-1.5 text-[11px] text-gray-400">Disarankan format PNG transparan tanpa background putih.</p>
                </div>

                <!-- Stamp Upload -->
                <div class="rounded-2xl border border-gray-200 bg-gray-50/60 dark:border-gray-700 dark:bg-gray-800/40 p-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2">Scan Cap Stempel (PNG Transparan)</label>
                    <?php if (!empty($ttd['file_cap'])): ?>
                        <div class="h-20 w-48 mx-auto mb-2 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-2 shadow-theme-xs flex items-center justify-center">
                            <img src="<?= base_url('uploads/kartu/' . $ttd['file_cap']) ?>" class="max-h-full max-w-full object-contain" alt="Cap Stempel">
                        </div>
                        <div class="flex justify-center mb-3">
                            <button type="button" class="text-xs text-red-500 hover:text-red-600 font-semibold inline-flex items-center gap-1 py-1 px-2.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors btn-delete-ttd" data-field="file_cap" data-label="Cap Stempel" data-id="<?= esc($ttd['id_ttd'] ?? '') ?>">
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Hapus Cap Stempel
                            </button>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="file_cap" accept="image/png"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                    <p class="mt-1.5 text-[11px] text-gray-400">Disarankan format PNG transparan.</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end pt-5 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Legalitas TTD & Cap</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.btn-delete-ttd').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var field = this.getAttribute('data-field');
        var label = this.getAttribute('data-label') || 'file';
        var idTtd = this.getAttribute('data-id');
        if (confirm('Apakah Anda yakin ingin menghapus file ' + label + ' ini?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url("admin/setting-kartu/deleteImage") ?>';
            form.innerHTML = '<?= csrf_field() ?>'
                + '<input type="hidden" name="field" value="' + field + '">'
                + '<input type="hidden" name="id_ttd" value="' + idTtd + '">';
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
