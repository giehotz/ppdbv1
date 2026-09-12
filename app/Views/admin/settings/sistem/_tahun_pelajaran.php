<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-brand-500">calendar_month</span>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Tahun Pelajaran &amp; Isolasi Data</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola periode tahun ajaran. Mengubah tahun ajaran aktif akan menyembunyikan pendaftar dari tahun sebelumnya.</p>
            </div>
        </div>
        <button type="button" onclick="openModalTambahTP()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold rounded-xl shadow-theme-xs transition-all active:scale-[0.98] shrink-0">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            <span>Tambah Tahun Pelajaran</span>
        </button>
    </div>

    <div class="p-6 space-y-5">
        <!-- Selector Form Tahun Pelajaran Aktif -->
        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/60 dark:border-gray-800 dark:bg-gray-800/30">
            <div class="flex items-center justify-between mb-2">
                <label class="text-sm font-bold text-gray-800 dark:text-gray-200">Tahun Pelajaran Aktif Sistem</label>
                <button type="button" onclick="openModalTambahTP()" class="text-xs text-brand-600 dark:text-brand-400 hover:underline font-semibold flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">add_circle</span> Tambah Periode
                </button>
            </div>
            <select name="th_pelajaran"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-bold text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                <?php foreach (($tahunPelajaranList ?? []) as $tp): ?>
                    <option value="<?= esc($tp['tahun_pelajaran']) ?>" <?= ($web['th_pelajaran'] === $tp['tahun_pelajaran']) ? 'selected' : '' ?>>
                        <?= esc($tp['tahun_pelajaran']) ?> <?= ($tp['status'] === 'Aktif') ? '★ (Aktif Saat Ini)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs text-amber-500">lock_reset</span>
                <span>Data calon siswa dari tahun ajaran lain otomatis disembunyikan.</span>
            </p>
        </div>

        <!-- Active Year Summary Banner -->
        <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/70 dark:border-emerald-900/50 dark:bg-emerald-950/20 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="material-symbols-outlined">verified</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Tahun Pelajaran Aktif:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-600 text-white shadow-xs"><?= esc($web['th_pelajaran']) ?></span>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        Data calon siswa di menu <strong>Calon Siswa</strong>, <strong>Dashboard</strong>, <strong>Kelulusan</strong>, dan <strong>Pembiayaan</strong> saat ini diisolasi hanya untuk tahun ajaran <strong><?= esc($web['th_pelajaran']) ?></strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Table Riwayat -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50/80 dark:bg-gray-800/50 font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4 text-center w-12">No</th>
                        <th class="py-3 px-4">Tahun Pelajaran</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Jumlah Pendaftar</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Tanggal Dibuat</th>
                        <th class="py-3 px-4 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php if (!empty($tahunPelajaranList)): ?>
                        <?php $no = 1; foreach ($tahunPelajaranList as $tp): ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors <?= ($tp['status'] === 'Aktif') ? 'bg-brand-50/20 dark:bg-brand-500/[0.03]' : '' ?>">
                                <td class="py-3 px-4 text-center text-gray-500"><?= $no++ ?></td>
                                <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        <span><?= esc($tp['tahun_pelajaran']) ?></span>
                                        <?php if ($tp['status'] === 'Aktif'): ?>
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-400 px-2 py-0.5 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Utama
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <?php if ($tp['status'] === 'Aktif'): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/50">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                                            Tidak Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <?php if ((int)$tp['total_siswa'] > 0): ?>
                                        <a href="<?= base_url('admin/siswa?th_pelajaran=' . urlencode($tp['tahun_pelajaran'])) ?>"
                                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-950/40 dark:text-blue-300 dark:hover:bg-blue-900/60 transition-all shadow-2xs hover:scale-105"
                                           title="Klik untuk melihat daftar calon siswa pada Tahun Pelajaran <?= esc($tp['tahun_pelajaran']) ?>">
                                            <span class="material-symbols-outlined text-xs">group</span>
                                            <span><?= number_format((int)$tp['total_siswa']) ?> Siswa</span>
                                            <span class="material-symbols-outlined text-[10px]">open_in_new</span>
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-xs">group</span>
                                            0 Siswa
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                                    <?= esc($tp['keterangan'] ?? '-') ?>
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-[11px]">
                                    <?= !empty($tp['created_at']) ? date('d M Y H:i', strtotime($tp['created_at'])) : '-' ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                        <?php if ((int)$tp['total_siswa'] > 0): ?>
                                            <a href="<?= base_url('admin/siswa?th_pelajaran=' . urlencode($tp['tahun_pelajaran'])) ?>"
                                               class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-[11px] font-bold rounded-lg transition-colors"
                                               title="Lihat daftar calon siswa tahun <?= esc($tp['tahun_pelajaran']) ?>">
                                                <span class="material-symbols-outlined text-xs">visibility</span>
                                                <span>Lihat Siswa</span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($tp['status'] === 'Aktif'): ?>
                                            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1 py-1 px-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/30">
                                                <span class="material-symbols-outlined text-xs">check_circle</span> Aktif
                                            </span>
                                        <?php else: ?>
                                            <button type="button"
                                                    onclick="confirmActivateTP(<?= $tp['id_tahun'] ?>, '<?= esc($tp['tahun_pelajaran']) ?>', <?= (int)$tp['total_siswa'] ?>)"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-brand-500 hover:bg-brand-600 text-white text-[11px] font-bold rounded-lg shadow-theme-xs transition-colors"
                                                    title="Aktifkan Tahun Pelajaran ini">
                                                <span class="material-symbols-outlined text-xs">toggle_on</span>
                                                <span>Jadikan Aktif</span>
                                            </button>
                                            <?php if ((int)$tp['total_siswa'] === 0): ?>
                                                <button type="button"
                                                        onclick="confirmDeleteTP(<?= $tp['id_tahun'] ?>, '<?= esc($tp['tahun_pelajaran']) ?>')"
                                                        class="inline-flex items-center justify-center w-7 h-7 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition-colors"
                                                        title="Hapus Tahun Pelajaran">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">Belum ada riwayat tahun pelajaran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
