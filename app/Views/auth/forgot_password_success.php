<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Reset Password - <?= $app_alias ?? 'PPDB' ?> Online</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
        </div>

        <h1 class="text-xl font-bold text-gray-800 mb-2">Permintaan Terkirim!</h1>
        <p class="text-gray-500 text-sm mb-6">Permintaan reset password Anda sedang menunggu persetujuan admin. Silakan konfirmasi melalui WhatsApp agar prosesnya lebih cepat.</p>

        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left text-sm">
            <div class="flex justify-between mb-1">
                <span class="text-gray-500">Nama:</span>
                <span class="font-semibold text-gray-800"><?= esc($nama) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">NIK:</span>
                <span class="font-semibold text-gray-800"><?= esc($nik) ?></span>
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
            <a href="<?= $wa_url ?>" target="_blank" class="inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-md w-full mb-3">
                <i class="fab fa-whatsapp text-xl"></i>
                Konfirmasi via WhatsApp
            </a>
        <?php endif; ?>

        <a href="<?= base_url('/login') ?>" class="inline-block text-sm text-green-600 hover:text-green-800 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke halaman Login
        </a>
    </div>
</body>

</html>
