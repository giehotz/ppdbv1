<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Status Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Status
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-<?= $statusInfo['color'] ?>-500 to-<?= $statusInfo['color'] ?>-600 p-5 text-center">
        <i class="fas <?= $statusInfo['icon'] ?> text-3xl mb-3 shadow-sm rounded-full bg-white/20 p-3.5"></i>
        <h2 class="text-lg font-bold text-white mb-1"><?= $statusInfo['text'] ?></h2>
        <p class="text-[10px] text-<?= $statusInfo['color'] ?>-100/80"><?= $statusInfo['description'] ?></p>
    </div>

    <div class="p-4">
        <h4 class="text-xs font-bold text-slate-800 mb-3 border-b border-slate-100/50 pb-2">
            <i class="fas fa-user-circle mr-2 text-<?= $statusInfo['color'] ?>-500"></i>Info Pendaftaran
        </h4>

        <div class="space-y-2.5 mb-5">
            <div class="flex justify-between items-center bg-slate-50/60 backdrop-blur-sm rounded-xl p-3 border border-slate-200/30">
                <span class="text-[10px] text-slate-500">NISN</span>
                <span class="text-xs font-semibold text-slate-800"><?= $siswa['nisn'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between items-center bg-slate-50/60 backdrop-blur-sm rounded-xl p-3 border border-slate-200/30">
                <span class="text-[10px] text-slate-500">No. Daftar</span>
                <span class="text-xs font-semibold text-slate-800"><?= $siswa['no_pendaftaran'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between items-center bg-slate-50/60 backdrop-blur-sm rounded-xl p-3 border border-slate-200/30">
                <span class="text-[10px] text-slate-500">Nama</span>
                <span class="text-xs font-semibold text-slate-800 text-right"><?= $siswa['nama_lengkap'] ?? '-' ?></span>
            </div>
        </div>

        <?php if ($siswa['status_verifikasi'] == 'rejected' && !empty($siswa['catatan_verifikasi'])): ?>
            <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 p-4 rounded-xl mb-5">
                <div class="flex">
                    <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
                    <div class="ml-3">
                        <h4 class="text-[10px] font-bold text-rose-800 mb-1">Catatan Admin</h4>
                        <p class="text-[10px] text-rose-700 leading-relaxed"><?= $siswa['catatan_verifikasi'] ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-2 gap-3 mb-4">
            <a href="<?= base_url('siswa/biodata') ?>" class="bg-blue-50/80 backdrop-blur-sm text-blue-700 hover:bg-blue-100/80 p-3 rounded-xl text-center transition flex flex-col items-center justify-center gap-1 active:scale-[0.95] border border-blue-200/30">
                <i class="fas fa-user-edit text-base"></i>
                <span class="text-[10px] font-semibold">Biodata</span>
            </a>
            <a href="<?= base_url('siswa/berkas') ?>" class="bg-emerald-50/80 backdrop-blur-sm text-emerald-700 hover:bg-emerald-100/80 p-3 rounded-xl text-center transition flex flex-col items-center justify-center gap-1 active:scale-[0.95] border border-emerald-200/30">
                <i class="fas fa-file-upload text-base"></i>
                <span class="text-[10px] font-semibold">Dokumen</span>
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
        <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?> class="w-full flex items-center justify-center bg-emerald-600 active:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl transition duration-200 shadow-md shadow-emerald-100/50 active:scale-[0.97]">
            <i class="fas fa-print mr-2"></i>
            Cetak Formulir Pendaftaran
        </a>
    </div>
</div>

<?= $this->endSection() ?>
