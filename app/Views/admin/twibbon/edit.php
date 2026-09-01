<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Edit Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">wallpaper</span> Edit Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">edit</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Kampanye Twibbon</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui data kampanye atau unggah ulang bingkai PNG transparan</p>
                </div>
            </div>
            <a href="<?= base_url('admin/twibbon') ?>"
               class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>

        <?php $errors = session('errors') ?? []; ?>

        <form action="<?= base_url('admin/twibbon/update/' . $campaign['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="p-6 md:p-8 space-y-5">
                <div>
                    <label for="title" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Judul Kampanye <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           value="<?= old('title', $campaign['title']) ?>" placeholder="Contoh: Twibbon Sukseskan PPDB 2026"
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
                              placeholder="Tuliskan deskripsi singkat mengenai kampanye ini..."
                              class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none leading-relaxed"><?= old('description', $campaign['description']) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" value="<?= old('start_date', $campaign['start_date']) ?>"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    </div>
                    <div>
                        <label for="end_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" value="<?= old('end_date', $campaign['end_date']) ?>"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="is_active" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Status Kampanye <span class="text-red-500">*</span></label>
                        <select name="is_active" id="is_active" required
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                            <option value="1" <?= old('is_active', $campaign['is_active']) == '1' ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= old('is_active', $campaign['is_active']) == '0' ? 'selected' : '' ?>>Non-Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="frame" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Ganti File Bingkai (PNG)</label>
                        <input type="file" name="frame" id="frame" accept="image/png"
                               class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                        <p class="text-gray-400 text-[11px] mt-1">Kosongkan jika tidak ingin mengganti file. Format PNG, maks 5MB.</p>
                    </div>
                </div>

                <?php if ($frame): ?>
                    <div class="p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/40">
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 block mb-3">Bingkai Twibbon Saat Ini:</span>
                        <div class="flex items-center gap-4">
                            <div class="h-24 w-24 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden bg-white dark:bg-gray-900 shadow-theme-xs shrink-0">
                                <img src="<?= base_url($frame['file_path']) ?>" alt="Current Frame" class="h-full w-full object-cover">
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1 font-mono">
                                <p><strong class="text-gray-800 dark:text-gray-200">Nama File:</strong> <?= basename($frame['file_path']) ?></p>
                                <p><strong class="text-gray-800 dark:text-gray-200">Resolusi:</strong> <?= $frame['width'] ?> &times; <?= $frame['height'] ?> px</p>
                                <p><strong class="text-gray-800 dark:text-gray-200">Diunggah:</strong> <?= date('d M Y H:i', strtotime($frame['created_at'])) ?> WIB</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <a href="<?= base_url('admin/twibbon') ?>"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-theme-xs">
                    <span>Batal</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
