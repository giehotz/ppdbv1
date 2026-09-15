<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Profil & Biodata Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<i class="fas fa-address-card mr-2 text-blue-600 dark:text-blue-400"></i> Dashboard Profil & Biodata Siswa
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
/* ============================================================
   SISWA LIST DASHBOARD — Scoped styles for Excel-themed detail
   ============================================================ */

/* Split panel height */
.sl-wrapper {
    display: flex;
    gap: 0;
    height: calc(100vh - 180px);
    min-height: 480px;
}
.sl-panel-left {
    width: 400px;
    min-width: 320px;
    display: flex;
    flex-direction: column;
}
.sl-panel-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Left table scrollable body */
.sl-table-wrap {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
}

/* Active row highlight */
#tblLeft tbody tr.active-row td {
    background-color: rgba(59, 130, 246, 0.12) !important;
}
html.dark #tblLeft tbody tr.active-row td {
    background-color: rgba(59, 130, 246, 0.2) !important;
}

/* Detail scrollable */
.sl-detail-wrap {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px;
}

/* Section group cards */
.bio-section {
    margin-bottom: 16px;
}
.bio-section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    margin-bottom: 6px;
    color: #fff;
}
.bio-section-title.sec-personal { background: linear-gradient(135deg, #002060, #1a3a7a); }
.bio-section-title.sec-family   { background: linear-gradient(135deg, #1e4620, #2d6a30); }
.bio-section-title.sec-parents  { background: linear-gradient(135deg, #00579a, #0077c2); }
.bio-section-title.sec-address  { background: linear-gradient(135deg, #4a1d6a, #6b3fa0); }

html.dark .bio-section-title.sec-personal { background: linear-gradient(135deg, #1e3a5f, #2a4a7a); }
html.dark .bio-section-title.sec-family   { background: linear-gradient(135deg, #1a3520, #2a5530); }
html.dark .bio-section-title.sec-parents  { background: linear-gradient(135deg, #0a4570, #1a6590); }
html.dark .bio-section-title.sec-address  { background: linear-gradient(135deg, #3a1a5a, #5a3580); }

.bio-section-body {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
html.dark .bio-section-body {
    border-color: #374151;
}

/* Bio rows */
.bio-row {
    display: flex;
    align-items: stretch;
    border-bottom: 1px solid #e5e7eb;
    font-size: 12.5px;
    transition: background-color .15s;
}
.bio-row:last-child { border-bottom: none; }
.bio-row:hover { background-color: rgba(59,130,246,.04); }
html.dark .bio-row { border-color: #374151; }
html.dark .bio-row:hover { background-color: rgba(59,130,246,.08); }

.bio-row .bio-label {
    width: 210px;
    min-width: 150px;
    padding: 8px 12px;
    font-weight: 600;
    color: #374151;
    background: #f9fafb;
    display: flex;
    align-items: center;
    flex-shrink: 0;
    border-right: 1px solid #e5e7eb;
}
html.dark .bio-row .bio-label {
    background: rgba(255,255,255,.03);
    color: #d1d5db;
    border-color: #374151;
}

.bio-row .bio-value {
    flex: 1;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    color: #111827;
    min-width: 0;
}
html.dark .bio-row .bio-value { color: #f3f4f6; }

.bio-row .bio-value .val-text {
    flex: 1;
    min-width: 0;
    word-break: break-word;
}

/* Accent stripe for highlighted rows */
.bio-row.accent-navy    { border-left: 4px solid #002060; }
.bio-row.accent-green   { border-left: 4px solid #00b050; }
.bio-row.accent-dkgreen { border-left: 4px solid #1e4620; }
.bio-row.accent-cyan    { border-left: 4px solid #00b0f0; }

/* Copy button — always visible */
.btn-copy-row {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 3px 8px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #f3f4f6;
    color: #6b7280;
    font-size: 11px;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-copy-row:hover {
    background: #e5e7eb;
    color: #374151;
    border-color: #9ca3af;
}
html.dark .btn-copy-row {
    background: #374151;
    border-color: #4b5563;
    color: #9ca3af;
}
html.dark .btn-copy-row:hover {
    background: #4b5563;
    color: #e5e7eb;
    border-color: #6b7280;
}

/* Dropdown — modern style */
.sl-select-nama {
    flex: 1;
    padding: 6px 10px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #fff;
    color: #111827;
    outline: none;
    transition: border-color .2s;
    min-width: 0;
}
.sl-select-nama:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
html.dark .sl-select-nama {
    background: #1f2937;
    border-color: #4b5563;
    color: #f3f4f6;
}
html.dark .sl-select-nama:focus { border-color: #60a5fa; box-shadow: 0 0 0 3px rgba(96,165,250,.15); }

/* Toast */
.sl-toast {
    position: fixed; bottom: 24px; right: 24px;
    background: #065f46; color: #fff;
    padding: 10px 20px; border-radius: 8px;
    font-size: 13px; font-weight: 600;
    box-shadow: 0 4px 16px rgba(0,0,0,.25);
    opacity: 0; transform: translateY(16px);
    transition: all .3s ease; z-index: 9999; pointer-events: none;
}
.sl-toast.show { opacity: 1; transform: translateY(0); }

/* Mobile tab switcher */
.sl-tab-switch { display: none; }
.sl-tab-switch button {
    flex: 1;
    padding: 11px 0;
    border: none;
    background: transparent;
    color: rgba(255,255,255,.5);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.sl-tab-switch button.active {
    color: #fff;
    background: rgba(255,255,255,.08);
    border-bottom: 3px solid #3b82f6;
}
.sl-tab-switch button i { font-size: 12px; }

/* ============================================================
   RESPONSIVE — TABLET (≤ 900px)
   ============================================================ */
@media (max-width: 900px) {
    .sl-wrapper {
        flex-direction: column;
        height: auto;
        min-height: calc(100vh - 160px);
    }
    .sl-panel-left {
        width: 100%;
        min-width: unset;
        border-right: none !important;
        border-bottom: 1px solid;
    }
    .sl-panel-right { min-height: 400px; }
    .sl-tab-switch { display: flex; }
    .sl-panel-left.hidden-mobile,
    .sl-panel-right.hidden-mobile { display: none !important; }

    .bio-row .bio-label { width: 180px; min-width: 120px; font-size: 12px; }
    .bio-row .bio-value { font-size: 12px; }
}

/* ============================================================
   RESPONSIVE — SMARTPHONE (≤ 640px)
   ============================================================ */
@media (max-width: 640px) {
    /* Detail padding reduced */
    .sl-detail-wrap { padding: 10px; }

    /* Bio rows: stack vertically */
    .bio-row {
        flex-direction: column;
        align-items: stretch;
    }
    .bio-row .bio-label {
        width: 100%;
        min-width: unset;
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
        padding: 6px 10px;
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: #f3f4f6;
    }
    html.dark .bio-row .bio-label {
        background: rgba(255,255,255,.04);
        border-color: #374151;
        color: #9ca3af;
    }
    .bio-row .bio-value {
        padding: 8px 10px;
        font-size: 13px;
        font-weight: 500;
    }

    /* Accent stripe adapts to top border on mobile */
    .bio-row.accent-navy    { border-left: none; border-top: 3px solid #002060; }
    .bio-row.accent-green   { border-left: none; border-top: 3px solid #00b050; }
    .bio-row.accent-dkgreen { border-left: none; border-top: 3px solid #1e4620; }
    .bio-row.accent-cyan    { border-left: none; border-top: 3px solid #00b0f0; }

    /* Copy button: compact icon-only on mobile */
    .btn-copy-row {
        padding: 5px 8px;
        font-size: 12px;
        border-radius: 6px;
    }
    .btn-copy-row i { font-size: 11px !important; }

    /* Dropdown full-width */
    .sl-select-nama {
        width: 100%;
        font-size: 14px;
        padding: 8px 10px;
    }

    /* Section titles smaller */
    .bio-section-title {
        font-size: 11px;
        padding: 7px 12px;
        border-radius: 8px;
    }
    .bio-section { margin-bottom: 12px; }
    .bio-section-body { border-radius: 8px; }

    /* Toast repositioned */
    .sl-toast {
        bottom: 16px;
        right: 12px;
        left: 12px;
        text-align: center;
        font-size: 12px;
        padding: 8px 16px;
    }

    /* Table left: compact */
    #tblLeft th { font-size: 10px; padding: 8px 4px; }
    #tblLeft td { padding: 8px 4px; }
    #tblLeft .truncate { max-width: 110px; }
}

/* ============================================================
   RESPONSIVE — VERY SMALL (≤ 380px)
   ============================================================ */
@media (max-width: 380px) {
    .bio-row .bio-value { font-size: 12px; }
    .btn-copy-row span.copy-label { display: none; }
    .sl-select-nama { font-size: 13px; }
    .bio-section-title { font-size: 10px; padding: 6px 10px; }
}

/* Checkbox sizing for touch */
.chk-siswa { min-width: 18px; min-height: 18px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Toast notification -->
<div class="sl-toast" id="slToast"></div>

<!-- Mobile Tab Switcher -->
<div class="sl-tab-switch rounded-t-2xl bg-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700" id="slTabSwitch">
    <button class="active" data-panel="left" id="tabBtnLeft">📋 Daftar Siswa</button>
    <button data-panel="right" id="tabBtnRight">👤 Detail Siswa</button>
</div>

<!-- Main Two-Panel Layout -->
<div class="sl-wrapper overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]" id="slWrapper">

    <!-- ==================== PANEL KIRI ==================== -->
    <div class="sl-panel-left border-r border-gray-200 dark:border-gray-800" id="panelLeft">

        <!-- Header & Search -->
        <div class="border-b border-gray-100 dark:border-gray-800 px-4 py-3 space-y-2.5">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-list-ul text-xs text-gray-400"></i> Daftar Siswa
                </h3>
                <span class="text-[11px] font-semibold text-gray-400 dark:text-gray-500" id="slTotalInfo">0 siswa</span>
            </div>

            <!-- Filter Tahun Ajaran -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-blue-500">
                    <i class="fas fa-calendar-alt text-xs"></i>
                </div>
                <select id="slThPelajaran"
                    class="w-full h-9 pl-8 pr-7 text-xs font-semibold rounded-lg border border-gray-200 bg-gray-50/70 text-gray-800 focus:border-blue-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-900/70 dark:text-gray-100 dark:focus:bg-gray-900 transition-colors cursor-pointer appearance-none shadow-theme-xs">
                    <?php foreach (($tahunList ?? []) as $t): ?>
                        <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= (($selectedTh ?? '') === $t['tahun_pelajaran']) ? 'selected' : '' ?>>
                            Tahun Ajaran: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '★ (Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="all" <?= (($selectedTh ?? '') === 'all') ? 'selected' : '' ?>>Semua Tahun Ajaran</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
                    <i class="fas fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <!-- Live Search -->
            <div class="flex items-center h-9 rounded-lg border border-gray-200 bg-gray-50/50 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900/50 overflow-hidden focus-within:border-blue-500 focus-within:bg-white dark:focus-within:bg-gray-900 transition-colors">
                <div class="pl-3 text-gray-400 pointer-events-none">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text"
                    id="slSearch"
                    placeholder="Cari nama, NISN, atau desa…"
                    autocomplete="off"
                    class="h-full flex-1 bg-transparent py-1.5 px-2.5 text-xs text-gray-800 placeholder:text-gray-400 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder:text-gray-500">
            </div>
        </div>

        <!-- Info bar: counter + badge + salin -->
        <div class="flex items-center justify-between gap-2 px-4 py-2 border-b border-gray-100 dark:border-gray-800 bg-gray-50/40 dark:bg-gray-800/20 flex-wrap">
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-bold text-blue-700 dark:text-blue-400" id="slCounter">Terpilih: 0</span>
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800" id="slThBadge" title="Tahun Ajaran Aktif">
                    <i class="fas fa-calendar-check text-[9px]"></i> <span id="slThBadgeText"><?= esc(($selectedTh === 'all') ? 'Semua TA' : ($selectedTh ?? '')) ?></span>
                </span>
            </div>
            <button id="btnSalinTerpilih"
                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[11px] font-semibold bg-gray-900 text-white hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors shadow-theme-xs"
                title="Salin data siswa yang dicentang">
                📋 Salin Terpilih
            </button>
        </div>

        <!-- Left Table -->
        <div class="sl-table-wrap">
            <table class="w-full text-left" id="tblLeft">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                        <th class="py-3 px-2 text-center w-10">
                            <i class="fas fa-check-square text-[10px]" title="Centang per siswa"></i>
                        </th>
                        <th class="py-3 px-2 text-center w-8">No</th>
                        <th class="py-3 px-3">Nama Siswa</th>
                        <th class="py-3 px-2 w-8">L/P</th>
                        <th class="py-3 px-3 w-20">NISN</th>
                    </tr>
                </thead>
                <tbody id="tblLeftBody" class="divide-y divide-gray-100 text-xs dark:divide-gray-800"></tbody>
            </table>
        </div>
    </div>

    <!-- ==================== PANEL KANAN ==================== -->
    <div class="sl-panel-right" id="panelRight">

        <!-- Detail header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-800 bg-gray-50/40 dark:bg-gray-800/20 flex-wrap gap-2">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2" id="detailTitle">
                <i class="fas fa-id-card text-xs text-gray-400"></i> Detail Biodata Siswa
            </h3>
            <button id="btnSalinSemua"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-blue-600 text-white hover:bg-blue-700 transition-colors shadow-theme-xs"
                title="Salin seluruh biodata siswa aktif">
                <i class="fas fa-copy text-[10px]"></i> Salin Semua
            </button>
        </div>

        <!-- Detail content -->
        <div class="sl-detail-wrap" id="detailWrap">
            <div class="flex flex-col items-center justify-center h-full text-gray-400 dark:text-gray-600 gap-4 p-10 text-center" id="detailEmpty">
                <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fas fa-user-circle text-4xl opacity-30"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada siswa dipilih</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Klik nama siswa di panel kiri untuk melihat detail biodata</p>
                </div>
            </div>
            <div id="detailContent" style="display:none"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    'use strict';

    // ============ CONFIG ============
    const URL_GET_DATA     = '<?= base_url("admin/siswa-list/get-data") ?>';
    const URL_UPDATE_CHK   = '<?= base_url("admin/siswa-list/update-checklist") ?>';
    let csrfToken          = '<?= csrf_hash() ?>';
    const csrfName         = '<?= csrf_token() ?>';

    // ============ STATE ============
    let allSiswa     = [];
    let filteredList = [];
    let activeId     = null;

    // ============ DOM REFS ============
    const $thPelajaran  = document.getElementById('slThPelajaran');
    const $thBadgeText  = document.getElementById('slThBadgeText');
    const $search       = document.getElementById('slSearch');
    const $tblLeftBody  = document.getElementById('tblLeftBody');
    const $counter      = document.getElementById('slCounter');
    const $totalInfo    = document.getElementById('slTotalInfo');
    const $detailEmpty  = document.getElementById('detailEmpty');
    const $detailContent= document.getElementById('detailContent');
    const $toast        = document.getElementById('slToast');
    const $panelLeft    = document.getElementById('panelLeft');
    const $panelRight   = document.getElementById('panelRight');
    const $tabBtnLeft   = document.getElementById('tabBtnLeft');
    const $tabBtnRight  = document.getElementById('tabBtnRight');

    // ============ HELPERS ============
    function esc(str) {
        if (str === null || str === undefined || str === '') return '-';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    function showToast(msg) {
        $toast.textContent = msg;
        $toast.classList.add('show');
        setTimeout(() => $toast.classList.remove('show'), 1800);
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => showToast('✅ Tersalin!'));
        } else {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            showToast('✅ Tersalin!');
        }
    }

    function ajaxPost(url, data, cb) {
        data[csrfName] = csrfToken;
        const fd = new URLSearchParams(data);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: fd.toString()
        })
        .then(r => r.json())
        .then(json => {
            if (json.csrf) csrfToken = json.csrf;
            cb(json);
        })
        .catch(err => console.error(err));
    }

    // ============ LOAD DATA ============
    function loadData(th) {
        const selectedYear = th !== undefined ? th : ($thPelajaran ? $thPelajaran.value : '<?= esc($selectedTh ?? '') ?>');

        $tblLeftBody.innerHTML = `<tr><td colspan="5" class="py-10 text-center text-gray-400 dark:text-gray-500">
            <i class="fas fa-circle-notch fa-spin text-2xl mb-2 text-blue-500 block"></i> Memuat data siswa...
        </td></tr>`;
        $totalInfo.textContent = 'Memuat...';

        const url = URL_GET_DATA + '?th_pelajaran=' + encodeURIComponent(selectedYear);

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(json => {
            if (json.csrf) csrfToken = json.csrf;
            allSiswa = json.data || [];

            // Reset detail jika siswa yang sedang dilihat tidak ada di data tahun ajaran baru
            if (activeId && !allSiswa.some(s => s.id_siswa == activeId)) {
                activeId = null;
                $detailEmpty.style.display = 'flex';
                if ($detailContent) {
                    $detailContent.style.display = 'none';
                    $detailContent.innerHTML = '';
                }
            }

            applyFilter();
        })
        .catch(err => {
            console.error('Load error:', err);
            $tblLeftBody.innerHTML = `<tr><td colspan="5" class="py-10 text-center text-red-500">
                <i class="fas fa-exclamation-triangle text-2xl mb-2 block"></i> Gagal memuat data
            </td></tr>`;
            $totalInfo.textContent = '0 siswa';
        });
    }

    // ============ FILTER ============
    function applyFilter() {
        const q = ($search.value || '').toLowerCase().trim();
        filteredList = allSiswa.filter(s => {
            if (!q) return true;
            return (s.nama_lengkap || '').toLowerCase().includes(q)
                || (s.nisn || '').toLowerCase().includes(q)
                || (s.desa || '').toLowerCase().includes(q);
        });
        renderLeftTable();
        updateCounter();
        $totalInfo.textContent = filteredList.length + ' siswa';
    }

    // ============ RENDER LEFT TABLE ============
    function renderLeftTable() {
        let html = '';
        filteredList.forEach((s, i) => {
            const checked = s.is_checked == 1 ? 'checked' : '';
            const activeClass = s.id_siswa == activeId ? 'active-row' : '';
            const genderIcon = s.jk === 'L'
                ? '<span class="inline-flex items-center gap-0.5 font-semibold text-blue-600 dark:text-blue-400"><i class="fas fa-mars text-[10px]"></i>L</span>'
                : '<span class="inline-flex items-center gap-0.5 font-semibold text-pink-600 dark:text-pink-400"><i class="fas fa-venus text-[10px]"></i>P</span>';

            html += `<tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors cursor-pointer ${activeClass}" data-id="${s.id_siswa}">
                <td class="py-2.5 px-2 text-center">
                    <input type="checkbox" class="chk-siswa h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" data-id="${s.id_siswa}" ${checked}>
                </td>
                <td class="py-2.5 px-2 text-center text-gray-400 dark:text-gray-500 font-medium">${i + 1}</td>
                <td class="py-2.5 px-3">
                    <span class="font-semibold text-gray-900 dark:text-gray-100 truncate block max-w-[160px]" title="${esc(s.nama_lengkap)}">${esc(s.nama_lengkap)}</span>
                </td>
                <td class="py-2.5 px-2">${genderIcon}</td>
                <td class="py-2.5 px-3 font-mono text-gray-500 dark:text-gray-400 text-[11px]">${esc(s.nisn)}</td>
            </tr>`;
        });
        $tblLeftBody.innerHTML = html || `<tr><td colspan="5" class="py-10 text-center text-gray-400 dark:text-gray-600">
            <i class="fas fa-inbox text-3xl opacity-30 block mb-2"></i>Tidak ada data
        </td></tr>`;
        bindLeftTableEvents();
    }

    // ============ LEFT TABLE EVENTS ============
    function bindLeftTableEvents() {
        // Row click → show detail
        document.querySelectorAll('#tblLeftBody tr[data-id]').forEach(tr => {
            tr.addEventListener('click', function (e) {
                if (e.target.type === 'checkbox') return;
                selectSiswa(parseInt(this.dataset.id));
            });
        });

        // Individual checkbox → single AJAX update (no bulk)
        document.querySelectorAll('.chk-siswa').forEach(chk => {
            chk.addEventListener('change', function (e) {
                e.stopPropagation();
                const id = parseInt(this.dataset.id);
                const val = this.checked ? 1 : 0;
                // Optimistic update
                const s = allSiswa.find(x => x.id_siswa == id);
                if (s) s.is_checked = val;
                updateCounter();
                ajaxPost(URL_UPDATE_CHK, { id_siswa: id, is_checked: val }, (json) => {
                    if (json.status !== 'success') {
                        // Rollback on failure
                        if (s) s.is_checked = val ? 0 : 1;
                        this.checked = !this.checked;
                        updateCounter();
                    }
                });
            });
        });
    }

    // ============ COUNTER ============
    function updateCounter() {
        const count = allSiswa.filter(s => s.is_checked == 1).length;
        $counter.textContent = `Terpilih: ${count}`;
    }

    // ============ SELECT SISWA ============
    function selectSiswa(id) {
        activeId = id;
        document.querySelectorAll('#tblLeftBody tr').forEach(tr => tr.classList.remove('active-row'));
        const targetRow = document.querySelector(`#tblLeftBody tr[data-id="${id}"]`);
        if (targetRow) targetRow.classList.add('active-row');
        renderDetail(id);
        switchToTab('right');
    }

    // ============ RENDER DETAIL ============
    const $detailContent = document.getElementById('detailContent');

    function renderDetail(id) {
        const s = allSiswa.find(x => x.id_siswa == id);
        if (!s) return;

        $detailEmpty.style.display = 'none';
        $detailContent.style.display = 'block';

        // Riwayat PraSekolah
        let riwayatPra = [];
        if (s.paud) riwayatPra.push('PAUD: ' + s.paud);
        if (s.tk) riwayatPra.push('TK: ' + s.tk);
        const riwayatPraStr = riwayatPra.length ? riwayatPra.join(', ') : '-';

        // Build grouped sections
        const sections = [
            {
                title: 'Data Pribadi Siswa',
                icon: 'fa-user',
                cls: 'sec-personal',
                rows: [
                    ['Nama Lengkap',          '__DROPDOWN__',          'accent-navy'],
                    ['Tahun Ajaran',          s.th_pelajaran || '-',   'accent-navy'],
                    ['NISN',                  s.nisn,                  ''],
                    ['NIS Lokal',             s.no_pendaftaran,        'accent-green'],
                    ['NIK Siswa',             s.nik,                   ''],
                    ['Tempat Lahir',          s.tempat_lahir,          ''],
                    ['Tanggal Lahir',         formatTgl(s.tgl_lahir),  ''],
                    ['Jenis Kelamin',          s.jk === 'L' ? 'Laki-laki' : (s.jk === 'P' ? 'Perempuan' : s.jk), ''],
                    ['Agama',                  s.agama,               ''],
                    ['Jumlah Saudara',         s.jml_saudara,         ''],
                    ['Anak Ke',                s.anak_ke,             ''],
                    ['Cita-Cita',              s.cita,                ''],
                    ['Hobi',                   s.hobi,                ''],
                    ['Yang Membiayai Sekolah', 'Orang Tua',           ''],
                    ['Riwayat PraSekolah',     riwayatPraStr,         ''],
                ]
            },
            {
                title: 'Data Keluarga',
                icon: 'fa-home',
                cls: 'sec-family',
                rows: [
                    ['No. Kartu Keluarga (KK)',  s.no_kk,             'accent-dkgreen'],
                    ['Nama Kepala Keluarga',     s.kepala_keluarga,   'accent-cyan'],
                ]
            },
            {
                title: 'Data Orang Tua',
                icon: 'fa-users',
                cls: 'sec-parents',
                rows: [
                    ['Nama Ayah',                s.nama_ayah,           ''],
                    ['NIK Ayah',                 s.nik_ayah,            'accent-navy'],
                    ['Tempat Lahir (Ayah)',      s.tempat_lahir_ayah,   ''],
                    ['Tanggal Lahir (Ayah)',     formatTgl(s.tgl_lahir_ayah), ''],
                    ['Pendidikan Terakhir Ayah', s.pdd_ayah,            ''],
                    ['Pekerjaan Utama Ayah',     s.pekerjaan_ayah,      ''],
                    ['Nama Ibu',                 s.nama_ibu,            'accent-navy'],
                    ['NIK Ibu',                  s.nik_ibu,             ''],
                    ['Tempat Lahir (Ibu)',       s.tempat_lahir_ibu,    ''],
                    ['Tanggal Lahir (Ibu)',      formatTgl(s.tgl_lahir_ibu), ''],
                    ['Pendidikan Terakhir Ibu',  s.pdd_ibu,             ''],
                    ['Pekerjaan Utama Ibu',      s.pekerjaan_ibu,       ''],
                    ['No. Handphone Ortu',       s.no_hp_ortu,          ''],
                ]
            },
            {
                title: 'Alamat Tempat Tinggal',
                icon: 'fa-map-marker-alt',
                cls: 'sec-address',
                rows: [
                    ['Alamat Jalan / Dusun',  s.alamat_siswa,  'accent-navy'],
                    ['Provinsi',              s.prov,          ''],
                    ['Kabupaten/Kota',        s.kab,           ''],
                    ['Kecamatan',             s.kec,           ''],
                    ['Desa/Kelurahan',        s.desa,          ''],
                    ['Kode Pos',              s.kode_pos,      ''],
                ]
            }
        ];

        let html = '';
        sections.forEach(sec => {
            html += `<div class="bio-section">`;
            html += `<div class="bio-section-title ${sec.cls}"><i class="fas ${sec.icon} text-xs"></i> ${sec.title}</div>`;
            html += `<div class="bio-section-body">`;
            sec.rows.forEach(([label, value, accent]) => {
                const accentClass = accent ? ' ' + accent : '';
                let valHtml;
                if (value === '__DROPDOWN__') {
                    let opts = '';
                    allSiswa.forEach(x => {
                        const sel = x.id_siswa == s.id_siswa ? 'selected' : '';
                        opts += `<option value="${x.id_siswa}" ${sel}>${esc(x.nama_lengkap)}</option>`;
                    });
                    valHtml = `<select class="sl-select-nama" id="ddNamaSiswa">${opts}</select>
                               <button class="btn-copy-row" onclick="window._slCopy('${escAttr(s.nama_lengkap)}')" title="Salin"><i class="fas fa-copy text-[10px]"></i> Salin</button>`;
                } else {
                    const display = (value !== null && value !== undefined && value !== '') ? value : '-';
                    valHtml = `<span class="val-text">${esc(String(display))}</span>
                               <button class="btn-copy-row" onclick="window._slCopy('${escAttr(String(display))}')" title="Salin"><i class="fas fa-copy text-[10px]"></i> Salin</button>`;
                }
                html += `<div class="bio-row${accentClass}">
                    <div class="bio-label">${esc(label)}</div>
                    <div class="bio-value">${valHtml}</div>
                </div>`;
            });
            html += `</div></div>`;
        });

        $detailContent.innerHTML = html;

        // Bind dropdown sync
        const dd = document.getElementById('ddNamaSiswa');
        if (dd) {
            dd.addEventListener('change', function () {
                const newId = parseInt(this.value);
                selectSiswa(newId);
                const row = document.querySelector(`#tblLeftBody tr[data-id="${newId}"]`);
                if (row) row.scrollIntoView({ block: 'center', behavior: 'smooth' });
            });
        }
    }

    function formatTgl(val) {
        if (!val) return '-';
        const d = new Date(val);
        if (isNaN(d)) return val;
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    function escAttr(str) {
        if (!str) return '';
        return str.replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '&quot;');
    }

    // Global copy function
    window._slCopy = function (text) {
        if (text && text !== '-') copyText(text);
        else showToast('Tidak ada data untuk disalin');
    };

    // ============ SALIN SEMUA (biodata of active student) ============
    document.getElementById('btnSalinSemua').addEventListener('click', function () {
        if (!activeId) { showToast('Pilih siswa terlebih dahulu'); return; }
        const s = allSiswa.find(x => x.id_siswa == activeId);
        if (!s) return;
        copyText(buildBiodataText(s));
    });

    // ============ SALIN TERPILIH ============
    document.getElementById('btnSalinTerpilih').addEventListener('click', function () {
        const selected = allSiswa.filter(s => s.is_checked == 1);
        if (!selected.length) { showToast('Belum ada siswa yang dicentang'); return; }
        const allLines = selected.map((s, i) => {
            return `=== ${i + 1}. ${s.nama_lengkap || '-'} ===\n` + buildBiodataText(s);
        }).join('\n\n');
        copyText(allLines);
    });

    function buildBiodataText(s) {
        let riwayatPra = [];
        if (s.paud) riwayatPra.push('PAUD: ' + s.paud);
        if (s.tk) riwayatPra.push('TK: ' + s.tk);
        return [
            `Nama Lengkap: ${s.nama_lengkap || '-'}`,
            `Tahun Ajaran: ${s.th_pelajaran || '-'}`,
            `NISN: ${s.nisn || '-'}`,
            `NIS Lokal: ${s.no_pendaftaran || '-'}`,
            `NIK: ${s.nik || '-'}`,
            `Tempat Lahir: ${s.tempat_lahir || '-'}`,
            `Tanggal Lahir: ${formatTgl(s.tgl_lahir)}`,
            `Jenis Kelamin: ${s.jk === 'L' ? 'Laki-laki' : s.jk === 'P' ? 'Perempuan' : (s.jk || '-')}`,
            `Agama: ${s.agama || '-'}`,
            `Jumlah Saudara: ${s.jml_saudara || '-'}`,
            `Anak Ke: ${s.anak_ke || '-'}`,
            `Cita-Cita: ${s.cita || '-'}`,
            `Hobi: ${s.hobi || '-'}`,
            `Yang Membiayai Sekolah: Orang Tua`,
            `Riwayat PraSekolah: ${riwayatPra.length ? riwayatPra.join(', ') : '-'}`,
            `No. KK: ${s.no_kk || '-'}`,
            `Kepala Keluarga: ${s.kepala_keluarga || '-'}`,
            `Nama Ayah: ${s.nama_ayah || '-'}`,
            `NIK Ayah: ${s.nik_ayah || '-'}`,
            `Tempat Lahir Ayah: ${s.tempat_lahir_ayah || '-'}`,
            `Tanggal Lahir Ayah: ${formatTgl(s.tgl_lahir_ayah)}`,
            `Pendidikan Ayah: ${s.pdd_ayah || '-'}`,
            `Pekerjaan Ayah: ${s.pekerjaan_ayah || '-'}`,
            `Nama Ibu: ${s.nama_ibu || '-'}`,
            `NIK Ibu: ${s.nik_ibu || '-'}`,
            `Tempat Lahir Ibu: ${s.tempat_lahir_ibu || '-'}`,
            `Tanggal Lahir Ibu: ${formatTgl(s.tgl_lahir_ibu)}`,
            `Pendidikan Ibu: ${s.pdd_ibu || '-'}`,
            `Pekerjaan Ibu: ${s.pekerjaan_ibu || '-'}`,
            `No. HP Ortu: ${s.no_hp_ortu || '-'}`,
            `Alamat: ${s.alamat_siswa || '-'}`,
            `Provinsi: ${s.prov || '-'}`,
            `Kabupaten/Kota: ${s.kab || '-'}`,
            `Kecamatan: ${s.kec || '-'}`,
            `Desa/Kelurahan: ${s.desa || '-'}`,
            `Kode Pos: ${s.kode_pos || '-'}`,
        ].join('\n');
    }

    // ============ FILTER TAHUN AJARAN ============
    if ($thPelajaran) {
        $thPelajaran.addEventListener('change', function () {
            const val = this.value;
            if ($thBadgeText) {
                $thBadgeText.textContent = val === 'all' ? 'Semua TA' : val;
            }
            try {
                const url = new URL(window.location);
                url.searchParams.set('th_pelajaran', val);
                window.history.replaceState({}, '', url);
            } catch (e) {}

            loadData(val);
        });
    }

    // ============ SEARCH ============
    let searchTimer = null;
    $search.addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilter, 200);
    });

    // ============ MOBILE TABS ============
    function switchToTab(panel) {
        if (window.innerWidth > 900) return;
        if (panel === 'left') {
            $panelLeft.classList.remove('hidden-mobile');
            $panelRight.classList.add('hidden-mobile');
            $tabBtnLeft.classList.add('active');
            $tabBtnRight.classList.remove('active');
        } else {
            $panelLeft.classList.add('hidden-mobile');
            $panelRight.classList.remove('hidden-mobile');
            $tabBtnLeft.classList.remove('active');
            $tabBtnRight.classList.add('active');
        }
    }
    $tabBtnLeft.addEventListener('click', () => switchToTab('left'));
    $tabBtnRight.addEventListener('click', () => switchToTab('right'));

    // ============ INIT ============
    loadData();

})();
</script>
<?= $this->endSection() ?>
