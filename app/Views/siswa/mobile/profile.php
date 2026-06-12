<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-xs font-semibold">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-xs font-semibold">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Profile Header -->
<div class="bg-white rounded-2xl shadow-sm mb-4 overflow-hidden relative">
    <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
    <div class="px-5 pb-5 pt-0 flex flex-col items-center">
        <!-- Photo -->
        <div class="relative -mt-12 mb-3">
            <?php
            $fotoPath = 'uploads/berkas/' . $siswa['nisn'] . '/' . ($siswa['foto'] ?? '');
            $displayFoto = (isset($siswa['foto']) && file_exists(FCPATH . $fotoPath))
                ? base_url($fotoPath)
                : base_url('assets/img/default-avatar.png');
            ?>
            <img src="<?= $displayFoto ?>" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md bg-white">
            
            <button onclick="document.getElementById('foto-input').click()" class="absolute bottom-0 right-0 bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white shadow-sm active:scale-90 transition">
                <i class="fas fa-camera text-xs"></i>
            </button>
        </div>

        <!-- Info -->
        <h2 class="text-lg font-bold text-gray-800 text-center leading-tight mb-1"><?= esc($siswa['nama_lengkap']) ?></h2>
        <p class="text-xs font-semibold text-gray-500 mb-4 bg-gray-100 px-3 py-1 rounded-full"><i class="fas fa-id-card mr-1.5 opacity-70"></i><?= esc($siswa['nisn']) ?></p>

        <div class="grid grid-cols-2 gap-3 w-full">
            <div class="bg-blue-50 rounded-xl p-3 border border-blue-100 text-center">
                <p class="text-[10px] uppercase tracking-wide text-blue-600 font-bold mb-1">No. Daftar</p>
                <p class="text-sm font-black text-gray-800 font-mono"><?= esc($siswa['no_pendaftaran']) ?></p>
            </div>
            
            <?php
            $statusMap = ['0' => 'Menunggu', '1' => 'Terverifikasi', '2' => 'Ditolak'];
            $stVal = $siswa['status_verifikasi'] ?? '0';
            $statusText = $statusMap[$stVal] ?? $stVal;
            if (!isset($statusMap[$stVal])) $statusText = $stVal ?: 'Menunggu';
            
            $bg = 'bg-yellow-50'; $border = 'border-yellow-100'; $tc = 'text-yellow-600'; $icon = 'fa-clock';
            if(strtolower($statusText) == 'terverifikasi') { $bg = 'bg-green-50'; $border = 'border-green-100'; $tc = 'text-green-600'; $icon = 'fa-check-circle'; }
            if(strtolower($statusText) == 'ditolak') { $bg = 'bg-red-50'; $border = 'border-red-100'; $tc = 'text-red-600'; $icon = 'fa-times-circle'; }
            ?>
            
            <div class="<?= $bg ?> rounded-xl p-3 border <?= $border ?> text-center">
                <p class="text-[10px] uppercase tracking-wide <?= $tc ?> font-bold mb-1">Verifikasi</p>
                <p class="text-xs font-bold text-gray-800 flex items-center justify-center gap-1.5"><i class="fas <?= $icon ?> <?= $tc ?>"></i><?= esc($statusText) ?></p>
            </div>
        </div>

        <?php if (!empty($siswa['foto'])): ?>
            <button onclick="confirmDelete()" class="mt-4 w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 text-xs font-bold py-2.5 rounded-xl transition">
                <i class="fas fa-trash-alt mr-1.5"></i> Hapus Foto Saat Ini
            </button>
        <?php endif; ?>
    </div>
</div>

<!-- Forms -->
<form action="<?= base_url('siswa/profile/update-foto') ?>" method="POST" enctype="multipart/form-data" id="foto-form" class="hidden">
    <?= csrf_field() ?>
    <input type="file" id="foto-input" name="foto" accept="image/*" onchange="previewAndSubmit(this)">
</form>

<form action="<?= base_url('siswa/profile/delete-foto') ?>" method="POST" id="delete-foto-form" class="hidden">
    <?= csrf_field() ?>
</form>

<!-- Settings Menu -->
<div class="mb-4">
    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-2">Akun & Pengaturan</h3>
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
        <a href="<?= base_url('siswa/ubah-password') ?>" class="flex items-center gap-4 p-4 active:bg-gray-50 transition border-b border-gray-100">
            <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center flex-shrink-0 text-indigo-600 border border-indigo-100">
                <i class="fas fa-lock"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-sm text-gray-800">Ubah Password</p>
                <p class="text-[11px] text-gray-500">Perbarui kata sandi akun Anda</p>
            </div>
            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        </a>
        
        <a href="<?= base_url('siswa/biodata') ?>" class="flex items-center gap-4 p-4 active:bg-gray-50 transition border-b border-gray-100">
            <div class="w-10 h-10 bg-teal-50 rounded-full flex items-center justify-center flex-shrink-0 text-teal-600 border border-teal-100">
                <i class="fas fa-user-edit"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-sm text-gray-800">Update Biodata</p>
                <p class="text-[11px] text-gray-500">Lengkapi formulir registrasi PPDB</p>
            </div>
            <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        </a>
        
        <a href="<?= base_url('logout') ?>" class="flex items-center gap-4 p-4 active:bg-red-50 transition">
            <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0 text-red-600 border border-red-100">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <div class="flex-1">
                <p class="font-bold text-sm text-red-600">Logout</p>
                <p class="text-[11px] text-gray-500">Keluar dari sesi saat ini</p>
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
        if (confirm('Hapus foto pofil?')) document.getElementById('delete-foto-form').submit();
    }
</script>
<?= $this->endSection() ?>
