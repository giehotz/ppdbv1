<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Siswa Pindahan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">swap_horiz</span> Daftar Siswa Pindahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$rows   = $siswa ?? $siswaList ?? [];
$sort   = $sortBy ?? 'ASC';
$tabBase = base_url('verifikator/pindahan') . '?th_pelajaran=' . urlencode($selectedTh ?? '') . '&search=' . urlencode($search ?? '');
$no     = 0;
?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Siswa Pindahan</h3>
                    <?php if (!empty($activeTh)) : ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white shadow-sm ring-2 ring-emerald-500/20 dark:bg-emerald-500 dark:text-gray-950">
                            <span class="material-symbols-outlined text-[12px]">calendar_check</span>
                            TP: <?= esc($activeTh) ?> (Aktif)
                        </span>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola pendaftaran, kelengkapan biodata, dan verifikasi siswa pindahan.</p>
            </div>

            <form action="<?= base_url('verifikator/pindahan') ?>" method="get" class="inline-flex items-center gap-2 shrink-0 flex-wrap">
                <input type="hidden" name="tab" value="<?= esc($currentTab ?? 'all') ?>">

                <!-- Filter Tahun Pelajaran -->
                <select name="th_pelajaran" onchange="this.form.submit()"
                        class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 cursor-pointer shrink-0">
                    <?php foreach (($tahunList ?? []) as $t) : ?>
                        <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= (($selectedTh ?? $activeTh) === $t['tahun_pelajaran']) ? 'selected' : '' ?>>
                            TP: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '(Aktif)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="all" <?= (($selectedTh ?? '') === 'all') ? 'selected' : '' ?>>Semua Tahun Pelajaran</option>
                </select>

                <div class="inline-flex items-center h-9 rounded-lg border border-gray-200 bg-gray-50/50 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/50 overflow-hidden focus-within:border-brand-500 shrink-0">
                    <div class="pl-3 text-gray-400 pointer-events-none">
                        <span class="material-symbols-outlined text-sm">search</span>
                    </div>
                    <input type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Cari No. Daftar, NISN, Nama, Sekolah..."
                        class="h-full w-40 sm:w-60 bg-transparent py-1.5 px-2.5 text-xs text-gray-800 placeholder:text-gray-400 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder:text-gray-500">
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('verifikator/pindahan') ?>?th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
                           class="flex items-center justify-center h-full px-2 text-gray-400 hover:text-red-500 transition-colors"
                           title="Reset Pencarian">
                            <span class="material-symbols-outlined text-xs">close</span>
                        </a>
                    <?php endif; ?>
                    <button type="submit"
                            class="inline-flex items-center justify-center h-full bg-gray-900 px-3.5 text-xs font-semibold text-white transition-colors hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 shrink-0">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($selectedTh) && $selectedTh !== $activeTh && $selectedTh !== 'all') : ?>
            <div class="mt-3 px-3 py-2 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-lg flex items-center justify-between text-xs text-amber-800 dark:text-amber-300">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">inventory_2</span>
                    <span>Anda sedang melihat <strong>Arsip Riwayat TP <?= esc($selectedTh) ?></strong> (bukan tahun pelajaran aktif).</span>
                </div>
                <a href="<?= base_url('verifikator/pindahan') ?>" class="font-bold underline hover:text-amber-900">Kembali ke TP Aktif (<?= esc($activeTh) ?>)</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Status Filter Tabs / Pills -->
    <div class="border-b border-gray-100 px-5 py-3 dark:border-gray-800 bg-gray-50/40 dark:bg-gray-800/20 flex flex-wrap items-center gap-2">
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 mr-1 flex items-center gap-1.5">
            <span class="material-symbols-outlined text-sm">filter_list</span> Status:
        </span>

        <?php
        $tabs = [
            'all' => [
                'label' => 'Semua',
                'count' => $statusCounts['all'] ?? 0,
                'badgeClass' => 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                'activeClass' => 'bg-gray-900 text-white dark:bg-white dark:text-gray-900 shadow-sm',
            ],
            'menunggu' => [
                'label' => 'Menunggu Verifikasi',
                'count' => $statusCounts['menunggu'] ?? 0,
                'badgeClass' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-200',
                'activeClass' => 'bg-amber-500 text-white shadow-sm',
            ],
            'incomplete' => [
                'label' => 'Biodata Belum Lengkap',
                'count' => $statusCounts['incomplete'] ?? 0,
                'badgeClass' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/60 dark:text-rose-200',
                'activeClass' => 'bg-rose-500 text-white shadow-sm',
            ],
            'terverifikasi' => [
                'label' => 'Terverifikasi',
                'count' => $statusCounts['terverifikasi'] ?? 0,
                'badgeClass' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200',
                'activeClass' => 'bg-emerald-600 text-white shadow-sm',
            ],
            'ditolak' => [
                'label' => 'Ditolak',
                'count' => $statusCounts['ditolak'] ?? 0,
                'badgeClass' => 'bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200',
                'activeClass' => 'bg-red-600 text-white shadow-sm',
            ],
        ];
        ?>

        <?php foreach ($tabs as $k => $t) : ?>
            <?php $isActive = (($currentTab ?? 'all') === $k); ?>
            <a href="<?= $tabBase ?>&tab=<?= $k ?>"
               class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium transition-all <?= $isActive ? $t['activeClass'] : 'bg-white dark:bg-gray-800/80 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/40' ?>">
                <span><?= $t['label'] ?></span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] font-bold <?= $isActive ? 'bg-white/25 text-inherit' : $t['badgeClass'] ?>">
                    <?= number_format($t['count']) ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-3 text-center w-10">No</th>
                    <th class="py-3.5 px-5">No. Pendaftaran</th>
                    <th class="py-3.5 px-5">NISN</th>
                    <th class="py-3.5 px-5">Nama</th>
                    <th class="py-3.5 px-5">Jenjang Asal</th>
                    <th class="py-3.5 px-5">Kelengkapan</th>
                    <th class="py-3.5 px-5">Status</th>
                    <th class="py-3.5 px-5">Tanggal</th>
                    <th class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($rows as $s) :
                        $no++;
                        $inisial = mb_substr(trim($s['nama_lengkap'] ?? ''), 0, 1);
                        if (empty($inisial)) $inisial = 'S';
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <!-- No -->
                            <td class="py-3.5 px-3 text-center text-gray-400 font-medium"><?= $no ?></td>

                            <!-- No. Pendaftaran -->
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex rounded-lg bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran'] ?? '-') ?>
                                </span>
                            </td>

                            <!-- NISN -->
                            <td class="py-3.5 px-5 whitespace-nowrap font-mono text-gray-600 dark:text-gray-300">
                                <?= esc($s['nisn'] ?? '-') ?>
                            </td>

                            <!-- Nama -->
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= esc($inisial) ?>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('verifikator/pindahan/detail/' . $s['id_pindahan']) ?>" class="font-bold text-gray-900 dark:text-white hover:text-brand-500 dark:hover:text-brand-400 transition-colors block">
                                            <?= esc($s['nama_lengkap'] ?? '-') ?>
                                        </a>
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500">
                                            <?= esc($s['email'] ?? '') ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Jenjang Asal -->
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                        <?= esc($s['jenjang_sekolah_asal'] ?? '-') ?>
                                    </span>
                                </div>
                            </td>

                            <!-- Kelengkapan -->
                            <td class="py-3.5 px-5 min-w-[140px]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                                        <div class="<?= ($s['kelengkapan'] ?? 0) == 100 ? 'bg-emerald-500' : (($s['kelengkapan'] ?? 0) >= 50 ? 'bg-brand-500' : 'bg-amber-500') ?> h-2 rounded-full transition-all" style="width: <?= esc($s['kelengkapan'] ?? 0, 'attr') ?>%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold <?= ($s['kelengkapan'] ?? 0) == 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' ?>">
                                        <?= esc($s['kelengkapan'] ?? 0) ?>%
                                    </span>
                                </div>
                            </td>

                            <!-- Status Validasi -->
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <?php if (($s['status_verifikasi'] ?? '') === 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                    </span>
                                <?php elseif (($s['status_verifikasi'] ?? '') === 'Ditolak') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Tanggal -->
                            <td class="py-3.5 px-5 whitespace-nowrap text-gray-500 dark:text-gray-400 font-medium">
                                <?= !empty($s['tgl_pindahan']) && strtotime($s['tgl_pindahan']) ? date('d/m/Y', strtotime($s['tgl_pindahan'])) : '-' ?>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <form action="<?= base_url('impersonate/start-pindahan/' . $s['id_pindahan']) ?>" method="POST" class="inline m-0 p-0">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-500/15 transition-colors focus:outline-none"
                                            title="Login sebagai Siswa Pindahan (Menyamar)">
                                            <span class="material-symbols-outlined text-base">switch_account</span>
                                        </button>
                                    </form>
                                    <a href="<?= base_url('verifikator/pindahan/detail/' . $s['id_pindahan']) ?>"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/15 transition-colors"
                                        title="Detail &amp; Verifikasi">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                    <a href="<?= base_url('verifikator/pindahan/cetak-akun/' . $s['id_pindahan']) ?>" target="_blank"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/15 transition-colors"
                                        title="Cetak Akun (Slip)">
                                        <span class="material-symbols-outlined text-base">print</span>
                                    </a>
                                    <form action="<?= base_url('verifikator/pindahan/delete/' . $s['id_pindahan']) ?>" method="post"
                                          onsubmit="return confirm('Yakin ingin menghapus data siswa pindahan ini beserta seluruh berkasnya secara permanen?');"
                                          class="inline m-0 p-0">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="p-1.5 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/15 transition-colors"
                                            title="Hapus Siswa Pindahan">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="py-12 px-5 text-center text-gray-400 dark:text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300 dark:text-gray-600">swap_horiz</span>
                                <?php if (!empty($search)) : ?>
                                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pencarian Tidak Ditemukan</p>
                                    <p class="text-xs text-gray-400">Tidak ada siswa pindahan dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('verifikator/pindahan') ?>" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-600 dark:text-brand-400 hover:underline">
                                        <span class="material-symbols-outlined text-xs">refresh</span> Reset Pencarian
                                    </a>
                                <?php else : ?>
                                    <p class="text-xs font-semibold text-gray-500">Belum ada siswa pindahan.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($rows) && isset($pager)) : ?>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900/50 flex flex-col sm:flex-row justify-between items-center gap-3">
            <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data siswa pindahan.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>