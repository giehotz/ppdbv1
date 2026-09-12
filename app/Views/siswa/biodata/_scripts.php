<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="<?= base_url('js/biodata.js') ?>"></script>

<style>
    /* Custom Modern Flatpickr styling matching TailAdmin */
    .flatpickr-calendar {
        background: #ffffff !important;
        border-radius: 1rem !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #e5e7eb !important;
        font-family: inherit !important;
        padding: 8px !important;
        width: 310px !important;
    }
    .dark .flatpickr-calendar {
        background: #111827 !important;
        border-color: #374151 !important;
        color: #f3f4f6 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6) !important;
    }
    .flatpickr-months {
        border-radius: 0.75rem 0.75rem 0 0;
    }
    .dark .flatpickr-months, 
    .dark .flatpickr-weekdays,
    .dark span.flatpickr-weekday,
    .dark .flatpickr-month {
        background: #111827 !important;
        color: #9ca3af !important;
        fill: #9ca3af !important;
    }
    .dark .flatpickr-current-month input.cur-year,
    .dark .flatpickr-current-month select {
        color: #f9fafb !important;
        font-weight: 700 !important;
    }
    .dark .flatpickr-day {
        color: #e5e7eb !important;
    }
    .dark .flatpickr-day:hover,
    .dark .flatpickr-day:focus {
        background: #374151 !important;
        border-color: #374151 !important;
    }
    .flatpickr-day.selected, 
    .flatpickr-day.selected:hover {
        background: #465fff !important;
        border-color: #465fff !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }
    .dark .flatpickr-day.today {
        border-color: #465fff !important;
    }
    .flatpickr-day.today:hover {
        background: #e0e7ff !important;
        color: #1e1b4b !important;
    }
    .dark .flatpickr-day.today:hover {
        background: #312e81 !important;
        color: #e0e7ff !important;
    }
    .dark .flatpickr-day.flatpickr-disabled, 
    .dark .flatpickr-day.flatpickr-disabled:hover {
        color: #4b5563 !important;
    }
</style>

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
                        const targetEl = (el._flatpickr && el._flatpickr.altInput) ? el._flatpickr.altInput : el;
                        if (!el.value.trim()) {
                            targetEl.classList.add('border-red-500', 'bg-red-50');
                        } else {
                            targetEl.classList.remove('border-red-500', 'bg-red-50');
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
                                progressText.className = pct < 100 ? 'text-base sm:text-lg font-black font-mono text-amber-500 dark:text-amber-400' : 'text-base sm:text-lg font-black font-mono text-emerald-500 dark:text-emerald-400';
                            }
                            if (progressBar) {
                                progressBar.style.width = pct + '%';
                                progressBar.className = pct < 100 ? 'bg-gradient-to-r from-amber-500 to-orange-500 h-2.5 rounded-full transition-all duration-500' : 'bg-gradient-to-r from-emerald-500 to-teal-500 h-2.5 rounded-full transition-all duration-500';
                            }
                            if (progressInfo) {
                                if (pct < 100) {
                                    progressInfo.innerHTML = `Terdapat <span class="font-bold text-amber-600 dark:text-amber-400">${incompleteCount}</span> kolom wajib yang belum lengkap.`;
                                } else {
                                    progressInfo.innerHTML = `<span class="text-emerald-600 dark:text-emerald-400 font-bold inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">verified</span> Formulir 100% lengkap! Siap untuk tahap finalisasi.</span>`;
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

        // Inisialisasi Flatpickr Date Picker (Orang Tua & Calon Siswa)
        if (typeof flatpickr !== 'undefined') {
            flatpickr('.datepicker-parent, .datepicker-siswa', {
                locale: 'id',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd-m-Y',
                altInputClass: 'w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 pl-5 pr-11 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 cursor-pointer',
                maxDate: 'today',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    if (instance.input) {
                        instance.input.dispatchEvent(new Event('change', { bubbles: true }));
                        instance.input.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                },
                onClose: function(selectedDates, dateStr, instance) {
                    if (instance.input) {
                        instance.input.dispatchEvent(new Event('change', { bubbles: true }));
                        instance.input.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            });
        }
    });
</script>
