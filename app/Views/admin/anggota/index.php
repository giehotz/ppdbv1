<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Anggota</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data anggota dan kartu identitas.</p>
        </div>
        <button onclick="openModal('addModal')" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-colors hover:bg-brand-600 shrink-0">
            <i class="fas fa-plus"></i> Tambah Anggota
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th scope="col" class="py-3.5 px-5 w-12 text-center">No</th>
                    <th scope="col" class="py-3.5 px-4">Foto</th>
                    <th scope="col" class="py-3.5 px-4">Nama</th>
                    <th scope="col" class="py-3.5 px-4">Nomor Induk</th>
                    <th scope="col" class="py-3.5 px-4">Departemen</th>
                    <th scope="col" class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($anggota)) : ?>
                    <?php $no = 1;
                    foreach ($anggota as $row) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-5 text-center font-medium text-gray-500 dark:text-gray-400"><?= $no++ ?></td>
                            <td class="py-3.5 px-4">
                                <?php if ($row['foto']): ?>
                                    <img src="<?= base_url('uploads/kartu/' . $row['foto']) ?>" class="w-10 h-10 object-cover rounded-full border border-gray-200 dark:border-gray-700" alt="Foto">
                                <?php else: ?>
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-gray-100"><?= esc($row['nama']) ?></td>
                            <td class="py-3.5 px-4 font-mono text-gray-700 dark:text-gray-300"><?= esc($row['nomor_induk']) ?></td>
                            <td class="py-3.5 px-4 text-gray-600 dark:text-gray-400">
                                <span><?= esc($row['departemen']) ?></span>
                                <?php if ($row['sub_departemen']): ?>
                                    <span class="block text-[11px] text-gray-400 dark:text-gray-500"><?= esc($row['sub_departemen']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600 transition-colors dark:text-gray-400 dark:hover:bg-amber-500/15 dark:hover:text-amber-400"
                                        title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <form method="post" action="<?= base_url('admin/anggota/delete/' . $row['id_anggota']) ?>" data-confirm="Yakin ingin menghapus data anggota ini?" style="display:inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors dark:text-gray-400 dark:hover:bg-red-500/15 dark:hover:text-red-400"
                                            title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center text-gray-400 dark:text-gray-500">
                            <i class="fas fa-users text-4xl text-gray-300 dark:text-gray-700 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada data anggota.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Add -->
<div id="addModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 overflow-hidden transform transition-all">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-user-plus text-brand-500"></i> Tambah Anggota Baru
            </h3>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?= base_url('admin/anggota/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" required class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Induk / NPM / NIP</label>
                        <input type="text" name="nomor_induk" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Departemen / Fakultas</label>
                        <input type="text" name="departemen" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Sub Departemen / Prodi / Jabatan</label>
                        <input type="text" name="sub_departemen" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">QR Text (Data QR Code)</label>
                        <input type="text" name="qr_text" placeholder="Misal: https://web.com/u/ID123" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" class="w-full rounded-lg border border-gray-200 bg-transparent px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pas Foto</label>
                        <input type="file" name="foto" accept="image/*" class="w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/15 dark:file:text-brand-400 dark:border-gray-800">
                    </div>
                </div>
            </div>
            <div class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
                <button type="button" onclick="closeModal('addModal')" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all shadow-theme-xs">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 overflow-hidden transform transition-all">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-user-edit text-amber-500"></i> Edit Anggota
            </h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" id="edit_nama" required class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Induk / NPM / NIP</label>
                        <input type="text" name="nomor_induk" id="edit_nomor_induk" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Departemen / Fakultas</label>
                        <input type="text" name="departemen" id="edit_departemen" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Sub Departemen / Prodi / Jabatan</label>
                        <input type="text" name="sub_departemen" id="edit_sub_departemen" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">QR Text (Data QR Code)</label>
                        <input type="text" name="qr_text" id="edit_qr_text" class="h-9 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" rows="2" class="w-full rounded-lg border border-gray-200 bg-transparent px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Ganti Pas Foto (opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full rounded-lg border border-gray-200 bg-transparent px-3 py-1.5 text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/15 dark:file:text-brand-400 dark:border-gray-800">
                    </div>
                </div>
            </div>
            <div class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
                <button type="button" onclick="closeModal('editModal')" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all shadow-theme-xs">Perbarui Anggota</button>
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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('addModal');
            closeModal('editModal');
        }
    });
</script>
<?= $this->endSection() ?>