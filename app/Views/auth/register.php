<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <?php $page_title = 'Registrasi'; ?>
    <?= view('partials/_auth_head', ['page_title' => $page_title]) ?>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center relative overflow-x-hidden selection:bg-brand-500/20 selection:text-brand-600 px-4 py-10">

    <!-- Decorative Gradient Background Glows -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[50vw] h-[50vw] max-w-[500px] max-h-[500px] bg-brand-500/10 dark:bg-brand-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[45vw] h-[45vw] max-w-[450px] max-h-[450px] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl"></div>
    </div>

    <?php
    $schoolLogo = $web_logo ?? null;
    $hasLogo    = !empty($schoolLogo) && is_file(FCPATH . 'uploads/logo/' . $schoolLogo);
    ?>

    <!-- Main Register Card -->
    <div class="w-full max-w-lg bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-3xl border border-gray-200/80 dark:border-gray-800 p-8 sm:p-10 shadow-theme-md relative z-10">

        <!-- Header & Logo -->
        <div class="text-center mb-8">
            <?php if ($hasLogo): ?>
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white dark:bg-gray-800 p-2 mb-4 shadow-theme-xs border border-gray-200/80 dark:border-gray-700">
                    <img src="<?= base_url('uploads/logo/' . esc($schoolLogo, 'url')) ?>" alt="Logo Sekolah" class="h-full w-full object-contain" width="64" height="64" loading="eager">
                </div>
            <?php else: ?>
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 mb-4 shadow-theme-xs border border-brand-200/40 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-3xl">person_add</span>
                </div>
            <?php endif; ?>
            <h1 class="heading-font text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Registrasi Calon Siswa
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-1.5 font-medium">
                Buat akun pendaftaran peserta didik baru di <?= esc($app_alias ?? 'PPDB') ?>
            </p>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400 px-4 py-3 rounded-2xl mb-5 text-xs" role="alert">
                <p class="font-bold mb-1">Terdapat kesalahan pengisian:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400 px-4 py-3 rounded-2xl mb-5 text-xs" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="<?= base_url('auth/doRegister') ?>" method="post" class="space-y-4" autocomplete="on">
            <?= csrf_field() ?>

            <!-- NISN -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="nisn">
                    NISN (Nomor Induk Siswa Nasional) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">badge</span>
                    <input type="text" id="nisn" name="nisn" value="<?= old('nisn') ?>" required maxlength="10" inputmode="numeric" pattern="[0-9]{10}" placeholder="10 digit nomor NISN"
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm font-mono focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                </div>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-[11px] text-gray-400">NISN berupa 10 digit angka valid.</p>
                    <a href="https://nisn.data.kemendikdasmen.go.id/" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1 text-xs text-brand-600 dark:text-brand-400 hover:underline font-semibold">
                        <span>Cari NISN</span>
                        <span class="material-symbols-outlined text-xs">open_in_new</span>
                    </a>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="nama_lengkap">
                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">person</span>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required placeholder="Sesuai akta kelahiran / ijazah"
                           class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                </div>
            </div>

            <!-- Email & No HP Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="email">
                        Email Aktif <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">mail</span>
                        <input type="email" id="email" name="email" value="<?= old('email') ?>" required placeholder="contoh@gmail.com"
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="no_hp">
                        No. HP / WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">call</span>
                        <input type="tel" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" required inputmode="numeric" placeholder="08xxxxxxxxxx"
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm font-mono focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                    </div>
                </div>
            </div>

            <!-- Password & Confirm Password Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="password">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">lock</span>
                        <input type="password" id="password" name="password" required minlength="6" placeholder="Min. 6 karakter"
                               class="w-full pl-11 pr-12 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 flex items-center justify-center transition-colors focus:outline-none" title="Lihat Password">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="confirm_password">
                        Ulangi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">lock_reset</span>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Ulangi password"
                               class="w-full pl-11 pr-12 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs">
                        <button type="button" onclick="togglePassword('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 flex items-center justify-center transition-colors focus:outline-none" title="Lihat Password">
                            <span class="material-symbols-outlined text-lg">visibility_off</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-200 shadow-md shadow-brand-500/25 active:scale-[0.98] flex items-center justify-center gap-2 text-sm mt-4 cursor-pointer">
                <span>Daftar Calon Siswa Sekarang</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">
                Sudah memiliki akun terdaftar?
                <a href="<?= base_url('/login') ?>" class="text-brand-500 hover:text-brand-600 dark:text-brand-400 font-bold transition-colors">
                    Login di sini
                </a>
            </p>
        </div>

        <div class="text-center mt-4">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center justify-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-semibold transition-colors bg-gray-50 dark:bg-gray-800 px-3.5 py-2 rounded-xl border border-gray-200 dark:border-gray-700">
                <span class="material-symbols-outlined text-sm">home</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>

    <?= view('partials/sweetalert') ?>
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('span');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>
</body>

</html>
