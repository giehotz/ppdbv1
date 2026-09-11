<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="<?= base_url('js/biodata.js') ?>"></script>

<style>
.flatpickr-calendar { background: #fff !important; border-radius: 1rem !important; box-shadow: 0 20px 25px -5px rgba(0,0,0,.1) !important; border: 1px solid #e5e7eb !important; font-family: inherit !important; padding: 8px !important; width: 310px !important; }
.dark .flatpickr-calendar { background: #111827 !important; border-color: #374151 !important; color: #f3f4f6 !important; }
.dark .flatpickr-months, .dark .flatpickr-weekdays, .dark span.flatpickr-weekday, .dark .flatpickr-month { background: #111827 !important; color: #9ca3af !important; fill: #9ca3af !important; }
.dark .flatpickr-current-month input.cur-year, .dark .flatpickr-current-month select { color: #f9fafb !important; font-weight: 700 !important; }
.dark .flatpickr-day { color: #e5e7eb !important; }
.dark .flatpickr-day:hover { background: #374151 !important; border-color: #374151 !important; }
.flatpickr-day.selected, .flatpickr-day.selected:hover { background: #465fff !important; border-color: #465fff !important; color: #fff !important; font-weight: 700 !important; }
</style>

<script>
setupBiodata({ baseUrl: '<?= base_url() ?>', csrfToken: '<?= csrf_token() ?>', csrfHash: '<?= csrf_hash() ?>' });
setSavedValues({
    prov: '<?= esc($pindahan['prov'] ?? '', 'js') ?>',
    kab: '<?= esc($pindahan['kab'] ?? '', 'js') ?>',
    kec: '<?= esc($pindahan['kec'] ?? '', 'js') ?>',
    desa: '<?= esc($pindahan['desa'] ?? '', 'js') ?>'
});
setIsFinal(<?= (isset($isFinal) && $isFinal) ? 'true' : 'false' ?>, <?= (isset($isVerifikator) && $isVerifikator) ? 'true' : 'false' ?>);
setPercentage(<?= $completionPercentage ?? 0 ?>);

// ── Urutan tab khusus wizard pindahan (6 langkah) ──
// Override showTab/navigateTab dari js/biodata.js agar urutan tab sesuai:
// 1 Data Diri → 2 Alamat → 3 Orang Tua/Wali → 4 Sekolah Asal → 5 Nilai Rapor → 6 Berkas
const PINDAHAN_TABS = ['dataDiri', 'alamat', 'orangTua', 'asal', 'rapor', 'berkas'];

function showTab(tabName) {
    currentTabIndex = PINDAHAN_TABS.indexOf(tabName);

    try { localStorage.setItem('biodata_active_tab', tabName); } catch(e) {}

    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => {
        content.classList.add('hidden');
    });

    const buttons = document.querySelectorAll('.tab-button');
    const activeClasses = ['border-brand-500', 'bg-brand-500/10', 'dark:bg-brand-500/20', 'text-brand-600', 'dark:text-brand-400'];
    const inactiveClasses = ['border-transparent', 'text-gray-500', 'hover:text-gray-900', 'hover:bg-gray-100', 'dark:text-gray-400', 'dark:hover:text-white', 'dark:hover:bg-gray-800'];

    buttons.forEach(button => {
        button.classList.remove(...activeClasses);
        button.classList.add(...inactiveClasses);
        const stepNum = button.querySelector('span:first-child');
        if (stepNum && stepNum.textContent.trim().match(/^\d+$/)) {
            stepNum.className = 'flex h-5 w-5 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-[10px] font-extrabold text-gray-600 dark:text-gray-300';
        }
    });

    const targetContent = document.getElementById('content-' + tabName);
    if (targetContent) targetContent.classList.remove('hidden');

    const activeButton = document.getElementById('tab-' + tabName);
    if (activeButton) {
        activeButton.classList.remove(...inactiveClasses);
        activeButton.classList.add(...activeClasses);
        const stepNum = activeButton.querySelector('span:first-child');
        if (stepNum && stepNum.textContent.trim().match(/^\d+$/)) {
            stepNum.className = 'flex h-5 w-5 items-center justify-center rounded-full bg-brand-500 text-[10px] font-extrabold text-white';
        }

        if (window.innerWidth < 768) {
            activeButton.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    updateNavigationButtons(tabName);
}

function navigateTab(direction) {
    if (direction === 'next' && currentTabIndex < PINDAHAN_TABS.length - 1) {
        currentTabIndex++;
    } else if (direction === 'prev' && currentTabIndex > 0) {
        currentTabIndex--;
    }
    showTab(PINDAHAN_TABS[currentTabIndex]);
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formBiodata');
    const isVerifikator = <?= (isset($isVerifikator) && $isVerifikator) ? 'true' : 'false' ?>;
    const isFinal = <?= (isset($isFinal) && $isFinal) ? 'true' : 'false' ?>;

    // Override confirmFinalize for pindahan endpoints
    window.confirmFinalize = async function() {
        if (typeof Swal === 'undefined') return;
        if (currentPercentage < 100) {
            Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap', text: 'Lengkapi biodata hingga 100% sebelum mengirim.', confirmButtonColor: '#3085d6', confirmButtonText: 'Baik, Saya Lengkapi' });
            return;
        }
        const result = await Swal.fire({
            title: 'Kirim Data Permanen?', text: 'Pastikan semua data benar. Data tidak dapat diubah lagi setelah dikirim.', icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Kirim & Kunci Data!', cancelButtonText: 'Batal'
        });
        if (!result.isConfirmed) return;
        Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        try {
            const resp = await fetch(config.baseUrl + '/siswa/pindahan/biodata/finalize', {
                method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ [config.csrfToken]: config.csrfHash })
            });
            const data = await resp.json();
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Data Terkirim!',
                    html: '<p style="text-align:left;font-size:0.95em">' + data.message + '<br><br>Cetak formulir pendaftaran sekarang?</p>',
                    showCancelButton: true, confirmButtonText: 'Cetak Sekarang', cancelButtonText: 'Nanti Saja',
                    confirmButtonColor: '#16a34a', cancelButtonColor: '#6b7280'
                }).then(r => { if (r.isConfirmed) window.open(config.baseUrl + '/siswa/pindahan/cetak-formulir', '_blank'); window.location.reload(); });
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
            }
        } catch(e) { Swal.fire('Error', 'Gagal menghubungi server.', 'error'); }
    };

    // Override auto-save endpoint
    let saveTimeout = null;
    function triggerAutoSave() {
        if (saveTimeout) clearTimeout(saveTimeout);
        saveTimeout = setTimeout(async () => {
            if (!form) return;
            const disabledEls = [];
            form.querySelectorAll('[disabled]').forEach(el => { disabledEls.push(el); el.disabled = false; });
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            disabledEls.forEach(el => el.disabled = true);
            try {
                const resp = await fetch(config.baseUrl + '/siswa/pindahan/biodata/auto-save', {
                    method: 'POST', headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': config.csrfHash },
                    body: JSON.stringify(data)
                });
                const result = await resp.json();
                if (result.success) {
                    setPercentage(result.percentage);
                    const pct = result.percentage;
                    const incompleteCount = result.incomplete ? result.incomplete.length : 0;
                    const progressText = document.getElementById('progressText');
                    const progressBar = document.getElementById('progressBar');
                    const progressInfo = document.getElementById('progressInfo');
                    if (progressText) { progressText.textContent = pct + '%'; progressText.className = pct < 100 ? 'text-base sm:text-lg font-black font-mono text-amber-500 dark:text-amber-400' : 'text-base sm:text-lg font-black font-mono text-emerald-500 dark:text-emerald-400'; }
                    if (progressBar) { progressBar.style.width = pct + '%'; progressBar.className = pct < 100 ? 'bg-gradient-to-r from-amber-500 to-orange-500 h-2.5 rounded-full transition-all duration-500' : 'bg-gradient-to-r from-emerald-500 to-teal-500 h-2.5 rounded-full transition-all duration-500'; }
                    if (progressInfo) { progressInfo.innerHTML = pct < 100 ? `Terdapat <span class="font-bold text-amber-600 dark:text-amber-400">${incompleteCount}</span> kolom wajib yang belum lengkap.` : `<span class="text-emerald-600 dark:text-emerald-400 font-bold inline-flex items-center gap-1"><span class="material-symbols-outlined text-sm">verified</span> Formulir 100% lengkap!</span>`; }
                }
            } catch(e) { console.error('Auto-save failed', e); }
        }, 1500);
    }

    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', triggerAutoSave);
            el.addEventListener('change', triggerAutoSave);
        });
        form.addEventListener('submit', function() { this.querySelectorAll('[disabled]').forEach(el => el.disabled = false); });
    }

    const btnNext = document.getElementById('btnNext');
    const btnPrev = document.getElementById('btnPrev');
    if (btnNext) btnNext.addEventListener('click', triggerAutoSave);
    if (btnPrev) btnPrev.addEventListener('click', triggerAutoSave);

    // Flatpickr
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.datepicker-parent', {
            locale: 'id', dateFormat: 'Y-m-d', altInput: true, altFormat: 'd-m-Y',
            altInputClass: 'w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 pl-5 pr-11 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500',
            maxDate: 'today', allowInput: true,
            onChange: function(d, ds, inst) { if (inst.input) { inst.input.dispatchEvent(new Event('change', {bubbles:true})); inst.input.dispatchEvent(new Event('input', {bubbles:true})); } },
            onClose: function(d, ds, inst) { if (inst.input) { inst.input.dispatchEvent(new Event('change', {bubbles:true})); inst.input.dispatchEvent(new Event('input', {bubbles:true})); } }
        });
    }

    // Auto-save listeners terpasang di atas.
});

</script>