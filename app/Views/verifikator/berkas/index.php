<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Manajemen Berkas<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">folder_managed</span> Manajemen &amp; Verifikasi Berkas
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Status Summary Cards (TailAdmin Metric Cards) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Pending Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                <span class="material-symbols-outlined text-xl">hourglass_top</span>
            </div>
            <span class="rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                Menunggu Review
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Pending</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($statusCounts['pending'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold">Perlu diperiksa</p>
        </div>
    </div>

    <!-- Valid Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-xl">task_alt</span>
            </div>
            <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                Dokumen Sesuai
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Valid</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($statusCounts['valid'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">Terverifikasi</p>
        </div>
    </div>

    <!-- Invalid Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs transition-all hover:shadow-theme-md dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                Perlu Perbaikan
            </span>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Berkas Ditolak</span>
                <h4 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($statusCounts['invalid'] ?? 0) ?></h4>
            </div>
            <p class="text-[11px] text-red-600 dark:text-red-400 font-semibold">Ditolak verifikator</p>
        </div>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Berkas Calon Siswa</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Periksa, validasi, dan unduh dokumen pendaftaran calon peserta didik.</p>
            </div>

            <form action="<?= base_url('verifikator/berkas') ?>" method="get" class="flex w-full lg:w-auto">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-symbols-outlined text-base">search</span>
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
                    <a href="<?= base_url('verifikator/berkas') ?>" class="flex items-center justify-center border border-l-0 border-red-200 bg-red-50 px-3 text-red-600 transition-colors hover:bg-red-100 rounded-r-lg dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400" title="Reset Pencarian">
                        <span class="material-symbols-outlined text-xs">close</span>
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
                                                    <span class="material-symbols-outlined text-sm text-gray-400">checklist</span>
                                                </th>
                                                <th class="py-2.5 px-3 w-1/3">Jenis Berkas</th>
                                                <th class="py-2.5 px-3 w-1/3">Nama File &amp; Waktu</th>
                                                <th class="py-2.5 px-3 text-center">Status</th>
                                                <th class="py-2.5 px-3 text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            <?php foreach ($student['berkas_list'] as $b) : 
                                                $statusVerif = $b['status_verifikasi'] ?? 'pending';
                                                if (!empty($b['path_file'])) {
                                                    $fileUrl = base_url($b['path_file']);
                                                } else {
                                                    $fileUrl = base_url('uploads/berkas/' . ($student['nisn'] ?? '') . '/' . $b['nama_file']);
                                                }
                                            ?>
                                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                                    <td class="py-2.5 px-3 text-center align-middle">
                                                        <input type="checkbox" class="berkas-checkbox h-4 w-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 cursor-pointer" value="<?= $b['id_berkas'] ?>" onclick="updateBulkBar()">
                                                    </td>
                                                    <td class="py-2.5 px-3 align-middle">
                                                        <span class="font-semibold text-gray-800 dark:text-gray-100 block"><?= esc($b['jenis_berkas']) ?></span>
                                                        <?php if (!empty($b['keterangan'])): ?>
                                                            <div class="text-[11px] text-amber-700 dark:text-amber-300 mt-1 bg-amber-50 dark:bg-amber-950/40 px-2 py-0.5 rounded-md inline-flex items-start max-w-full">
                                                                <span class="material-symbols-outlined text-xs mr-1 mt-0.5">info</span>
                                                                <span class="leading-tight"><?= esc($b['keterangan']) ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2.5 px-3 align-middle">
                                                        <span class="text-gray-600 dark:text-gray-300 truncate max-w-[150px] inline-block font-mono text-[11px]" title="<?= esc($b['nama_file']) ?>">
                                                            <?= esc($b['nama_file']) ?>
                                                        </span>
                                                        <span class="text-[10px] text-gray-400 dark:text-gray-500 block">
                                                            <?= date('d/m/y H:i', strtotime($b['created_at'])) ?>
                                                        </span>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-center align-middle">
                                                        <?php if ($statusVerif === 'valid') : ?>
                                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Valid
                                                            </span>
                                                        <?php elseif ($statusVerif === 'invalid') : ?>
                                                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Invalid
                                                            </span>
                                                        <?php else : ?>
                                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Pending
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-2.5 px-3 text-center align-middle whitespace-nowrap">
                                                        <div class="inline-flex items-center gap-1.5">
                                                            <!-- Preview Button -->
                                                            <button onclick="previewFile('<?= esc($fileUrl, 'js') ?>', '<?= esc($b['jenis_berkas']) ?> - <?= esc($student['nama_lengkap']) ?>', <?= (int)$b['id_berkas'] ?>, '<?= esc($statusVerif, 'js') ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>')"
                                                                class="p-1.5 rounded-lg text-gray-500 hover:text-brand-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                                                title="Lihat Berkas">
                                                                <span class="material-symbols-outlined text-base">visibility</span>
                                                            </button>

                                                            <!-- Verify Action Button -->
                                                            <button onclick="openVerifyModal(<?= (int)$b['id_berkas'] ?>, '<?= esc($statusVerif, 'js') ?>', '<?= esc($b['keterangan'] ?? '', 'js') ?>', '<?= esc($b['jenis_berkas'], 'js') ?>', '<?= esc($student['nama_lengkap'], 'js') ?>')"
                                                                class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition-colors"
                                                                title="Verifikasi Dokumen">
                                                                <span class="material-symbols-outlined text-base">verified</span>
                                                            </button>
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
                        <td colspan="2" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl mb-2 block">folder_off</span>
                            <p class="text-xs font-semibold">Tidak ada berkas yang ditemukan</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager) && $pager->getPageCount('berkas') > 1) : ?>
        <div class="border-t border-gray-100 p-4 dark:border-gray-800">
            <?= $pager->links('berkas', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<!-- Floating Bulk Action Bar -->
<div id="bulkBar" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white dark:bg-gray-800 px-6 py-3 rounded-2xl shadow-theme-lg flex items-center gap-4 transition-all duration-300 translate-y-24 opacity-0 z-40 border border-gray-700">
    <span class="text-xs font-semibold"><span id="selectedCount" class="font-bold text-brand-400">0</span> Berkas Terpilih</span>
    <div class="h-4 w-px bg-gray-700"></div>
    <div class="flex items-center gap-2">
        <button onclick="submitBulk('valid')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-xs">check</span> Set Valid
        </button>
        <button onclick="submitBulk('invalid')" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-lg text-xs font-semibold transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-xs">close</span> Set Invalid
        </button>
    </div>
</div>

<!-- Single Verification Modal -->
<div id="verifyModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-md w-full p-6 shadow-theme-xl border border-gray-200 dark:border-gray-800 transform transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">fact_check</span>
                <span>Verifikasi Dokumen</span>
            </h3>
            <button onclick="closeVerifyModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <div class="mb-4 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-xl border border-gray-100 dark:border-gray-800 text-xs">
            <span class="text-gray-400 block text-[10px] uppercase font-semibold">Calon Siswa / Berkas:</span>
            <span id="modalStudentName" class="font-bold text-gray-800 dark:text-gray-200 block"></span>
            <span id="modalDocType" class="text-brand-600 dark:text-brand-400 font-medium"></span>
        </div>

        <form id="verifyForm" action="" method="post">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status Validasi</label>
                    <select name="status" id="modalStatus" class="w-full h-9 rounded-lg border border-gray-200 bg-white px-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                        <option value="pending">Pending (Menunggu)</option>
                        <option value="valid">Valid (Disetujui)</option>
                        <option value="invalid">Invalid (Ditolak / Salah)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan / Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="modalKeterangan" rows="3" placeholder="Contoh: File buram, mohon upload ulang scan asli..." class="w-full rounded-lg border border-gray-200 bg-white p-3 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 placeholder:text-gray-400"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2.5">
                <button type="button" onclick="closeVerifyModal()" class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-xs font-bold text-white shadow-theme-xs transition-colors">
                    Simpan Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-black/85 z-[99999] hidden flex items-center justify-center p-4 backdrop-blur-md" onclick="if(event.target === this) closePreviewModal()">
    <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-5xl w-full h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-800">
        <!-- Header -->
        <div class="px-5 py-3.5 border-b border-gray-200 dark:border-gray-800 flex flex-wrap items-center justify-between gap-3 bg-gray-50/90 dark:bg-gray-900/90">
            <div class="flex items-center gap-3 min-w-0 max-w-full sm:max-w-[45%]">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">description</span>
                </div>
                <div class="min-w-0">
                    <h3 id="previewTitle" class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white truncate"></h3>
                    <span id="previewStatusBadge" class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold"></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2 ml-auto">
                <button type="button" onclick="previewActionUpdateVerif('valid')"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-[0.97] text-white px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span>Setujui</span>
                </button>

                <button type="button" onclick="previewActionUpdateVerif('invalid')"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-red-600 hover:bg-red-700 active:scale-[0.97] text-white px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer">
                    <span class="material-symbols-outlined text-sm">cancel</span>
                    <span>Tolak</span>
                </button>

                <div class="h-6 w-px bg-gray-300 dark:bg-gray-700 hidden sm:block mx-1"></div>

                <a id="previewDownloadLink" href="#" download
                    class="inline-flex items-center gap-1.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-3.5 py-2 text-xs font-semibold transition-all shadow-theme-xs active:scale-[0.97]">
                    <span class="material-symbols-outlined text-sm">download</span>
                    <span class="hidden sm:inline">Unduh</span>
                </a>

                <button type="button" onclick="closePreviewModal()"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-3.5 py-2 text-xs font-bold transition-all shadow-theme-xs cursor-pointer active:scale-[0.97]">
                    <span class="material-symbols-outlined text-sm">close</span>
                    <span class="hidden sm:inline">Tutup</span>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="flex-1 bg-gray-100 dark:bg-gray-950 flex items-center justify-center p-3 overflow-hidden">
            <iframe id="previewFrame" src="" class="w-full h-full rounded-xl border-0 hidden bg-white"></iframe>
            <img id="previewImage" src="" class="max-w-full max-h-full object-contain rounded-xl shadow-lg hidden" />
        </div>
    </div>
</div>

<script>
    let currentVerifPreviewId = null;
    let currentVerifPreviewStatus = null;
    let currentVerifPreviewKeterangan = '';

    function updateVerifPreviewBadge(status) {
        const badge = document.getElementById('previewStatusBadge');
        if (!badge) return;
        if (status === 'valid') {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30';
            badge.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Valid (Disetujui)';
        } else if (status === 'invalid') {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-500/30';
            badge.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Invalid (Ditolak)';
        } else {
            badge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30';
            badge.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Pending (Menunggu)';
        }
    }

    function openVerifyModal(id, status, keterangan, docType, studentName) {
        document.getElementById('verifyForm').action = '<?= base_url('verifikator/berkas/updateStatus') ?>/' + id;
        document.getElementById('modalStatus').value = status;
        document.getElementById('modalKeterangan').value = keterangan;
        document.getElementById('modalDocType').textContent = docType;
        document.getElementById('modalStudentName').textContent = studentName;
        document.getElementById('verifyModal').classList.remove('hidden');
    }

    function closeVerifyModal() {
        document.getElementById('verifyModal').classList.add('hidden');
    }

    function previewFile(url, title, id, status, keterangan) {
        currentVerifPreviewId = id || null;
        currentVerifPreviewStatus = status || 'pending';
        currentVerifPreviewKeterangan = keterangan || '';

        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewDownloadLink').href = url;
        updateVerifPreviewBadge(currentVerifPreviewStatus);

        const frame = document.getElementById('previewFrame');
        const img = document.getElementById('previewImage');
        
        if (url.toLowerCase().endsWith('.pdf')) {
            frame.src = url;
            frame.classList.remove('hidden');
            img.classList.add('hidden');
        } else {
            img.src = url;
            img.classList.remove('hidden');
            frame.classList.add('hidden');
        }
        
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.add('hidden');
        document.getElementById('previewFrame').src = '';
        document.getElementById('previewImage').src = '';
        currentVerifPreviewId = null;
    }

    async function previewActionUpdateVerif(status) {
        if (!currentVerifPreviewId) return;

        let keterangan = currentVerifPreviewKeterangan;

        if (status === 'invalid') {
            const { value: note, isConfirmed } = await Swal.fire({
                title: 'Tolak Berkas Ini?',
                text: 'Berikan alasan / catatan perbaikan untuk calon siswa (opsional):',
                input: 'textarea',
                inputValue: keterangan || '',
                inputPlaceholder: 'Contoh: Dokumen buram atau halaman tidak lengkap...',
                showCancelButton: true,
                confirmButtonText: 'Tolak Berkas',
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
                confirmButtonText: 'Ya, Setujui',
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

        const formData = new FormData();
        formData.append('status', status);
        formData.append('keterangan', keterangan);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        try {
            const res = await fetch('<?= base_url('verifikator/berkas/updateStatus/') ?>' + currentVerifPreviewId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const data = await res.json();

            if (data.success) {
                currentVerifPreviewStatus = status;
                currentVerifPreviewKeterangan = keterangan;
                updateVerifPreviewBadge(status);

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
            const form = document.getElementById('verifyForm');
            form.action = '<?= base_url('verifikator/berkas/updateStatus/') ?>' + currentVerifPreviewId;
            form.querySelector('[name="status"]').value = status;
            form.querySelector('[name="keterangan"]').value = keterangan;
            form.submit();
        }
    }


    function updateBulkBar() {
        const checked = document.querySelectorAll('.berkas-checkbox:checked');
        const bar = document.getElementById('bulkBar');
        document.getElementById('selectedCount').textContent = checked.length;
        
        if (checked.length > 0) {
            bar.classList.remove('translate-y-24', 'opacity-0');
        } else {
            bar.classList.add('translate-y-24', 'opacity-0');
        }
    }

    function submitBulk(status) {
        const checked = document.querySelectorAll('.berkas-checkbox:checked');
        if (checked.length === 0) return;
        
        const ids = Array.from(checked).map(c => c.value);
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('verifikator/berkas/bulkUpdateStatus') ?>';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = '<?= csrf_hash() ?>';
        form.appendChild(csrf);
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        form.appendChild(statusInput);
        
        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
</script>

<?= $this->endSection() ?>