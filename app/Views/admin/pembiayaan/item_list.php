<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Item Pembiayaan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">payments</span> Item Pembiayaan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Item Pembiayaan</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola item biaya pendaftaran dan seragam yang ditagihkan ke calon siswa</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <a href="<?= base_url('admin/pembiayaan/siswa') ?>" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 text-xs font-semibold shadow-theme-xs transition dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base text-brand-500">group</span>
            <span>Tagihan Siswa</span>
        </a>

        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">add</span>
            <span>Tambah Item</span>
        </button>
    </div>
</div>

<!-- Main Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">Nama Item</th>
                    <th class="py-3 px-4 text-right">Harga Satuan</th>
                    <th class="py-3 px-4 text-center">Sasaran Gender</th>
                    <th class="py-3 px-4 text-center">Urutan</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300 dark:text-gray-600">inbox</span>
                            Belum ada item pembiayaan yang ditambahkan.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($items as $item): ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors <?= $item['aktif'] ? '' : 'opacity-60 bg-gray-50/30 dark:bg-gray-800/20' ?>">
                            <td class="py-3.5 px-4 font-mono text-gray-500 dark:text-gray-400"><?= $no++ ?></td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 dark:text-white"><?= esc($item['nama']) ?></div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold font-mono text-gray-900 dark:text-white">
                                <?= format_rupiah($item['harga']) ?>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if ($item['jenis_kelamin'] === 'L'): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
                                        <span class="material-symbols-outlined text-xs">male</span> Laki-laki
                                    </span>
                                <?php elseif ($item['jenis_kelamin'] === 'P'): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-pink-50 px-2.5 py-0.5 text-xs font-semibold text-pink-700 dark:bg-pink-500/15 dark:text-pink-400 border border-pink-200/50 dark:border-pink-500/20">
                                        <span class="material-symbols-outlined text-xs">female</span> Perempuan
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                        Semua Gender
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-gray-500 dark:text-gray-400">
                                <?= $item['urutan'] ?>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if ($item['aktif']): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" onclick="openEdit(<?= esc(json_encode($item)) ?>)" class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 hover:bg-brand-50 hover:text-brand-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-brand-500/15 dark:hover:text-brand-400 transition" title="Edit Item">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    <?php if ($item['aktif']): ?>
                                        <form action="<?= base_url('admin/pembiayaan/delete/' . $item['id_item']) ?>" method="post" class="inline" onsubmit="return confirm('Nonaktifkan item pembiayaan ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 transition" title="Nonaktifkan">
                                                <span class="material-symbols-outlined text-base">power_settings_new</span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?= base_url('admin/pembiayaan/activate/' . $item['id_item']) ?>" method="post" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-500/15 dark:text-emerald-400 dark:hover:bg-emerald-500/25 transition" title="Aktifkan">
                                                <span class="material-symbols-outlined text-base">check_circle</span>
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

<!-- Modal Tambah -->
<div id="modalTambah" class="hidden fixed inset-0 z-[9999] overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 max-w-md w-full overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/40">
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">add_circle</span>
                Tambah Item Pembiayaan
            </h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <form action="<?= base_url('admin/pembiayaan/store') ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none" placeholder="Contoh: Seragam Batik & Olahraga">
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" required min="0" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none" placeholder="0">
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Sasaran Gender</label>
                <select name="jenis_kelamin" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    <option value="">Semua (Laki-laki & Perempuan)</option>
                    <option value="L">Khusus Laki-laki</option>
                    <option value="P">Khusus Perempuan</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nomor Urutan</label>
                <input type="number" name="urutan" value="0" min="0" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-gray-100 dark:border-gray-800">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition shadow-theme-xs">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">Simpan Item</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="hidden fixed inset-0 z-[9999] overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 max-w-md w-full overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/40">
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">edit</span>
                Edit Item Pembiayaan
            </h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <form action="<?= base_url('admin/pembiayaan/update') ?>" method="post" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="id_item" id="edit_id">
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nama Item <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="edit_nama" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Harga Satuan (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="edit_harga" required min="0" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Sasaran Gender</label>
                <select name="jenis_kelamin" id="edit_jk" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    <option value="">Semua (Laki-laki & Perempuan)</option>
                    <option value="L">Khusus Laki-laki</option>
                    <option value="P">Khusus Perempuan</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nomor Urutan</label>
                <input type="number" name="urutan" id="edit_urutan" min="0" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div class="flex justify-end gap-2.5 pt-4 border-t border-gray-100 dark:border-gray-800">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition shadow-theme-xs">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">Update Item</button>
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
