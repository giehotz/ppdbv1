<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('page_title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Welcome & Profile -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-700 to-indigo-800 rounded-3xl shadow-xl p-6 mb-6">
    <!-- Ornamen Background -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
    
    <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 shadow-inner">
                <span class="text-white text-xl font-black"><?= esc(strtoupper(substr($siswa['nama_lengkap'], 0, 1))) ?></span>
            </div>
            <div>
                <p class="text-blue-100 text-xs font-medium tracking-wide uppercase">Selamat Datang,</p>
                <h3 class="text-white text-lg font-bold leading-tight"><?= esc($siswa['nama_lengkap']) ?></h3>
                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded bg-blue-500/30 border border-blue-400/30">
                     <p class="text-[10px] text-blue-50 font-mono tracking-tighter"><?= $siswa['no_pendaftaran'] ?></p>
                </div>
            </div>
            </div>
        </div>

        <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
            <div class="mt-5">
                <p class="text-blue-100/70 text-[10px] mb-2 italic ml-1">Untuk mengetahui info lebih lanjut silahkan bergabung di grup WhatsApp:</p>
                <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 active:scale-95 text-white text-xs font-black rounded-2xl transition-all shadow-lg shadow-green-900/20">
                    <i class="fab fa-whatsapp text-lg"></i> BERGABUNG GRUP WHATSAPP
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="grid grid-cols-2 gap-4 mb-6">
    <!-- Verification Status Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4">
        <div class="flex flex-col items-center text-center">
            <?php 
                $vColor = 'amber'; $vIcon = 'fa-hourglass-half'; $vLabel = 'Menunggu';
                if ($siswa['status_verifikasi'] == 'Terverifikasi') { $vColor = 'emerald'; $vIcon = 'fa-check-circle'; $vLabel = 'Terverifikasi'; }
                elseif ($siswa['status_verifikasi'] == 'Ditolak') { $vColor = 'rose'; $vIcon = 'fa-times-circle'; $vLabel = 'Ditolak'; }
            ?>
            <div class="w-12 h-12 rounded-2xl bg-<?= $vColor ?>-50 text-<?= $vColor ?>-600 flex items-center justify-center mb-3">
                <i class="fas <?= $vIcon ?> text-xl"></i>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Verifikasi</p>
            <p class="text-sm font-extrabold text-<?= $vColor ?>-600 mt-0.5"><?= $vLabel ?></p>
        </div>
    </div>

    <!-- Completion Progress Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                <span class="text-sm font-black"><?= $completionPercentage ?>%</span>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kelengkapan</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2.5">
                <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-700" style="width: <?= $completionPercentage ?>%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Main Menu Grid -->
<div class="mb-8">
    <div class="flex items-center justify-between px-1 mb-4">
        <h4 class="text-slate-800 font-black text-sm uppercase tracking-widest">Menu Layanan</h4>
        <span class="w-8 h-1 bg-blue-600 rounded-full"></span>
    </div>
    
    <div class="grid grid-cols-3 gap-3">
        <?php 
        $mobileMenus = [
            ['url' => 'siswa/biodata', 'icon' => 'fa-user-edit', 'label' => 'Biodata', 'color' => 'blue'],
            ['url' => 'siswa/berkas', 'icon' => 'fa-file-upload', 'label' => 'Berkas', 'color' => 'emerald'],
            ['url' => 'siswa/status', 'icon' => 'fa-tasks', 'label' => 'Status', 'color' => 'amber'],
            ['url' => 'siswa/pengumuman', 'icon' => 'fa-bullhorn', 'label' => 'Info', 'color' => 'violet'],
            ['url' => 'siswa/pesan', 'icon' => 'fa-envelope', 'label' => 'Pesan', 'color' => 'rose'],
            ['url' => 'siswa/kelulusan', 'icon' => 'fa-graduation-cap', 'label' => 'Kelulusan', 'color' => 'indigo'],
            ['url' => 'siswa/profile', 'icon' => 'fa-user-circle', 'label' => 'Profil', 'color' => 'teal'],
            ['url' => 'siswa/ubah-password', 'icon' => 'fa-key', 'label' => 'Sandi', 'color' => 'slate'],
        ];
        foreach ($mobileMenus as $m) :
        ?>
        <a href="<?= base_url($m['url']) ?>" class="bg-white rounded-3xl p-4 flex flex-col items-center shadow-sm border border-slate-50 active:scale-90 active:bg-slate-50 transition-all duration-200">
            <div class="w-11 h-11 rounded-2xl bg-<?= $m['color'] ?>-50 text-<?= $m['color'] ?>-600 flex items-center justify-center mb-2">
                <i class="fas <?= $m['icon'] ?> text-lg"></i>
            </div>
            <p class="text-[10px] font-bold text-slate-700"><?= $m['label'] ?></p>
        </a>
        <?php endforeach; ?>

        <!-- Full Width Action -->
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
        <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?> class="col-span-2 bg-gradient-to-r from-rose-500 to-orange-500 rounded-3xl p-4 flex items-center justify-between shadow-lg shadow-rose-200 active:scale-95 transition-all duration-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <p class="text-xs font-bold text-white uppercase tracking-tighter">Cetak Formulir</p>
            </div>
            <i class="fas fa-chevron-right text-white/50 text-xs"></i>
        </a>
    </div>
</div>

<!-- Alert Info for Incomplete Data -->
<?php if (!empty($incompleteFields)): ?>
<div class="bg-amber-50 border border-amber-100 rounded-3xl p-5 mb-6">
    <div class="flex gap-3">
        <div class="text-amber-600 mt-0.5"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <p class="text-xs font-black text-amber-800 uppercase mb-2">Data Belum Lengkap!</p>
            <ul class="space-y-1">
                <?php foreach ($incompleteFields as $field): ?>
                <li class="text-[10px] text-amber-700 flex items-center gap-2">
                    <div class="w-1 h-1 bg-amber-400 rounded-full"></div> <?= $field ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Timeline -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-6">
    <h4 class="text-slate-800 font-black text-xs uppercase tracking-widest mb-5">Timeline Pendaftaran</h4>
    
    <div class="space-y-6">
        <!-- Item 1 -->
        <div class="relative flex items-start gap-4">
            <div class="absolute h-full w-px bg-slate-100 left-4 top-8"></div>
            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-calendar-check text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-800 leading-none">Registrasi Akun</p>
                <p class="text-[10px] text-slate-500 mt-1"><?= $siswa['tgl_siswa'] ? date('d M Y', strtotime($siswa['tgl_siswa'])) : '-' ?></p>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="relative flex items-start gap-4">
            <div class="absolute h-full w-px bg-slate-100 left-4 top-8"></div>
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-user-edit text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-800 leading-none">Pengisian Data</p>
                <p class="text-[10px] text-slate-500 mt-1">Lengkapi Profil & Upload Berkas</p>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="flex items-start gap-4">
            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-search text-xs"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-800 leading-none">Tahap Verifikasi</p>
                <p class="text-[10px] text-slate-500 mt-1">Pengecekan oleh Admin Sekolah</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>