<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pembiayaan - <?= esc($siswa['nama_lengkap']) ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pembiayaan - <?= esc($siswa['nama_lengkap']) ?>
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

<div class="mb-6">
    <a href="<?= base_url('admin/pembiayaan/siswa') ?>" class="inline-flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<!-- Info Siswa -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-semibold text-gray-800">Data Siswa</h3>
    </div>
    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">No. Pendaftaran</p>
            <p class="text-gray-900 font-medium"><?= esc($siswa['no_pendaftaran']) ?></p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</p>
            <p class="text-gray-900 font-medium"><?= esc($siswa['nama_lengkap']) ?></p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">NISN</p>
            <p class="text-gray-900 font-medium"><?= esc($siswa['nisn'] ?? '-') ?></p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</p>
            <p class="text-gray-900 font-medium"><?= esc($siswa['jk'] ?? '-') ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Kiri: Tagihan + Riwayat -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Total Tagihan</p>
                <p class="text-xl font-bold text-gray-800"><?= format_rupiah($totalTagihan) ?></p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Sudah Dibayar</p>
                <p class="text-xl font-bold text-blue-600"><?= format_rupiah($totalLunas) ?></p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border <?= $statusLunas ? 'border-green-200 bg-green-50' : 'border-amber-200 bg-amber-50' ?> p-4 text-center">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Status</p>
                <?php if ($statusLunas): ?>
                    <p class="text-xl font-bold text-green-600"><i class="fas fa-check-circle mr-1"></i> LUNAS</p>
                <?php else: ?>
                    <p class="text-xl font-bold text-amber-600">Belum Lunas</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Checklist Tagihan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Centang Item yang Sudah Dibayar</h3>
                    <?php if (!empty($tagihan)): ?>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-600">Centang Semua</span>
                    </label>
                    <?php endif; ?>
                </div>
            </div>
            <div class="p-6">
                <?php if (empty($tagihan)): ?>
                    <p class="text-gray-500 text-center py-8">Belum ada tagihan.</p>
                <?php else: ?>
                    <form action="<?= base_url('admin/pembiayaan/siswa/' . $siswa['id_siswa'] . '/update-status') ?>" method="post" id="formStatusBayar">
                        <?= csrf_field() ?>
                        <div class="space-y-3" id="tagihanList">
                            <?php foreach ($tagihan as $t): ?>
                                <label class="flex items-center gap-3 p-3 rounded-lg border <?= $t['status_bayar'] === 'lunas' ? 'border-green-200 bg-green-50' : 'border-gray-200 hover:bg-gray-50' ?> cursor-pointer transition tagihan-item">
                                    <input type="checkbox" name="tagihan_ids[]" value="<?= $t['id_tagihan'] ?>"
                                        <?= $t['status_bayar'] === 'lunas' ? 'checked' : '' ?>
                                        data-harga="<?= $t['harga_satuan'] ?>"
                                        class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500 status-check">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900"><?= esc($t['nama_item']) ?></p>
                                        <p class="text-sm text-gray-500"><?= format_rupiah($t['harga_satuan']) ?></p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="status-label">
                                            <?php if ($t['status_bayar'] === 'lunas'): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i> Lunas
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    Belum
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <form action="<?= base_url('admin/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/hapus') ?>" method="post" class="inline" onsubmit="return confirm('Hapus tagihan ini?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_tagihan" value="<?= $t['id_tagihan'] ?>">
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition text-sm" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-sm text-gray-500">Total centang: <span id="totalCentang" class="font-bold text-blue-600">0</span> item</p>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Metode</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (empty($riwayatBayar)): ?>
                                <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada pembayaran.</td></tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($riwayatBayar as $bayar): ?>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700"><?= $no++ ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-700"><?= date('d/m/Y', strtotime($bayar['tanggal'])) ?></td>
                                        <td class="px-4 py-3 text-sm text-green-600 font-medium text-right"><?= format_rupiah($bayar['jumlah']) ?></td>
                                        <td class="px-4 py-3 text-sm text-gray-700"><?= esc($bayar['metode'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="space-y-6">

        <!-- Tambah Tagihan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Tambah Tagihan</h3>
            </div>
            <div class="p-6 space-y-4">
                <?php if (!empty($items)): ?>
                <form action="<?= base_url('admin/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah-semua') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-check-double mr-2"></i> Tambah Semua Item (<?= count($items) ?>)
                    </button>
                </form>
                <hr class="border-gray-200">
                <?php endif; ?>
                <form action="<?= base_url('admin/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah') ?>" method="post" class="space-y-4">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Item</label>
                        <?php if (empty($items)): ?>
                            <p class="text-sm text-gray-500 italic">Semua item sudah ditambahkan.</p>
                        <?php else: ?>
                        <select name="item_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Item --</option>
                            <?php foreach ($items as $item): ?>
                                <option value="<?= $item['id_item'] ?>"><?= esc($item['nama']) ?> - <?= format_rupiah($item['harga']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($items)): ?>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i> Tambah Tagihan
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Kuitansi -->
        <?php if ($statusLunas): ?>
            <div class="bg-green-50 rounded-xl shadow-sm border border-green-200 overflow-hidden">
                <div class="p-6 text-center">
                    <i class="fas fa-file-pdf text-4xl text-green-600 mb-3"></i>
                    <h3 class="text-lg font-bold text-green-800 mb-2">Pembayaran Lunas!</h3>
                    <p class="text-sm text-green-700 mb-4">Semua tagihan sudah terbayar.</p>
                    <a href="<?= base_url('admin/pembiayaan/siswa/' . $siswa['id_siswa'] . '/kuitansi') ?>" target="_blank" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 shadow-sm">
                        <i class="fas fa-print mr-2"></i> Cetak Kuitansi
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-amber-50 rounded-xl shadow-sm border border-amber-200 overflow-hidden">
                <div class="p-6 text-center">
                    <i class="fas fa-exclamation-triangle text-3xl text-amber-500 mb-3"></i>
                    <h3 class="text-lg font-bold text-amber-800 mb-2">Belum Lunas</h3>
                    <p class="text-sm text-amber-700">Masih ada <?= count($unpaidItems) ?> item yang belum dibayar.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
const checkAll = document.getElementById('checkAll');
const totalCentang = document.getElementById('totalCentang');
const statusChecks = document.querySelectorAll('.status-check');

function hitungTotal() {
    let count = 0;
    statusChecks.forEach(cb => {
        if (cb.checked) count++;
    });
    if (totalCentang) totalCentang.textContent = count;

    document.querySelectorAll('.tagihan-item').forEach(label => {
        const cb = label.querySelector('.status-check');
        const statusLabel = label.querySelector('.status-label');
        if (cb.checked) {
            label.classList.remove('border-gray-200', 'hover:bg-gray-50');
            label.classList.add('border-green-200', 'bg-green-50');
            statusLabel.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check mr-1"></i> Lunas</span>';
        } else {
            label.classList.remove('border-green-200', 'bg-green-50');
            label.classList.add('border-gray-200', 'hover:bg-gray-50');
            statusLabel.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Belum</span>';
        }
    });

    if (checkAll) {
        checkAll.checked = statusChecks.length > 0 && [...statusChecks].every(cb => cb.checked);
    }
}

if (checkAll) {
    checkAll.addEventListener('change', function() {
        statusChecks.forEach(cb => { cb.checked = this.checked; });
        hitungTotal();
    });
}

statusChecks.forEach(cb => {
    cb.addEventListener('change', hitungTotal);
});

hitungTotal();
</script>

<?= $this->endSection() ?>
