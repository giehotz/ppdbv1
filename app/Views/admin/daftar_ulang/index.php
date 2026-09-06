<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kelola Daftar Ulang & Seragam<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">backpack</span> Kelola Daftar Ulang &amp; Pendataan Seragam
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .du-tab-btn.active-tab {
        background-color: #ffffff;
        color: #111827;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .dark .du-tab-btn.active-tab {
        background-color: #374151;
        color: #ffffff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Notification -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/40 dark:bg-emerald-950/20 flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl shrink-0">check_circle</span>
        <p class="text-xs sm:text-sm font-semibold text-emerald-800 dark:text-emerald-300">
            <?= session()->getFlashdata('success') ?>
        </p>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/40 dark:bg-red-950/20 flex items-center gap-3">
        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl shrink-0">error</span>
        <p class="text-xs sm:text-sm font-semibold text-red-800 dark:text-red-300">
            <?= session()->getFlashdata('error') ?>
        </p>
    </div>
<?php endif; ?>

<!-- Top Metrics Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-xl">school</span>
            </div>
            <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">Target</span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Siswa Lulus</span>
            <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white"><?= number_format($totalLulus) ?></h4>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-xl">how_to_reg</span>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Bersedia</span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Konfirmasi Daftar Ulang</span>
            <h4 class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400"><?= number_format($totalBersedia) ?></h4>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <span class="material-symbols-outlined text-xl">person_remove</span>
            </div>
            <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">Mundur</span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Mengundurkan Diri</span>
            <h4 class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400"><?= number_format($totalMundur) ?></h4>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <span class="material-symbols-outlined text-xl">pending_actions</span>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">Menunggu</span>
        </div>
        <div class="mt-4">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Belum Konfirmasi</span>
            <h4 class="mt-1 text-2xl font-bold text-amber-600 dark:text-amber-400"><?= number_format($totalBelum) ?></h4>
        </div>
    </div>
</div>

<!-- Tab Navigation Header -->
<div class="mb-6">
    <div class="flex flex-wrap gap-2 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-2xl" id="duTabs" role="tablist">
        <button class="du-tab-btn flex items-center gap-2 px-5 py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 active-tab shadow-sm" data-target="tab-pengaturan" type="button">
            <span class="material-symbols-outlined text-lg">tune</span>
            <span>1. Pengaturan Akses &amp; Visibilitas</span>
        </button>
        <button class="du-tab-btn flex items-center gap-2 px-5 py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" data-target="tab-form-seragam" type="button">
            <span class="material-symbols-outlined text-lg">apparel</span>
            <span>2. Form Ukuran Seragam (Fleksibel)</span>
        </button>
        <button class="du-tab-btn flex items-center gap-2 px-5 py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white" data-target="tab-rekap" type="button">
            <span class="material-symbols-outlined text-lg">fact_check</span>
            <span>3. Rekap Siswa Daftar Ulang</span>
        </button>
    </div>
</div>

<!-- TAB 1: PENGATURAN AKSES & VISIBILITAS -->
<div id="tab-pengaturan" class="du-tab-pane space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-3 pb-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-xl">settings</span>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">Pengaturan Akses Portal Daftar Ulang</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Atur status pembukaan pendaftaran ulang, batas waktu penutupan, dan visibilitas formulir seragam.</p>
            </div>
        </div>

        <form action="<?= base_url('admin/daftar-ulang/simpan-pengaturan') ?>" method="POST" class="mt-6 space-y-6">
            <?= csrf_field() ?>

            <!-- Switch Status Daftar Ulang -->
            <div class="flex items-start justify-between gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                <div>
                    <label class="block text-xs font-bold text-gray-900 dark:text-white">
                        Status Akses Pendaftaran Ulang (Buka / Tutup)
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Bila diaktifkan, calon siswa yang berstatus <strong>Lulus</strong> dapat mengakses dan mengisi formulir daftar ulang.
                    </p>
                </div>
                <label class="relative inline-flex cursor-pointer items-center shrink-0">
                    <input type="checkbox" name="daftar_ulang_aktif" value="1" class="peer sr-only" <?= (($web['daftar_ulang_aktif'] ?? '1') == '1') ? 'checked' : '' ?>>
                    <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-brand-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:border-gray-600 dark:bg-gray-700"></div>
                </label>
            </div>

            <!-- FITUR UTAMA: Switch Tampilkan / Sembunyikan Bagian 2 Ukuran Seragam -->
            <div class="flex items-start justify-between gap-4 p-4 rounded-xl border border-brand-100 bg-brand-50/40 dark:border-brand-900/40 dark:bg-brand-950/20">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-600 text-lg">apparel</span>
                        <label class="block text-xs font-bold text-gray-900 dark:text-white">
                            Tampilkan Bagian "2. Pendataan Ukuran Seragam" pada Portal Siswa
                        </label>
                        <span class="rounded-full bg-brand-200/70 px-2 py-0.5 text-[10px] font-extrabold text-brand-900 dark:bg-brand-800/40 dark:text-brand-300 uppercase">Fleksibel</span>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        • <strong>Jika Diaktifkan (ON):</strong> Portal siswa menampilkan Bagian 1 (Kesediaan) dan Bagian 2 (Pendataan Ukuran Seragam).<br>
                        • <strong>Jika Dinonaktifkan (OFF):</strong> Bagian 2 <u>disembunyikan sama sekali</u>. Siswa hanya mengisi konfirmasi kesediaan masuk sekolah (sangat cocok jika sekolah tidak menyediakan seragam).
                    </p>
                </div>
                <label class="relative inline-flex cursor-pointer items-center shrink-0">
                    <input type="checkbox" name="seragam_aktif" value="1" class="peer sr-only" <?= (($web['seragam_aktif'] ?? '1') == '1') ? 'checked' : '' ?>>
                    <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-emerald-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none dark:border-gray-600 dark:bg-gray-700"></div>
                </label>
            </div>

            <!-- Batas Waktu Penutupan -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Batas Waktu Penutupan Daftar Ulang (Opsional)
                </label>
                <?php 
                $valTgl = '';
                if (!empty($web['tgl_tutup_daftar_ulang']) && $web['tgl_tutup_daftar_ulang'] !== '0000-00-00 00:00:00') {
                    $valTgl = date('Y-m-d\TH:i', strtotime($web['tgl_tutup_daftar_ulang']));
                }
                ?>
                <input type="datetime-local" name="tgl_tutup_daftar_ulang" value="<?= $valTgl ?>"
                    class="w-full max-w-md rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <p class="text-[11px] text-gray-400">
                    Jika waktu saat ini melewati tanggal & jam di atas, akses pengisian formulir daftar ulang akan otomatis terkunci di akun siswa. Kosongkan jika tidak ada batas waktu.
                </p>
            </div>

            <!-- Pesan Pengumuman Siswa saat Ditutup -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pesan Pemberitahuan saat Akses Ditutup / Berakhir
                </label>
                <textarea name="pesan_daftar_ulang" rows="3" placeholder="Contoh: Pendaftaran ulang calon siswa baru tahun pelajaran 2026/2027 saat ini telah ditutup oleh panitia PPDB..."
                    class="w-full rounded-xl border border-gray-300 bg-white p-3 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"><?= esc($web['pesan_daftar_ulang'] ?? '') ?></textarea>
                <p class="text-[11px] text-gray-400">
                    Pesan ini akan ditampilkan dalam banner khusus di halaman calon siswa jika status nonaktif atau telah melewati batas waktu.
                </p>
            </div>

            <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pengaturan Akses</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TAB 2: FORM UKURAN SERAGAM FLEKSIBEL -->
<div id="tab-form-seragam" class="du-tab-pane hidden space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-xl">style</span>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">Kelola Item Formulir Ukuran Seragam</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Sesuaikan item seragam dengan fasilitas yang disediakan sekolah. Anda dapat menambah item baru, mengubah opsi pilihan, atau menghapus item yang tidak digunakan.
                    </p>
                </div>
            </div>

            <!-- Tombol Reset ke Default Standar -->
            <form action="<?= base_url('admin/daftar-ulang/reset-form-seragam') ?>" method="POST" onsubmit="return confirm('Kembalikan konfigurasi form seragam ke 4 standar bawaan (Baju, Celana, Peci, Sepatu)?')">
                <?= csrf_field() ?>
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <span class="material-symbols-outlined text-sm">restart_alt</span>
                    <span>Reset ke Standar Bawaan</span>
                </button>
            </form>
        </div>

        <form action="<?= base_url('admin/daftar-ulang/simpan-form-seragam') ?>" method="POST" class="mt-6 space-y-6">
            <?= csrf_field() ?>

            <!-- Repeater Container untuk Field Seragam -->
            <div class="space-y-3" id="seragamFieldsContainer">
                <?php foreach ($seragamFields as $index => $field): ?>
                    <div class="seragam-field-row rounded-xl border border-gray-200 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/30 transition-all space-y-3">
                        <div class="flex items-center justify-between gap-3 border-b border-gray-200/70 pb-2.5 dark:border-gray-700/60">
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-gray-400">drag_handle</span>
                                <span>Item Seragam #<span class="row-num"><?= $index + 1 ?></span></span>
                            </span>
                            <button type="button" onclick="removeFieldRow(this)" class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 hover:text-red-700 transition-colors">
                                <span class="material-symbols-outlined text-sm">delete</span> Hapus Item
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Label / Nama Item</label>
                                <input type="text" name="field_label[]" value="<?= esc($field['label']) ?>" placeholder="Misal: Ukuran Jilbab / Kerudung" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">ID Sistem / Kode (Otomatis)</label>
                                <input type="text" name="field_id[]" value="<?= esc($field['id']) ?>" placeholder="contoh: ukuran_jilbab"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 font-mono shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Tipe Formulir</label>
                                <select name="field_type[]" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <option value="select" <?= ($field['type'] ?? '') === 'select' ? 'selected' : '' ?>>Pilihan Dropdown</option>
                                    <option value="text" <?= ($field['type'] ?? '') === 'text' ? 'selected' : '' ?>>Isian Teks Bebas</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Wajib Diisi oleh Siswa?</label>
                                <select name="field_required[]" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <option value="1" <?= (!empty($field['required']) && $field['required'] == 1) ? 'selected' : '' ?>>Ya (Wajib Diisi)</option>
                                    <option value="0" <?= (empty($field['required'])) ? 'selected' : '' ?>>Tidak (Opsional)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">
                                Opsi Pilihan Ukuran (Pisahkan dengan koma <code class="text-brand-600">,</code> jika tipe Dropdown)
                            </label>
                            <input type="text" name="field_options[]" value="<?= esc($field['options'] ?? '') ?>" placeholder="Misal: S, M, L, XL, XXL, Custom"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Tombol Tambah Field Baru -->
            <div class="pt-2">
                <button type="button" onclick="addFieldRow()" class="inline-flex items-center gap-2 rounded-xl border-2 border-dashed border-gray-300 hover:border-brand-500 hover:text-brand-600 bg-white px-4 py-3 text-xs font-bold text-gray-700 w-full justify-center transition-all dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-300 dark:hover:border-brand-400">
                    <span class="material-symbols-outlined text-base">add_circle</span>
                    <span>Tambah Input Seragam Baru (Custom Item)</span>
                </button>
            </div>

            <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Struktur Form Seragam</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TAB 3: REKAP SISWA DAFTAR ULANG -->
<div id="tab-rekap" class="du-tab-pane hidden space-y-6">
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <!-- Filter Header -->
        <div class="border-b border-gray-100 p-5 dark:border-gray-800">
            <form action="<?= base_url('admin/daftar-ulang') ?>" method="get" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
                <div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Rekapitulasi Calon Siswa</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Status kesediaan masuk dan data ukuran seragam siswa lulus.</p>
                </div>

                <div class="flex-1"></div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Search -->
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined text-base">search</span>
                        </span>
                        <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari Nama/NISN..."
                            class="h-9 w-full rounded-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 sm:w-48">
                    </div>

                    <!-- Status Konfirmasi -->
                    <select name="status_konfirmasi" class="h-9 rounded-lg border border-gray-200 bg-gray-50/50 px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100">
                        <option value="">Semua Status</option>
                        <option value="bersedia" <?= ($statusKonfirmasi === 'bersedia') ? 'selected' : '' ?>>Bersedia Daftar Ulang</option>
                        <option value="mengundurkan_diri" <?= ($statusKonfirmasi === 'mengundurkan_diri') ? 'selected' : '' ?>>Mengundurkan Diri</option>
                        <option value="belum_konfirmasi" <?= ($statusKonfirmasi === 'belum_konfirmasi') ? 'selected' : '' ?>>Belum Konfirmasi</option>
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">filter_alt</span> Filter
                    </button>

                    <!-- Export Excel -->
                    <a href="<?= base_url('admin/daftar-ulang/export-excel?' . http_build_query(['th_pelajaran' => $selectedTh, 'status_konfirmasi' => $statusKonfirmasi, 'search' => $search])) ?>"
                       class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">download</span> Unduh Excel
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 bg-gray-50/50 dark:border-gray-800 dark:text-gray-500 dark:bg-gray-800/30">
                        <th class="py-3 px-4 text-center w-12">No</th>
                        <th class="py-3 px-4">Calon Siswa</th>
                        <th class="py-3 px-4">No. Pendaftaran</th>
                        <th class="py-3 px-4 text-center">Status Konfirmasi</th>
                        <?php if (($web['seragam_aktif'] ?? '1') == '1'): ?>
                            <th class="py-3 px-4">Rincian Ukuran Seragam</th>
                        <?php endif; ?>
                        <th class="py-3 px-4">Alasan / Catatan</th>
                        <th class="py-3 px-4 text-center">Tgl Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php if (!empty($rekapSiswa)): ?>
                        <?php $no = 1; foreach ($rekapSiswa as $s): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                                <td class="py-3 px-4 text-center text-gray-400 font-medium"><?= $no++ ?></td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-900 dark:text-white"><?= esc($s['nama_lengkap']) ?></div>
                                    <div class="text-[11px] text-gray-400 font-mono">NISN: <?= esc($s['nisn'] ?: '-') ?> | <?= esc($s['telepon'] ?: '-') ?></div>
                                </td>
                                <td class="py-3 px-4 font-mono font-bold text-gray-700 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <?php if (($s['status_konfirmasi'] ?? '') === 'bersedia'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                            <span class="material-symbols-outlined text-xs">how_to_reg</span> Bersedia
                                        </span>
                                    <?php elseif (($s['status_konfirmasi'] ?? '') === 'mengundurkan_diri'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                            <span class="material-symbols-outlined text-xs">close</span> Mundur
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-[11px] font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-xs">schedule</span> Belum Isi
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php if (($web['seragam_aktif'] ?? '1') == '1'): ?>
                                    <td class="py-3 px-4">
                                        <?php if (($s['status_konfirmasi'] ?? '') === 'bersedia'): ?>
                                            <?php 
                                            $answers = [];
                                            if (!empty($s['data_seragam'])) {
                                                $answers = json_decode($s['data_seragam'], true) ?: [];
                                            }
                                            ?>
                                            <div class="flex flex-wrap gap-1.5 max-w-xs">
                                                <?php foreach ($seragamFields as $sf): 
                                                    $val = $answers[$sf['id']] ?? $s[$sf['id']] ?? null;
                                                    if (!empty($val)):
                                                ?>
                                                    <span class="inline-block rounded-md bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                                        <?= esc($sf['label']) ?>: <strong><?= esc($val) ?></strong>
                                                    </span>
                                                <?php endif; endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-[11px]">-</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <td class="py-3 px-4">
                                    <?php if (($s['status_konfirmasi'] ?? '') === 'mengundurkan_diri' && !empty($s['alasan_mundur'])): ?>
                                        <span class="text-red-600 text-xs italic">"<?= esc($s['alasan_mundur']) ?>"</span>
                                    <?php elseif (!empty($s['catatan'])): ?>
                                        <span class="text-gray-600 dark:text-gray-300 text-xs"><?= esc($s['catatan']) ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center text-[11px] text-gray-400 whitespace-nowrap">
                                    <?= !empty($s['tgl_konfirmasi']) ? date('d/m/y H:i', strtotime($s['tgl_konfirmasi'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400 dark:text-gray-500">
                                <span class="material-symbols-outlined text-4xl block mb-1">person_search</span>
                                <span>Tidak ada data siswa ditemukan untuk filter ini.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Tab switching logic
    document.querySelectorAll('.du-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active style from all tab buttons
            document.querySelectorAll('.du-tab-btn').forEach(b => {
                b.classList.remove('active-tab', 'bg-white', 'text-gray-900', 'shadow-sm', 'dark:bg-gray-700', 'dark:text-white');
                b.classList.add('text-gray-600', 'dark:text-gray-400');
            });

            // Add active style to clicked tab
            this.classList.add('active-tab', 'bg-white', 'text-gray-900', 'shadow-sm', 'dark:bg-gray-700', 'dark:text-white');
            this.classList.remove('text-gray-600', 'dark:text-gray-400');

            // Switch content pane
            const target = this.dataset.target;
            document.querySelectorAll('.du-tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });
            const targetPane = document.getElementById(target);
            if (targetPane) {
                targetPane.classList.remove('hidden');
            }
        });
    });

    // Dynamic field repeater logic
    function addFieldRow() {
        const container = document.getElementById('seragamFieldsContainer');
        const count = container.querySelectorAll('.seragam-field-row').length + 1;

        const row = document.createElement('div');
        row.className = 'seragam-field-row rounded-xl border border-gray-200 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/30 transition-all space-y-3';
        row.innerHTML = `
            <div class="flex items-center justify-between gap-3 border-b border-gray-200/70 pb-2.5 dark:border-gray-700/60">
                <span class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm text-gray-400">drag_handle</span>
                    <span>Item Seragam #<span class="row-num">${count}</span></span>
                </span>
                <button type="button" onclick="removeFieldRow(this)" class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 hover:text-red-700 transition-colors">
                    <span class="material-symbols-outlined text-sm">delete</span> Hapus Item
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Label / Nama Item</label>
                    <input type="text" name="field_label[]" placeholder="Misal: Ukuran Jas Almamater" required
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">ID Sistem / Kode</label>
                    <input type="text" name="field_id[]" placeholder="contoh: jas_almamater"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 font-mono shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Tipe Formulir</label>
                    <select name="field_type[]" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="select">Pilihan Dropdown</option>
                        <option value="text">Isian Teks Bebas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Wajib Diisi?</label>
                    <select name="field_required[]" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="1">Ya (Wajib Diisi)</option>
                        <option value="0">Tidak (Opsional)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">
                    Opsi Pilihan Ukuran (Pisahkan dengan koma <code class="text-brand-600">,</code> jika tipe Dropdown)
                </label>
                <input type="text" name="field_options[]" placeholder="Misal: S, M, L, XL, XXL, Custom"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            </div>
        `;
        container.appendChild(row);
        updateRowNumbers();
    }

    function removeFieldRow(btn) {
        const container = document.getElementById('seragamFieldsContainer');
        const rows = container.querySelectorAll('.seragam-field-row');
        if (rows.length <= 1) {
            alert('Minimal harus menyisakan 1 item input seragam. Jika sekolah tidak menyediakan seragam sama sekali, silakan nonaktifkan Visibilitas Seragam pada Tab 1 (Pengaturan Akses).');
            return;
        }

        const row = btn.closest('.seragam-field-row');
        row.remove();
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll('.seragam-field-row');
        rows.forEach((r, idx) => {
            const numSpan = r.querySelector('.row-num');
            if (numSpan) numSpan.textContent = idx + 1;
        });
    }
</script>
<?= $this->endSection() ?>
