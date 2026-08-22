<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Tambah Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Tambah Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .frame-dropzone {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f9fafb;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .frame-dropzone:hover,
    .frame-dropzone.dragover {
        border-color: #16a34a;
        background: #f0fdf4;
    }
    .frame-dropzone.has-image {
        padding: 0.5rem;
        background: #fff;
        border-style: solid;
        border-color: #16a34a;
    }
    .frame-preview {
        max-width: 100%;
        max-height: 240px;
        object-fit: contain;
        display: none;
        border-radius: 8px;
    }
    .frame-dropzone.has-image .frame-preview {
        display: block;
    }
    .frame-dropzone.has-image .dropzone-text {
        display: none;
    }
    .frame-dropzone.has-image .dropzone-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        gap: 0.5rem;
    }
    .frame-dropzone.has-image:hover .dropzone-overlay {
        opacity: 1;
    }
    .frame-wrapper {
        position: relative;
        display: inline-block;
        max-width: 100%;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-image text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Buat Kampanye Baru</h1>
                <p class="text-sm text-gray-500 mt-0.5">Isi data kampanye dan unggah bingkai PNG transparan.</p>
            </div>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>" class="text-gray-500 hover:text-gray-700 flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Error Alerts -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl relative mb-6 flex items-start gap-3">
            <i class="fas fa-exclamation-circle mt-0.5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php $errors = session('errors') ?? []; ?>

    <form action="<?= base_url('admin/twibbon/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            <!-- Left Column: Form Fields -->
            <div class="lg:col-span-3 space-y-6">

                <!-- Informasi Kampanye -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-info-circle text-emerald-600"></i> Informasi Kampanye
                    </h3>
                    <p class="text-xs text-gray-400 mb-5">Detail utama yang akan ditampilkan ke publik.</p>

                    <div class="space-y-5">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Kampanye <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow <?= isset($errors['title']) ? 'border-red-400 ring-1 ring-red-400' : '' ?>"
                                value="<?= old('title') ?>" placeholder="Contoh: Twibbon Sukseskan PPDB 2026" required>
                            <?php if (isset($errors['title'])): ?>
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> <?= $errors['title'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kampanye</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow resize-y"
                                placeholder="Tuliskan deskripsi singkat mengenai kampanye ini..."><?= old('description') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Periode & Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-emerald-600"></i> Periode &amp; Status
                    </h3>
                    <p class="text-xs text-gray-400 mb-5">Atur jadwal aktif dan status kampanye.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                            <div class="relative">
                                <i class="fas fa-calendar-day absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow"
                                    value="<?= old('start_date') ?>">
                            </div>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                            <div class="relative">
                                <i class="fas fa-calendar-check absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow"
                                    value="<?= old('end_date') ?>">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="is_active" class="block text-sm font-semibold text-gray-700 mb-1.5">Status Kampanye <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-toggle-on absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                                <select name="is_active" id="is_active"
                                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow appearance-none bg-white" required>
                                    <option value="1" <?= old('is_active', '1') == '1' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= old('is_active') == '0' ? 'selected' : '' ?>>Non-Aktif</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Frame Upload -->
            <div class="lg:col-span-2">

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                        <i class="fas fa-stop text-emerald-600"></i> Bingkai Twibbon <span class="text-red-500">*</span>
                    </h3>
                    <p class="text-xs text-gray-400 mb-4">Upload bingkai PNG transparan (maks. 5MB).</p>

                    <!-- Dropzone -->
                    <div class="frame-dropzone" id="frame-dropzone" onclick="document.getElementById('frame').click()">
                        <div class="frame-wrapper">
                            <img id="frame-preview" class="frame-preview" src="#" alt="Preview Bingkai">
                            <div class="dropzone-overlay">
                                <i class="fas fa-sync-alt"></i> Ganti File
                            </div>
                        </div>
                        <div class="dropzone-text">
                            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-3 border border-emerald-200">
                                <i class="fas fa-cloud-upload-alt text-2xl text-emerald-500"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-700">Klik untuk upload bingkai</p>
                            <p class="text-xs text-gray-400 mt-1">Format PNG transparan</p>
                            <p class="text-xs text-gray-400">Dimensi menyesuaikan ukuran bingkai yang diunggah</p>
                        </div>
                    </div>

                    <input type="file" name="frame" id="frame" accept="image/png"
                        class="hidden <?= isset($errors['frame']) ? 'border-red-400' : '' ?>"
                        onchange="previewFrame(this)" required>

                    <?php if (isset($errors['frame'])): ?>
                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> <?= $errors['frame'] ?></p>
                    <?php endif; ?>

                    <p id="file-info" class="text-xs text-gray-400 mt-3 hidden flex items-center gap-1.5">
                        <i class="fas fa-file-image text-emerald-500"></i>
                        <span id="file-name"></span>
                        <span class="text-gray-300">•</span>
                        <span id="file-size"></span>
                    </p>
                </div>

            </div>

        </div>

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-400"><i class="fas fa-info-circle text-emerald-500 mr-1"></i> Pastikan bingkai memiliki area transparan di tengah untuk foto.</p>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="reset" class="flex-1 sm:flex-none bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold px-6 py-2.5 rounded-lg transition-colors text-sm">
                    Reset
                </button>
                <button type="submit" class="flex-1 sm:flex-none bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Kampanye
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function previewFrame(input) {
    const dropzone = document.getElementById('frame-dropzone');
    const preview = document.getElementById('frame-preview');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate type
        if (file.type !== 'image/png') {
            alert('Hanya file PNG yang diperbolehkan.');
            input.value = '';
            return;
        }

        // Validate size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            dropzone.classList.add('has-image');
            fileName.textContent = file.name;

            const sizeKB = (file.size / 1024).toFixed(1);
            fileSize.textContent = sizeKB < 1024 ? sizeKB + ' KB' : (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            fileInfo.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Drag-and-drop support
(function() {
    const dropzone = document.getElementById('frame-dropzone');
    const input = document.getElementById('frame');

    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            input.files = e.dataTransfer.files;
            previewFrame(input);
        }
    });
})();
</script>
<?= $this->endSection() ?>
