<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Anggota</h2>
        <button onclick="openModal('addModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i> Tambah Anggota
        </button>
    </div>

    <div class="p-6 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Foto</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Nomor Induk</th>
                    <th scope="col" class="px-6 py-3">Departemen</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($anggota)) : ?>
                    <?php $no = 1;
                    foreach ($anggota as $row) : ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= $no++ ?></td>
                            <td class="px-6 py-4">
                                <?php if ($row['foto']): ?>
                                    <img src="<?= base_url('uploads/kartu/' . $row['foto']) ?>" class="w-12 h-12 object-cover rounded-full border border-gray-200" alt="Foto">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900"><?= esc($row['nama']) ?></td>
                            <td class="px-6 py-4"><?= esc($row['nomor_induk']) ?></td>
                            <td class="px-6 py-4">
                                <?= esc($row['departemen']) ?>
                                <?php if ($row['sub_departemen']): ?>
                                    <br><span class="text-xs text-gray-400"><?= esc($row['sub_departemen']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('admin/anggota/delete/' . $row['id_anggota']) ?>" data-confirm="Yakin ingin menghapus data anggota ini?" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data anggota.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Add -->
<div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-3/4 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Anggota Baru</h3>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/anggota/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                    <input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Induk / NPM / NIP</label>
                    <input type="text" name="nomor_induk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departemen / Fakultas</label>
                    <input type="text" name="departemen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sub Departemen / Prodi / Jabatan</label>
                    <input type="text" name="sub_departemen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">QR Text (Data QR Code)</label>
                    <input type="text" name="qr_text" placeholder="Misal: https://web.com/u/ID123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border"></textarea>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Pas Foto</label>
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full border text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 rounded-md">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal('addModal')" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-3/4 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-900">Edit Anggota</h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                    <input type="text" name="nama" id="edit_nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Induk / NPM / NIP</label>
                    <input type="text" name="nomor_induk" id="edit_nomor_induk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departemen / Fakultas</label>
                    <input type="text" name="departemen" id="edit_departemen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sub Departemen / Prodi / Jabatan</label>
                    <input type="text" name="sub_departemen" id="edit_sub_departemen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">QR Text (Data QR Code)</label>
                    <input type="text" name="qr_text" id="edit_qr_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2 border"></textarea>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Ganti Pas Foto (opsional)</label>
                    <input type="file" name="foto" accept="image/*" class="mt-1 block w-full border text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 rounded-md">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal('editModal')" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Perbarui Anggota</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openEditModal(data) {
        document.getElementById('formEdit').action = "<?= base_url('admin/anggota/update/') ?>" + data.id_anggota;
        document.getElementById('edit_nama').value = data.nama || '';
        document.getElementById('edit_tempat_lahir').value = data.tempat_lahir || '';
        document.getElementById('edit_tgl_lahir').value = data.tgl_lahir || '';
        document.getElementById('edit_nomor_induk').value = data.nomor_induk || '';
        document.getElementById('edit_departemen').value = data.departemen || '';
        document.getElementById('edit_sub_departemen').value = data.sub_departemen || '';
        document.getElementById('edit_qr_text').value = data.qr_text || '';
        document.getElementById('edit_alamat').value = data.alamat || '';
        openModal('editModal');
    }
</script>
<?= $this->endSection() ?>