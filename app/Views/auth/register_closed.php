<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <?php $page_title = 'Pendaftaran Ditutup'; ?>
    <?= view('partials/_auth_head', ['page_title' => $page_title]) ?>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Glow -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[50vw] h-[50vw] max-w-[500px] max-h-[500px] bg-red-500/10 dark:bg-red-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl rounded-3xl border border-gray-200/80 dark:border-gray-800 shadow-theme-md w-full max-w-md text-center p-8 sm:p-10 relative z-10">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 mb-5 border border-red-200/50 dark:border-red-500/20 shadow-theme-xs">
            <span class="material-symbols-outlined text-3xl">lock_clock</span>
        </div>

        <h1 class="heading-font text-2xl font-bold text-gray-900 dark:text-white mb-2">Pendaftaran Ditutup</h1>

        <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-6 leading-relaxed">
            Mohon maaf, Penerimaan Peserta Didik Baru (<b><?= esc($app_alias ?? 'PPDB') ?></b>) saat ini sedang tidak menerima pendaftaran akun baru.
        </p>

        <p class="text-gray-400 dark:text-gray-500 text-xs mb-8">
            Silakan hubungi panitia pendaftaran atau pantau pengumuman di halaman utama untuk jadwal gelombang berikutnya.
        </p>

        <div class="space-y-3">
            <a href="<?= base_url('/login') ?>"
               class="inline-flex items-center justify-center gap-2 w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 px-4 rounded-xl transition shadow-theme-xs text-xs active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">login</span>
                <span>Masuk ke Akun Terdaftar</span>
            </a>

            <a href="<?= base_url('/') ?>"
               class="inline-flex items-center justify-center gap-2 w-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold py-3 px-4 rounded-xl transition text-xs shadow-theme-xs">
                <span class="material-symbols-outlined text-base">home</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>

</body>

</html>
