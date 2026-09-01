<!-- Tab Content: Favicon -->
<div id="form-favicon" class="tab-content hidden p-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Manajemen Favicon</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ganti icon kecil yang muncul di tab browser Anda.</p>
        </div>
        <div class="inline-flex items-center gap-3 rounded-xl border border-brand-100 dark:border-brand-500/20 bg-brand-50 dark:bg-brand-500/10 px-4 py-2.5">
            <span class="text-xs font-bold text-brand-700 dark:text-brand-400 uppercase tracking-wider">Icon Saat Ini:</span>
            <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-lg shadow-theme-xs border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                <img src="<?= base_url('favicon.ico') ?>?v=<?= time() ?>" alt="Favicon" class="w-8 h-8 object-contain">
            </div>
        </div>
    </div>

    <div class="rounded-xl border-l-4 border-amber-500 bg-amber-50 dark:bg-amber-950/30 p-4 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-amber-600 dark:text-amber-400 text-lg"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-bold text-amber-900 dark:text-amber-300 mb-1.5">Catatan Penting:</h4>
                <ul class="text-sm text-amber-800 dark:text-amber-200/80 space-y-1">
                    <li>1. Format yang disarankan adalah <span class="font-bold">.ico</span> atau <span class="font-bold">.png</span> (transparan).</li>
                    <li>2. Ukuran ideal adalah <span class="font-bold">32x32</span> atau <span class="font-bold">48x48</span> pixel.</li>
                    <li>3. File baru akan menggantikan file <code class="bg-amber-100 dark:bg-amber-900/50 px-1.5 py-0.5 rounded text-xs font-mono">public/favicon.ico</code> secara permanen.</li>
                    <li>4. Browser sering melakukan caching favicon sangat kuat. Jika tidak berubah, coba <span class="font-bold">Hard Refresh (CTRL+F5)</span>.</li>
                </ul>
            </div>
        </div>
    </div>

    <form action="<?= base_url('admin/landing-content/updateFavicon') ?>" method="post" enctype="multipart/form-data" class="max-w-2xl">
        <?= csrf_field() ?>
        
        <div class="rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-600 p-8 text-center hover:border-brand-500 dark:hover:border-brand-400 transition-colors cursor-pointer bg-white dark:bg-gray-900" onclick="document.getElementById('favicon-input').click()">
            <div class="w-16 h-16 bg-brand-50 dark:bg-brand-500/15 text-brand-500 dark:text-brand-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-upload text-2xl"></i>
            </div>
            <h4 class="text-gray-800 dark:text-gray-200 font-bold mb-1">Klik untuk pilih file Icon</h4>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">atau drag and drop file di sini</p>
            <input type="file" name="favicon" id="favicon-input" class="hidden" accept=".ico,.png,.jpg,.jpeg" onchange="previewFavicon(this)">
            
            <div id="favicon-preview-container" class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 flex flex-col items-center">
                <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Preview Upload:</p>
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                    <img id="favicon-preview-img" src="#" alt="Preview" class="w-12 h-12 object-contain">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-3 px-8 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
                <i class="fas fa-save"></i> Simpan Favicon Baru
            </button>
        </div>
    </form>
</div>

<script>
function previewFavicon(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('favicon-preview-img').src = e.target.result;
            document.getElementById('favicon-preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
