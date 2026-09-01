<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Ubah Password<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Ganti Kata Sandi<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
        
        <div class="pb-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">Ubah Kata Sandi</h3>
            <p class="text-[10px] text-gray-400 mt-0.5">Gunakan password minimal 6 karakter kombinasi yang kuat.</p>
        </div>

        <form action="<?= base_url('siswa/profile/update-password') ?>" method="POST" class="space-y-3">
            <?= csrf_field() ?>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Password Lama <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" id="password_lama" name="password_lama" required
                        class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        placeholder="Password lama">
                    <button type="button" onclick="togglePassword('password_lama')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <span class="material-symbols-outlined text-base" id="password_lama-icon">visibility</span>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Password Baru <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" id="password_baru" name="password_baru" minlength="6" required
                        class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePassword('password_baru')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <span class="material-symbols-outlined text-base" id="password_baru-icon">visibility</span>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Ulangi Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" minlength="6" required
                        class="h-10 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-10 pl-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        placeholder="Ketik ulang password baru">
                    <button type="button" onclick="togglePassword('konfirmasi_password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <span class="material-symbols-outlined text-base" id="konfirmasi_password-icon">visibility</span>
                    </button>
                </div>
            </div>

            <div class="pt-3 flex gap-2">
                <a href="<?= base_url('siswa/profile') ?>"
                   class="w-1/3 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Batal
                </a>
                <button type="submit"
                        class="w-2/3 inline-flex items-center justify-center gap-1 rounded-xl bg-brand-500 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan</span>
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
