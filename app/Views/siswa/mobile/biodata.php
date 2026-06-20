<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Biodata
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Data Biodata
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="flex items-center p-3 mb-4 text-emerald-800 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-check-circle mr-2 text-emerald-500"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-3 mb-4 text-rose-800 bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-exclamation-triangle mr-2 text-rose-500"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 mb-6 overflow-hidden">
    <!-- Horizontal Scrollable Tabs optimized for mobile -->
    <div class="border-b border-slate-100/50 bg-transparent">
        <nav class="flex overflow-x-auto scrollbar-hide py-1 pl-1" style="-webkit-overflow-scrolling: touch;">
            <button onclick="showTab('dataDiri')" id="tab-dataDiri" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-emerald-600 text-emerald-600 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-user mr-1.5"></i>Data Diri
            </button>
            <button onclick="showTab('alamat')" id="tab-alamat" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-700 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-map-marker-alt mr-1.5"></i>Alamat
            </button>
            <button onclick="showTab('orangTua')" id="tab-orangTua" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-700 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-users mr-1.5"></i>Orang Tua
            </button>
            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-700 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-hand-holding-heart mr-1.5"></i>Kesejahteraan
            </button>
            <button onclick="showTab('sekolah')" id="tab-sekolah" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-700 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-school mr-1.5"></i>Asal Sekolah
            </button>
            <button onclick="showTab('berkas')" id="tab-berkas" class="tab-button whitespace-nowrap py-3 px-4 text-xs font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-700 flex-shrink-0 transition-colors bg-white/40 backdrop-blur-sm">
                <i class="fas fa-file-upload mr-1.5"></i>Berkas
            </button>
        </nav>
    </div>

    <?php
    $status_verifikasi = strtolower(trim($siswa['status_verifikasi'] ?? ''));
    $isFinal = (($siswa['status_pendaftaran'] ?? '') === 'Final') && ($status_verifikasi !== 'ditolak');

    $this->setData([
        'isFinal' => $isFinal,
        'siswa' => $siswa,
        'penghasilan' => $penghasilan ?? [],
        'requiredDocs' => $requiredDocs ?? [],
        'uploadedBerkas' => $uploadedBerkas ?? [],
        'pendingRequest' => $pendingRequest ?? null
    ]);
    ?>

    <!-- Progress Bar Glass -->
    <div class="px-4 pt-4">
        <div class="flex justify-between items-center mb-2">
            <span class="text-[10px] font-semibold text-slate-600">Kelengkapan (Wajib 100%)</span>
            <span class="text-xs font-bold <?= ($completionPercentage ?? 0) < 100 ? 'text-rose-500' : 'text-emerald-600' ?>" id="progressText">
                <?= $completionPercentage ?? 0 ?>%
            </span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2">
            <div id="progressBar" class="<?= ($completionPercentage ?? 0) < 100 ? 'bg-rose-500' : 'bg-emerald-500' ?> h-2 rounded-full transition-all duration-500" style="width: <?= $completionPercentage ?? 0 ?>%"></div>
        </div>
        <p class="text-[10px] text-slate-500 mt-1.5" id="progressInfo">
            <?php if (($completionPercentage ?? 0) < 100): ?>
                Ada <span class="font-bold text-rose-500"><?= count($incompleteFields ?? []) ?></span> kolom wajib yang belum diisi.
            <?php else: ?>
                <span class="text-emerald-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata 100% lengkap!</span>
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

        <!-- Navigation Buttons -->
        <div class="pt-3 border-t border-slate-100/50 flex justify-between items-center rounded-b-2xl">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')" class="bg-white/60 backdrop-blur-sm border border-slate-200/50 hover:bg-slate-100/80 text-slate-700 font-bold py-2 px-4 rounded-xl text-[10px] transition-colors shadow-sm disabled:opacity-50 flex items-center active:scale-[0.95]">
                <i class="fas fa-chevron-left mr-1"></i>Prev
            </button>

            <div class="flex gap-2">
                <button type="button" id="btnNext" onclick="navigateTab('next')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl text-[10px] transition-colors shadow-sm flex items-center active:scale-[0.95]">
                    Next<i class="fas fa-chevron-right ml-1"></i>
                </button>

                <?php if (!$isFinal): ?>
                    <button type="button" id="btnFinalize" onclick="confirmFinalize()" class="hidden bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-xl text-[10px] transition-colors shadow-sm items-center active:scale-[0.95]">
                        <i class="fas fa-paper-plane mr-1"></i>Kirim Data
                    </button>
                    <button type="submit" form="formBiodata" id="btnSubmit" class="hidden bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl text-[10px] transition-colors shadow-sm items-center active:scale-[0.95]">
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

    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('tab') === 'berkas'): ?>
            setTimeout(() => {
                showTab('berkas');
            }, 100);
        <?php endif; ?>

        <?php
        $defaultWelcomeMsg = 'Untuk mengakses <b>Dashboard</b> dan fitur lainnya, Anda <b style="color:#dc2626">wajib melengkapi biodata hingga 100%</b>.';
        $defaultWelcomeFooter = '📋 Isi setiap tab formulir secara lengkap. Data tersimpan <b>otomatis</b> saat Anda mengetik.';
        $welcomeRaw = (string) ($web['popup_biodata_welcome'] ?? '');
        $customWelcome = !empty($welcomeRaw) ? nl2br(esc($welcomeRaw)) : '';
        
        $defaultWarningMsg = 'Anda <b style="color:#dc2626">belum dapat mengakses menu tersebut</b> karena biodata belum lengkap.';
        $defaultWarningFooter = '📝 Lengkapi <b>seluruh kolom wajib</b> hingga <b style="color:#16a34a">100%</b> untuk mengakses Dashboard dan fitur lainnya.';
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
                confirmButtonColor: '#059669',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-5 py-2 text-sm font-semibold'
                }
            });
        }
        <?php endif; ?>

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
            confirmButtonColor: '#059669',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-5 py-2 text-sm font-semibold'
            }
        });
        <?php endif; ?>

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
                            el.classList.add('border-rose-500', 'bg-rose-50');
                        } else {
                            el.classList.remove('border-rose-500', 'bg-rose-50');
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
                                progressText.className = pct < 100 ? 'text-xs font-bold text-rose-500' : 'text-xs font-bold text-emerald-600';
                            }
                            if (progressBar) {
                                progressBar.style.width = pct + '%';
                                progressBar.className = pct < 100 ? 'bg-rose-500 h-2 rounded-full transition-all duration-500' : 'bg-emerald-500 h-2 rounded-full transition-all duration-500';
                            }
                            if (progressInfo) {
                                if (pct < 100) {
                                    progressInfo.innerHTML = `Ada <span class="font-bold text-rose-500">${incompleteCount}</span> kolom wajib yang belum diisi.`;
                                } else {
                                    progressInfo.innerHTML = `<span class="text-emerald-600 font-medium"><i class="fas fa-check-circle mr-1"></i> Biodata 100% lengkap!</span>`;
                                }
                            }
                        }
                    } catch (error) {
                        console.error("Auto-save failed", error);
                    }
                }, 1500);
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

            document.getElementById('formBiodata').addEventListener('submit', function() {
                this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
            });
        }
    });
</script>
<?= $this->endSection() ?>
