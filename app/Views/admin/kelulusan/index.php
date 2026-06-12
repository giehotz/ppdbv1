<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Kelulusan Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Kelulusan Siswa
<?= $this->endSection() ?>

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

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h3 class="text-lg font-medium text-gray-900">Data Kelulusan</h3>

            <form action="<?= base_url('admin/kelulusan') ?>" method="get" class="flex gap-2">
                <select name="status" class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <option value="">Semua Status</option>
                    <option value="Lulus" <?= ($status == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                    <option value="Tidak Lulus" <?= ($status == 'Tidak Lulus') ? 'selected' : '' ?>>Tidak Lulus</option>
                    <option value="Pending" <?= ($status == 'Pending') ? 'selected' : '' ?>>Pending</option>
                </select>
                <input type="text"
                    name="search"
                    value="<?= esc($search ?? '') ?>"
                    placeholder="Cari Nama/NISN..."
                    class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-4 w-10">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" class="h-4 w-4 text-green-600 border-gray-300 rounded">
                    </th>
                    <th class="py-3 px-6">No. Pendaftaran</th>
                    <th class="py-3 px-6">Nama Siswa</th>
                    <th class="py-3 px-6">Asal Sekolah</th>
                    <th class="py-3 px-6 text-center">Status Kelulusan</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <input type="checkbox" class="siswa-checkbox h-4 w-4 text-green-600 border-gray-300 rounded" value="<?= $s['id_siswa'] ?>" onclick="updateBulkBar()">
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap font-medium"><?= $s['no_pendaftaran'] ?></td>
                            <td class="py-3 px-6">
                                <span class="font-bold"><?= $s['nama_lengkap'] ?></span><br>
                                <span class="text-xs text-gray-500">NISN: <?= $s['nisn'] ?></span>
                            </td>
                            <td class="py-3 px-6"><?= $s['nama_sekolah'] ?></td>
                            <td class="py-3 px-6 text-center">
                                <?php if ($s['status_lulus'] == 'Lulus') : ?>
                                    <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Lulus</span>
                                <?php elseif ($s['status_lulus'] == 'Tidak Lulus') : ?>
                                    <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs font-bold">Tidak Lulus</span>
                                <?php else : ?>
                                    <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <form action="<?= base_url('admin/kelulusan/update/' . $s['id_siswa']) ?>" method="post" class="inline-block">
                                    <?= csrf_field() ?>
                                    <div class="relative inline-block text-left">
                                        <select name="status_lulus" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-1 text-xs border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md">
                                            <option value="Pending" <?= ($s['status_lulus'] == 'Pending' || empty($s['status_lulus'])) ? 'selected' : '' ?>>Pending</option>
                                            <option value="Lulus" <?= ($s['status_lulus'] == 'Lulus') ? 'selected' : '' ?>>Lulus</option>
                                            <option value="Tidak Lulus" <?= ($s['status_lulus'] == 'Tidak Lulus') ? 'selected' : '' ?>>Tidak Lulus</option>
                                        </select>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                            Belum ada data siswa.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200">
        <?= $pager->links() ?>
    </div>
</div>

<!-- Bulk Action Bar -->
<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40">
    <div class="bg-gray-900 text-white rounded-xl shadow-2xl px-6 py-3 flex items-center gap-4">
        <span class="text-sm">
            <i class="fas fa-check-square mr-1"></i>
            <span id="selectedCount">0</span> siswa dipilih
        </span>
        <div class="h-6 w-px bg-gray-600"></div>

        <form action="<?= base_url('admin/kelulusan/bulkUpdate') ?>" method="post" id="bulkForm" class="flex gap-2">
            <?= csrf_field() ?>
            <input type="hidden" name="ids" id="bulkIds">
            <input type="hidden" name="status_lulus" id="bulkStatus">

            <button type="button" onclick="submitBulk('Lulus')" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition">
                <i class="fas fa-check mr-1"></i>Set Lulus
            </button>
            <button type="button" onclick="submitBulk('Tidak Lulus')" class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition">
                <i class="fas fa-times mr-1"></i>Set Tidak Lulus
            </button>
        </form>

        <button onclick="clearSelection()" class="text-gray-400 hover:text-white transition ml-2" title="Batal Pilih">
            <i class="fas fa-times-circle text-lg"></i>
        </button>
    </div>
</div>

<script>
    function toggleSelectAll(master) {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }

    function updateBulkBar() {
        const selected = document.querySelectorAll('.siswa-checkbox:checked');
        const bar = document.getElementById('bulkActionBar');
        document.getElementById('selectedCount').innerText = selected.length;

        if (selected.length > 0) bar.classList.remove('hidden');
        else bar.classList.add('hidden');
    }

    function clearSelection() {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        updateBulkBar();
    }

    function submitBulk(status) {
        if (!confirm('Set status ' + status + ' untuk data terpilih?')) return;

        const ids = Array.from(document.querySelectorAll('.siswa-checkbox:checked')).map(cb => cb.value);
        document.getElementById('bulkIds').value = ids.join(',');
        document.getElementById('bulkStatus').value = status;
        document.getElementById('bulkForm').submit();
    }
</script>

<?= $this->endSection() ?>