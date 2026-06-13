<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Biodata
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Data Biodata
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <?= session()->getFlashdata('error') ?>
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
            <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-red-500' : 'bg-green-600' ?> h-2.5 rounded-full transition-all duration-500" style="width: <?= $completionPercentage ?? 0 ?>%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2" id="progressInfo">
            <?php if (($completionPercentage ?? 0) < 100): ?>
                Ada <span class="font-bold text-red-500"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum diisi.
            <?php else: ?>
                <span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata sudah 100% lengkap! Anda dapat mengakses Dashboard.</span>
            <?php endif; ?>
        </p>
    </div>

    <form action="<?= base_url('siswa/biodata/update') ?>" method="post" class="p-6" id="formBiodata">
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

                <?php if (!$isFinal): ?>
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
        $defaultWelcomeMsg = 'Untuk dapat mengakses <b>Dashboard</b> dan seluruh fitur sistem, Anda <b style="color:#dc2626">wajib melengkapi formulir biodata hingga 100%</b> terlebih dahulu.';
        $defaultWelcomeFooter = '📋 Silakan isi setiap tab formulir di bawah secara lengkap. Data Anda akan <b>tersimpan otomatis</b> saat Anda mengetik.';
        /** @var string $welcomeRaw */
        $welcomeRaw = (string) ($web['popup_biodata_welcome'] ?? '');
        $customWelcome = !empty($welcomeRaw) ? nl2br(esc($welcomeRaw)) : '';
        
        $defaultWarningMsg = 'Anda <b style="color:#dc2626">belum dapat mengakses menu tersebut</b> karena data biodata Anda belum lengkap.';
        $defaultWarningFooter = '📝 Silakan lengkapi <b>seluruh kolom wajib</b> di formulir ini hingga mencapai <b style="color:#16a34a">100%</b>, lalu Anda akan otomatis dapat mengakses Dashboard dan fitur lainnya.';
        /** @var string $warningRaw */
        $warningRaw = (string) ($web['popup_biodata_warning'] ?? '');
        $customWarning = !empty($warningRaw) ? nl2br(esc($warningRaw)) : '';
        ?>
        <?php if (($completionPercentage ?? 0) < 100): ?>
            if (!sessionStorage.getItem('biodataPopupShown')) {
                sessionStorage.setItem('biodataPopupShown', '1');
                Swal.fire({
                    icon: 'info',
                    title: '<span style="font-size:1.15em">Selamat Datang, Calon Siswa! 👋</span>',
                    html: `
                    <div style="text-align:left; line-height:1.7; font-size:0.93em">
                        <p><?= $customWelcome ?: $defaultWelcomeMsg ?></p>
                        <hr style="margin:10px 0; border-color:#e5e7eb">
                        <p><b>Saat ini kelengkapan Anda:</b></p>
                        <div style="background:#fee2e2; border-radius:8px; padding:10px 14px; margin:8px 0; text-align:center">
                            <span style="font-size:1.6em; font-weight:800; color:#dc2626"><?= $completionPercentage ?? 0 ?>%</span>
                            <span style="font-size:0.85em; color:#991b1b; display:block">dari 100% yang diperlukan</span>
                        </div>
                        <?php if (!$customWelcome): ?>
                        <p style="margin-top:8px"><?= $defaultWelcomeFooter ?></p>
                        <?php endif; ?>
                    </div>
                `,
                    confirmButtonText: '<i class="fas fa-edit mr-1"></i> Mulai Isi Biodata',
                    confirmButtonColor: '#2563eb',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold'
                    }
                });
            }
        <?php endif; ?>

        // Popup peringatan saat siswa di-redirect dari menu lain
        <?php if (session()->getFlashdata('warning')): ?>
            Swal.fire({
                icon: 'warning',
                title: '<span style="font-size:1.1em">Akses Ditolak ⚠️</span>',
                html: `
                <div style="text-align:left; line-height:1.7; font-size:0.93em">
                    <p><?= $customWarning ?: $defaultWarningMsg ?></p>
                    <div style="background:#fef3c7; border-radius:8px; padding:10px 14px; margin:10px 0; text-align:center; border:1px solid #fbbf24">
                        <span style="font-size:1.5em; font-weight:800; color:#d97706"><?= $completionPercentage ?? 0 ?>%</span>
                        <span style="font-size:0.85em; color:#92400e; display:block">kelengkapan saat ini</span>
                    </div>
                    <?php if (!$customWarning): ?>
                    <p style="margin-top:8px"><?= $defaultWarningFooter ?></p>
                    <?php endif; ?>
                </div>
            `,
                confirmButtonText: '<i class="fas fa-edit mr-1"></i> Isi Biodata Sekarang',
                confirmButtonColor: '#d97706',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold'
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
                    // Temporarily enable disabled selects so their values are included
                    const disabledEls = [];
                    form.querySelectorAll('[disabled]').forEach(el => {
                        disabledEls.push(el);
                        el.disabled = false;
                    });
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    disabledEls.forEach(el => el.disabled = true);

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
                                progressText.className = pct < 100 ? 'text-sm font-bold text-red-500' : 'text-sm font-bold text-green-600';
                            }
                            if (progressBar) {
                                progressBar.style.width = pct + '%';
                                progressBar.className = pct < 100 ? 'bg-red-500 h-2.5 rounded-full transition-all duration-500' : 'bg-green-600 h-2.5 rounded-full transition-all duration-500';
                            }
                            if (progressInfo) {
                                if (pct < 100) {
                                    progressInfo.innerHTML = `Ada <span class="font-bold text-red-500">${incompleteCount}</span> kolom wajib yang belum diisi.`;
                                } else {
                                    progressInfo.innerHTML = `<span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata sudah 100% lengkap! Anda dapat mengakses Dashboard.</span>`;
                                }
                            }
                        }
                    } catch (error) {
                        console.error("Auto-save failed", error);
                    }
                }, 1500); // 1.5s delay
            }

            // Initial highlight
            validateAndHighlight();

            // Bind listeners
            const formInputs = document.querySelectorAll('#formBiodata input, #formBiodata select, #formBiodata textarea');
            formInputs.forEach(input => {
                input.addEventListener('input', triggerAutoSave);
                input.addEventListener('change', triggerAutoSave);
            });

            // Re-check intensely on tabs change
            const btnNext = document.getElementById('btnNext');
            const btnPrev = document.getElementById('btnPrev');
            if (btnNext) btnNext.addEventListener('click', validateAndHighlight);
            if (btnPrev) btnPrev.addEventListener('click', validateAndHighlight);

            // Ensure disabled selects submit their values on form submit
            document.getElementById('formBiodata').addEventListener('submit', function() {
                this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
            });
        }
    });
</script>
<?= $this->endSection() ?>