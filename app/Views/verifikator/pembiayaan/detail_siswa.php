<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Pembiayaan - <?= esc($siswa['nama_lengkap']) ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pembiayaan - <?= esc($siswa['nama_lengkap']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Back Navigation & Action Bar -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <a href="<?= base_url('verifikator/pembiayaan') ?>"
       class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition active:scale-[0.97]">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        <span>Kembali ke Daftar Siswa</span>
    </a>

    <?php if ($statusLunas): ?>
        <a href="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/kuitansi') ?>" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
            <span class="material-symbols-outlined text-base">print</span>
            <span>Cetak Kuitansi Resmi PDF</span>
        </a>
    <?php endif; ?>
</div>

<!-- Info Siswa Card -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">badge</span>
                Identitas Calon Peserta Didik
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi data pendaftaran siswa yang bersangkutan</p>
        </div>
        <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-200/50 dark:border-blue-500/20">
            <?= esc($siswa['no_pendaftaran']) ?>
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200/70 dark:border-gray-700">
            <span class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">No. Pendaftaran</span>
            <p class="text-sm font-bold font-mono text-gray-900 dark:text-white"><?= esc($siswa['no_pendaftaran']) ?></p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200/70 dark:border-gray-700">
            <span class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</span>
            <p class="text-sm font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap']) ?></p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200/70 dark:border-gray-700">
            <span class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">NISN</span>
            <p class="text-sm font-bold font-mono text-gray-900 dark:text-white"><?= esc($siswa['nisn'] ?? '-') ?></p>
        </div>
        <div class="bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl border border-gray-200/70 dark:border-gray-700">
            <span class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</span>
            <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1">
                <?php if (($siswa['jk'] ?? '') === 'L'): ?>
                    <span class="material-symbols-outlined text-blue-500 text-base">male</span> Laki-laki
                <?php elseif (($siswa['jk'] ?? '') === 'P'): ?>
                    <span class="material-symbols-outlined text-pink-500 text-base">female</span> Perempuan
                <?php else: ?>
                    <?= esc($siswa['jk'] ?? '-') ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Kiri: Ringkasan, Tagihan Siswa & Riwayat Transaksi -->
    <div class="lg:col-span-2 space-y-6">

        <!-- 3 Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Total Tagihan -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Tagihan</span>
                    <span class="material-symbols-outlined text-gray-400 text-xl">account_balance</span>
                </div>
                <h4 class="mt-3 text-xl font-bold font-mono text-gray-900 dark:text-white"><?= format_rupiah($totalTagihan) ?></h4>
            </div>

            <!-- Sudah Dibayar -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Sudah Dibayar</span>
                    <span class="material-symbols-outlined text-emerald-500 text-xl">payments</span>
                </div>
                <h4 class="mt-3 text-xl font-bold font-mono text-emerald-600 dark:text-emerald-400"><?= format_rupiah($totalLunas) ?></h4>
            </div>

            <!-- Status Kelunasan -->
            <div class="rounded-2xl border p-5 shadow-theme-xs <?= $statusLunas ? 'border-emerald-200 bg-emerald-50/50 dark:border-emerald-500/20 dark:bg-emerald-500/10' : 'border-amber-200 bg-amber-50/50 dark:border-amber-500/20 dark:bg-amber-500/10' ?>">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider <?= $statusLunas ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400' ?>">Status</span>
                    <span class="material-symbols-outlined text-xl <?= $statusLunas ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' ?>">
                        <?= $statusLunas ? 'verified' : 'pending' ?>
                    </span>
                </div>
                <h4 class="mt-3 text-xl font-bold <?= $statusLunas ? 'text-emerald-700 dark:text-emerald-300' : 'text-amber-700 dark:text-amber-300' ?>">
                    <?= $statusLunas ? 'LUNAS' : 'Belum Lunas' ?>
                </h4>
            </div>
        </div>

        <!-- Daftar Tagihan Siswa Card -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Tagihan Pembiayaan Siswa</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Rincian item kewajiban biaya yang dibebankan kepada siswa</p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-800 px-3 py-1 text-xs font-bold text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                    <?= count($tagihan) ?> Item Tagihan
                </span>
            </div>

            <?php if (empty($tagihan)): ?>
                <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                    <span class="material-symbols-outlined text-4xl block mb-2">request_quote</span>
                    Belum ada item tagihan yang ditetapkan. Silakan tambahkan item di panel samping.
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($tagihan as $t): ?>
                        <div class="flex items-center justify-between p-4 rounded-2xl border transition-all <?= $t['status_bayar'] === 'lunas' ? 'border-emerald-500/50 bg-emerald-50/40 dark:border-emerald-500/20 dark:bg-emerald-500/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900' ?>">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl <?= $t['status_bayar'] === 'lunas' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' ?>">
                                    <span class="material-symbols-outlined text-lg"><?= $t['status_bayar'] === 'lunas' ? 'check_circle' : 'hourglass_top' ?></span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-sm text-gray-900 dark:text-white truncate"><?= esc($t['nama_item']) ?></p>
                                    <p class="text-xs font-mono font-semibold text-gray-500 dark:text-gray-400 mt-0.5"><?= format_rupiah($t['harga_satuan']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <?php if ($t['status_bayar'] === 'lunas'): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-800 dark:text-emerald-300">
                                        <span class="material-symbols-outlined text-xs">check</span> Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded-full bg-amber-50 dark:bg-amber-500/15 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-500/20">
                                        Belum Lunas
                                    </span>
                                    <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/hapus') ?>" method="post" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_tagihan" value="<?= $t['id_tagihan'] ?>">
                                        <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/15 transition" title="Hapus Tagihan">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Riwayat Pembayaran Card -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">history</span>
                        Riwayat Transaksi Pembayaran
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Log seluruh pembayaran yang sah dan tercatat di sistem</p>
                </div>
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 font-mono">
                    Total: <?= format_rupiah($totalLunas) ?>
                </span>
            </div>

            <?php if (empty($riwayatBayar)): ?>
                <div class="py-10 text-center text-gray-400 dark:text-gray-500">
                    <span class="material-symbols-outlined text-3xl block mb-1">payments</span>
                    Belum ada transaksi pembayaran yang dicatat.
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $no = 1; foreach ($riwayatBayar as $bayar): 
                        $bukti = !empty($bayar['bukti_pembayaran']) ? json_decode($bayar['bukti_pembayaran'], true) : [];
                    ?>
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 p-4 transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white font-mono">
                                        <?= $no++ ?>
                                    </span>
                                    <div>
                                        <p class="text-sm font-bold font-mono text-emerald-600 dark:text-emerald-400">
                                            <?= format_rupiah($bayar['jumlah']) ?>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <?= date('d/m/Y', strtotime($bayar['tanggal'])) ?> &bull; Metode: <b class="text-gray-700 dark:text-gray-300"><?= esc($bayar['metode'] ?? 'Tunai') ?></b>
                                            <?php if (!empty($bayar['diverifikasi_oleh'])): ?>
                                                &bull; Oleh: <span class="text-gray-600 dark:text-gray-400"><?= esc($bayar['diverifikasi_oleh']) ?></span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 self-end sm:self-center">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-500/20">
                                        <span class="material-symbols-outlined text-xs">verified</span> Tercatat
                                    </span>
                                    <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/pembayaran/hapus') ?>" method="post" class="inline" onsubmit="return confirm('PERINGATAN: Membatalkan transaksi ini akan menghapus catatan pembayaran dan mengembalikan status tagihan terkait menjadi BELUM LUNAS. Lanjutkan?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_pembayaran" value="<?= $bayar['id_pembayaran'] ?>">
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 px-2.5 py-1 text-xs font-semibold transition active:scale-[0.97]" title="Batalkan / Hapus Transaksi Ini">
                                            <span class="material-symbols-outlined text-xs">delete</span>
                                            <span>Batalkan</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <?php if (!empty($bayar['keterangan'])): ?>
                                <p class="text-xs text-gray-600 dark:text-gray-400 ml-10 mt-1 italic">
                                    "<?= esc($bayar['keterangan']) ?>"
                                </p>
                            <?php endif; ?>

                            <!-- Bukti Pembayaran Images -->
                            <div class="ml-10 mt-3 pt-3 border-t border-gray-200/60 dark:border-gray-700">
                                <?php if (!empty($bukti)): ?>
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <?php foreach ($bukti as $idx => $file): ?>
                                            <div class="relative group">
                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $file) ?>" target="_blank" class="block w-16 h-16 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-blue-500 shadow-theme-xs transition">
                                                    <img src="<?= base_url('uploads/bukti_pembayaran/' . $file) ?>" alt="Bukti" class="w-full h-full object-cover">
                                                </a>
                                                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/hapus-bukti') ?>" method="post" class="absolute -top-1.5 -right-1.5 hidden group-hover:block" onsubmit="return confirm('Hapus file bukti ini?')">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="id_pembayaran" value="<?= $bayar['id_pembayaran'] ?>">
                                                    <input type="hidden" name="index" value="<?= $idx ?>">
                                                    <button type="submit" class="bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700 shadow">
                                                        <span class="material-symbols-outlined text-xs">close</span>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Upload Bukti Tambahan -->
                                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/upload-bukti') ?>" method="post" enctype="multipart/form-data" class="inline-flex items-center">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_pembayaran" value="<?= $bayar['id_pembayaran'] ?>">
                                    <label class="inline-flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline cursor-pointer font-semibold">
                                        <span class="material-symbols-outlined text-base">add_a_photo</span>
                                        <span>Unggah Bukti Bayar Tambahan</span>
                                        <input type="file" name="bukti_pembayaran[]" multiple accept="image/*" class="hidden" onchange="this.form.submit()">
                                    </label>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Kolom Kanan: Tambah Tagihan & Form Catat Pembayaran -->
    <div class="space-y-6">

        <!-- Card Tambah Tagihan -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">add_task</span>
                    Tambah Tagihan Siswa
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tambahkan item pembiayaan baru untuk siswa ini</p>
            </div>

            <div class="space-y-4">
                <?php if (!empty($items)): ?>
                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah-semua') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">done_all</span>
                        <span>Tambah Semua Item Tersedia (<?= count($items) ?>)</span>
                    </button>
                </form>
                <div class="relative flex py-1 items-center">
                    <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                    <span class="flex-shrink mx-3 text-[11px] text-gray-400 uppercase font-semibold">Atau Pilih Satuan</span>
                    <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/tagihan/tambah') ?>" method="post" class="space-y-4">
                    <?= csrf_field() ?>
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Pilih Item Pembiayaan</label>
                        <?php if (empty($items)): ?>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400 italic text-center">
                                Seluruh item yang tersedia sudah ditambahkan ke tagihan siswa.
                            </div>
                        <?php else: ?>
                            <select name="item_id" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-blue-300 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                <option value="">-- Pilih Item Pembiayaan --</option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?= $item['id_item'] ?>"><?= esc($item['nama']) ?> - <?= format_rupiah($item['harga']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($items)): ?>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">add</span>
                        <span>Tambah ke Tagihan</span>
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Form Catat Pembayaran Resmi -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">payments</span>
                    Catat Pembayaran
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pilih item yang dibayarkan dan simpan transaksi</p>
            </div>

            <?php if ($totalTagihan == 0): ?>
                <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined text-4xl block mb-2 text-amber-500">assignment_late</span>
                    <p class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-1">Belum Ada Item Tagihan</p>
                    <p class="text-xs mb-4">Tambahkan item tagihan siswa terlebih dahulu melalui pilihan di atas untuk mencatat pembayaran.</p>
                </div>
            <?php elseif (empty($unpaidItems)): ?>
                <div class="py-8 text-center text-emerald-600 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-4xl block mb-2">check_circle</span>
                    <p class="text-xs font-bold">Semua tagihan sudah berstatus Lunas!</p>
                </div>
            <?php else: ?>
                <form action="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/bayar') ?>" method="post" enctype="multipart/form-data" id="formBayar" class="space-y-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tagihan_ids" id="tagihanIdsHidden" value="">

                    <!-- Checklist Item Belum Lunas -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Pilih Item yang Dibayar</label>
                            <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-bold text-blue-600 dark:text-blue-400">
                                <input type="checkbox" id="checkAllUnpaid" class="h-3.5 w-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span>Pilih Semua</span>
                            </label>
                        </div>
                        <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
                            <?php foreach ($unpaidItems as $unpaid): ?>
                                <label class="flex items-center justify-between p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/40 hover:border-blue-300 cursor-pointer transition select-unpaid-item">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <input type="checkbox" value="<?= $unpaid['id_tagihan'] ?>" data-harga="<?= $unpaid['harga_satuan'] ?>" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 unpaid-check">
                                        <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate"><?= esc($unpaid['nama_item']) ?></span>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400 shrink-0 ml-2">
                                        <?= format_rupiah($unpaid['harga_satuan']) ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Jumlah Bayar -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Jumlah Nominal Pembayaran (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" id="inputJumlahBayar" required min="1" readonly
                               class="w-full rounded-xl border border-gray-300 bg-gray-100 dark:bg-gray-800 px-4 py-2.5 text-base font-bold font-mono text-emerald-600 dark:text-emerald-400 shadow-theme-xs outline-none" placeholder="0">
                        <p class="mt-1 text-[11px] text-gray-400">Nominal terhitung otomatis dari item yang dipilih di atas.</p>
                    </div>

                    <!-- Tanggal Bayar -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Tanggal Transaksi <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>"
                               class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-blue-300 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    </div>

                    <!-- Metode Bayar -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
                        <select name="metode" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-blue-300 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            <option value="Tunai">Tunai / Cash (Langsung di Sekolah)</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Catatan / Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan transaksi..."
                                  class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-blue-300 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none"></textarea>
                    </div>

                    <!-- Upload Bukti -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Bukti Pembayaran (Opsional)</label>
                        <input type="file" name="bukti_pembayaran[]" multiple accept="image/*"
                               class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 dark:file:bg-blue-500/15 dark:file:text-blue-400 file:cursor-pointer file:transition-colors">
                    </div>

                    <button type="submit" id="btnSubmitBayar"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-3 text-xs font-bold text-white shadow-theme-xs transition-all active:scale-[0.97]">
                        <span class="material-symbols-outlined text-base">savings</span>
                        <span>Catat Pembayaran Sekarang</span>
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Card Status Kuitansi -->
        <?php if ($statusLunas): ?>
            <div class="rounded-2xl border border-emerald-200/80 bg-emerald-50/60 dark:border-emerald-500/20 dark:bg-emerald-500/10 p-6 text-center shadow-theme-xs">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400 mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl">verified</span>
                </div>
                <h3 class="text-base font-bold text-emerald-900 dark:text-emerald-200 mb-1">Pembayaran Lunas!</h3>
                <p class="text-xs text-emerald-700 dark:text-emerald-400 mb-5 leading-relaxed">Seluruh tagihan pembiayaan telah dibayarkan penuh.</p>
                <a href="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa'] . '/kuitansi') ?>" target="_blank"
                   class="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">print</span>
                    <span>Cetak Kuitansi Resmi</span>
                </a>
            </div>
        <?php else: ?>
            <div class="rounded-2xl border border-amber-200/80 bg-amber-50/60 dark:border-amber-500/20 dark:bg-amber-500/10 p-6 text-center shadow-theme-xs">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400 mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl">pending_actions</span>
                </div>
                <h3 class="text-base font-bold text-amber-900 dark:text-amber-200 mb-1">Tagihan Belum Lunas</h3>
                <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
                    Masih ada <b><?= count($unpaidItems) ?> item</b> yang belum diselesaikan. Kuitansi resmi dapat dicetak setelah status tagihan lunas.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Logic Checklist Item Belum Lunas & Hitung Total Bayar
const checkAllUnpaid = document.getElementById('checkAllUnpaid');
const inputJumlahBayar = document.getElementById('inputJumlahBayar');
const tagihanIdsHidden = document.getElementById('tagihanIdsHidden');
const unpaidChecks = document.querySelectorAll('.unpaid-check');
const formBayar = document.getElementById('formBayar');
const btnSubmitBayar = document.getElementById('btnSubmitBayar');

function kalkulasiTotalBayar() {
    let total = 0;
    let ids = [];
    unpaidChecks.forEach(cb => {
        if (cb.checked) {
            total += parseInt(cb.dataset.harga) || 0;
            ids.push(cb.value);
            cb.closest('.select-unpaid-item').classList.add('border-emerald-500', 'bg-emerald-50/50', 'dark:bg-emerald-500/15');
        } else {
            cb.closest('.select-unpaid-item').classList.remove('border-emerald-500', 'bg-emerald-50/50', 'dark:bg-emerald-500/15');
        }
    });

    if (inputJumlahBayar) inputJumlahBayar.value = total;
    if (tagihanIdsHidden) tagihanIdsHidden.value = ids.join(',');

    if (checkAllUnpaid) {
        checkAllUnpaid.checked = unpaidChecks.length > 0 && [...unpaidChecks].every(cb => cb.checked);
    }
}

if (checkAllUnpaid) {
    checkAllUnpaid.addEventListener('change', function() {
        unpaidChecks.forEach(cb => { cb.checked = this.checked; });
        kalkulasiTotalBayar();
    });
}

unpaidChecks.forEach(cb => {
    cb.addEventListener('change', kalkulasiTotalBayar);
});

if (unpaidChecks.length > 0) {
    unpaidChecks.forEach(cb => { cb.checked = true; });
    kalkulasiTotalBayar();
}

// Client-Side Double-Submit Guard
if (formBayar) {
    formBayar.addEventListener('submit', function(e) {
        if (parseInt(inputJumlahBayar.value) <= 0) {
            e.preventDefault();
            alert('Pilih setidaknya satu item tagihan yang akan dibayar.');
            return false;
        }

        if (btnSubmitBayar) {
            btnSubmitBayar.disabled = true;
            btnSubmitBayar.classList.add('opacity-75', 'cursor-not-allowed');
            btnSubmitBayar.innerHTML = '<span class="material-symbols-outlined animate-spin text-base mr-1">progress_activity</span> Menyimpan Transaksi...';
        }
    });
}
</script>

<?= $this->endSection() ?>
