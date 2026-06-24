<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Pembiayaan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Status Pembiayaan
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

<!-- Ringkasan Atas -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    <!-- Info Siswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Data Siswa</h3>
        </div>
        <div class="p-5 space-y-3">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">No. Pendaftaran</p>
                <p class="text-gray-900 font-semibold"><?= esc($siswa['no_pendaftaran']) ?></p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Nama Lengkap</p>
                <p class="text-gray-900 font-semibold"><?= esc($siswa['nama_lengkap']) ?></p>
            </div>
        </div>
    </div>

    <!-- Total Tagihan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Tagihan</h3>
        </div>
        <div class="p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Total Tagihan</p>
            <p class="text-2xl font-bold text-gray-800"><?= format_rupiah($totalTagihan) ?></p>
            <p class="text-xs font-semibold text-gray-400 uppercase mt-3 mb-1">Sudah Dibayar</p>
            <p class="text-xl font-bold text-blue-600"><?= format_rupiah($totalLunas) ?></p>
        </div>
    </div>

    <!-- Status -->
    <div class="bg-white rounded-xl shadow-sm border <?= $statusLunas ? 'border-green-200' : 'border-amber-200' ?> overflow-hidden">
        <div class="px-5 py-4 border-b <?= $statusLunas ? 'border-green-100 bg-green-50/50' : 'border-amber-100 bg-amber-50/50' ?>">
            <h3 class="text-sm font-bold <?= $statusLunas ? 'text-green-800' : 'text-amber-800' ?> uppercase tracking-wide">Status Pembayaran</h3>
        </div>
        <div class="p-5 text-center">
            <?php if ($statusLunas): ?>
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-3">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
                <p class="text-xl font-bold text-green-600">LUNAS</p>
                <p class="text-xs text-green-500 mt-1">Semua tagihan sudah terbayar</p>
            <?php else: ?>
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-3">
                    <i class="fas fa-clock text-3xl text-amber-500"></i>
                </div>
                <p class="text-xl font-bold text-amber-600">BELUM LUNAS</p>
                <p class="text-xs text-amber-500 mt-1">Sisa <?= count($unpaidItems) ?> item belum dibayar</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Rincian Tagihan -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Rincian Tagihan</h3>
    </div>
    <div class="p-0">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Item</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($tagihan)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3 block"></i>
                                <p class="text-gray-500 font-medium">Belum ada tagihan</p>
                                <p class="text-xs text-gray-400 mt-1">Tagihan akan muncul setelah admin/verifikator menambahkan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($tagihan as $t): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500"><?= $no++ ?></td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900"><?= esc($t['nama_item']) ?></p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 text-right font-medium"><?= format_rupiah($t['harga_satuan']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($t['status_bayar'] === 'lunas'): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <i class="fas fa-check-circle mr-1.5"></i> Lunas
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                            <i class="fas fa-clock mr-1.5"></i> Belum
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($tagihan)): ?>
                <tfoot>
                    <tr class="bg-gray-50 border-t-2 border-gray-200">
                        <td colspan="2" class="px-6 py-4 text-sm font-bold text-gray-700 text-right">Total Tagihan</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right"><?= format_rupiah($totalTagihan) ?></td>
                        <td></td>
                    </tr>
                    <tr class="bg-green-50/50">
                        <td colspan="2" class="px-6 py-4 text-sm font-bold text-green-700 text-right">Sudah Dibayar</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-700 text-right"><?= format_rupiah($totalLunas) ?></td>
                        <td></td>
                    </tr>
                    <tr class="bg-<?= $statusLunas ? 'green' : 'amber' ?>-50/50 border-t-2 border-<?= $statusLunas ? 'green' : 'amber' ?>-200">
                        <td colspan="2" class="px-6 py-4 text-sm font-bold text-<?= $statusLunas ? 'green' : 'amber' ?>-700 text-right">Sisa Tagihan</td>
                        <td class="px-6 py-4 text-sm font-bold text-<?= $statusLunas ? 'green' : 'amber' ?>-700 text-right"><?= format_rupiah(max(0, $totalTagihan - $totalLunas)) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<!-- Kuitansi & Riwayat -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Riwayat Pembayaran -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Riwayat Pembayaran</h3>
            </div>
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Metode</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($riwayatBayar)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center">
                                        <i class="fas fa-receipt text-3xl text-gray-300 mb-2 block"></i>
                                        <p class="text-gray-500 text-sm">Belum ada riwayat pembayaran</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($riwayatBayar as $bayar): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm text-gray-500"><?= $no++ ?></td>
                                        <td class="px-6 py-3 text-sm text-gray-700"><?= date('d/m/Y', strtotime($bayar['tanggal'])) ?></td>
                                        <td class="px-6 py-3 text-sm text-green-600 font-semibold text-right"><?= format_rupiah($bayar['jumlah']) ?></td>
                                        <td class="px-6 py-3 text-sm text-gray-600"><?= esc($bayar['metode'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kuitansi -->
    <div>
        <?php if ($statusLunas): ?>
            <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-green-100 bg-green-50/50">
                    <h3 class="text-sm font-bold text-green-800 uppercase tracking-wide">Kuitansi</h3>
                </div>
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                        <i class="fas fa-file-pdf text-3xl text-green-600"></i>
                    </div>
                    <h4 class="text-lg font-bold text-green-800 mb-2">Pembayaran Lunas!</h4>
                    <p class="text-sm text-green-600 mb-5">Silakan cetak kuitansi sebagai bukti pembayaran.</p>
                    <a href="<?= base_url('siswa/pembiayaan/kuitansi') ?>" target="_blank" class="inline-flex items-center justify-center w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-sm">
                        <i class="fas fa-print mr-2"></i> Cetak Kuitansi
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-amber-100 bg-amber-50/50">
                    <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wide">Kuitansi</h3>
                </div>
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-4">
                        <i class="fas fa-lock text-3xl text-amber-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-amber-800 mb-2">Belum Tersedia</h4>
                    <p class="text-sm text-amber-600">Kuitansi dapat dicetak setelah semua tagihan lunas.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
