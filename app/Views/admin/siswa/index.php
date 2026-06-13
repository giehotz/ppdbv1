<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Calon Siswa
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

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header Section -->
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Daftar Calon Siswa</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola data pendaftaran, verifikasi, dan berkas siswa.</p>
            </div>

            <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3">
                <a href="<?= base_url('admin/siswa/export-excel') ?>" class="flex justify-center items-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm whitespace-nowrap">
                    <i class="fas fa-file-excel mr-2"></i> Export Excel
                </a>

                <form action="<?= base_url('admin/siswa') ?>" method="get" class="flex w-full sm:w-auto">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm">
                    </div>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 border border-gray-800 transition duration-200 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                        Cari
                    </button>
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('admin/siswa') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-l-0 border-red-200 font-medium py-2 px-4 rounded-r-lg transition duration-200 flex items-center" title="Reset Pencarian">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs tracking-wider">
                    <th class="py-4 px-6 font-semibold">No. Pendaftaran</th>
                    <th class="py-4 px-6 font-semibold">NISN</th>
                    <th class="py-4 px-6 font-semibold">Nama Lengkap</th>
                    <th class="py-4 px-6 font-semibold">Gender</th>
                    <th class="py-4 px-6 font-semibold">Kelengkapan</th>
                    <th class="py-4 px-6 font-semibold">Status Validasi</th>
                    <th class="py-4 px-6 font-semibold">Tanggal Daftar</th>
                    <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/80 transition-colors">
                            <td class="py-3 px-6 whitespace-nowrap font-bold text-gray-800">
                                <span class="bg-gray-100 text-gray-700 py-1 px-2 rounded text-xs"><?= esc($s['no_pendaftaran']) ?></span>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap"><?= esc($s['nisn'] ?? '-') ?></td>
                            <td class="py-3 px-6 font-medium text-gray-900"><?= esc($s['nama_lengkap']) ?></td>
                            <td class="py-3 px-6">
                                <?= $s['jk'] == 'L' ? '<span class="text-blue-600" title="Laki-laki"><i class="fas fa-mars mr-1"></i> L</span>' : '<span class="text-pink-600" title="Perempuan"><i class="fas fa-venus mr-1"></i> P</span>' ?>
                            </td>
                            <td class="py-3 px-6 min-w-[150px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="<?= $s['kelengkapan'] == 100 ? 'bg-emerald-500' : ($s['kelengkapan'] >= 50 ? 'bg-blue-500' : 'bg-red-500') ?> h-2.5 rounded-full" style="width: <?= esc($s['kelengkapan']) ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 font-bold"><?= esc($s['kelengkapan']) ?>%</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] == 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold border border-emerald-200">
                                        <i class="fas fa-check-circle mr-1.5"></i> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] == 'Ditolak') : ?>
                                    <span class="inline-flex items-center bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold border border-red-200">
                                        <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-bold border border-amber-200">
                                        <i class="fas fa-clock mr-1.5"></i> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap text-gray-500">
                                <?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="<?= base_url('admin/siswa/detail/' . $s['id_siswa']) ?>"
                                        class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-transform"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                    <a href="<?= base_url('admin/siswa/cetak/' . $s['id_siswa']) ?>" target="_blank"
                                        class="text-emerald-500 hover:text-emerald-700 transform hover:scale-110 transition-transform"
                                        title="Cetak Formulir">
                                        <i class="fas fa-print text-lg"></i>
                                    </a>
                                    <a href="<?= base_url('admin/siswa/cetak-kartu/' . $s['id_siswa']) ?>" target="_blank"
                                        class="text-purple-500 hover:text-purple-700 transform hover:scale-110 transition-transform"
                                        title="Cetak Kartu Pelajar">
                                        <i class="fas fa-id-card text-lg"></i>
                                    </a>
                                    <form action="<?= base_url('admin/siswa/resetPassword/' . $s['id_siswa']) ?>" method="post" class="inline-block" data-confirm="Yakin ingin mereset password siswa ini menjadi 123456?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-amber-500 hover:text-amber-700 transform hover:scale-110 transition-transform focus:outline-none" title="Reset Password">
                                            <i class="fas fa-key text-lg"></i>
                                        </button>
                                    </form>
                                    <button type="button"
                                        onclick="openDeleteModal('<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= base_url('admin/siswa/delete/' . $s['id_siswa']) ?>')"
                                        class="text-red-500 hover:text-red-700 transform hover:scale-110 transition-transform focus:outline-none"
                                        title="Hapus Data">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Empty State -->
                    <tr>
                        <td colspan="8" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <?php if (!empty($search)) : ?>
                                    <i class="fas fa-search-minus text-5xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-600 mb-1">Pencarian Tidak Ditemukan</p>
                                    <p class="text-sm">Tidak ada siswa dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('admin/siswa') ?>" class="mt-4 text-emerald-600 hover:underline text-sm font-medium">Clear Pencarian</a>
                                <?php else : ?>
                                    <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-600 mb-1">Belum Ada Data</p>
                                    <p class="text-sm">Belum ada calon siswa yang mendaftar saat ini.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($siswa)) : ?>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-sm text-gray-500">Menampilkan data calon siswa.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal (Dipertahankan dan dirapikan sedikit) -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-95 opacity-0" id="deleteModalContent">
            <!-- Header -->
            <div class="bg-red-50 rounded-t-2xl px-6 py-5 border-b border-red-100">
                <div class="flex items-center gap-4">
                    <div class="bg-red-100 rounded-full p-3 shadow-sm">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-800">Konfirmasi Hapus Data</h3>
                        <p class="text-sm text-red-600 mt-0.5">Tindakan ini permanen!</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <p class="text-gray-600 mb-1 text-sm">Anda akan menghapus seluruh data pendaftaran milik:</p>
                <p class="text-gray-900 font-bold text-xl mb-5 pb-4 border-b border-gray-100" id="deleteStudentName"></p>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-5">
                    <p class="text-amber-800 text-sm flex items-start">
                        <i class="fas fa-info-circle mt-0.5 mr-2"></i> 
                        <span>Untuk mencegah kesalahan, silakan ketik kata <strong class="text-red-600 uppercase tracking-wide">hapus</strong> di bawah ini:</span>
                    </p>
                </div>

                <input type="text" id="deleteConfirmInput"
                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 text-center text-lg font-medium focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/20 transition-all placeholder-gray-400"
                    placeholder="Ketik 'hapus' di sini"
                    autocomplete="off">
                <p class="text-xs text-gray-500 mt-2 text-center" id="deleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex gap-3 justify-end bg-gray-50 rounded-b-2xl">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition duration-200 shadow-sm">
                    Batal
                </button>
                <button type="button" id="deleteConfirmBtn" disabled onclick="executeDelete()"
                    class="px-5 py-2.5 bg-red-400 text-white font-semibold rounded-xl transition-all duration-200 cursor-not-allowed opacity-60 flex items-center shadow-sm">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Permanen
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteUrl = '';

    function openDeleteModal(name, url) {
        deleteUrl = url;
        document.getElementById('deleteStudentName').textContent = name;
        document.getElementById('deleteConfirmInput').value = '';
        document.getElementById('deleteHint').textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
        document.getElementById('deleteHint').className = 'text-xs text-gray-500 mt-2 text-center';
        resetDeleteBtn();

        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');

        // Animate in
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Focus input
        setTimeout(() => {
            document.getElementById('deleteConfirmInput').focus();
        }, 200);
    }

    function closeDeleteModal() {
        const content = document.getElementById('deleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('deleteModal').classList.add('hidden');
        }, 200);
    }

    function resetDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = true;
        btn.classList.add('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    function enableDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = false;
        btn.classList.remove('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100', 'hover:shadow-md');
    }

    document.getElementById('deleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('deleteHint');

        if (value === 'hapus') {
            enableDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-xs text-emerald-600 mt-2 text-center font-medium';
            this.classList.remove('border-gray-300', 'focus:border-red-500', 'focus:ring-red-500/20');
            this.classList.add('border-emerald-500', 'focus:border-emerald-500', 'focus:ring-emerald-500/20');
        } else {
            resetDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-xs text-red-500 mt-2 text-center';
                this.classList.remove('border-gray-300', 'border-emerald-500', 'focus:border-emerald-500', 'focus:ring-emerald-500/20');
                this.classList.add('border-red-400', 'focus:border-red-500', 'focus:ring-red-500/20');
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-xs text-gray-500 mt-2 text-center';
                this.classList.remove('border-red-400', 'border-emerald-500', 'focus:border-emerald-500', 'focus:ring-emerald-500/20', 'focus:ring-red-500/20');
                this.classList.add('border-gray-300', 'focus:border-red-500', 'focus:ring-red-500/20');
            }
        }
    });

    // Allow Enter key to confirm when valid
    document.getElementById('deleteConfirmInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && this.value.trim().toLowerCase() === 'hapus') {
            e.preventDefault(); // Hindari submit form lain jika ada
            executeDelete();
        }
    });

    function executeDelete() {
        if (deleteUrl) {
            window.location.href = deleteUrl;
        }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

<style>
    /* Styling tambahan untuk pagination bawaan CI4 agar cocok dengan desain Tailwind */
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