        <!-- Tab: Layout -->
        <div id="layout" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Desain Kartu & Layout</h3>
            <form action="<?= base_url('admin/setting-kartu/saveLayout') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id_layout" value="<?= esc($layout['id_layout'] ?? '') ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Desain (Tema)</label>
                        <input type="text" name="nama_layout" value="<?= esc($layout['nama_layout'] ?? 'Desain Standar') ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Panjang / Tinggi Kartu (cm)</label>
                        <input type="number" step="0.01" name="panjang_cm" value="<?= esc($layout['panjang_cm'] ?? 8.56) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lebar Kartu (cm)</label>
                        <input type="number" step="0.01" name="lebar_cm" value="<?= esc($layout['lebar_cm'] ?? 5.39) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Masa Berlaku (Tahun)</label>
                        <input type="number" name="masa_berlaku" value="<?= esc($layout['masa_berlaku'] ?? 3) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                        <span class="text-xs text-gray-400">Isi 0 jika berlaku seumur hidup.</span>
                    </div>

                    <div class="md:col-span-2 mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                            $dpi = $printer['dpi'] ?? 300;
                            $panjang = $layout['panjang_cm'] ?? 8.56;
                            $lebar   = $layout['lebar_cm'] ?? 5.39;
                            $widthPx  = round(($panjang / 2.54) * $dpi);
                            $heightPx = round(($lebar / 2.54) * $dpi);
                        ?>
                        <div class="md:col-span-2 bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-start gap-2">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <div class="text-xs text-blue-700">
                                <p class="font-semibold mb-1">Rekomendasi Ukuran Gambar Background</p>
                                <p>Berdasarkan ukuran kartu <strong><?= $panjang ?> × <?= $lebar ?> cm</strong> dengan DPI <strong><?= $dpi ?></strong>:</p>
                                <p class="mt-1 font-bold text-blue-900 text-sm"><?= $widthPx ?> × <?= $heightPx ?> piksel</p>
                                <p class="mt-1 text-blue-600">Format: JPG / PNG. Rasio aspek ≈ <?= round($panjang / $lebar, 2) ?> : 1</p>
                            </div>
                        </div>
                        <div class="border rounded p-4 bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Depan</label>
                            <?php if (!empty($layout['bg_depan'])): ?>
                                <div class="mb-3 border rounded overflow-hidden aspect-[8.56/5.39]">
                                    <img src="<?= base_url('uploads/kartu/' . $layout['bg_depan']) ?>" class="w-full h-full object-cover" alt="Background Depan">
                                </div>
                                <button type="button" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 mb-2 btn-delete-img" data-field="bg_depan" data-id="<?= esc($layout['id_layout'] ?? '') ?>">
                                    <i class="fas fa-trash-alt"></i> Hapus Gambar
                                </button>
                            <?php endif; ?>
                            <input type="file" name="bg_depan" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                        </div>

                        <div class="border rounded p-4 bg-gray-50">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Belakang</label>
                            <?php if (!empty($layout['bg_belakang'])): ?>
                                <div class="mb-3 border rounded overflow-hidden aspect-[8.56/5.39]">
                                    <img src="<?= base_url('uploads/kartu/' . $layout['bg_belakang']) ?>" class="w-full h-full object-cover" alt="Background Belakang">
                                </div>
                                <button type="button" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1 mb-2 btn-delete-img" data-field="bg_belakang" data-id="<?= esc($layout['id_layout'] ?? '') ?>">
                                    <i class="fas fa-trash-alt"></i> Hapus Gambar
                                </button>
                            <?php endif; ?>
                            <input type="file" name="bg_belakang" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">Simpan Layout</button>
                </div>
            </form>
        </div>

        <script>
        document.querySelectorAll('.btn-delete-img').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var field = this.getAttribute('data-field');
                var idLayout = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Hapus Gambar?',
                    text: 'File gambar akan dihapus permanen dari server.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.isConfirmed) {
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
        });
        </script>
