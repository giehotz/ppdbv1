<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Upload Berkas
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Upload Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded text-sm mb-3" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded text-sm mb-3" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Info Box -->
<div class="bg-blue-50 border-l-4 border-blue-500 p-3 mb-4 rounded-lg">
    <div class="flex items-start">
        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-2"></i>
        <p class="text-xs text-blue-700">
            <strong>Petunjuk:</strong> Upload file JPG, PNG, atau PDF (max 2MB).
        </p>
    </div>
</div>

<!-- Document Upload Cards -->
<div class="space-y-3">
    <?php foreach ($requiredDocs as $jenis => $label): ?>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-gray-800 flex items-center">
                    <i class="fas fa-file-alt text-blue-600 mr-2 text-lg"></i>
                    <?= $label ?>
                </h3>
                <?php if (isset($uploadedBerkas[$jenis])): ?>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full flex items-center">
                        <i class="fas fa-check-circle mr-1"></i>Uploaded
                    </span>
                <?php else: ?>
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-semibold rounded-full flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>Belum
                    </span>
                <?php endif; ?>
            </div>

            <?php if (isset($uploadedBerkas[$jenis])): ?>
                <!-- Display uploaded file -->
                <div class="bg-gray-50 rounded-lg p-3 mb-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <?php
                                $ext = pathinfo($uploadedBerkas[$jenis]['nama_file'], PATHINFO_EXTENSION);
                                if ($ext == 'pdf'):
                                ?>
                                    <i class="fas fa-file-pdf text-red-600 text-lg"></i>
                                <?php else: ?>
                                    <i class="fas fa-file-image text-blue-600 text-lg"></i>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-gray-800 truncate"><?= $uploadedBerkas[$jenis]['nama_file'] ?></p>
                                <p class="text-xs text-gray-500"><?= number_format($uploadedBerkas[$jenis]['ukuran_file'] / 1024, 2) ?> KB</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-2">
                            <a href="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $uploadedBerkas[$jenis]['nama_file']) ?>" target="_blank" class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <form action="<?= base_url('siswa/berkas/delete/' . $uploadedBerkas[$jenis]['id_berkas']) ?>" method="post" class="inline" data-confirm="Yakin hapus berkas ini?">
                                <?= csrf_field() ?>
                                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Replace file form -->
                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">

                    <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700" required>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                        <i class="fas fa-sync-alt mr-1"></i>Ganti File
                    </button>
                </form>
            <?php else: ?>
                <!-- Upload form -->
                <form action="<?= base_url('siswa/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">

                    <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700" required>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                        <i class="fas fa-upload mr-1"></i>Upload <?= $label ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>