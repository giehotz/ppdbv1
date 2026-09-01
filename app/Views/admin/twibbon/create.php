<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Tambah Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">wallpaper</span> Tambah Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .frame-dropzone {
        border: 2px dashed #d1d5db;
        border-radius: 1rem;
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
    .dark .frame-dropzone {
        border-color: #374151;
        background: rgba(255, 255, 255, 0.02);
    }
    .frame-dropzone:hover,
    .frame-dropzone.dragover {
        border-color: #465fff;
        background: #f0f4ff;
    }
    .dark .frame-dropzone:hover,
    .dark .frame-dropzone.dragover {
        border-color: #465fff;
        background: rgba(70, 95, 255, 0.08);
    }
    .frame-dropzone.has-image {
        padding: 0.5rem;
        background: #fff;
        border-style: solid;
        border-color: #465fff;
    }
    .dark .frame-dropzone.has-image {
        background: #111827;
    }
    .frame-preview {
        max-width: 100%;
        max-height: 240px;
        object-fit: contain;
        display: none;
        border-radius: 0.75rem;
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
        background: rgba(0,0,0,0.5);
        border-radius: 0.75rem;
        opacity: 0;
        transition: opacity 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        gap: 0.35rem;
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

    <!-- Header Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-2xl">add_photo_alternate</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Buat Kampanye Twibbon Baru</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Unggah bingkai PNG transparan dan atur periode publikasi kampanye</p>
            </div>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>"
           class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <?php $errors = session('errors') ?? []; ?>

    <form action="<?= base_url('admin/twibbon/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            <!-- Left Column: Form Fields -->
            <div class="lg:col-span-3 space-y-6">

                <!-- Informasi Kampanye -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-lg">info</span>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Informasi Utama Kampanye</h4>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="title" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Judul Kampanye <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" required
                                   value="<?= old('title') ?>" placeholder="Contoh: Twibbon Sukseskan PPDB 2026/2027"
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                            <?php if (isset($errors['title'])): ?>
                                <p class="text-red-500 text-xs mt-1.5"><?= $errors['title'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="description" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Deskripsi Kampanye
                            </label>
                            <textarea name="description" id="description" rows="4"
                                      placeholder="Tuliskan deskripsi singkat atau instruksi pemasangan twibbon..."
                                      class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none leading-relaxed"><?= old('description') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Periode & Status -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-lg">calendar_month</span>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Jadwal & Status Kampanye</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="<?= old('start_date') ?>"
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                        </div>
                        <div>
                            <label for="end_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="<?= old('end_date') ?>"
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="is_active" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Status Publikasi <span class="text-red-500">*</span></label>
                            <select name="is_active" id="is_active" required
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                                <option value="1" <?= old('is_active', '1') == '1' ? 'selected' : '' ?>>Aktif (Dapat Diakses Publik)</option>
                                <option value="0" <?= old('is_active') == '0' ? 'selected' : '' ?>>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Frame Upload Dropzone -->
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] sticky top-24">
                    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-lg">crop_square</span>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">File Bingkai Twibbon <span class="text-red-500">*</span></h4>
                    </div>

                    <p class="text-xs text-gray-400 mb-4">Wajib berformat PNG transparan (Maks. 5MB).</p>

                    <!-- Dropzone -->
                    <div class="frame-dropzone" id="frame-dropzone" onclick="document.getElementById('frame').click()">
                        <div class="frame-wrapper">
                            <img id="frame-preview" class="frame-preview" src="#" alt="Preview Bingkai">
                            <div class="dropzone-overlay">
                                <span class="material-symbols-outlined text-sm">sync</span> Ganti File
                            </div>
                        </div>
                        <div class="dropzone-text">
                            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center justify-center mx-auto mb-3">
                                <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                            </div>
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-200">Klik atau Drag & Drop Bingkai</p>
                            <p class="text-[11px] text-gray-400 mt-1">Format PNG transparan</p>
                            <p class="text-[10px] text-gray-400">Rasio 1:1 atau sesuai ukuran bingkai</p>
                        </div>
                    </div>

                    <input type="file" name="frame" id="frame" accept="image/png"
                           class="hidden" onchange="previewFrame(this)" required>

                    <?php if (isset($errors['frame'])): ?>
                        <p class="text-red-500 text-xs mt-2"><?= $errors['frame'] ?></p>
                    <?php endif; ?>

                    <p id="file-info" class="text-xs text-gray-500 dark:text-gray-400 mt-3 hidden flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-brand-500">image</span>
                        <span id="file-name" class="font-mono text-gray-800 dark:text-gray-200"></span>
                        <span>&bull;</span>
                        <span id="file-size"></span>
                    </p>
                </div>
            </div>

        </div>

        <!-- Action Footer -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 mt-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-400 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-base text-brand-500">lightbulb</span>
                <span>Pastikan gambar bingkai memiliki lubang transparan di tengah untuk foto peserta.</span>
            </p>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="<?= base_url('admin/twibbon') ?>"
                   class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Kampanye</span>
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

        if (file.type !== 'image/png') {
            alert('Hanya file PNG yang diperbolehkan.');
            input.value = '';
            return;
        }

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

(function() {
    const dropzone = document.getElementById('frame-dropzone');
    const input = document.getElementById('frame');

    if (!dropzone || !input) return;

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
