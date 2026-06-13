<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - PPDB</title>

    <?php
    $page_title = 'Registrasi - PPDB';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="bg-green-600 text-white p-6 rounded-t-lg">
            <h2 class="text-2xl font-bold text-center">Registrasi PPDB</h2>
            <p class="text-center text-green-100 mt-1">Daftar sebagai calon siswa baru</p>
        </div>

        <div class="p-6">
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/doRegister') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-id-card text-green-600 mr-2"></i>NISN <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="nisn"
                        value="<?= old('nisn') ?>"
                        required
                        maxlength="10"
                        placeholder="Masukkan NISN 10 digit"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-gray-500">NISN terdiri dari 10 digit angka. <br class="sm:hidden"> Jika tidak tahu, silakan klik tombol Cari NISN di samping.</p>
                        <a href="https://nisn.data.kemdikbud.go.id/index.php/Cindex/formcaribynama" target="_blank" rel="noopener noreferrer" class="text-xs bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100 hover:text-blue-700 py-1.5 px-3 rounded-md transition-colors flex items-center shadow-sm whitespace-nowrap ml-2">
                            <i class="fas fa-search mr-1.5"></i> Cari NISN
                        </a>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-user text-green-600 mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="nama_lengkap"
                        value="<?= old('nama_lengkap') ?>"
                        required
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-envelope text-green-600 mr-2"></i>Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                        name="email"
                        value="<?= old('email') ?>"
                        required
                        placeholder="contoh@email.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-phone text-green-600 mr-2"></i>No. HP <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        name="no_hp"
                        value="<?= old('no_hp') ?>"
                        required
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-lock text-green-600 mr-2"></i>Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                        name="password"
                        required
                        minlength="6"
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-lock text-green-600 mr-2"></i>Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                        name="confirm_password"
                        required
                        minlength="6"
                        placeholder="Ulangi password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-user-plus mr-2"></i> Daftar
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="<?= base_url('login') ?>" class="text-green-600 hover:text-green-700 font-semibold">
                        Login di sini
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="<?= base_url('/') ?>" class="text-gray-500 hover:text-gray-700 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('errors')): ?>
                let errorList = <?= json_encode(session()->getFlashdata('errors')) ?>;
                Swal.fire({
                    icon: 'error',
                    title: 'Terdapat Kesalahan',
                    html: '<ul style="text-align:left;list-style:disc;padding-left:1.5rem;">' + errorList.map(e => '<li>' + e + '</li>').join('') + '</ul>',
                    confirmButtonColor: '#ef4444'
                });
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: <?= json_encode(session()->getFlashdata('error')) ?>,
                    confirmButtonColor: '#ef4444'
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>