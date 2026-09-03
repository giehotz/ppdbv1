<?= $this->extend($layout ?? 'layouts/siswa') ?>

<?= $this->section('title') ?>Biodata Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">badge</span> Biodata Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// Logic to determine if data is final/locked
$status_verifikasi = strtolower(trim($siswa['status_verifikasi'] ?? ''));
$isFinal = (($siswa['status_pendaftaran'] ?? '') === 'Final') && ($status_verifikasi !== 'ditolak');

// Set data globally in the view instance so partials can access it
$this->setData([
    'isFinal' => $isFinal,
    'isVerifikator' => $isVerifikator ?? false,
    'formAction' => $formAction ?? null,
    'siswa' => $siswa,
    'penghasilan' => $penghasilan ?? [],
    'requiredDocs' => $requiredDocs ?? [],
    'uploadedBerkas' => $uploadedBerkas ?? [],
    'pendingRequest' => $pendingRequest ?? null
]);
?>
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50/80 p-4 text-red-800 shadow-sm dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg mt-0.5">error</span>
            <div class="flex-1 text-xs">
                <span class="font-bold block mb-1">Pemberitahuan Simpan Data:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="rounded-sm border border-gray-200 bg-white shadow-default dark:border-gray-800 dark:bg-gray-900">
    <!-- Tabs Navigation (TailAdmin Style) -->
    <div class="border-b border-gray-200 px-4 dark:border-gray-800">
        <nav class="flex gap-5 sm:gap-10 overflow-x-auto no-scrollbar scrollable-tabs" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            <button onclick="showTab('dataDiri')" id="tab-dataDiri"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-brand-500 text-brand-600 dark:text-brand-400">
                <span class="material-symbols-outlined text-base">person</span>
                <span>Data Diri</span>
            </button>

            <button onclick="showTab('alamat')" id="tab-alamat"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-transparent text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined text-base">home_pin</span>
                <span>Alamat</span>
            </button>

            <button onclick="showTab('orangTua')" id="tab-orangTua"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-transparent text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined text-base">family_restroom</span>
                <span>Orang Tua/Wali</span>
            </button>

            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-transparent text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined text-base">card_membership</span>
                <span>Kesejahteraan</span>
            </button>

            <button onclick="showTab('sekolah')" id="tab-sekolah"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-transparent text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined text-base">school</span>
                <span>Asal Sekolah</span>
            </button>

            <button onclick="showTab('berkas')" id="tab-berkas"
                class="tab-button inline-flex items-center gap-1.5 border-b-2 py-4 text-sm font-medium transition-all shrink-0 border-transparent text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                <span class="material-symbols-outlined text-base">upload_file</span>
                <span>Upload Berkas</span>
            </button>
        </nav>
    </div>

    <!-- Progress Bar Section -->
    <div class="px-5 pt-5 md:px-6 md:pt-6">
        <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-gray-800/30">
            <div class="flex items-center justify-between mb-1.5">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-base text-brand-500">analytics</span>
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Kelengkapan Formulir Biodata</span>
                </div>
                <span class="text-xs font-mono font-extrabold <?= ($completionPercentage ?? 0) < 100 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' ?>" id="progressText">
                    <?= $completionPercentage ?? 0 ?>%
                </span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden mb-1.5">
                <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-amber-500' : 'bg-emerald-500' ?> h-2 rounded-full transition-all duration-500" style="width: <?= esc($completionPercentage ?? 0, 'attr') ?>%"></div>
            </div>
            <div class="text-[11px] text-gray-500 dark:text-gray-400" id="progressInfo">
                <?php if (($completionPercentage ?? 0) < 100): ?>
                    Terdapat <span class="font-bold text-amber-600 dark:text-amber-400"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum diisi. Lengkapi hingga 100% untuk finalisasi.
                <?php else: ?>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span> Biodata sudah 100% lengkap! Anda siap melakukan finalisasi data.
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Form Area -->
    <form action="<?= $formAction ?? base_url('siswa/biodata/update') ?>" method="post" class="p-5 md:p-6" id="formBiodata">
        <?= csrf_field() ?>

        <?= $this->include('siswa/biodata/_data_diri') ?>
        <?= $this->include('siswa/biodata/_alamat') ?>
        <?= $this->include('siswa/biodata/_orang_tua') ?>
        <?= $this->include('siswa/biodata/_kesejahteraan') ?>
        <?= $this->include('siswa/biodata/_asal_sekolah') ?>
    </form>

    <div class="px-5 pb-5 md:px-6 md:pb-6">
        <?= $this->include('siswa/biodata/_upload_berkas') ?>

        <!-- Shared Navigation & Action Buttons (TailAdmin Style) -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-6 pt-5 border-t border-gray-100 dark:border-gray-800">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Kembali</span>
            </button>

            <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto justify-end">
                <button type="button" id="btnNext" onclick="navigateTab('next')"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                    <span>Selanjutnya</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>

                <?php if (isset($isVerifikator) && $isVerifikator): ?>
                    <button type="button" onclick="window.location.href='<?= base_url('verifikator/siswa/cetak-akun/' . $siswa['id_siswa']) ?>'" id="btnFinalize"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-purple-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-purple-700 transition-colors">
                        <span class="material-symbols-outlined text-base">print</span>
                        <span>Selesai &amp; Cetak Akun</span>
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-colors">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Biodata</span>
                    </button>
                <?php elseif (!$isFinal): ?>
                    <button type="button" id="btnFinalize" onclick="confirmFinalize()"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-red-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-red-700 transition-colors">
                        <span class="material-symbols-outlined text-base">send</span>
                        <span>Kirim Data (Final)</span>
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Draft</span>
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