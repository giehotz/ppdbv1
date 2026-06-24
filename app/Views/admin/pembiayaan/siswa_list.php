<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Data Pembiayaan Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Data Pembiayaan Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center">
        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center">
        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
        <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Daftar Siswa & Status Pembayaran</h3>
                <p class="text-sm text-gray-500 mt-1">Centang item yang sudah dibayar, lalu simpan.</p>
            </div>
            <a href="<?= base_url('admin/pembiayaan') ?>" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
                <i class="fas fa-cog mr-2"></i> Kelola Item
            </a>
        </div>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No. Daftar</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Total Tagihan</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Sudah Dibayar</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($siswaList)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-2 block"></i>
                                Belum ada data siswa.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($siswaList as $s): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-700"><?= $no++ ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700"><?= esc($s['no_pendaftaran']) ?></td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900"><?= esc($s['nama_lengkap']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700 text-right"><?= format_rupiah($s['totalTagihan']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700 text-right"><?= format_rupiah($s['totalLunas']) ?></td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <?php if ($s['statusLunas']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Lunas
                                        </span>
                                    <?php elseif ($s['totalTagihan'] > 0): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <i class="fas fa-clock mr-1"></i> Belum Lunas
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class="fas fa-minus-circle mr-1"></i> Belum Ada Tagihan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <a href="<?= base_url('admin/pembiayaan/siswa/' . $s['id_siswa']) ?>" class="text-blue-600 hover:text-blue-800 transition" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
