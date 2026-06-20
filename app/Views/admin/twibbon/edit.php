<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Edit Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Edit Kampanye</h2>
            <p class="text-sm text-gray-500">Perbarui data kampanye atau unggah ulang bingkai PNG transparan.</p>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>" class="text-gray-600 hover:text-gray-900 flex items-center gap-1 text-sm font-medium">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Error Alerts -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php $errors = session('errors') ?? []; ?>

    <form action="<?= base_url('admin/twibbon/update/' . $campaign['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Kampanye <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none <?= isset($errors['title']) ? 'border-red-500' : '' ?>" value="<?= old('title', $campaign['title']) ?>" placeholder="Contoh: Twibbon Sukseskan PPDB 2026" required>
            <?php if (isset($errors['title'])): ?>
                <p class="text-red-500 text-xs mt-1"><?= $errors['title'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Kampanye</label>
            <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" placeholder="Tuliskan deskripsi singkat mengenai kampanye ini..."><?= old('description', $campaign['description']) ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" value="<?= old('start_date', $campaign['start_date']) ?>">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" value="<?= old('end_date', $campaign['end_date']) ?>">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-1">Status Kampanye <span class="text-red-500">*</span></label>
                <select name="is_active" id="is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none" required>
                    <option value="1" <?= old('is_active', $campaign['is_active']) == '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= old('is_active', $campaign['is_active']) == '0' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
            <div>
                <label for="frame" class="block text-sm font-semibold text-gray-700 mb-1">Ganti File Bingkai (PNG Transparan)</label>
                <input type="file" name="frame" id="frame" accept="image/png" class="w-full border border-gray-300 rounded-lg px-4 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none <?= isset($errors['frame']) ? 'border-red-500' : '' ?>">
                <p class="text-gray-500 text-[11px] mt-1">Kosongkan jika tidak ingin mengganti bingkai. Format PNG, maks 5MB.</p>
                <?php if (isset($errors['frame'])): ?>
                    <p class="text-red-500 text-xs mt-1"><?= $errors['frame'] ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($frame): ?>
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bingkai Saat Ini:</label>
                <div class="flex items-start gap-4">
                    <img src="<?= base_url($frame['file_path']) ?>" alt="Current Frame" class="w-32 h-32 object-cover border rounded shadow-sm">
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>Nama File:</strong> <?= basename($frame['file_path']) ?></p>
                        <p><strong>Resolusi:</strong> <?= $frame['width'] ?> x <?= $frame['height'] ?> px</p>
                        <p><strong>Diupload:</strong> <?= date('d M Y H:i', strtotime($frame['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex justify-end gap-3 border-t pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2.5 rounded-lg transition duration-200">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
