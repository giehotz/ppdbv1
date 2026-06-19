<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Pengguna<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Manajemen Pengguna<?= $this->endSection() ?>

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
$totalUsers   = count($users);
$adminCount   = count(array_filter($users, fn($u) => $u['level'] === 'admin'));
$verifikatorCount = count(array_filter($users, fn($u) => $u['level'] === 'verifikator'));
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
            <i class="fas fa-users text-green-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pengguna</p>
            <p class="text-2xl font-bold text-gray-800"><?= $totalUsers ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
            <i class="fas fa-user-shield text-blue-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Admin</p>
            <p class="text-2xl font-bold text-gray-800"><?= $adminCount ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
            <i class="fas fa-user-check text-purple-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Verifikator</p>
            <p class="text-2xl font-bold text-gray-800"><?= $verifikatorCount ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengguna</h3>
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Cari pengguna..."
                    class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none w-full sm:w-56">
            </div>
            <a href="<?= base_url('admin/users/create') ?>"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center gap-2 shrink-0">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left" id="usersTable">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="py-4 px-6">User</th>
                    <th class="py-4 px-6">Username</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Level</th>
                    <th class="py-4 px-6">Tanggal Daftar</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) :
                        $avatarChar = strtoupper(substr($user['nama_lengkap'], 0, 1));
                    ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        <?= $avatarChar ?>
                                    </div>
                                    <div class="font-medium text-gray-800"><?= esc($user['nama_lengkap']) ?></div>
                                </div>
                            </td>
                            <td class="py-4 px-6"><?= esc($user['username']) ?></td>
                            <td class="py-4 px-6"><?= esc($user['email']) ?: '<span class="text-gray-400">—</span>' ?></td>
                            <td class="py-4 px-6">
                                <?php if ($user['level'] === 'admin') : ?>
                                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-shield-alt text-xs"></i> Admin
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-check-circle text-xs"></i> Verifikator
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-gray-500"><?= date('d M Y', strtotime($user['tgl_daftar'])) ?></td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 flex items-center justify-center transition-colors duration-150"
                                        title="Edit User">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <?php if ($user['level'] != 'admin') : ?>
                                        <form method="post" action="<?= base_url('admin/users/delete/' . $user['id_user']) ?>"
                                            data-confirm="Yakin ingin menghapus user ini?"
                                            style="display:inline">
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 flex items-center justify-center transition-colors duration-150"
                                                title="Hapus User">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <span class="w-8 h-8 rounded-lg bg-gray-100 text-gray-300 flex items-center justify-center cursor-not-allowed" title="Admin tidak dapat dihapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i class="fas fa-users text-4xl"></i>
                                <p class="text-sm">Belum ada data pengguna.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#usersTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
