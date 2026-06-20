<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="flex items-center p-3 mb-4 text-emerald-800 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-check-circle mr-2 text-emerald-500"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-3 mb-4 text-rose-800 bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-exclamation-triangle mr-2 text-rose-500"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Profile Header Glass -->
<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 mb-4 overflow-hidden">
    <div class="h-20 bg-gradient-to-r from-emerald-500 to-green-600"></div>
    <div class="px-5 pb-5 pt-0 flex flex-col items-center -mt-10">
        <div class="relative mb-3">
            <?php
            $fotoPath = 'uploads/berkas/' . $siswa['nisn'] . '/' . ($siswa['foto'] ?? '');
            $displayFoto = (isset($siswa['foto']) && file_exists(FCPATH . $fotoPath))
                ? base_url($fotoPath)
                : base_url('assets/img/default-avatar.png');
            ?>
            <div class="w-20 h-20 rounded-full overflow-hidden border-[3px] border-white/90 shadow-md bg-white">
                <img src="<?= $displayFoto ?>" alt="Avatar" class="w-full h-full object-cover">
            </div>
            
            <button onclick="document.getElementById('foto-input').click()" class="absolute bottom-0 right-0 bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center border-2 border-white shadow-sm active:scale-90 transition">
                <i class="fas fa-camera text-[10px]"></i>
            </button>
        </div>

        <h2 class="text-base font-bold text-slate-800 text-center leading-tight mb-1"><?= esc($siswa['nama_lengkap']) ?></h2>
        <p class="text-[10px] font-semibold text-slate-500 mb-4 bg-slate-100/80 px-3 py-1 rounded-full"><i class="fas fa-id-card mr-1.5 opacity-70"></i><?= esc($siswa['nisn']) ?></p>

        <div class="grid grid-cols-2 gap-3 w-full">
            <div class="bg-blue-50/80 backdrop-blur-sm rounded-xl p-3 border border-blue-200/30 text-center">
                <p class="text-[10px] uppercase tracking-wide text-blue-600 font-bold mb-1">No. Daftar</p>
                <p class="text-sm font-black text-slate-800 font-mono"><?= esc($siswa['no_pendaftaran']) ?></p>
            </div>
            
            <?php
            $statusMap = ['0' => 'Menunggu', '1' => 'Terverifikasi', '2' => 'Ditolak'];
            $stVal = $siswa['status_verifikasi'] ?? '0';
            $statusText = $statusMap[$stVal] ?? $stVal;
            if (!isset($statusMap[$stVal])) $statusText = $stVal ?: 'Menunggu';
            
            $bg = 'bg-amber-50/80'; $border = 'border-amber-200/30'; $tc = 'text-amber-600'; $icon = 'fa-clock';
            if(strtolower($statusText) == 'terverifikasi') { $bg = 'bg-emerald-50/80'; $border = 'border-emerald-200/30'; $tc = 'text-emerald-600'; $icon = 'fa-check-circle'; }
            if(strtolower($statusText) == 'ditolak') { $bg = 'bg-rose-50/80'; $border = 'border-rose-200/30'; $tc = 'text-rose-600'; $icon = 'fa-times-circle'; }
            ?>
            
            <div class="<?= $bg ?> backdrop-blur-sm rounded-xl p-3 border <?= $border ?> text-center">
                <p class="text-[10px] uppercase tracking-wide <?= $tc ?> font-bold mb-1">Verifikasi</p>
                <p class="text-xs font-bold text-slate-800 flex items-center justify-center gap-1.5"><i class="fas <?= $icon ?> <?= $tc ?>"></i><?= esc($statusText) ?></p>
            </div>
        </div>

        <?php if (!empty($siswa['foto'])): ?>
            <button onclick="confirmDelete()" class="mt-4 w-full bg-rose-50/80 hover:bg-rose-100/80 text-rose-600 border border-rose-200/50 text-[10px] font-bold py-2.5 rounded-xl transition active:scale-[0.97]">
                <i class="fas fa-trash-alt mr-1.5"></i> Hapus Foto Saat Ini
            </button>
        <?php endif; ?>
    </div>
</div>

<form action="<?= base_url('siswa/profile/update-foto') ?>" method="POST" enctype="multipart/form-data" id="foto-form" class="hidden">
    <?= csrf_field() ?>
    <input type="file" id="foto-input" name="foto" accept="image/*" onchange="previewAndSubmit(this)">
</form>

<form action="<?= base_url('siswa/profile/delete-foto') ?>" method="POST" id="delete-foto-form" class="hidden">
    <?= csrf_field() ?>
</form>

<!-- Settings Menu Glass -->
<div class="mb-4">
    <h3 class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 ml-2">Akun & Pengaturan</h3>
    <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 overflow-hidden">
        <a href="<?= base_url('siswa/ubah-password') ?>" class="flex items-center gap-4 p-4 active:bg-slate-50/50 transition border-b border-slate-100/50">
            <div class="w-9 h-9 bg-indigo-50/80 rounded-xl flex items-center justify-center flex-shrink-0 text-indigo-600 border border-indigo-200/30">
                <i class="fas fa-lock text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-xs text-slate-800">Ubah Password</p>
                <p class="text-[10px] text-slate-500">Perbarui kata sandi akun Anda</p>
            </div>
            <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
        </a>
        
        <a href="<?= base_url('siswa/biodata') ?>" class="flex items-center gap-4 p-4 active:bg-slate-50/50 transition border-b border-slate-100/50">
            <div class="w-9 h-9 bg-teal-50/80 rounded-xl flex items-center justify-center flex-shrink-0 text-teal-600 border border-teal-200/30">
                <i class="fas fa-user-edit text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-xs text-slate-800">Update Biodata</p>
                <p class="text-[10px] text-slate-500">Lengkapi formulir registrasi PPDB</p>
            </div>
            <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
        </a>
        
        <a href="<?= base_url('logout') ?>" class="flex items-center gap-4 p-4 active:bg-rose-50/50 transition">
            <div class="w-9 h-9 bg-rose-50/80 rounded-xl flex items-center justify-center flex-shrink-0 text-rose-600 border border-rose-200/30">
                <i class="fas fa-sign-out-alt text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-xs text-rose-600">Logout</p>
                <p class="text-[10px] text-slate-500">Keluar dari sesi saat ini</p>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewAndSubmit(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 2 * 1024 * 1024) return alert('Maks 2MB');
            if (!file.type.match('image.*')) return alert('Hanya gambar');
            if (confirm('Update foto profil?')) document.getElementById('foto-form').submit();
            else input.value = '';
        }
    }
    function confirmDelete() {
        if (confirm('Hapus foto profil?')) document.getElementById('delete-foto-form').submit();
    }
</script>
<?= $this->endSection() ?>
