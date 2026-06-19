<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Status Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-gray-900"><?= $statusCounts['pending'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Valid</p>
                <p class="text-2xl font-bold text-gray-900"><?= $statusCounts['valid'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Invalid</p>
                <p class="text-2xl font-bold text-gray-900"><?= $statusCounts['invalid'] ?></p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h3 class="text-lg font-medium text-gray-900">Daftar Berkas Calon Siswa</h3>

            <form action="<?= base_url('verifikator/berkas') ?>" method="get" class="flex gap-2">
                <input type="text"
                    name="search"
                    value="<?= esc($search ?? '') ?>"
                    placeholder="Cari No. Pendaftaran, Nama, Jenis Berkas..."
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    <i class="fas fa-search"></i>
                </button>
                <?php if (!empty($search)) : ?>
                    <a href="<?= base_url('verifikator/berkas') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6 w-1/4">Info Siswa</th>
                    <th class="py-3 px-6 w-3/4">Daftar Berkas</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 align-top">
                            <!-- Student Info Column -->
                            <td class="py-4 px-6 bg-gray-50 border-r border-gray-200">
                                <div class="font-bold text-gray-800 text-base mb-1"><?= esc($student['nama_lengkap']) ?></div>
                                <div class="text-xs text-gray-500 mb-1">
                                    <span class="font-semibold">No. Pendaftaran:</span> <br>
                                    <span class="font-mono bg-white px-1 border rounded"><?= esc($student['no_pendaftaran']) ?></span>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <span class="font-semibold">NISN:</span> <?= esc($student['nisn']) ?>
                                </div>
                            </td>

                            <!-- Files Column -->
                            <td class="py-2 px-6 p-0">
                                <div class="rounded-lg border border-gray-200 overflow-hidden my-2">
                                    <table class="w-full">
                                        <thead class="bg-gray-100 text-xs font-semibold text-gray-700">
                                            <tr>
                                                <th class="py-2 px-3 text-left w-8">
                                                    <!-- Checkbox for bulk actions -->
                                                </th>
                                                <th class="py-2 px-3 text-left">Jenis Berkas</th>
                                                <th class="py-2 px-3 text-left">Nama File</th>
                                                <th class="py-2 px-3 text-center">Status</th>
                                                <th class="py-2 px-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($student['berkas_list'] as $b) : ?>
                                                <tr class="border-b last:border-0 border-gray-100 hover:bg-white transition-colors">
                                                    <td class="py-2 px-3 text-center">
                                                        <input type="checkbox" class="berkas-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="<?= esc($b['id_berkas']) ?>" onclick="updateBulkBar()">
                                                    </td>
                                                    <td class="py-2 px-3 align-middle">
                                                        <span class="font-medium text-gray-700"><?= esc($b['jenis_berkas']) ?></span>
                                                        <?php if (!empty($b['keterangan'])): ?>
                                                            <div class="text-xs text-gray-500 mt-0.5 italic flex">
                                                                <i class="fas fa-info-circle mr-1 mt-0.5 text-blue-500"></i>
                                                                <span><?= esc($b['keterangan']) ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2 px-3 align-middle">
                                                        <span class="text-xs font-mono bg-blue-50 text-blue-700 px-2 py-1 rounded inline-block max-w-[150px] truncate" title="<?= esc($b['nama_file']) ?>">
                                                            <?= esc($b['nama_file']) ?>
                                                        </span>
                                                        <div class="text-[10px] text-gray-400 mt-0.5"><?= !empty($b['created_at']) && strtotime($b['created_at']) ? date('d/M/Y H:i', strtotime($b['created_at'])) : '-' ?></div>
                                                    </td>
                                                    <td class="py-2 px-3 text-center align-middle">
                                                        <?php if ($b['status_verifikasi'] == 'valid') : ?>
                                                            <span class="bg-green-100 text-green-700 py-0.5 px-2 rounded text-xs font-semibold border border-green-200">
                                                                Valid
                                                            </span>
                                                        <?php elseif ($b['status_verifikasi'] == 'invalid') : ?>
                                                            <span class="bg-red-100 text-red-700 py-0.5 px-2 rounded text-xs font-semibold border border-red-200">
                                                                Invalid
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="bg-yellow-100 text-yellow-700 py-0.5 px-2 rounded text-xs font-semibold border border-yellow-200">
                                                                Pending
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2 px-3 text-center align-middle">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <?php
                                                            // Build preview URL
                                                            if (!empty($b['path_file'])) {
                                                                $previewUrl = base_url($b['path_file']);
                                                            } else {
                                                                $nisnDir = !empty($student['nisn']) ? $student['nisn'] : 'unknown';
                                                            $previewUrl = base_url('uploads/berkas/' . $nisnDir . '/' . $b['nama_file']);
                                                            }
                                                            $ext = strtolower(pathinfo($b['nama_file'], PATHINFO_EXTENSION));
                                                            ?>
                                                            <button onclick="openFilePreview('<?= esc($previewUrl) ?>', '<?= esc($b['nama_file']) ?>', '<?= esc($ext) ?>')"
                                                                class="text-blue-500 hover:text-blue-700 transition bg-blue-50 p-1.5 rounded"
                                                                title="Lihat Berkas">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button onclick="openStatusModal(<?= esc($b['id_berkas']) ?>, '<?= esc($b['status_verifikasi']) ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>')"
                                                                class="text-green-500 hover:text-green-700 transition bg-green-50 p-1.5 rounded"
                                                                title="Validasi Berkas">
                                                                <i class="fas fa-check-square"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="py-8 px-6 text-center text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                            <p><?= !empty($search) ? 'Tidak ada hasil pencarian.' : 'Belum ada data berkas yang diupload.' ?></p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pager) && $pager->getPageCount() > 1) : ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<!-- Bulk Action Bar (floating) -->
<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40 transition-all duration-300 ease-in-out">
    <div class="bg-gray-900 text-white rounded-xl shadow-2xl px-6 py-3 flex items-center gap-4">
        <span class="text-sm">
            <i class="fas fa-check-square text-blue-400 mr-1"></i>
            <span id="selectedCount" class="font-bold text-blue-400">0</span> berkas dipilih
        </span>
        <div class="h-6 w-px bg-gray-600"></div>
        <button onclick="bulkQuickAction('valid')" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition shadow">
            <i class="fas fa-check mr-1"></i>Valid
        </button>
        <button onclick="bulkQuickAction('invalid')" class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition shadow">
            <i class="fas fa-times mr-1"></i>Invalid
        </button>
        <button onclick="bulkQuickAction('pending')" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition shadow">
            <i class="fas fa-clock mr-1"></i>Pending
        </button>
        <button onclick="openBulkModal()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-1.5 px-4 rounded-lg transition shadow">
            <i class="fas fa-edit mr-1"></i>+ Keterangan
        </button>
        <button onclick="clearSelection()" class="text-gray-400 hover:text-white transition ml-2 bg-gray-800 p-1.5 rounded-full" title="Batal Pilih Semua">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Bulk Status Update Modal -->
<div id="bulkModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b border-gray-200 bg-blue-50 rounded-t-lg">
            <h3 class="text-lg font-medium text-blue-900 font-bold">
                <i class="fas fa-layer-group text-blue-600 mr-2"></i>Bulk Update Status
            </h3>
            <p class="text-sm text-gray-600 mt-1">Mengubah status <span id="bulkModalCount" class="font-bold text-blue-600">0</span> berkas sekaligus</p>
        </div>

        <form id="bulkForm" action="<?= base_url('verifikator/berkas/bulkUpdateStatus') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="ids" id="bulkIds">
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                    <select name="status" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border">
                        <option value="valid">Valid</option>
                        <option value="invalid">Invalid</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Verifikasi (opsional)</label>
                    <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan mengapa berkas valid/invalid..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3 border"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-2 rounded-b-lg">
                <button type="button" onclick="closeBulkModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 shadow">
                    <i class="fas fa-save mr-1"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Status Update Modal (Single File) -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-lg">
            <h3 class="text-lg font-medium text-green-900 font-bold"><i class="fas fa-check-square mr-2 text-green-600"></i> Validasi Berkas</h3>
        </div>

        <form id="statusForm" method="post">
            <?= csrf_field() ?>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="valid" required class="form-radio text-green-600 focus:ring-green-500 h-4 w-4">
                            <span class="ml-2 text-gray-700">Valid</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="invalid" required class="form-radio text-red-600 focus:ring-red-500 h-4 w-4">
                            <span class="ml-2 text-gray-700">Invalid</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="status" value="pending" required class="form-radio text-yellow-500 focus:ring-yellow-400 h-4 w-4">
                            <span class="ml-2 text-gray-700">Pending</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan/Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Tuliskan catatan perbaikan jika invalid..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-2 rounded-b-lg">
                <button type="button" onclick="closeStatusModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded transition duration-200">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200 shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden flex items-center justify-center">
    <div class="relative w-full h-full flex flex-col pt-16 md:pt-0">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-gray-900 border-b border-gray-800 text-white shadow-md">
            <h3 id="previewFileName" class="text-lg font-medium truncate flex-1 flex items-center">
                <i class="fas fa-file-alt mr-3 text-blue-400"></i>
                <span class="file-name-text"></span>
            </h3>
            <div class="flex items-center gap-4">
                <a id="previewDownloadBtn" href="#" download
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded font-medium transition flex items-center text-sm" title="Download file asli">
                    <i class="fas fa-download mr-2"></i> Unduh
                </a>
                <div class="w-px h-6 bg-gray-700 mx-1"></div>
                <button onclick="closeFilePreview()" class="text-gray-400 hover:text-white transition group flex items-center text-sm font-medium" title="Tutup Preview">
                    <span class="mr-2 uppercase tracking-wider">Tutup</span>
                    <div class="bg-gray-800 group-hover:bg-red-500 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </div>
                </button>
            </div>
        </div>
        <!-- Modal Content -->
        <div id="previewContent" class="flex-1 flex items-center justify-center overflow-auto p-4 md:p-8 bg-black">
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function openStatusModal(id, status, keterangan) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');

        form.action = '<?= base_url('verifikator/berkas/updateStatus/') ?>' + id;

        // Check correct radio button
        const radios = form.querySelectorAll('input[name="status"]');
        radios.forEach(radio => {
            radio.checked = (radio.value === status);
        });

        form.querySelector('[name="keterangan"]').value = keterangan;

        // Modal animations
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.add('scale-100', 'opacity-100');
            modal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.querySelector('.bg-white').classList.add('scale-95', 'opacity-0');
        modal.querySelector('.bg-white').classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    // Close modal when clicking outside
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStatusModal();
        }
    });

    // File Preview Modal
    function openFilePreview(url, fileName, ext) {
        const modal = document.getElementById('filePreviewModal');
        const content = document.getElementById('previewContent');
        const nameEl = document.querySelector('#previewFileName .file-name-text');
        const downloadBtn = document.getElementById('previewDownloadBtn');

        nameEl.textContent = fileName;
        downloadBtn.href = url;

        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const pdfExts = ['pdf'];

        content.innerHTML = '<div class="flex items-center justify-center text-white"><i class="fas fa-spinner fa-spin text-4xl mr-3"></i> Memuat...</div>';

        if (imageExts.includes(ext)) {
            const img = new Image();
            img.onload = function() {
                content.innerHTML = `<img src="${url}" alt="${fileName}" class="max-w-full max-h-[90vh] object-contain rounded shadow-2xl bg-white bg-opacity-10 p-2">`;
            }
            img.src = url;
        } else if (pdfExts.includes(ext)) {
            content.innerHTML = `<iframe src="${url}" class="w-full h-full max-w-6xl rounded shadow-2xl bg-white" style="min-height: 85vh;"></iframe>`;
        } else {
            content.innerHTML = `
                <div class="text-center text-white bg-gray-900 border border-gray-800 p-10 rounded-xl shadow-2xl max-w-md">
                    <i class="fas fa-file-archive text-6xl mb-6 text-blue-500"></i>
                    <p class="text-lg mb-2 font-medium">Berhasil Dimuat</p>
                    <p class="text-gray-400 mb-6 text-sm">Preview tidak tersedia untuk format file (.${ext}). Anda bisa mengunduhnya.</p>
                    <a href="${url}" download class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition inline-flex items-center shadow-lg">
                        <i class="fas fa-download mr-2"></i> Download File
                    </a>
                </div>`;
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeFilePreview() {
        const modal = document.getElementById('filePreviewModal');
        const content = document.getElementById('previewContent');
        modal.classList.add('hidden');
        content.innerHTML = '';
        document.body.style.overflow = ''; // Restore scrolling
    }

    // Close preview with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFilePreview();
            closeStatusModal();
            closeBulkModal();
        }
    });

    // Close preview when clicking outside content
    document.getElementById('filePreviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFilePreview();
        }
    });

    // ==========================================
    // Bulk Selection & Actions
    // ==========================================

    function getSelectedIds() {
        const checkboxes = document.querySelectorAll('.berkas-checkbox:checked');
        return Array.from(checkboxes).map(cb => cb.value);
    }

    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.berkas-checkbox');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        updateBulkBar();
    }

    function updateBulkBar() {
        const selected = getSelectedIds();
        const bar = document.getElementById('bulkActionBar');
        const countEl = document.getElementById('selectedCount');
        const allCheckboxes = document.querySelectorAll('.berkas-checkbox');

        countEl.textContent = selected.length;

        if (selected.length > 0) {
            bar.classList.remove('hidden', 'translate-y-20', 'opacity-0');
            bar.classList.add('translate-y-0', 'opacity-100');
        } else {
            bar.classList.add('translate-y-20', 'opacity-0');
            setTimeout(() => {
                if (getSelectedIds().length === 0) bar.classList.add('hidden');
            }, 300);
        }
    }

    function clearSelection() {
        document.querySelectorAll('.berkas-checkbox').forEach(cb => {
            cb.checked = false;
        });
        updateBulkBar();
    }

    function bulkQuickAction(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        const statusLabel = {
            'valid': 'Valid',
            'invalid': 'Invalid',
            'pending': 'Pending'
        };
        if (!confirm(`Ubah status ${ids.length} berkas menjadi ${statusLabel[status]}?`)) return;

        // Submit via hidden form
        const form = document.getElementById('bulkForm');
        document.getElementById('bulkIds').value = ids.join(',');
        form.querySelector('[name="status"]').value = status;
        form.querySelector('[name="keterangan"]').value = '';
        form.submit();
    }

    function openBulkModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        document.getElementById('bulkIds').value = ids.join(',');
        document.getElementById('bulkModalCount').textContent = ids.length;

        const modal = document.getElementById('bulkModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBulkModal() {
        const modal = document.getElementById('bulkModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('bulkModal').addEventListener('click', function(e) {
        if (e.target === this) closeBulkModal();
    });
</script>
<?= $this->endSection() ?>