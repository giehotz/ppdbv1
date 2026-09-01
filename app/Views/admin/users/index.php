<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Pengguna<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Manajemen Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalUsers       = count($users);
$adminCount       = count(array_filter($users, fn($u) => $u['level'] === 'admin'));
$verifikatorCount = count(array_filter($users, fn($u) => $u['level'] === 'verifikator'));
?>

<!-- Metric Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                <i class="fas fa-users text-lg"></i>
            </div>
            <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                Semua User
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pengguna</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= $totalUsers ?></h4>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <i class="fas fa-user-shield text-lg"></i>
            </div>
            <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                Administrator
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Admin</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= $adminCount ?></h4>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                <i class="fas fa-user-check text-lg"></i>
            </div>
            <span class="rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-semibold text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                Staf Verifikator
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Verifikator</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= $verifikatorCount ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Pengguna Sistem</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola akun administrator dan staf verifikator.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Cari pengguna..."
                        class="h-9 w-full rounded-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 dark:placeholder:text-gray-500 sm:w-56">
                </div>
                <a href="<?= base_url('admin/users/create') ?>"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-colors hover:bg-brand-600 shrink-0">
                    <i class="fas fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left" id="usersTable">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-5">User</th>
                    <th class="py-3.5 px-4">Username</th>
                    <th class="py-3.5 px-4">Email</th>
                    <th class="py-3.5 px-4">Level</th>
                    <th class="py-3.5 px-4">Tanggal Daftar</th>
                    <th class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) :
                        $avatarChar = strtoupper(substr($user['nama_lengkap'], 0, 1));
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 font-bold text-xs dark:bg-brand-500/15 dark:text-brand-400">
                                        <?= $avatarChar ?>
                                    </div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100"><?= esc($user['nama_lengkap']) ?></div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-gray-700 dark:text-gray-300"><?= esc($user['username']) ?></td>
                            <td class="py-3.5 px-4 text-gray-500 dark:text-gray-400"><?= esc($user['email']) ?: '<span class="text-gray-400">—</span>' ?></td>
                            <td class="py-3.5 px-4">
                                <?php if ($user['level'] === 'admin') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                        <i class="fas fa-shield-alt text-[10px]"></i> Admin
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-purple-50 px-2.5 py-0.5 text-[11px] font-semibold text-purple-700 dark:bg-purple-500/15 dark:text-purple-400">
                                        <i class="fas fa-check-circle text-[10px]"></i> Verifikator
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-gray-500 dark:text-gray-400 text-[11px]"><?= date('d M Y', strtotime($user['tgl_daftar'])) ?></td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600 transition-colors dark:text-gray-400 dark:hover:bg-amber-500/15 dark:hover:text-amber-400"
                                        title="Edit User">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <?php if ($user['level'] != 'admin') : ?>
                                        <form method="post" action="<?= base_url('admin/users/delete/' . $user['id_user']) ?>"
                                            data-confirm="Yakin ingin menghapus user ini?"
                                            style="display:inline">
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors dark:text-gray-400 dark:hover:bg-red-500/15 dark:hover:text-red-400"
                                                title="Hapus User">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-300 dark:text-gray-600 cursor-not-allowed" title="Admin tidak dapat dihapus">
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
                            <div class="flex flex-col items-center gap-2 text-gray-400 dark:text-gray-500">
                                <i class="fas fa-users text-4xl text-gray-300 dark:text-gray-700"></i>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada data pengguna.</p>
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
