<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Status Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Status
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-2xl shadow-sm mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-<?= $statusInfo['color'] ?>-500 to-<?= $statusInfo['color'] ?>-600 text-white p-5 text-center">
        <i class="fas <?= $statusInfo['icon'] ?> text-4xl mb-3 shadow-sm rounded-full bg-white/20 p-4"></i>
        <h2 class="text-xl font-bold mb-1 shadow-sm"><?= $statusInfo['text'] ?></h2>
        <p class="text-xs text-<?= $statusInfo['color'] ?>-100 opacity-90"><?= $statusInfo['description'] ?></p>
    </div>

    <div class="p-4">
        <!-- Student Information -->
        <h4 class="text-sm font-bold text-gray-800 mb-3 border-b pb-2">
            <i class="fas fa-user-circle mr-2 text-<?= $statusInfo['color'] ?>-500"></i>Info Pendaftaran
        </h4>

        <div class="space-y-3 mb-6">
            <div class="flex justify-between items-center bg-gray-50 rounded-xl p-3">
                <span class="text-xs text-gray-500">NISN</span>
                <span class="text-sm font-semibold text-gray-800"><?= $siswa['nisn'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between items-center bg-gray-50 rounded-xl p-3">
                <span class="text-xs text-gray-500">No. Daftar</span>
                <span class="text-sm font-semibold text-gray-800"><?= $siswa['no_pendaftaran'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between items-center bg-gray-50 rounded-xl p-3">
                <span class="text-xs text-gray-500">Nama</span>
                <span class="text-sm font-semibold text-gray-800 text-right"><?= $siswa['nama_lengkap'] ?? '-' ?></span>
            </div>
        </div>

        <?php if ($siswa['status_verifikasi'] == 'rejected' && !empty($siswa['catatan_verifikasi'])): ?>
            <!-- Rejection Note -->
            <div class="bg-red-50 border border-red-200 p-4 rounded-xl mb-6">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                    <div class="ml-3">
                        <h4 class="text-xs font-bold text-red-800 mb-1">Catatan Admin</h4>
                        <p class="text-xs text-red-700 leading-relaxed"><?= $siswa['catatan_verifikasi'] ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Links -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <a href="<?= base_url('siswa/biodata') ?>" class="bg-blue-50 text-blue-700 hover:bg-blue-100 p-3 rounded-xl text-center transition flex flex-col items-center justify-center gap-1 active:scale-95">
                <i class="fas fa-user-edit text-lg"></i>
                <span class="text-xs font-semibold">Biodata</span>
            </a>
            <a href="<?= base_url('siswa/berkas') ?>" class="bg-green-50 text-green-700 hover:bg-green-100 p-3 rounded-xl text-center transition flex flex-col items-center justify-center gap-1 active:scale-95">
                <i class="fas fa-file-upload text-lg"></i>
                <span class="text-xs font-semibold">Dokumen</span>
            </a>
        </div>

        <?php
            $url = base_url('siswa/cetak-formulir');
            $target = 'target="_blank"';
            $onClick = '';
            
            if (isset($completionPercentage) && $completionPercentage < 100) {
                $url = '#';
                $target = '';
                $onClick = 'onclick="alert(\'Silahkan lengkapi biodata untuk mencetak\'); return false;"';
            }
        ?>
        <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?> class="w-full flex items-center justify-center bg-blue-600 active:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl transition duration-200 shadow-md shadow-blue-100">
            <i class="fas fa-print mr-2"></i>
            Cetak Formulir Pendaftaran
        </a>
    </div>
</div>

<?= $this->endSection() ?>
