<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?><?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">campaign</span> <?= isset($pengumuman) ? 'Edit Pengumuman' : 'Tambah Pengumuman' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">campaign</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        <?= isset($pengumuman) ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' ?>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        <?= isset($pengumuman) ? 'Perbarui konten dan pengaturan publikasi pengumuman' : 'Publikasikan informasi penting untuk calon peserta didik' ?>
                    </p>
                </div>
            </div>
            <a href="<?= base_url('admin/pengumuman') ?>"
               class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>

        <form action="<?= isset($pengumuman) ? base_url('admin/pengumuman/update/' . $pengumuman['id_pengumuman']) : base_url('admin/pengumuman/store') ?>"
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="p-6 md:p-8 space-y-6">
                <!-- Section 1: Konten Utama -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-base">article</span>
                        Konten Pengumuman
                    </h4>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="<?= isset($pengumuman) ? esc($pengumuman['judul']) : '' ?>" required
                               placeholder="Contoh: Jadwal Pelaksanaan Ujian Masuk & Verifikasi Berkas"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Isi Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi_pengumuman" id="isi_pengumuman" rows="8" required
                                  class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs outline-none"><?= isset($pengumuman) ? esc($pengumuman['isi_pengumuman']) : '' ?></textarea>
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-gray-800">

                <!-- Section 2: Kategori & Target Audiens -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-base">tune</span>
                        Kategori & Pengaturan Publikasi
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Kategori / Tipe <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe" required
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="general" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'general') ? 'selected' : '' ?>>General (Informasi Umum)</option>
                                <option value="ujian" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'ujian') ? 'selected' : '' ?>>Ujian (Jadwal / Tes)</option>
                                <option value="kelulusan" <?= (isset($pengumuman) && $pengumuman['tipe'] == 'kelulusan') ? 'selected' : '' ?>>Kelulusan (Hasil Seleksi)</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Target Sasaran Siswa <span class="text-red-500">*</span>
                            </label>
                            <select name="target_audience" required
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                                <option value="">-- Pilih Target Sasaran --</option>
                                <option value="all" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'all') ? 'selected' : '' ?>>Semua Siswa Terdaftar</option>
                                <option value="verified" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'verified') ? 'selected' : '' ?>>Hanya Siswa Terverifikasi</option>
                                <option value="lulus" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'lulus') ? 'selected' : '' ?>>Hanya Siswa Dinyatakan Lulus</option>
                                <option value="rejected" <?= (isset($pengumuman) && $pengumuman['target_audience'] == 'rejected') ? 'selected' : '' ?>>Hanya Siswa Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                Jadwal Waktu Publish
                            </label>
                            <input type="datetime-local" name="publish_date"
                                   value="<?= isset($pengumuman) && $pengumuman['publish_date'] ? date('Y-m-d\TH:i', strtotime($pengumuman['publish_date'])) : '' ?>"
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                            <p class="mt-1 text-[11px] text-gray-400">Kosongkan jika ingin pengumuman langsung tayang saat disimpan.</p>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                File Lampiran (Opsional)
                            </label>
                            <input type="file" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                   class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
                            <?php if (isset($pengumuman) && $pengumuman['lampiran']): ?>
                                <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                                    File aktif: <span class="font-mono font-bold text-gray-800 dark:text-gray-200"><?= esc($pengumuman['lampiran']) ?></span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-gray-800">

                <!-- Section 3: Opsi Tampilan & Popup -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-500 text-base">visibility</span>
                        Opsi Tampilan & Notifikasi Popup
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 hover:border-brand-300 cursor-pointer transition">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   <?= (isset($pengumuman) && $pengumuman['is_active']) || !isset($pengumuman) ? 'checked' : '' ?>
                                   class="h-5 w-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                            <div>
                                <span class="text-xs font-bold text-gray-900 dark:text-white block">Aktifkan Pengumuman</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">Pengumuman dapat dilihat oleh siswa</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 hover:border-brand-300 cursor-pointer transition">
                            <input type="checkbox" name="is_popup" id="is_popup" value="1"
                                   <?= (isset($pengumuman) && $pengumuman['is_popup']) ? 'checked' : '' ?>
                                   class="h-5 w-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                            <div>
                                <span class="text-xs font-bold text-gray-900 dark:text-white block">Tampilkan Sebagai Popup Dialog</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">Otomatis muncul saat siswa login</span>
                            </div>
                        </label>
                    </div>

                    <div id="countdown_wrapper" class="<?= (isset($pengumuman) && $pengumuman['is_popup']) ? '' : 'hidden' ?> p-4 rounded-2xl border border-brand-100 dark:border-brand-500/20 bg-brand-50/50 dark:bg-brand-500/10">
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-brand-900 dark:text-brand-300">
                            Hitungan Mundur Popup (Detik)
                        </label>
                        <div class="max-w-xs">
                            <input type="number" name="popup_countdown" id="popup_countdown"
                                   value="<?= isset($pengumuman) ? $pengumuman['popup_countdown'] : '0' ?>" min="0"
                                   class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2 shadow-theme-xs outline-none">
                        </div>
                        <p class="mt-1 text-[11px] text-brand-700 dark:text-brand-300">
                            Waktu tunggu (detik) sebelum tombol tutup popup dapat diklik. Isi 0 jika ingin langsung bisa ditutup.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <a href="<?= base_url('admin/pengumuman') ?>"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-theme-xs">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    <span>Batal</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pengumuman</span>
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor4/4.22.1/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('isi_pengumuman', {
                height: 350,
                allowedContent: true,
                extraPlugins: 'colorbutton,font,justify'
            });
        }

        const isPopupCheckbox = document.getElementById('is_popup');
        const countdownWrapper = document.getElementById('countdown_wrapper');

        if (isPopupCheckbox) {
            isPopupCheckbox.addEventListener('change', function() {
                countdownWrapper.classList.toggle('hidden', !this.checked);
            });
        }
    });
</script>
<?= $this->endSection() ?>
