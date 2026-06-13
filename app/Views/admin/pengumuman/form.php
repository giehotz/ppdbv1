<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?><?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                <i class="fas fa-bullhorn text-blue-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800"><?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' ?></h3>
                <p class="text-sm text-gray-500"><?= isset($pengumuman) ? 'Ubah informasi pengumuman' : 'Buat pengumuman baru untuk siswa' ?></p>
            </div>
        </div>

        <form action="<?= isset($pengumuman) ? base_url('admin/pengumuman/update/' . $pengumuman['id_pengumuman']) : base_url('admin/pengumuman/store') ?>"
            method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="p-6 space-y-6">
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i> Informasi Pengumuman
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-heading absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="judul" value="<?= isset($pengumuman) ? esc($pengumuman['judul']) : '' ?>"
                                    required
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Isi Pengumuman <span class="text-red-500">*</span></label>
                            <textarea name="isi_pengumuman" id="isi_pengumuman" rows="8" required
                                class="w-full border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none py-2.5 px-3"><?= isset($pengumuman) ? esc($pengumuman['isi_pengumuman']) : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-cog text-blue-500"></i> Pengaturan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-tag absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <select name="tipe" required
                                    class="w-full pl-9 pr-8 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none bg-white">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="general" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'general') ? 'selected' : '' ?>>General</option>
                                    <option value="ujian" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'ujian') ? 'selected' : '' ?>>Ujian</option>
                                    <option value="kelulusan" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'kelulusan') ? 'selected' : '' ?>>Kelulusan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Target Audience <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-users absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <select name="target_audience" required
                                    class="w-full pl-9 pr-8 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none bg-white">
                                    <option value="">-- Pilih Target --</option>
                                    <option value="all" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'all') ? 'selected' : '' ?>>Semua</option>
                                    <option value="verified" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'verified') ? 'selected' : '' ?>>Terverifikasi</option>
                                    <option value="lulus" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'lulus') ? 'selected' : '' ?>>Lulus</option>
                                    <option value="rejected" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Publish</label>
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="datetime-local" name="publish_date"
                                    value="<?= isset($pengumuman) && $pengumuman['publish_date'] ? date('Y-m-d\TH:i', strtotime($pengumuman['publish_date'])) : '' ?>"
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Kosongkan untuk publish sekarang</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lampiran (File)</label>
                            <div class="relative">
                                <i class="fas fa-paperclip absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="file" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <?php if (isset($pengumuman) && $pengumuman['lampiran']) : ?>
                                <p class="text-xs text-gray-400 mt-1">File saat ini: <span class="font-mono"><?= esc($pengumuman['lampiran']) ?></span></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-check-circle text-blue-500"></i> Opsi Tampilan
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    <?= (isset($pengumuman) && $pengumuman['is_active']) || !isset($pengumuman) ? 'checked' : '' ?>
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Aktifkan Pengumuman</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_popup" id="is_popup" value="1"
                                    <?= (isset($pengumuman) && $pengumuman['is_popup']) ? 'checked' : '' ?>
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="text-sm text-gray-700">Tampilkan sebagai Popup</span>
                            </label>
                        </div>
                        <div id="countdown_wrapper" class="<?= (isset($pengumuman) && $pengumuman['is_popup']) ? '' : 'hidden' ?>">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Hitungan Mundur Popup (Detik)</label>
                            <div class="relative max-w-xs">
                                <i class="fas fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="number" name="popup_countdown" id="popup_countdown"
                                    value="<?= isset($pengumuman) ? $pengumuman['popup_countdown'] : '0' ?>" min="0"
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Lama waktu (detik) sebelum tombol tutup muncul. Isi 0 jika ingin langsung bisa ditutup.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="<?= base_url('admin/pengumuman') ?>"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors duration-150">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition duration-150">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor4/4.22.1/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('isi_pengumuman', {
                height: 400,
                allowedContent: true,
                extraPlugins: 'colorbutton,font,justify'
            });
        } else {
            console.error("CKEditor script failed to load. Please check the network tab.");
        }

        const isPopupCheckbox = document.getElementById('is_popup');
        const countdownWrapper = document.getElementById('countdown_wrapper');

        if (isPopupCheckbox) {
            isPopupCheckbox.addEventListener('change', function() {
                countdownWrapper.classList.toggle('hidden', !this.checked);
            });
        }
    });
</script>
<?= $this->endSection() ?>
