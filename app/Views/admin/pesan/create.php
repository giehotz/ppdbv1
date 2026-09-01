<?= $this->extend('layouts/admin') ?>

<?= $this->section('head') ?>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 44px;
        border-color: #d1d5db;
        border-radius: 0.75rem;
        padding-top: 6px;
        background-color: #ffffff;
    }
    .dark .select2-container--default .select2-selection--single {
        background-color: #111827;
        border-color: #374151;
        color: #ffffff;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff;
    }
    .dark .select2-dropdown {
        background-color: #1f2937;
        border-color: #374151;
        color: #ffffff;
    }
    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #465fff;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('title') ?>
Tulis Pesan Baru
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">send</span> Tulis Pesan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">edit_square</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Kirim Pesan Pribadi</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kirimkan instruksi atau konfirmasi khusus ke calon peserta didik</p>
                </div>
            </div>
            <a href="<?= base_url('admin/pesan') ?>"
               class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 shadow-theme-xs hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>

        <form action="<?= base_url('admin/pesan/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="p-6 md:p-8 space-y-5">
                <div>
                    <label for="penerima_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Penerima Pesan (Siswa) <span class="text-red-500">*</span>
                    </label>
                    <select name="penerima_id" id="penerima_id" class="w-full select2" required>
                        <option value="">-- Cari dan Pilih Siswa --</option>
                        <?php foreach ($siswaList as $siswa) : ?>
                            <option value="<?= $siswa['id_siswa'] ?>" <?= old('penerima_id') == $siswa['id_siswa'] ? 'selected' : '' ?>>
                                <?= esc($siswa['no_pendaftaran']) ?> - <?= esc($siswa['nama_lengkap']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="subjek" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Subjek Pesan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="subjek" id="subjek" value="<?= old('subjek') ?>" required
                           placeholder="Contoh: Permintaan Perbaikan Berkas KK / Foto"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none">
                </div>

                <div>
                    <label for="isi_pesan" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Isi Pesan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi_pesan" id="isi_pesan" rows="6" required
                              placeholder="Tuliskan isi pesan secara jelas untuk siswa..."
                              class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-white px-4 py-2.5 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 outline-none leading-relaxed"><?= old('isi_pesan') ?></textarea>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <a href="<?= base_url('admin/pesan') ?>"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-theme-xs">
                    <span>Batal</span>
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">send</span>
                    <span>Kirim Pesan Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#penerima_id').select2({
            placeholder: "-- Cari dan Pilih Siswa --",
            allowClear: true
        });
    });
</script>
<?= $this->endSection() ?>
