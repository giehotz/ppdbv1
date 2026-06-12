<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Pengguna
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Pengguna
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
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Daftar Pengguna</h3>
        <a href="<?= base_url('admin/users/create') ?>" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Username</th>
                    <th class="py-3 px-6">Nama Lengkap</th>
                    <th class="py-3 px-6">Email</th>
                    <th class="py-3 px-6">Level</th>
                    <th class="py-3 px-6">Tanggal Daftar</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 whitespace-nowrap"><?= $user['id_user'] ?></td>
                            <td class="py-3 px-6"><?= $user['username'] ?></td>
                            <td class="py-3 px-6"><?= $user['nama_lengkap'] ?></td>
                            <td class="py-3 px-6"><?= $user['email'] ?></td>
                            <td class="py-3 px-6">
                                <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                                    <?= ucfirst($user['level']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-6"><?= date('d/m/Y', strtotime($user['tgl_daftar'])) ?></td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="<?= base_url('admin/users/edit/' . $user['id_user']) ?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($user['level'] != 'admin') : ?>
                                        <a href="<?= base_url('admin/users/delete/' . $user['id_user']) ?>"
                                            data-confirm="Yakin ingin menghapus user ini?"
                                            class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else : ?>
                                        <span class="w-4 mr-2 text-gray-400 cursor-not-allowed" title="Admin tidak dapat dihapus">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-4 px-6 text-center text-gray-500">Belum ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>