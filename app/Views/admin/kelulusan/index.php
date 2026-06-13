<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Kelulusan Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Kelulusan Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<?php
$totalSiswa   = $totalAll ?? count($siswa);
$lulusCount   = $totalLulus ?? 0;
$tlCount      = $totalTl ?? 0;
$pendingCount = $totalPending ?? 0;
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
            <i class="fas fa-user-graduate text-gray-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Siswa</p>
            <p class="text-2xl font-bold text-gray-800"><?= $totalSiswa ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Lulus</p>
            <p class="text-2xl font-bold text-gray-800"><?= $lulusCount ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
            <i class="fas fa-times-circle text-red-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Tidak Lulus</p>
            <p class="text-2xl font-bold text-gray-800"><?= $tlCount ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
            <i class="fas fa-hourglass-half text-amber-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Pending</p>
            <p class="text-2xl font-bold text-gray-800"><?= $pendingCount ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <form action="<?= base_url('admin/kelulusan') ?>" method="get" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <h3 class="text-lg font-semibold text-gray-800 sm:mr-2">Data Kelulusan</h3>
            <div class="flex-1"></div>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                    placeholder="Cari Nama/NISN..."
                    class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none w-full sm:w-56">
            </div>
            <select name="status"
                class="border border-gray-300 rounded-lg text-sm px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                <option value="">Semua Status</option>
                <option value="Lulus" <?= ($status == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                <option value="Tidak Lulus" <?= ($status == 'Tidak Lulus') ? 'selected' : '' ?>>Tidak Lulus</option>
                <option value="Pending" <?= ($status == 'Pending') ? 'selected' : '' ?>>Pending</option>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-150 inline-flex items-center gap-2 shrink-0">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left" id="kelulusanTable">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="py-4 px-4 w-10">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"
                            class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    </th>
                    <th class="py-4 px-6">Siswa</th>
                    <th class="py-4 px-6">No. Pendaftaran</th>
                    <th class="py-4 px-6">Asal Sekolah</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) :
                        $initial = strtoupper(substr($s['nama_lengkap'], 0, 1));
                    ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="siswa-checkbox h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                    value="<?= $s['id_siswa'] ?>" onclick="updateBulkBar()">
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        <?= $initial ?>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-800"><?= esc($s['nama_lengkap']) ?></span>
                                        <span class="block text-xs text-gray-400">NISN: <?= esc($s['nisn']) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono text-sm"><?= esc($s['no_pendaftaran']) ?></td>
                            <td class="py-4 px-6"><?= esc($s['nama_sekolah']) ?></td>
                            <td class="py-4 px-6 text-center">
                                <?php if (($s['status_lulus'] ?? '') === 'Lulus') : ?>
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-check-circle text-xs"></i> Lulus
                                    </span>
                                <?php elseif (($s['status_lulus'] ?? '') === 'Tidak Lulus') : ?>
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-times-circle text-xs"></i> Tidak Lulus
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-clock text-xs"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="<?= base_url('admin/kelulusan/update/' . $s['id_siswa']) ?>" method="post"
                                    class="inline-block status-form">
                                    <?= csrf_field() ?>
                                    <select name="status_lulus" onchange="confirmStatusChange(this)"
                                        class="text-xs border border-gray-300 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
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
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i class="fas fa-user-graduate text-4xl"></i>
                                <p class="text-sm">Belum ada data siswa.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($siswa)) : ?>
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <span class="text-sm text-gray-500">Menampilkan data kelulusan.</span>
        <div class="pagination-wrapper">
            <?= $pager->links() ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40 w-full px-4 max-w-lg">
    <div class="bg-gray-900 text-white rounded-xl shadow-2xl px-5 py-3 flex items-center gap-3">
        <div class="flex items-center gap-2 text-sm min-w-0">
            <i class="fas fa-check-square text-green-400 shrink-0"></i>
            <span><strong id="selectedCount">0</strong> siswa dipilih</span>
        </div>
        <div class="h-5 w-px bg-gray-600 shrink-0"></div>

        <form action="<?= base_url('admin/kelulusan/bulkUpdate') ?>" method="post" id="bulkForm" class="flex gap-2 flex-1 justify-end">
            <?= csrf_field() ?>
            <input type="hidden" name="ids" id="bulkIds">
            <input type="hidden" name="status_lulus" id="bulkStatus">

            <button type="button" onclick="submitBulk('Lulus')"
                class="bg-green-600 hover:bg-green-500 text-white text-xs font-semibold py-1.5 px-3 rounded-lg transition flex items-center gap-1">
                <i class="fas fa-check text-xs"></i> Lulus
            </button>
            <button type="button" onclick="submitBulk('Tidak Lulus')"
                class="bg-red-600 hover:bg-red-500 text-white text-xs font-semibold py-1.5 px-3 rounded-lg transition flex items-center gap-1">
                <i class="fas fa-times text-xs"></i> Tidak Lulus
            </button>
        </form>

        <button onclick="clearSelection()" class="text-gray-400 hover:text-white transition shrink-0 ml-1" title="Batal">
            <i class="fas fa-times-circle text-lg"></i>
        </button>
    </div>
</div>

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
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.2s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background-color: #059669;
        border-color: #059669;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>

<script>
    function toggleSelectAll(master) {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }

    function updateBulkBar() {
        const selected = document.querySelectorAll('.siswa-checkbox:checked');
        const bar = document.getElementById('bulkActionBar');
        document.getElementById('selectedCount').innerText = selected.length;
        bar.classList.toggle('hidden', selected.length === 0);
    }

    function clearSelection() {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateBulkBar();
    }

    function confirmStatusChange(sel) {
        const label = sel.options[sel.selectedIndex].text;
        if (!confirm('Ubah status menjadi ' + label + '?')) {
            sel.value = sel.getAttribute('data-prev') || sel.querySelector('option[selected]')?.value || 'Pending';
            return;
        }
        sel.closest('form').submit();
    }

    document.querySelectorAll('.status-form select').forEach(sel => {
        sel.setAttribute('data-prev', sel.value);
        sel.addEventListener('focus', function() { this.setAttribute('data-prev', this.value); });
    });

    function submitBulk(status) {
        const ids = Array.from(document.querySelectorAll('.siswa-checkbox:checked')).map(cb => cb.value);
        if (ids.length === 0) return;
        if (!confirm('Set status ' + status + ' untuk ' + ids.length + ' data terpilih?')) return;
        document.getElementById('bulkIds').value = ids.join(',');
        document.getElementById('bulkStatus').value = status;
        document.getElementById('bulkForm').submit();
    }
</script>

<?= $this->endSection() ?>
