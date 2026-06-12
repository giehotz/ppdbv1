<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Ubah Password
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Ubah Password
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                <i class="fas fa-key mr-2 text-blue-600"></i>Ubah Password
            </h3>
            <p class="text-sm text-gray-600">Pastikan password baru Anda kuat dan mudah diingat</p>
        </div>

        <form action="<?= base_url('siswa/profile/update-password') ?>" method="POST">
            <?= csrf_field() ?>

            <!-- Password Lama -->
            <div class="mb-4">
                <label for="password_lama" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Lama <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                        id="password_lama"
                        name="password_lama"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <button type="button"
                        onclick="togglePassword('password_lama')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye" id="password_lama-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label for="password_baru" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                        id="password_baru"
                        name="password_baru"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        minlength="6"
                        required>
                    <button type="button"
                        onclick="togglePassword('password_baru')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye" id="password_baru-icon"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="konfirmasi_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input type="password"
                        id="konfirmasi_password"
                        name="konfirmasi_password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        minlength="6"
                        required>
                    <button type="button"
                        onclick="togglePassword('konfirmasi_password')"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-eye" id="konfirmasi_password-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Password
                </button>
                <a href="<?= base_url('siswa/profile') ?>"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
        <h4 class="font-semibold text-blue-800 mb-2">
            <i class="fas fa-lightbulb mr-2"></i>Tips Password Aman:
        </h4>
        <ul class="text-sm text-blue-700 space-y-1">
            <li><i class="fas fa-check mr-2"></i>Gunakan kombinasi huruf besar, kecil, dan angka</li>
            <li><i class="fas fa-check mr-2"></i>Minimal 6 karakter (lebih panjang lebih baik)</li>
            <li><i class="fas fa-check mr-2"></i>Jangan gunakan informasi pribadi seperti tanggal lahir</li>
            <li><i class="fas fa-check mr-2"></i>Ganti password secara berkala</li>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
<?= $this->endSection() ?>