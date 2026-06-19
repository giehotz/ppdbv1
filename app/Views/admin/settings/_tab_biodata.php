<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-secondary">fact_check</span>
        <h3 class="text-lg font-bold text-on-surface">Wajib Kelengkapan Biodata</h3>
    </div>
    <div class="p-6">
        <div class="flex items-start justify-between gap-6">
            <div class="flex-1">
                <p class="text-sm font-bold text-on-surface">Paksa Siswa Mengisi Biodata Hingga 100%</p>
                <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
                    Jika <b>diaktifkan</b>, siswa yang baru mendaftar tidak akan bisa mengakses Dashboard dan menu lainnya
                    sebelum seluruh kolom wajib di formulir biodata terisi penuh (100%).
                    Siswa akan menerima popup peringatan dan diarahkan paksa ke halaman biodata.
                </p>
            </div>
            <div class="flex-shrink-0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="wajib_biodata_100" value="0">
                    <input type="checkbox" name="wajib_biodata_100" value="1" <?= ($web['wajib_biodata_100'] ?? 1) == 1 ? 'checked' : '' ?> class="sr-only peer" id="toggleWajibBiodata">
                    <div class="w-14 h-7 bg-outline-variant rounded-full peer-checked:bg-secondary after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-7 peer-focus:ring-2 peer-focus:ring-secondary/30"></div>
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

<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">comment</span>
        <h3 class="text-lg font-bold text-on-surface">Kustomisasi Pesan Popup</h3>
    </div>
    <div class="p-6 space-y-6">

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-bold text-on-surface">
                    <span class="material-symbols-outlined text-primary text-base align-middle mr-1">waving_hand</span>
                    Pesan Popup Selamat Datang
                </label>
                <button type="button" onclick="resetWelcome()" class="text-xs font-semibold text-primary hover:text-primary-container hover:underline transition">
                    <span class="material-symbols-outlined text-sm align-middle">undo</span>
                    Reset ke Default
                </button>
            </div>
            <p class="text-xs text-on-surface-variant mb-2">Pesan ini muncul <b>satu kali</b> saat siswa pertama kali masuk ke halaman biodata (setelah login).</p>
            <textarea name="popup_biodata_welcome" id="popupWelcomeText" rows="4"
                      class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWelcome) ?></textarea>
            <div class="mt-2 p-3 bg-surface-container-low rounded-lg border border-surface-variant">
                <p class="text-xs text-on-surface-variant flex items-start gap-1.5">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">info</span>
                    <span><b>Default:</b> <?= esc($defaultWelcome) ?></span>
                </p>
            </div>
        </div>

        <hr class="border-surface-variant">

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-bold text-on-surface">
                    <span class="material-symbols-outlined text-secondary text-base align-middle mr-1">warning</span>
                    Pesan Popup Akses Ditolak
                </label>
                <button type="button" onclick="resetWarning()" class="text-xs font-semibold text-secondary hover:text-secondary-fixed hover:underline transition">
                    <span class="material-symbols-outlined text-sm align-middle">undo</span>
                    Reset ke Default
                </button>
            </div>
            <p class="text-xs text-on-surface-variant mb-2">Pesan ini muncul <b>setiap kali</b> siswa mencoba mengakses menu lain (Dashboard, Berkas, dll) saat biodata belum 100%.</p>
            <textarea name="popup_biodata_warning" id="popupWarningText" rows="4"
                      class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none transition-all" placeholder="Kosongkan untuk menggunakan pesan default..."><?= esc($currentWarning) ?></textarea>
            <div class="mt-2 p-3 bg-surface-container-low rounded-lg border border-surface-variant">
                <p class="text-xs text-on-surface-variant flex items-start gap-1.5">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">info</span>
                    <span><b>Default:</b> <?= esc($defaultWarning) ?></span>
                </p>
            </div>
        </div>

    </div>
</div>

<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-tertiary">psychology</span>
        <h3 class="text-lg font-bold text-on-surface">Cara Kerja Mekanisme Ini</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-surface-container-low rounded-xl p-5 border border-surface-variant">
                <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm mb-3">1</div>
                <p class="text-sm font-bold text-on-surface mb-1">Siswa Login / Mendaftar</p>
                <p class="text-xs text-on-surface-variant">Siswa baru masuk ke sistem setelah berhasil mendaftar atau login.</p>
            </div>
            <div class="bg-surface-container-low rounded-xl p-5 border border-surface-variant">
                <div class="w-9 h-9 rounded-full bg-secondary/10 flex items-center justify-center text-secondary font-bold text-sm mb-3">2</div>
                <p class="text-sm font-bold text-on-surface mb-1">Sistem Mengecek Kelengkapan Biodata</p>
                <p class="text-xs text-on-surface-variant">Setiap kali siswa mengakses halaman apapun, sistem akan menghitung persentase pengisian biodata dari 15 kolom wajib.</p>
            </div>
            <div class="bg-surface-container-low rounded-xl p-5 border border-surface-variant">
                <div class="w-9 h-9 rounded-full bg-error/10 flex items-center justify-center text-error font-bold text-sm mb-3">3</div>
                <p class="text-sm font-bold text-on-surface mb-1">Jika Belum 100% → Akses Ditolak</p>
                <p class="text-xs text-on-surface-variant">Siswa akan melihat popup peringatan dan diarahkan paksa ke halaman biodata.</p>
            </div>
            <div class="bg-surface-container-low rounded-xl p-5 border border-surface-variant">
                <div class="w-9 h-9 rounded-full bg-tertiary/10 flex items-center justify-center text-tertiary font-bold text-sm mb-3">4</div>
                <p class="text-sm font-bold text-on-surface mb-1">Jika Sudah 100% → Akses Terbuka</p>
                <p class="text-xs text-on-surface-variant">Setelah semua kolom wajib terisi, siswa dapat mengakses seluruh fitur sistem secara normal.</p>
            </div>
        </div>

        <div class="mt-5 p-4 bg-tertiary-container/20 rounded-xl border border-tertiary/10 flex items-start gap-3">
            <span class="material-symbols-outlined text-tertiary text-xl flex-shrink-0">lightbulb</span>
            <p class="text-xs text-tertiary leading-relaxed">
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
                info.className = 'mt-4 p-4 rounded-xl border text-xs leading-relaxed bg-secondary/10 border-secondary/20 text-secondary font-semibold flex items-center gap-2';
                info.innerHTML = '<span class="material-symbols-outlined text-lg">lock</span> <b>Aktif</b> — Siswa tidak bisa mengakses menu manapun sebelum biodata 100% lengkap. Popup peringatan akan ditampilkan.';
            } else {
                info.className = 'mt-4 p-4 rounded-xl border text-xs leading-relaxed bg-surface-container-low border-surface-variant text-on-surface-variant font-semibold flex items-center gap-2';
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
