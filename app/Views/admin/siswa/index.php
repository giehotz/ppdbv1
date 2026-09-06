<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<div class="flex items-center gap-3 flex-wrap">
    <span>Calon Siswa</span>
    <?php if (!empty($activeTh)): ?>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-sm ring-2 ring-emerald-500/20 dark:bg-emerald-500 dark:text-gray-950">
            <i class="fas fa-calendar-check text-xs"></i>
            <span>TP: <?= esc($activeTh) ?> ★ (Aktif)</span>
        </span>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('print_password')) : ?>
    <?php session()->keepFlashdata('print_password'); ?>
    <script>
        window.open('<?= base_url('admin/siswa/cetak-password') ?>', '_blank');
    </script>
<?php endif; ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Calon Siswa</h3>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data pendaftaran, kelengkapan berkas, verifikasi, dan pembiayaan siswa.</p>
                <div class="flex flex-wrap items-center gap-2.5 w-full xl:w-auto">
                <button type="button"
                   onclick="confirmResetThrottle('<?= base_url('admin/siswa/reset-throttle') ?>')"
                   class="inline-flex items-center justify-center gap-1.5 h-9 rounded-lg border border-amber-200 bg-amber-50 px-3 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 transition-colors shadow-theme-xs shrink-0"
                   title="Reset batas waktu 15 menit login jika ada akun/IP terkunci">
                    <i class="fas fa-unlock-alt text-xs"></i>
                    <span>Reset Batas Waktu Login</span>
                </button>

                <a href="<?= base_url('admin/siswa/export-excel') ?>?th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
                   class="inline-flex items-center justify-center gap-2 h-9 rounded-lg bg-emerald-600 px-4 text-xs font-semibold text-white shadow-theme-xs transition-all hover:bg-emerald-700 shrink-0">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>

                <form action="<?= base_url('admin/siswa') ?>" method="get" class="inline-flex items-center gap-2 shrink-0">
                    <input type="hidden" name="sort" value="<?= esc($sort ?? 'ASC') ?>">
                    <input type="hidden" name="tab" value="<?= esc($currentTab ?? 'all') ?>">
                    
                    <!-- Filter Tahun Pelajaran -->
                    <select name="th_pelajaran" onchange="this.form.submit()"
                            class="h-9 rounded-lg border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-700 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 cursor-pointer shrink-0">
                        <?php foreach (($tahunList ?? []) as $t): ?>
                            <option value="<?= esc($t['tahun_pelajaran']) ?>" <?= ($selectedTh === $t['tahun_pelajaran']) ? 'selected' : '' ?>>
                                TP: <?= esc($t['tahun_pelajaran']) ?> <?= ($t['status'] === 'Aktif') ? '★ (Aktif)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="all" <?= ($selectedTh === 'all') ? 'selected' : '' ?>>Semua Tahun Pelajaran</option>
                    </select>

                    <!-- Integrated Search Bar -->
                    <div class="inline-flex items-center h-9 rounded-lg border border-gray-200 bg-gray-50/50 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900/50 overflow-hidden focus-within:border-brand-500 shrink-0">
                        <div class="pl-3 text-gray-400 pointer-events-none">
                            <i class="fas fa-search text-xs"></i>
                        </div>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="h-full w-40 sm:w-56 bg-transparent py-1.5 px-2.5 text-xs text-gray-800 placeholder:text-gray-400 border-none outline-none focus:outline-none focus:ring-0 dark:text-gray-100 dark:placeholder:text-gray-500">
                        <?php if (!empty($search)) : ?>
                            <a href="<?= base_url('admin/siswa') ?>?th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
                               class="flex items-center justify-center h-full px-2 text-gray-400 hover:text-red-500 transition-colors"
                               title="Reset Pencarian">
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        <?php endif; ?>
                        <button type="submit"
                                class="inline-flex items-center justify-center h-full bg-gray-900 px-3.5 text-xs font-semibold text-white transition-colors hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 shrink-0">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
            </div>

            
        </div>

        <?php if (!empty($selectedTh) && $selectedTh !== $activeTh && $selectedTh !== 'all'): ?>
            <div class="mt-3 px-3 py-2 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-lg flex items-center justify-between text-xs text-amber-800 dark:text-amber-300">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">inventory_2</span>
                    <span>Anda sedang melihat <strong>Arsip Riwayat TP <?= esc($selectedTh) ?></strong> (bukan tahun pelajaran aktif).</span>
                </div>
                <a href="<?= base_url('admin/siswa') ?>" class="font-bold underline hover:text-amber-900">Kembali ke TP Aktif (<?= esc($activeTh) ?>)</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Status Filter Tabs / Pills -->
    <div class="border-b border-gray-100 px-5 py-3 dark:border-gray-800 bg-gray-50/40 dark:bg-gray-800/20 flex flex-wrap items-center gap-2">
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 mr-1 flex items-center gap-1.5">
            <i class="fas fa-filter text-[10px]"></i> Status:
        </span>
        
        <?php
        $baseFilterUrl = base_url('admin/siswa') . '?th_pelajaran=' . urlencode($selectedTh ?? '') . '&search=' . urlencode($search ?? '') . '&sort=' . esc($sort ?? 'ASC');
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

        <?php foreach ($tabs as $k => $t): ?>
            <?php $isActive = (($currentTab ?? 'all') === $k); ?>
            <a href="<?= $baseFilterUrl ?>&tab=<?= $k ?>"
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
                    <th class="py-3.5 px-3 text-center w-10">
                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)"
                               class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 cursor-pointer"
                               title="Pilih Semua di Halaman Ini">
                    </th>
                    <th class="py-3.5 px-3 text-center w-10">No</th>
                    <th class="py-3.5 px-4">No. Pendaftaran</th>
                    <th class="py-3.5 px-4">NISN</th>
                    <th class="py-3.5 px-4">Nama Lengkap</th>
                    <th class="py-3.5 px-4">Gender</th>
                    <th class="py-3.5 px-4">Kelengkapan</th>
                    <th class="py-3.5 px-4">Status Validasi</th>
                    <th class="py-3.5 px-4">Status Tagihan</th>
                    <th class="py-3.5 px-4">
                        <a href="<?= base_url('admin/siswa') ?>?search=<?= esc($search ?? '') ?>&sort=<?= ($sort ?? 'ASC') == 'ASC' ? 'DESC' : 'ASC' ?>&th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
                           class="flex items-center hover:text-brand-500 transition-colors whitespace-nowrap"
                           title="Klik untuk mengurutkan">
                            Tanggal Daftar
                            <?php if(($sort ?? 'ASC') == 'ASC'): ?>
                                <i class="fas fa-sort-up ml-1.5 text-brand-500 mt-1"></i>
                            <?php else: ?>
                                <i class="fas fa-sort-down ml-1.5 text-brand-500 mb-1"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th class="py-3.5 px-4 text-center w-36 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($siswa)) : ?>
                    <?php $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; ?>
                    <?php $nomor = 1 + (20 * ($page - 1)); ?>
                    <?php foreach ($siswa as $s) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]" id="row-<?= $s['id_siswa'] ?>">
                            <td class="py-3 px-3 text-center">
                                <input type="checkbox" class="siswa-checkbox h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 cursor-pointer"
                                       value="<?= $s['id_siswa'] ?>"
                                       data-name="<?= esc($s['nama_lengkap']) ?>"
                                       onchange="updateBulkBar()">
                            </td>
                            <td class="py-3 px-3 text-center text-gray-400 dark:text-gray-500 font-medium"><?= $nomor++ ?></td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <span class="inline-flex rounded-md bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap font-mono text-gray-600 dark:text-gray-400"><?= esc($s['nisn'] ?? '-') ?></td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2.5">
                                    <?php if (!empty($s['foto_url'])): ?>
                                        <img src="<?= $s['foto_url'] ?>" alt="" class="h-7 w-7 rounded-full object-cover border border-gray-200 dark:border-gray-700 shrink-0" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                                        <div class="hidden h-7 w-7 rounded-full bg-brand-50 text-brand-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-xs shrink-0 font-bold">
                                            <?= mb_substr($s['nama_lengkap'], 0, 1) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="h-7 w-7 rounded-full bg-brand-50 text-brand-600 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700 flex items-center justify-center text-xs shrink-0 font-bold">
                                            <?= mb_substr($s['nama_lengkap'], 0, 1) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="min-w-0">
                                        <a href="javascript:void(0)" onclick="openQuickDetail('<?= $s['id_siswa'] ?>')" class="font-semibold text-gray-900 dark:text-gray-100 hover:text-brand-500 dark:hover:text-brand-400 transition-colors truncate block max-w-[180px]" title="Klik untuk Quick Preview">
                                            <?= esc($s['nama_lengkap']) ?>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <?= $s['jk'] == 'L'
                                    ? '<span class="inline-flex items-center gap-1 font-semibold text-blue-600 dark:text-blue-400"><i class="fas fa-mars text-xs"></i> L</span>'
                                    : '<span class="inline-flex items-center gap-1 font-semibold text-pink-600 dark:text-pink-400"><i class="fas fa-venus text-xs"></i> P</span>' ?>
                            </td>
                            <td class="py-3 px-4 min-w-[130px]">
                                <div class="flex items-center gap-2">
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                                        <div class="<?= $s['kelengkapan'] == 100 ? 'bg-emerald-500' : ($s['kelengkapan'] >= 50 ? 'bg-brand-500' : 'bg-red-500') ?> h-2 rounded-full transition-all"
                                             style="width: <?= esc($s['kelengkapan']) ?>%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-600 dark:text-gray-400"><?= esc($s['kelengkapan']) ?>%</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] == 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        <i class="fas fa-check-circle text-[10px]"></i> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] == 'Ditolak') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                        <i class="fas fa-times-circle text-[10px]"></i> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                        <i class="fas fa-clock text-[10px]"></i> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                <a href="<?= base_url('admin/pembiayaan/siswa/' . $s['id_siswa']) ?>" class="group inline-flex flex-col items-start hover:opacity-85 transition-opacity" title="Klik untuk kelola pembiayaan siswa">
                                    <?php if (($s['status_pembiayaan'] ?? '') === 'lunas'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40">
                                            <i class="fas fa-check-circle text-[10px]"></i> Lunas
                                        </span>
                                        <span class="text-[10px] text-gray-400 group-hover:text-brand-500 mt-0.5">Rp <?= number_format($s['total_bayar'] ?? 0, 0, ',', '.') ?></span>
                                    <?php elseif (($s['status_pembiayaan'] ?? '') === 'sebagian'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/40">
                                            <i class="fas fa-hourglass-half text-[10px]"></i> Sisa Rp <?= number_format($s['sisa_tagihan'] ?? 0, 0, ',', '.') ?>
                                        </span>
                                        <span class="text-[10px] text-gray-400 group-hover:text-brand-500 mt-0.5">Masuk: Rp <?= number_format($s['total_bayar'] ?? 0, 0, ',', '.') ?></span>
                                    <?php elseif (($s['status_pembiayaan'] ?? '') === 'belum'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-0.5 text-[11px] font-semibold text-rose-700 dark:bg-rose-500/15 dark:text-rose-400 border border-rose-200 dark:border-rose-800/40">
                                            <i class="fas fa-exclamation-circle text-[10px]"></i> Belum Bayar
                                        </span>
                                        <span class="text-[10px] text-gray-400 group-hover:text-brand-500 mt-0.5">Total: Rp <?= number_format($s['total_tagihan'] ?? 0, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            Belum Ditagih
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-500 dark:text-gray-400 text-[11px]">
                                <?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- WhatsApp -->
                                    <button type="button"
                                        onclick="openWhatsAppModal('<?= $s['id_siswa'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= esc(addslashes($s['no_pendaftaran'])) ?>', '<?= esc($s['no_hp_siswa'] ?? '') ?>', '<?= esc($s['no_hp_ortu'] ?? '') ?>')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-emerald-600 hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-emerald-500/15 transition-colors focus:outline-none"
                                        title="Kirim Pesan WhatsApp">
                                        <i class="fab fa-whatsapp text-xs font-bold"></i>
                                    </button>

                                    <!-- Quick Preview -->
                                    <button type="button"
                                        onclick="openQuickDetail('<?= $s['id_siswa'] ?>')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-500/15 transition-colors focus:outline-none"
                                        title="Quick Preview">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>

                                    <!-- Login Siswa (Impersonate) -->
                                    <form action="<?= base_url('impersonate/start/' . $s['id_siswa']) ?>" method="POST" class="inline m-0 p-0">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg text-amber-600 hover:bg-amber-50 hover:text-amber-700 dark:text-amber-400 dark:hover:bg-amber-500/15 transition-colors focus:outline-none"
                                            title="Login sebagai Siswa (Impersonate)">
                                            <i class="fas fa-user-secret text-xs"></i>
                                        </button>
                                    </form>

                                    <!-- More Actions Dropdown (Titik Tiga) -->
                                    <div class="relative inline-block text-left">
                                        <button type="button"
                                            onclick="toggleActionMenu(event, 'actionMenu-<?= $s['id_siswa'] ?>')"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors focus:outline-none"
                                            title="Pilihan Aksi Lainnya">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>

                                        <!-- Dropdown Menu Content -->
                                        <div id="actionMenu-<?= $s['id_siswa'] ?>"
                                             class="student-action-menu hidden absolute right-0 mt-1.5 w-48 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50 text-left divide-y divide-gray-100 dark:divide-gray-800">
                                            <div class="py-1">
                                                <a href="<?= base_url('admin/siswa/detail/' . $s['id_siswa']) ?>"
                                                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                    <i class="fas fa-id-badge text-gray-400 w-4 text-center"></i>
                                                    <span>Detail Lengkap</span>
                                                </a>
                                                <a href="<?= base_url('admin/pembiayaan/siswa/' . $s['id_siswa']) ?>"
                                                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-emerald-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                    <i class="fas fa-wallet text-gray-400 w-4 text-center"></i>
                                                    <span>Kelola Pembiayaan</span>
                                                </a>
                                            </div>

                                            <div class="py-1">
                                                <a href="<?= base_url('admin/siswa/cetak/' . $s['id_siswa']) ?>" target="_blank"
                                                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-emerald-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                    <i class="fas fa-print text-gray-400 w-4 text-center"></i>
                                                    <span>Cetak Formulir</span>
                                                </a>
                                                <a href="<?= base_url('admin/siswa/cetak-kartu/' . $s['id_siswa']) ?>" target="_blank"
                                                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-purple-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                    <i class="fas fa-id-card text-gray-400 w-4 text-center"></i>
                                                    <span>Cetak Kartu</span>
                                                </a>
                                            </div>

                                            <div class="py-1">
                                                <button type="button"
                                                    onclick="openResetPasswordModal('<?= $s['id_siswa'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>')"
                                                    class="w-full flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-amber-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors text-left">
                                                    <i class="fas fa-key text-gray-400 w-4 text-center"></i>
                                                    <span>Reset Password</span>
                                                </button>
                                            </div>

                                            <div class="py-1">
                                                <button type="button"
                                                    onclick="openDeleteModal('<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= base_url('admin/siswa/delete/' . $s['id_siswa']) ?>')"
                                                    class="w-full flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30 transition-colors text-left">
                                                    <i class="fas fa-trash-alt text-red-500 w-4 text-center"></i>
                                                    <span>Hapus Siswa</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Empty State -->
                    <tr>
                        <td colspan="11" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                <?php if (!empty($search)) : ?>
                                    <i class="fas fa-search-minus text-4xl mb-3 text-gray-300 dark:text-gray-700"></i>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Pencarian Tidak Ditemukan</p>
                                    <p class="text-xs mt-0.5">Tidak ada siswa dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('admin/siswa') ?>" class="mt-3 text-xs font-semibold text-brand-500 hover:underline">Clear Pencarian</a>
                                <?php else : ?>
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300 dark:text-gray-700"></i>
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Data</p>
                                    <p class="text-xs mt-0.5">Belum ada calon siswa pada kriteria filter ini.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($siswa)) : ?>
        <div class="border-t border-gray-100 px-5 py-3.5 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex flex-col sm:flex-row justify-between items-center gap-3">
            <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data calon peserta didik.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Floating Bulk Action Bar -->
<div id="bulkActionBar" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 hidden transition-all duration-300 transform translate-y-10 opacity-0">
    <div class="flex items-center gap-3 bg-gray-900/95 dark:bg-gray-800/95 backdrop-blur-md text-white px-5 py-3 rounded-2xl shadow-2xl border border-gray-700/50">
        <div class="flex items-center gap-2 pr-3 border-r border-gray-700">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white" id="selectedCountBadge">0</span>
            <span class="text-xs font-semibold text-gray-200 whitespace-nowrap">Siswa Terpilih</span>
        </div>

        <div class="flex items-center gap-2">
            <!-- Verifikasi Massal -->
            <button type="button" onclick="openBulkVerifyModal()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                <i class="fas fa-check-double text-xs"></i>
                <span>Verifikasi Massal</span>
            </button>

            <!-- Cetak Kartu Massal -->
            <button type="button" onclick="executeBulkPrintCards()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                <i class="fas fa-id-card text-xs"></i>
                <span>Cetak Kartu</span>
            </button>

            <!-- Hapus Massal -->
            <button type="button" onclick="openBulkDeleteModal()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-600 hover:bg-red-500 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                <i class="fas fa-trash-alt text-xs"></i>
                <span>Hapus Terpilih</span>
            </button>

            <!-- Deselect All -->
            <button type="button" onclick="clearSelection()"
                    class="p-1.5 rounded-xl text-gray-400 hover:text-white hover:bg-gray-800 transition-colors ml-1"
                    title="Batalkan Pilihan">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
</div>

<!-- WhatsApp Modal -->
<div id="whatsappModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeWhatsAppModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="whatsappModalContent">
            <div class="border-b border-emerald-100 bg-emerald-50/70 px-6 py-4 dark:border-emerald-950 dark:bg-emerald-950/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Kirim Pesan WhatsApp</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="waStudentHeader">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeWhatsAppModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- Target Penerima -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Tujuan Nomor WhatsApp</label>
                    <div class="grid grid-cols-2 gap-2" id="waRecipientOptions">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Template Pesan Cepat -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Template Pesan</label>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="applyWaTemplate('berkas')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            📑 Kelengkapan Berkas
                        </button>
                        <button type="button" onclick="applyWaTemplate('verif')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            ✅ Verifikasi Diterima
                        </button>
                        <button type="button" onclick="applyWaTemplate('ditolak')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            ⚠️ Perbaikan Berkas
                        </button>
                        <button type="button" onclick="applyWaTemplate('keuangan')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            💳 Tagihan Pembiayaan
                        </button>
                    </div>
                </div>

                <!-- Textarea Pesan -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi Pesan (Bisa Diedit)</label>
                    <textarea id="waMessageText" rows="6" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-3 text-xs text-gray-900 focus:border-emerald-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/60 dark:text-white" placeholder="Ketik pesan..."></textarea>
                </div>
            </div>

            <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                <button type="button" onclick="closeWhatsAppModal()"
                    class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="sendWhatsAppNow()"
                    class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i> Buka WhatsApp Web / App
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Detail Preview Modal -->
<div id="quickDetailModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeQuickDetail()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-3xl max-h-[90vh] rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 flex flex-col overflow-hidden" id="quickDetailContent">
            <!-- Header -->
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <img id="qdPhoto" src="" alt="Foto" class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm dark:border-gray-700">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white" id="qdNama">-</h3>
                            <span id="qdStatusVerifBadge"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="qdSubheader">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeQuickDetail()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 text-xs flex-grow" id="qdBody">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left: Biodata & Kelengkapan -->
                    <div class="space-y-4">
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/20 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-brand-500"></i> Biodata Calon Siswa
                            </h4>
                            <dl class="space-y-2 text-xs">
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">NISN / NIK</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100 font-mono" id="qdNisnNik">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Jenis Kelamin</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdJk">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Tempat, Tgl Lahir</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdTTL">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Asal Sekolah</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdSekolah">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100 text-right max-w-[200px]" id="qdAlamat">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Orang Tua (Ayah/Ibu)</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdOrtu">-</dd>
                                </div>
                                <div class="flex justify-between py-1">
                                    <dt class="text-gray-500">No. HP Siswa / Ortu</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdHp">-</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Progress Kelengkapan -->
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Kelengkapan Biodata</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-white" id="qdKelengkapanPercent">0%</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 mb-2">
                                <div id="qdKelengkapanBar" class="h-2 rounded-full bg-brand-500 transition-all" style="width: 0%"></div>
                            </div>
                            <div id="qdMissingFields" class="text-[11px] text-rose-500 hidden">
                                Belum diisi: <span id="qdMissingList" class="font-medium"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Verifikasi, Keuangan, Berkas -->
                    <div class="space-y-4">
                        <!-- Quick Verifikasi Form -->
                        <div class="rounded-xl border border-brand-200/60 bg-brand-50/20 dark:border-brand-900/40 dark:bg-brand-950/20 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-1.5">
                                <i class="fas fa-check-shield text-brand-500"></i> Verifikasi Cepat
                            </h4>
                            <form id="qdVerifyForm" onsubmit="submitQuickVerify(event)">
                                <input type="hidden" id="qdStudentId" name="id">
                                <div class="space-y-2.5">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Ubah Status</label>
                                        <select id="qdStatusSelect" name="status" class="w-full h-8 rounded-lg border border-gray-200 bg-white px-2.5 text-xs font-semibold text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                                            <option value="Terverifikasi">Terverifikasi</option>
                                            <option value="Menunggu">Menunggu</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Catatan Verifikasi</label>
                                        <input type="text" id="qdCatatanInput" name="catatan" placeholder="Opsional (misal: Berkas valid)" class="w-full h-8 rounded-lg border border-gray-200 bg-white px-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                                    </div>
                                    <button type="submit" id="qdVerifySubmitBtn" class="w-full h-8 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold shadow-theme-xs transition-colors flex items-center justify-center gap-1.5">
                                        <i class="fas fa-save text-[11px]"></i> Simpan Verifikasi
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Status Keuangan -->
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                                    <i class="fas fa-wallet text-emerald-500"></i> Administrasi & Biaya
                                </h4>
                                <a id="qdKeuanganLink" href="#" class="text-[11px] text-brand-500 font-semibold hover:underline">Kelola &rarr;</a>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                <span class="text-gray-500">Status</span>
                                <span id="qdKeuanganBadge">-</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                <span class="text-gray-500">Total Tagihan</span>
                                <span class="font-semibold text-gray-800 dark:text-gray-200" id="qdTotalTagihan">-</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-gray-500">Sisa Tagihan</span>
                                <span class="font-bold text-rose-600 dark:text-rose-400" id="qdSisaTagihan">-</span>
                            </div>
                        </div>

                        <!-- Berkas Uploaded -->
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-1.5">
                                <i class="fas fa-paperclip text-purple-500"></i> Dokumen Berkas
                            </h4>
                            <div id="qdBerkasList" class="space-y-1.5 max-h-32 overflow-y-auto">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-100 px-6 py-3.5 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40 flex flex-wrap justify-between items-center gap-2 shrink-0">
                <div class="flex items-center gap-2">
                    <a id="qdCetakFormulir" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-print text-[11px] text-emerald-500"></i> Formulir
                    </a>
                    <a id="qdCetakKartu" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-id-card text-[11px] text-purple-500"></i> Kartu
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeQuickDetail()" class="px-3.5 py-1.5 rounded-lg border border-gray-200 bg-white text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50">
                        Tutup
                    </button>
                    <a id="qdFullDetailLink" href="#" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                        <span>Halaman Lengkap</span> &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Verify Modal -->
<div id="bulkVerifyModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBulkVerifyModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="bulkVerifyModalContent">
            <div class="border-b border-emerald-100 bg-emerald-50/60 px-6 py-4 dark:border-emerald-950 dark:bg-emerald-950/30">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400">
                        <i class="fas fa-check-double text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Verifikasi Massal</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Ubah status verifikasi untuk siswa terpilih</p>
                    </div>
                </div>
            </div>

            <form id="bulkVerifyForm" onsubmit="submitBulkVerify(event)">
                <?= csrf_field() ?>
                <div class="p-6 space-y-4">
                    <p class="text-xs text-gray-600 dark:text-gray-300">
                        Anda memilih <strong id="bulkVerifyCount" class="text-emerald-600 font-bold">0</strong> siswa. Pilih status verifikasi baru:
                    </p>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Status Baru</label>
                        <select name="status" id="bulkVerifyStatus" class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                            <option value="Terverifikasi">✅ Terverifikasi</option>
                            <option value="Menunggu">⏳ Menunggu</option>
                            <option value="Ditolak">❌ Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Catatan Verifikasi</label>
                        <input type="text" name="catatan" id="bulkVerifyCatatan" value="Verifikasi massal oleh Admin" class="w-full h-10 rounded-xl border border-gray-200 bg-transparent px-3 text-xs text-gray-800 dark:border-gray-700 dark:text-white focus:outline-none" placeholder="Masukkan catatan">
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeBulkVerifyModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="bulkVerifySubmitBtn"
                        class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulkDeleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBulkDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="bulkDeleteModalContent">
            <div class="border-b border-red-100 bg-red-50/60 px-6 py-5 dark:border-red-950 dark:bg-red-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-red-900 dark:text-red-300">Konfirmasi Hapus Massal</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini permanen dan tidak dapat dibatalkan!</p>
                    </div>
                </div>
            </div>

            <form id="bulkDeleteForm" onsubmit="submitBulkDelete(event)">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Anda akan menghapus secara permanen data milik:</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
                        <span id="bulkDeleteCountText" class="text-red-600">0</span> siswa yang dipilih
                    </p>

                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-3 mb-4 dark:border-amber-900/50 dark:bg-amber-950/40">
                        <p class="text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Ketik kata <strong class="text-red-600 uppercase">hapus</strong> untuk mengonfirmasi:</span>
                        </p>
                    </div>

                    <input type="text" id="bulkDeleteConfirmInput"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-center text-sm font-semibold focus:border-red-500 focus:outline-none dark:border-gray-800 dark:text-white"
                        placeholder="Ketik 'hapus' di sini"
                        autocomplete="off">
                    <p class="text-[11px] text-gray-500 mt-2 text-center" id="bulkDeleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeBulkDeleteModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="bulkDeleteConfirmBtn" disabled
                        class="rounded-xl bg-red-400 px-4 py-2 text-xs font-semibold text-white transition-all cursor-not-allowed opacity-60 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="deleteModalContent">
            <div class="border-b border-red-100 bg-red-50/60 px-6 py-5 dark:border-red-950 dark:bg-red-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-red-900 dark:text-red-300">Konfirmasi Hapus Data</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                </div>
            </div>

            <form method="post" id="deleteForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Anda akan menghapus seluruh data pendaftaran milik:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="deleteStudentName"></p>

                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-3 mb-4 dark:border-amber-900/50 dark:bg-amber-950/40">
                        <p class="text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Ketik kata <strong class="text-red-600 uppercase">hapus</strong> untuk mengonfirmasi:</span>
                        </p>
                    </div>

                    <input type="text" id="deleteConfirmInput" name="delete_confirm"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-center text-sm font-semibold focus:border-red-500 focus:outline-none dark:border-gray-800 dark:text-white"
                        placeholder="Ketik 'hapus' di sini"
                        autocomplete="off">
                    <p class="text-[11px] text-gray-500 mt-2 text-center" id="deleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="deleteConfirmBtn" disabled
                        class="rounded-xl bg-red-400 px-4 py-2 text-xs font-semibold text-white transition-all cursor-not-allowed opacity-60 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeResetPasswordModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="resetPasswordModalContent">
            <div class="border-b border-amber-100 bg-amber-50/60 px-6 py-5 dark:border-amber-950 dark:bg-amber-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400">
                        <i class="fas fa-key text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Reset Password Siswa</h3>
                        <p class="text-xs text-amber-600 dark:text-amber-400">Buat password baru dan cetak resi PDF</p>
                    </div>
                </div>
            </div>
            <form method="post" id="resetPasswordForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Reset password untuk calon siswa:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="resetStudentName"></p>

                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" id="newPasswordInput" name="new_password" required
                            class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm font-semibold focus:border-amber-500 focus:outline-none dark:border-gray-800 dark:text-white"
                            placeholder="Ketik password atau klik acak">
                        <button type="button" onclick="generateRandomPassword()"
                            class="shrink-0 rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                            <i class="fas fa-random mr-1"></i> Acak
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500">File PDF resi login akan terunduh otomatis setelah Anda menyimpannya.</p>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeResetPasswordModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all flex items-center gap-2 shadow-theme-xs">
                        <i class="fas fa-save"></i> Simpan & Download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ==========================================
    // BULK ACTIONS LOGIC
    // ==========================================
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.siswa-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.siswa-checkbox:checked')).map(cb => cb.value);
    }

    function updateBulkBar() {
        const checked = document.querySelectorAll('.siswa-checkbox:checked');
        const all = document.querySelectorAll('.siswa-checkbox');
        const bar = document.getElementById('bulkActionBar');
        const countBadge = document.getElementById('selectedCountBadge');
        const master = document.getElementById('selectAllCheckbox');

        if (master && all.length > 0) {
            master.checked = (checked.length === all.length);
        }

        if (checked.length > 0) {
            countBadge.textContent = checked.length;
            bar.classList.remove('hidden');
            setTimeout(() => {
                bar.classList.remove('translate-y-10', 'opacity-0');
                bar.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        } else {
            bar.classList.remove('translate-y-0', 'opacity-100');
            bar.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                bar.classList.add('hidden');
            }, 300);
        }
    }

    function clearSelection() {
        document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllCheckbox');
        if (master) master.checked = false;
        updateBulkBar();
    }

    function executeBulkPrintCards() {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih minimal satu siswa untuk mencetak kartu.' });
            return;
        }
        window.open('<?= base_url('admin/setting-kartu/cetak-masal') ?>?ids=' + ids.join(','), '_blank');
    }

    function openBulkVerifyModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('bulkVerifyCount').textContent = ids.length;

        const modal = document.getElementById('bulkVerifyModal');
        const content = document.getElementById('bulkVerifyModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBulkVerifyModal() {
        const modal = document.getElementById('bulkVerifyModal');
        const content = document.getElementById('bulkVerifyModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    async function submitBulkVerify(e) {
        e.preventDefault();
        const ids = getSelectedIds();
        const status = document.getElementById('bulkVerifyStatus').value;
        const catatan = document.getElementById('bulkVerifyCatatan').value;
        const submitBtn = document.getElementById('bulkVerifySubmitBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const formData = new FormData(document.getElementById('bulkVerifyForm'));
        formData.append('ids', ids.join(','));
        formData.set('status', status);
        formData.set('catatan', catatan);

        try {
            const resp = await fetch('<?= base_url('admin/siswa/bulk-verify') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await resp.json();
            if (data.status === 'success') {
                closeBulkVerifyModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Simpan Perubahan';
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Simpan Perubahan';
        }
    }

    function openBulkDeleteModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('bulkDeleteCountText').textContent = ids.length;
        document.getElementById('bulkDeleteConfirmInput').value = '';
        resetBulkDeleteBtn();

        const modal = document.getElementById('bulkDeleteModal');
        const content = document.getElementById('bulkDeleteModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('bulkDeleteConfirmInput').focus();
        }, 200);
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('bulkDeleteModal');
        const content = document.getElementById('bulkDeleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function resetBulkDeleteBtn() {
        const btn = document.getElementById('bulkDeleteConfirmBtn');
        btn.disabled = true;
        btn.classList.add('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    function enableBulkDeleteBtn() {
        const btn = document.getElementById('bulkDeleteConfirmBtn');
        btn.disabled = false;
        btn.classList.remove('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    document.getElementById('bulkDeleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('bulkDeleteHint');
        if (value === 'hapus') {
            enableBulkDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-[11px] text-emerald-600 mt-2 text-center font-medium';
        } else {
            resetBulkDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-[11px] text-red-500 mt-2 text-center';
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-[11px] text-gray-500 mt-2 text-center';
            }
        }
    });

    async function submitBulkDelete(e) {
        e.preventDefault();
        const ids = getSelectedIds();
        const confirmText = document.getElementById('bulkDeleteConfirmInput').value;
        const submitBtn = document.getElementById('bulkDeleteConfirmBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

        const formData = new FormData(document.getElementById('bulkDeleteForm'));
        formData.append('ids', ids.join(','));
        formData.set('confirm', confirmText);

        try {
            const resp = await fetch('<?= base_url('admin/siswa/bulk-delete') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await resp.json();
            if (data.status === 'success') {
                closeBulkDeleteModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Hapus Permanen';
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Hapus Permanen';
        }
    }

    // ==========================================
    // 1-CLICK WHATSAPP LOGIC
    // ==========================================
    let currentWaStudent = null;

    function openWhatsAppModal(id, name, noDaftar, hpSiswa, hpOrtu) {
        currentWaStudent = { id, name, noDaftar, hpSiswa, hpOrtu };
        document.getElementById('waStudentHeader').textContent = `${name} (${noDaftar})`;

        const container = document.getElementById('waRecipientOptions');
        container.innerHTML = '';

        const hasSiswa = hpSiswa && hpSiswa.trim().length >= 8;
        const hasOrtu = hpOrtu && hpOrtu.trim().length >= 8;

        // Siswa radio
        const optSiswa = document.createElement('label');
        optSiswa.className = `flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-colors ${hasSiswa ? 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' : 'border-dashed border-gray-200 text-gray-400 opacity-60 cursor-not-allowed'}`;
        optSiswa.innerHTML = `
            <input type="radio" name="wa_target_phone" value="${hasSiswa ? hpSiswa : ''}" ${hasSiswa ? 'checked' : 'disabled'} class="text-emerald-600 focus:ring-emerald-500">
            <div>
                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200">Siswa</span>
                <span class="block text-[11px] font-mono text-gray-500">${hasSiswa ? hpSiswa : '(Tidak ada nomor)'}</span>
            </div>
        `;
        container.appendChild(optSiswa);

        // Ortu radio
        const optOrtu = document.createElement('label');
        optOrtu.className = `flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-colors ${hasOrtu ? 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' : 'border-dashed border-gray-200 text-gray-400 opacity-60 cursor-not-allowed'}`;
        optOrtu.innerHTML = `
            <input type="radio" name="wa_target_phone" value="${hasOrtu ? hpOrtu : ''}" ${(!hasSiswa && hasOrtu) ? 'checked' : ''} ${hasOrtu ? '' : 'disabled'} class="text-emerald-600 focus:ring-emerald-500">
            <div>
                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200">Orang Tua / Wali</span>
                <span class="block text-[11px] font-mono text-gray-500">${hasOrtu ? hpOrtu : '(Tidak ada nomor)'}</span>
            </div>
        `;
        container.appendChild(optOrtu);

        applyWaTemplate('berkas');

        const modal = document.getElementById('whatsappModal');
        const content = document.getElementById('whatsappModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeWhatsAppModal() {
        const modal = document.getElementById('whatsappModal');
        const content = document.getElementById('whatsappModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function applyWaTemplate(type) {
        if (!currentWaStudent) return;
        const name = currentWaStudent.name;
        const noDaftar = currentWaStudent.noDaftar;
        let msg = '';

        switch (type) {
            case 'berkas':
                msg = `Halo ${name}, kami dari Panitia PPDB menginformasikan bahwa data/berkas pendaftaran Anda (${noDaftar}) masih belum lengkap. Mohon segera login ke akun pendaftaran dan melengkapi berkas sebelum batas waktu berakhir. Terima kasih.`;
                break;
            case 'verif':
                msg = `Halo ${name}, selamat! Berkas dan biodata pendaftaran PPDB Anda dengan No. Pendaftaran ${noDaftar} telah selesai DIVERIFIKASI dan dinyatakan VALID oleh Panitia. Silakan unduh kartu pendaftaran Anda di dashboard siswa.`;
                break;
            case 'ditolak':
                msg = `Halo ${name}, kami menginformasikan bahwa berkas pendaftaran Anda (${noDaftar}) memerlukan perbaikan. Silakan login ke portal pendaftaran untuk memeriksa catatan dari verifikator dan unggah ulang berkas yang diminta.`;
                break;
            case 'keuangan':
                msg = `Halo ${name}/Bapak/Ibu Orang Tua, kami dari Panitia PPDB menginformasikan mengenai administrasi pendaftaran untuk No. Pendaftaran ${noDaftar}. Silakan cek rincian biaya atau tagihan di portal pendaftaran.`;
                break;
        }

        document.getElementById('waMessageText').value = msg;
    }

    function cleanPhoneNumber(phone) {
        if (!phone) return '';
        let cleaned = phone.replace(/[^0-9]/g, '');
        if (cleaned.startsWith('0')) {
            cleaned = '62' + cleaned.substring(1);
        } else if (cleaned.startsWith('8')) {
            cleaned = '62' + cleaned;
        }
        return cleaned;
    }

    function sendWhatsAppNow() {
        const selectedRadio = document.querySelector('input[name="wa_target_phone"]:checked');
        if (!selectedRadio || !selectedRadio.value) {
            Swal.fire({ icon: 'warning', title: 'Nomor Tidak Valid', text: 'Nomor WhatsApp untuk target yang dipilih tidak tersedia.' });
            return;
        }

        const phone = cleanPhoneNumber(selectedRadio.value);
        const text = encodeURIComponent(document.getElementById('waMessageText').value);

        if (!phone || phone.length < 9) {
            Swal.fire({ icon: 'warning', title: 'Nomor Tidak Valid', text: 'Format nomor telepon tidak sesuai untuk WhatsApp.' });
            return;
        }

        window.open(`https://wa.me/${phone}?text=${text}`, '_blank');
        closeWhatsAppModal();
    }

    // ==========================================
    // QUICK DETAIL PREVIEW MODAL
    // ==========================================
    async function openQuickDetail(id) {
        const modal = document.getElementById('quickDetailModal');
        const content = document.getElementById('quickDetailContent');
        
        // Reset modal fields to loading state
        document.getElementById('qdNama').textContent = 'Memuat...';
        document.getElementById('qdSubheader').textContent = 'Mengambil data siswa...';
        document.getElementById('qdPhoto').src = 'https://ui-avatars.com/api/?name=Loading&background=random';
        document.getElementById('qdStudentId').value = id;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        try {
            const resp = await fetch('<?= base_url('admin/siswa/quick-detail') ?>/' + id, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const res = await resp.json();
            if (res.status !== 'success') {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message || 'Gagal memuat data siswa.' });
                closeQuickDetail();
                return;
            }

            const s = res.data.student;
            const b = res.data.berkas;
            const k = res.data.keuangan;

            // Header
            document.getElementById('qdNama').textContent = s.nama_lengkap;
            document.getElementById('qdSubheader').textContent = `No: ${s.no_pendaftaran} • TP: ${s.th_pelajaran || '-'}`;
            const qdPhotoEl = document.getElementById('qdPhoto');
            qdPhotoEl.onerror = function() {
                this.onerror = null;
                this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(s.nama_lengkap)}&background=random`;
            };
            qdPhotoEl.src = s.foto_url ? s.foto_url : `https://ui-avatars.com/api/?name=${encodeURIComponent(s.nama_lengkap)}&background=random`;

            // Status Verif Badge
            const stVerif = s.status_verifikasi || 'Menunggu';
            let stBadge = '';
            if (stVerif === 'Terverifikasi') {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400"><i class="fas fa-check-circle text-[10px]"></i> Terverifikasi</span>';
            } else if (stVerif === 'Ditolak') {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400"><i class="fas fa-times-circle text-[10px]"></i> Ditolak</span>';
            } else {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400"><i class="fas fa-clock text-[10px]"></i> Menunggu</span>';
            }
            document.getElementById('qdStatusVerifBadge').innerHTML = stBadge;

            // Biodata details
            document.getElementById('qdNisnNik').textContent = `${s.nisn || '-'} / ${s.nik || '-'}`;
            document.getElementById('qdJk').textContent = s.jk === 'L' ? 'Laki-laki' : 'Perempuan';
            document.getElementById('qdTTL').textContent = `${s.tempat_lahir || '-'}, ${s.tgl_lahir || '-'}`;
            document.getElementById('qdSekolah').textContent = s.nama_sekolah || '-';
            document.getElementById('qdAlamat').textContent = s.alamat_siswa || '-';
            document.getElementById('qdOrtu').textContent = `${s.nama_ayah || '-'} / ${s.nama_ibu || '-'}`;
            document.getElementById('qdHp').textContent = `${s.no_hp_siswa || '-'} / ${s.no_hp_ortu || '-'}`;

            // Progress Kelengkapan
            const percent = s.kelengkapan || 0;
            document.getElementById('qdKelengkapanPercent').textContent = percent + '%';
            document.getElementById('qdKelengkapanBar').style.width = percent + '%';
            document.getElementById('qdKelengkapanBar').className = `h-2 rounded-full transition-all ${percent === 100 ? 'bg-emerald-500' : (percent >= 50 ? 'bg-brand-500' : 'bg-red-500')}`;

            const missingContainer = document.getElementById('qdMissingFields');
            if (s.incomplete_fields && s.incomplete_fields.length > 0) {
                missingContainer.classList.remove('hidden');
                document.getElementById('qdMissingList').textContent = s.incomplete_fields.slice(0, 4).join(', ') + (s.incomplete_fields.length > 4 ? ` (+${s.incomplete_fields.length - 4} lainnya)` : '');
            } else {
                missingContainer.classList.add('hidden');
            }

            // Quick Verifikasi select
            document.getElementById('qdStatusSelect').value = ['Terverifikasi', 'Menunggu', 'Ditolak'].includes(stVerif) ? stVerif : 'Menunggu';
            document.getElementById('qdCatatanInput').value = s.verifikasi_isi || '';

            // Keuangan
            document.getElementById('qdKeuanganLink').href = '<?= base_url('admin/pembiayaan/siswa') ?>/' + s.id_siswa;
            let kbHtml = '';
            if (k.status === 'lunas') {
                kbHtml = '<span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">Lunas</span>';
            } else if (k.status === 'sebagian') {
                kbHtml = '<span class="inline-flex rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700">Kurang Bayar</span>';
            } else if (k.status === 'belum') {
                kbHtml = '<span class="inline-flex rounded-full bg-rose-50 px-2 py-0.5 text-[11px] font-semibold text-rose-700">Belum Bayar</span>';
            } else {
                kbHtml = '<span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-[10px] text-gray-500">Belum Ditagih</span>';
            }
            document.getElementById('qdKeuanganBadge').innerHTML = kbHtml;
            document.getElementById('qdTotalTagihan').textContent = 'Rp ' + Number(k.total_tagihan).toLocaleString('id-ID');
            document.getElementById('qdSisaTagihan').textContent = 'Rp ' + Number(k.sisa).toLocaleString('id-ID');

            // Berkas list
            const berkasDiv = document.getElementById('qdBerkasList');
            berkasDiv.innerHTML = '';
            if (b && b.length > 0) {
                b.forEach(file => {
                    const isImg = file.path_file && file.path_file.match(/\.(jpg|jpeg|png|webp)$/i);
                    const fileUrl = '<?= base_url('uploads/berkas') ?>/' + file.path_file;
                    const item = document.createElement('div');
                    item.className = 'flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-800/40 text-[11px] border border-gray-100 dark:border-gray-800';
                    item.innerHTML = `
                        <div class="flex items-center gap-2 truncate">
                            <i class="${isImg ? 'fas fa-image text-blue-500' : 'fas fa-file-pdf text-red-500'}"></i>
                            <span class="font-medium text-gray-800 dark:text-gray-200 capitalize truncate">${file.jenis_berkas.replace(/_/g, ' ')}</span>
                        </div>
                        <a href="${fileUrl}" target="_blank" class="text-brand-500 hover:underline font-semibold ml-2 shrink-0">
                            Lihat <i class="fas fa-external-link-alt text-[9px]"></i>
                        </a>
                    `;
                    berkasDiv.appendChild(item);
                });
            } else {
                berkasDiv.innerHTML = '<span class="text-gray-400 italic text-[11px]">Belum ada berkas yang diunggah.</span>';
            }

            // Footer Links
            document.getElementById('qdCetakFormulir').href = '<?= base_url('admin/siswa/cetak') ?>/' + s.id_siswa;
            document.getElementById('qdCetakKartu').href = '<?= base_url('admin/siswa/cetak-kartu') ?>/' + s.id_siswa;
            document.getElementById('qdFullDetailLink').href = '<?= base_url('admin/siswa/detail') ?>/' + s.id_siswa;

        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            closeQuickDetail();
        }
    }

    function closeQuickDetail() {
        const modal = document.getElementById('quickDetailModal');
        const content = document.getElementById('quickDetailContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    async function submitQuickVerify(e) {
        e.preventDefault();
        const id = document.getElementById('qdStudentId').value;
        const status = document.getElementById('qdStatusSelect').value;
        const catatan = document.getElementById('qdCatatanInput').value;
        const btn = document.getElementById('qdVerifySubmitBtn');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const formData = new FormData();
        formData.append('status', status);
        formData.append('catatan', catatan);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        try {
            const resp = await fetch('<?= base_url('admin/siswa/verify') ?>/' + id, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            closeQuickDetail();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status verifikasi siswa telah diperbarui.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());

        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save text-[11px]"></i> Simpan Verifikasi';
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
        }
    }

    // ==========================================
    // THROTTLE RESET, DELETE & RESET PASSWORD
    // ==========================================
    function confirmResetThrottle(url) {
        Swal.fire({
            title: 'Konfirmasi Reset',
            text: 'Apakah Anda yakin ingin mereset batas waktu login untuk semua IP/akun yang terkunci?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function openDeleteModal(name, url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteStudentName').textContent = name;
        document.getElementById('deleteConfirmInput').value = '';
        document.getElementById('deleteHint').textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
        document.getElementById('deleteHint').className = 'text-[11px] text-gray-500 mt-2 text-center';
        resetDeleteBtn();

        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('deleteConfirmInput').focus();
        }, 200);
    }

    function closeDeleteModal() {
        const content = document.getElementById('deleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('deleteModal').classList.add('hidden');
        }, 200);
    }

    function resetDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = true;
        btn.classList.add('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    function enableDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = false;
        btn.classList.remove('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    document.getElementById('deleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('deleteHint');

        if (value === 'hapus') {
            enableDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-[11px] text-emerald-600 mt-2 text-center font-medium';
        } else {
            resetDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-[11px] text-red-500 mt-2 text-center';
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-[11px] text-gray-500 mt-2 text-center';
            }
        }
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        const input = document.getElementById('deleteConfirmInput');
        if (input.value.trim().toLowerCase() !== 'hapus') {
            e.preventDefault();
            return false;
        }
    });

    // ==========================================
    // ROW ACTION DROPDOWN MENU
    // ==========================================
    function toggleActionMenu(e, menuId) {
        e.stopPropagation();
        const menu = document.getElementById(menuId);
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden');

        // Close all other student action menus
        document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));

        if (isHidden) {
            menu.classList.remove('hidden');
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.student-action-menu') && !e.target.closest('button[onclick^="toggleActionMenu"]')) {
            document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));
            closeDeleteModal();
            closeResetPasswordModal();
            closeWhatsAppModal();
            closeQuickDetail();
            closeBulkVerifyModal();
            closeBulkDeleteModal();
        }
    });

    function openResetPasswordModal(id, name) {
        document.getElementById('resetPasswordForm').action = '<?= base_url('admin/siswa/resetPassword') ?>/' + id;
        document.getElementById('resetStudentName').textContent = name;
        document.getElementById('newPasswordInput').value = '';

        const modal = document.getElementById('resetPasswordModal');
        const content = document.getElementById('resetPasswordModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeResetPasswordModal() {
        const content = document.getElementById('resetPasswordModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('resetPasswordModal').classList.add('hidden');
        }, 200);
    }

    function generateRandomPassword() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let pass = '';
        for (let i = 0; i < 6; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('newPasswordInput').value = pass;
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
        background-color: #465fff; /* brand-500 */
        border-color: #465fff;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>

<?= $this->endSection() ?>