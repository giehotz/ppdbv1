<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan Twibbon
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">settings</span> Pengaturan Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-2xl">auto_delete</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengaturan Otomasi Twibbon</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola siklus hidup file cache, retensi file sementara, dan pembersihan terjadwal</p>
            </div>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>"
           class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali</span>
        </a>
    </div>

    <?php $errors = session('errors') ?? []; ?>

    <!-- Form Settings -->
    <form action="<?= base_url('admin/twibbon/saveSetting') ?>" method="post">
        <?= csrf_field() ?>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">schedule</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Jadwal & Retensi Pembersihan Otomatis</h4>
            </div>

            <div class="space-y-6">

                <!-- Toggle Pembersihan -->
                <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
                    <div>
                        <p class="text-xs font-bold text-gray-900 dark:text-white">Pembersihan Otomatis (Background Cleanup)</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Hapus file twibbon yang sudah kadaluarsa secara berkala di latar belakang.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="cleanup_enabled" value="0">
                        <input type="checkbox" name="cleanup_enabled" value="1" <?= ($settings['cleanup_enabled'] ?? 1) ? 'checked' : '' ?> class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500"></div>
                    </label>
                </div>

                <!-- Durasi Hasil -->
                <div>
                    <label for="results_ttl_hours" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Retensi File Hasil Unduhan <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">File hasil generate twibbon (folder <code>results/</code>) yang lebih lama dari durasi ini akan otomatis dihapus.</p>
                    <div class="relative max-w-xs">
                        <input type="number" name="results_ttl_hours" id="results_ttl_hours" min="1" max="8759" required
                               value="<?= old('results_ttl_hours', $settings['results_ttl_hours'] ?? 12) ?>"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white pl-4 pr-12 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold pointer-events-none">Jam</span>
                    </div>
                    <?php if (isset($errors['results_ttl_hours'])): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $errors['results_ttl_hours'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Durasi Temp -->
                <div>
                    <label for="temp_ttl_hours" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Retensi File Foto Sementara <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">File foto sementara pengguna (folder <code>temp/</code>) yang lebih lama dari durasi ini akan dihapus.</p>
                    <div class="relative max-w-xs">
                        <input type="number" name="temp_ttl_hours" id="temp_ttl_hours" min="1" max="8759" required
                               value="<?= old('temp_ttl_hours', $settings['temp_ttl_hours'] ?? 1) ?>"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white pl-4 pr-12 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold pointer-events-none">Jam</span>
                    </div>
                    <?php if (isset($errors['temp_ttl_hours'])): ?>
                        <p class="text-red-500 text-xs mt-1"><?= $errors['temp_ttl_hours'] ?></p>
                    <?php endif; ?>
                </div>

            </div>

            <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </div>
    </form>

    <!-- Aksi Manual -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2">
            <span class="material-symbols-outlined text-brand-500 text-lg">build</span>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Tindakan Pembersihan & Arsip Manual</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <form action="<?= base_url('admin/twibbon/cleanup') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus semua file kadaluarsa sekarang?')"
                        class="w-full rounded-2xl border border-amber-200 dark:border-amber-500/20 bg-amber-50/70 hover:bg-amber-100 dark:bg-amber-500/10 dark:hover:bg-amber-500/20 text-amber-800 dark:text-amber-300 font-bold px-5 py-4 transition text-xs flex items-center justify-center gap-2 shadow-theme-xs">
                    <span class="material-symbols-outlined text-lg">cleaning_services</span>
                    <span>Hapus File Kadaluarsa Sekarang</span>
                </button>
            </form>
            <a href="<?= base_url('admin/twibbon/download-zip') ?>"
               class="w-full rounded-2xl border border-blue-200 dark:border-blue-500/20 bg-blue-50/70 hover:bg-blue-100 dark:bg-blue-500/10 dark:hover:bg-blue-500/20 text-blue-800 dark:text-blue-300 font-bold px-5 py-4 transition text-xs flex items-center justify-center gap-2 shadow-theme-xs">
                <span class="material-symbols-outlined text-lg">folder_zip</span>
                <span>Download Seluruh Arsip Hasil (ZIP)</span>
            </a>
        </div>
    </div>

    <!-- Info Cron Box -->
    <div class="rounded-2xl border border-blue-200/80 bg-blue-50/50 dark:border-blue-500/20 dark:bg-blue-500/10 p-5 shadow-theme-xs">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl shrink-0 mt-0.5">terminal</span>
            <div class="text-xs text-blue-900 dark:text-blue-300 space-y-2">
                <p class="font-bold text-sm">Informasi Penjadwalan Cron Job</p>
                <p class="leading-relaxed">
                    Untuk server produksi tanpa cPanel cron langsung, jadwalkan perintah spark berikut pada sistem operasi atau layanan cron eksternal setiap jam:
                </p>
                <pre class="bg-white/80 dark:bg-gray-900/80 rounded-xl p-3 text-xs font-mono border border-blue-200 dark:border-blue-500/30 overflow-x-auto text-gray-800 dark:text-gray-200">php <?= ROOTPATH ?>spark twibbon:cleanup</pre>
                <p class="text-[11px] opacity-80 leading-relaxed">
                    Pembersihan otomatis juga berjalan secara adaptif (~5% sampling probability) pada setiap unduhan twibbon yang berhasil.
                </p>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>