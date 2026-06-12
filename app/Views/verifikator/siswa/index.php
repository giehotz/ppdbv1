<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center" role="alert">
        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
        <span class="block sm:inline font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center" role="alert">
        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
        <span class="block sm:inline font-medium"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header Section -->
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Daftar Calon Siswa</h3>
                <p class="text-sm text-gray-500 mt-1">Verifikasi pendaftaran dan berkas siswa.</p>
            </div>

            <div class="flex flex-col sm:flex-row w-full lg:w-auto gap-3">
                <form action="<?= base_url('verifikator/siswa') ?>" method="get" class="flex w-full sm:w-auto">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors shadow-sm">
                    </div>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 border border-gray-800 transition duration-200 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                        Cari
                    </button>
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('verifikator/siswa') ?>" class="bg-red-50 hover:bg-red-100 text-red-600 border border-l-0 border-red-200 font-medium py-2 px-4 rounded-r-lg transition duration-200 flex items-center" title="Reset Pencarian">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs tracking-wider">
                    <th class="py-4 px-6 font-semibold">No. Pendaftaran</th>
                    <th class="py-4 px-6 font-semibold">NISN</th>
                    <th class="py-4 px-6 font-semibold">Nama Lengkap</th>
                    <th class="py-4 px-6 font-semibold text-center">Gender</th>
                    <th class="py-4 px-6 font-semibold">Kelengkapan</th>
                    <th class="py-4 px-6 font-semibold">Status Validasi</th>
                    <th class="py-4 px-6 font-semibold">Tanggal Daftar</th>
                    <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/80 transition-colors">
                            <td class="py-3 px-6 whitespace-nowrap font-bold text-gray-800">
                                <span class="bg-gray-100 text-gray-700 py-1 px-2 rounded text-xs"><?= esc($s['no_pendaftaran']) ?></span>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap"><?= esc($s['nisn'] ?? '-') ?></td>
                            <td class="py-3 px-6 font-medium text-gray-900"><?= esc($s['nama_lengkap']) ?></td>
                            <td class="py-3 px-6 text-center">
                                <?= $s['jk'] == 'L' ? '<span class="text-blue-600" title="Laki-laki"><i class="fas fa-mars"></i> L</span>' : '<span class="text-pink-600" title="Perempuan"><i class="fas fa-venus"></i> P</span>' ?>
                            </td>
                            <td class="py-3 px-6 min-w-[150px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="<?= $s['kelengkapan'] == 100 ? 'bg-emerald-500' : ($s['kelengkapan'] >= 50 ? 'bg-blue-500' : 'bg-red-500') ?> h-2.5 rounded-full" style="width: <?= esc($s['kelengkapan']) ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 font-bold"><?= esc($s['kelengkapan']) ?>%</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] == 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold border border-emerald-200">
                                        <i class="fas fa-check-circle mr-1.5"></i> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] == 'Ditolak') : ?>
                                    <span class="inline-flex items-center bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold border border-red-200">
                                        <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-bold border border-amber-200">
                                        <i class="fas fa-hourglass-half mr-1.5"></i> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap text-gray-500">
                                <?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="<?= base_url('verifikator/siswa/detail/' . $s['id_siswa']) ?>"
                                        class="text-blue-500 hover:text-blue-700 transform hover:scale-110 transition-transform"
                                        title="Periksa / Verifikasi">
                                        <i class="fas fa-file-signature text-lg"></i>
                                    </a>
                                    <a href="<?= base_url('verifikator/siswa/cetak/' . $s['id_siswa']) ?>" target="_blank"
                                        class="text-emerald-500 hover:text-emerald-700 transform hover:scale-110 transition-transform"
                                        title="Cetak Formulir">
                                        <i class="fas fa-print text-lg"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Empty State -->
                    <tr>
                        <td colspan="8" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <?php if (!empty($search)) : ?>
                                    <i class="fas fa-search-minus text-5xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-600 mb-1">Pencarian Tidak Ditemukan</p>
                                    <p class="text-sm">Tidak ada siswa dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('verifikator/siswa') ?>" class="mt-4 text-emerald-600 hover:underline text-sm font-medium">Clear Pencarian</a>
                                <?php else : ?>
                                    <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium text-gray-600 mb-1">Belum Ada Data</p>
                                    <p class="text-sm">Belum ada calon siswa yang mendaftar saat ini.</p>
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
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-sm text-gray-500">Menampilkan data calon siswa.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Styling tambahan untuk pagination bawaan CI4 agar cocok dengan desain Tailwind */
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
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.2s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background-color: #059669; /* emerald-600 */
        border-color: #059669;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>

<?= $this->endSection() ?>