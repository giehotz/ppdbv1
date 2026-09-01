<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('head') ?>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-color: #e5e7eb !important;
        border-radius: 0.75rem !important;
        background-color: #f9fafb !important;
        display: flex !important;
        align-items: center !important;
    }
    .dark .select2-container .select2-selection--single {
        border-color: #374151 !important;
        background-color: #1f2937 !important;
        color: #f3f4f6 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px !important;
        padding-left: 14px !important;
        font-size: 0.8125rem !important;
        color: #111827 !important;
    }
    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f3f4f6 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
    }
    .select2-dropdown {
        border-color: #e5e7eb !important;
        border-radius: 0.75rem !important;
        overflow: hidden !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        font-size: 0.8125rem !important;
    }
    .dark .select2-dropdown {
        background-color: #1f2937 !important;
        border-color: #374151 !important;
        color: #f3f4f6 !important;
    }
    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #465fff !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('title') ?>Tulis Pesan Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">send</span> Tulis Pesan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50/80 p-4 text-red-800 shadow-sm dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg mt-0.5">error</span>
            <div class="flex-1 text-xs">
                <span class="font-bold block mb-1">Gagal Mengirim Pesan:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] max-w-3xl">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-brand-500">outgoing_mail</span>
            <span>Formulir Kirim Pesan ke Siswa</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kirim pesan informasi berkas, instruksi tahapan, atau pengingat ke calon siswa.</p>
    </div>

    <form action="<?= base_url('verifikator/pesan/store') ?>" method="POST" class="p-5 md:p-6 space-y-4">
        <?= csrf_field() ?>

        <div>
            <label for="penerima_id" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Penerima (Calon Siswa) <span class="text-red-500">*</span>
            </label>
            <select name="penerima_id" id="penerima_id" class="w-full select2" required>
                <option value="">-- Cari No. Pendaftaran atau Nama Siswa --</option>
                <?php foreach ($siswaList as $siswa) : ?>
                    <option value="<?= $siswa['id_siswa'] ?>" <?= old('penerima_id') == $siswa['id_siswa'] ? 'selected' : '' ?>>
                        <?= esc($siswa['no_pendaftaran']) ?> - <?= esc($siswa['nama_lengkap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="subjek" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Subjek Pesan <span class="text-red-500">*</span>
            </label>
            <input type="text" name="subjek" id="subjek" value="<?= old('subjek') ?>" 
                class="w-full h-10 px-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none" 
                placeholder="Contoh: Pemberitahuan Perbaikan Scan Berkas KK" required>
        </div>

        <div>
            <label for="isi_pesan" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Isi Pesan <span class="text-red-500">*</span>
            </label>
            <textarea name="isi_pesan" id="isi_pesan" rows="6" 
                class="w-full p-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none leading-relaxed placeholder:text-gray-400" 
                placeholder="Tuliskan isi pesan atau arahan verifikasi dengan jelas di sini..." required><?= old('isi_pesan') ?></textarea>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
            <a href="<?= base_url('verifikator/pesan') ?>" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-brand-500 hover:bg-brand-600 text-xs font-bold text-white shadow-theme-xs transition-colors active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">send</span>
                <span>Kirim Pesan</span>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#penerima_id').select2({
            placeholder: "-- Cari No. Pendaftaran atau Nama Siswa --",
            allowClear: true
        });
    });
</script>
<?= $this->endSection() ?>
