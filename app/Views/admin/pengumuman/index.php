<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Pengumuman<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Manajemen Pengumuman<?= $this->endSection() ?>

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
$totalAll       = $totalAll ?? count($pengumuman);
$generalCount   = $totalGeneral ?? 0;
$ujianCount     = $totalUjian ?? 0;
$kelulusanCount = $totalKelulusan ?? 0;
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
            <i class="fas fa-bullhorn text-gray-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pengumuman</p>
            <p class="text-2xl font-bold text-gray-800"><?= $totalAll ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
            <i class="fas fa-globe text-blue-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">General</p>
            <p class="text-2xl font-bold text-gray-800"><?= $generalCount ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center shrink-0">
            <i class="fas fa-pencil-alt text-purple-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Ujian</p>
            <p class="text-2xl font-bold text-gray-800"><?= $ujianCount ?></p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
            <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Kelulusan</p>
            <p class="text-2xl font-bold text-gray-800"><?= $kelulusanCount ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pengumuman</h3>
            <form action="<?= base_url('admin/pengumuman') ?>" method="get" class="flex gap-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                        placeholder="Cari judul atau isi..."
                        class="pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none w-full sm:w-56">
                </div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-150">
                    <i class="fas fa-search"></i>
                </button>
                <?php if (!empty($search)) : ?>
                    <a href="<?= base_url('admin/pengumuman') ?>" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-150">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('admin/pengumuman/create') ?>"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition duration-150 inline-flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                    <th class="py-4 px-6">Judul</th>
                    <th class="py-4 px-6">Tipe</th>
                    <th class="py-4 px-6">Target</th>
                    <th class="py-4 px-6">Tanggal Publish</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                <?php if (!empty($pengumuman)) : ?>
                    <?php foreach ($pengumuman as $p) : ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-400 to-cyan-600 flex items-center justify-center text-white shrink-0">
                                        <i class="fas fa-file-alt text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-medium text-gray-800"><?= esc($p['judul']) ?></span>
                                        <span class="block text-xs text-gray-400 truncate max-w-xs">
                                            <?= substr(strip_tags($p['isi_pengumuman']), 0, 100) ?>...
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <?php
                                $tipeColors = [
                                    'general'   => 'bg-blue-100 text-blue-700',
                                    'ujian'     => 'bg-purple-100 text-purple-700',
                                    'kelulusan' => 'bg-green-100 text-green-700',
                                ];
                                $tipeIcons = [
                                    'general'   => 'fa-globe',
                                    'ujian'     => 'fa-pencil-alt',
                                    'kelulusan' => 'fa-graduation-cap',
                                ];
                                $tc = $tipeColors[$p['tipe']] ?? 'bg-gray-100 text-gray-700';
                                $ti = $tipeIcons[$p['tipe']] ?? 'fa-tag';
                                ?>
                                <span class="inline-flex items-center gap-1 <?= $tc ?> text-xs font-medium px-3 py-1 rounded-full">
                                    <i class="fas <?= $ti ?> text-xs"></i> <?= ucfirst(esc($p['tipe'])) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                                    <?php
                                    $audienceLabels = ['all' => 'Semua', 'verified' => 'Terverifikasi', 'lulus' => 'Lulus', 'rejected' => 'Ditolak'];
                                    ?>
                                    <?= $audienceLabels[$p['target_audience']] ?? ucfirst(esc($p['target_audience'])) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-500">
                                <?= $p['publish_date'] ? date('d M Y H:i', strtotime($p['publish_date'])) : '<span class="text-gray-400">—</span>' ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <?php if ($p['is_active']) : ?>
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-check-circle text-xs"></i> Aktif
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-medium px-3 py-1 rounded-full">
                                        <i class="fas fa-times-circle text-xs"></i> Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form method="post" action="<?= base_url('admin/pengumuman/toggleStatus/' . $p['id_pengumuman']) ?>"
                                        data-confirm="Ubah status pengumuman ini?"
                                        style="display:inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-700 flex items-center justify-center transition-colors duration-150"
                                            title="<?= $p['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <i class="fas fa-power-off text-xs"></i>
                                        </button>
                                    </form>
                                    <a href="<?= base_url('admin/pengumuman/edit/' . $p['id_pengumuman']) ?>"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 flex items-center justify-center transition-colors duration-150"
                                        title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form method="post" action="<?= base_url('admin/pengumuman/delete/' . $p['id_pengumuman']) ?>"
                                        data-confirm="Yakin ingin menghapus pengumuman ini?"
                                        style="display:inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 flex items-center justify-center transition-colors duration-150"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <i class="fas fa-bullhorn text-4xl"></i>
                                <p class="text-sm"><?= !empty($search) ? 'Tidak ada hasil pencarian.' : 'Belum ada data pengumuman.' ?></p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pengumuman)) : ?>
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-center">
        <div class="pagination-wrapper"><?= $pager->links() ?></div>
    </div>
    <?php endif; ?>
</div>

<style>
    .pagination-wrapper ul.pagination {
        display: flex; list-style: none; padding: 0; margin: 0; gap: 0.25rem;
    }
    .pagination-wrapper ul.pagination li a,
    .pagination-wrapper ul.pagination li span {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: 500;
        border-radius: 0.5rem; background: #fff; border: 1px solid #e5e7eb;
        color: #4b5563; transition: all 0.2s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background: #059669; border-color: #059669; color: #fff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background: #f3f4f6; color: #111827;
    }
</style>

<?= $this->endSection() ?>
