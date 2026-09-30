<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Profil & Biodata Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<div class="flex items-center gap-2">
    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
        <i class="fas fa-address-card text-sm"></i>
    </div>
    <span>Dashboard Profil & Biodata Siswa</span>
</div>
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
/* ============================================================
   SISWA LIST DASHBOARD — Scoped styles & performance optimizations
   ============================================================ */

/* Main split wrapper */
.sl-wrapper {
    display: flex;
    gap: 0;
    height: calc(100vh - 215px);
    min-height: 520px;
    contain: layout;
}

.sl-panel-left {
    width: 390px;
    min-width: 320px;
    display: flex;
    flex-direction: column;
}

.sl-panel-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #fafbfc;
}
html.dark .sl-panel-right {
    background: #0f172a;
}

/* Scrollable containers with paint containment for 60fps */
.sl-table-wrap {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    contain: content;
}

.sl-detail-wrap {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 20px;
    contain: content;
}

/* Virtual row rendering optimization */
.sl-table-row {
    content-visibility: auto;
    contain-intrinsic-size: 0 44px;
}

/* Active row highlight */
#tblLeft tbody tr.active-row td {
    background-color: rgba(70, 95, 255, 0.08) !important;
}
html.dark #tblLeft tbody tr.active-row td {
    background-color: rgba(70, 95, 255, 0.18) !important;
}

/* Bio Section styling */
.bio-section {
    margin-bottom: 20px;
}

.bio-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    border-radius: 12px 12px 0 0;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-bottom: none;
}
html.dark .bio-section-header {
    background: rgba(255, 255, 255, 0.02);
    border-color: #334155;
}

.bio-section-body {
    border-radius: 0 0 12px 12px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    background: #ffffff;
}
html.dark .bio-section-body {
    border-color: #334155;
    background: rgba(255, 255, 255, 0.015);
}

/* Bio rows */
.bio-row {
    display: flex;
    align-items: stretch;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    transition: background-color .15s ease;
}
.bio-row:last-child {
    border-bottom: none;
}
.bio-row:hover {
    background-color: rgba(70, 95, 255, 0.03);
}
html.dark .bio-row {
    border-color: rgba(51, 65, 85, 0.6);
}
html.dark .bio-row:hover {
    background-color: rgba(70, 95, 255, 0.07);
}

.bio-row .bio-label {
    width: 220px;
    min-width: 160px;
    padding: 10px 14px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    display: flex;
    align-items: center;
    flex-shrink: 0;
    border-right: 1px solid #f1f5f9;
    font-size: 12px;
}
html.dark .bio-row .bio-label {
    background: rgba(255, 255, 255, 0.025);
    color: #94a3b8;
    border-color: rgba(51, 65, 85, 0.6);
}

.bio-row .bio-value {
    flex: 1;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    color: #0f172a;
    min-width: 0;
}
html.dark .bio-row .bio-value {
    color: #f1f5f9;
}

.bio-row .bio-value .val-text {
    flex: 1;
    min-width: 0;
    word-break: break-word;
}

/* Highlighted key identifier rows (subtle background, no heavy side tabs) */
.bio-row.highlight-key {
    background-color: rgba(70, 95, 255, 0.025);
}
html.dark .bio-row.highlight-key {
    background-color: rgba(70, 95, 255, 0.05);
}

/* Copy button */
.btn-copy-row {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s ease;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-copy-row:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #cbd5e1;
}
html.dark .btn-copy-row {
    background: #1e293b;
    border-color: #334155;
    color: #94a3b8;
}
html.dark .btn-copy-row:hover {
    background: #334155;
    color: #f8fafc;
    border-color: #475569;
}

/* Toast */
.sl-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #0f172a;
    color: #ffffff;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    opacity: 0;
    transform: translateY(16px);
    transition: all .25s ease;
    z-index: 9999;
    pointer-events: none;
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.sl-toast.show {
    opacity: 1;
    transform: translateY(0);
}

/* Mobile Tab Switcher */
.sl-tab-switch {
    display: none;
}
.sl-tab-switch button {
    flex: 1;
    padding: 12px 0;
    border: none;
    background: transparent;
    color: #94a3b8;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.sl-tab-switch button.active {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.08);
    border-bottom: 2px solid #465fff;
}

/* ============================================================
   RESPONSIVE — TABLET & MOBILE
   ============================================================ */
@media (max-width: 900px) {
    .sl-wrapper {
        flex-direction: column;
        height: auto;
        min-height: calc(100vh - 200px);
    }
    .sl-panel-left {
        width: 100%;
        min-width: unset;
        border-right: none !important;
        border-bottom: 1px solid;
    }
    .sl-panel-right {
        min-height: 420px;
    }
    .sl-tab-switch {
        display: flex;
    }
    .sl-panel-left.hidden-mobile,
    .sl-panel-right.hidden-mobile {
        display: none !important;
    }
    .bio-row .bio-label {
        width: 180px;
        min-width: 130px;
    }
}

@media (max-width: 640px) {
    .sl-detail-wrap {
        padding: 12px;
    }
    .bio-row {
        flex-direction: column;
        align-items: stretch;
    }
    .bio-row .bio-label {
        width: 100%;
        min-width: unset;
        border-right: none;
        border-bottom: 1px solid #f1f5f9;
        padding: 7px 12px;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: #f8fafc;
    }
    html.dark .bio-row .bio-label {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(51, 65, 85, 0.6);
        color: #94a3b8;
    }
    .bio-row .bio-value {
        padding: 9px 12px;
        font-size: 13px;
    }
    .sl-toast {
        bottom: 16px;
        right: 12px;
        left: 12px;
        text-align: center;
    }
}

/* Touch Checkbox */
.chk-siswa {
    min-width: 18px;
    min-height: 18px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Toast Notification -->
<div class="sl-toast" id="slToast"></div>

<!-- Mobile Tab Switcher -->
<div class="sl-tab-switch rounded-t-2xl bg-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700" id="slTabSwitch">
    <button class="active" data-panel="left" id="tabBtnLeft">
        <i class="fas fa-list-ul text-xs"></i>
        <span>Daftar Siswa</span>
    </button>
    <button data-panel="right" id="tabBtnRight">
        <i class="fas fa-id-card text-xs"></i>
        <span>Detail Biodata</span>
    </button>
</div>

<!-- Main Two-Panel Layout -->
<div class="sl-wrapper overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]" id="slWrapper">

    <!-- ==================== PANEL KIRI ==================== -->
    <div class="sl-panel-left border-r border-gray-200/80 dark:border-gray-800" id="panelLeft">

        <!-- Header & Search -->
        <div class="border-b border-gray-100 dark:border-gray-800 px-4 py-3.5 space-y-3 bg-white dark:bg-gray-900/40">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <i class="fas fa-users text-xs"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Siswa</h3>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 tabular-nums" id="slTotalInfo">
                    0 siswa
                </span>
            </div>

            <!-- Filter Tahun Ajaran -->
            <div class="flex items-center h-9 rounded-xl border border-gray-200/90 bg-gray-50/80 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800/60 overflow-hidden focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-all">
                <div class="pl-3 pr-1 text-brand-500 dark:text-brand-400 shrink-0 pointer-events-none flex items-center">
                    <i class="fas fa-calendar-alt text-xs"></i>
                </div>
                <select id="slThPelajaran"
                    class="h-full flex-1 bg-transparent py-1 px-2 text-xs font-semibold text-gray-800 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 cursor-pointer">
                    <?php foreach (($tahunList ?? []) as $t): ?>
                        <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= (($selectedTh ?? '') === $t['tahun_pelajaran']) ? 'selected' : '' ?> class="text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                            Tahun Ajaran: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '★ (Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="all" <?= (($selectedTh ?? '') === 'all') ? 'selected' : '' ?> class="text-gray-800 dark:bg-gray-800 dark:text-gray-100">Semua Tahun Ajaran</option>
                </select>
            </div>

            <!-- Live Search -->
            <div class="flex items-center h-9 rounded-xl border border-gray-200/90 bg-gray-50/80 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800/60 overflow-hidden focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20 transition-all">
                <div class="pl-3 text-gray-400 pointer-events-none flex items-center">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text"
                    id="slSearch"
                    placeholder="Cari nama, NISN, no daftar, atau desa…"
                    autocomplete="off"
                    class="h-full flex-1 bg-transparent py-1.5 px-2.5 text-xs text-gray-800 placeholder:text-gray-400 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder:text-gray-500">
                <button type="button" id="slClearSearch" class="px-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hidden" title="Hapus pencarian">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Info Bar & Action Toolbar -->
        <div class="flex items-center justify-between gap-2 px-4 py-2.5 border-b border-gray-100 dark:border-gray-800 bg-gray-50/60 dark:bg-gray-800/30 flex-wrap">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-brand-600 dark:text-brand-400 tabular-nums" id="slCounter">Terpilih: 0</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200/70 dark:border-emerald-500/30" id="slThBadge" title="Tahun Ajaran Aktif">
                    <i class="fas fa-calendar-check text-[10px]"></i>
                    <span id="slThBadgeText"><?= esc(($selectedTh === 'all') ? 'Semua TA' : ($selectedTh ?? '')) ?></span>
                </span>
            </div>
            <button id="btnSalinTerpilih"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-900 text-white hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 transition-all shadow-theme-xs active:scale-[0.98]"
                title="Salin biodata siswa yang dicentang">
                <i class="fas fa-clipboard-list text-xs"></i>
                <span>Salin Terpilih</span>
            </button>
        </div>

        <!-- Left Table -->
        <div class="sl-table-wrap">
            <table class="w-full text-left" id="tblLeft">
                <thead>
                    <tr class="sticky top-0 z-10 border-b border-gray-200/80 bg-gray-50/90 text-xs font-semibold uppercase tracking-wider text-gray-500 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/90 dark:text-gray-400">
                        <th class="py-3 px-2 text-center w-10">
                            <input type="checkbox" id="chkAllSiswa" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 cursor-pointer" title="Centang / Hapus Semua">
                        </th>
                        <th class="py-3 px-2 text-center w-9">No</th>
                        <th class="py-3 px-3">Nama Siswa</th>
                        <th class="py-3 px-2 text-center w-10">L/P</th>
                        <th class="py-3 px-3 w-24">NISN</th>
                    </tr>
                </thead>
                <tbody id="tblLeftBody" class="divide-y divide-gray-100 text-xs dark:divide-gray-800"></tbody>
            </table>
        </div>
    </div>

    <!-- ==================== PANEL KANAN ==================== -->
    <div class="sl-panel-right" id="panelRight">

        <!-- Detail Header -->
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-200/80 dark:border-gray-800 bg-white dark:bg-gray-900/60 flex-wrap gap-2">
            <div class="flex items-center gap-2.5">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <i class="fas fa-id-card text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white" id="detailTitle">Detail Biodata Siswa</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400" id="detailSubtitle">Data profil lengkap calon peserta didik</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex items-center rounded-lg border border-gray-200/80 bg-gray-50 dark:border-gray-700 dark:bg-gray-800 p-0.5 shadow-theme-xs">
                    <button type="button" id="btnPrevSiswa" class="px-2.5 py-1 text-xs font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white disabled:opacity-40 disabled:cursor-not-allowed transition-colors" title="Siswa Sebelumnya (Panah Atas / Kiri)">
                        <i class="fas fa-chevron-left text-[11px]"></i>
                    </button>
                    <span class="px-2 text-[11px] font-semibold text-gray-500 dark:text-gray-400 tabular-nums border-x border-gray-200 dark:border-gray-700" id="navIndexInfo">-/-</span>
                    <button type="button" id="btnNextSiswa" class="px-2.5 py-1 text-xs font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white disabled:opacity-40 disabled:cursor-not-allowed transition-colors" title="Siswa Selanjutnya (Panah Bawah / Kanan)">
                        <i class="fas fa-chevron-right text-[11px]"></i>
                    </button>
                </div>

                <button id="btnSalinSemua"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-brand-500 text-white hover:bg-brand-600 transition-all shadow-theme-xs active:scale-[0.98]"
                    title="Salin seluruh biodata siswa yang sedang dibuka">
                    <i class="fas fa-copy text-xs"></i>
                    <span>Salin Biodata</span>
                </button>
            </div>
        </div>

        <!-- Detail Content -->
        <div class="sl-detail-wrap" id="detailWrap">
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center h-full text-gray-400 dark:text-gray-500 gap-3.5 p-10 text-center" id="detailEmpty">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 shadow-theme-xs">
                    <i class="fas fa-address-book text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Belum Ada Siswa Dipilih</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-sm">Klik salah satu siswa pada tabel di panel kiri untuk melihat profil biodata lengkap.</p>
                </div>
            </div>

            <!-- Populated Content Area -->
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
    const URL_GET_DATA       = '<?= base_url("admin/siswa-list/get-data") ?>';
    const URL_UPDATE_CHK     = '<?= base_url("admin/siswa-list/update-checklist") ?>';
    const URL_UPDATE_ALL_CHK = '<?= base_url("admin/siswa-list/update-all-checklist") ?>';
    let csrfToken            = '<?= csrf_hash() ?>';
    const csrfName           = '<?= csrf_token() ?>';

    // ============ STATE ============
    let allSiswa     = [];
    let filteredList = [];
    let activeId     = null;

    // ============ DOM REFS ============
    const $thPelajaran   = document.getElementById('slThPelajaran');
    const $thBadgeText   = document.getElementById('slThBadgeText');
    const $search        = document.getElementById('slSearch');
    const $clearSearch   = document.getElementById('slClearSearch');
    const $tblLeftBody   = document.getElementById('tblLeftBody');
    const $chkAllSiswa   = document.getElementById('chkAllSiswa');
    const $counter       = document.getElementById('slCounter');
    const $totalInfo     = document.getElementById('slTotalInfo');
    const $detailEmpty   = document.getElementById('detailEmpty');
    const $detailContent = document.getElementById('detailContent');
    const $navIndexInfo  = document.getElementById('navIndexInfo');
    const $btnPrevSiswa  = document.getElementById('btnPrevSiswa');
    const $btnNextSiswa  = document.getElementById('btnNextSiswa');
    const $toast         = document.getElementById('slToast');
    const $panelLeft     = document.getElementById('panelLeft');
    const $panelRight    = document.getElementById('panelRight');
    const $tabBtnLeft    = document.getElementById('tabBtnLeft');
    const $tabBtnRight   = document.getElementById('tabBtnRight');

    // ============ HELPERS ============
    function esc(str) {
        if (str === null || str === undefined || str === '') return '-';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    function escAttr(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    let toastTimer = null;
    function showToast(msg) {
        if (toastTimer) clearTimeout(toastTimer);
        $toast.textContent = msg;
        $toast.classList.add('show');
        toastTimer = setTimeout(() => $toast.classList.remove('show'), 1800);
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => showToast('✅ Tersalin ke clipboard!'));
        } else {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            showToast('✅ Tersalin ke clipboard!');
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
            if (cb) cb(json);
        })
        .catch(err => {
            console.error(err);
            showToast('❌ Gagal menghubungi server');
        });
    }

    // ============ LOAD DATA ============
    function loadData(th) {
        const selectedYear = th !== undefined ? th : ($thPelajaran ? $thPelajaran.value : '<?= esc($selectedTh ?? '') ?>');

        $tblLeftBody.innerHTML = `<tr><td colspan="5" class="py-12 text-center text-gray-400 dark:text-gray-500">
            <i class="fas fa-circle-notch fa-spin text-2xl mb-2 text-brand-500 block"></i>
            <span class="text-xs font-medium">Memuat data siswa...</span>
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
            $tblLeftBody.innerHTML = `<tr><td colspan="5" class="py-10 text-center text-rose-500">
                <i class="fas fa-exclamation-triangle text-2xl mb-2 block"></i>
                <span class="text-xs font-semibold">Gagal memuat data siswa</span>
            </td></tr>`;
            $totalInfo.textContent = '0 siswa';
        });
    }

    // ============ FILTER ============
    function applyFilter() {
        const q = ($search.value || '').toLowerCase().trim();
        if ($clearSearch) {
            $clearSearch.classList.toggle('hidden', q.length === 0);
        }

        filteredList = allSiswa.filter(s => {
            if (!q) return true;
            return (s.nama_lengkap || '').toLowerCase().includes(q)
                || (s.nisn || '').toLowerCase().includes(q)
                || (s.no_pendaftaran || '').toLowerCase().includes(q)
                || (s.desa || '').toLowerCase().includes(q);
        });

        renderLeftTable();
        updateCounter();
        updateNavState();
        $totalInfo.textContent = filteredList.length + ' siswa';
    }

    // ============ RENDER LEFT TABLE (Optimized HTML generation) ============
    function renderLeftTable() {
        if (!filteredList.length) {
            $tblLeftBody.innerHTML = `<tr><td colspan="5" class="py-12 text-center text-gray-400 dark:text-gray-500">
                <i class="fas fa-inbox text-3xl opacity-30 block mb-2"></i>
                <p class="text-xs font-medium">Tidak ada data siswa ditemukan</p>
            </td></tr>`;
            return;
        }

        let html = '';
        for (let i = 0; i < filteredList.length; i++) {
            const s = filteredList[i];
            const checked = s.is_checked == 1 ? 'checked' : '';
            const activeClass = s.id_siswa == activeId ? ' active-row' : '';
            const genderBadge = s.jk === 'L'
                ? '<span class="inline-flex items-center justify-center font-bold text-blue-600 dark:text-blue-400 text-[11px]"><i class="fas fa-mars text-[10px]"></i></span>'
                : '<span class="inline-flex items-center justify-center font-bold text-pink-600 dark:text-pink-400 text-[11px]"><i class="fas fa-venus text-[10px]"></i></span>';

            html += `<tr class="sl-table-row hover:bg-gray-50/70 dark:hover:bg-white/[0.02] transition-colors cursor-pointer${activeClass}" data-id="${s.id_siswa}">
                <td class="py-2.5 px-2 text-center">
                    <input type="checkbox" class="chk-siswa h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 cursor-pointer" data-id="${s.id_siswa}" ${checked}>
                </td>
                <td class="py-2.5 px-2 text-center text-gray-500 dark:text-gray-400 font-medium tabular-nums text-xs">${i + 1}</td>
                <td class="py-2.5 px-3">
                    <span class="font-semibold text-gray-900 dark:text-gray-100 truncate block max-w-[170px]" title="${escAttr(s.nama_lengkap)}">${esc(s.nama_lengkap)}</span>
                </td>
                <td class="py-2.5 px-2 text-center">${genderBadge}</td>
                <td class="py-2.5 px-3 font-mono text-gray-600 dark:text-gray-400 text-xs tabular-nums">${esc(s.nisn)}</td>
            </tr>`;
        }

        $tblLeftBody.innerHTML = html;
        updateHeaderCheckState();
    }

    // ============ EVENT DELEGATION FOR LEFT TABLE (Zero Memory Churn) ============
    $tblLeftBody.addEventListener('click', function (e) {
        if (e.target.matches('.chk-siswa') || e.target.closest('.chk-siswa')) {
            return; // handled by change event
        }
        const tr = e.target.closest('tr[data-id]');
        if (tr) {
            selectSiswa(parseInt(tr.dataset.id, 10));
        }
    });

    $tblLeftBody.addEventListener('change', function (e) {
        if (e.target.matches('.chk-siswa')) {
            const chk = e.target;
            const id  = parseInt(chk.dataset.id, 10);
            const val = chk.checked ? 1 : 0;

            // Optimistic update
            const s = allSiswa.find(x => x.id_siswa == id);
            if (s) s.is_checked = val;
            updateCounter();
            updateHeaderCheckState();

            ajaxPost(URL_UPDATE_CHK, { id_siswa: id, is_checked: val }, (json) => {
                if (json.status !== 'success') {
                    // Rollback
                    if (s) s.is_checked = val ? 0 : 1;
                    chk.checked = !chk.checked;
                    updateCounter();
                    updateHeaderCheckState();
                }
            });
        }
    });

    // ============ HEADER CHECKBOX (Check / Uncheck All in Filtered List) ============
    if ($chkAllSiswa) {
        $chkAllSiswa.addEventListener('change', function () {
            const isChecked = this.checked ? 1 : 0;
            const targetIds = filteredList.map(s => s.id_siswa);
            if (!targetIds.length) return;

            filteredList.forEach(s => s.is_checked = isChecked);
            document.querySelectorAll('#tblLeftBody .chk-siswa').forEach(c => c.checked = isChecked === 1);
            updateCounter();

            const curTh = $thPelajaran ? $thPelajaran.value : '';
            ajaxPost(URL_UPDATE_ALL_CHK, { is_checked: isChecked, th_pelajaran: curTh }, (json) => {
                if (json.status === 'success') {
                    showToast(isChecked ? '✅ Semua siswa dicentang' : '⚪ Checklist dibersihkan');
                }
            });
        });
    }

    function updateHeaderCheckState() {
        if (!$chkAllSiswa) return;
        if (!filteredList.length) {
            $chkAllSiswa.checked = false;
            $chkAllSiswa.indeterminate = false;
            return;
        }
        const checkedCount = filteredList.filter(s => s.is_checked == 1).length;
        if (checkedCount === 0) {
            $chkAllSiswa.checked = false;
            $chkAllSiswa.indeterminate = false;
        } else if (checkedCount === filteredList.length) {
            $chkAllSiswa.checked = true;
            $chkAllSiswa.indeterminate = false;
        } else {
            $chkAllSiswa.checked = false;
            $chkAllSiswa.indeterminate = true;
        }
    }

    // ============ COUNTER ============
    function updateCounter() {
        const count = allSiswa.filter(s => s.is_checked == 1).length;
        $counter.textContent = `Terpilih: ${count}`;
    }

    // ============ NAVIGATION STATE (PREV / NEXT) ============
    function updateNavState() {
        if (!activeId || !filteredList.length) {
            $navIndexInfo.textContent = '-/-';
            $btnPrevSiswa.disabled = true;
            $btnNextSiswa.disabled = true;
            return;
        }
        const idx = filteredList.findIndex(s => s.id_siswa == activeId);
        if (idx === -1) {
            $navIndexInfo.textContent = '-/-';
            $btnPrevSiswa.disabled = true;
            $btnNextSiswa.disabled = true;
        } else {
            $navIndexInfo.textContent = `${idx + 1}/${filteredList.length}`;
            $btnPrevSiswa.disabled = (idx === 0);
            $btnNextSiswa.disabled = (idx === filteredList.length - 1);
        }
    }

    $btnPrevSiswa.addEventListener('click', function () {
        if (!activeId || !filteredList.length) return;
        const idx = filteredList.findIndex(s => s.id_siswa == activeId);
        if (idx > 0) {
            selectSiswa(filteredList[idx - 1].id_siswa);
            scrollToActiveRow();
        }
    });

    $btnNextSiswa.addEventListener('click', function () {
        if (!activeId || !filteredList.length) return;
        const idx = filteredList.findIndex(s => s.id_siswa == activeId);
        if (idx >= 0 && idx < filteredList.length - 1) {
            selectSiswa(filteredList[idx + 1].id_siswa);
            scrollToActiveRow();
        }
    });

    function scrollToActiveRow() {
        const row = document.querySelector(`#tblLeftBody tr[data-id="${activeId}"]`);
        if (row) {
            row.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    }

    // ============ SELECT SISWA ============
    function selectSiswa(id) {
        activeId = id;
        document.querySelectorAll('#tblLeftBody tr.active-row').forEach(tr => tr.classList.remove('active-row'));
        const targetRow = document.querySelector(`#tblLeftBody tr[data-id="${id}"]`);
        if (targetRow) targetRow.classList.add('active-row');
        renderDetail(id);
        updateNavState();
        switchToTab('right');
    }

    // ============ RENDER DETAIL (Clean Modern TailAdmin UI) ============
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

        const sections = [
            {
                title: 'Data Pribadi Siswa',
                icon: 'fa-user',
                badgeCls: 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400',
                rows: [
                    ['Nama Lengkap',          s.nama_lengkap,          true],
                    ['Tahun Ajaran',          s.th_pelajaran || '-',   false],
                    ['NISN',                  s.nisn,                  true],
                    ['NIS Lokal',             s.no_pendaftaran,        true],
                    ['NIK Siswa',             s.nik,                   false],
                    ['Tempat Lahir',          s.tempat_lahir,          false],
                    ['Tanggal Lahir',         formatTgl(s.tgl_lahir),  false],
                    ['Jenis Kelamin',          s.jk === 'L' ? 'Laki-laki' : (s.jk === 'P' ? 'Perempuan' : s.jk), false],
                    ['Agama',                  s.agama,               false],
                    ['Jumlah Saudara',         s.jml_saudara,         false],
                    ['Anak Ke',                s.anak_ke,             false],
                    ['Cita-Cita',              s.cita,                false],
                    ['Hobi',                   s.hobi,                false],
                    ['Yang Membiayai Sekolah', 'Orang Tua',           false],
                    ['Riwayat PraSekolah',     riwayatPraStr,         false],
                ]
            },
            {
                title: 'Data Keluarga',
                icon: 'fa-home',
                badgeCls: 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400',
                rows: [
                    ['No. Kartu Keluarga (KK)',  s.no_kk,             true],
                    ['Nama Kepala Keluarga',     s.kepala_keluarga,   false],
                ]
            },
            {
                title: 'Data Orang Tua',
                icon: 'fa-users',
                badgeCls: 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400',
                rows: [
                    ['Nama Ayah',                s.nama_ayah,           false],
                    ['NIK Ayah',                 s.nik_ayah,            false],
                    ['Tempat Lahir (Ayah)',      s.tempat_lahir_ayah,   false],
                    ['Tanggal Lahir (Ayah)',     formatTgl(s.tgl_lahir_ayah), false],
                    ['Pendidikan Terakhir Ayah', s.pdd_ayah,            false],
                    ['Pekerjaan Utama Ayah',     s.pekerjaan_ayah,      false],
                    ['Nama Ibu',                 s.nama_ibu,            false],
                    ['NIK Ibu',                  s.nik_ibu,             false],
                    ['Tempat Lahir (Ibu)',       s.tempat_lahir_ibu,    false],
                    ['Tanggal Lahir (Ibu)',      formatTgl(s.tgl_lahir_ibu), false],
                    ['Pendidikan Terakhir Ibu',  s.pdd_ibu,             false],
                    ['Pekerjaan Utama Ibu',      s.pekerjaan_ibu,       false],
                    ['No. Handphone Ortu',       s.no_hp_ortu,          true],
                ]
            },
            {
                title: 'Alamat Tempat Tinggal',
                icon: 'fa-map-marker-alt',
                badgeCls: 'bg-teal-50 text-teal-600 dark:bg-teal-500/15 dark:text-teal-400',
                rows: [
                    ['Alamat Jalan / Dusun',  s.alamat_siswa,  false],
                    ['Provinsi',              s.prov,          false],
                    ['Kabupaten/Kota',        s.kab,           false],
                    ['Kecamatan',             s.kec,           false],
                    ['Desa/Kelurahan',        s.desa,          false],
                    ['Kode Pos',              s.kode_pos,      false],
                ]
            }
        ];

        // Executive Profile Banner
        const genderColor = s.jk === 'L' ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400' : 'bg-pink-50 text-pink-600 dark:bg-pink-500/15 dark:text-pink-400';
        const initial = (s.nama_lengkap || 'S').trim().charAt(0).toUpperCase();

        let html = `
        <div class="mb-5 rounded-2xl border border-gray-200/80 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-3.5">
                <div class="flex h-13 w-13 shrink-0 items-center justify-center rounded-2xl ${genderColor} text-lg font-bold shadow-theme-xs ring-2 ring-white dark:ring-gray-800">
                    ${initial}
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-bold tracking-tight text-gray-900 dark:text-white leading-tight">${esc(s.nama_lengkap)}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                        <span class="inline-flex items-center gap-1 rounded-md bg-brand-50 px-2 py-0.5 text-xs font-semibold text-brand-700 dark:bg-brand-500/15 dark:text-brand-300 border border-brand-200/60 dark:border-brand-500/20 tabular-nums">
                            NISN: ${esc(s.nisn)}
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300 tabular-nums">
                            No. Daftar: ${esc(s.no_pendaftaran)}
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-500/20">
                            TP ${esc(s.th_pelajaran || '-')}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" class="btn-copy-row !py-2 !px-3" data-copy="${escAttr(s.nama_lengkap)}" title="Salin Nama Lengkap">
                    <i class="fas fa-copy text-xs"></i>
                    <span>Salin Nama</span>
                </button>
            </div>
        </div>
        `;

        // Section Cards
        sections.forEach(sec => {
            html += `<div class="bio-section">
                <div class="bio-section-header">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg ${sec.badgeCls}">
                            <i class="fas ${sec.icon} text-xs"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">${sec.title}</span>
                    </div>
                </div>
                <div class="bio-section-body">`;

            sec.rows.forEach(([label, value, isHighlight]) => {
                const hlClass = isHighlight ? ' highlight-key' : '';
                const display = (value !== null && value !== undefined && value !== '') ? value : '-';

                html += `<div class="bio-row${hlClass}">
                    <div class="bio-label">${esc(label)}</div>
                    <div class="bio-value">
                        <span class="val-text font-medium text-gray-900 dark:text-gray-100 tabular-nums">${esc(String(display))}</span>
                        <button type="button" class="btn-copy-row" data-copy="${escAttr(String(display))}" title="Salin ${escAttr(label)}">
                            <i class="fas fa-copy text-[10px]"></i>
                            <span class="copy-label">Salin</span>
                        </button>
                    </div>
                </div>`;
            });

            html += `</div></div>`;
        });

        $detailContent.innerHTML = html;
    }

    // ============ EVENT DELEGATION FOR DETAIL PANEL COPY BUTTONS ============
    $detailContent.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-copy-row');
        if (btn) {
            const val = btn.getAttribute('data-copy');
            if (val && val !== '-') {
                copyText(val);
            } else {
                showToast('Tidak ada data untuk disalin');
            }
        }
    });

    function formatTgl(val) {
        if (!val) return '-';
        const d = new Date(val);
        if (isNaN(d.getTime())) return val;
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

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
        searchTimer = setTimeout(applyFilter, 120);
    });

    if ($clearSearch) {
        $clearSearch.addEventListener('click', function () {
            $search.value = '';
            applyFilter();
            $search.focus();
        });
    }

    // ============ KEYBOARD NAVIGATION ============
    window.addEventListener('keydown', function (e) {
        // Prevent navigating when typing in search or inputs
        if (['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
            return;
        }
        if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
            e.preventDefault();
            $btnPrevSiswa.click();
        } else if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
            e.preventDefault();
            $btnNextSiswa.click();
        }
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
