<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('print_password')) : ?>
    <?php session()->keepFlashdata('print_password'); ?>
    <script>
        window.open('<?= base_url('admin/siswa/cetak-password') ?>', '_blank');
    </script>
<?php endif; ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Calon Siswa</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data pendaftaran, kelengkapan berkas, dan status verifikasi siswa.</p>
            </div>

            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch sm:items-center gap-2.5">
                <a href="<?= base_url('admin/siswa/reset-throttle') ?>"
                   onclick="return confirm('Reset batas waktu login untuk membuka seluruh IP/akun yang terkunci?');"
                   class="inline-flex items-center justify-center gap-1.5 h-9 rounded-lg border border-amber-200 bg-amber-50 px-3 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 transition-colors shadow-theme-xs shrink-0"
                   title="Reset batas waktu 15 menit login jika ada akun/IP terkunci">
                    <i class="fas fa-unlock-alt text-xs"></i>
                    <span>Reset Batas Waktu Login</span>
                </a>

                <a href="<?= base_url('admin/siswa/export-excel') ?>"
                   class="inline-flex items-center justify-center gap-2 h-9 rounded-lg bg-emerald-600 px-4 text-xs font-semibold text-white shadow-theme-xs transition-all hover:bg-emerald-700 shrink-0">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <form action="<?= base_url('admin/siswa') ?>" method="get" class="flex w-full sm:w-auto">
                    <input type="hidden" name="sort" value="<?= esc($sort ?? 'ASC') ?>">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-search text-xs"></i>
                        </span>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="h-9 w-full rounded-l-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:border-brand-400 sm:w-64">
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center bg-gray-800 px-4 text-xs font-semibold text-white transition-colors hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                        Cari
                    </button>
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('admin/siswa') ?>"
                           class="flex items-center justify-center border border-l-0 border-red-200 bg-red-50 px-3 text-red-600 transition-colors hover:bg-red-100 rounded-r-lg dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400"
                           title="Reset Pencarian">
                            <i class="fas fa-times text-xs"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-4 text-center w-12">No</th>
                    <th class="py-3.5 px-4">No. Pendaftaran</th>
                    <th class="py-3.5 px-4">NISN</th>
                    <th class="py-3.5 px-4">Nama Lengkap</th>
                    <th class="py-3.5 px-4">Gender</th>
                    <th class="py-3.5 px-4">Kelengkapan</th>
                    <th class="py-3.5 px-4">Status Validasi</th>
                    <th class="py-3.5 px-4">
                        <a href="<?= base_url('admin/siswa') ?>?search=<?= esc($search ?? '') ?>&sort=<?= ($sort ?? 'ASC') == 'ASC' ? 'DESC' : 'ASC' ?>"
                           class="flex items-center hover:text-brand-500 transition-colors whitespace-nowrap"
                           title="Klik untuk mengurutkan">
                            Tanggal Daftar
                            <?php if(($sort ?? 'ASC') == 'ASC'): ?>
                                <i class="fas fa-sort-up ml-1.5 text-brand-500 mt-1"></i>
                            <?php else: ?>
                                <i class="fas fa-sort-down ml-1.5 text-brand-500 mb-1"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($siswa)) : ?>
                    <?php $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>
                    <?php $nomor = 1 + (20 * ($page - 1)); ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3 px-4 text-center text-gray-400 dark:text-gray-500 font-medium"><?= $nomor++ ?></td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="inline-flex rounded-md bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap font-mono text-gray-600 dark:text-gray-400"><?= esc($s['nisn'] ?? '-') ?></td>
                            <td class="py-3 px-4 font-semibold text-gray-900 dark:text-gray-100"><?= esc($s['nama_lengkap']) ?></td>
                            <td class="py-3 px-4">
                                <?= $s['jk'] == 'L'
                                    ? '<span class="inline-flex items-center gap-1 font-semibold text-blue-600 dark:text-blue-400"><i class="fas fa-mars text-xs"></i> L</span>'
                                    : '<span class="inline-flex items-center gap-1 font-semibold text-pink-600 dark:text-pink-400"><i class="fas fa-venus text-xs"></i> P</span>' ?>
                            </td>
                            <td class="py-3 px-4 min-w-[140px]">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                                        <div class="<?= $s['kelengkapan'] == 100 ? 'bg-emerald-500' : ($s['kelengkapan'] >= 50 ? 'bg-brand-500' : 'bg-red-500') ?> h-2 rounded-full transition-all"
                                             style="width: <?= esc($s['kelengkapan']) ?>%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400"><?= esc($s['kelengkapan']) ?>%</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] == 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        <i class="fas fa-check-circle text-[10px]"></i> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] == 'Ditolak') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                        <i class="fas fa-times-circle text-[10px]"></i> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                        <i class="fas fa-clock text-[10px]"></i> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-500 dark:text-gray-400 text-[11px]">
                                <?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="<?= base_url('admin/siswa/detail/' . $s['id_siswa']) ?>"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors dark:text-gray-400 dark:hover:bg-blue-500/15 dark:hover:text-blue-400"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="<?= base_url('admin/siswa/cetak/' . $s['id_siswa']) ?>" target="_blank"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors dark:text-gray-400 dark:hover:bg-emerald-500/15 dark:hover:text-emerald-400"
                                        title="Cetak Formulir">
                                        <i class="fas fa-print text-xs"></i>
                                    </a>
                                    <a href="<?= base_url('admin/siswa/cetak-kartu/' . $s['id_siswa']) ?>" target="_blank"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-purple-50 hover:text-purple-600 transition-colors dark:text-gray-400 dark:hover:bg-purple-500/15 dark:hover:text-purple-400"
                                        title="Cetak Kartu">
                                        <i class="fas fa-id-card text-xs"></i>
                                    </a>
                                    <button type="button"
                                        onclick="openResetPasswordModal('<?= $s['id_siswa'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600 transition-colors dark:text-gray-400 dark:hover:bg-amber-500/15 dark:hover:text-amber-400 focus:outline-none"
                                        title="Reset Password">
                                        <i class="fas fa-key text-xs"></i>
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal('<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= base_url('admin/siswa/delete/' . $s['id_siswa']) ?>')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors dark:text-gray-400 dark:hover:bg-red-500/15 dark:hover:text-red-400 focus:outline-none"
                                        title="Hapus Data">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Empty State -->
                    <tr>
                        <td colspan="9" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                <?php if (!empty($search)) : ?>
                                    <i class="fas fa-search-minus text-4xl mb-3 text-gray-300 dark:text-gray-700"></i>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pencarian Tidak Ditemukan</p>
                                    <p class="text-xs mt-0.5">Tidak ada siswa dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('admin/siswa') ?>" class="mt-3 text-xs font-semibold text-brand-500 hover:underline">Clear Pencarian</a>
                                <?php else : ?>
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300 dark:text-gray-700"></i>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Data</p>
                                    <p class="text-xs mt-0.5">Belum ada calon siswa yang mendaftar saat ini.</p>
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
        <div class="border-t border-gray-100 px-5 py-3.5 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex flex-col sm:flex-row justify-between items-center gap-3">
            <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data calon peserta didik.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="deleteModalContent">
            <div class="border-b border-red-100 bg-red-50/60 px-6 py-5 dark:border-red-950 dark:bg-red-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-red-900 dark:text-red-300">Konfirmasi Hapus Data</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                </div>
            </div>

            <form method="post" id="deleteForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Anda akan menghapus seluruh data pendaftaran milik:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="deleteStudentName"></p>

                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-3 mb-4 dark:border-amber-900/50 dark:bg-amber-950/40">
                        <p class="text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Ketik kata <strong class="text-red-600 uppercase">hapus</strong> untuk mengonfirmasi:</span>
                        </p>
                    </div>

                    <input type="text" id="deleteConfirmInput" name="delete_confirm"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-center text-sm font-semibold focus:border-red-500 focus:outline-none dark:border-gray-800 dark:text-white"
                        placeholder="Ketik 'hapus' di sini"
                        autocomplete="off">
                    <p class="text-[11px] text-gray-500 mt-2 text-center" id="deleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="deleteConfirmBtn" disabled
                        class="rounded-xl bg-red-400 px-4 py-2 text-xs font-semibold text-white transition-all cursor-not-allowed opacity-60 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeResetPasswordModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="resetPasswordModalContent">
            <div class="border-b border-amber-100 bg-amber-50/60 px-6 py-5 dark:border-amber-950 dark:bg-amber-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400">
                        <i class="fas fa-key text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Reset Password Siswa</h3>
                        <p class="text-xs text-amber-600 dark:text-amber-400">Buat password baru dan cetak resi PDF</p>
                    </div>
                </div>
            </div>
            <form method="post" id="resetPasswordForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Reset password untuk calon siswa:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="resetStudentName"></p>

                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" id="newPasswordInput" name="new_password" required
                            class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm font-semibold focus:border-amber-500 focus:outline-none dark:border-gray-800 dark:text-white"
                            placeholder="Ketik password atau klik acak">
                        <button type="button" onclick="generateRandomPassword()"
                            class="shrink-0 rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                            <i class="fas fa-random mr-1"></i> Acak
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">File PDF resi login akan terunduh otomatis setelah Anda menyimpannya.</p>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeResetPasswordModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all flex items-center gap-2 shadow-theme-xs">
                        <i class="fas fa-save"></i> Simpan & Download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(name, url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteStudentName').textContent = name;
        document.getElementById('deleteConfirmInput').value = '';
        document.getElementById('deleteHint').textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
        document.getElementById('deleteHint').className = 'text-[11px] text-gray-500 mt-2 text-center';
        resetDeleteBtn();

        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

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
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    document.getElementById('deleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('deleteHint');

        if (value === 'hapus') {
            enableDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-[11px] text-emerald-600 mt-2 text-center font-medium';
        } else {
            resetDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-[11px] text-red-500 mt-2 text-center';
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-[11px] text-gray-500 mt-2 text-center';
            }
        }
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        const input = document.getElementById('deleteConfirmInput');
        if (input.value.trim().toLowerCase() !== 'hapus') {
            e.preventDefault();
            return false;
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
            closeResetPasswordModal();
        }
    });

    function openResetPasswordModal(id, name) {
        document.getElementById('resetPasswordForm').action = '<?= base_url('admin/siswa/resetPassword') ?>/' + id;
        document.getElementById('resetStudentName').textContent = name;
        document.getElementById('newPasswordInput').value = '';

        const modal = document.getElementById('resetPasswordModal');
        const content = document.getElementById('resetPasswordModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeResetPasswordModal() {
        const content = document.getElementById('resetPasswordModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('resetPasswordModal').classList.add('hidden');
        }, 200);
    }

    function generateRandomPassword() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let pass = '';
        for (let i = 0; i < 6; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('newPasswordInput').value = pass;
    }
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
        background-color: #465fff; /* brand-500 */
        border-color: #465fff;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>

<?= $this->endSection() ?>