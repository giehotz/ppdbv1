<!-- Tab Content: Favicon -->
<div id="form-favicon" class="tab-content hidden p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Manajemen Favicon</h3>
            <p class="text-sm text-gray-500">Ganti icon kecil yang muncul di tab browser Anda.</p>
        </div>
        <div class="bg-blue-50 p-3 rounded-xl border border-blue-100 flex items-center space-x-3">
            <div class="text-xs font-bold text-blue-700 uppercase tracking-wider">Icon Saat Ini:</div>
            <div class="w-10 h-10 bg-white rounded-lg shadow-sm border border-gray-200 flex items-center justify-center overflow-hidden">
                <img src="<?= base_url('favicon.ico') ?>?v=<?= time() ?>" alt="Favicon" class="w-8 h-8 object-contain">
            </div>
        </div>
    </div>

    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8 rounded-r-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-amber-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-bold text-amber-900 mb-1">Catatan Penting:</h4>
                <ul class="text-sm text-amber-800 space-y-1">
                    <li>1. Format yang disarankan adalah <span class="font-bold">.ico</span> atau <span class="font-bold">.png</span> (transparan).</li>
                    <li>2. Ukuran ideal adalah <span class="font-bold">32x32</span> atau <span class="font-bold">48x48</span> pixel.</li>
                    <li>3. File baru akan menggantikan file <span class="font-mono text-xs bg-amber-100 px-1">public/favicon.ico</span> secara permanen.</li>
                    <li>4. Browser sering melakukan caching favicon sangat kuat. Jika tidak berubah, coba <span class="font-bold">Hard Refresh (CTRL+F5)</span>.</li>
                </ul>
            </div>
        </div>
    </div>

    <form action="<?= base_url('admin/landing-content/updateFavicon') ?>" method="post" enctype="multipart/form-data" class="max-w-2xl">
        <?= csrf_field() ?>
        
        <div class="bg-white border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-colors cursor-pointer" onclick="document.getElementById('favicon-input').click()">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-upload text-2xl"></i>
            </div>
            <h4 class="text-gray-800 font-bold mb-1">Klik untuk pilih file Icon</h4>
            <p class="text-gray-500 text-sm mb-4">atau drag and drop file di sini</p>
            <input type="file" name="favicon" id="favicon-input" class="hidden" accept=".ico,.png,.jpg,.jpeg" onchange="previewFavicon(this)">
            
            <div id="favicon-preview-container" class="hidden mt-4 pt-4 border-t border-gray-100 flex flex-col items-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Preview Upload:</p>
                <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden">
                    <img id="favicon-preview-img" src="#" alt="Preview" class="w-12 h-12 object-contain">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-md shadow-blue-500/20 flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Favicon Baru
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
