<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Data Pembiayaan Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">account_balance_wallet</span> Data Pembiayaan Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Message Notifications -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
        <span class="material-symbols-outlined text-xl text-emerald-500">check_circle</span>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="mb-5 flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-300">
        <span class="material-symbols-outlined text-xl text-rose-500">error</span>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Siswa &amp; Status Pembayaran</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data tagihan dan catat pembayaran biaya calon siswa secara langsung.</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <!-- Tombol Buka Modal Input Pembayaran -->
        <button type="button" id="btnBukaModalBayarUmum" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">payments</span>
            <span>+ Input Pembayaran</span>
        </button>

        <!-- Tombol Terapkan Biaya ke Semua Siswa -->
        <form action="<?= base_url('verifikator/pembiayaan/tambah-semua-siswa') ?>" method="post" onsubmit="return confirm('Tambahkan semua item pembiayaan aktif ke SEMUA calon siswa?')">
            <?= csrf_field() ?>
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">playlist_add_check</span>
                <span>Terapkan Biaya ke Semua Siswa</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Search & Filter Controls -->
    <div class="mb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative w-full sm:w-72">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
            <input type="text" id="searchTableInput" placeholder="Cari nama atau no. pendaftaran..."
                   class="w-full rounded-xl border border-gray-200 bg-gray-50/50 py-2 pl-9 pr-3 text-xs text-gray-800 placeholder-gray-400 outline-none focus:border-brand-500 focus:bg-white focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800/40 dark:text-gray-200 dark:focus:bg-gray-900 transition">
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <select id="statusFilterSelect" class="rounded-xl border border-gray-200 bg-gray-50/50 px-3 py-2 text-xs text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-800/40 dark:text-gray-300">
                <option value="all">Semua Status</option>
                <option value="belum">Belum Lunas</option>
                <option value="lunas">Lunas</option>
                <option value="kosong">Belum Ada Tagihan</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="tableSiswaPembiayaan">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-4">No</th>
                    <th class="py-3.5 px-4">No. Daftar</th>
                    <th class="py-3.5 px-4">Nama Siswa</th>
                    <th class="py-3.5 px-4 text-right">Total Tagihan</th>
                    <th class="py-3.5 px-4 text-right">Sudah Dibayar</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm" id="tbodySiswa">
                <?php if (empty($siswaList)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300 dark:text-gray-600">inbox</span>
                            Belum ada data siswa.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($siswaList as $s): 
                        $inisial = mb_substr(trim($s['nama_lengkap']), 0, 1);
                        $statusClass = $s['statusLunas'] ? 'lunas' : ($s['totalTagihan'] > 0 ? 'belum' : 'kosong');
                    ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors row-siswa"
                            data-nama="<?= esc(strtolower($s['nama_lengkap'])) ?>"
                            data-nodaftar="<?= esc(strtolower($s['no_pendaftaran'])) ?>"
                            data-status="<?= $statusClass ?>">
                            <td class="py-3.5 px-4 font-mono text-gray-400 dark:text-gray-500 text-xs"><?= $no++ ?></td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex rounded-lg bg-gray-100 px-2 py-0.5 font-mono text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= esc($inisial) ?>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white block"><?= esc($s['nama_lengkap']) ?></span>
                                        <span class="text-[11px] text-gray-400">
                                            <?= ($s['jk'] ?? '') === 'L' ? 'Laki-laki' : (($s['jk'] ?? '') === 'P' ? 'Perempuan' : '-') ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-gray-900 dark:text-white"><?= format_rupiah($s['totalTagihan']) ?></td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400"><?= format_rupiah($s['totalLunas']) ?></td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if ($s['statusLunas']): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="material-symbols-outlined text-xs">check_circle</span> Lunas
                                    </span>
                                <?php elseif ($s['totalTagihan'] > 0): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                                        <span class="material-symbols-outlined text-xs">hourglass_top</span> Belum Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        Belum Ada Tagihan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Tombol Bayar Langsung -->
                                    <button type="button"
                                            class="btn-bayar-row inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-500/15 dark:text-emerald-400 dark:hover:bg-emerald-500/25 transition active:scale-95"
                                            data-id="<?= $s['id_siswa'] ?>"
                                            data-nama="<?= esc($s['nama_lengkap']) ?>"
                                            data-nodaftar="<?= esc($s['no_pendaftaran']) ?>"
                                            title="Input Transaksi Pembayaran">
                                        <span class="material-symbols-outlined text-sm">payments</span>
                                        <span>Bayar</span>
                                    </button>

                                    <!-- Tombol Detail -->
                                    <a href="<?= base_url('verifikator/pembiayaan/siswa/' . $s['id_siswa']) ?>"
                                       class="inline-flex items-center justify-center h-7 w-7 rounded-lg bg-gray-100 text-gray-600 hover:bg-brand-50 hover:text-brand-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-brand-500/15 dark:hover:text-brand-400 transition"
                                       title="Lihat Detail & Checklist Tagihan">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL INPUT DATA PEMBAYARAN                                               -->
<!-- ========================================================================= -->
<div id="modalInputBayar" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="relative w-full max-w-xl rounded-2xl bg-white shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800 my-8 overflow-hidden transition-all transform animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-6 py-4 bg-gray-50/50 dark:bg-gray-800/30">
            <div class="flex items-center gap-2.5">
                <div class="h-9 w-9 rounded-xl bg-emerald-50 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Input Pembayaran Siswa</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Catat pembayaran tunai, transfer, atau QRIS</p>
                </div>
            </div>
            <button type="button" id="btnTutupModalBayar" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="formInputBayarModal" action="" method="post" enctype="multipart/form-data" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="tagihan_ids" id="modalTagihanIdsHidden" value="">
            <input type="hidden" name="redirect_to" value="<?= current_url() ?>">

            <!-- 1. Pilih Siswa -->
            <div>
                <label for="selectSiswaModal" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                    Pilih Calon Siswa <span class="text-red-500">*</span>
                </label>
                <select id="selectSiswaModal" required class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    <option value="">-- Pilih Calon Siswa --</option>
                    <?php foreach ($siswaList as $s): ?>
                        <option value="<?= $s['id_siswa'] ?>"
                                data-nama="<?= esc($s['nama_lengkap']) ?>"
                                data-nodaftar="<?= esc($s['no_pendaftaran']) ?>">
                            [<?= esc($s['no_pendaftaran']) ?>] <?= esc($s['nama_lengkap']) ?> - (Sisa: <?= format_rupiah($s['sisa']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Loading Spinner State -->
            <div id="modalLoadingState" class="hidden py-6 text-center text-gray-400">
                <span class="material-symbols-outlined animate-spin text-3xl text-brand-500 mb-1">progress_activity</span>
                <p class="text-xs">Memuat rincian tagihan siswa...</p>
            </div>

            <!-- Detail Tagihan Container -->
            <div id="modalTagihanContainer" class="space-y-4">
                <!-- Info Banner Siswa Terpilih -->
                <div id="modalSiswaBanner" class="hidden rounded-xl border border-blue-100 bg-blue-50/60 p-3.5 text-xs dark:border-blue-500/20 dark:bg-blue-500/10">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-gray-400">No. Pendaftaran</span>
                            <span id="bannerNoDaftar" class="font-bold font-mono text-gray-800 dark:text-gray-200">-</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-gray-400">Total Tagihan</span>
                            <span id="bannerTotalTagihan" class="font-bold font-mono text-gray-800 dark:text-gray-200">Rp 0</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase text-gray-400">Sisa Tagihan</span>
                            <span id="bannerSisaTagihan" class="font-bold font-mono text-emerald-600 dark:text-emerald-400">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Opsi Auto Generate Tagihan jika belum ada tagihan -->
                <div id="modalNoTagihanAlert" class="hidden rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs dark:border-amber-500/20 dark:bg-amber-500/10">
                    <div class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-amber-500 text-lg shrink-0 mt-0.5">info</span>
                        <div>
                            <p class="font-bold text-amber-900 dark:text-amber-200">Siswa ini belum memiliki rincian tagihan.</p>
                            <label class="mt-2 inline-flex items-center gap-2 cursor-pointer font-semibold text-amber-800 dark:text-amber-300">
                                <input type="checkbox" name="auto_generate_tagihan" id="checkAutoTagihan" value="1" checked class="h-4 w-4 rounded border-amber-300 text-brand-500 focus:ring-brand-500">
                                <span>Buat item tagihan default otomatis sesuai gender siswa</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Checklist Item Belum Lunas -->
                <div id="modalUnpaidSection" class="hidden">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Pilih Item yang Dibayar</label>
                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-bold text-brand-600 dark:text-brand-400">
                            <input type="checkbox" id="modalCheckAllUnpaid" class="h-3.5 w-3.5 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                            <span>Pilih Semua</span>
                        </label>
                    </div>
                    <div id="modalUnpaidList" class="space-y-2 max-h-48 overflow-y-auto pr-1 border border-gray-100 dark:border-gray-800 rounded-xl p-2 bg-gray-50/40 dark:bg-gray-800/20">
                        <!-- Diisi via Javascript -->
                    </div>
                </div>

                <!-- Status Sudah Lunas -->
                <div id="modalSudahLunasAlert" class="hidden rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-center text-xs dark:border-emerald-500/20 dark:bg-emerald-500/10">
                    <span class="material-symbols-outlined text-emerald-500 text-3xl block mb-1">check_circle</span>
                    <p class="font-bold text-emerald-800 dark:text-emerald-300">Semua tagihan siswa ini sudah berstatus LUNAS!</p>
                </div>

                <!-- Grid Input Nominal & Tanggal -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Jumlah Bayar -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Jumlah Bayar (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" id="modalInputJumlah" required min="1"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm font-bold font-mono text-emerald-600 dark:text-emerald-400 shadow-theme-xs focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800" placeholder="0">
                        <p class="mt-1 text-[10px] text-gray-400">Terhitung otomatis dari item yang dipilih atau isi manual.</p>
                    </div>

                    <!-- Tanggal Bayar -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Tanggal Transaksi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
                    <select name="metode" class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="Tunai">Tunai / Cash (Langsung di Sekolah)</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>

                <!-- Keterangan / Catatan -->
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Catatan / Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Pembayaran seragam & infak pertama..."
                           class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <!-- Upload Bukti -->
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Unggah Bukti Transaksi (Opsional)</label>
                    <input type="file" name="bukti_pembayaran[]" multiple accept="image/*,application/pdf"
                           class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-gray-100 dark:border-gray-800">
                <button type="button" id="btnBatalModalBayar" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition">
                    Batal
                </button>
                <button type="submit" id="btnSubmitModalBayar" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-95">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pembayaran</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- 1. Quick Table Filter & Search ---
    const searchInput = document.getElementById('searchTableInput');
    const statusFilter = document.getElementById('statusFilterSelect');
    const rows = document.querySelectorAll('.row-siswa');

    function filterTable() {
        const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const status = statusFilter ? statusFilter.value : 'all';

        rows.forEach(row => {
            const nama = row.dataset.nama || '';
            const nodaftar = row.dataset.nodaftar || '';
            const rowStatus = row.dataset.status || '';

            const matchQuery = !query || nama.includes(query) || nodaftar.includes(query);
            const matchStatus = status === 'all' || rowStatus === status;

            row.style.display = (matchQuery && matchStatus) ? '' : 'none';
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);

    // --- 2. Modal Logic ---
    const modal = document.getElementById('modalInputBayar');
    const btnBukaModalUmum = document.getElementById('btnBukaModalBayarUmum');
    const btnTutupModal = document.getElementById('btnTutupModalBayar');
    const btnBatalModal = document.getElementById('btnBatalModalBayar');
    const selectSiswa = document.getElementById('selectSiswaModal');
    const formModal = document.getElementById('formInputBayarModal');
    const loadingState = document.getElementById('modalLoadingState');
    const tagihanContainer = document.getElementById('modalTagihanContainer');

    const bannerSiswa = document.getElementById('modalSiswaBanner');
    const bannerNoDaftar = document.getElementById('bannerNoDaftar');
    const bannerTotalTagihan = document.getElementById('bannerTotalTagihan');
    const bannerSisaTagihan = document.getElementById('bannerSisaTagihan');

    const noTagihanAlert = document.getElementById('modalNoTagihanAlert');
    const sudahLunasAlert = document.getElementById('modalSudahLunasAlert');
    const unpaidSection = document.getElementById('modalUnpaidSection');
    const unpaidList = document.getElementById('modalUnpaidList');
    const checkAllUnpaid = document.getElementById('modalCheckAllUnpaid');
    const inputJumlah = document.getElementById('modalInputJumlah');
    const tagihanIdsHidden = document.getElementById('modalTagihanIdsHidden');
    const btnSubmit = document.getElementById('btnSubmitModalBayar');

    function openModal(preselectId = '') {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        if (preselectId && selectSiswa) {
            selectSiswa.value = preselectId;
            loadSiswaTagihan(preselectId);
        } else if (selectSiswa && selectSiswa.value) {
            loadSiswaTagihan(selectSiswa.value);
        } else {
            resetModalDetails();
        }
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    if (btnBukaModalUmum) btnBukaModalUmum.addEventListener('click', () => openModal());
    if (btnTutupModal) btnTutupModal.addEventListener('click', closeModal);
    if (btnBatalModal) btnBatalModal.addEventListener('click', closeModal);

    // Close on backdrop click or Escape key
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });

    // Handle "Bayar" button in each table row
    document.querySelectorAll('.btn-bayar-row').forEach(btn => {
        btn.addEventListener('click', function() {
            const siswaId = this.dataset.id;
            openModal(siswaId);
        });
    });

    // On select student changed
    if (selectSiswa) {
        selectSiswa.addEventListener('change', function() {
            const siswaId = this.value;
            if (siswaId) {
                loadSiswaTagihan(siswaId);
            } else {
                resetModalDetails();
            }
        });
    }

    function resetModalDetails() {
        if (formModal) formModal.action = '';
        if (bannerSiswa) bannerSiswa.classList.add('hidden');
        if (noTagihanAlert) noTagihanAlert.classList.add('hidden');
        if (sudahLunasAlert) sudahLunasAlert.classList.add('hidden');
        if (unpaidSection) unpaidSection.classList.add('hidden');
        if (unpaidList) unpaidList.innerHTML = '';
        if (inputJumlah) inputJumlah.value = '';
        if (tagihanIdsHidden) tagihanIdsHidden.value = '';
    }

    function loadSiswaTagihan(siswaId) {
        resetModalDetails();
        formModal.action = '<?= base_url('verifikator/pembiayaan/siswa') ?>/' + siswaId + '/bayar';

        loadingState.classList.remove('hidden');

        fetch('<?= base_url('verifikator/pembiayaan/siswa-tagihan') ?>/' + siswaId)
            .then(res => res.json())
            .then(data => {
                loadingState.classList.add('hidden');
                if (!data.status) {
                    alert(data.message || 'Gagal mengambil rincian tagihan.');
                    return;
                }

                // Show Banner
                bannerNoDaftar.textContent = data.siswa.no_pendaftaran;
                bannerTotalTagihan.textContent = data.total_tagihan_fmt;
                bannerSisaTagihan.textContent = data.sisa_fmt;
                bannerSiswa.classList.remove('hidden');

                if (!data.has_tagihan) {
                    // Siswa belum punya tagihan
                    noTagihanAlert.classList.remove('hidden');
                    inputJumlah.value = '';
                } else if (data.status_lunas) {
                    // Sudah lunas
                    sudahLunasAlert.classList.remove('hidden');
                    inputJumlah.value = 0;
                } else if (data.unpaid_items && data.unpaid_items.length > 0) {
                    // Ada item tagihan belum lunas
                    unpaidSection.classList.remove('hidden');
                    renderUnpaidItems(data.unpaid_items);
                }
            })
            .catch(err => {
                loadingState.classList.add('hidden');
                console.error('Fetch error:', err);
                alert('Terjadi kesalahan jaringan saat memuat tagihan.');
            });
    }

    function renderUnpaidItems(items) {
        unpaidList.innerHTML = '';
        items.forEach(item => {
            const label = document.createElement('label');
            label.className = 'flex items-center justify-between p-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-emerald-400 cursor-pointer transition select-unpaid-modal-item';
            label.innerHTML = `
                <div class="flex items-center gap-2 min-w-0">
                    <input type="checkbox" value="${item.id_tagihan}" data-harga="${item.harga_satuan}" checked
                           class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 modal-unpaid-check">
                    <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate">${item.nama_item}</span>
                </div>
                <span class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400 shrink-0 ml-2">
                    ${item.harga_fmt}
                </span>
            `;
            unpaidList.appendChild(label);
        });

        const checks = unpaidList.querySelectorAll('.modal-unpaid-check');
        checks.forEach(cb => {
            cb.addEventListener('change', hitungTotalModal);
        });

        if (checkAllUnpaid) {
            checkAllUnpaid.checked = true;
            checkAllUnpaid.addEventListener('change', function() {
                checks.forEach(cb => { cb.checked = this.checked; });
                hitungTotalModal();
            });
        }

        hitungTotalModal();
    }

    function hitungTotalModal() {
        const checks = unpaidList.querySelectorAll('.modal-unpaid-check');
        let total = 0;
        let ids = [];

        checks.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.harga) || 0;
                ids.push(cb.value);
                cb.closest('.select-unpaid-modal-item').classList.add('border-emerald-500', 'bg-emerald-50/50', 'dark:bg-emerald-500/15');
            } else {
                cb.closest('.select-unpaid-modal-item').classList.remove('border-emerald-500', 'bg-emerald-50/50', 'dark:bg-emerald-500/15');
            }
        });

        if (inputJumlah) inputJumlah.value = total;
        if (tagihanIdsHidden) tagihanIdsHidden.value = ids.join(',');

        if (checkAllUnpaid && checks.length > 0) {
            checkAllUnpaid.checked = [...checks].every(cb => cb.checked);
        }
    }

    // Submit Guard
    if (formModal) {
        formModal.addEventListener('submit', function(e) {
            if (!selectSiswa.value) {
                e.preventDefault();
                alert('Pilih calon siswa terlebih dahulu.');
                return false;
            }

            const jumlah = parseInt(inputJumlah.value) || 0;
            if (jumlah <= 0) {
                e.preventDefault();
                alert('Nominal pembayaran wajib lebih besar dari 0.');
                return false;
            }

            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
                btnSubmit.innerHTML = '<span class="material-symbols-outlined animate-spin text-base">progress_activity</span> Menyimpan...';
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
