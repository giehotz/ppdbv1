<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3 text-blue-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Total Pendaftar</p>
                <div class="text-2xl font-bold text-gray-800"><?= $totalPendaftar ?></div>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-100 rounded-full p-3 text-green-500">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Terverifikasi</p>
                <div class="text-2xl font-bold text-gray-800"><?= $terverifikasi ?></div>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3 text-yellow-500">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Pending</p>
                <div class="text-2xl font-bold text-gray-800"><?= $pending ?></div>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-lg shadow p-5 border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-red-100 rounded-full p-3 text-red-500">
                <i class="fas fa-times-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Siswa Tidak Lulus</p>
                <div class="text-2xl font-bold text-gray-800"><?= $tidakLulus ?></div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Pendaftar Terbaru -->
    <div class="bg-white rounded-lg shadow h-full flex flex-col">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pendaftar Terbaru</h3>
            <a href="<?= base_url('admin/siswa') ?>" class="text-sm text-green-600 hover:text-green-800 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">No. Daftar</th>
                        <th class="py-3 px-6">Nama Siswa</th>
                        <th class="py-3 px-6">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if (!empty($recentStudents)) : ?>
                        <?php foreach ($recentStudents as $s) : ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 whitespace-nowrap"><span class="font-medium"><?= $s['no_pendaftaran'] ?></span></td>
                                <td class="py-3 px-6"><?= $s['nama_lengkap'] ?></td>
                                <td class="py-3 px-6"><?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center text-gray-500">Belum ada data pendaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Aktivitas User (Login Logs) -->
    <div class="bg-white rounded-lg shadow h-full flex flex-col">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Aktivitas Login Terbaru</h3>
            <a href="<?= base_url('admin/users') ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Pengguna</a>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                        <th class="py-3 px-6">User</th>
                        <th class="py-3 px-6">Level</th>
                        <th class="py-3 px-6">Activity (Terakhir Login)</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if (!empty($activeUsers)) : ?>
                        <?php foreach ($activeUsers as $u) : ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=<?= urlencode($u['nama_lengkap']) ?>&background=random" alt="<?= $u['nama_lengkap'] ?>" />
                                        </div>
                                        <span class="font-medium"><?= $u['nama_lengkap'] ?></span>
                                    </div>
                                </td>
                                <td class="py-3 px-6">
                                    <?php if ($u['level'] === 'admin'): ?>
                                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-semibold">Admin</span>
                                    <?php elseif ($u['level'] === 'siswa'): ?>
                                        <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-semibold">Siswa</span>
                                    <?php else: ?>
                                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold">Verifikator</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center text-gray-500">
                                        <i class="far fa-clock mr-2"></i>
                                        <?= date('d M Y, H:i', strtotime($u['last_login'])) ?> WIB
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="py-4 px-6 text-center text-gray-500">Belum ada aktivitas login terekam.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>