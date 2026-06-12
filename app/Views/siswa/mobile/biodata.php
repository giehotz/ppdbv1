<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Biodata
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Data Biodata
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm mb-6 overflow-hidden">
    <!-- Horizontal Scrollable Tabs optimized for mobile -->
    <div class="border-b border-gray-100 bg-white">
        <nav class="flex overflow-x-auto scrollbar-hide py-1 pl-1" style="-webkit-overflow-scrolling: touch;">
            <button onclick="showTab('dataDiri')" id="tab-dataDiri" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-blue-600 text-blue-600 flex-shrink-0 transition-colors">
                <i class="fas fa-user mr-2"></i>Data Diri
            </button>
            <button onclick="showTab('alamat')" id="tab-alamat" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-700 flex-shrink-0 transition-colors">
                <i class="fas fa-map-marker-alt mr-2"></i>Alamat
            </button>
            <button onclick="showTab('orangTua')" id="tab-orangTua" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-700 flex-shrink-0 transition-colors">
                <i class="fas fa-users mr-2"></i>Orang Tua
            </button>
            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-700 flex-shrink-0 transition-colors">
                <i class="fas fa-hand-holding-heart mr-2"></i>Kesejahteraan
            </button>
            <button onclick="showTab('sekolah')" id="tab-sekolah" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-700 flex-shrink-0 transition-colors">
                <i class="fas fa-school mr-2"></i>Asal Sekolah
            </button>
            <button onclick="showTab('berkas')" id="tab-berkas" class="tab-button whitespace-nowrap py-3 px-4 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-700 flex-shrink-0 transition-colors">
                <i class="fas fa-file-upload mr-2"></i>Berkas
            </button>
        </nav>
    </div>

    <?php
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

    <!-- Progress Bar (Mobile) -->
    <div class="px-4 pt-4 font-sans">
        <div class="flex justify-between items-center mb-2">
            <span class="text-xs font-semibold text-gray-700">Kelengkapan (Wajib 100%)</span>
            <span class="text-xs font-bold <?= ($completionPercentage ?? 0) < 100 ? 'text-red-500' : 'text-green-600' ?>" id="progressText">
                <?= $completionPercentage ?? 0 ?>%
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-red-500' : 'bg-green-600' ?> h-2 rounded-full transition-all duration-500" style="width: <?= $completionPercentage ?? 0 ?>%"></div>
        </div>
        <p class="text-[11px] text-gray-500 mt-1.5" id="progressInfo">
            <?php if (($completionPercentage ?? 0) < 100): ?>
                Ada <span class="font-bold text-red-500"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum diisi.
            <?php else: ?>
                <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata 100% lengkap!</span>
            <?php endif; ?>
        </p>
    </div>

    <form action="<?= base_url('siswa/biodata/update') ?>" method="post" class="p-4" id="formBiodata">
        <?= csrf_field() ?>

        <?= $this->include('siswa/biodata/_data_diri') ?>
        <?= $this->include('siswa/biodata/_alamat') ?>
        <?= $this->include('siswa/biodata/_orang_tua') ?>
        <?= $this->include('siswa/biodata/_kesejahteraan') ?>
        <?= $this->include('siswa/biodata/_asal_sekolah') ?>
    </form>

    <div class="px-4 pb-4">
        <?= $this->include('siswa/biodata/_upload_berkas') ?>

        <!-- Navigation Buttons - Sticky at bottom of card inside container -->
        <div class="pt-3 border-t border-gray-100 flex justify-between items-center rounded-b-2xl">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded-xl text-xs transition-colors shadow-sm disabled:opacity-50 flex items-center">
                <i class="fas fa-chevron-left mr-1"></i>Prev
            </button>

            <div class="flex gap-2">
                <button type="button" id="btnNext" onclick="navigateTab('next')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition-colors shadow-sm flex items-center">
                    Next<i class="fas fa-chevron-right ml-1"></i>
                </button>

                <?php if (!$isFinal): ?>
                    <button type="button" id="btnFinalize" onclick="confirmFinalize()" class="hidden bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition-colors shadow-sm items-center">
                        <i class="fas fa-paper-plane mr-1"></i>Kirim Data
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit" class="hidden bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition-colors shadow-sm items-center">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/biodata.css') ?>">
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/biodata.js') ?>"></script>

<script>
    // Initialize data from PHP to JS
    setupBiodata({
        baseUrl: '<?= base_url() ?>',
        csrfToken: '<?= csrf_token() ?>',
        csrfHash: '<?= csrf_hash() ?>'
    });

    setIsFinal(<?= $isFinal ? 'true' : 'false' ?>);

    setSavedValues({
        prov: '<?= $siswa['prov'] ?? '' ?>',
        kab: '<?= $siswa['kab'] ?? '' ?>',
        kec: '<?= $siswa['kec'] ?? '' ?>',
        desa: '<?= $siswa['desa'] ?? '' ?>'
    });

    setPercentage(<?= $completionPercentage ?? 0 ?>);

    // Auto-open specific tab from session flashdata
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('tab') === 'berkas'): ?>
            setTimeout(() => {
                showTab('berkas');
            }, 100);
        <?php endif; ?>

        <?php
        $defaultWelcomeMsg = 'Untuk mengakses <b>Dashboard</b> dan fitur lainnya, Anda <b style="color:#dc2626">wajib melengkapi biodata hingga 100%</b>.';
        $defaultWelcomeFooter = '📋 Isi setiap tab formulir secara lengkap. Data tersimpan <b>otomatis</b> saat Anda mengetik.';
        /** @var string $welcomeRaw */
        $welcomeRaw = (string) ($web['popup_biodata_welcome'] ?? '');
        $customWelcome = !empty($welcomeRaw) ? nl2br(esc($welcomeRaw)) : '';
        
        $defaultWarningMsg = 'Anda <b style="color:#dc2626">belum dapat mengakses menu tersebut</b> karena biodata belum lengkap.';
        $defaultWarningFooter = '📝 Lengkapi <b>seluruh kolom wajib</b> hingga <b style="color:#16a34a">100%</b> untuk mengakses Dashboard dan fitur lainnya.';
        /** @var string $warningRaw */
        $warningRaw = (string) ($web['popup_biodata_warning'] ?? '');
        $customWarning = !empty($warningRaw) ? nl2br(esc($warningRaw)) : '';
        ?>
        <?php if (($completionPercentage ?? 0) < 100): ?>
        if (!sessionStorage.getItem('biodataPopupShown')) {
            sessionStorage.setItem('biodataPopupShown', '1');
            Swal.fire({
                icon: 'info',
                title: '<span style="font-size:1.05em">Selamat Datang! 👋</span>',
                html: `
                    <div style="text-align:left; line-height:1.6; font-size:0.88em">
                        <p><?= $customWelcome ?: $defaultWelcomeMsg ?></p>
                        <div style="background:#fee2e2; border-radius:8px; padding:8px 12px; margin:10px 0; text-align:center">
                            <span style="font-size:1.5em; font-weight:800; color:#dc2626"><?= $completionPercentage ?? 0 ?>%</span>
                            <span style="font-size:0.8em; color:#991b1b; display:block">dari 100% yang diperlukan</span>
                        </div>
                        <?php if (!$customWelcome): ?>
                        <p><?= $defaultWelcomeFooter ?></p>
                        <?php endif; ?>
                    </div>
                `,
                confirmButtonText: '<i class="fas fa-edit mr-1"></i> Mulai Isi Biodata',
                confirmButtonColor: '#2563eb',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-5 py-2 text-sm font-semibold'
                }
            });
        }
        <?php endif; ?>

        // Popup peringatan saat siswa di-redirect dari menu lain
        <?php if (session()->getFlashdata('warning')): ?>
        Swal.fire({
            icon: 'warning',
            title: '<span style="font-size:1.05em">Akses Ditolak ⚠️</span>',
            html: `
                <div style="text-align:left; line-height:1.6; font-size:0.88em">
                    <p><?= $customWarning ?: $defaultWarningMsg ?></p>
                    <div style="background:#fef3c7; border-radius:8px; padding:8px 12px; margin:10px 0; text-align:center; border:1px solid #fbbf24">
                        <span style="font-size:1.4em; font-weight:800; color:#d97706"><?= $completionPercentage ?? 0 ?>%</span>
                        <span style="font-size:0.8em; color:#92400e; display:block">kelengkapan saat ini</span>
                    </div>
                    <?php if (!$customWarning): ?>
                    <p><?= $defaultWarningFooter ?></p>
                    <?php endif; ?>
                </div>
            `,
            confirmButtonText: '<i class="fas fa-edit mr-1"></i> Isi Biodata Sekarang',
            confirmButtonColor: '#d97706',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-5 py-2 text-sm font-semibold'
            }
        });
        <?php endif; ?>



        // WIZARD, AUTO-SAVE & VALIDATION
        if (!isFinal) {
            const requiredFields = [
                'nisn', 'nik', 'nama_lengkap', 'jk', 'tempat_lahir', 'tgl_lahir', 'agama', 
                'alamat_siswa', 'desa', 'kec', 'kab', 'prov', 'nama_ayah', 'nama_ibu', 'no_hp_ortu'
            ];

            function validateAndHighlight() {
                requiredFields.forEach(fieldName => {
                    const el = document.querySelector(`[name="${fieldName}"]`);
                    if (el) {
                        if (!el.value.trim()) {
                            el.classList.add('border-red-500', 'bg-red-50');
                        } else {
                            el.classList.remove('border-red-500', 'bg-red-50');
                        }
                    }
                });
            }

            let saveTimeout = null;
            function triggerAutoSave() {
                validateAndHighlight();
                if (saveTimeout) clearTimeout(saveTimeout);
                
                saveTimeout = setTimeout(async () => {
                    const form = document.getElementById('formBiodata');
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    
                    try {
                        const response = await fetch(config.baseUrl + '/siswa/biodata/auto-save', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(data)
                        });
                        
                        const result = await response.json();
                        if (result.success) {
                            const pct = result.percentage;
                            setPercentage(pct);
                            const incompleteCount = result.incomplete ? result.incomplete.length : 0;
                            
                            const progressText = document.getElementById('progressText');
                            const progressBar = document.getElementById('progressBar');
                            const progressInfo = document.getElementById('progressInfo');
                            
                            if (progressText) {
                                progressText.textContent = pct + '%';
                                progressText.className = pct < 100 ? 'text-xs font-bold text-red-500' : 'text-xs font-bold text-green-600';
                            }
                            if (progressBar) {
                                progressBar.style.width = pct + '%';
                                progressBar.className = pct < 100 ? 'bg-red-500 h-2 rounded-full transition-all duration-500' : 'bg-green-600 h-2 rounded-full transition-all duration-500';
                            }
                            if (progressInfo) {
                                if (pct < 100) {
                                    progressInfo.innerHTML = `Ada <span class="font-bold text-red-500">${incompleteCount}</span> kolom wajib yang belum diisi.`;
                                } else {
                                    progressInfo.innerHTML = `<span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata 100% lengkap!</span>`;
                                }
                            }
                        }
                    } catch (error) {
                        console.error("Auto-save failed", error);
                    }
                }, 1500); // 1.5s delay
            }

            validateAndHighlight();

            const formInputs = document.querySelectorAll('#formBiodata input, #formBiodata select, #formBiodata textarea');
            formInputs.forEach(input => {
                input.addEventListener('input', triggerAutoSave);
                input.addEventListener('change', triggerAutoSave);
            });

            const btnNext = document.getElementById('btnNext');
            const btnPrev = document.getElementById('btnPrev');
            if (btnNext) btnNext.addEventListener('click', validateAndHighlight);
            if (btnPrev) btnPrev.addEventListener('click', validateAndHighlight);
        }
    });
</script>
<?= $this->endSection() ?>
