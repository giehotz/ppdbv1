<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Item Pembiayaan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Item Pembiayaan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Daftar Item Pembiayaan</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola item biaya pendaftaran yang akan ditagihkan ke siswa.</p>
            </div>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i> Tambah Item
            </button>
        </div>
    </div>

    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Item</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-2 block"></i>
                                Belum ada item pembiayaan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($items as $item): ?>
                            <tr class="<?= $item['aktif'] ? '' : 'bg-gray-50 opacity-60' ?>">
                                <td class="px-4 py-3 text-sm text-gray-700"><?= $no++ ?></td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900"><?= esc($item['nama']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700 text-right"><?= format_rupiah($item['harga']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-700 text-center">
                                    <?php if ($item['jenis_kelamin'] === 'L'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Laki-laki</span>
                                    <?php elseif ($item['jenis_kelamin'] === 'P'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Perempuan</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Semua</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 text-center"><?= $item['urutan'] ?></td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <?php if ($item['aktif']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEdit(<?= esc(json_encode($item)) ?>)" class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <?php if ($item['aktif']): ?>
                                            <form action="<?= base_url('admin/pembiayaan/delete/' . $item['id_item']) ?>" method="post" class="inline" onsubmit="return confirm('Nonaktifkan item ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Nonaktifkan">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="<?= base_url('admin/pembiayaan/activate/' . $item['id_item']) ?>" method="post" class="inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-green-600 hover:text-green-800 transition" title="Aktifkan">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Tambah Item Pembiayaan</h3>
            <button onclick="this.closest('#modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/pembiayaan/store') ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Uang Pendaftaran">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="urutan" value="0" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="this.closest('#modalTambah').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Edit Item Pembiayaan</h3>
            <button onclick="this.closest('#modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/pembiayaan/update') ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_item" id="edit_id">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="edit_nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="edit_harga" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="edit_jk" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="urutan" id="edit_urutan" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="this.closest('#modalEdit').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(item) {
    document.getElementById('edit_id').value = item.id_item;
    document.getElementById('edit_nama').value = item.nama;
    document.getElementById('edit_harga').value = item.harga;
    document.getElementById('edit_jk').value = item.jenis_kelamin || '';
    document.getElementById('edit_urutan').value = item.urutan;
    document.getElementById('modalEdit').classList.remove('hidden');
}
</script>

<?= $this->endSection() ?>
