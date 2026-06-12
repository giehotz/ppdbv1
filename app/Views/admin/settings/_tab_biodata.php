<!-- Card: Wajib Kelengkapan Biodata 100% -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
        <i class="fas fa-clipboard-check text-amber-500"></i>
        <h3 class="text-lg font-medium text-gray-900">Wajib Kelengkapan Biodata</h3>
    </div>
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div class="pr-4">
                <p class="text-sm font-medium text-gray-800">Paksa Siswa Mengisi Biodata Hingga 100%</p>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    Jika <b>diaktifkan</b>, siswa yang baru mendaftar tidak akan bisa mengakses Dashboard dan menu lainnya 
                    sebelum seluruh kolom wajib di formulir biodata terisi penuh (100%). 
                    Siswa akan menerima popup peringatan dan diarahkan paksa ke halaman biodata.
                </p>
            </div>
            <div class="flex-shrink-0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="wajib_biodata_100" value="0">
                    <input type="checkbox" name="wajib_biodata_100" value="1" <?= ($web['wajib_biodata_100'] ?? 1) == 1 ? 'checked' : '' ?> class="sr-only peer" id="toggleWajibBiodata">
                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-amber-500"></div>
                </label>
            </div>
        </div>
        <div class="mt-4 p-3 rounded-lg border text-xs leading-relaxed" id="statusInfoWajibBiodata">
        </div>
    </div>
</div>

<?php
// Default messages
$defaultWelcome = 'Untuk dapat mengakses Dashboard dan seluruh fitur sistem, Anda wajib melengkapi formulir biodata hingga 100% terlebih dahulu. Silakan isi setiap tab formulir di bawah secara lengkap. Data Anda akan tersimpan otomatis saat Anda mengetik.';
$defaultWarning = 'Anda belum dapat mengakses menu tersebut karena data biodata Anda belum lengkap. Silakan lengkapi seluruh kolom wajib di formulir ini hingga mencapai 100%, lalu Anda akan otomatis dapat mengakses Dashboard dan fitur lainnya.';

$currentWelcome = $web['popup_biodata_welcome'] ?? '';
$currentWarning = $web['popup_biodata_warning'] ?? '';
?>

<!-- Card: Kustomisasi Pesan Popup -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
        <i class="fas fa-comment-dots text-indigo-500"></i>
        <h3 class="text-lg font-medium text-gray-900">Kustomisasi Pesan Popup</h3>
    </div>
    <div class="p-6 space-y-6">

        <!-- Popup Selamat Datang -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-800">
                    <i class="fas fa-hand-sparkles text-blue-500 mr-1"></i> Pesan Popup Selamat Datang
                </label>
                <button type="button" onclick="resetWelcome()" class="text-xs text-blue-600 hover:text-blue-800 hover:underline transition">
                    <i class="fas fa-undo mr-1"></i>Reset ke Default
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-2">Pesan ini muncul <b>satu kali</b> saat siswa pertama kali masuk ke halaman biodata (setelah login).</p>
            <textarea name="popup_biodata_welcome" id="popupWelcomeText" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 border text-sm" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWelcome) ?></textarea>
            <div class="mt-2 p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-[11px] text-gray-500"><i class="fas fa-info-circle mr-1"></i> <b>Default:</b> <?= esc($defaultWelcome) ?></p>
            </div>
        </div>

        <hr class="border-gray-100">

        <!-- Popup Peringatan Akses Ditolak -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-800">
                    <i class="fas fa-exclamation-triangle text-amber-500 mr-1"></i> Pesan Popup Akses Ditolak
                </label>
                <button type="button" onclick="resetWarning()" class="text-xs text-amber-600 hover:text-amber-800 hover:underline transition">
                    <i class="fas fa-undo mr-1"></i>Reset ke Default
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-2">Pesan ini muncul <b>setiap kali</b> siswa mencoba mengakses menu lain (Dashboard, Berkas, dll) saat biodata belum 100%.</p>
            <textarea name="popup_biodata_warning" id="popupWarningText" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 py-2 px-3 border text-sm" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWarning) ?></textarea>
            <div class="mt-2 p-2.5 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-[11px] text-gray-500"><i class="fas fa-info-circle mr-1"></i> <b>Default:</b> <?= esc($defaultWarning) ?></p>
            </div>
        </div>

    </div>
</div>

<!-- Card: Penjelasan Mekanisme -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
        <i class="fas fa-info-circle text-blue-500"></i>
        <h3 class="text-lg font-medium text-gray-900">Cara Kerja Mekanisme Ini</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">1</div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Siswa Login / Mendaftar</p>
                    <p class="text-xs text-gray-500">Siswa baru masuk ke sistem setelah berhasil mendaftar atau login.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 font-bold text-sm">2</div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Sistem Mengecek Kelengkapan Biodata</p>
                    <p class="text-xs text-gray-500">Setiap kali siswa mengakses halaman apapun, sistem akan menghitung persentase pengisian biodata dari 15 kolom wajib (NISN, NIK, Nama, Alamat, dll).</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-sm">3</div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Jika Belum 100% → Akses Ditolak</p>
                    <p class="text-xs text-gray-500">Siswa akan melihat popup peringatan dan diarahkan paksa ke halaman biodata. Mereka tidak bisa membuka Dashboard, Berkas, Status, atau menu lainnya.</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-sm">4</div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Jika Sudah 100% → Akses Terbuka</p>
                    <p class="text-xs text-gray-500">Setelah semua kolom wajib terisi, siswa dapat mengakses seluruh fitur sistem secara normal.</p>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-800 leading-relaxed">
                <i class="fas fa-lightbulb mr-1 text-blue-500"></i>
                <b>Catatan:</b> Fitur auto-save akan menyimpan data siswa secara otomatis saat mereka mengetik, sehingga data tidak hilang meskipun siswa keluar sebelum selesai. Progress bar juga akan ditampilkan secara real-time di halaman biodata.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('toggleWajibBiodata');
        const info = document.getElementById('statusInfoWajibBiodata');
        
        function updateInfo() {
            if (toggle.checked) {
                info.className = 'mt-4 p-3 rounded-lg border text-xs leading-relaxed bg-amber-50 border-amber-200 text-amber-800';
                info.innerHTML = '<i class="fas fa-lock mr-1"></i> <b>Aktif</b> — Siswa tidak bisa mengakses menu manapun sebelum biodata 100% lengkap. Popup peringatan akan ditampilkan.';
            } else {
                info.className = 'mt-4 p-3 rounded-lg border text-xs leading-relaxed bg-gray-50 border-gray-200 text-gray-600';
                info.innerHTML = '<i class="fas fa-lock-open mr-1"></i> <b>Tidak Aktif</b> — Siswa bebas mengakses semua menu tanpa harus melengkapi biodata terlebih dahulu.';
            }
        }
        
        toggle.addEventListener('change', updateInfo);
        updateInfo();
    });

    function resetWelcome() {
        document.getElementById('popupWelcomeText').value = '';
    }

    function resetWarning() {
        document.getElementById('popupWarningText').value = '';
    }
</script>
