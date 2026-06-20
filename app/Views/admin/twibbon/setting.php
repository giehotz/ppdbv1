<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Pengaturan Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Pengaturan Twibbon<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .toggle-switch {
        position: relative;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        inset: 0;
        background: #d1d5db;
        border-radius: 26px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        left: 3px;
        bottom: 3px;
        background: #fff;
        border-radius: 50%;
        transition: transform 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    .toggle-switch input:checked + .toggle-slider {
        background: #16a34a;
    }
    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(22px);
    }
    .stat-card {
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                <i class="fas fa-cog text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Pengaturan Twibbon</h1>
                <p class="text-sm text-gray-500 mt-0.5">Atur pembersihan otomatis file hasil twibbon.</p>
            </div>
        </div>
        <a href="<?= base_url('admin/twibbon') ?>" class="text-gray-500 hover:text-gray-700 flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-3.5 rounded-xl flex items-start gap-3">
            <i class="fas fa-check-circle mt-0.5"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl flex items-start gap-3">
            <i class="fas fa-exclamation-circle mt-0.5"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>
    <?php $errors = session('errors') ?? []; ?>

    <!-- Form Settings -->
    <form action="<?= base_url('admin/twibbon/saveSetting') ?>" method="post">
        <?= csrf_field() ?>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
                <i class="fas fa-clock text-emerald-600"></i> Jadwal Pembersihan Otomatis
            </h3>
            <p class="text-xs text-gray-400 mb-6">File hasil twibbon dan file sementara akan dihapus otomatis berdasarkan durasi di bawah ini.</p>

            <div class="space-y-6">

                <!-- Toggle -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Pembersihan Otomatis</p>
                        <p class="text-xs text-gray-500 mt-0.5">Aktifkan atau nonaktifkan fungsi pembersihan file kadaluarsa.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="cleanup_enabled" value="0">
                        <input type="checkbox" name="cleanup_enabled" value="1" <?= ($settings['cleanup_enabled'] ?? 1) ? 'checked' : '' ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <!-- Durasi Hasil -->
                <div>
                    <label for="results_ttl_hours" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Durasi File Hasil <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">File hasil twibbon (folder <code>results/</code>) yang lebih tua dari durasi ini akan otomatis dihapus.</p>
                    <div class="relative max-w-xs">
                        <input type="number" name="results_ttl_hours" id="results_ttl_hours"
                            class="w-full border border-gray-300 rounded-lg pl-4 pr-12 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow <?= isset($errors['results_ttl_hours']) ? 'border-red-400 ring-1 ring-red-400' : '' ?>"
                            value="<?= old('results_ttl_hours', $settings['results_ttl_hours'] ?? 12) ?>" min="1" max="8759" required>
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium pointer-events-none">Jam</span>
                    </div>
                    <?php if (isset($errors['results_ttl_hours'])): ?>
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> <?= $errors['results_ttl_hours'] ?></p>
                    <?php endif; ?>
                </div>

                <!-- Durasi Temp -->
                <div>
                    <label for="temp_ttl_hours" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Durasi File Sementara <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">File foto sementara (folder <code>temp/</code>) yang lebih tua dari durasi ini akan otomatis dihapus.</p>
                    <div class="relative max-w-xs">
                        <input type="number" name="temp_ttl_hours" id="temp_ttl_hours"
                            class="w-full border border-gray-300 rounded-lg pl-4 pr-12 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-shadow <?= isset($errors['temp_ttl_hours']) ? 'border-red-400 ring-1 ring-red-400' : '' ?>"
                            value="<?= old('temp_ttl_hours', $settings['temp_ttl_hours'] ?? 1) ?>" min="1" max="8759" required>
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium pointer-events-none">Jam</span>
                    </div>
                    <?php if (isset($errors['temp_ttl_hours'])): ?>
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> <?= $errors['temp_ttl_hours'] ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>

    <!-- Aksi Manual -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
            <i class="fas fa-tools text-emerald-600"></i> Aksi Manual
        </h3>
        <p class="text-xs text-gray-400 mb-5">Jalankan pembersihan atau unduh semua file hasil twibbon secara langsung.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <form action="<?= base_url('admin/twibbon/cleanup') ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" onclick="return confirm('Hapus semua file yang sudah kadaluarsa?')"
                    class="w-full border border-orange-300 bg-orange-50 hover:bg-orange-100 text-orange-700 font-semibold px-5 py-3.5 rounded-xl transition-colors text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-broom"></i> Hapus File Kadaluarsa Sekarang
                </button>
            </form>
            <a href="<?= base_url('admin/twibbon/download-zip') ?>"
                class="w-full border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold px-5 py-3.5 rounded-xl transition-colors text-sm flex items-center justify-center gap-2">
                <i class="fas fa-file-archive"></i> Download Semua File Hasil (ZIP)
            </a>
        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
            <div class="text-sm text-blue-800 space-y-2">
                <p class="font-semibold">Informasi Cron Job</p>
                <p class="text-xs leading-relaxed">
                    Untuk hosting tanpa akses cron panel, gunakan layanan gratis seperti
                    <a href="https://cron-job.org" target="_blank" class="underline font-medium">cron-job.org</a>
                    untuk menjadwalkan URL berikut setiap jam:
                </p>
                <pre class="bg-blue-100 rounded-lg px-3 py-2 text-xs font-mono overflow-x-auto whitespace-pre-wrap">php <?= ROOTPATH ?>spark twibbon:cleanup</pre>
                <p class="text-xs leading-relaxed">
                    Pembersihan juga berjalan secara otomatis (~5% kemungkinan) setiap kali ada pengunjung yang berhasil mengunduh twibbon.
                </p>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>