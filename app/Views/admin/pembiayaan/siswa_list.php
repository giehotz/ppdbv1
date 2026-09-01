<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Data Pembiayaan Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">account_balance_wallet</span> Data Pembiayaan Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Siswa & Status Pembayaran</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pantau status kelunasan dan riwayat pembayaran seluruh calon siswa</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <a href="<?= base_url('admin/pembiayaan') ?>" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">payments</span>
            <span>Kelola Item Biaya</span>
        </a>
    </div>
</div>

<!-- Main Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3 px-4">No</th>
                    <th class="py-3 px-4">No. Daftar</th>
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4 text-right">Total Tagihan</th>
                    <th class="py-3 px-4 text-right">Sudah Dibayar</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (empty($siswaList)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2 text-gray-300 dark:text-gray-600">inbox</span>
                            Belum ada data siswa.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($siswaList as $s): ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="py-3.5 px-4 font-mono text-gray-500 dark:text-gray-400"><?= $no++ ?></td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-gray-700 dark:text-gray-300"><?= esc($s['no_pendaftaran']) ?></td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 dark:text-white"><?= esc($s['nama_lengkap']) ?></div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-gray-900 dark:text-white"><?= format_rupiah($s['totalTagihan']) ?></td>
                            <td class="py-3.5 px-4 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400"><?= format_rupiah($s['totalLunas']) ?></td>
                            <td class="py-3.5 px-4 text-center">
                                <?php if ($s['statusLunas']): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="material-symbols-outlined text-xs">check_circle</span> Lunas
                                    </span>
                                <?php elseif ($s['totalTagihan'] > 0): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200/50 dark:border-amber-500/20">
                                        <span class="material-symbols-outlined text-xs">hourglass_top</span> Belum Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                        Belum Ada Tagihan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a href="<?= base_url('admin/pembiayaan/siswa/' . $s['id_siswa']) ?>"
                                   class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-gray-100 text-gray-600 hover:bg-brand-50 hover:text-brand-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-brand-500/15 dark:hover:text-brand-400 transition"
                                   title="Lihat Detail & Checklist Tagihan">
                                    <span class="material-symbols-outlined text-base">visibility</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
