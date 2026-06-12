<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900"><?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman Baru' ?></h3>
    </div>

    <form action="<?= isset($pengumuman) ? base_url('admin/pengumuman/update/' . $pengumuman['id_pengumuman']) : base_url('admin/pengumuman/store') ?>"
        method="post"
        enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text"
                    name="judul"
                    value="<?= isset($pengumuman) ? esc($pengumuman['judul']) : '' ?>"
                    required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi_pengumuman"
                    id="isi_pengumuman"
                    rows="8"
                    required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"><?= isset($pengumuman) ? esc($pengumuman['isi_pengumuman']) : '' ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe <span class="text-red-500">*</span></label>
                    <select name="tipe" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="general" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'general') ? 'selected' : '' ?>>General</option>
                        <option value="ujian" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'ujian') ? 'selected' : '' ?>>Ujian</option>
                        <option value="kelulusan" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'kelulusan') ? 'selected' : '' ?>>Kelulusan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audience <span class="text-red-500">*</span></label>
                    <select name="target_audience" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                        <option value="">-- Pilih Target --</option>
                        <option value="all" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'all') ? 'selected' : '' ?>>Semua</option>
                        <option value="verified" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'verified') ? 'selected' : '' ?>>Terverifikasi</option>
                        <option value="lulus" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'lulus') ? 'selected' : '' ?>>Lulus</option>
                        <option value="rejected" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publish</label>
                    <input type="datetime-local"
                        name="publish_date"
                        value="<?= isset($pengumuman) && $pengumuman['publish_date'] ? date('Y-m-d\TH:i', strtotime($pengumuman['publish_date'])) : '' ?>"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan untuk publish sekarang</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran (File)</label>
                    <input type="file"
                        name="lampiran"
                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <?php if (isset($pengumuman) && $pengumuman['lampiran']) : ?>
                        <p class="text-xs text-gray-500 mt-1">File saat ini: <span class="font-mono"><?= $pengumuman['lampiran'] ?></span></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-gray-100">
                <div class="flex items-center">
                    <input type="checkbox"
                        name="is_active"
                        id="is_active"
                        value="1"
                        <?= (isset($pengumuman) && $pengumuman['is_active']) || !isset($pengumuman) ? 'checked' : '' ?>
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Aktifkan Pengumuman
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox"
                        name="is_popup"
                        id="is_popup"
                        value="1"
                        <?= (isset($pengumuman) && $pengumuman['is_popup']) ? 'checked' : '' ?>
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="is_popup" class="ml-2 block text-sm text-gray-900">
                        Tampilkan sebagai Popup di Landing Page
                    </label>
                </div>

                <div id="countdown_wrapper" class="<?= (isset($pengumuman) && $pengumuman['is_popup']) ? '' : 'hidden' ?>">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hitungan Mundur Popup (Detik)</label>
                    <input type="number"
                        name="popup_countdown"
                        id="popup_countdown"
                        value="<?= isset($pengumuman) ? $pengumuman['popup_countdown'] : '0' ?>"
                        min="0"
                        class="w-full md:w-1/4 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <p class="text-xs text-gray-500 mt-1">Lama waktu (detik) sebelum tombol tutup muncul/aktif. Isi 0 jika ingin langsung bisa ditutup.</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <a href="<?= base_url('admin/pengumuman') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Define base path so query parameters on the script tag don't break auto-detection
    var CKEDITOR_BASEPATH = '/js/ckeditor/';
</script>
<script src="<?= base_url('js/ckeditor/ckeditor.js?v=' . time()) ?>"></script>
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

        // Popup countdown toggle
        const isPopupCheckbox = document.getElementById('is_popup');
        const countdownWrapper = document.getElementById('countdown_wrapper');

        if (isPopupCheckbox) {
            isPopupCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    countdownWrapper.classList.remove('hidden');
                } else {
                    countdownWrapper.classList.add('hidden');
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>