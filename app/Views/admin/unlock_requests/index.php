<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Antrean Buka Kunci<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Antrean Permohonan Buka Kunci<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <h3 class="text-sm font-bold text-gray-800 dark:text-white">Daftar Permohonan Buka Kunci (Tertunda)</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Siswa memohon perbaikan biodata dan meminta Anda membuka kembali formulir pendaftaran yang sudah difinalisasi.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-5">Waktu Pengajuan</th>
                    <th class="py-3.5 px-5">Identitas Siswa</th>
                    <th class="py-3.5 px-5 w-1/3">Alasan / Pesan Siswa</th>
                    <th class="py-3.5 px-5 text-center">Aksi (Eksekusi)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($requests)) : ?>
                    <?php foreach ($requests as $r) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <div class="font-semibold text-gray-800 dark:text-gray-200"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500"><?= date('H:i:s', strtotime($r['created_at'])) ?> WIB</div>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-gray-900 dark:text-white block"><?= esc($r['nama_lengkap']) ?></span>
                                <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 font-mono text-[11px] font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 mt-1">
                                    <?= esc($r['no_pendaftaran']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="rounded-xl border border-amber-200 bg-amber-50/60 p-3 text-xs italic text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-200">
                                    "<?= esc($r['alasan']) ?>"
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="<?= base_url('admin/unlockrequest/approve/' . $r['id_request']) ?>" method="post" class="inline" data-confirm="Apakah Anda yakin menyetujui dan MEMBUKA KEMBALI form siswa ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-theme-xs transition-colors hover:bg-emerald-700">
                                            <i class="fas fa-check"></i> Terima & Buka
                                        </button>
                                    </form>

                                    <form action="<?= base_url('admin/unlockrequest/reject/' . $r['id_request']) ?>" method="post" class="inline" data-confirm="Tolak permohonan ini? (Data siswa akan tetap TERKUNCI FINAL)">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white shadow-theme-xs transition-colors hover:bg-red-600">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="py-12 px-5 text-center text-gray-400 dark:text-gray-500">
                            <i class="fas fa-check-circle text-4xl text-emerald-400/50 mb-3 block"></i>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tidak ada antrean permohonan buka kunci.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>