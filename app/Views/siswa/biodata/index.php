<?= $this->extend($layout ?? 'layouts/siswa') ?>

<?= $this->section('title') ?>Biodata Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<div class="flex items-center gap-2">
    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
        <span class="material-symbols-outlined text-xl">badge</span>
    </span>
    <div>
        <h1 class="text-base font-bold text-gray-900 dark:text-white leading-none">Biodata Calon Siswa</h1>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Lengkapi identitas diri, orang tua, dan dokumen pendaftaran</p>
    </div>
</div>
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
    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50/90 p-4 text-red-800 shadow-sm dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl shrink-0 mt-0.5">error</span>
            <div class="flex-1 text-xs">
                <span class="font-bold text-sm block mb-1">Periksa Kembali Data Anda:</span>
                <ul class="list-disc list-inside space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Main Card Container with Modern Rounded Border & Subtle Shadow -->
<div class="rounded-2xl border border-gray-200/80 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
    
    <!-- Header Stepper Tabs Navigation -->
    <div class="border-b border-gray-100 bg-gray-50/50 px-3 sm:px-6 dark:border-gray-800/80 dark:bg-gray-900/50">
        <nav class="flex items-center gap-2 sm:gap-4 overflow-x-auto py-3 no-scrollbar scrollable-tabs" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            
            <!-- Step 1: Data Diri -->
            <button onclick="showTab('dataDiri')" id="tab-dataDiri"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent border-brand-500 bg-brand-500/10 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-500 text-[10px] font-extrabold text-white">1</span>
                <span class="material-symbols-outlined text-base">person</span>
                <span class="whitespace-nowrap">Data Diri</span>
            </button>

            <!-- Step 2: Alamat -->
            <button onclick="showTab('alamat')" id="tab-alamat"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300">2</span>
                <span class="material-symbols-outlined text-base">home_pin</span>
                <span class="whitespace-nowrap">Alamat</span>
            </button>

            <!-- Step 3: Orang Tua -->
            <button onclick="showTab('orangTua')" id="tab-orangTua"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300">3</span>
                <span class="material-symbols-outlined text-base">family_restroom</span>
                <span class="whitespace-nowrap">Orang Tua / Wali</span>
            </button>

            <!-- Step 4: Kesejahteraan -->
            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300">4</span>
                <span class="material-symbols-outlined text-base">card_membership</span>
                <span class="whitespace-nowrap">Kesejahteraan</span>
            </button>

            <!-- Step 5: Asal Sekolah -->
            <button onclick="showTab('sekolah')" id="tab-sekolah"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300">5</span>
                <span class="material-symbols-outlined text-base">school</span>
                <span class="whitespace-nowrap">Asal Sekolah</span>
            </button>

            <!-- Step 6: Upload Berkas -->
            <button onclick="showTab('berkas')" id="tab-berkas"
                class="tab-button group inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold transition-all duration-200 shrink-0 border border-transparent text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300">6</span>
                <span class="material-symbols-outlined text-base">upload_file</span>
                <span class="whitespace-nowrap">Upload Dokumen</span>
            </button>
        </nav>
    </div>

    <!-- Progress & Status Widget Bar -->
    <div class="px-5 pt-5 sm:px-8 sm:pt-6">
        <div class="rounded-2xl border border-gray-100 bg-gradient-to-r from-gray-50/80 via-white to-gray-50/80 p-4 sm:p-5 dark:border-gray-800/80 dark:from-gray-800/40 dark:via-gray-800/20 dark:to-gray-800/40 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2.5">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <span class="material-symbols-outlined text-lg">donut_large</span>
                    </span>
                    <div>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Status Kelengkapan Berkas &amp; Formulir</span>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400" id="progressInfo">
                            <?php if (($completionPercentage ?? 0) < 100): ?>
                                Terdapat <span class="font-bold text-amber-600 dark:text-amber-400"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum lengkap.
                            <?php else: ?>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">verified</span> Formulir 100% lengkap! Siap untuk tahap finalisasi.
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <?php if ($isFinal): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600 border border-red-200 dark:bg-red-500/15 dark:text-red-400 dark:border-red-900/50">
                            <span class="material-symbols-outlined text-sm">lock</span> Data Terkunci
                        </span>
                    <?php endif; ?>
                    <div class="flex items-baseline gap-1 text-right">
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">Progres:</span>
                        <span class="text-base sm:text-lg font-black font-mono <?= ($completionPercentage ?? 0) < 100 ? 'text-amber-500 dark:text-amber-400' : 'text-emerald-500 dark:text-emerald-400' ?>" id="progressText">
                            <?= $completionPercentage ?? 0 ?>%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modern Animated Gradient Bar -->
            <div class="w-full bg-gray-200/70 dark:bg-gray-700/60 rounded-full h-2.5 overflow-hidden">
                <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-gradient-to-r from-amber-500 to-orange-500' : 'bg-gradient-to-r from-emerald-500 to-teal-500' ?> h-2.5 rounded-full transition-all duration-500" style="width: <?= esc($completionPercentage ?? 0, 'attr') ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Main Form Area with Consistent Spacing -->
    <form action="<?= $formAction ?? base_url('siswa/biodata/update') ?>" method="post" class="p-5 sm:p-8" id="formBiodata">
        <?= csrf_field() ?>

        <?= $this->include('siswa/biodata/_data_diri') ?>
        <?= $this->include('siswa/biodata/_alamat') ?>
        <?= $this->include('siswa/biodata/_orang_tua') ?>
        <?= $this->include('siswa/biodata/_kesejahteraan') ?>
        <?= $this->include('siswa/biodata/_asal_sekolah') ?>
    </form>

    <!-- Upload Berkas & Shared Navigation Action Bar -->
    <div class="px-5 pb-6 sm:px-8 sm:pb-8">
        <?= $this->include('siswa/biodata/_upload_berkas') ?>

        <!-- Floating-like Navigation Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-all disabled:opacity-30 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span>Kembali</span>
            </button>

            <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto justify-end">
                <button type="button" id="btnNext" onclick="navigateTab('next')"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/20 hover:bg-brand-600 transition-all">
                    <span>Selanjutnya</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </button>

                <?php if (isset($isVerifikator) && $isVerifikator): ?>
                    <button type="button" onclick="window.location.href='<?= base_url('verifikator/siswa/cetak-akun/' . $siswa['id_siswa']) ?>'" id="btnFinalize"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-purple-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-purple-600/20 hover:bg-purple-700 transition-all">
                        <span class="material-symbols-outlined text-base">print</span>
                        <span>Selesai &amp; Cetak Akun</span>
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-600/20 hover:bg-brand-700 transition-all">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Biodata</span>
                    </button>
                <?php elseif (!$isFinal): ?>
                    <button type="button" id="btnFinalize" onclick="confirmFinalize()"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-red-600/20 hover:bg-red-700 transition-all">
                        <span class="material-symbols-outlined text-base">send</span>
                        <span>Kirim Data (Final)</span>
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit"
                        class="hidden w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 transition-all">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Draft</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url('css/biodata.css') ?>?v=<?= @filemtime(FCPATH . 'css/biodata.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->include('siswa/biodata/_scripts') ?>
<?= $this->endSection() ?>