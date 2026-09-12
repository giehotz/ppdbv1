<!-- Tab: Asal Sekolah -->
<div id="content-sekolah" class="tab-content hidden space-y-6">
    <!-- Header -->
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-50 text-teal-600 dark:bg-teal-500/15 dark:text-teal-400">
                <span class="material-symbols-outlined text-lg">school</span>
            </span>
            <span>Data Riwayat Asal Sekolah</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi jenjang dan sekolah sebelumnya tempat siswa menempuh pendidikan.</p>
    </div>

    <!-- Section 1: Identitas Sekolah Sebelumnya -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">domain</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">1. Identitas Sekolah Asal</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nama Asal Sekolah -->
            <div class="md:col-span-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Nama Asal Sekolah / Madrasah <span class="text-red-500">*</span>
                    </label>
                    <!-- Toggle Opsi Wilayah -->
                    <button type="button" id="btnToggleFilterWilayah" class="inline-flex items-center gap-1 text-[11px] font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 transition-colors">
                        <span class="material-symbols-outlined text-xs">tune</span>
                        <span id="labelToggleWilayah">Bantuan: Cari Berdasarkan Wilayah</span>
                    </button>
                </div>

                <!-- Input Pencarian Langsung -->
                <div class="relative">
                    <div class="input-icon-wrapper relative">
                        <span class="input-icon material-symbols-outlined" id="iconSearchSekolah">school</span>
                        <input type="text" id="inputNamaSekolah" name="nama_sekolah" value="<?= esc($siswa['nama_sekolah'] ?? '', 'attr') ?>" autocomplete="off" class="form-input-control border border-gray-300 dark:border-gray-600 pr-10" placeholder="Ketik nama sekolah/madrasah (min. 3 huruf) atau ketik manual...">
                        <button type="button" id="btnClearSekolah" class="<?= !empty($siswa['nama_sekolah']) ? '' : 'hidden' ?> absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" title="Bersihkan input">
                            <span class="material-symbols-outlined text-base">cancel</span>
                        </button>
                    </div>

                    <!-- Petunjuk & Status Auto-fill -->
                    <div class="mt-1.5 flex items-center justify-between gap-2">
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs text-brand-500">travel_explore</span>
                            <span>Ketik nama sekolah, atau buka <em>Bantuan: Cari Berdasarkan Wilayah</em> jika nama sekolah banyak yang mirip.</span>
                        </p>
                        <span id="badgeSekolahStatus" class="hidden text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 shrink-0">
                            Data Terpilih
                        </span>
                    </div>

                    <!-- Autocomplete Dropdown List -->
                    <div id="dropdownSekolah" class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl overflow-hidden max-h-80 overflow-y-auto">
                        <!-- Konten hasil pencarian di-render via JavaScript -->
                    </div>
                </div>

                <!-- Panel Opsi Bantuan: Filter Berdasarkan Tingkat & Wilayah (Tingkat -> Provinsi -> Kab -> Kec -> Desa) -->
                <div id="panelFilterWilayah" class="hidden mt-3 p-4 rounded-xl border border-brand-200 bg-brand-50/40 dark:border-brand-900/40 dark:bg-brand-950/20 space-y-3 transition-all duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-brand-200/50 dark:border-brand-800/40">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-brand-600 dark:text-brand-400 text-sm">filter_alt</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Opsi Bantuan: Filter Sekolah per Wilayah &amp; Jenjang</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-brand-100 text-brand-700 dark:bg-brand-900/50 dark:text-brand-300">Opsional</span>
                        </div>
                        <button type="button" id="btnPakaiDomisili" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                            <span class="material-symbols-outlined text-xs">my_location</span>
                            <span>Gunakan Wilayah Domisili Saya</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
                        Gunakan opsi bantuan ini jika Anda tidak mengetahui NPSN atau nama sekolah Anda banyak yang kembar di Indonesia (seperti <em>SDN 1, TK Kartini, RA Al-Hidayah</em>). Menyaring hingga kecamatan/desa memastikan Anda tidak salah memilih sekolah dari daerah lain.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                        <!-- 1. Tingkat Sekolah -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">1. Tingkat Sekolah</label>
                            <select id="filterTingkat" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="">Semua Tingkat</option>
                                <option value="TK">TK / RA / PAUD / KB</option>
                                <option value="SD">SD / MI</option>
                                <option value="SMP">SMP / MTs</option>
                                <option value="SMA">SMA / SMK / MA</option>
                            </select>
                        </div>

                        <!-- 2. Provinsi -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">2. Provinsi</label>
                            <select id="filterProvinsi" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                        </div>

                        <!-- 3. Kabupaten / Kota -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">3. Kabupaten / Kota</label>
                            <select id="filterKabupaten" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white" disabled>
                                <option value="">-- Pilih Kab/Kota --</option>
                            </select>
                        </div>

                        <!-- 4. Kecamatan -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">4. Kecamatan</label>
                            <select id="filterKecamatan" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white" disabled>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>

                        <!-- 5. Desa / Kelurahan -->
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">5. Desa / Kelurahan</label>
                            <select id="filterDesa" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white" disabled>
                                <option value="">-- Semua Desa --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dropdown Hasil Pilihan Sekolah Wilayah -->
                    <div id="wrapperHasilWilayah" class="hidden pt-2 space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <label class="block text-[11px] font-bold text-gray-800 dark:text-gray-200" id="labelHasilWilayah">
                                Daftar Sekolah di Wilayah Terpilih:
                            </label>
                            <span id="countHasilWilayah" class="text-[10px] text-brand-600 dark:text-brand-400 font-semibold"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <div class="sm:col-span-2">
                                <select id="selectSekolahWilayah" class="w-full text-xs font-semibold rounded-lg border border-brand-300 bg-white px-3 py-2.5 text-gray-800 shadow-sm dark:border-brand-700 dark:bg-gray-900 dark:text-white">
                                    <option value="">-- Pilih Sekolah Asal dari Daftar Wilayah Ini --</option>
                                </select>
                            </div>
                            <div>
                                <input type="text" id="filterKeywordWilayah" class="w-full text-xs rounded-lg border border-gray-300 bg-white px-3 py-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Saring nama sekolah di sini...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NPSN Asal Sekolah -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        NPSN Asal Sekolah
                    </label>
                    <button type="button" id="btnCariNpsn" class="text-[11px] text-brand-600 dark:text-brand-400 hover:underline font-semibold flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-xs">search</span> Cari via NPSN
                    </button>
                </div>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">numbers</span>
                    <input type="text" id="inputNpsnSekolah" name="npsn_sekolah" value="<?= esc($siswa['npsn_sekolah'] ?? '', 'attr') ?>" maxlength="8" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="8 digit NPSN sekolah">
                </div>
            </div>

            <!-- Jenjang Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jenjang Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">stairs</span>
                    <select id="selectJenjangSekolah" name="jenjang_sekolah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="TK/RA/PAUD" <?= ($siswa['jenjang_sekolah'] ?? '') == 'TK/RA/PAUD' ? 'selected' : '' ?>>TK / RA / PAUD</option>
                        <option value="SD/MI" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SD/MI' ? 'selected' : '' ?>>SD / MI</option>
                        <option value="SMP/MTs" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SMP/MTs' ? 'selected' : '' ?>>SMP / MTs</option>
                        <option value="Lainnya" <?= ($siswa['jenjang_sekolah'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya / Tidak Sekolah</option>
                    </select>
                </div>
            </div>

            <!-- Status Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Status Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">verified</span>
                    <select id="selectStatusSekolah" name="status_sekolah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="Negeri" <?= ($siswa['status_sekolah'] ?? '') == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                        <option value="Swasta" <?= ($siswa['status_sekolah'] ?? '') == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                    </select>
                </div>
            </div>

            <!-- Kabupaten / Kota Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Kabupaten / Kota Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_on</span>
                    <input type="text" id="inputLokasiSekolah" name="lokasi_sekolah" value="<?= esc($siswa['lokasi_sekolah'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Kota / Kabupaten sekolah asal">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Peminatan / Kompetensi Keahlian Sebelumnya -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-4">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">tune</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">2. Peminatan / Jurusan Sebelumnya</h4>
        </div>

        <div>
            <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                Peminatan / Jurusan (Khusus Lanjutan SMP/SMA/SMK)
            </label>
            <div class="input-icon-wrapper">
                <span class="input-icon material-symbols-outlined">category</span>
                <input type="text" name="komp_ahli" value="<?= esc($siswa['komp_ahli'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: IPA / IPS / TKJ / Rekayasa Perangkat Lunak (Kosongkan jika dasar)">
            </div>
            <p class="text-[11px] text-gray-400 mt-1.5">Kosongkan kolom ini apabila jenjang yang didaftar adalah jenjang dasar (TK/SD).</p>
        </div>
    </div>
</div>

<!-- Script Autocomplete & API Sekolah (dengan Opsi Filter Wilayah) -->
<script>
(function() {
    if (window.sekolahAutocompleteInitialized) return;
    window.sekolahAutocompleteInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        // Elemen Form Utama
        const inputNama = document.getElementById('inputNamaSekolah');
        const inputNpsn = document.getElementById('inputNpsnSekolah');
        const selectJenjang = document.getElementById('selectJenjangSekolah');
        const selectStatus = document.getElementById('selectStatusSekolah');
        const inputLokasi = document.getElementById('inputLokasiSekolah');
        const dropdown = document.getElementById('dropdownSekolah');
        const iconSearch = document.getElementById('iconSearchSekolah');
        const btnClear = document.getElementById('btnClearSekolah');
        const btnCariNpsn = document.getElementById('btnCariNpsn');
        const badgeStatus = document.getElementById('badgeSekolahStatus');

        // Elemen Panel Filter Wilayah
        const btnToggleWilayah = document.getElementById('btnToggleFilterWilayah');
        const labelToggleWilayah = document.getElementById('labelToggleWilayah');
        const panelFilterWilayah = document.getElementById('panelFilterWilayah');
        const filterTingkat = document.getElementById('filterTingkat');
        const filterProvinsi = document.getElementById('filterProvinsi');
        const filterKabupaten = document.getElementById('filterKabupaten');
        const filterKecamatan = document.getElementById('filterKecamatan');
        const filterDesa = document.getElementById('filterDesa');
        const filterKeywordWilayah = document.getElementById('filterKeywordWilayah');
        const btnPakaiDomisili = document.getElementById('btnPakaiDomisili');
        const wrapperHasilWilayah = document.getElementById('wrapperHasilWilayah');
        const countHasilWilayah = document.getElementById('countHasilWilayah');
        const selectSekolahWilayah = document.getElementById('selectSekolahWilayah');

        if (!inputNama || !dropdown) return;

        let debounceTimer = null;
        let currentResults = [];
        let currentWilayahResults = [];
        let provincesCache = [];

        const EMSIFA_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        function toTitleCase(str) {
            if (!str) return '';
            return str.toLowerCase().replace(/(?:^|\s|\/|\-)\S/g, function(a) { return a.toUpperCase(); });
        }

        function mapJenjang(bp) {
            if (!bp) return '';
            const u = bp.toUpperCase().trim();
            if (['TK', 'RA', 'KB', 'TPA', 'SPS', 'PAUD'].includes(u)) return 'TK/RA/PAUD';
            if (['SD', 'MI', 'SDTK', 'SPK SD'].includes(u)) return 'SD/MI';
            if (['SMP', 'MTS', 'SMPTK', 'SPK SMP'].includes(u)) return 'SMP/MTs';
            return 'Lainnya';
        }

        function mapStatus(st) {
            if (!st) return '';
            const u = st.toUpperCase().trim();
            if (u.includes('NEGERI')) return 'Negeri';
            if (u.includes('SWASTA')) return 'Swasta';
            return '';
        }

        function dispatchChanges(elements) {
            elements.forEach(el => {
                if (el) {
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        }

        function applySchool(school) {
            inputNama.value = school.nama || '';
            if (inputNpsn && school.npsn) inputNpsn.value = school.npsn;
            
            if (selectJenjang) {
                const j = mapJenjang(school.bentukPendidikan);
                if (j) selectJenjang.value = j;
            }

            if (selectStatus) {
                const s = mapStatus(school.statusSatuanPendidikan);
                if (s) selectStatus.value = s;
            }

            if (inputLokasi) {
                let loc = '';
                if (school.alamat) {
                    loc = school.alamat.nama_kabupaten || school.alamat.nama_kota || '';
                    if (loc) loc = toTitleCase(loc);
                }
                if (loc) inputLokasi.value = loc;
            }

            if (badgeStatus) {
                badgeStatus.classList.remove('hidden');
                badgeStatus.textContent = 'Terpilih: ' + (school.bentukPendidikan || 'Sekolah');
            }

            if (btnClear) btnClear.classList.remove('hidden');
            hideDropdown();

            dispatchChanges([inputNama, inputNpsn, selectJenjang, selectStatus, inputLokasi]);

            if (window.Swal) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2200,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Data sekolah berhasil disinkronkan'
                });
            }
        }

        function showLoading() {
            if (iconSearch) iconSearch.textContent = 'hourglass_top';
            dropdown.innerHTML = `
                <div class="p-4 text-center text-gray-500 dark:text-gray-400 text-xs flex items-center justify-center gap-2">
                    <span class="inline-block w-4 h-4 border-2 border-brand-500 border-t-transparent rounded-full animate-spin"></span>
                    <span>Mencari data sekolah di database nasional...</span>
                </div>
            `;
            dropdown.classList.remove('hidden');
        }

        function showEmpty(keyword) {
            if (iconSearch) iconSearch.textContent = 'school';
            dropdown.innerHTML = `
                <div class="p-4 text-center">
                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">Sekolah "${escapeHtml(keyword)}" tidak ditemukan</p>
                    <p class="text-[11px] text-gray-500 mt-1">Nama sekolah mungkin berbeda penulisan, memiliki nama kembar, atau belum terdaftar.</p>
                    <div class="mt-2.5 flex items-center justify-center gap-2">
                        <button type="button" class="btn-open-bantuan-wilayah inline-flex items-center gap-1 text-[11px] font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-900/40 px-3 py-1.5 rounded-lg hover:bg-brand-100 transition-colors">
                            <span class="material-symbols-outlined text-xs">tune</span>
                            <span>Buka Opsi Bantuan Wilayah</span>
                        </button>
                    </div>
                </div>
            `;
            dropdown.classList.remove('hidden');
            dropdown.querySelector('.btn-open-bantuan-wilayah')?.addEventListener('click', function(e) {
                e.stopPropagation();
                openBantuanWilayah();
                hideDropdown();
            });
        }

        function hideDropdown() {
            if (iconSearch) iconSearch.textContent = 'school';
            dropdown.classList.add('hidden');
            dropdown.innerHTML = '';
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function renderResults(list) {
            if (iconSearch) iconSearch.textContent = 'school';
            currentResults = list;

            if (!list || list.length === 0) {
                showEmpty(inputNama.value);
                return;
            }

            let html = `
                <div class="px-3.5 py-2 bg-gray-50 dark:bg-gray-700/50 text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                    <span>Hasil Pencarian Database Nasional (${list.length})</span>
                    <span class="text-[9px] text-gray-400">Klik untuk isi otomatis</span>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700/60 max-h-64 overflow-y-auto">
            `;

            list.forEach((item, idx) => {
                const nama = escapeHtml(item.nama || '-');
                const npsn = escapeHtml(item.npsn || '-');
                const bentuk = escapeHtml(item.bentukPendidikan || '-');
                const status = escapeHtml(item.statusSatuanPendidikan || '');
                const desa = escapeHtml(item.alamat?.nama_desa || '');
                const kec = escapeHtml(item.alamat?.nama_kecamatan || '');
                const kab = escapeHtml(item.alamat?.nama_kabupaten || '');
                const prov = escapeHtml(item.alamat?.nama_provinsi || '');

                // Susun lokasi lengkap (Desa, Kec, Kab, Prov) agar user tidak salah pilih sekolah dengan nama sama
                let locParts = [];
                if (desa) locParts.push('Desa ' + toTitleCase(desa));
                if (kec) locParts.push('Kec. ' + toTitleCase(kec));
                if (kab) locParts.push(toTitleCase(kab));
                if (prov) locParts.push(toTitleCase(prov));
                const fullLokasi = locParts.join(', ');

                const statusBadge = status.toUpperCase().includes('NEGERI') 
                    ? '<span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">NEGERI</span>'
                    : '<span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300">SWASTA</span>';

                html += `
                    <div class="sekolah-item p-3 hover:bg-brand-50/60 dark:hover:bg-brand-500/10 cursor-pointer transition-colors" data-index="${idx}">
                        <div class="flex items-start justify-between gap-2">
                            <h5 class="text-xs font-bold text-gray-900 dark:text-white leading-snug">${nama}</h5>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-300 shrink-0">
                                ${bentuk}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-1.5 text-[11px] text-gray-500 dark:text-gray-400">
                            <span class="font-mono font-medium text-gray-600 dark:text-gray-300">NPSN: ${npsn}</span>
                            <span>&bull;</span>
                            ${statusBadge}
                        </div>
                        ${fullLokasi ? `
                            <div class="flex items-center gap-1 mt-1 text-[10px] text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-[12px] text-brand-500">location_on</span>
                                <span class="truncate">${fullLokasi}</span>
                            </div>
                        ` : ''}
                    </div>
                `;
            });

            html += `
                </div>
                <div class="p-2.5 bg-gray-50 dark:bg-gray-700/40 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-[11px]">
                    <span class="text-gray-500 dark:text-gray-400 text-[10px]">Nama sekolah terlalu umum?</span>
                    <button type="button" class="btn-open-bantuan-wilayah font-bold text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">tune</span>
                        <span>Saring per Wilayah (Prov &rarr; Kab &rarr; Kec &rarr; Desa)</span>
                    </button>
                </div>
            `;
            dropdown.innerHTML = html;
            dropdown.classList.remove('hidden');

            dropdown.querySelectorAll('.btn-open-bantuan-wilayah').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    openBantuanWilayah();
                    hideDropdown();
                });
            });

            dropdown.querySelectorAll('.sekolah-item').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const idx = parseInt(this.getAttribute('data-index'), 10);
                    if (currentResults[idx]) {
                        applySchool(currentResults[idx]);
                    }
                });
            });
        }

        async function fetchSekolah(query) {
            if (!query || query.trim().length < 3) {
                hideDropdown();
                return;
            }

            showLoading();

            try {
                const url = '<?= base_url('siswa/biodata/search-sekolah') ?>?q=' + encodeURIComponent(query.trim());
                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();

                if (json && json.success && Array.isArray(json.data) && json.data.length > 0) {
                    renderResults(json.data);
                } else {
                    showEmpty(query);
                }
            } catch (err) {
                console.error('Error fetching data sekolah:', err);
                showEmpty(query);
            }
        }

        // Live input dengan debounce pada pencarian utama
        inputNama.addEventListener('input', function() {
            const val = this.value;
            if (btnClear) {
                btnClear.classList.toggle('hidden', !val);
            }
            if (badgeStatus) {
                badgeStatus.classList.add('hidden');
            }

            clearTimeout(debounceTimer);
            if (val.trim().length < 3) {
                hideDropdown();
                return;
            }

            debounceTimer = setTimeout(() => {
                fetchSekolah(val);
            }, 350);
        });

        // Tombol hapus/bersihkan
        if (btnClear) {
            btnClear.addEventListener('click', function(e) {
                e.stopPropagation();
                inputNama.value = '';
                this.classList.add('hidden');
                if (badgeStatus) badgeStatus.classList.add('hidden');
                hideDropdown();
                inputNama.focus();
                dispatchChanges([inputNama]);
            });
        }

        // Pencarian via NPSN
        if (btnCariNpsn && inputNpsn) {
            btnCariNpsn.addEventListener('click', function() {
                const val = inputNpsn.value.trim();
                if (val.length < 8) {
                    alert('Silakan masukkan 8 digit NPSN yang valid.');
                    inputNpsn.focus();
                    return;
                }
                fetchSekolah(val);
            });

            inputNpsn.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (this.value.trim().length >= 8) {
                        fetchSekolah(this.value.trim());
                    }
                }
            });
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && e.target !== inputNama) {
                hideDropdown();
            }
        });

        // ═══════════════════════════════════════════════════
        // OPSI BANTUAN: FILTER WILAYAH (Tingkat -> Prov -> Kab -> Kec -> Desa)
        // ═══════════════════════════════════════════════════
        function openBantuanWilayah() {
            if (!panelFilterWilayah) return;
            panelFilterWilayah.classList.remove('hidden');
            if (labelToggleWilayah) {
                labelToggleWilayah.textContent = 'Tutup Bantuan Wilayah';
            }
            initFilterProvinces();
            setTimeout(() => {
                panelFilterWilayah.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }

        if (btnToggleWilayah && panelFilterWilayah) {
            btnToggleWilayah.addEventListener('click', function() {
                const isHidden = panelFilterWilayah.classList.contains('hidden');
                panelFilterWilayah.classList.toggle('hidden', !isHidden);
                if (isHidden) {
                    labelToggleWilayah.textContent = 'Tutup Bantuan Wilayah';
                    initFilterProvinces();
                } else {
                    labelToggleWilayah.textContent = 'Bantuan: Cari Berdasarkan Wilayah';
                }
            });
        }

        async function initFilterProvinces() {
            if (!filterProvinsi || filterProvinsi.options.length > 1) return; // sudah dimuat

            try {
                filterProvinsi.innerHTML = '<option value="">Memuat provinsi...</option>';
                const res = await fetch(`${EMSIFA_BASE}/provinces.json`);
                provincesCache = await res.json();

                filterProvinsi.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
                provincesCache.forEach(prov => {
                    const opt = document.createElement('option');
                    opt.value = prov.name;
                    opt.textContent = prov.name;
                    opt.dataset.id = prov.id;
                    filterProvinsi.appendChild(opt);
                });
            } catch (err) {
                console.error('Error loading provinces for filter:', err);
                filterProvinsi.innerHTML = '<option value="">Gagal memuat provinsi</option>';
            }
        }

        async function loadFilterRegencies(provId, selectedKabName = '', selectedKecName = '', selectedDesaName = '') {
            try {
                filterKabupaten.innerHTML = '<option value="">Memuat kabupaten...</option>';
                filterKabupaten.disabled = false;
                filterKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                filterKecamatan.disabled = true;
                if (filterDesa) {
                    filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
                    filterDesa.disabled = true;
                }

                const res = await fetch(`${EMSIFA_BASE}/regencies/${provId}.json`);
                const regencies = await res.json();

                filterKabupaten.innerHTML = '<option value="">-- Pilih Kabupaten / Kota --</option>';
                regencies.forEach(reg => {
                    const opt = document.createElement('option');
                    opt.value = reg.name;
                    opt.textContent = reg.name;
                    opt.dataset.id = reg.id;
                    if (selectedKabName && reg.name.toUpperCase().includes(selectedKabName.toUpperCase())) {
                        opt.selected = true;
                    }
                    filterKabupaten.appendChild(opt);
                });

                if (selectedKabName && filterKabupaten.selectedIndex > 0) {
                    const chosen = filterKabupaten.options[filterKabupaten.selectedIndex];
                    await loadFilterDistricts(chosen.dataset.id, selectedKecName, selectedDesaName);
                }
            } catch (err) {
                console.error('Error loading regencies:', err);
                filterKabupaten.innerHTML = '<option value="">Gagal memuat kab/kota</option>';
            }
        }

        async function loadFilterDistricts(kabId, selectedKecName = '', selectedDesaName = '') {
            try {
                filterKecamatan.innerHTML = '<option value="">Memuat kecamatan...</option>';
                filterKecamatan.disabled = false;
                if (filterDesa) {
                    filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
                    filterDesa.disabled = true;
                }

                const res = await fetch(`${EMSIFA_BASE}/districts/${kabId}.json`);
                const districts = await res.json();

                filterKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                districts.forEach(dist => {
                    const opt = document.createElement('option');
                    opt.value = dist.name;
                    opt.textContent = dist.name;
                    opt.dataset.id = dist.id;
                    if (selectedKecName && dist.name.toUpperCase().includes(selectedKecName.toUpperCase())) {
                        opt.selected = true;
                    }
                    filterKecamatan.appendChild(opt);
                });

                if (selectedKecName && filterKecamatan.selectedIndex > 0) {
                    const chosenKec = filterKecamatan.options[filterKecamatan.selectedIndex];
                    await loadFilterVillages(chosenKec.dataset.id, selectedDesaName);
                    await triggerWilayahSearch();
                }
            } catch (err) {
                console.error('Error loading districts:', err);
                filterKecamatan.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
            }
        }

        async function loadFilterVillages(distId, selectedDesaName = '') {
            if (!filterDesa) return;
            try {
                filterDesa.innerHTML = '<option value="">Memuat desa...</option>';
                filterDesa.disabled = false;

                const res = await fetch(`${EMSIFA_BASE}/villages/${distId}.json`);
                const villages = await res.json();

                filterDesa.innerHTML = '<option value="">-- Semua Desa / Kelurahan --</option>';
                villages.forEach(v => {
                    const opt = document.createElement('option');
                    opt.value = v.name;
                    opt.textContent = v.name;
                    opt.dataset.id = v.id;
                    if (selectedDesaName && v.name.toUpperCase().includes(selectedDesaName.toUpperCase())) {
                        opt.selected = true;
                    }
                    filterDesa.appendChild(opt);
                });
            } catch (err) {
                console.error('Error loading villages:', err);
                filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
            }
        }

        // Listener perubahan dropdown Provinsi
        filterProvinsi.addEventListener('change', function() {
            const chosen = this.options[this.selectedIndex];
            if (chosen && chosen.dataset.id) {
                loadFilterRegencies(chosen.dataset.id);
            } else {
                filterKabupaten.innerHTML = '<option value="">-- Pilih Kab/Kota --</option>';
                filterKabupaten.disabled = true;
                filterKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                filterKecamatan.disabled = true;
                if (filterDesa) {
                    filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
                    filterDesa.disabled = true;
                }
                wrapperHasilWilayah.classList.add('hidden');
            }
        });

        // Listener perubahan dropdown Kabupaten
        filterKabupaten.addEventListener('change', function() {
            const chosen = this.options[this.selectedIndex];
            if (chosen && chosen.dataset.id) {
                loadFilterDistricts(chosen.dataset.id);
            } else {
                filterKecamatan.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                filterKecamatan.disabled = true;
                if (filterDesa) {
                    filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
                    filterDesa.disabled = true;
                }
                wrapperHasilWilayah.classList.add('hidden');
            }
        });

        // Listener perubahan dropdown Kecamatan
        filterKecamatan.addEventListener('change', async function() {
            const chosen = this.options[this.selectedIndex];
            if (chosen && chosen.dataset.id) {
                await loadFilterVillages(chosen.dataset.id);
            } else if (filterDesa) {
                filterDesa.innerHTML = '<option value="">-- Semua Desa --</option>';
                filterDesa.disabled = true;
            }
            triggerWilayahSearch();
        });

        // Listener perubahan dropdown Desa, Tingkat & Keyword
        if (filterDesa) {
            filterDesa.addEventListener('change', function() {
                renderWilayahDropdown();
            });
        }

        filterTingkat.addEventListener('change', triggerWilayahSearch);

        if (filterKeywordWilayah) {
            let filterDebounce = null;
            filterKeywordWilayah.addEventListener('input', function() {
                clearTimeout(filterDebounce);
                filterDebounce = setTimeout(() => {
                    renderWilayahDropdown();
                }, 200);
            });
        }

        // Fungsi panggil pencarian berdasarkan wilayah & tingkat
        async function triggerWilayahSearch() {
            const kecName = filterKecamatan.value;
            const kabName = filterKabupaten.value;
            const tingkatVal = filterTingkat.value;

            if (!kecName && !kabName) {
                wrapperHasilWilayah.classList.add('hidden');
                return;
            }

            const queryLocation = kecName || kabName;
            selectSekolahWilayah.innerHTML = '<option value="">Memuat daftar sekolah di wilayah ini...</option>';
            wrapperHasilWilayah.classList.remove('hidden');

            try {
                let url = '<?= base_url('siswa/biodata/search-sekolah') ?>?q=' + encodeURIComponent(queryLocation) + '&limit=100';
                if (tingkatVal) {
                    url += '&bentuk=' + encodeURIComponent(tingkatVal);
                }

                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();

                if (json && json.success && Array.isArray(json.data) && json.data.length > 0) {
                    currentWilayahResults = json.data;
                    renderWilayahDropdown();
                } else {
                    currentWilayahResults = [];
                    countHasilWilayah.textContent = '0 sekolah';
                    selectSekolahWilayah.innerHTML = `<option value="">Tidak ada data sekolah di ${toTitleCase(queryLocation)} (Tingkat: ${tingkatVal || 'Semua'}). Anda dapat mengetik manual di kolom atas.</option>`;
                }
            } catch (err) {
                console.error('Error fetching wilayah schools:', err);
                selectSekolahWilayah.innerHTML = '<option value="">Gagal memuat sekolah di wilayah ini.</option>';
            }
        }

        // Render hasil pilihan dropdown wilayah dengan filter Desa & kata kunci
        function renderWilayahDropdown() {
            if (!currentWilayahResults || currentWilayahResults.length === 0) {
                countHasilWilayah.textContent = '0 sekolah';
                selectSekolahWilayah.innerHTML = '<option value="">Tidak ada data sekolah di wilayah ini.</option>';
                return;
            }

            const selectedDesa = (filterDesa ? filterDesa.value : '').trim().toUpperCase();
            const keyword = (filterKeywordWilayah ? filterKeywordWilayah.value : '').trim().toUpperCase();

            let matchedList = currentWilayahResults.filter(sch => {
                // Filter Desa jika dipilih
                if (selectedDesa) {
                    const schDesa = (sch.alamat?.nama_desa || '').toUpperCase();
                    if (!schDesa.includes(selectedDesa) && !selectedDesa.includes(schDesa)) {
                        return false;
                    }
                }
                // Filter kata kunci pencarian lokal jika diketik
                if (keyword) {
                    const schNama = (sch.nama || '').toUpperCase();
                    const schNpsn = (sch.npsn || '').toUpperCase();
                    if (!schNama.includes(keyword) && !schNpsn.includes(keyword)) {
                        return false;
                    }
                }
                return true;
            });

            const displayList = (matchedList.length > 0) ? matchedList : currentWilayahResults;
            const isFallback = (matchedList.length === 0 && selectedDesa);

            if (isFallback) {
                countHasilWilayah.textContent = `0 di Desa, ${currentWilayahResults.length} di Kecamatan`;
            } else {
                countHasilWilayah.textContent = `${matchedList.length} sekolah ditemukan`;
            }

            const locationLabel = selectedDesa && !isFallback 
                ? `Desa ${toTitleCase(selectedDesa)}` 
                : `Kecamatan ${toTitleCase(filterKecamatan.value || filterKabupaten.value)}`;

            let opts = `<option value="">-- Pilih Sekolah Asal Anda (${displayList.length} Sekolah di ${locationLabel}) --</option>`;
            displayList.forEach(sch => {
                const originalIndex = currentWilayahResults.indexOf(sch);
                const status = sch.statusSatuanPendidikan || '';
                const npsn = sch.npsn ? ` [NPSN: ${sch.npsn}]` : '';
                const bentuk = sch.bentukPendidikan ? `[${sch.bentukPendidikan}] ` : '';
                const desa = sch.alamat?.nama_desa ? ` - Desa ${toTitleCase(sch.alamat.nama_desa)}` : '';
                opts += `<option value="${originalIndex}">${bentuk}${sch.nama}${npsn} (${status})${desa}</option>`;
            });

            selectSekolahWilayah.innerHTML = opts;
        }

        // Listener saat siswa memilih sekolah dari dropdown wilayah
        selectSekolahWilayah.addEventListener('change', function() {
            const idx = parseInt(this.value, 10);
            if (!isNaN(idx) && currentWilayahResults[idx]) {
                applySchool(currentWilayahResults[idx]);
                // Highlight input
                inputNama.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });

        // Tombol Gunakan Wilayah Domisili Saya
        if (btnPakaiDomisili) {
            btnPakaiDomisili.addEventListener('click', async function() {
                // Periksa data domisili siswa dari window.savedValues jika ada
                const saved = window.savedValues || {};
                const provDomisili = saved.prov || '';
                const kabDomisili = saved.kab || '';
                const kecDomisili = saved.kec || '';
                const desaDomisili = saved.desa || '';

                if (!provDomisili && !kabDomisili) {
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Wilayah Domisili Belum Terisi',
                            text: 'Silakan isi Alamat Domisili Anda pada tab Alamat terlebih dahulu, atau pilih Provinsi dan Kabupaten secara manual di bawah ini.'
                        });
                    } else {
                        alert('Data domisili belum terisi pada tab Alamat.');
                    }
                    return;
                }

                await initFilterProvinces();

                // Pilih provinsi
                for (let i = 0; i < filterProvinsi.options.length; i++) {
                    if (filterProvinsi.options[i].value.toUpperCase() === provDomisili.toUpperCase()) {
                        filterProvinsi.selectedIndex = i;
                        const provId = filterProvinsi.options[i].dataset.id;
                        await loadFilterRegencies(provId, kabDomisili, kecDomisili, desaDomisili);
                        break;
                    }
                }
            });
        }
    });
})();
</script>
