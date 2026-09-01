<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <?php $page_title = 'Reset Password'; ?>
    <?= view('partials/_auth_head', ['page_title' => $page_title]) ?>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Glow -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[50vw] h-[50vw] max-w-[500px] max-h-[500px] bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl p-8 sm:p-10 rounded-3xl border border-gray-200/80 dark:border-gray-800 shadow-theme-md w-full max-w-md text-center relative z-10">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 mb-5 border border-emerald-200/50 dark:border-emerald-500/20 shadow-theme-xs">
            <span class="material-symbols-outlined text-3xl">verified</span>
        </div>

        <h1 class="heading-font text-2xl font-bold text-gray-900 dark:text-white mb-2">Permohonan Terkirim!</h1>
        <p class="text-gray-500 dark:text-gray-400 text-xs sm:text-sm mb-6 leading-relaxed">
            Permintaan reset password Anda telah berhasil dicatat dan sedang menunggu verifikasi panitia/admin.
        </p>

        <div class="bg-gray-50 dark:bg-gray-800/60 rounded-2xl p-4 mb-6 text-left text-xs border border-gray-200/80 dark:border-gray-700 space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-gray-400 uppercase font-bold text-[10px]">Nama Siswa:</span>
                <span class="font-bold text-gray-900 dark:text-white"><?= esc($nama) ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-400 uppercase font-bold text-[10px]">NIK:</span>
                <span class="font-bold font-mono text-gray-900 dark:text-white"><?= esc($nik) ?></span>
            </div>
        </div>

        <?php if (!empty($wa_admin_number)): ?>
            <?php
            $pesan_wa = "Halo Admin, saya ingin mengonfirmasi permintaan reset password.\n\n"
                . "Nama: " . $nama . "\n"
                . "NIK: " . $nik . "\n\n"
                . "Mohon bantuannya untuk mereset password akun saya. Terima kasih.";
            $wa_url = "https://wa.me/" . $wa_admin_number . "?text=" . urlencode($pesan_wa);
            ?>
            <a href="<?= $wa_url ?>" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-theme-xs w-full mb-3 text-xs active:scale-[0.97]">
                <span class="material-symbols-outlined text-base">chat</span>
                <span>Konfirmasi via WhatsApp</span>
            </a>
        <?php endif; ?>

        <a href="<?= base_url('/login') ?>"
           class="inline-flex items-center justify-center gap-1.5 text-xs text-brand-600 dark:text-brand-400 hover:underline font-bold mt-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Kembali ke Halaman Login</span>
        </a>
    </div>

</body>

</html>
