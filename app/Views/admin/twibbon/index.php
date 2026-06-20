<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Kampanye Twibbon</h2>
            <p class="text-sm text-gray-500">Kelola bingkai promosi dan lihat statistik penggunaannya.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('admin/twibbon/setting') ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2 text-sm">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
            <a href="<?= base_url('admin/twibbon/create') ?>" class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Kampanye
            </a>
        </div>
    </div>

    <!-- Alert Success / Error -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bingkai</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kampanye</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unduhan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($campaigns)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada kampanye twibbon yang dibuat.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($campaigns as $c): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($c['frame']['file_path'])): ?>
                                    <img src="<?= base_url($c['frame']['file_path']) ?>" alt="Frame" class="w-16 h-16 object-cover border rounded shadow-sm hover:scale-105 transition-transform duration-200">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-gray-100 border rounded flex items-center justify-center text-gray-400">
                                        <i class="far fa-image text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900"><?= esc($c['title']) ?></div>
                                <div class="text-xs text-gray-500 mt-1 max-w-xs truncate"><?= strip_tags($c['description'] ?: 'Tidak ada deskripsi') ?></div>
                                <div class="text-xs text-green-600 mt-1">
                                    <a href="<?= base_url('twibbon/' . $c['slug']) ?>" target="_blank" class="hover:underline flex items-center gap-1">
                                        <i class="fas fa-external-link-alt text-[10px]"></i> Lihat Halaman Publik
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if ($c['start_date'] || $c['end_date']): ?>
                                    <div>Mulai: <?= $c['start_date'] ? date('d M Y', strtotime($c['start_date'])) : '-' ?></div>
                                    <div class="mt-1">Selesai: <?= $c['end_date'] ? date('d M Y', strtotime($c['end_date'])) : '-' ?></div>
                                <?php else: ?>
                                    <span>Selamanya</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $today = date('Y-m-d');
                                $activeDate = true;
                                if ($c['start_date'] && $c['start_date'] > $today) $activeDate = false;
                                if ($c['end_date'] && $c['end_date'] < $today) $activeDate = false;

                                if ($c['is_active'] && $activeDate): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                <?= number_format($c['total_downloads']) ?> kali
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="<?= base_url('admin/twibbon/stats/' . $c['id']) ?>" class="text-blue-600 hover:text-blue-900" title="Statistik">
                                        <i class="fas fa-chart-line text-lg"></i>
                                    </a>
                                    <a href="<?= base_url('admin/twibbon/edit/' . $c['id']) ?>" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>
                                    <form action="<?= base_url('admin/twibbon/delete/' . $c['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kampanye ini?');" class="inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash-alt text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
