<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Ubah Password
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Ganti Kata Sandi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-xs font-semibold">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-xs">
        <ul class="list-disc list-inside">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm mb-6 p-4">
    <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-3">
        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center shrink-0">
            <i class="fas fa-lock text-lg"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-sm">Ubah Password Akun</h3>
            <p class="text-[10px] text-gray-500">Gunakan minimal 6 karakter kombinasi keamanan</p>
        </div>
    </div>

    <form action="<?= base_url('siswa/profile/update-password') ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1 ml-1">Password Lama <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="password" id="password_lama" name="password_lama" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors bg-gray-50" required>
                <button type="button" onclick="togglePassword('password_lama')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                    <i class="fas fa-eye" id="password_lama-icon"></i>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1 ml-1">Password Baru <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="password" id="password_baru" name="password_baru" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors bg-white" minlength="6" required>
                <button type="button" onclick="togglePassword('password_baru')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                    <i class="fas fa-eye" id="password_baru-icon"></i>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1 ml-1">Konfirmasi Password <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors bg-white" minlength="6" required>
                <button type="button" onclick="togglePassword('konfirmasi_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                    <i class="fas fa-eye" id="konfirmasi_password-icon"></i>
                </button>
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <a href="<?= base_url('siswa/profile') ?>" class="w-1/3 bg-gray-100 text-gray-600 font-bold py-3 rounded-xl text-center text-xs border border-gray-200 active:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white font-bold py-3 rounded-xl text-center text-xs shadow-md active:scale-[0.98] transition">
                Simpan Password
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
<?= $this->endSection() ?>
