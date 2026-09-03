<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Biodata Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Formulir Biodata<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$status_verifikasi = strtolower(trim($siswa['status_verifikasi'] ?? ''));
$isFinal = (($siswa['status_pendaftaran'] ?? '') === 'Final') && ($status_verifikasi !== 'ditolak');

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

$pct = $completionPercentage ?? 0;
$tabMeta = [
    ['id' => 'dataDiri',       'icon' => 'person',           'label' => 'Data Diri'],
    ['id' => 'alamat',         'icon' => 'home_pin',         'label' => 'Alamat'],
    ['id' => 'orangTua',       'icon' => 'family_restroom',  'label' => 'Orang Tua'],
    ['id' => 'kesejahteraan',  'icon' => 'card_membership',  'label' => 'Kesejahteraan'],
    ['id' => 'sekolah',        'icon' => 'school',           'label' => 'Asal Sekolah'],
    ['id' => 'berkas',         'icon' => 'upload_file',      'label' => 'Berkas'],
];
?>

<div class="biodata-mobile-wrapper pb-24">

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="mb-3 rounded-xl border border-red-200 bg-red-50/90 p-3.5 text-red-800 text-xs dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300 shadow-sm">
            <span class="font-bold block mb-1">Periksa kembali data:</span>
            <ul class="list-disc list-inside space-y-0.5">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <!-- ═══════ Progress Card ═══════ -->
    <div class="mb-3 progress-card rounded-[1.25rem] border border-gray-100 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden relative">
        <!-- Subtle accent gradient top-line -->
        <div class="absolute top-0 left-0 right-0 h-1 rounded-t-[1.25rem] <?= $pct < 100 ? 'bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500' : 'bg-gradient-to-r from-emerald-400 via-teal-400 to-emerald-500' ?>"></div>

        <div class="flex items-center justify-between gap-3 mb-2.5 pt-0.5">
            <div class="flex items-center gap-2 min-w-0">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl <?= $pct < 100 ? 'bg-amber-50 dark:bg-amber-500/10' : 'bg-emerald-50 dark:bg-emerald-500/10' ?> shrink-0">
                    <span class="material-symbols-outlined text-lg <?= $pct < 100 ? 'text-amber-500' : 'text-emerald-500' ?>">analytics</span>
                </div>
                <div class="min-w-0">
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200 block leading-tight">Kelengkapan Data</span>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 leading-tight" id="progressInfo">
                        <?php if ($pct < 100): ?>
                            <span class="font-semibold text-amber-600 dark:text-amber-400"><?= count($incompleteFields ?? []) ?></span> kolom wajib belum diisi
                        <?php else: ?>
                            <span class="text-emerald-600 dark:text-emerald-400 font-semibold inline-flex items-center gap-0.5">
                                <span class="material-symbols-outlined" style="font-size:11px">check_circle</span> Siap kirim/finalisasi
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <div class="flex flex-col items-end shrink-0">
                <span class="text-lg font-extrabold font-mono leading-none <?= $pct < 100 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' ?>" id="progressText">
                    <?= $pct ?>%
                </span>
            </div>
        </div>

        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
            <div id="progressBar"
                 class="<?= $pct < 100 ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gradient-to-r from-emerald-400 to-teal-500' ?> h-2 rounded-full transition-all duration-700 ease-out"
                 style="width: <?= esc($pct, 'attr') ?>%"></div>
        </div>
    </div>

    <!-- ═══════ Segmented Tab Navigation ═══════ -->
    <div class="mb-3 sticky top-0 z-10 -mx-4 px-3 py-2.5 bg-white/95 backdrop-blur-xl dark:bg-gray-900/95 border-b border-gray-200/70 dark:border-gray-800 shadow-sm">
        <nav class="flex gap-1 overflow-x-auto no-scrollbar scrollable-tabs" id="mobileTabsNav" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            <?php foreach ($tabMeta as $i => $tab): ?>
                <button type="button" onclick="showTab('<?= $tab['id'] ?>')" id="tab-<?= $tab['id'] ?>"
                    class="tab-button inline-flex items-center gap-1 rounded-xl px-3 py-2 text-[11px] transition-all duration-200 shrink-0 whitespace-nowrap
                    <?= $i === 0
                        ? 'font-bold bg-brand-500 text-white shadow-md shadow-brand-500/25 dark:bg-brand-500 dark:text-white'
                        : 'font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-800' ?>">
                    <span class="material-symbols-outlined" style="font-size:16px"><?= $tab['icon'] ?></span>
                    <span><?= $tab['label'] ?></span>
                </button>
            <?php endforeach; ?>
        </nav>
    </div>

    <!-- ═══════ Main Card Body ═══════ -->
    <div class="rounded-[1.25rem] border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <!-- Card Inner with nice padding -->
        <div class="p-4">
            <form action="<?= base_url('siswa/biodata/update') ?>" method="post" id="formBiodata" class="space-y-4">
                <?= csrf_field() ?>

                <?= $this->include('siswa/biodata/_data_diri') ?>
                <?= $this->include('siswa/biodata/_alamat') ?>
                <?= $this->include('siswa/biodata/_orang_tua') ?>
                <?= $this->include('siswa/biodata/_kesejahteraan') ?>
                <?= $this->include('siswa/biodata/_asal_sekolah') ?>
            </form>

            <?= $this->include('siswa/biodata/_upload_berkas') ?>
        </div>
    </div>

</div>

<!-- ═══════ Sticky Bottom Action Bar ═══════ -->
<div class="fixed bottom-[4.25rem] left-0 right-0 z-20 px-3 pb-2 pt-2.5 bg-white/95 backdrop-blur-xl border-t border-gray-200/80 dark:bg-gray-900/95 dark:border-gray-800 shadow-[0_-4px_16px_rgba(0,0,0,0.06)]">
    <div class="max-w-lg mx-auto space-y-2">
        <!-- Row 1: Navigation (always visible) -->
        <div class="flex items-center gap-2" id="navRow">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')"
                class="inline-flex items-center justify-center gap-1 h-10 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-gray-50 active:scale-[0.97] dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 disabled:opacity-30 disabled:cursor-not-allowed transition-all duration-150"
                style="min-width:44px; padding: 0 14px;">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                <span class="btn-prev-label">Kembali</span>
            </button>

            <button type="button" id="btnNext" onclick="navigateTab('next')"
                class="flex-1 inline-flex items-center justify-center gap-1 h-10 rounded-xl bg-brand-500 hover:bg-brand-600 active:scale-[0.97] text-xs font-bold text-white shadow-sm shadow-brand-500/20 transition-all duration-150">
                <span>Selanjutnya</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
        </div>

        <?php if (!$isFinal): ?>
        <!-- Row 2: Action buttons (only on berkas tab) -->
        <div class="hidden flex items-center gap-2" id="actionRow">
            <button type="submit" form="formBiodata" id="btnSubmit"
                class="flex-1 inline-flex items-center justify-center gap-1.5 h-10 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-[0.97] text-xs font-bold text-white shadow-sm shadow-emerald-500/20 transition-all duration-150">
                <span class="material-symbols-outlined text-base">save</span>
                <span>Simpan Data</span>
            </button>
            <button type="button" id="btnFinalize" onclick="confirmFinalize()"
                class="flex-1 inline-flex items-center justify-center gap-1.5 h-10 rounded-xl bg-red-600 hover:bg-red-700 active:scale-[0.97] text-xs font-bold text-white shadow-sm shadow-red-500/20 transition-all duration-150">
                <span class="material-symbols-outlined text-base">send</span>
                <span>Kirim Final</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/biodata.css') ?>">
<style>
    /* ===== Mobile-First Form Refinements ===== */

    /* Smooth tab switching animation */
    .tab-content {
        animation: fadeSlideIn 0.25s ease-out;
    }
    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tab button active state – filled pill style */
    .tab-button {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Form input sizing for mobile touch targets */
    .tab-content select,
    .tab-content input[type="text"],
    .tab-content input[type="email"],
    .tab-content input[type="number"],
    .tab-content input[type="date"],
    .tab-content textarea {
        font-size: 14px !important;
        height: 44px;
        border-radius: 12px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .tab-content textarea {
        height: auto;
        min-height: 76px;
    }

    /* Focus ring glow */
    .tab-content select:focus,
    .tab-content input:focus,
    .tab-content textarea:focus {
        box-shadow: 0 0 0 3px rgba(70, 95, 255, 0.1);
    }

    /* Labels – tighter spacing */
    .tab-content label {
        margin-bottom: 6px;
        letter-spacing: 0.01em;
    }

    /* Section headers inside tabs */
    .tab-content > .border-b {
        padding-bottom: 12px;
        margin-bottom: 16px;
    }

    /* Sub-cards (e.g., Ayah, Ibu, Wali) */
    .tab-content .rounded-xl.border.border-gray-100 {
        border-radius: 16px;
        padding: 16px;
    }

    /* Grid gap override for mobile */
    .tab-content .grid {
        gap: 14px;
    }

    /* Progress bar shimmer effect */
    #progressBar {
        position: relative;
        overflow: hidden;
    }
    #progressBar::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
        animation: shimmer 2.5s infinite;
    }
    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 200%; }
    }

    /* Bottom bar safe area */
    .biodata-mobile-wrapper {
        padding-bottom: 5.5rem;
    }

    /* Berkas card hover polish */
    .tab-content .rounded-xl.border.shadow-theme-xs {
        transition: border-color 0.2s ease, transform 0.15s ease;
    }
    .tab-content .rounded-xl.border.shadow-theme-xs:active {
        transform: scale(0.995);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->include('siswa/biodata/_scripts') ?>
<script>
    // Auto-scroll active tab into center view on mobile navigation
    const originalShowTab = window.showTab;

    // Override active classes for the filled-pill mobile style
    window.showTab = function(tabName) {
        if (typeof originalShowTab === 'function') {
            originalShowTab(tabName);
        }

        // Apply mobile-specific active styling (filled pill)
        const allBtns = document.querySelectorAll('#mobileTabsNav .tab-button');
        const activeClasses = ['bg-brand-500', 'text-white', 'shadow-md', 'shadow-brand-500/25', 'font-bold', 'dark:bg-brand-500', 'dark:text-white'];
        const inactiveClasses = ['text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-100', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:bg-gray-800', 'font-semibold'];

        allBtns.forEach(btn => {
            btn.classList.remove(...activeClasses,
                'bg-white', 'text-brand-600', 'shadow-theme-xs', 'border', 'border-brand-200',
                'dark:bg-brand-500/15', 'dark:text-brand-400', 'dark:border-brand-500/30');
            btn.classList.add(...inactiveClasses);
        });

        const activeBtn = document.getElementById('tab-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove(...inactiveClasses);
            activeBtn.classList.add(...activeClasses);

            // Smooth scroll into center view
            activeBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    };
</script>
<?= $this->endSection() ?>
