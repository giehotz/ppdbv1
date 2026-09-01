<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Status Pembiayaan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">payments</span> Status Pembiayaan &amp; Tagihan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Top Summary Cards (TailAdmin Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
        
        <!-- Info Siswa -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">badge</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Identitas Pendaftar</span>
                    <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate max-w-[180px]">
                        <?= esc($siswa['nama_lengkap']) ?>
                    </h4>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center text-xs">
                <span class="text-gray-500 dark:text-gray-400">No. Pendaftaran:</span>
                <span class="font-mono font-bold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/15 px-2 py-0.5 rounded-md">
                    <?= esc($siswa['no_pendaftaran']) ?>
                </span>
            </div>
        </div>

        <!-- Total Tagihan -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Total Biaya &amp; Terbayar</span>
                    <h4 class="text-base font-extrabold text-gray-900 dark:text-white">
                        <?= format_rupiah($totalTagihan) ?>
                    </h4>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center text-xs">
                <span class="text-gray-500 dark:text-gray-400">Sudah Dibayar:</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400">
                    <?= format_rupiah($totalLunas) ?>
                </span>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <div class="rounded-2xl border sm:col-span-2 lg:col-span-1 p-5 shadow-theme-xs <?= $statusLunas ? 'border-emerald-200 bg-emerald-50/40 dark:border-emerald-900/40 dark:bg-emerald-950/20' : 'border-amber-200 bg-amber-50/40 dark:border-amber-900/40 dark:bg-amber-950/20' ?> space-y-3">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl <?= $statusLunas ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white' ?>">
                    <span class="material-symbols-outlined text-xl"><?= $statusLunas ? 'check_circle' : 'pending' ?></span>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider <?= $statusLunas ? 'text-emerald-800 dark:text-emerald-300' : 'text-amber-800 dark:text-amber-300' ?>">Status Tagihan</span>
                    <h4 class="text-sm font-bold <?= $statusLunas ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400' ?>">
                        <?= $statusLunas ? 'LUNAS' : 'BELUM LUNAS' ?>
                    </h4>
                </div>
            </div>
            <div class="pt-2 border-t border-gray-200/60 dark:border-gray-700/60 flex justify-between items-center text-xs">
                <span class="text-gray-500 dark:text-gray-400">Sisa Tagihan:</span>
                <span class="font-bold <?= $statusLunas ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' ?>">
                    <?= format_rupiah(max(0, $totalTagihan - $totalLunas)) ?>
                </span>
            </div>
        </div>

    </div>

    <!-- Rincian Tagihan Table (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">list_alt</span>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Rincian Item Pembiayaan</h4>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/60 dark:text-gray-400">
                        <th class="py-3 px-4 font-bold uppercase text-[10px] w-12 text-center">No</th>
                        <th class="py-3 px-4 font-bold uppercase text-[10px]">Nama Komponen Tagihan</th>
                        <th class="py-3 px-4 font-bold uppercase text-[10px] text-right">Nominal Tagihan</th>
                        <th class="py-3 px-4 font-bold uppercase text-[10px] text-center w-32">Status Item</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php if (empty($tagihan)): ?>
                        <tr>
                            <td colspan="4" class="py-10 px-4 text-center text-gray-400 dark:text-gray-500">
                                <span class="material-symbols-outlined text-3xl mb-1 block">receipt_long</span>
                                Belum ada data tagihan pembiayaan yang ditetapkan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($tagihan as $t): ?>
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="py-3 px-4 text-center text-gray-400 font-mono"><?= $no++ ?></td>
                                <td class="py-3 px-4 font-bold text-gray-800 dark:text-gray-200">
                                    <?= esc($t['nama_item']) ?>
                                </td>
                                <td class="py-3 px-4 text-right font-mono font-bold text-gray-900 dark:text-white">
                                    <?= format_rupiah($t['harga_satuan']) ?>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <?php if (($t['status_bayar'] ?? '') === 'lunas'): ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                            <span class="material-symbols-outlined text-xs">check_circle</span> Lunas
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-[10px] font-bold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-xs">schedule</span> Belum
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($tagihan)): ?>
                    <tfoot class="border-t-2 border-gray-200 dark:border-gray-700 bg-gray-50/40 dark:bg-gray-850/40 font-bold">
                        <tr>
                            <td colspan="2" class="py-3 px-4 text-right text-gray-600 dark:text-gray-400">Total Seluruh Tagihan:</td>
                            <td class="py-3 px-4 text-right text-sm font-mono text-gray-900 dark:text-white"><?= format_rupiah($totalTagihan) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="py-2.5 px-4 text-right text-emerald-600 dark:text-emerald-400">Total Terbayar:</td>
                            <td class="py-2.5 px-4 text-right text-sm font-mono text-emerald-600 dark:text-emerald-400"><?= format_rupiah($totalLunas) ?></td>
                            <td></td>
                        </tr>
                        <tr class="<?= $statusLunas ? 'text-emerald-700 dark:text-emerald-300' : 'text-amber-700 dark:text-amber-300' ?>">
                            <td colspan="2" class="py-2.5 px-4 text-right">Sisa Tagihan yang Harus Dibayar:</td>
                            <td class="py-2.5 px-4 text-right text-sm font-mono"><?= format_rupiah(max(0, $totalTagihan - $totalLunas)) ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- Bottom Row: Riwayat Pembayaran & Kuitansi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Riwayat Pembayaran (2 Cols) -->
        <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500">history_edu</span>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Riwayat Transaksi Masuk</h4>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/60 dark:text-gray-400">
                            <th class="py-2.5 px-4 font-bold uppercase text-[10px] w-12 text-center">No</th>
                            <th class="py-2.5 px-4 font-bold uppercase text-[10px]">Tanggal Bayar</th>
                            <th class="py-2.5 px-4 font-bold uppercase text-[10px] text-right">Nominal</th>
                            <th class="py-2.5 px-4 font-bold uppercase text-[10px]">Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php if (empty($riwayatBayar)): ?>
                            <tr>
                                <td colspan="4" class="py-8 px-4 text-center text-gray-400 dark:text-gray-500">
                                    <span class="material-symbols-outlined text-3xl mb-1 block">receipt</span>
                                    Belum ada transaksi pembayaran yang tercatat.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($riwayatBayar as $bayar): ?>
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors">
                                    <td class="py-2.5 px-4 text-center text-gray-400 font-mono"><?= $no++ ?></td>
                                    <td class="py-2.5 px-4 text-gray-700 dark:text-gray-300 font-mono">
                                        <?= date('d/m/Y', strtotime($bayar['tanggal'])) ?>
                                    </td>
                                    <td class="py-2.5 px-4 text-right font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        <?= format_rupiah($bayar['jumlah']) ?>
                                    </td>
                                    <td class="py-2.5 px-4 text-gray-600 dark:text-gray-400">
                                        <?= esc($bayar['metode'] ?? 'Tunai') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kuitansi Card (1 Col) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center flex flex-col items-center justify-center space-y-3">
            <?php if ($statusLunas): ?>
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40 shadow-theme-xs">
                    <span class="material-symbols-outlined text-3xl">verified</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pembayaran Telah Lunas!</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kuitansi resmi sudah siap dicetak sebagai bukti pembayaran.</p>
                </div>
                <a href="<?= base_url('siswa/pembiayaan/kuitansi') ?>" target="_blank" rel="noopener"
                   class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 py-3 px-4 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-colors">
                    <span class="material-symbols-outlined text-base">print</span>
                    <span>Cetak Kuitansi Resmi</span>
                </a>
            <?php else: ?>
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500">
                    <span class="material-symbols-outlined text-3xl">lock</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Kuitansi Belum Tersedia</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kuitansi digital akan otomatis dapat dicetak setelah seluruh tagihan dilunasi.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
