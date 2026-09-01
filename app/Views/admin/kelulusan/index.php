<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kelulusan Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Kelulusan Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalSiswa   = $totalAll ?? count($siswa);
$lulusCount   = $totalLulus ?? 0;
$tlCount      = $totalTl ?? 0;
$pendingCount = $totalPending ?? 0;
?>

<!-- Metric Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                <i class="fas fa-user-graduate text-lg"></i>
            </div>
            <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">Total</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Siswa</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($totalSiswa) ?></h4>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <i class="fas fa-check-circle text-lg"></i>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Diterima</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Lulus Seleksi</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($lulusCount) ?></h4>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <i class="fas fa-times-circle text-lg"></i>
            </div>
            <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">Ditolak</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Tidak Lulus</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($tlCount) ?></h4>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <i class="fas fa-hourglass-half text-lg"></i>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">Belum Ditentukan</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Pending</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($pendingCount) ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <form action="<?= base_url('admin/kelulusan') ?>" method="get" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Data Kelulusan Siswa</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tentukan dan perbarui status kelulusan peserta.</p>
            </div>
            <div class="flex-1"></div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                    placeholder="Cari Nama/NISN..."
                    class="h-9 w-full rounded-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 dark:placeholder:text-gray-500 sm:w-56">
            </div>
            <select name="status"
                class="h-9 rounded-lg border border-gray-200 bg-gray-50/50 px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100">
                <option value="">Semua Status</option>
                <option value="Lulus" <?= ($status == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                <option value="Tidak Lulus" <?= ($status == 'Tidak Lulus') ? 'selected' : '' ?>>Tidak Lulus</option>
                <option value="Pending" <?= ($status == 'Pending') ? 'selected' : '' ?>>Pending</option>
            </select>
            <button type="submit" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-colors hover:bg-brand-600 shrink-0">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left" id="kelulusanTable">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-4 w-10">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"
                            class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800">
                    </th>
                    <th class="py-3.5 px-5">Siswa</th>
                    <th class="py-3.5 px-4">No. Pendaftaran</th>
                    <th class="py-3.5 px-4">Asal Sekolah</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) :
                        $initial = strtoupper(substr($s['nama_lengkap'], 0, 1));
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-4">
                                <input type="checkbox" class="siswa-checkbox h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800"
                                    value="<?= $s['id_siswa'] ?>" onclick="updateBulkBar()">
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 font-bold text-xs dark:bg-brand-500/15 dark:text-brand-400">
                                        <?= $initial ?>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 dark:text-gray-100"><?= esc($s['nama_lengkap']) ?></span>
                                        <span class="block text-[11px] text-gray-400 dark:text-gray-500">NISN: <?= esc($s['nisn']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-gray-700 dark:text-gray-300"><?= esc($s['no_pendaftaran']) ?></td>
                            <td class="py-3.5 px-4 text-gray-600 dark:text-gray-400"><?= esc($s['nama_sekolah']) ?></td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if (($s['status_lulus'] ?? '') === 'Lulus') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        <i class="fas fa-check-circle text-[10px]"></i> Lulus
                                    </span>
                                <?php elseif (($s['status_lulus'] ?? '') === 'Tidak Lulus') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                        <i class="fas fa-times-circle text-[10px]"></i> Tidak Lulus
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                        <i class="fas fa-clock text-[10px]"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <form action="<?= base_url('admin/kelulusan/update/' . $s['id_siswa']) ?>" method="post"
                                    class="inline-block status-form">
                                    <?= csrf_field() ?>
                                    <select name="status_lulus" onchange="confirmStatusChange(this)"
                                        class="h-8 rounded-lg border border-gray-200 bg-transparent px-2.5 py-1 text-xs text-gray-700 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:text-gray-300">
                                        <option value="Pending" <?= (($s['status_lulus'] ?? '') === 'Pending' || empty($s['status_lulus'])) ? 'selected' : '' ?>>Pending</option>
                                        <option value="Lulus" <?= ($s['status_lulus'] ?? '') === 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                                        <option value="Tidak Lulus" <?= ($s['status_lulus'] ?? '') === 'Tidak Lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-user-graduate text-4xl text-gray-300 dark:text-gray-700"></i>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada data siswa.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($siswa)) : ?>
    <div class="border-t border-gray-100 px-5 py-3.5 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex flex-col sm:flex-row justify-between items-center gap-3">
        <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data kelulusan siswa.</span>
        <div class="pagination-wrapper">
            <?= $pager->links() ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Bulk Action Floating Bar -->
<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40 w-full px-4 max-w-lg">
    <div class="bg-gray-900/90 backdrop-blur-md text-white rounded-2xl shadow-2xl px-5 py-3.5 flex items-center gap-3 border border-gray-700">
        <div class="flex items-center gap-2 text-xs min-w-0 font-medium">
            <i class="fas fa-check-square text-brand-400 shrink-0"></i>
            <span><strong id="selectedCount">0</strong> siswa dipilih</span>
        </div>
        <div class="h-5 w-px bg-gray-700 shrink-0"></div>

        <form action="<?= base_url('admin/kelulusan/bulkUpdate') ?>" method="post" id="bulkForm" class="flex gap-2 flex-1 justify-end">
            <?= csrf_field() ?>
            <input type="hidden" name="ids" id="bulkIds">
            <input type="hidden" name="status_lulus" id="bulkStatus">

            <button type="button" onclick="submitBulk('Lulus')"
                class="rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold py-1.5 px-3 transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-check text-xs"></i> Lulus
            </button>
            <button type="button" onclick="submitBulk('Tidak Lulus')"
                class="rounded-lg bg-red-600 hover:bg-red-500 text-white text-xs font-semibold py-1.5 px-3 transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-times text-xs"></i> Tidak Lulus
            </button>
            <button type="button" onclick="submitBulk('Pending')"
                class="rounded-lg bg-amber-600 hover:bg-amber-500 text-white text-xs font-semibold py-1.5 px-3 transition flex items-center gap-1 shadow-sm">
                <i class="fas fa-clock text-xs"></i> Pending
            </button>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    function toggleSelectAll(master) {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }

    function updateBulkBar() {
        const checked = document.querySelectorAll('.siswa-checkbox:checked');
        const bar = document.getElementById('bulkActionBar');
        const count = document.getElementById('selectedCount');
        const master = document.getElementById('selectAll');

        count.textContent = checked.length;
        if (checked.length > 0) {
            bar.classList.remove('hidden');
        } else {
            bar.classList.add('hidden');
            if (master) master.checked = false;
        }
    }

    function submitBulk(status) {
        const checked = document.querySelectorAll('.siswa-checkbox:checked');
        if (checked.length === 0) return;

        const ids = Array.from(checked).map(cb => cb.value).join(',');
        document.getElementById('bulkIds').value = ids;
        document.getElementById('bulkStatus').value = status;

        if (confirm(`Ubah status ${checked.length} siswa menjadi "${status}"?`)) {
            document.getElementById('bulkForm').submit();
        }
    }

    function confirmStatusChange(select) {
        const status = select.value;
        if (confirm(`Ubah status kelulusan menjadi "${status}"?`)) {
            select.form.submit();
        } else {
            select.value = select.dataset.prev || 'Pending';
        }
    }

    document.querySelectorAll('.status-form select').forEach(s => {
        s.dataset.prev = s.value;
    });
</script>

<style>
    .pagination-wrapper ul.pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.25rem;
    }
    .pagination-wrapper ul.pagination li a,
    .pagination-wrapper ul.pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.15s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background-color: #465fff;
        border-color: #465fff;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
