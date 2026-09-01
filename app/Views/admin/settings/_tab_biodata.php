<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">fact_check</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Wajib Kelengkapan Biodata</h3>
    </div>
    <div class="p-6">
        <div class="flex items-start justify-between gap-6">
            <div class="flex-1">
                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Paksa Siswa Mengisi Biodata Hingga 100%</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                    Jika <b>diaktifkan</b>, siswa yang baru mendaftar tidak akan bisa mengakses Dashboard dan menu lainnya
                    sebelum seluruh kolom wajib di formulir biodata terisi penuh (100%).
                    Siswa akan menerima popup peringatan dan diarahkan paksa ke halaman biodata.
                </p>
            </div>
            <div class="flex-shrink-0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="wajib_biodata_100" value="0">
                    <input type="checkbox" name="wajib_biodata_100" value="1" <?= ($web['wajib_biodata_100'] ?? 1) == 1 ? 'checked' : '' ?> class="sr-only peer" id="toggleWajibBiodata">
                    <div class="w-14 h-7 bg-gray-300 dark:bg-gray-600 rounded-full peer-checked:bg-brand-500 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-7 peer-focus:ring-2 peer-focus:ring-brand-500/30"></div>
                </label>
            </div>
        </div>
        <div class="mt-4 p-4 rounded-xl border text-xs leading-relaxed" id="statusInfoWajibBiodata"></div>
    </div>
</div>

<?php
$defaultWelcome = 'Untuk dapat mengakses Dashboard dan seluruh fitur sistem, Anda wajib melengkapi formulir biodata hingga 100% terlebih dahulu. Silakan isi setiap tab formulir di bawah secara lengkap. Data Anda akan tersimpan otomatis saat Anda mengetik.';
$defaultWarning = 'Anda belum dapat mengakses menu tersebut karena data biodata Anda belum lengkap. Silakan lengkapi seluruh kolom wajib di formulir ini hingga mencapai 100%, lalu Anda akan otomatis dapat mengakses Dashboard dan fitur lainnya.';

$currentWelcome = $web['popup_biodata_welcome'] ?? '';
$currentWarning = $web['popup_biodata_warning'] ?? '';
?>

<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">comment</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Kustomisasi Pesan Popup</h3>
    </div>
    <div class="p-6 space-y-6">

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">
                    <span class="material-symbols-outlined text-brand-500 text-base align-middle mr-1">waving_hand</span>
                    Pesan Popup Selamat Datang
                </label>
                <button type="button" onclick="resetWelcome()" class="text-xs font-semibold text-brand-500 hover:text-brand-600 hover:underline transition">
                    <span class="material-symbols-outlined text-sm align-middle">undo</span>
                    Reset ke Default
                </button>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Pesan ini muncul <b>satu kali</b> saat siswa pertama kali masuk ke halaman biodata (setelah login).</p>
            <textarea name="popup_biodata_welcome" id="popupWelcomeText" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWelcome) ?></textarea>
            <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-start gap-1.5">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">info</span>
                    <span><b>Default:</b> <?= esc($defaultWelcome) ?></span>
                </p>
            </div>
        </div>

        <hr class="border-gray-200 dark:border-gray-800">

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-bold text-gray-800 dark:text-gray-200">
                    <span class="material-symbols-outlined text-amber-500 text-base align-middle mr-1">warning</span>
                    Pesan Popup Akses Ditolak
                </label>
                <button type="button" onclick="resetWarning()" class="text-xs font-semibold text-amber-500 hover:text-amber-600 hover:underline transition">
                    <span class="material-symbols-outlined text-sm align-middle">undo</span>
                    Reset ke Default
                </button>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Pesan ini muncul <b>setiap kali</b> siswa mencoba mengakses menu lain (Dashboard, Berkas, dll) saat biodata belum 100%.</p>
            <textarea name="popup_biodata_warning" id="popupWarningText" rows="4"
                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-amber-300 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWarning) ?></textarea>
            <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-start gap-1.5">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">info</span>
                    <span><b>Default:</b> <?= esc($defaultWarning) ?></span>
                </p>
            </div>
        </div>

    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-amber-500">psychology</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Cara Kerja Mekanisme Ini</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                <div class="w-9 h-9 rounded-full bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center text-brand-500 dark:text-brand-400 font-bold text-sm mb-3">1</div>
                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Siswa Login / Mendaftar</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Siswa baru masuk ke sistem setelah berhasil mendaftar atau login.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                <div class="w-9 h-9 rounded-full bg-blue-50 dark:bg-blue-500/15 flex items-center justify-center text-blue-500 dark:text-blue-400 font-bold text-sm mb-3">2</div>
                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Sistem Mengecek Kelengkapan Biodata</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Setiap kali siswa mengakses halaman apapun, sistem akan menghitung persentase pengisian biodata dari 15 kolom wajib.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                <div class="w-9 h-9 rounded-full bg-red-50 dark:bg-red-500/15 flex items-center justify-center text-red-500 dark:text-red-400 font-bold text-sm mb-3">3</div>
                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Jika Belum 100% → Akses Ditolak</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Siswa akan melihat popup peringatan dan diarahkan paksa ke halaman biodata.</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                <div class="w-9 h-9 rounded-full bg-emerald-50 dark:bg-emerald-500/15 flex items-center justify-center text-emerald-500 dark:text-emerald-400 font-bold text-sm mb-3">4</div>
                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Jika Sudah 100% → Akses Terbuka</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Setelah semua kolom wajib terisi, siswa dapat mengakses seluruh fitur sistem secara normal.</p>
            </div>
        </div>

        <div class="mt-5 p-4 bg-amber-50 dark:bg-amber-500/10 rounded-xl border border-amber-200 dark:border-amber-500/20 flex items-start gap-3">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-xl flex-shrink-0">lightbulb</span>
            <p class="text-xs text-amber-700 dark:text-amber-300 leading-relaxed">
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
                info.className = 'mt-4 p-4 rounded-xl border text-xs leading-relaxed bg-brand-50 dark:bg-brand-500/10 border-brand-100 dark:border-brand-500/20 text-brand-500 dark:text-brand-400 font-semibold flex items-center gap-2';
                info.innerHTML = '<span class="material-symbols-outlined text-lg">lock</span> <b>Aktif</b> — Siswa tidak bisa mengakses menu manapun sebelum biodata 100% lengkap. Popup peringatan akan ditampilkan.';
            } else {
                info.className = 'mt-4 p-4 rounded-xl border text-xs leading-relaxed bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-semibold flex items-center gap-2';
                info.innerHTML = '<span class="material-symbols-outlined text-lg">lock_open</span> <b>Tidak Aktif</b> — Siswa bebas mengakses semua menu tanpa harus melengkapi biodata terlebih dahulu.';
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
