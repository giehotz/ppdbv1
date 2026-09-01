/**
 * Biodata Form JavaScript
 * Handles tab navigation, Indonesia region cascading dropdowns, 
 * Wali logic, and form finalization with SweetAlert2.
 */

// ===== GLOBAL STATE / VARIABLES =====
const tabs = ['dataDiri', 'alamat', 'orangTua', 'kesejahteraan', 'sekolah', 'berkas'];
let currentTabIndex = 0;
let isFinal = false; // Will be set from PHP
let isVerifikator = false;

// This will be set from PHP
let savedValues = {
    prov: '',
    kab: '',
    kec: '',
    desa: ''
};

// Config for Base URL (to be set from PHP if needed, else using relative)
let config = {
    baseUrl: '',
    csrfToken: '',
    csrfHash: ''
};

let currentPercentage = 0;

function setPercentage(pct) {
    currentPercentage = parseInt(pct) || 0;
    if (!isVerifikator) {
        updateFinalizeButtonState();
    }
}

function updateFinalizeButtonState() {
    if (isVerifikator) return;
    const btnFinalize = document.getElementById('btnFinalize');
    if (!btnFinalize) return;

    if (currentPercentage < 100) {
        btnFinalize.disabled = true;
        btnFinalize.classList.add('opacity-50', 'cursor-not-allowed');
        btnFinalize.title = "Lengkapi data hingga 100% untuk mengirim";
    } else {
        btnFinalize.disabled = false;
        btnFinalize.classList.remove('opacity-50', 'cursor-not-allowed');
        btnFinalize.title = "";
    }
}

// ===== TAB NAVIGATION =====

function showTab(tabName) {
    // Update current tab index
    currentTabIndex = tabs.indexOf(tabName);

    // Save active tab to localStorage
    try { localStorage.setItem('biodata_active_tab', tabName); } catch(e) {}

    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active state from all tabs
    const buttons = document.querySelectorAll('.tab-button');
    const activeClasses = ['bg-white', 'text-brand-600', 'shadow-theme-xs', 'border', 'border-brand-200', 'dark:bg-brand-500/15', 'dark:text-brand-400', 'dark:border-brand-500/30', 'font-bold'];
    const inactiveClasses = ['text-gray-500', 'dark:text-gray-400', 'font-semibold'];

    buttons.forEach(button => {
        button.classList.remove(...activeClasses, 'border-blue-600', 'text-blue-600');
        button.classList.add(...inactiveClasses);
    });

    // Show selected tab content
    const targetContent = document.getElementById('content-' + tabName);
    if (targetContent) targetContent.classList.remove('hidden');

    // Set active state on selected tab
    const activeButton = document.getElementById('tab-' + tabName);
    if (activeButton) {
        activeButton.classList.remove(...inactiveClasses);
        activeButton.classList.add(...activeClasses);

        // Scroll active tab into view on mobile
        if (window.innerWidth < 768) {
            activeButton.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    // Update navigation and action buttons
    updateNavigationButtons(tabName);
}

function navigateTab(direction) {
    if (direction === 'next' && currentTabIndex < tabs.length - 1) {
        currentTabIndex++;
    } else if (direction === 'prev' && currentTabIndex > 0) {
        currentTabIndex--;
    }

    showTab(tabs[currentTabIndex]);
}

function updateNavigationButtons(tabId) {
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const actionRow = document.getElementById('actionRow');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnFinalize = document.getElementById('btnFinalize');

    if (!btnPrev || !btnNext) return;

    // Handle Previous Button
    if (currentTabIndex === 0) {
        btnPrev.disabled = true;
        btnPrev.classList.add('opacity-30', 'cursor-not-allowed');
    } else {
        btnPrev.disabled = false;
        btnPrev.classList.remove('opacity-30', 'cursor-not-allowed');
    }

    // Handle Next & Action Buttons
    if (tabId === 'berkas') {
        btnNext.classList.add('hidden');
        btnNext.style.display = 'none';
        btnPrev.classList.add('w-full');
        // Mobile layout: toggle the action row container
        if (actionRow && (!isFinal || isVerifikator)) {
            actionRow.classList.remove('hidden');
            actionRow.classList.add('flex');
            actionRow.style.display = 'flex';
            if (!isVerifikator) updateFinalizeButtonState();
        }
        // Desktop layout: toggle individual buttons (when actionRow doesn't exist)
        if (!actionRow) {
            if (btnSubmit && (!isFinal || isVerifikator)) {
                btnSubmit.classList.remove('hidden');
            }
            if (btnFinalize && (!isFinal || isVerifikator)) {
                btnFinalize.classList.remove('hidden');
                if (!isVerifikator) updateFinalizeButtonState();
            }
        }
    } else {
        btnNext.classList.remove('hidden');
        btnNext.style.display = '';
        btnPrev.classList.remove('w-full');
        if (actionRow) {
            actionRow.classList.add('hidden');
            actionRow.classList.remove('flex');
            actionRow.style.display = 'none';
        }
        if (!actionRow) {
            if (btnSubmit) btnSubmit.classList.add('hidden');
            if (btnFinalize) btnFinalize.classList.add('hidden');
        }
    }
}

// ===== WILAYAH INDONESIA API =====
const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

// Function to set saved values from PHP
function setSavedValues(values) {
    savedValues = values;
}

// Function to set status final from PHP
function setIsFinal(status, verifikatorMode = false) {
    isVerifikator = !!verifikatorMode;
    isFinal = isVerifikator ? false : !!status;
    if (status && !verifikatorMode) {
        // Disable all inputs automatically using JS if status is Final to avoid tampering
        // Skip when verifikator is editing — they need to modify data
        setTimeout(() => {
            document.querySelectorAll('#formBiodata input, #formBiodata select, #formBiodata textarea').forEach(el => {
                if (el.name !== 'csrf_test_name') { // Don't disable CSRF if needed, but usually it's hidden
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('bg-gray-100', 'cursor-not-allowed');
                }
            });
        }, 100);
    }
}

// Load provinces on page load
async function loadProvinces() {
    try {
        const response = await fetch(`${API_BASE}/provinces.json`);
        const provinces = await response.json();

        const select = document.getElementById('provinsi');
        if (!select) return;
        
        select.innerHTML = '<option value="">-- Pilih Provinsi --</option>';

        provinces.forEach(prov => {
            const option = document.createElement('option');
            option.value = prov.name;
            option.textContent = prov.name;
            option.dataset.id = prov.id;

            // Restore saved value
            if (savedValues.prov && prov.name === savedValues.prov) {
                option.selected = true;
                const provIdEl = document.getElementById('provinsi_id');
                if (provIdEl) provIdEl.value = prov.id;
            }

            select.appendChild(option);
        });

        // Load cities if province was saved
        if (savedValues.prov) {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.dataset.id) {
                await loadCities(selectedOption.dataset.id);
            }
        }
    } catch (error) {
        console.error('Error loading provinces:', error);
    }
}

// Load cities based on province
async function loadCities(provinceId) {
    try {
        const response = await fetch(`${API_BASE}/regencies/${provinceId}.json`);
        const cities = await response.json();

        const select = document.getElementById('kabupaten');
        if (!select) return;

        select.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
        if (!isFinal) select.disabled = false;

        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.name;
            option.textContent = city.name;
            option.dataset.id = city.id;

            // Restore saved value
            if (savedValues.kab && city.name === savedValues.kab) {
                option.selected = true;
                const kabIdEl = document.getElementById('kabupaten_id');
                if (kabIdEl) kabIdEl.value = city.id;
            }

            select.appendChild(option);
        });

        if (savedValues.kab) {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.dataset.id) {
                await loadDistricts(selectedOption.dataset.id);
            }
        } else if (!isFinal) {
            resetDistricts();
            resetVillages();
        }
    } catch (error) {
        console.error('Error loading cities:', error);
    }
}

// Load districts based on city
async function loadDistricts(cityId) {
    try {
        const response = await fetch(`${API_BASE}/districts/${cityId}.json`);
        const districts = await response.json();

        const select = document.getElementById('kecamatan');
        if (!select) return;

        select.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        if (!isFinal) select.disabled = false;

        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district.name;
            option.textContent = district.name;
            option.dataset.id = district.id;

            // Restore saved value
            if (savedValues.kec && district.name === savedValues.kec) {
                option.selected = true;
                const kecIdEl = document.getElementById('kecamatan_id');
                if (kecIdEl) kecIdEl.value = district.id;
            }

            select.appendChild(option);
        });

        if (savedValues.kec) {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.dataset.id) {
                await loadVillages(selectedOption.dataset.id);
            }
        } else if (!isFinal) {
            resetVillages();
        }
    } catch (error) {
        console.error('Error loading districts:', error);
    }
}

// Load villages based on district
async function loadVillages(districtId) {
    try {
        const response = await fetch(`${API_BASE}/villages/${districtId}.json`);
        const villages = await response.json();

        const select = document.getElementById('kelurahan');
        if (!select) return;

        select.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
        if (!isFinal) select.disabled = false;

        villages.forEach(village => {
            const option = document.createElement('option');
            option.value = village.name;
            option.textContent = village.name;

            // Restore saved value
            if (savedValues.desa && village.name === savedValues.desa) {
                option.selected = true;
            }

            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading villages:', error);
    }
}

// Reset functions
function resetCities() {
    const select = document.getElementById('kabupaten');
    if (select) {
        select.innerHTML = '<option value="">-- Pilih Provinsi Dahulu --</option>';
        select.disabled = true;
    }
    const kabId = document.getElementById('kabupaten_id');
    if (kabId) kabId.value = '';
}

function resetDistricts() {
    const select = document.getElementById('kecamatan');
    if (select) {
        select.innerHTML = '<option value="">-- Pilih Kabupaten/Kota Dahulu --</option>';
        select.disabled = true;
    }
    const kecId = document.getElementById('kecamatan_id');
    if (kecId) kecId.value = '';
}

function resetVillages() {
    const select = document.getElementById('kelurahan');
    if (select) {
        select.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
        select.disabled = true;
    }
}

// Event listeners for cascading
function initWilayahListeners() {
    document.getElementById('provinsi')?.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const provinceId = selectedOption ? selectedOption.dataset.id : null;
        const provIdEl = document.getElementById('provinsi_id');
        if (provIdEl) provIdEl.value = provinceId || '';

        if (provinceId) {
            loadCities(provinceId);
        } else {
            resetCities();
            resetDistricts();
            resetVillages();
        }
    });

    document.getElementById('kabupaten')?.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const cityId = selectedOption ? selectedOption.dataset.id : null;
        const kabIdEl = document.getElementById('kabupaten_id');
        if (kabIdEl) kabIdEl.value = cityId || '';

        if (cityId) {
            loadDistricts(cityId);
        } else {
            resetDistricts();
            resetVillages();
        }
    });

    document.getElementById('kecamatan')?.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const districtId = selectedOption ? selectedOption.dataset.id : null;
        const kecIdEl = document.getElementById('kecamatan_id');
        if (kecIdEl) kecIdEl.value = districtId || '';

        if (districtId) {
            loadVillages(districtId);
        } else {
            resetVillages();
        }
    });
}

// ===== WALI LOGIC =====

function handleWaliChanged() {
    const pilihan = document.getElementById('pilih_wali').value;
    const fields = ['nama', 'nik', 'th_lahir', 'pdd', 'pekerjaan', 'penghasilan'];

    fields.forEach(field => {
        const inputWali = document.getElementById(field + '_wali');
        if (!inputWali) return;

        if (pilihan === 'ayah' || pilihan === 'ibu') {
            const sourceInput = document.querySelector(`[name="${field}_${pilihan}"]`);
            if (sourceInput) {
                inputWali.value = sourceInput.value;
            }
            if (!isFinal) {
                inputWali.setAttribute('readonly', 'readonly');
                inputWali.classList.add('bg-gray-100', 'pointer-events-none');
            }
        } else {
            if (!isFinal) {
                inputWali.value = inputWali.getAttribute('data-original') || '';
                inputWali.removeAttribute('readonly');
                inputWali.classList.remove('bg-gray-100', 'pointer-events-none');
            }
        }
    });
}

function initWaliDetection() {
    if (!isFinal) {
        // Backup initial values for manual mode
        ['nama', 'nik', 'th_lahir', 'pdd', 'pekerjaan', 'penghasilan'].forEach(field => {
            const el = document.getElementById(field + '_wali');
            if(el) el.setAttribute('data-original', el.value);
        });

        // Auto-detect if saved data matches Ayah or Ibu
        const fields = ['nama', 'nik', 'th_lahir', 'pdd', 'pekerjaan', 'penghasilan'];
        let matchAyah = true;
        let matchIbu = true;
        let hasWali = false;

        fields.forEach(f => {
            const valWali = document.getElementById(f + '_wali')?.value || '';
            const valAyah = document.querySelector(`[name="${f}_ayah"]`)?.value || '';
            const valIbu = document.querySelector(`[name="${f}_ibu"]`)?.value || '';

            if (valWali !== '') hasWali = true;
            if (valWali !== valAyah || valWali === '') matchAyah = false;
            if (valWali !== valIbu || valWali === '') matchIbu = false;
        });

        if (hasWali) {
            const selectWali = document.getElementById('pilih_wali');
            if (selectWali) {
                if (matchAyah) {
                    selectWali.value = 'ayah';
                    handleWaliChanged();
                } else if (matchIbu) {
                    selectWali.value = 'ibu';
                    handleWaliChanged();
                } else {
                    selectWali.value = 'lainnya';
                }
            }
        }
    }
}

// ===== FINALIZATION & UNLOCK (SWEETALERT2) =====

function confirmFinalize() {
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 not loaded');
        return;
    }

    if (currentPercentage < 100) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Belum Lengkap',
            text: 'Silakan lengkapi biodata Anda hingga 100% sebelum melakukan pengiriman data final.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Baik, Saya Lengkapi'
        });
        return;
    }

    Swal.fire({
        title: 'Kirim Data Permanen?',
        text: "Pastikan semua data sudah benar! Saat diklik YES/Yakin, data tidak akan bisa diubah lagi oleh Anda (Terkunci untuk divalidasi Panitia).",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Kirim & Kunci Data!',
        cancelButtonText: 'Batalkan'
    }).then(async (result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Sedang Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch(config.baseUrl + '/siswa/biodata/finalize', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        [config.csrfToken]: config.csrfHash
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Success! Now offer to print
                    Swal.fire({
                        icon: 'success',
                        title: '<span style="font-size:1.15em">Data Terkirim! 🎉</span>',
                        html: '<p style="text-align:left; font-size:0.95em">' + data.message + '<br><br>Apakah Anda ingin <b>mencetak PDF Formulir Pendaftaran</b> sekarang?</p>',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-file-pdf mr-1"></i> Cetak Sekarang',
                        cancelButtonText: 'Nanti Saja',
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#6b7280',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold shadow-lg shadow-green-500/30',
                            cancelButton: 'rounded-xl px-6 py-2.5 text-sm font-semibold'
                        }
                    }).then((printResult) => {
                        if (printResult.isConfirmed) {
                            window.open(config.baseUrl + '/siswa/cetak-formulir', '_blank');
                        }
                        // Refresh to update UI to "Final" status
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            } catch (error) {
                console.error('Finalize error:', error);
                Swal.fire('Error', 'Gagal menghubungi server. Silakan coba lagi.', 'error');
            }
        }
    });
}

function requestUnlock() {
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 not loaded');
        return;
    }

    Swal.fire({
        title: 'Ajukan Buka Kunci?',
        text: "Kirim pesan kepada Admin agar kunci data formulir Anda dibuka kembali dan Anda bisa mengubah isian biodata/nilai Anda.",
        input: 'textarea',
        inputLabel: 'Tuliskan Alasan Pengajuan',
        inputPlaceholder: 'Contoh: Saya salah mengisi Nilai Rapor di semester 2...',
        inputAttributes: {
            'aria-label': 'Tuliskan Alasan Pengajuan'
        },
        showCancelButton: true,
        confirmButtonText: 'Kirim Permohonan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#eab308',
        inputValidator: (value) => {
            if (!value || value.trim().length === 0) {
                return 'Alasan pengajuan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = config.baseUrl + '/siswa/biodata/ajukan-buka';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = config.csrfToken;
            csrfToken.value = config.csrfHash;
            form.appendChild(csrfToken);

            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'alasan';
            reasonInput.value = result.value;
            form.appendChild(reasonInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

// ===== INITIALIZATION =====

function setupBiodata(phpConfig) {
    if (phpConfig.baseUrl) config.baseUrl = phpConfig.baseUrl;
    if (phpConfig.csrfToken) config.csrfToken = phpConfig.csrfToken;
    if (phpConfig.csrfHash) config.csrfHash = phpConfig.csrfHash;
}

document.addEventListener('DOMContentLoaded', function () {
    // Restore saved tab from localStorage
    try {
        const savedTab = localStorage.getItem('biodata_active_tab');
        if (savedTab && tabs.includes(savedTab)) {
            showTab(savedTab);
        }
    } catch(e) {}

    // Initial display of buttons
    const activeTab = tabs[currentTabIndex];
    updateNavigationButtons(activeTab);
    
    // Region cascader
    initWilayahListeners();
    loadProvinces();
    
    // Wali auto-detection
    initWaliDetection();
});
