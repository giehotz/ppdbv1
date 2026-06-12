<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Pengumuman
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Pengumuman
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
            <h3 class="text-lg font-medium text-gray-900">Daftar Pengumuman</h3>

            <div class="flex gap-2">
                <form action="<?= base_url('admin/pengumuman') ?>" method="get" class="flex gap-2">
                    <input type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Cari judul atau isi..."
                        class="border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                        <i class="fas fa-search"></i>
                    </button>
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('admin/pengumuman') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>

                <a href="<?= base_url('admin/pengumuman/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Pengumuman
                </a>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6">Judul</th>
                    <th class="py-3 px-6">Tipe</th>
                    <th class="py-3 px-6">Target</th>
                    <th class="py-3 px-6">Tanggal Publish</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (!empty($pengumuman)) : ?>
                    <?php foreach ($pengumuman as $p) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">
                                <div class="font-semibold"><?= $p['judul'] ?></div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    <?= substr(strip_tags($p['isi_pengumuman']), 0, 100) ?>...
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <?php
                                $badgeColors = [
                                    'general' => 'bg-blue-200 text-blue-700',
                                    'ujian' => 'bg-purple-200 text-purple-700',
                                    'kelulusan' => 'bg-green-200 text-green-700',
                                ];
                                ?>
                                <span class="<?= $badgeColors[$p['tipe']] ?? 'bg-gray-200 text-gray-700' ?> py-1 px-3 rounded-full text-xs">
                                    <?= ucfirst($p['tipe']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">
                                    <?= ucfirst($p['target_audience']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-6">
                                <?= $p['publish_date'] ? date('d/m/Y H:i', strtotime($p['publish_date'])) : '-' ?>
                            </td>
                            <td class="py-3 px-6">
                                <?php if ($p['is_active']) : ?>
                                    <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                <?php else : ?>
                                    <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">
                                        <i class="fas fa-times-circle"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center gap-2">
                                    <a href="<?= base_url('admin/pengumuman/toggleStatus/' . $p['id_pengumuman']) ?>"
                                        class="transform hover:text-yellow-500 hover:scale-110"
                                        title="Toggle Status">
                                        <i class="fas fa-power-off"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pengumuman/edit/' . $p['id_pengumuman']) ?>"
                                        class="transform hover:text-blue-500 hover:scale-110"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pengumuman/delete/' . $p['id_pengumuman']) ?>"
                                        data-confirm="Yakin ingin menghapus pengumuman ini?"
                                        class="transform hover:text-red-500 hover:scale-110"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                            <?= !empty($search) ? 'Tidak ada hasil pencarian.' : 'Belum ada data pengumuman.' ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pengumuman)) : ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>