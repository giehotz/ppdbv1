<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/biodata.js') ?>"></script>

<script>
    // Initialize data from PHP to JS
    setupBiodata({
        baseUrl: '<?= base_url() ?>',
        csrfToken: '<?= csrf_token() ?>',
        csrfHash: '<?= csrf_hash() ?>'
    });

    setIsFinal(<?= (isset($isFinal) && $isFinal) ? 'true' : 'false' ?>, <?= (isset($isVerifikator) && $isVerifikator) ? 'true' : 'false' ?>);

    setSavedValues({
        prov: '<?= esc($siswa['prov'] ?? '', 'js') ?>',
        kab: '<?= esc($siswa['kab'] ?? '', 'js') ?>',
        kec: '<?= esc($siswa['kec'] ?? '', 'js') ?>',
        desa: '<?= esc($siswa['desa'] ?? '', 'js') ?>'
    });

    setPercentage(<?= $completionPercentage ?? 0 ?>);

    // Auto-open specific tab from session flashdata
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('tab') === 'berkas'): ?>
            setTimeout(() => {
                showTab('berkas');
            }, 100);
        <?php endif; ?>

        <?php if (!isset($isVerifikator) || !$isVerifikator): ?>
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
        <?php endif; // End of !isVerifikator block ?>


        // WIZARD, AUTO-SAVE & VALIDATION
        if (typeof isFinal !== 'undefined' && !isFinal) {
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
                    if (!form) return;
                    
                    // Temporarily enable disabled selects so their values are included
                    const disabledEls = [];
                    form.querySelectorAll('[disabled]').forEach(el => {
                        disabledEls.push(el);
                        el.disabled = false;
                    });
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());
                    disabledEls.forEach(el => el.disabled = true);

                    <?php if (!isset($isVerifikator) || !$isVerifikator): ?>
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
                    <?php endif; ?>
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
            const formEl = document.getElementById('formBiodata');
            if (formEl) {
                formEl.addEventListener('submit', function() {
                    this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
                });
            }
        }
    });
</script>
