<?= $this->extend('pindahan/layouts/siswa_pindahan') ?>

<?= $this->section('title') ?>Upload Berkas Pindahan<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">upload_file</span> Upload Berkas Pindahan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$totalWajib = count($requiredDocs);
$totalUploaded = count($uploadedBerkas);
$percentComplete = $totalWajib > 0 ? round(($totalUploaded / $totalWajib) * 100) : 0;

$docIcons = [
    'surat_pindah_sekolah' => 'move_to_inbox',
    'surat_pindah_dapodik' => 'mail',
    'kk' => 'family_restroom',
    'ijazah' => 'school',
    'rapor' => 'grading',
    'surat_pernyataan' => 'gavel',
    'foto_siswa' => 'account_box',
    'sktm' => 'card_membership',
    'akta_kelahiran' => 'child_care',
    'ktp_orang_tua' => 'badge',
    'dokumen_lainnya' => 'description',
];
?>

<!-- Header Summary & Progress Banner -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
        <div class="flex items-start sm:items-center gap-4 flex-1">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 border border-brand-200/60 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-2xl">folder_shared</span>
            </div>
            <div class="space-y-1 flex-1">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Kelengkapan Berkas Pindahan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">Unggah dokumen persyaratan pindah asli (surat pindah sekolah, surat pindah Dapodik, KK, ijazah, surat pernyataan, dan foto siswa).</p>
                <div class="pt-1 flex flex-wrap items-center gap-3 text-[11px] font-medium text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs text-brand-500">picture_as_pdf</span> Format: JPG, PNG, PDF</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1"><span class="material-symbols-outlined text-xs text-brand-500">speed</span> Maks 2 MB / file</span>
                </div>
            </div>
        </div>
        <div class="shrink-0 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/70 dark:bg-gray-800/40 p-4 min-w-[200px]">
            <div class="flex items-center justify-between text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                <span>Progress</span>
                <span class="font-mono text-brand-600 dark:text-brand-400 font-bold"><?= $totalUploaded ?> / <?= $totalWajib ?></span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden mb-1.5">
                <div class="h-2 rounded-full transition-all duration-700 <?= $percentComplete == 100 ? 'bg-emerald-500' : 'bg-brand-500' ?>" style="width: <?= $percentComplete ?>%"></div>
            </div>
            <p class="text-[10px] text-right font-medium <?= $percentComplete == 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500' ?>">
                <?= $percentComplete == 100 ? 'Lengkap ✓' : 'Sisa ' . ($totalWajib - $totalUploaded) . ' berkas' ?>
            </p>
        </div>
    </div>
</div>

<!-- Document List Grid -->
<div class="space-y-4">
    <?php foreach ($requiredDocs as $jenis => $label): ?>
        <?php
        $isUploaded = isset($uploadedBerkas[$jenis]);
        $berkasItem = $isUploaded ? $uploadedBerkas[$jenis] : null;
        $iconName = $docIcons[$jenis] ?? 'description';
        $statusVerif = $berkasItem['status_verifikasi'] ?? 'pending';
        $isWajib = in_array($jenis, \App\Models\Pindahan\BerkasPindahanModel::JENIS_WAJIB, true);

        $statusBadge = match($statusVerif) {
            'valid'   => '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-500/15 dark:text-emerald-400 px-2 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800/40"><span class="material-symbols-outlined text-xs">check_circle</span> Tervalidasi</span>',
            'invalid' => '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 dark:bg-red-500/15 dark:text-red-400 px-2 py-0.5 rounded-full border border-red-200 dark:border-red-800/40"><span class="material-symbols-outlined text-xs">cancel</span> Ditolak</span>',
            default   => '<span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-500/15 dark:text-amber-400 px-2 py-0.5 rounded-full border border-amber-200 dark:border-amber-800/40"><span class="material-symbols-outlined text-xs">pending</span> Menunggu</span>',
        };
        ?>
        <div class="rounded-2xl border <?= $isUploaded ? 'border-emerald-100 dark:border-emerald-950/40' : 'border-gray-100 dark:border-gray-800' ?> bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md dark:bg-white/[0.02]">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 flex-1 min-w-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl shrink-0 <?= $isUploaded ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-400' ?>">
                        <span class="material-symbols-outlined text-2xl"><?= $iconName ?></span>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate"><?= esc($label) ?></h4>
                            <?php if ($isWajib): ?><span class="text-[10px] text-red-500 font-bold">WAJIB</span><?php endif; ?>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <?php if ($isUploaded): ?>
                                <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400">
                                    <?= esc($berkasItem['nama_file']) ?>
                                    (<?= round(($berkasItem['ukuran_file'] ?? 0) / 1024) ?> KB)
                                </span>
                            <?php else: ?>
                                <span class="text-[11px] font-medium text-gray-400 dark:text-gray-500">Belum diunggah</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <?php if ($isUploaded): ?>
                        <?= $statusBadge ?>
                        <?php
                        $filePath = $berkasItem['path_file'] ?? null;
                        if (empty($filePath)) {
                            $nisnP = $pindahan['nisn'] ?? '';
                            $filePath = 'uploads/berkas/' . rawurlencode($nisnP) . '/' . rawurlencode($berkasItem['nama_file']);
                        }
                        $fileUrl = base_url(ltrim($filePath, '/'));
                        ?>
                        <a href="<?= $fileUrl ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:text-brand-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors shadow-sm" title="Lihat">
                            <span class="material-symbols-outlined text-base">visibility</span>
                        </a>
                        <form action="<?= base_url('siswa/pindahan/berkas/delete/' . $berkasItem['id_berkas_pindahan']) ?>" method="post" onsubmit="return confirm('Hapus berkas ini?');" class="inline m-0">
                            <?= csrf_field() ?>
                            <button type="submit" class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400 transition-colors shadow-sm" title="Hapus">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
                <form action="<?= base_url('siswa/pindahan/berkas/upload') ?>" method="post" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="jenis_berkas" value="<?= $jenis ?>">
                    <input type="file" name="file_berkas" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full sm:w-64 text-xs text-gray-500 dark:text-gray-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/40 p-1">
                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 h-9 rounded-xl <?= $isUploaded ? 'bg-amber-500 hover:bg-amber-600' : 'bg-brand-500 hover:bg-brand-600' ?> px-4 text-xs font-bold text-white shadow-sm transition-all shrink-0">
                        <span class="material-symbols-outlined text-base">cloud_upload</span>
                        <span><?= $isUploaded ? 'Ganti' : 'Unggah' ?></span>
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Action Button -->
<div class="mt-6 flex justify-end">
    <a href="<?= base_url('siswa/pindahan/dashboard') ?>" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
        <span class="material-symbols-outlined text-base">arrow_back</span> Kembali ke Dashboard
    </a>
</div>

<?= $this->endSection() ?>