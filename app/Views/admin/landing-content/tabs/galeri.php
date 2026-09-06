    <div id="form-galeri" class="tab-content p-6 hidden">
        <!-- Gallery Header & Actions -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h4 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>Daftar Galeri Foto</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300">
                            Total: <?= $totalGaleriSize ?? '0 B' ?>
                        </span>
                    </h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola dokumentasi kegiatan madrasah (gambar otomatis dikonversi ke WebP super ringan)</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <?php if (!empty($galeri)): ?>
                    <form id="formConvertGaleriWebp" action="<?= base_url('admin/landing-content/convertAllGaleriToWebp') ?>" method="post" class="inline">
                        <?= csrf_field() ?>
                        <button type="button" onclick="confirmConvertAllWebp()" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-bold text-amber-900 bg-amber-100 hover:bg-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:hover:bg-amber-900/80 transition shadow-xs">
                            <span class="material-symbols-outlined text-base">bolt</span>
                            <span>Optimasi Semua ke WebP</span>
                            <?php if (!empty($nonWebpCount)): ?>
                                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-amber-500 text-white text-[10px] font-extrabold ml-0.5" title="<?= $nonWebpCount ?> foto belum WebP"><?= $nonWebpCount ?></span>
                            <?php endif; ?>
                        </button>
                    </form>
                    <?php endif; ?>

                    <button type="button" onclick="openModalTambahGaleri()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 transition shadow-theme-xs hover:shadow-theme-md active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">add_photo_alternate</span>
                        <span>Tambah Foto Galeri</span>
                    </button>
                </div>
            </div>

            <!-- Gallery Grid Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php if (!empty($galeri)): ?>
                    <?php foreach ($galeri as $g): ?>
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden bg-white dark:bg-white/[0.03] shadow-theme-xs hover:shadow-theme-md transition-all relative group flex flex-col">
                            <div class="relative w-full h-40 bg-gray-100 dark:bg-gray-800 overflow-hidden">
                                <img src="<?= base_url($g['gambar']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                <div class="absolute bottom-2 left-2 flex items-center gap-1">
                                    <?php if (!empty($g['is_webp'])): ?>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-600/90 text-white backdrop-blur-xs shadow-xs flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[11px] leading-none">check_circle</span>
                                            <span>WebP</span>
                                            <span>• <?= $g['file_size_formatted'] ?? '' ?></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-600/90 text-white backdrop-blur-xs shadow-xs flex items-center gap-1">
                                            <span><?= strtoupper(pathinfo($g['gambar'], PATHINFO_EXTENSION)) ?></span>
                                            <span>• <?= $g['file_size_formatted'] ?? '' ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <span class="absolute bottom-2 right-2 px-1.5 py-0.5 text-[10px] font-mono font-semibold rounded bg-black/50 text-white/90 backdrop-blur-xs">
                                    Urutan: <?= (int)$g['urutan'] ?>
                                </span>
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h5 class="font-bold text-sm text-gray-900 dark:text-white truncate" title="<?= esc($g['judul']) ?>"><?= esc($g['judul']) ?></h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mt-1 leading-relaxed"><?= esc($g['deskripsi'] ?: 'Tidak ada deskripsi') ?></p>
                                </div>

                                <div class="flex items-center justify-between pt-3 mt-3 border-t border-gray-100 dark:border-gray-800/80">
                                    <div>
                                        <?php if ($g['is_active']): ?>
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-500 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Non-Aktif
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex items-center gap-1.5">
                                        <button type="button" onclick='editGaleri(<?= json_encode($g) ?>)' class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold text-brand-600 bg-brand-50 hover:bg-brand-100 dark:bg-brand-500/15 dark:text-brand-400 dark:hover:bg-brand-500/25 transition-colors" title="Edit Foto">
                                            <i class="fas fa-edit text-xs"></i>
                                            <span>Edit</span>
                                        </button>
                                        <form method="post" action="<?= base_url('admin/landing-content/deleteGaleri/' . $g['galeri_id']) ?>" data-confirm="Yakin ingin menghapus foto galeri ini dari server?" style="display:inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="p-1.5 rounded-lg text-xs font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors" title="Hapus Foto">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-4 py-12 text-center bg-gray-50/50 dark:bg-gray-800/20 rounded-2xl border border-dashed border-gray-200 dark:border-gray-800">
                        <div class="max-w-sm mx-auto">
                            <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-500 mb-2">imagesmode</span>
                            <h5 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum Ada Foto Galeri</h5>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 mb-4">Tambahkan dokumentasi kegiatan madrasah untuk menarik minat calon pendaftar.</p>
                            <button type="button" onclick="openModalTambahGaleri()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 transition shadow-xs">
                                <span class="material-symbols-outlined text-base">add_photo_alternate</span>
                                <span>Tambah Foto Pertama</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODAL POPUP: TAMBAH / EDIT FOTO GALERI -->
    <!-- ========================================================================= -->
    <div id="modal-galeri" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-theme-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800 my-8">
            <!-- Header Modal -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <span id="galeri-modal-icon" class="material-symbols-outlined text-brand-500 text-xl">add_photo_alternate</span>
                    <h3 id="galeri-form-title" class="text-base font-bold text-gray-900 dark:text-white">Tambah Foto Galeri Baru</h3>
                </div>
                <button type="button" onclick="closeModalGaleri()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Form -->
            <form action="<?= base_url('admin/landing-content/saveGaleri') ?>" method="post" enctype="multipart/form-data" class="mt-5 space-y-4">
                <?= csrf_field() ?>
                <input type="hidden" name="galeri_id" id="galeri_id">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Judul Foto <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="galeri_judul" required placeholder="Contoh: Upacara Hari Kemerdekaan"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Urutan Tampil</label>
                        <input type="number" name="urutan" id="galeri_urutan" value="0"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Upload Berkas Gambar</label>
                    <input type="file" name="gambar" id="galeri_gambar" accept="image/png,image/jpeg,image/webp,image/gif" onchange="previewGaleriImage(this)"
                           class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs shadow-theme-xs file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <div class="flex items-center gap-1.5 text-[11px] text-emerald-600 dark:text-emerald-400 mt-1.5 font-medium">
                        <span class="material-symbols-outlined text-sm">auto_fix_high</span>
                        <span>Otomatis dikonversi ke WebP &amp; dikompresi agar loading kilat.</span>
                    </div>
                    <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1 hidden" id="galeri_gambar_note">Biarkan kosong jika tidak ingin mengubah file gambar yang sudah ada.</p>
                </div>

                <!-- Live Image Preview Box -->
                <div id="galeri_preview_container" class="hidden">
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Pratinjau Foto:</label>
                    <div class="relative w-full h-44 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                        <img id="galeri_preview_img" src="" class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Deskripsi Singkat (Opsional)</label>
                    <textarea name="deskripsi" id="galeri_deskripsi" rows="2" placeholder="Catatan singkat tentang dokumentasi kegiatan..."
                              class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none"></textarea>
                </div>

                <div class="pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_active" id="galeri_is_active" value="1" checked class="rounded text-brand-500 focus:ring-brand-400 w-4 h-4">
                        <span class="text-xs text-gray-700 dark:text-gray-300 font-medium">Tampilkan di Landing Page</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800 mt-6">
                    <button type="button" onclick="closeModalGaleri()" class="px-4 py-2.5 text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-theme-xs transition-all active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span id="galeri-btn-submit-text">Simpan Foto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Galeri Modal & Actions -->
    <script>
        function openModalTambahGaleri() {
            document.getElementById('galeri-form-title').innerText = 'Tambah Foto Galeri Baru';
            document.getElementById('galeri-modal-icon').innerText = 'add_photo_alternate';
            document.getElementById('galeri-btn-submit-text').innerText = 'Simpan Foto';
            document.getElementById('galeri_id').value = '';
            document.getElementById('galeri_judul').value = '';
            document.getElementById('galeri_urutan').value = '0';
            document.getElementById('galeri_gambar').value = '';
            document.getElementById('galeri_gambar').setAttribute('required', 'required');
            document.getElementById('galeri_deskripsi').value = '';
            document.getElementById('galeri_is_active').checked = true;
            document.getElementById('galeri_gambar_note').classList.add('hidden');
            document.getElementById('galeri_preview_container').classList.add('hidden');
            document.getElementById('galeri_preview_img').src = '';

            const modal = document.getElementById('modal-galeri');
            if (modal) modal.classList.remove('hidden');
            setTimeout(() => document.getElementById('galeri_judul').focus(), 100);
        }

        function editGaleri(data) {
            document.getElementById('galeri-form-title').innerText = 'Edit Foto Galeri';
            document.getElementById('galeri-modal-icon').innerText = 'edit_note';
            document.getElementById('galeri-btn-submit-text').innerText = 'Perbarui Foto';
            document.getElementById('galeri_id').value = data.galeri_id;
            document.getElementById('galeri_judul').value = data.judul || '';
            document.getElementById('galeri_urutan').value = data.urutan || '0';
            document.getElementById('galeri_gambar').value = '';
            document.getElementById('galeri_gambar').removeAttribute('required');
            document.getElementById('galeri_deskripsi').value = data.deskripsi || '';
            document.getElementById('galeri_is_active').checked = data.is_active == 1;
            document.getElementById('galeri_gambar_note').classList.remove('hidden');

            const previewContainer = document.getElementById('galeri_preview_container');
            const previewImg = document.getElementById('galeri_preview_img');
            if (data.gambar) {
                previewImg.src = '<?= base_url() ?>/' + data.gambar;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
                previewImg.src = '';
            }

            const modal = document.getElementById('modal-galeri');
            if (modal) modal.classList.remove('hidden');
            setTimeout(() => document.getElementById('galeri_judul').focus(), 100);
        }

        function closeModalGaleri() {
            const modal = document.getElementById('modal-galeri');
            if (modal) modal.classList.add('hidden');
        }

        function previewGaleriImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.getElementById('galeri_preview_container');
                    const previewImg = document.getElementById('galeri_preview_img');
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmConvertAllWebp() {
            Swal.fire({
                title: 'Optimasi Semua Foto ke WebP?',
                text: 'Sistem akan mengompresi dan mengonversi seluruh foto galeri menjadi format WebP berkualitas tinggi. File lama berukuran besar akan dibersihkan dari server.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Optimasi Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Mengompresi...',
                        text: 'Mohon tunggu beberapa detik, sistem sedang memproses gambar ke WebP...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('formConvertGaleriWebp').submit();
                }
            });
        }
    </script>
