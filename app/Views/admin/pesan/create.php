<?= $this->extend('layouts/admin') ?>

<?= $this->section('head') ?>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px;
        border-color: #d1d5db;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('title') ?>
Tulis Pesan Baru
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Tulis Pesan Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Terjadi Kesalahan!</strong>
        <ul class="list-disc pl-5 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Kirim Pesan ke Siswa</h3>
    </div>

    <form action="<?= base_url('admin/pesan/store') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>

        <div class="mb-4">
            <label for="penerima_id" class="block text-gray-700 font-medium mb-2">Ke (Pilih Siswa) <span class="text-red-500">*</span></label>
            <select name="penerima_id" id="penerima_id" class="w-full select2" required>
                <option value="">-- Cari dan Pilih Siswa --</option>
                <?php foreach ($siswaList as $siswa) : ?>
                    <option value="<?= $siswa['id_siswa'] ?>" <?= old('penerima_id') == $siswa['id_siswa'] ? 'selected' : '' ?>>
                        <?= esc($siswa['no_pendaftaran']) ?> - <?= esc($siswa['nama_lengkap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="subjek" class="block text-gray-700 font-medium mb-2">Subjek Pesan <span class="text-red-500">*</span></label>
            <input type="text" name="subjek" id="subjek" value="<?= old('subjek') ?>" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                placeholder="Misal: Perbaikan Berkas Pendaftaran" required>
        </div>

        <div class="mb-6">
            <label for="isi_pesan" class="block text-gray-700 font-medium mb-2">Isi Pesan <span class="text-red-500">*</span></label>
            <textarea name="isi_pesan" id="isi_pesan" rows="6" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                placeholder="Ketik pesan Anda di sini..." required><?= old('isi_pesan') ?></textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="<?= base_url('admin/pesan') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded transition duration-200">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
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
            placeholder: "-- Cari dan Pilih Siswa --",
            allowClear: true
        });
    });
</script>
<?= $this->endSection() ?>
