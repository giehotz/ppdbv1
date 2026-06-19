<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center" role="alert">
        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
        <span class="block sm:inline font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center" role="alert">
        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
        <span class="block sm:inline font-medium"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Status Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-200">
        <div class="flex-shrink-0 bg-amber-50 rounded-xl p-4 border border-amber-100">
            <i class="fas fa-clock text-amber-500 text-2xl"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending</p>
            <p class="text-3xl font-black text-gray-800"><?= $statusCounts['pending'] ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-200">
        <div class="flex-shrink-0 bg-emerald-50 rounded-xl p-4 border border-emerald-100">
            <i class="fas fa-check-circle text-emerald-500 text-2xl"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Valid</p>
            <p class="text-3xl font-black text-gray-800"><?= $statusCounts['valid'] ?></p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-200">
        <div class="flex-shrink-0 bg-red-50 rounded-xl p-4 border border-red-100">
            <i class="fas fa-times-circle text-red-500 text-2xl"></i>
        </div>
        <div class="ml-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Invalid</p>
            <p class="text-3xl font-black text-gray-800"><?= $statusCounts['invalid'] ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header Section -->
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Daftar Berkas Calon Siswa</h3>
                <p class="text-sm text-gray-500 mt-1">Periksa dan validasi dokumen persyaratan pendaftaran.</p>
            </div>

            <form action="<?= base_url('admin/berkas') ?>" method="get" class="flex w-full lg:w-auto">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Cari No. Daftar, Nama, Jenis..."
                        class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm">
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 border border-gray-800 transition duration-200 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                    Cari
                </button>
                <?php if (!empty($search)) : ?>
                    <a href="<?= base_url('admin/berkas') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-l-0 border-red-200 font-medium py-2 px-4 rounded-r-lg transition duration-200 flex items-center" title="Reset Pencarian">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                    <th class="py-4 px-6 w-1/4">Informasi Siswa</th>
                    <th class="py-4 px-6 w-3/4">Daftar Berkas Terunggah</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/30 transition-colors align-top">
                            <!-- Student Info Column -->
                            <td class="py-5 px-6 bg-gray-50/50 border-r border-gray-100">
                                <div class="font-bold text-gray-900 text-base mb-2"><?= esc($student['nama_lengkap']) ?></div>
                                <div class="space-y-1.5">
                                    <div class="text-xs text-gray-500 flex flex-col">
                                        <span class="font-medium mb-1">No. Pendaftaran:</span>
                                        <span class="font-mono bg-white text-gray-800 px-2 py-1 border border-gray-200 rounded text-xs w-max"><?= esc($student['no_pendaftaran']) ?></span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2 flex flex-col">
                                        <span class="font-medium mb-1">NISN:</span>
                                        <span class="text-gray-800"><?= esc($student['nisn']) ?></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Files Column -->
                            <td class="py-4 px-6">
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                    <table class="w-full text-left">
                                        <thead class="bg-gray-50 text-xs font-semibold text-gray-600 border-b border-gray-100">
                                            <tr>
                                                <th class="py-2.5 px-4 w-10 text-center">
                                                    <!-- Optional Header Checkbox placeholder -->
                                                    <i class="fas fa-check text-gray-300"></i>
                                                </th>
                                                <th class="py-2.5 px-4 w-1/3">Jenis Berkas</th>
                                                <th class="py-2.5 px-4 w-1/3">Nama File & Waktu</th>
                                                <th class="py-2.5 px-4 text-center">Status</th>
                                                <th class="py-2.5 px-4 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <?php foreach ($student['berkas_list'] as $b) : ?>
                                                <tr class="hover:bg-gray-50/80 transition-colors">
                                                    <td class="py-3 px-4 text-center align-middle">
                                                        <input type="checkbox" class="berkas-checkbox h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer" value="<?= $b['id_berkas'] ?>" onclick="updateBulkBar()">
                                                    </td>
                                                    <td class="py-3 px-4 align-middle">
                                                        <span class="font-semibold text-gray-800 block"><?= esc($b['jenis_berkas']) ?></span>
                                                        <?php if (!empty($b['keterangan'])): ?>
                                                            <div class="text-xs text-amber-600 mt-1 bg-amber-50 px-2 py-1 rounded-md inline-flex items-start max-w-full">
                                                                <i class="fas fa-info-circle mr-1.5 mt-0.5"></i>
                                                                <span class="leading-tight"><?= esc($b['keterangan']) ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-3 px-4 align-middle">
                                                        <div class="flex flex-col items-start">
                                                            <span class="text-xs font-mono bg-blue-50 text-blue-700 px-2 py-1 rounded-md border border-blue-100 block max-w-[200px] truncate" title="<?= esc($b['nama_file']) ?>">
                                                                <i class="fas fa-file-alt mr-1"></i><?= esc($b['nama_file']) ?>
                                                            </span>
                                                            <div class="text-[11px] text-gray-400 mt-1.5 font-medium flex items-center">
                                                                <i class="far fa-clock mr-1"></i> <?= date('d M Y, H:i', strtotime($b['created_at'])) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 text-center align-middle">
                                                        <?php if ($b['status_verifikasi'] == 'valid') : ?>
                                                            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 py-1 px-2.5 rounded-full text-xs font-bold border border-emerald-200">
                                                                Valid
                                                            </span>
                                                        <?php elseif ($b['status_verifikasi'] == 'invalid') : ?>
                                                            <span class="inline-flex items-center bg-red-100 text-red-700 py-1 px-2.5 rounded-full text-xs font-bold border border-red-200">
                                                                Invalid
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="inline-flex items-center bg-amber-100 text-amber-700 py-1 px-2.5 rounded-full text-xs font-bold border border-amber-200">
                                                                Pending
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-3 px-4 text-center align-middle">
                                                        <div class="flex items-center justify-center gap-3">
                                                            <?php
                                                            // Build preview URL
                                                            if (!empty($b['path_file'])) {
                                                                $previewUrl = base_url($b['path_file']);
                                                            } else {
                                                                $previewUrl = base_url('uploads/berkas/' . ($student['nisn'] ?? '') . '/' . $b['nama_file']);
                                                            }
                                                            $ext = strtolower(pathinfo($b['nama_file'], PATHINFO_EXTENSION));
                                                            ?>
                                                            <button onclick="openFilePreview('<?= esc($previewUrl, 'js') ?>', '<?= esc($b['nama_file'], 'js') ?>', '<?= esc($ext, 'js') ?>')"
                                                                class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition duration-200"
                                                                title="Lihat Berkas">
                                                                <i class="fas fa-eye text-lg"></i>
                                                            </button>
                                                            <button onclick="openStatusModal(<?= (int)$b['id_berkas'] ?>, '<?= esc($b['status_verifikasi'], 'js') ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>')"
                                                                class="text-emerald-500 hover:text-emerald-700 transform hover:scale-110 transition duration-200"
                                                                title="Validasi Berkas">
                                                                <i class="fas fa-check-square text-lg"></i>
                                                            </button>
                                                            <form method="post" action="<?= base_url('admin/berkas/delete/' . $b['id_berkas']) ?>"
                                                                data-confirm="Yakin ingin menghapus berkas ini?"
                                                                style="display:inline">
                                                                <?= csrf_field() ?>
                                                                <button type="submit"
                                                                    class="text-red-500 hover:text-red-700 transform hover:scale-110 transition duration-200"
                                                                    title="Hapus Berkas">
                                                                    <i class="fas fa-trash-alt text-lg"></i>
                                                                </button>
                                                            </form>
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
                        <td colspan="2" class="py-12 px-6 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-50 p-6 rounded-full mb-4 border border-gray-100">
                                    <i class="fas fa-folder-open text-5xl text-gray-300"></i>
                                </div>
                                <p class="text-lg font-medium text-gray-600 mb-1"><?= !empty($search) ? 'Berkas Tidak Ditemukan' : 'Belum Ada Berkas' ?></p>
                                <p class="text-sm text-gray-400"><?= !empty($search) ? 'Silakan gunakan kata kunci lain.' : 'Belum ada calon siswa yang mengunggah dokumen.' ?></p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($berkas)) : ?>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-sm text-gray-500">Menampilkan manajemen data berkas.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Floating Bulk Action Bar -->
<div id="bulkActionBar" class="hidden fixed bottom-8 left-1/2 transform -translate-x-1/2 z-40 transition-all duration-300 ease-in-out">
    <div class="bg-gray-900/95 backdrop-blur shadow-2xl rounded-2xl border border-gray-700 px-6 py-3.5 flex items-center gap-4">
        <span class="text-sm font-medium text-white flex items-center">
            <span class="bg-emerald-500 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold mr-2" id="selectedCount">0</span>
            Berkas Dipilih
        </span>
        <div class="h-6 w-px bg-gray-700"></div>
        <button onclick="bulkQuickAction('valid')" class="flex items-center text-sm font-semibold text-emerald-400 hover:text-white hover:bg-emerald-600 py-1.5 px-3 rounded-lg transition-colors">
            <i class="fas fa-check mr-2"></i>Set Valid
        </button>
        <button onclick="bulkQuickAction('invalid')" class="flex items-center text-sm font-semibold text-red-400 hover:text-white hover:bg-red-600 py-1.5 px-3 rounded-lg transition-colors">
            <i class="fas fa-times mr-2"></i>Set Invalid
        </button>
        <button onclick="bulkQuickAction('pending')" class="flex items-center text-sm font-semibold text-amber-400 hover:text-white hover:bg-amber-500 py-1.5 px-3 rounded-lg transition-colors">
            <i class="fas fa-clock mr-2"></i>Set Pending
        </button>
        <div class="h-6 w-px bg-gray-700"></div>
        <button onclick="openBulkModal()" class="flex items-center text-sm font-semibold text-blue-400 hover:text-white hover:bg-blue-600 py-1.5 px-3 rounded-lg transition-colors">
            <i class="fas fa-comment-dots mr-2"></i>Update Keterangan
        </button>
        <button onclick="clearSelection()" class="ml-2 text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 p-2 rounded-full transition-colors focus:outline-none" title="Batal Pilih Semua">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Bulk Status Update Modal -->
<div id="bulkModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeBulkModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all" id="bulkModalContent">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 rounded-t-2xl flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <i class="fas fa-layer-group text-blue-500 mr-2"></i> Update Massal
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Status untuk <span id="bulkModalCount" class="font-bold text-gray-800 bg-gray-200 px-1.5 rounded">0</span> berkas.</p>
                </div>
                <button onclick="closeBulkModal()" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fas fa-times"></i></button>
            </div>

            <form id="bulkForm" action="<?= base_url('admin/berkas/bulkUpdateStatus') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="ids" id="bulkIds">
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Status Baru</label>
                        <select name="status" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5 px-4 border outline-none">
                            <option value="valid">Valid (Disetujui)</option>
                            <option value="invalid">Invalid (Ditolak / Perbaiki)</option>
                            <option value="pending">Pending (Menunggu)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan untuk siswa terkait berkas ini..." class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 border outline-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex justify-end gap-3">
                    <button type="button" onclick="closeBulkModal()" class="px-5 py-2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition duration-200 shadow-sm flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Status Update Modal -->
<div id="statusModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeStatusModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all" id="statusModalContent">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                    <i class="fas fa-check-square text-emerald-500 mr-2"></i> Validasi Berkas
                </h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 text-xl"><i class="fas fa-times"></i></button>
            </div>

            <form id="statusForm" method="post">
                <?= csrf_field() ?>
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Validasi</label>
                        <select name="status" required class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5 px-4 border outline-none">
                            <option value="pending">Pending</option>
                            <option value="valid">Valid (Disetujui)</option>
                            <option value="invalid">Invalid (Perlu Diperbaiki)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan/Keterangan</label>
                        <textarea name="keterangan" rows="3" placeholder="Alasan penolakan atau catatan validasi..." class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-3 px-4 border outline-none"></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()" class="px-5 py-2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition duration-200 shadow-sm flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center backdrop-blur-sm">
    <div class="relative w-full h-full flex flex-col">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-gray-900/50 text-white absolute top-0 w-full z-10">
            <h3 id="previewFileName" class="text-sm font-medium truncate flex items-center">
                <i class="fas fa-file-alt mr-2 text-gray-400"></i> <span id="previewTextName"></span>
            </h3>
            <div class="flex items-center gap-4">
                <a id="previewDownloadBtn" href="#" download
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition flex items-center shadow-sm" title="Download Berkas">
                    <i class="fas fa-download mr-1.5"></i> Unduh
                </a>
                <button onclick="closeFilePreview()" class="text-gray-300 hover:text-red-400 transition bg-gray-800 hover:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center" title="Tutup Preview">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- Modal Content -->
        <div id="previewContent" class="flex-1 flex items-center justify-center overflow-auto p-4 pt-20 pb-10">
            <!-- Content Injected via JS -->
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // ==========================================
    // Modals Handling
    // ==========================================
    function openStatusModal(id, status, keterangan) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');

        form.action = '<?= base_url('admin/berkas/updateStatus/') ?>' + id;
        form.querySelector('[name="status"]').value = status;
        form.querySelector('[name="keterangan"]').value = keterangan;

        modal.classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    // File Preview Modal
    function openFilePreview(url, fileName, ext) {
        const modal = document.getElementById('filePreviewModal');
        const content = document.getElementById('previewContent');
        const nameEl = document.getElementById('previewTextName');
        const downloadBtn = document.getElementById('previewDownloadBtn');

        nameEl.textContent = fileName;
        downloadBtn.href = url;

        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const pdfExts = ['pdf'];

        if (imageExts.includes(ext)) {
            content.innerHTML = `<img src="${url}" alt="${fileName}" class="max-w-[95%] max-h-[90vh] object-contain rounded-lg shadow-2xl border border-gray-700">`;
        } else if (pdfExts.includes(ext)) {
            content.innerHTML = `<iframe src="${url}" class="w-full h-full max-w-5xl rounded-xl border border-gray-700 bg-white" style="height: 85vh;"></iframe>`;
        } else {
            content.innerHTML = `
                <div class="text-center text-white bg-gray-800 border border-gray-700 p-10 rounded-2xl shadow-2xl max-w-md">
                    <i class="fas fa-file-archive text-7xl mb-5 text-gray-500"></i>
                    <p class="text-lg font-medium mb-2">Preview Tidak Tersedia</p>
                    <p class="text-gray-400 text-sm mb-6">Format file <strong>.${ext}</strong> tidak dapat dipreview langsung di browser.</p>
                    <a href="${url}" download class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg">
                        <i class="fas fa-download mr-2"></i>Download File Sekarang
                    </a>
                </div>`;
        }

        modal.classList.remove('hidden');
    }

    function closeFilePreview() {
        document.getElementById('filePreviewModal').classList.add('hidden');
        document.getElementById('previewContent').innerHTML = '';
    }

    // Close Modals via Keyboard
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFilePreview();
            closeStatusModal();
            closeBulkModal();
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
        
        // Removed global selectAll logic as it's not present in this nested table structure easily, 
        // relying on individual checkbox selection.

        countEl.textContent = selected.length;

        if (selected.length > 0) {
            bar.classList.remove('hidden');
            // Adding a small delay for animation effect
            setTimeout(() => {
                bar.classList.remove('translate-y-full', 'opacity-0');
            }, 10);
        } else {
            bar.classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.berkas-checkbox').forEach(cb => cb.checked = false);
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
        if (!confirm(`Apakah Anda yakin ingin mengubah status ${ids.length} berkas menjadi ${statusLabel[status]}?`)) return;

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
        document.getElementById('bulkModal').classList.remove('hidden');
    }

    function closeBulkModal() {
        document.getElementById('bulkModal').classList.add('hidden');
    }
</script>

<style>
    /* Styling tambahan untuk pagination bawaan CI4 */
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
        background-color: #059669; /* emerald-600 */
        border-color: #059669;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>

<?= $this->endSection() ?>