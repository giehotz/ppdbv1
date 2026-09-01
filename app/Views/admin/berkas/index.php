<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Manajemen Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Status Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">Menunggu</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Pending Review</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($statusCounts['pending']) ?></h4>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500">Perlu diverifikasi</p>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <i class="fas fa-check-circle text-lg"></i>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Valid</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Valid</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($statusCounts['valid']) ?></h4>
            </div>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">Dokumen sesuai</p>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <i class="fas fa-times-circle text-lg"></i>
            </div>
            <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">Invalid</span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Invalid</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90"><?= number_format($statusCounts['invalid']) ?></h4>
            </div>
            <p class="text-[11px] text-red-600 dark:text-red-400 font-medium">Perlu diperbaiki</p>
        </div>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Berkas Calon Siswa</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Periksa dan validasi dokumen persyaratan pendaftaran calon peserta didik.</p>
            </div>

            <form action="<?= base_url('admin/berkas') ?>" method="get" class="flex w-full lg:w-auto">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Cari No. Daftar, Nama, Jenis..."
                        class="h-9 w-full rounded-l-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 dark:placeholder:text-gray-500 sm:w-64">
                </div>
                <button type="submit" class="inline-flex items-center justify-center bg-gray-800 px-4 text-xs font-semibold text-white transition-colors hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                    Cari
                </button>
                <?php if (!empty($search)) : ?>
                    <a href="<?= base_url('admin/berkas') ?>" class="flex items-center justify-center border border-l-0 border-red-200 bg-red-50 px-3 text-red-600 transition-colors hover:bg-red-100 rounded-r-lg dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400" title="Reset Pencarian">
                        <i class="fas fa-times text-xs"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-5 w-1/4">Informasi Siswa</th>
                    <th class="py-3.5 px-5 w-3/4">Daftar Berkas Terunggah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                        <tr class="hover:bg-gray-50/30 transition-colors dark:hover:bg-white/[0.01] align-top">
                            <!-- Student Info Column -->
                            <td class="py-4 px-5 bg-gray-50/30 dark:bg-gray-800/20 border-r border-gray-100 dark:border-gray-800">
                                <div class="font-bold text-gray-900 dark:text-white text-sm mb-2"><?= esc($student['nama_lengkap']) ?></div>
                                <div class="space-y-1.5">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 flex flex-col">
                                        <span class="font-medium mb-1 text-[11px]">No. Pendaftaran:</span>
                                        <span class="font-mono bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-2 py-0.5 border border-gray-200 dark:border-gray-700 rounded text-xs font-bold w-max"><?= esc($student['no_pendaftaran']) ?></span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex flex-col">
                                        <span class="font-medium mb-0.5 text-[11px]">NISN:</span>
                                        <span class="text-gray-800 dark:text-gray-200 font-mono"><?= esc($student['nisn']) ?></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Files Column -->
                            <td class="py-4 px-5">
                                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
                                    <table class="w-full text-left">
                                        <thead class="bg-gray-50/60 dark:bg-gray-800/50 text-[11px] font-semibold text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-800">
                                            <tr>
                                                <th class="py-2.5 px-3 w-8 text-center">
                                                    <i class="fas fa-check text-gray-300 dark:text-gray-600"></i>
                                                </th>
                                                <th class="py-2.5 px-3 w-1/3">Jenis Berkas</th>
                                                <th class="py-2.5 px-3 w-1/3">Nama File & Waktu</th>
                                                <th class="py-2.5 px-3 text-center">Status</th>
                                                <th class="py-2.5 px-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            <?php foreach ($student['berkas_list'] as $b) : ?>
                                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                                    <td class="py-2.5 px-3 text-center align-middle">
                                                        <input type="checkbox" class="berkas-checkbox h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 cursor-pointer" value="<?= $b['id_berkas'] ?>" onclick="updateBulkBar()">
                                                    </td>
                                                    <td class="py-2.5 px-3 align-middle">
                                                        <span class="font-semibold text-gray-800 dark:text-gray-100 block"><?= esc($b['jenis_berkas']) ?></span>
                                                        <?php if (!empty($b['keterangan'])): ?>
                                                            <div class="text-[11px] text-amber-700 dark:text-amber-300 mt-1 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded-md inline-flex items-start max-w-full">
                                                                <i class="fas fa-info-circle mr-1 mt-0.5"></i>
                                                                <span class="leading-tight"><?= esc($b['keterangan']) ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2.5 px-3 align-middle">
                                                        <div class="flex flex-col items-start">
                                                            <span class="text-[11px] font-mono bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded border border-blue-100 dark:border-blue-900/50 block max-w-[200px] truncate" title="<?= esc($b['nama_file']) ?>">
                                                                <i class="fas fa-file-alt mr-1"></i><?= esc($b['nama_file']) ?>
                                                            </span>
                                                            <div class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 font-medium flex items-center">
                                                                <i class="far fa-clock mr-1"></i> <?= date('d M Y, H:i', strtotime($b['created_at'])) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-center align-middle">
                                                        <?php if ($b['status_verifikasi'] == 'valid') : ?>
                                                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 py-0.5 px-2.5 rounded-full text-[11px] font-bold">
                                                                <i class="fas fa-check-circle text-[10px]"></i> Valid
                                                            </span>
                                                        <?php elseif ($b['status_verifikasi'] == 'invalid') : ?>
                                                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400 py-0.5 px-2.5 rounded-full text-[11px] font-bold">
                                                                <i class="fas fa-times-circle text-[10px]"></i> Invalid
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 py-0.5 px-2.5 rounded-full text-[11px] font-bold">
                                                                <i class="fas fa-clock text-[10px]"></i> Pending
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-center align-middle">
                                                        <div class="flex items-center justify-center gap-1.5">
                                                            <?php
                                                            if (!empty($b['path_file'])) {
                                                                $previewUrl = base_url($b['path_file']);
                                                            } else {
                                                                $previewUrl = base_url('uploads/berkas/' . ($student['nisn'] ?? '') . '/' . $b['nama_file']);
                                                            }
                                                            $ext = strtolower(pathinfo($b['nama_file'], PATHINFO_EXTENSION));
                                                            ?>
                                                            <button onclick="openFilePreview('<?= esc($previewUrl, 'js') ?>', '<?= esc($b['nama_file'], 'js') ?>', '<?= esc($ext, 'js') ?>', <?= (int)$b['id_berkas'] ?>, '<?= esc($b['status_verifikasi'], 'js') ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>', '<?= esc($student['nama_lengkap'], 'js') ?>', '<?= esc($b['jenis_berkas'], 'js') ?>')"
                                                                class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-colors dark:text-gray-400 dark:hover:bg-blue-500/15 dark:hover:text-blue-400"
                                                                title="Lihat Berkas">
                                                                <i class="fas fa-eye text-xs"></i>
                                                            </button>
                                                            <button onclick="openStatusModal(<?= (int)$b['id_berkas'] ?>, '<?= esc($b['status_verifikasi'], 'js') ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>')"
                                                                class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition-colors dark:text-gray-400 dark:hover:bg-emerald-500/15 dark:hover:text-emerald-400"
                                                                title="Validasi Berkas">
                                                                <i class="fas fa-check-square text-xs"></i>
                                                            </button>
                                                            <form method="post" action="<?= base_url('admin/berkas/delete/' . $b['id_berkas']) ?>"
                                                                data-confirm="Yakin ingin menghapus berkas ini?"
                                                                style="display:inline">
                                                                <?= csrf_field() ?>
                                                                <button type="submit"
                                                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors dark:text-gray-400 dark:hover:bg-red-500/15 dark:hover:text-red-400"
                                                                    title="Hapus Berkas">
                                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" class="py-12 px-6 text-center text-gray-400 dark:text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-folder-open text-4xl text-gray-300 dark:text-gray-700 mb-2"></i>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300"><?= !empty($search) ? 'Berkas Tidak Ditemukan' : 'Belum Ada Berkas' ?></p>
                                <p class="text-xs text-gray-400"><?= !empty($search) ? 'Silakan gunakan kata kunci lain.' : 'Belum ada calon siswa yang mengunggah dokumen.' ?></p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($berkas)) : ?>
        <div class="border-t border-gray-100 px-5 py-3.5 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex flex-col sm:flex-row justify-between items-center gap-3">
            <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan manajemen data berkas.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Floating Bulk Action Bar -->
<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40 w-full px-4 max-w-lg">
    <div class="bg-gray-900/90 backdrop-blur-md text-white rounded-2xl shadow-2xl px-5 py-3.5 flex items-center gap-3 border border-gray-700">
        <span class="text-xs font-semibold text-white flex items-center">
            <span class="bg-brand-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-[10px] font-bold mr-2" id="selectedCount">0</span>
            Dipilih
        </span>
        <div class="h-5 w-px bg-gray-700"></div>
        <button onclick="bulkQuickAction('valid')" class="flex items-center text-xs font-semibold text-emerald-400 hover:text-white hover:bg-emerald-600 py-1.5 px-2.5 rounded-lg transition-colors">
            <i class="fas fa-check mr-1.5"></i>Valid
        </button>
        <button onclick="bulkQuickAction('invalid')" class="flex items-center text-xs font-semibold text-red-400 hover:text-white hover:bg-red-600 py-1.5 px-2.5 rounded-lg transition-colors">
            <i class="fas fa-times mr-1.5"></i>Invalid
        </button>
        <button onclick="bulkQuickAction('pending')" class="flex items-center text-xs font-semibold text-amber-400 hover:text-white hover:bg-amber-500 py-1.5 px-2.5 rounded-lg transition-colors">
            <i class="fas fa-clock mr-1.5"></i>Pending
        </button>
        <div class="h-5 w-px bg-gray-700"></div>
        <button onclick="openBulkModal()" class="flex items-center text-xs font-semibold text-brand-300 hover:text-white hover:bg-brand-600 py-1.5 px-2.5 rounded-lg transition-colors">
            <i class="fas fa-comment-dots mr-1.5"></i>Catatan
        </button>
        <button onclick="clearSelection()" class="ml-auto text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 p-1.5 rounded-full transition-colors focus:outline-none" title="Batal">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>
</div>

<!-- Bulk Status Update Modal -->
<div id="bulkModal" class="fixed inset-0 z-[9999] hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBulkModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all overflow-hidden" id="bulkModalContent">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex justify-between items-center">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-layer-group text-brand-500 mr-2"></i> Update Massal Status Berkas
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Status untuk <span id="bulkModalCount" class="font-bold text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 px-1.5 rounded">0</span> berkas.</p>
                </div>
                <button onclick="closeBulkModal()" class="text-gray-400 hover:text-gray-600 text-sm"><i class="fas fa-times"></i></button>
            </div>

            <form id="bulkForm" action="<?= base_url('admin/berkas/bulkUpdateStatus') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="ids" id="bulkIds">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pilih Status Baru</label>
                        <select name="status" required class="w-full rounded-xl border border-gray-200 bg-transparent py-2.5 px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                            <option value="valid">Valid (Disetujui)</option>
                            <option value="invalid">Invalid (Ditolak / Perbaiki)</option>
                            <option value="pending">Pending (Menunggu)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan untuk siswa terkait berkas ini..." class="w-full rounded-xl border border-gray-200 bg-transparent py-2.5 px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100"></textarea>
                    </div>
                </div>

                <div class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
                    <button type="button" onclick="closeBulkModal()" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all shadow-theme-xs flex items-center gap-2">
                        <i class="fas fa-save"></i> Update Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Status Update Modal -->
<div id="statusModal" class="fixed inset-0 z-[9999] hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeStatusModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all overflow-hidden" id="statusModalContent">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-check-square text-emerald-500 mr-2"></i> Validasi Berkas Siswa
                </h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-sm"><i class="fas fa-times"></i></button>
            </div>

            <form id="statusForm" method="post">
                <?= csrf_field() ?>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status Validasi</label>
                        <select name="status" required class="w-full rounded-xl border border-gray-200 bg-transparent py-2.5 px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100">
                            <option value="pending">Pending (Menunggu)</option>
                            <option value="valid">Valid (Disetujui)</option>
                            <option value="invalid">Invalid (Perlu Diperbaiki)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan/Keterangan</label>
                        <textarea name="keterangan" rows="3" placeholder="Alasan penolakan atau catatan validasi..." class="w-full rounded-xl border border-gray-200 bg-transparent py-2.5 px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:text-gray-100"></textarea>
                    </div>
                </div>

                <div class="px-6 py-3.5 bg-gray-50/50 dark:bg-gray-800/40 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
                    <button type="button" onclick="closeStatusModal()" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all shadow-theme-xs flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div id="filePreviewModal" class="fixed inset-0 bg-black/85 z-[99999] hidden flex items-center justify-center backdrop-blur-md" onclick="if(event.target === this) closeFilePreview()">
    <div class="relative w-full h-full flex flex-col pointer-events-none">
        <!-- Top Control Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-3 bg-gray-900/95 backdrop-blur-md text-white w-full z-20 border-b border-gray-800 pointer-events-auto shrink-0 shadow-lg">
            <!-- Left: Document & Student Info -->
            <div class="flex items-center gap-3 min-w-0 max-w-full sm:max-w-[45%]">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-500/20 text-brand-400 border border-brand-500/30">
                    <i class="fas fa-file-alt text-base"></i>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span id="previewDocType" class="text-xs font-bold text-white uppercase tracking-wider truncate"></span>
                        <span id="previewStatusBadge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold"></span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-gray-400 truncate">
                        <span id="previewStudentName" class="font-medium text-gray-300"></span>
                        <span>•</span>
                        <span id="previewTextName" class="truncate font-mono"></span>
                    </div>
                </div>
            </div>

            <!-- Right: Action Buttons (Setujui, Tolak, Unduh, Tutup) -->
            <div class="flex flex-wrap items-center gap-2 ml-auto">
                <!-- Tombol Setujui -->
                <button type="button" id="btnPreviewApprove" onclick="previewActionUpdate('valid')"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-[0.97] text-white px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer">
                    <i class="fas fa-check-circle text-xs"></i>
                    <span>Setujui</span>
                </button>

                <!-- Tombol Tolak -->
                <button type="button" id="btnPreviewReject" onclick="previewActionUpdate('invalid')"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 hover:bg-red-700 active:scale-[0.97] text-white px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer">
                    <i class="fas fa-times-circle text-xs"></i>
                    <span>Tolak</span>
                </button>

                <div class="h-6 w-px bg-gray-700 hidden sm:block mx-1"></div>

                <!-- Tombol Unduh -->
                <a id="previewDownloadBtn" href="#" download
                    class="inline-flex items-center gap-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 border border-gray-700 px-3.5 py-2 text-xs font-semibold transition-all shadow-theme-xs active:scale-[0.97]">
                    <i class="fas fa-download text-xs"></i>
                    <span class="hidden sm:inline">Unduh</span>
                </a>

                <!-- Tombol Tutup -->
                <button type="button" onclick="closeFilePreview()" title="Tutup Pratinjau (Esc)"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 border border-gray-700 px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer active:scale-[0.97]">
                    <i class="fas fa-times text-xs"></i>
                    <span class="hidden sm:inline">Tutup</span>
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div id="previewContent" class="flex-1 flex items-center justify-center overflow-auto p-4 sm:p-6 pointer-events-auto" onclick="if(event.target === this) closeFilePreview()">
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let currentPreviewBerkasId = null;
    let currentPreviewStatus = null;
    let currentPreviewKeterangan = '';

    function updatePreviewBadge(status) {
        const badge = document.getElementById('previewStatusBadge');
        if (!badge) return;
        
        if (status === 'valid') {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40';
            badge.innerHTML = '<i class="fas fa-check-circle text-[9px]"></i> Valid';
        } else if (status === 'invalid') {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/20 text-red-300 border border-red-500/40';
            badge.innerHTML = '<i class="fas fa-times-circle text-[9px]"></i> Invalid';
        } else {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40';
            badge.innerHTML = '<i class="fas fa-clock text-[9px]"></i> Pending';
        }
    }

    function openStatusModal(id, status, keterangan) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusForm');

        form.action = '<?= base_url('admin/berkas/updateStatus/') ?>' + id;
        form.querySelector('[name="status"]').value = status;
        form.querySelector('[name="keterangan"]').value = keterangan;

        modal.classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    function openFilePreview(url, fileName, ext, idBerkas, statusVerifikasi, keterangan, studentName, docType) {
        const modal = document.getElementById('filePreviewModal');
        const content = document.getElementById('previewContent');
        const nameEl = document.getElementById('previewTextName');
        const docTypeEl = document.getElementById('previewDocType');
        const studentNameEl = document.getElementById('previewStudentName');
        const downloadBtn = document.getElementById('previewDownloadBtn');

        currentPreviewBerkasId = idBerkas || null;
        currentPreviewStatus = statusVerifikasi || 'pending';
        currentPreviewKeterangan = keterangan || '';

        nameEl.textContent = fileName;
        if (docTypeEl) docTypeEl.textContent = docType || 'Berkas Siswa';
        if (studentNameEl) studentNameEl.textContent = studentName || '';
        updatePreviewBadge(currentPreviewStatus);

        downloadBtn.href = url;

        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        const pdfExts = ['pdf'];

        if (imageExts.includes(ext)) {
            content.innerHTML = `<img src="${url}" alt="${fileName}" class="max-w-[95%] max-h-[85vh] object-contain rounded-xl shadow-2xl border border-gray-800">`;
        } else if (pdfExts.includes(ext)) {
            content.innerHTML = `<iframe src="${url}" class="w-full h-full max-w-5xl rounded-xl border border-gray-800 bg-white" style="height: 80vh;"></iframe>`;
        } else {
            content.innerHTML = `
                <div class="text-center text-white bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl max-w-md">
                    <i class="fas fa-file-archive text-5xl mb-4 text-gray-500"></i>
                    <p class="text-sm font-semibold mb-1">Preview Tidak Tersedia</p>
                    <p class="text-gray-400 text-xs mb-5">Format file <strong>.${ext}</strong> tidak dapat ditampilkan langsung.</p>
                    <a href="${url}" download class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2 px-5 rounded-xl transition text-xs">
                        <i class="fas fa-download"></i>Download File
                    </a>
                </div>`;
        }

        modal.classList.remove('hidden');
    }

    function closeFilePreview() {
        document.getElementById('filePreviewModal').classList.add('hidden');
        document.getElementById('previewContent').innerHTML = '';
        currentPreviewBerkasId = null;
    }

    async function previewActionUpdate(status) {
        if (!currentPreviewBerkasId) return;

        let keterangan = currentPreviewKeterangan;

        if (status === 'invalid') {
            const { value: note, isConfirmed } = await Swal.fire({
                title: 'Tolak Berkas Ini?',
                text: 'Berikan alasan / catatan perbaikan untuk calon siswa (opsional):',
                input: 'textarea',
                inputValue: keterangan || '',
                inputPlaceholder: 'Contoh: Dokumen buram atau halaman tidak lengkap...',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-times-circle mr-1"></i> Tolak Berkas',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rounded-2xl dark:bg-gray-900 dark:text-white',
                    title: 'text-base font-bold',
                    confirmButton: 'rounded-xl text-xs font-bold py-2.5 px-4',
                    cancelButton: 'rounded-xl text-xs font-semibold py-2.5 px-4',
                    input: 'text-xs rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800'
                }
            });

            if (!isConfirmed) return;
            keterangan = note || '';
        } else if (status === 'valid') {
            const { isConfirmed } = await Swal.fire({
                title: 'Setujui Berkas Ini?',
                text: 'Status dokumen akan diverifikasi menjadi Valid (Disetujui).',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check-circle mr-1"></i> Ya, Setujui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rounded-2xl dark:bg-gray-900 dark:text-white',
                    title: 'text-base font-bold',
                    confirmButton: 'rounded-xl text-xs font-bold py-2.5 px-4',
                    cancelButton: 'rounded-xl text-xs font-semibold py-2.5 px-4'
                }
            });

            if (!isConfirmed) return;
            keterangan = '';
        }

        // Send AJAX request
        const formData = new FormData();
        formData.append('status', status);
        formData.append('keterangan', keterangan);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        try {
            const res = await fetch('<?= base_url('admin/berkas/updateStatus/') ?>' + currentPreviewBerkasId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                currentPreviewStatus = status;
                currentPreviewKeterangan = keterangan;
                updatePreviewBadge(status);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Status berkas berhasil diperbarui.',
                    timer: 1300,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Gagal mengubah status berkas.'
                });
            }
        } catch (err) {
            // Fallback: standard form submit
            const form = document.getElementById('statusForm');
            form.action = '<?= base_url('admin/berkas/updateStatus/') ?>' + currentPreviewBerkasId;
            form.querySelector('[name="status"]').value = status;
            form.querySelector('[name="keterangan"]').value = keterangan;
            form.submit();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFilePreview();
            closeStatusModal();
            closeBulkModal();
        }
    });

    function getSelectedIds() {
        const checkboxes = document.querySelectorAll('.berkas-checkbox:checked');
        return Array.from(checkboxes).map(cb => cb.value);
    }

    function updateBulkBar() {
        const selected = getSelectedIds();
        const bar = document.getElementById('bulkActionBar');
        const countEl = document.getElementById('selectedCount');

        countEl.textContent = selected.length;
        if (selected.length > 0) {
            bar.classList.remove('hidden');
        } else {
            bar.classList.add('hidden');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.berkas-checkbox').forEach(cb => cb.checked = false);
        updateBulkBar();
    }

    function bulkQuickAction(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        const statusLabel = {
            'valid': 'Valid',
            'invalid': 'Invalid',
            'pending': 'Pending'
        };
        if (!confirm(`Apakah Anda yakin ingin mengubah status ${ids.length} berkas menjadi ${statusLabel[status]}?`)) return;

        const form = document.getElementById('bulkForm');
        document.getElementById('bulkIds').value = ids.join(',');
        form.querySelector('[name="status"]').value = status;
        form.querySelector('[name="keterangan"]').value = '';
        form.submit();
    }

    function openBulkModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        document.getElementById('bulkIds').value = ids.join(',');
        document.getElementById('bulkModalCount').textContent = ids.length;
        document.getElementById('bulkModal').classList.remove('hidden');
    }

    function closeBulkModal() {
        document.getElementById('bulkModal').classList.add('hidden');
    }
</script>

<style>
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
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.15s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background-color: #465fff;
        border-color: #465fff;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>
<?= $this->endSection() ?>