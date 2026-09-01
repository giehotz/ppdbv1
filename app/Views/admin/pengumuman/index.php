<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Pengumuman
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">campaign</span> Manajemen Pengumuman
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalAll       = $totalAll ?? count($pengumuman);
$generalCount   = $totalGeneral ?? 0;
$ujianCount     = $totalUjian ?? 0;
$kelulusanCount = $totalKelulusan ?? 0;
?>

<!-- 4 Key Stat Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6 mb-6">
    <!-- Card 1: Total Pengumuman -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                <span class="material-symbols-outlined text-2xl">campaign</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/50 dark:border-brand-500/20">
                Semua
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Pengumuman</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($totalAll) ?></h4>
            </div>
        </div>
    </div>

    <!-- Card 2: General -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">public</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
                Umum
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kategori General</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($generalCount) ?></h4>
            </div>
        </div>
    </div>

    <!-- Card 3: Ujian -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                <span class="material-symbols-outlined text-2xl">edit_note</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-semibold text-purple-600 dark:bg-purple-500/15 dark:text-purple-400 border border-purple-200/50 dark:border-purple-500/20">
                Ujian
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kategori Ujian</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($ujianCount) ?></h4>
            </div>
        </div>
    </div>

    <!-- Card 4: Kelulusan -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
        <div class="flex items-center justify-between">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <span class="flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                Kelulusan
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Kategori Kelulusan</span>
                <h4 class="mt-1 text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white"><?= number_format($kelulusanCount) ?></h4>
            </div>
        </div>
    </div>
</div>

<!-- Action & Search Bar Header -->
<div class="mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pengumuman</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola pengumuman, popup modal informasi, dan lampiran berkas untuk calon peserta didik</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5 self-stretch md:self-auto">
        <form action="<?= base_url('admin/pengumuman') ?>" method="get" class="flex items-center gap-2 flex-1 sm:flex-none">
            <div class="relative w-full sm:w-60">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari pengumuman..."
                       class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 dark:text-white pl-10 pr-4 py-2.5 text-xs shadow-theme-xs outline-none focus:border-brand-300 focus:ring-brand-500">
            </div>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('admin/pengumuman') ?>" class="flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-500 hover:text-gray-700 transition" title="Reset Pencarian">
                    <span class="material-symbols-outlined text-base">close</span>
                </a>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('admin/pengumuman/create') ?>"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">add</span>
            <span>Tambah Pengumuman</span>
        </a>
    </div>
</div>

<!-- Main Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3.5 px-4">Judul Pengumuman</th>
                    <th class="py-3.5 px-4">Kategori / Tipe</th>
                    <th class="py-3.5 px-4">Target Sasaran</th>
                    <th class="py-3.5 px-4">Waktu Publish</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (!empty($pengumuman)): ?>
                    <?php foreach ($pengumuman as $p): ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-4 max-w-sm">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400">
                                        <span class="material-symbols-outlined text-lg">article</span>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-bold text-gray-900 dark:text-white block truncate"><?= esc($p['judul']) ?></span>
                                        <span class="block text-[11px] text-gray-400 dark:text-gray-500 truncate">
                                            <?= substr(strip_tags($p['isi_pengumuman']), 0, 80) ?>...
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <?php
                                $tipeClass = 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border-blue-200/50 dark:border-blue-500/20';
                                if ($p['tipe'] === 'ujian') {
                                    $tipeClass = 'bg-purple-50 text-purple-700 dark:bg-purple-500/15 dark:text-purple-400 border-purple-200/50 dark:border-purple-500/20';
                                } elseif ($p['tipe'] === 'kelulusan') {
                                    $tipeClass = 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border-emerald-200/50 dark:border-emerald-500/20';
                                }
                                ?>
                                <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold border <?= $tipeClass ?>">
                                    <?= ucfirst(esc($p['tipe'])) ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <?php
                                $audienceLabels = [
                                    'all'      => 'Semua Siswa',
                                    'verified' => 'Terverifikasi',
                                    'lulus'    => 'Lulus',
                                    'rejected' => 'Ditolak'
                                ];
                                ?>
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 px-2.5 py-0.5 text-xs font-semibold">
                                    <span class="material-symbols-outlined text-xs">group</span>
                                    <?= $audienceLabels[$p['target_audience']] ?? ucfirst(esc($p['target_audience'])) ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 font-mono">
                                <?= $p['publish_date'] ? date('d/m/Y H:i', strtotime($p['publish_date'])) : '<span class="text-gray-400">&mdash;</span>' ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <?php if ($p['is_active']): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Toggle Status -->
                                    <form method="post" action="<?= base_url('admin/pengumuman/toggleStatus/' . $p['id_pengumuman']) ?>" class="inline" onsubmit="return confirm('Ubah status keaktifan pengumuman ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                                                title="<?= $p['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <span class="material-symbols-outlined text-base">power_settings_new</span>
                                        </button>
                                    </form>

                                    <!-- Edit -->
                                    <a href="<?= base_url('admin/pengumuman/edit/' . $p['id_pengumuman']) ?>"
                                       class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-500/15 dark:text-amber-400 dark:hover:bg-amber-500/25 transition"
                                       title="Edit Pengumuman">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </a>

                                    <!-- Delete -->
                                    <form method="post" action="<?= base_url('admin/pengumuman/delete/' . $p['id_pengumuman']) ?>" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini secara permanen?')">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 transition"
                                                title="Hapus">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2">campaign</span>
                            <p class="text-xs"><?= !empty($search) ? 'Tidak ada hasil pencarian.' : 'Belum ada data pengumuman.' ?></p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($pengumuman) && isset($pager)): ?>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex justify-center">
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
        padding: 0.35rem 0.75rem; font-size: 0.75rem; font-weight: 600;
        border-radius: 0.5rem; background: #fff; border: 1px solid #e5e7eb;
        color: #4b5563; transition: all 0.2s;
    }
    .dark .pagination-wrapper ul.pagination li a,
    .dark .pagination-wrapper ul.pagination li span {
        background: #1f2937; border-color: #374151; color: #d1d5db;
    }
    .pagination-wrapper ul.pagination li.active span {
        background: #465fff !important; border-color: #465fff !important; color: #fff !important;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background: #f3f4f6; color: #111827;
    }
</style>

<?= $this->endSection() ?>
