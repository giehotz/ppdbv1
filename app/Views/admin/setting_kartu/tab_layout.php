<!-- Tab: Layout -->
<div id="layout" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Desain Kartu & Layout</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Konfigurasi dimensi kartu, background depan & belakang, dan masa berlaku</p>
        </div>

        <form action="<?= base_url('admin/setting-kartu/saveLayout') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id_layout" value="<?= esc($layout['id_layout'] ?? '') ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Nama Desain (Tema) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_layout" value="<?= esc($layout['nama_layout'] ?? 'Desain Standar') ?>" required
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Panjang / Lebar Horizontal (cm)
                    </label>
                    <input type="number" step="0.01" name="panjang_cm" value="<?= esc($layout['panjang_cm'] ?? 8.56) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1 text-[11px] text-gray-400">Standar ID Card: 8.56 cm</p>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Tinggi / Dimensi Vertikal (cm)
                    </label>
                    <input type="number" step="0.01" name="lebar_cm" value="<?= esc($layout['lebar_cm'] ?? 5.39) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1 text-[11px] text-gray-400">Standar ID Card: 5.39 cm</p>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Masa Berlaku (Tahun)
                    </label>
                    <input type="number" name="masa_berlaku" value="<?= esc($layout['masa_berlaku'] ?? 3) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1 text-[11px] text-gray-400">Isi 0 jika berlaku seumur hidup / selama menjadi siswa.</p>
                </div>

                <!-- Recommendation Box -->
                <div class="md:col-span-2">
                    <?php
                        $dpi = $printer['dpi'] ?? 300;
                        $panjang = $layout['panjang_cm'] ?? 8.56;
                        $lebar   = $layout['lebar_cm'] ?? 5.39;
                        $widthPx  = round(($panjang / 2.54) * $dpi);
                        $heightPx = round(($lebar / 2.54) * $dpi);
                    ?>
                    <div class="rounded-xl border border-brand-100 bg-brand-50/60 dark:border-brand-500/20 dark:bg-brand-500/10 p-4">
                        <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-brand-500 text-lg flex-shrink-0 mt-0.5">info</span>
                            <div class="text-xs text-brand-800 dark:text-brand-300 space-y-1">
                                <p class="font-bold">Rekomendasi Ukuran Gambar Background (DPI: <?= $dpi ?>):</p>
                                <p>Dimensi resolusi optimal: <b class="text-brand-900 dark:text-white font-mono text-sm"><?= $widthPx ?> &times; <?= $heightPx ?> piksel</b> (Format: JPG / PNG).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background Upload Cards -->
                <div class="rounded-2xl border border-gray-200 bg-gray-50/60 dark:border-gray-700 dark:bg-gray-800/40 p-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-3">Background Depan</label>
                    <?php if (!empty($layout['bg_depan'])): ?>
                        <div class="mb-3 rounded-xl overflow-hidden aspect-[8.56/5.39] border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-theme-xs">
                            <img src="<?= base_url('uploads/kartu/' . $layout['bg_depan']) ?>" class="w-full h-full object-cover" alt="Background Depan">
                        </div>
                        <button type="button" class="text-xs text-red-500 hover:text-red-600 font-semibold flex items-center gap-1 mb-3 btn-delete-img" data-field="bg_depan" data-id="<?= esc($layout['id_layout'] ?? '') ?>">
                            <span class="material-symbols-outlined text-sm">delete</span>
                            Hapus Gambar Depan
                        </button>
                    <?php endif; ?>
                    <input type="file" name="bg_depan" accept="image/*"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                </div>

                <div class="rounded-2xl border border-gray-200 bg-gray-50/60 dark:border-gray-700 dark:bg-gray-800/40 p-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-3">Background Belakang</label>
                    <?php if (!empty($layout['bg_belakang'])): ?>
                        <div class="mb-3 rounded-xl overflow-hidden aspect-[8.56/5.39] border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-theme-xs">
                            <img src="<?= base_url('uploads/kartu/' . $layout['bg_belakang']) ?>" class="w-full h-full object-cover" alt="Background Belakang">
                        </div>
                        <button type="button" class="text-xs text-red-500 hover:text-red-600 font-semibold flex items-center gap-1 mb-3 btn-delete-img" data-field="bg_belakang" data-id="<?= esc($layout['id_layout'] ?? '') ?>">
                            <span class="material-symbols-outlined text-sm">delete</span>
                            Hapus Gambar Belakang
                        </button>
                    <?php endif; ?>
                    <input type="file" name="bg_belakang" accept="image/*"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                </div>
            </div>

            <div class="mt-8 flex justify-end pt-5 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pengaturan Layout</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.btn-delete-img').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var field = this.getAttribute('data-field');
        var idLayout = this.getAttribute('data-id');
        if (confirm('Apakah Anda yakin ingin menghapus file background gambar ini?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url("admin/setting-kartu/deleteImage") ?>';
            form.innerHTML = '<?= csrf_field() ?>'
                + '<input type="hidden" name="field" value="' + field + '">'
                + '<input type="hidden" name="id_layout" value="' + idLayout + '">';
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
