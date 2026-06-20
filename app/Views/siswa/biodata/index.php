<?= $this->extend($layout ?? 'layouts/siswa') ?>

<?= $this->section('title') ?>
Biodata
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Data Biodata
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow">
    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 bg-gray-50">
        <nav class="flex -mb-px overflow-x-auto scrollbar-hide scrollable-tabs" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            <button onclick="showTab('dataDiri')" id="tab-dataDiri" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-blue-600 text-blue-600 flex-shrink-0">
                <i class="fas fa-user mr-1 md:mr-2"></i>Data Diri
            </button>
            <button onclick="showTab('alamat')" id="tab-alamat" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-map-marker-alt mr-1 md:mr-2"></i>Alamat
            </button>
            <button onclick="showTab('orangTua')" id="tab-orangTua" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-users mr-1 md:mr-2"></i>Orang Tua/Wali
            </button>
            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-hand-holding-heart mr-1 md:mr-2"></i>Kesejahteraan
            </button>
            <button onclick="showTab('sekolah')" id="tab-sekolah" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-school mr-1 md:mr-2"></i>Asal Sekolah
            </button>
            <button onclick="showTab('berkas')" id="tab-berkas" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-file-upload mr-1 md:mr-2"></i>Upload Berkas
            </button>
        </nav>
    </div>

    <?php
    // Logic to determine if data is final/locked
    $status_verifikasi = strtolower(trim($siswa['status_verifikasi'] ?? ''));
    $isFinal = (($siswa['status_pendaftaran'] ?? '') === 'Final') && ($status_verifikasi !== 'ditolak');

    // Set data globally in the view instance so partials can access it
    $this->setData([
        'isFinal' => $isFinal,
        'siswa' => $siswa,
        'penghasilan' => $penghasilan ?? [],
        'requiredDocs' => $requiredDocs ?? [],
        'uploadedBerkas' => $uploadedBerkas ?? [],
        'pendingRequest' => $pendingRequest ?? null
    ]);
    ?>

    <!-- Progress Bar -->
    <div class="px-6 pt-6 font-sans">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-semibold text-gray-700">Kelengkapan Biodata (Wajib 100%)</span>
            <span class="text-sm font-bold <?= ($completionPercentage ?? 0) < 100 ? 'text-red-500' : 'text-green-600' ?>" id="progressText">
                <?= $completionPercentage ?? 0 ?>%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-red-500' : 'bg-green-600' ?> h-2.5 rounded-full transition-all duration-500" style="width: <?= esc($completionPercentage ?? 0, 'attr') ?>%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2" id="progressInfo">
            <?php if (($completionPercentage ?? 0) < 100): ?>
                Ada <span class="font-bold text-red-500"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum diisi.
            <?php else: ?>
                <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata sudah 100% lengkap! Anda dapat mengakses Dashboard.</span>
            <?php endif; ?>
        </p>
    </div>

    <form action="<?= $formAction ?? base_url('siswa/biodata/update') ?>" method="post" class="p-6" id="formBiodata">
        <?= csrf_field() ?>

        <?= $this->include('siswa/biodata/_data_diri') ?>
        <?= $this->include('siswa/biodata/_alamat') ?>
        <?= $this->include('siswa/biodata/_orang_tua') ?>
        <?= $this->include('siswa/biodata/_kesejahteraan') ?>
        <?= $this->include('siswa/biodata/_asal_sekolah') ?>
    </form>

    <div class="px-6 pb-6">
        <?= $this->include('siswa/biodata/_upload_berkas') ?>

        <!-- Shared Navigation Buttons -->
        <div class="flex justify-between items-center mt-6 pt-6 border-t">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')" class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>

            <div class="flex items-center gap-3">
                <button type="button" id="btnNext" onclick="navigateTab('next')" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition duration-200">
                    Selanjutnya<i class="fas fa-arrow-right ml-2"></i>
                </button>

                <?php if (isset($isVerifikator) && $isVerifikator): ?>
                    <button type="button" onclick="window.location.href='<?= base_url('verifikator/siswa/cetak-akun/' . $siswa['id_siswa']) ?>'" id="btnFinalize" class="hidden bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-print mr-2"></i>Selesai & Cetak Akun
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit" class="hidden bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Biodata
                    </button>
                <?php elseif (!$isFinal): ?>
                    <button type="button" id="btnFinalize" onclick="confirmFinalize()" class="hidden bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Data (Final)
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit" class="hidden bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-8 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Draft
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/biodata.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->include('siswa/biodata/_scripts') ?>
<?= $this->endSection() ?>