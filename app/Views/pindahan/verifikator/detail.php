<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Detail Siswa Pindahan - <?= esc($siswa['nama_lengkap']) ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">swap_horiz</span> Detail Siswa Pindahan &amp; Verifikasi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$inisialP = mb_substr(trim($siswa['nama_lengkap'] ?? ''), 0, 1);
if (empty($inisialP)) $inisialP = 'S';

$berkasAll   = $berkasList ?? $uploadedBerkas ?? [];
$berkasArr   = [];
foreach ($berkasAll as $item) {
    $berkasArr[$item['jenis_berkas']] = $item;
}

$verifLogs = $verifikasiRiwayat ?? ($verifikasiLogs ?? ($riwayat ?? []));
if (!is_array($verifLogs)) $verifLogs = [];

$berkasWajibArr = $berkasWajib ?? null;

$this->setData([
    'inisialP'       => $inisialP,
    'berkasArr'      => $berkasArr,
    'verifLogs'      => $verifLogs,
    'berkasWajibArr' => $berkasWajibArr,
]);
?>

<?= $this->include('pindahan/verifikator/partials/_actions') ?>
<?= $this->include('pindahan/verifikator/partials/_hero') ?>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Bagian Kiri (Lebar 2 Kolom) -->
    <div class="xl:col-span-2 space-y-6">
        <?= $this->include('pindahan/verifikator/partials/_data') ?>
        <?= $this->include('pindahan/verifikator/partials/_sekolah') ?>
        <?= $this->include('pindahan/verifikator/partials/_orang_tua') ?>
        <?= $this->include('pindahan/verifikator/partials/_berkas') ?>
        <?= $this->include('pindahan/verifikator/partials/_riwayat') ?>
    </div>

    <!-- Bagian Kanan (Sidebar - Lebar 1 Kolom) -->
    <div class="xl:col-span-1 space-y-6">
        <?= $this->include('pindahan/verifikator/partials/_verifikasi') ?>
        <?= $this->include('pindahan/verifikator/partials/_ringkasan') ?>
        <?= $this->include('pindahan/verifikator/partials/_kesejahteraan') ?>
    </div>
</div>

<?= $this->endSection() ?>