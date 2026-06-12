<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ditutup - <?= $app_alias ?? 'PPDB' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-red-50 to-red-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md text-center overflow-hidden">
        <div class="bg-red-600 text-white p-6">
            <i class="fas fa-door-closed text-5xl mb-4"></i>
            <h2 class="text-2xl font-bold">Pendaftaran Ditutup</h2>
        </div>

        <div class="p-8">
            <p class="text-gray-700 mb-6 text-lg">
                Mohon maaf, Pendaftaran Peserta Didik Baru (<?= $app_alias ?? 'PPDB' ?>) saat ini sedang <strong>DITUTUP</strong>.
            </p>

            <p class="text-gray-600 mb-8">
                Silakan hubungi panitia atau pantau terus website kami untuk informasi jadwal pendaftaran selanjutnya.
            </p>

            <div class="space-y-3">
                <a href="<?= base_url('/') ?>" class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>

                <a href="<?= base_url('login') ?>" class="block w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login Siswa
                </a>
            </div>
        </div>
    </div>

</body>

</html>