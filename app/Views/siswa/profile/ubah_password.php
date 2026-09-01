<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Ubah Password<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">lock_reset</span> Ubah Password Akun
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-xl mx-auto">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Ganti Kata Sandi</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pastikan password baru Anda minimal 6 karakter dan mudah Anda ingat.</p>
        </div>

        <form action="<?= base_url('siswa/profile/update-password') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>

            <!-- Password Lama -->
            <div>
                <label for="password_lama" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Password Lama Saat Ini <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" id="password_lama" name="password_lama" required
                        class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        placeholder="Masukkan password lama">
                    <button type="button" onclick="togglePassword('password_lama')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <span class="material-symbols-outlined text-base" id="password_lama-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password_baru" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" id="password_baru" name="password_baru" minlength="6" required
                        class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono"
                        placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePassword('password_baru')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <span class="material-symbols-outlined text-base" id="password_baru-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="konfirmasi_password" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                    Ulangi Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" minlength="6" required
                        class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono"
                        placeholder="Ketik ulang password baru">
                    <button type="button" onclick="togglePassword('konfirmasi_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <span class="material-symbols-outlined text-base" id="konfirmasi_password-icon">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-gray-100 dark:border-gray-800">
                <a href="<?= base_url('siswa/profile') ?>"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    <span>Kembali</span>
                </a>

                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Password Baru</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
</script>

<?= $this->endSection() ?>