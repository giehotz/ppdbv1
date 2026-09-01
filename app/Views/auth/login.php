<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <?php $page_title = 'Login'; ?>
    <?= view('partials/_auth_head', ['page_title' => $page_title]) ?>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center relative overflow-x-hidden selection:bg-brand-500/20 selection:text-brand-600 px-4 py-8">

    <!-- Decorative Gradient Background Glows -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[50vw] h-[50vw] max-w-[500px] max-h-[500px] bg-brand-500/10 dark:bg-brand-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[45vw] h-[45vw] max-w-[450px] max-h-[450px] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl"></div>
    </div>

    <?php
    $schoolLogo = $web_logo ?? null;
    $hasLogo    = !empty($schoolLogo) && is_file(FCPATH . 'uploads/logo/' . $schoolLogo);
    ?>

    <!-- Main Login Card -->
    <div class="w-full max-w-md bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl rounded-3xl border border-gray-200/80 dark:border-gray-800 p-8 sm:p-10 shadow-theme-md relative z-10">

        <!-- Header & Logo -->
        <div class="text-center mb-8">
            <?php if ($hasLogo): ?>
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white dark:bg-gray-800 p-2 mb-4 shadow-theme-xs border border-gray-200/80 dark:border-gray-700">
                    <img src="<?= base_url('uploads/logo/' . esc($schoolLogo, 'url')) ?>" alt="Logo Sekolah" class="h-full w-full object-contain" width="64" height="64" loading="eager">
                </div>
            <?php else: ?>
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 mb-4 shadow-theme-xs border border-brand-200/40 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-3xl">school</span>
                </div>
            <?php endif; ?>
            <h1 class="heading-font text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Login <?= esc($app_alias ?? 'PPDB') ?>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mt-1.5 font-medium">
                Masuk untuk mengelola data dan proses pendaftaran Anda
            </p>
        </div>

        <!-- Login Form -->
        <form action="<?= base_url('/auth/login') ?>" method="post" class="space-y-4" autocomplete="on">
            <?= csrf_field() ?>

            <!-- Username / NISN -->
            <div>
                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-2" for="username">
                    Username / NISN / Email
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">person</span>
                    <input class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs"
                           id="username" name="username" type="text" placeholder="Masukkan ID atau NISN Anda" required autocomplete="username" autofocus>
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider" for="password">
                        Password
                    </label>
                    <button type="button" onclick="openForgotModal()" class="text-xs text-red-500 hover:text-red-600 dark:text-red-400 font-semibold transition-colors">
                        Lupa Password?
                    </button>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">lock</span>
                    <input class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-800/60 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-brand-300 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder:text-gray-400 shadow-theme-xs"
                           id="password" name="password" type="password" placeholder="••••••••••••" required autocomplete="current-password">
                </div>
            </div>

            <!-- Submit Button -->
            <button class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-200 shadow-md shadow-brand-500/25 active:scale-[0.98] flex items-center justify-center gap-2 text-sm mt-3 cursor-pointer" type="submit">
                <span>Masuk Sekarang</span>
                <span class="material-symbols-outlined text-base">login</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">
                Belum memiliki akun?
                <a href="<?= base_url('/auth/register') ?>" class="text-brand-500 hover:text-brand-600 dark:text-brand-400 font-bold transition-colors">
                    Daftar di sini
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

    <!-- Modal Lupa Password -->
    <div id="modal-forgot-pw" class="fixed inset-0 z-[99999] hidden" role="dialog" aria-modal="true" aria-labelledby="forgot-title">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop" onclick="closeForgotModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-800 w-full max-w-md transform transition-all scale-95 opacity-0 overflow-hidden" id="modal-panel">
                <form action="<?= base_url('/auth/forgot-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center mb-5">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-amber-50 dark:bg-amber-500/15 border border-amber-200/60 dark:border-amber-500/20 text-amber-600 dark:text-amber-400">
                                <span class="material-symbols-outlined text-2xl">key</span>
                            </div>
                            <div class="ml-3.5">
                                <h3 id="forgot-title" class="text-lg font-bold text-gray-900 dark:text-white">Lupa Password Akun</h3>
                                <p class="text-xs font-semibold text-amber-600 dark:text-amber-400 uppercase tracking-wider mt-0.5">Pemulihan Akun Siswa</p>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-5 leading-relaxed">
                            Masukkan nama lengkap dan NIK sesuai data pendaftaran. Panitia/Admin akan memverifikasi permohonan Anda sebelum mereset password.
                        </p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-1.5" for="fw-nama">Nama Lengkap</label>
                                <input type="text" id="fw-nama" name="nama" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all placeholder:text-gray-400" placeholder="Sesuai akta / KK" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider mb-1.5" for="fw-nik">NIK (16 Digit Angka)</label>
                                <input type="text" id="fw-nik" name="nik" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white text-sm focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all placeholder:text-gray-400 font-mono" placeholder="Contoh: 1806xxxxxxxxxxxx" maxlength="16" pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka" required>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 sm:px-8 py-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-end gap-3">
                        <button type="button" onclick="closeForgotModal()" class="px-5 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition text-xs shadow-theme-xs">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition shadow-theme-xs flex items-center gap-1.5 text-xs active:scale-[0.97]">
                            <span class="material-symbols-outlined text-sm">send</span>
                            <span>Kirim Permohonan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= view('partials/sweetalert') ?>

    <script>
        function openForgotModal() {
            const modal = document.getElementById('modal-forgot-pw');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');

            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.replace('opacity-0', 'opacity-100');
                panel.classList.replace('scale-95', 'scale-100');
                panel.classList.replace('opacity-0', 'opacity-100');
            });
            document.getElementById('fw-nama').focus();
        }

        function closeForgotModal() {
            const modal = document.getElementById('modal-forgot-pw');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');

            backdrop.classList.replace('opacity-100', 'opacity-0');
            panel.classList.replace('scale-100', 'scale-95');
            panel.classList.replace('opacity-100', 'opacity-0');

            setTimeout(() => modal.classList.add('hidden'), 250);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeForgotModal();
        });
    </script>
</body>

</html>
