<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('page_title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Welcome Glass -->
<div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-green-700 rounded-2xl shadow-lg p-5 mb-5">
    <div class="absolute -top-8 -right-8 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
    <div class="relative flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/25">
                <span class="text-white text-lg font-black"><?= esc(strtoupper(substr($siswa['nama_lengkap'], 0, 1))) ?></span>
            </div>
            <div>
                <p class="text-emerald-100 text-[10px] font-semibold uppercase tracking-wider">Selamat Datang,</p>
                <h3 class="text-white text-base font-bold leading-tight"><?= esc($siswa['nama_lengkap']) ?></h3>
                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded-md bg-white/15 border border-white/20">
                    <p class="text-[10px] text-emerald-50 font-mono tracking-tighter"><?= $siswa['no_pendaftaran'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
        <div class="mt-4 pt-4 border-t border-white/10">
            <p class="text-emerald-100/70 text-[10px] mb-2 italic">Untuk info lebih lanjut, bergabung di grup WhatsApp:</p>
            <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 active:scale-[0.97] text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-green-900/20">
                <i class="fab fa-whatsapp text-base"></i> BERGABUNG GRUP WHATSAPP
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Quick Stats Glass -->
<div class="grid grid-cols-2 gap-3 mb-5">
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-4">
        <div class="flex flex-col items-center text-center">
            <?php 
                $vColor = 'amber'; $vIcon = 'fa-hourglass-half'; $vLabel = 'Menunggu';
                if ($siswa['status_verifikasi'] == 'Terverifikasi') { $vColor = 'emerald'; $vIcon = 'fa-check-circle'; $vLabel = 'Terverifikasi'; }
                elseif ($siswa['status_verifikasi'] == 'Ditolak') { $vColor = 'rose'; $vIcon = 'fa-times-circle'; $vLabel = 'Ditolak'; }
            ?>
            <div class="w-11 h-11 rounded-xl bg-<?= $vColor ?>-50 text-<?= $vColor ?>-600 flex items-center justify-center mb-2.5">
                <i class="fas <?= $vIcon ?> text-lg"></i>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Verifikasi</p>
            <p class="text-sm font-extrabold text-<?= $vColor ?>-600 mt-0.5"><?= $vLabel ?></p>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-4">
        <div class="flex flex-col items-center text-center">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2.5">
                <span class="text-sm font-black"><?= $completionPercentage ?>%</span>
            </div>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Kelengkapan</p>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-700" style="width: <?= $completionPercentage ?>%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Info for Incomplete Data -->
<?php if (!empty($incompleteFields)): ?>
<div class="bg-amber-50/90 backdrop-blur-md border border-amber-200/50 rounded-2xl p-4 mb-5">
    <div class="flex gap-3">
        <div class="text-amber-600 mt-0.5"><i class="fas fa-exclamation-triangle"></i></div>
        <div>
            <p class="text-xs font-black text-amber-800 uppercase mb-1.5">Data Belum Lengkap!</p>
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

<!-- Main Menu Grid -->
<div class="mb-8">
    <div class="flex items-center justify-between px-1 mb-4">
        <h4 class="text-slate-800 font-black text-xs uppercase tracking-widest">Menu Layanan</h4>
        <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
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
        <a href="<?= base_url($m['url']) ?>" class="bg-white/80 backdrop-blur-md rounded-2xl p-4 flex flex-col items-center shadow-sm border border-white/20 active:scale-[0.95] active:bg-white/90 transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-<?= $m['color'] ?>-50 text-<?= $m['color'] ?>-600 flex items-center justify-center mb-2">
                <i class="fas <?= $m['icon'] ?> text-base"></i>
            </div>
            <p class="text-[10px] font-bold text-slate-700"><?= $m['label'] ?></p>
        </a>
        <?php endforeach; ?>

        <!-- Cetak Formulir -->
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
        <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?> class="col-span-2 bg-gradient-to-r from-rose-500 to-orange-500 rounded-2xl p-4 flex items-center justify-between shadow-lg shadow-rose-200/50 active:scale-[0.97] transition-all duration-200">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <p class="text-xs font-bold text-white uppercase tracking-tighter">Cetak Formulir</p>
            </div>
            <i class="fas fa-chevron-right text-white/40 text-xs"></i>
        </a>
    </div>
</div>

<!-- Timeline Glass -->
<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-5 mb-6">
    <h4 class="text-slate-800 font-black text-xs uppercase tracking-widest mb-5">Timeline Pendaftaran</h4>
    
    <div class="space-y-5">
        <div class="relative flex items-start gap-3">
            <div class="absolute h-full w-px bg-emerald-200 left-[15px] top-8"></div>
            <div class="w-[30px] h-[30px] rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-calendar-check text-[11px]"></i>
            </div>
            <div class="pt-1">
                <p class="text-xs font-bold text-slate-800 leading-none">Registrasi Akun</p>
                <p class="text-[10px] text-slate-500 mt-1"><?= $siswa['tgl_siswa'] ? date('d M Y', strtotime($siswa['tgl_siswa'])) : '-' ?></p>
            </div>
        </div>

        <div class="relative flex items-start gap-3">
            <div class="absolute h-full w-px bg-emerald-200 left-[15px] top-8"></div>
            <div class="w-[30px] h-[30px] rounded-full bg-blue-100 text-blue-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-user-edit text-[11px]"></i>
            </div>
            <div class="pt-1">
                <p class="text-xs font-bold text-slate-800 leading-none">Pengisian Data</p>
                <p class="text-[10px] text-slate-500 mt-1">Lengkapi Profil & Upload Berkas</p>
            </div>
        </div>

        <div class="flex items-start gap-3">
            <div class="w-[30px] h-[30px] rounded-full bg-amber-100 text-amber-600 flex items-center justify-center z-10 flex-shrink-0">
                <i class="fas fa-search text-[11px]"></i>
            </div>
            <div class="pt-1">
                <p class="text-xs font-bold text-slate-800 leading-none">Tahap Verifikasi</p>
                <p class="text-[10px] text-slate-500 mt-1">Pengecekan oleh Admin Sekolah</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
