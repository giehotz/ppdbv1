<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Verifikator <?= $app_alias ?? 'PPDB' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex h-screen overflow-hidden">

    <?php
    // Define common classes for sidebar links to keep HTML clean
    $linkClass = "flex items-center px-6 py-3 text-gray-300 hover:bg-blue-700 hover:text-white transition-colors duration-200";
    $activeClass = "bg-blue-700 text-white";
    ?>

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 text-white flex-shrink-0 hidden md:flex flex-col shadow-xl">
        <div class="p-6 flex items-center justify-center border-b border-blue-700">
            <span class="text-2xl font-bold tracking-wider flex items-center">
                <?php if (!empty($web_logo) && file_exists(FCPATH . 'uploads/logo/' . $web_logo)): ?>
                    <img src="<?= base_url('uploads/logo/' . $web_logo) ?>" alt="Logo" class="h-8 w-auto mr-2">
                <?php endif; ?>
                VERIFIKATOR
            </span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul>
                <li>
                    <a href="<?= base_url('verifikator/dashboard') ?>" class="<?= $linkClass ?> <?= uri_string() == 'verifikator/dashboard' ? $activeClass : '' ?>">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider mt-4">
                    Verifikasi Data
                </li>

                <li>
                    <a href="<?= base_url('verifikator/siswa') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'verifikator/siswa') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-user-check w-6"></i>
                        <span class="ml-2">Data Siswa</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('verifikator/berkas') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'verifikator/berkas') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-file-signature w-6"></i>
                        <span class="ml-2">Verifikasi Berkas</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('verifikator/unlockrequest') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'verifikator/unlockrequest') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-unlock-alt w-6"></i>
                        <span class="ml-2">Antrean Buka Kunci</span>
                    </a>
                </li>
                
                <li class="px-6 py-2 text-xs font-semibold text-blue-300 uppercase tracking-wider mt-4">
                    Komunikasi
                </li>

                <li>
                    <a href="<?= base_url('verifikator/pesan') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'verifikator/pesan') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-envelope w-6"></i>
                        <span class="ml-2">Pesan Pribadi</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-blue-700">
            <a href="<?= base_url('logout') ?>" class="flex items-center text-blue-300 hover:text-white transition duration-200">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="ml-2">Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Top Navbar -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-gray-600 focus:outline-none" id="mobile-menu-btn">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="font-semibold text-lg text-gray-700">
                <?= $this->renderSection('page_title') ?>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600 hidden md:inline-block">Halo, <strong><?= session()->get('nama_lengkap') ?></strong></span>
                <div class="relative">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-300"
                        src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama_lengkap')) ?>&background=random&color=fff&background=1d4ed8"
                        alt="Avatar">
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 p-4 text-center text-sm text-gray-500">
            &copy; <?= date('Y') ?> <?= $app_alias ?? 'PPDB' ?> Online - <?= \Config\Services::renderer()->getData()['web']['nama_sekolah'] ?? 'Sekolah' ?>. All rights reserved.
        </footer>
    </div>

    <!-- Mobile Sidebar Backdrop (Hidden by default) -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden" id="mobile-backdrop"></div>

    <!-- Mobile Sidebar (Hidden by default) -->
    <nav class="fixed inset-y-0 left-0 w-64 bg-blue-800 text-white z-30 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col" id="mobile-sidebar">
        <!-- Close Button -->
        <div class="p-4 flex justify-between items-center border-b border-blue-700">
            <span class="font-bold text-xl">MENU</span>
            <button class="text-white focus:outline-none" id="close-sidebar-btn">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Same links as desktop sidebar -->
        <div class="flex-1 overflow-y-auto py-4">
            <ul>
                <li>
                    <a href="<?= base_url('verifikator/dashboard') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="ml-2">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('verifikator/siswa') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-user-check w-6"></i>
                        <span class="ml-2">Data Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('verifikator/berkas') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-file-signature w-6"></i>
                        <span class="ml-2">Verifikasi Berkas</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('verifikator/unlockrequest') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-unlock-alt w-6"></i>
                        <span class="ml-2">Antrean Buka Kunci</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="p-4 border-t border-blue-700">
            <a href="<?= base_url('logout') ?>" class="flex items-center text-blue-300 hover:text-white transition duration-200">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="ml-2">Logout</span>
            </a>
        </div>
    </nav>

    <script>
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileBackdrop = document.getElementById('mobile-backdrop');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');

        function toggleSidebar() {
            mobileSidebar.classList.toggle('-translate-x-full');
            mobileBackdrop.classList.toggle('hidden');
        }

        mobileBtn.addEventListener('click', toggleSidebar);
        closeSidebarBtn.addEventListener('click', toggleSidebar);
        mobileBackdrop.addEventListener('click', toggleSidebar);
    </script>
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>

</html>