<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan SEO Google
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">travel_explore</span> Pengaturan SEO Google
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Info Banner Card -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-2xl">troubleshoot</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Optimalisasi Mesin Pencari (SEO Google)</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola metadata, pratinjau indeks pencarian, dan tautan sosial media agar website mudah ditemukan di Google.</p>
            </div>
        </div>
        <a href="https://search.google.com/search-console" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition shrink-0 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base text-brand-500">query_stats</span>
            <span>Google Search Console</span>
            <span class="material-symbols-outlined text-xs">open_in_new</span>
        </a>
    </div>
</div>

<form action="<?= base_url('admin/seo/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card 1: Identitas Situs -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <span class="material-symbols-outlined text-lg">language</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Identitas Situs & Judul Halaman</h4>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Nama Situs / Brand Utama
                    </label>
                    <input type="text" name="site_name" id="siteNameField" value="<?= esc($seo['site_name'] ?? '') ?>"
                           placeholder="Contoh: PPDB MIN 2 Tanggamus"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    <p class="mt-1 text-[11px] text-gray-400">Nama resmi institusi atau aplikasi yang ditampilkan di hasil pencarian.</p>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Akhiran Judul Halaman (Title Suffix)
                    </label>
                    <input type="text" name="meta_title_suffix" id="suffixField" value="<?= esc($seo['meta_title_suffix'] ?? '') ?>"
                           placeholder="Contoh: | PPDB MIN 2 Tanggamus"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    <div class="mt-2.5 p-3 rounded-xl bg-blue-50/60 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 text-xs text-blue-700 dark:text-blue-300 flex items-start gap-2">
                        <span class="material-symbols-outlined text-base shrink-0 mt-0.5">info</span>
                        <div>
                            Teks ini ditambahkan otomatis di akhir judul setiap tab browser.<br>
                            <span class="font-semibold">Contoh:</span> "Pendaftaran Siswa Baru <?= esc($seo['meta_title_suffix'] ?? '| PPDB MIN 2 Tanggamus') ?>"
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Meta Description & Keywords -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-lg">description</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Deskripsi Global & Kata Kunci</h4>
            </div>

            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Meta Description (Deskripsi Cuplikan)
                        </label>
                        <span class="text-[11px] font-mono text-gray-400" id="desc-counter">0/160</span>
                    </div>
                    <textarea name="meta_description" id="descField" rows="4" maxlength="300"
                              placeholder="Deskripsi singkat mengenai pendaftaran peserta didik baru (disarankan 120-160 karakter)..."
                              class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none leading-relaxed"><?= esc($seo['meta_description'] ?? '') ?></textarea>
                    <p class="mt-1 text-[11px] text-gray-400">Cuplikan teks ringkas yang muncul tepat di bawah judul di Google SERP.</p>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Meta Keywords (Kata Kunci)
                    </label>
                    <input type="text" name="meta_keywords" value="<?= esc($seo['meta_keywords'] ?? '') ?>"
                           placeholder="Contoh: PPDB, pendaftaran siswa, MIN 2 Tanggamus, madrasah ibtidaiyah"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    <p class="mt-1 text-[11px] text-gray-400">Pisahkan beberapa kata kunci dengan tanda koma.</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Open Graph (Social Media) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    <span class="material-symbols-outlined text-lg">share</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Open Graph (Thumbnail Berbagi Medsos)</h4>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Banner / Gambar OG Share
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Gambar ini muncul otomatis saat tautan website dibagikan ke WhatsApp, Facebook, Twitter/X, atau Telegram.</p>

                    <?php if (!empty($seo['og_image'])): ?>
                        <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Gambar Saat Ini:</span>
                            <img src="<?= base_url('uploads/seo/' . $seo['og_image']) ?>" alt="OG Image Preview" class="max-h-40 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 object-cover">
                        </div>
                    <?php else: ?>
                        <div class="mb-3 p-6 bg-gray-50/60 dark:bg-gray-800/40 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
                            <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-600 block mb-1">image</span>
                            <p class="text-xs text-gray-400">Belum ada gambar thumbnail share sosial media.</p>
                        </div>
                    <?php endif; ?>

                    <input type="file" name="og_image" accept="image/jpeg,image/png,image/webp"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                    <p class="mt-2 text-[11px] text-gray-400">Rekomendasi rasio 1.91:1 (1200 &times; 630 px). Format: JPG, PNG, atau WebP (Maks 2MB).</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Google Analytics & Tips -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                    <span class="material-symbols-outlined text-lg">analytics</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Google Analytics & Rekomendasi</h4>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Measurement ID (Google Analytics 4)
                    </label>
                    <input type="text" name="google_analytics" value="<?= esc($seo['google_analytics'] ?? '') ?>"
                           placeholder="Contoh: G-XXXXXXXXXX"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none font-mono">
                    <p class="mt-1 text-[11px] text-gray-400">Dapatkan ID Pengukuran dari Dashboard Google Analytics properti Anda.</p>
                </div>

                <div class="p-4 rounded-xl bg-amber-50/60 dark:bg-amber-500/10 border border-amber-200/70 dark:border-amber-500/20 text-xs text-amber-900 dark:text-amber-300">
                    <div class="flex items-center gap-2 font-bold mb-1.5">
                        <span class="material-symbols-outlined text-base text-amber-600 dark:text-amber-400">tips_and_updates</span>
                        <span>Panduan Praktis SEO Madrasah:</span>
                    </div>
                    <ul class="space-y-1 list-disc list-inside text-amber-800/90 dark:text-amber-300/90 text-[11px] leading-relaxed">
                        <li>Sertakan nama daerah/kecamatan pada judul agar mudah dicari warga sekitar.</li>
                        <li>Pastikan tautan sitemap disubmit ke Google Search Console untuk indexing kilat.</li>
                        <li>Gunakan kata kunci yang paling sering diketik orang tua calon siswa baru.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Google SERP Live Preview -->
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-lg">preview</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Simulasi Tampilan di Hasil Pencarian Google</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pratinjau langsung bagaimana situs Anda muncul di halaman Google Search</p>
                </div>
            </div>

            <!-- SERP Container Box -->
            <div class="max-w-2xl rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/60 p-5">
                <div class="flex items-center gap-2.5 mb-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-brand-600 text-xs shadow-theme-xs">
                        <span class="material-symbols-outlined text-sm">globe</span>
                    </div>
                    <div>
                        <p class="text-xs font-mono text-gray-700 dark:text-gray-300"><?= base_url() ?></p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">ppdb &rsaquo; penerimaan-siswa-baru</p>
                    </div>
                </div>
                <h3 class="text-base md:text-lg text-blue-600 dark:text-blue-400 font-medium hover:underline cursor-pointer" id="preview-title">
                    <?= esc($seo['site_name'] ?? 'PPDB MIN 2 Tanggamus') ?><?= esc($seo['meta_title_suffix'] ?? '') ?>
                </h3>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-300 mt-1 leading-relaxed" id="preview-desc">
                    <?= esc($seo['meta_description'] ?? 'Deskripsi website Anda akan muncul di sini...') ?>
                </p>
            </div>
            <p class="mt-3 text-[11px] text-gray-400 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">info</span>
                <span>Tampilan di atas adalah simulasi visual. Hasil sesungguhnya ditentukan oleh algoritma mesin pencari Google.</span>
            </p>
        </div>

        <!-- Submit Button -->
        <div class="lg:col-span-2 flex justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-7 py-3 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">save</span>
                <span>Simpan Pengaturan SEO</span>
            </button>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const descField = document.getElementById('descField');
    const descCounter = document.getElementById('desc-counter');
    const previewDesc = document.getElementById('preview-desc');
    const previewTitle = document.getElementById('preview-title');
    const siteNameField = document.getElementById('siteNameField');
    const suffixField = document.getElementById('suffixField');

    function updateCounter() {
        if (!descField || !descCounter || !previewDesc) return;
        const len = descField.value.length;
        descCounter.textContent = len + '/160';
        descCounter.className = len > 160 ? 'text-[11px] font-mono text-amber-500 font-bold' : 'text-[11px] font-mono text-gray-400';
        previewDesc.textContent = descField.value || 'Deskripsi website Anda akan muncul di sini...';
    }

    function updateTitlePreview() {
        if (!siteNameField || !suffixField || !previewTitle) return;
        const siteName = siteNameField.value || 'Nama Situs';
        const suffix = suffixField.value || '';
        previewTitle.textContent = siteName + suffix;
    }

    if (descField) descField.addEventListener('input', updateCounter);
    if (siteNameField) siteNameField.addEventListener('input', updateTitlePreview);
    if (suffixField) suffixField.addEventListener('input', updateTitlePreview);

    updateCounter();
    updateTitlePreview();
</script>
<?= $this->endSection() ?>
