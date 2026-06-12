<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Dashboard Verifikator
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard Verifikator
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Welcome Banner -->
<div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-6 text-white border-l-4 border-blue-800">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= session()->get('nama_lengkap') ?>!</h2>
            <p class="text-blue-100">Anda login sebagai Verifikator. Silakan periksa data siswa dan berkas pendaftaran yang masuk.</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-user-check text-5xl opacity-80"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Pendaftar -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pendaftar</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $total_pendaftar ?></h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Menunggu Verifikasi</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $menunggu_verifikasi ?></h3>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Terverifikasi -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Terverifikasi</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $terverifikasi ?></h3>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Ditolak -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Ditolak</p>
                <h3 class="text-2xl font-bold text-gray-800"><?= $ditolak ?></h3>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <i class="fas fa-times-circle text-red-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Pendaftar Terbaru -->
    <div class="bg-white rounded-lg shadow h-full flex flex-col">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pendaftar Terbaru</h3>
            <a href="<?= base_url('verifikator/siswa') ?>" class="text-sm text-green-600 hover:text-green-800 font-medium">Lihat Semua</a>
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

    <!-- Shortcut -->
    <div class="bg-white rounded-lg shadow overflow-hidden h-full">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= base_url('verifikator/siswa') ?>" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 border border-gray-200 hover:border-blue-300 transition-colors">
                    <i class="fas fa-user-check text-3xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Verifikasi Siswa</span>
                </a>
                <a href="<?= base_url('verifikator/berkas') ?>" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 border border-gray-200 hover:border-blue-300 transition-colors">
                    <i class="fas fa-file-signature text-3xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700">Verifikasi Berkas</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>