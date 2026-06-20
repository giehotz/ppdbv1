<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Ubah Password
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Ganti Kata Sandi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-3 mb-4 text-rose-800 bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 rounded-xl text-xs font-bold">
        <i class="fas fa-exclamation-triangle mr-2 text-rose-500"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="flex items-start p-3 mb-4 text-rose-800 bg-rose-50/80 backdrop-blur-sm border border-rose-200/50 rounded-xl text-xs">
        <i class="fas fa-exclamation-circle mr-2 text-rose-500 mt-0.5"></i>
        <ul class="list-disc list-inside">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 mb-6 p-5">
    <div class="flex items-center gap-3 mb-5 border-b border-slate-100/50 pb-3">
        <div class="w-9 h-9 bg-emerald-50/80 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 border border-emerald-200/30">
            <i class="fas fa-lock text-sm"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Ubah Password Akun</h3>
            <p class="text-[10px] text-slate-500">Gunakan minimal 6 karakter kombinasi keamanan</p>
        </div>
    </div>

    <form action="<?= base_url('siswa/profile/update-password') ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>

        <div>
            <label class="block text-[10px] font-semibold text-slate-600 mb-1 ml-1">Password Lama <span class="text-rose-500">*</span></label>
            <div class="relative">
                <input type="password" id="password_lama" name="password_lama" class="w-full border border-slate-200/70 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-colors bg-slate-50/50" required>
                <button type="button" onclick="togglePassword('password_lama')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                    <i class="fas fa-eye text-xs" id="password_lama-icon"></i>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-semibold text-slate-600 mb-1 ml-1">Password Baru <span class="text-rose-500">*</span></label>
            <div class="relative">
                <input type="password" id="password_baru" name="password_baru" class="w-full border border-slate-200/70 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-colors bg-white/50" minlength="6" required>
                <button type="button" onclick="togglePassword('password_baru')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                    <i class="fas fa-eye text-xs" id="password_baru-icon"></i>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-semibold text-slate-600 mb-1 ml-1">Konfirmasi Password <span class="text-rose-500">*</span></label>
            <div class="relative">
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="w-full border border-slate-200/70 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/30 transition-colors bg-white/50" minlength="6" required>
                <button type="button" onclick="togglePassword('konfirmasi_password')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1">
                    <i class="fas fa-eye text-xs" id="konfirmasi_password-icon"></i>
                </button>
            </div>
        </div>

        <div class="pt-4 flex gap-3">
            <a href="<?= base_url('siswa/profile') ?>" class="w-1/3 bg-slate-100/80 backdrop-blur-sm text-slate-600 font-bold py-3 rounded-xl text-center text-[10px] border border-slate-200/50 active:bg-slate-200/80 active:scale-[0.97] transition">
                Batal
            </a>
            <button type="submit" class="w-2/3 bg-emerald-600 text-white font-bold py-3 rounded-xl text-center text-xs shadow-md active:scale-[0.97] transition">
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
