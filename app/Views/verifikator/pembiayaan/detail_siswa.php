<?= $this->extend('layouts/verifikator') ?>

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
    <a href="<?= base_url('verifikator/pembiayaan') ?>" class="inline-flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
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

    <!-- Kolom Kiri: Checklist + Riwayat -->
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
                    <p class="text-gray-500 text-center py-8">Belum ada tagihan. Tambahkan item terlebih dahulu.</p>
                <?php else: ?>
                    <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/update-status') ?>" method="post" id="formStatusBayar">
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
                                        <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/hapus') ?>" method="post" class="inline" onsubmit="return confirm('Hapus tagihan ini?')">
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
                <div class="space-y-4">
                    <?php if (empty($riwayatBayar)): ?>
                        <p class="text-gray-500 text-center py-8">Belum ada pembayaran.</p>
                    <?php else: ?>
                        <?php $no = 1; foreach ($riwayatBayar as $bayar):
                            $bukti = !empty($bayar['bukti_pembayaran']) ? json_decode($bayar['bukti_pembayaran'], true) : [];
                        ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold text-white bg-blue-500 rounded-full w-6 h-6 flex items-center justify-center"><?= $no++ ?></span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900"><?= format_rupiah($bayar['jumlah']) ?></p>
                                        <p class="text-xs text-gray-500"><?= date('d/m/Y', strtotime($bayar['tanggal'])) ?> &middot; <?= esc($bayar['metode'] ?? '-') ?></p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Dibayar
                                </span>
                            </div>
                            <?php if (!empty($bayar['keterangan'])): ?>
                                <p class="text-xs text-gray-500 mb-2 ml-9"><?= esc($bayar['keterangan']) ?></p>
                            <?php endif; ?>

                            <!-- Bukti Images -->
                            <div class="ml-9 mt-2">
                                <?php if (!empty($bukti)): ?>
                                    <div class="flex flex-wrap gap-2">
                                        <?php foreach ($bukti as $idx => $file): ?>
                                            <div class="relative group">
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $file) ?>" target="_blank" class="block w-20 h-20 rounded-lg overflow-hidden border border-gray-200 hover:border-blue-400 transition">
                                                    <img src="<?= base_url('uploads/bukti_pembayaran/' . $file) ?>" alt="Bukti" class="w-full h-full object-cover">
                                                </a>
                                                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/hapus-bukti') ?>" method="post" class="absolute -top-2 -right-2 hidden group-hover:block" onsubmit="return confirm('Hapus bukti ini?')">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id_pembayaran" value="<?= $bayar['id_pembayaran'] ?>">
                                                    <input type="hidden" name="index" value="<?= $idx ?>">
                                                    <button type="submit" class="bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 shadow">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Upload tambahan -->
                                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/upload-bukti') ?>" method="post" enctype="multipart/form-data" class="mt-2">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_pembayaran" value="<?= $bayar['id_pembayaran'] ?>">
                                    <label class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-800 cursor-pointer font-medium">
                                        <i class="fas fa-camera"></i> Tambah Bukti
                                        <input type="file" name="bukti_pembayaran[]" multiple accept="image/*" class="hidden" onchange="this.form.submit()">
                                    </label>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah-semua') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-check-double mr-2"></i> Tambah Semua Item (<?= count($items) ?>)
                    </button>
                </form>
                <hr class="border-gray-200">
                <?php endif; ?>
                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah') ?>" method="post" class="space-y-4">
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

        <!-- Catat Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Catat Pembayaran</h3>
            </div>
            <div class="p-6">
                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/bayar') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tagihan_ids" id="tagihanIdsHidden" value="">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" id="jumlahBayar" required min="1" readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 text-gray-700 font-bold focus:outline-none" placeholder="0">
                        <p class="text-xs text-gray-400 mt-1">Otomatis dihitung dari item yang dicentang</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                        <select name="metode" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Catatan opsional..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran[]" multiple accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Bisa pilih lebih dari 1 file.</p>
                        <div id="preview-bukti" class="flex flex-wrap gap-2 mt-2"></div>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-money-bill-wave mr-2"></i> Catat Pembayaran
                    </button>
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
                    <a href="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/kuitansi') ?>" target="_blank" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 shadow-sm">
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
// Check All & Auto Hitung
const checkAll = document.getElementById('checkAll');
const jumlahBayar = document.getElementById('jumlahBayar');
const totalCentang = document.getElementById('totalCentang');
const statusChecks = document.querySelectorAll('.status-check');

function hitungTotal() {
    let total = 0;
    let count = 0;
    let ids = [];
    statusChecks.forEach(cb => {
        if (cb.checked) {
            total += parseInt(cb.dataset.harga) || 0;
            count++;
            ids.push(cb.value);
        }
    });
    jumlahBayar.value = total;
    totalCentang.textContent = count;
    document.getElementById('tagihanIdsHidden').value = ids.join(',');

    // Update label warna
    const labels = document.querySelectorAll('.tagihan-item');
    labels.forEach(label => {
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

    // Update checkAll state
    if (checkAll) {
        const allChecked = statusChecks.length > 0 && [...statusChecks].every(cb => cb.checked);
        checkAll.checked = allChecked;
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

// Hitung saat load (untuk item yang sudah lunas)
hitungTotal();

// Preview bukti pembayaran
const fileInput = document.querySelector('input[name="bukti_pembayaran[]"]');
if (fileInput) {
    fileInput.addEventListener('change', function(e) {
        const preview = document.getElementById('preview-bukti');
        preview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'w-16 h-16 object-cover rounded-lg border border-gray-200';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
}
</script>

<?= $this->endSection() ?>
