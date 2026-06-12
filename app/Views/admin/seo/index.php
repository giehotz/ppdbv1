<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan SEO
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<i class="fas fa-search mr-2 text-green-600"></i> Pengaturan SEO Google
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- SEO Score / Info Banner -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-6 text-white">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="bg-white/20 rounded-full p-3">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold">Optimalisasi SEO Google</h2>
                <p class="text-blue-100 text-sm mt-1">Kelola metadata agar website Anda lebih mudah ditemukan di mesin pencari Google.</p>
            </div>
        </div>
        <a href="https://search.google.com/search-console" target="_blank" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shrink-0">
            <i class="fab fa-google"></i> Google Search Console
            <i class="fas fa-external-link-alt text-xs"></i>
        </a>
    </div>
</div>

<form action="<?= base_url('admin/seo/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card 1: Identitas Situs -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                <i class="fas fa-globe text-blue-500"></i>
                <h3 class="text-lg font-medium text-gray-900">Identitas Situs</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Situs / Brand</label>
                    <input type="text" name="site_name" value="<?= esc($seo['site_name'] ?? '') ?>" placeholder="Misal: PPDB MIN 2 Tanggamus" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                    <p class="mt-1 text-xs text-gray-500">Nama yang akan ditampilkan di hasil pencarian Google.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akhiran Judul Halaman (Title Suffix)</label>
                    <input type="text" name="meta_title_suffix" value="<?= esc($seo['meta_title_suffix'] ?? '') ?>" placeholder="Misal: | PPDB MIN 2 Tanggamus" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                    <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
                        <i class="fas fa-info-circle mr-1"></i> Teks ini akan ditambahkan di akhir judul setiap halaman. <br>
                        <strong>Contoh hasil:</strong> "Pendaftaran Siswa Baru <?= esc($seo['meta_title_suffix'] ?? '| PPDB MIN 2 Tanggamus') ?>"
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 2: Meta Description & Keywords -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                <i class="fas fa-tags text-green-500"></i>
                <h3 class="text-lg font-medium text-gray-900">Metadata Mesin Pencari</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Global (Meta Description)</label>
                    <textarea name="meta_description" rows="4" placeholder="Deskripsi singkat untuk mesin pencari (maks 160 karakter)..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border" maxlength="300"><?= esc($seo['meta_description'] ?? '') ?></textarea>
                    <div class="flex justify-between mt-1">
                        <p class="text-xs text-gray-500">Deskripsi ini akan muncul di bawah judul pada hasil pencarian Google.</p>
                        <span class="text-xs text-gray-400" id="desc-counter">0/160</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci (Meta Keywords)</label>
                    <input type="text" name="meta_keywords" value="<?= esc($seo['meta_keywords'] ?? '') ?>" placeholder="Pisahkan koma, misal: PPDB, pendaftaran, MIN 2 Tanggamus" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                    <p class="mt-1 text-xs text-gray-500">Kata kunci utama yang relevan dengan website Anda.</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Open Graph (Social Media) -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                <i class="fas fa-share-alt text-purple-500"></i>
                <h3 class="text-lg font-medium text-gray-900">Open Graph (Media Sosial)</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar untuk Share Media Sosial</label>
                    <p class="text-xs text-gray-500 mb-3">Gambar ini akan muncul saat link website di-share ke Facebook, WhatsApp, dll.</p>

                    <?php if (!empty($seo['og_image'])): ?>
                        <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs font-medium text-gray-500 mb-2">Gambar saat ini:</p>
                            <img src="<?= base_url('uploads/seo/' . $seo['og_image']) ?>" alt="OG Image Preview" class="max-h-40 rounded-lg shadow-sm border">
                        </div>
                    <?php else: ?>
                        <div class="mb-3 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 text-center">
                            <i class="fas fa-image text-3xl text-gray-300 mb-2"></i>
                            <p class="text-xs text-gray-400">Belum ada gambar. Upload gambar untuk tampilan yang lebih menarik saat di-share.</p>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="og_image" accept="image/jpeg,image/png,image/webp" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border text-sm">
                    <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
                        <i class="fas fa-info-circle mr-1"></i> Rekomendasi ukuran: <strong>1200 x 630 piksel</strong> (rasio 1.91:1). Format: JPG, PNG, atau WebP. Maks 2MB.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 4: Google Analytics -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                <i class="fab fa-google text-red-500"></i>
                <h3 class="text-lg font-medium text-gray-900">Google Analytics</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Measurement ID / Tracking ID</label>
                    <input type="text" name="google_analytics" value="<?= esc($seo['google_analytics'] ?? '') ?>" placeholder="Misal: G-XXXXXXXXXX atau UA-XXXXXXXXX-X" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                    <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
                        <i class="fas fa-info-circle mr-1"></i> Dapatkan ID ini dari <a href="https://analytics.google.com/" target="_blank" class="underline font-semibold">Google Analytics</a>. Kosongkan jika belum memiliki akun.
                    </p>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-lightbulb text-amber-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-amber-800">Tips SEO</p>
                            <ul class="text-xs text-amber-700 mt-1 space-y-1 list-disc list-inside">
                                <li>Pastikan deskripsi mengandung kata kunci utama</li>
                                <li>Gunakan gambar OG berkualitas tinggi untuk share sosial media</li>
                                <li>Daftarkan website ke <a href="https://search.google.com/search-console" target="_blank" class="underline font-semibold">Google Search Console</a></li>
                                <li>Submit sitemap untuk mempercepat indexing</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Search Preview -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                <i class="fab fa-google text-blue-500"></i>
                <h3 class="text-lg font-medium text-gray-900">Pratinjau Hasil Pencarian Google</h3>
            </div>
            <div class="p-6">
                <div class="max-w-2xl border border-gray-200 rounded-lg p-5 bg-white">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-globe text-green-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600" id="preview-url">https://ppdb.min2tanggamus.sch.id</p>
                        </div>
                    </div>
                    <h3 class="text-xl text-blue-700 hover:underline cursor-pointer font-medium" id="preview-title">
                        <?= esc($seo['site_name'] ?? 'PPDB MIN 2 Tanggamus') ?><?= esc($seo['meta_title_suffix'] ?? '') ?>
                    </h3>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed" id="preview-desc">
                        <?= esc($seo['meta_description'] ?? 'Deskripsi website Anda akan muncul di sini...') ?>
                    </p>
                </div>
                <p class="mt-3 text-xs text-gray-400"><i class="fas fa-eye mr-1"></i> Ini hanyalah simulasi. Tampilan sebenarnya di Google bisa berbeda.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="lg:col-span-2 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow transition duration-200 flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Pengaturan SEO
            </button>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Character counter for meta description
    const descField = document.querySelector('textarea[name="meta_description"]');
    const descCounter = document.getElementById('desc-counter');
    const previewDesc = document.getElementById('preview-desc');
    const previewTitle = document.getElementById('preview-title');

    function updateCounter() {
        const len = descField.value.length;
        descCounter.textContent = len + '/160';
        descCounter.className = len > 160 ? 'text-xs text-red-500 font-bold' : 'text-xs text-gray-400';
        previewDesc.textContent = descField.value || 'Deskripsi website Anda akan muncul di sini...';
    }

    descField.addEventListener('input', updateCounter);
    updateCounter();

    // Live preview for title
    const siteNameField = document.querySelector('input[name="site_name"]');
    const suffixField = document.querySelector('input[name="meta_title_suffix"]');

    function updateTitlePreview() {
        const siteName = siteNameField.value || 'Nama Situs';
        const suffix = suffixField.value || '';
        previewTitle.textContent = siteName + suffix;
    }

    siteNameField.addEventListener('input', updateTitlePreview);
    suffixField.addEventListener('input', updateTitlePreview);
</script>
<?= $this->endSection() ?>
