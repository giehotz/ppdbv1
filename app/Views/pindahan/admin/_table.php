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
                <th class="py-3.5 px-4">Jenjang Asal</th>
                <th class="py-3.5 px-4">Kelengkapan</th>
                <th class="py-3.5 px-4">Status Validasi</th>
                <th class="py-3.5 px-4">
                    <a href="<?= base_url('admin/pindahan') ?>?search=<?= esc($search ?? '') ?>&sort=<?= ($sort ?? 'ASC') == 'ASC' ? 'DESC' : 'ASC' ?>&th_pelajaran=<?= urlencode($selectedTh ?? '') ?>&tab=<?= urlencode($currentTab ?? 'all') ?>"
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
                    <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]" id="row-<?= $s['id_pindahan'] ?>">
                        <td class="py-3 px-3 text-center">
                            <input type="checkbox" class="pindahan-checkbox h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 cursor-pointer"
                                   value="<?= $s['id_pindahan'] ?>"
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
                                    <a href="javascript:void(0)" onclick="openQuickDetail('<?= $s['id_pindahan'] ?>')" class="font-semibold text-gray-900 dark:text-gray-100 hover:text-brand-500 dark:hover:text-brand-400 transition-colors truncate block max-w-[180px]" title="Klik untuk Quick Preview">
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
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 font-medium text-gray-700 dark:text-gray-200">
                                <span class="font-semibold"><?= esc($s['jenjang_sekolah_asal'] ?? '-') ?></span>
                            </span>
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
                        <td class="py-3 px-4 whitespace-nowrap text-gray-500 dark:text-gray-400 text-[11px]">
                            <?= $s['tgl_pindahan'] ? date('d/m/Y', strtotime($s['tgl_pindahan'])) : '-' ?>
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- WhatsApp -->
                                <button type="button"
                                    onclick="openWhatsAppModal('<?= $s['id_pindahan'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= esc(addslashes($s['no_pendaftaran'])) ?>', '<?= esc($s['no_hp_siswa'] ?? '') ?>', '<?= esc($s['no_hp_ortu'] ?? '') ?>')"
                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-emerald-600 hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-emerald-500/15 transition-colors focus:outline-none"
                                    title="Kirim Pesan WhatsApp">
                                    <i class="fab fa-whatsapp text-xs font-bold"></i>
                                </button>

                                <!-- Quick Preview -->
                                <button type="button"
                                    onclick="openQuickDetail('<?= $s['id_pindahan'] ?>')"
                                    class="flex h-7 w-7 items-center justify-center rounded-lg text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-500/15 transition-colors focus:outline-none"
                                    title="Quick Preview">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>

                                <!-- Login Siswa (Impersonate) -->
                                <form action="<?= base_url('impersonate/start-pindahan/' . $s['id_pindahan']) ?>" method="POST" class="inline m-0 p-0">
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
                                        onclick="toggleActionMenu(event, 'actionMenu-<?= $s['id_pindahan'] ?>')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-colors focus:outline-none"
                                        title="Pilihan Aksi Lainnya">
                                        <i class="fas fa-ellipsis-v text-xs"></i>
                                    </button>

                                    <!-- Dropdown Menu Content -->
                                    <div id="actionMenu-<?= $s['id_pindahan'] ?>"
                                         class="student-action-menu hidden absolute right-0 mt-1.5 w-48 rounded-xl border border-gray-100 bg-white p-1.5 shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50 text-left divide-y divide-gray-100 dark:divide-gray-800">
                                        <div class="py-1">
                                            <a href="<?= base_url('admin/pindahan/detail/' . $s['id_pindahan']) ?>"
                                               class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                <i class="fas fa-id-badge text-gray-400 w-4 text-center"></i>
                                                <span>Detail Lengkap</span>
                                            </a>
                                        </div>

                                        <div class="py-1">
                                            <a href="<?= base_url('admin/pindahan/cetak/' . $s['id_pindahan']) ?>" target="_blank"
                                               class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-emerald-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                <i class="fas fa-print text-gray-400 w-4 text-center"></i>
                                                <span>Cetak Formulir</span>
                                            </a>
                                            <a href="<?= base_url('admin/pindahan/cetak-kartu/' . $s['id_pindahan']) ?>" target="_blank"
                                               class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-purple-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                                                <i class="fas fa-id-card text-gray-400 w-4 text-center"></i>
                                                <span>Cetak Kartu</span>
                                            </a>
                                        </div>

                                        <div class="py-1">
                                            <button type="button"
                                                onclick="openResetPasswordModal('<?= $s['id_pindahan'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>')"
                                                class="w-full flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-amber-600 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors text-left">
                                                <i class="fas fa-key text-gray-400 w-4 text-center"></i>
                                                <span>Reset Password</span>
                                            </button>
                                        </div>

                                        <div class="py-1">
                                            <button type="button"
                                                onclick="openDeleteModal('<?= esc(addslashes($s['nama_lengkap'])) ?>', '<?= base_url('admin/pindahan/delete/' . $s['id_pindahan']) ?>')"
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
                                <p class="text-xs mt-0.5">Tidak ada siswa pindahan dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                <a href="<?= base_url('admin/pindahan') ?>" class="mt-3 text-xs font-semibold text-brand-500 hover:underline">Clear Pencarian</a>
                            <?php else : ?>
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300 dark:text-gray-700"></i>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum Ada Data</p>
                                <p class="text-xs mt-0.5">Belum ada siswa pindahan pada kriteria filter ini.</p>
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
        <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data siswa pindahan.</span>
        <div class="pagination-wrapper">
            <?= $pager->links() ?>
        </div>
    </div>
<?php endif; ?>