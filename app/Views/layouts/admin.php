<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Admin <?= $app_alias ?? 'PPDB' ?></title>

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

        /* Sidebar layout transitions */
        #desktop-sidebar {
            transition: width 0.3s ease;
        }

        .sidebar-text {
            transition: opacity 0.2s ease;
            overflow: hidden;
            white-space: nowrap;
        }

        #desktop-sidebar.minimized {
            width: 5rem;
            /* w-20 */
        }

        #desktop-sidebar.minimized .sidebar-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        #desktop-sidebar.minimized .sidebar-header {
            display: none;
        }

        #desktop-sidebar.minimized #sidebar-brand {
            display: none;
        }

        #desktop-sidebar:not(.minimized) #sidebar-brand-mini {
            display: none;
        }

        #desktop-sidebar.minimized .link-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        #desktop-sidebar.minimized .link-item i {
            margin: 0 auto;
            font-size: 1.25rem;
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex h-screen overflow-hidden">

    <?php
    // Define common classes for sidebar links to keep HTML clean
    $linkClass = "link-item flex items-center px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white transition-colors duration-200";
    $activeClass = "bg-green-700 text-white";

    // Get pending unlock request count
    $unlockModel = new \App\Models\UnlockRequestModel();
    $pendingUnlockCount = $unlockModel->getPendingCount();
    ?>

    <!-- Sidebar -->
    <aside id="desktop-sidebar" class="w-64 bg-green-800 text-white flex-shrink-0 hidden md:flex flex-col shadow-xl z-20">
        <div class="h-16 flex items-center justify-center border-b border-green-700 overflow-hidden shrink-0">
            <span id="sidebar-brand" class="text-2xl font-bold tracking-wider flex items-center">
                <?php if (!empty($web_logo) && file_exists(FCPATH . 'uploads/logo/' . $web_logo)): ?>
                    <img src="<?= base_url('uploads/logo/' . $web_logo) ?>" alt="Logo" class="h-8 w-auto mr-2">
                <?php endif; ?>
                <?= strtoupper($app_alias ?? 'PPDB') ?> ADMIN
            </span>
            <span id="sidebar-brand-mini" class="text-2xl font-bold tracking-wider flex items-center justify-center" title="<?= strtoupper($app_alias ?? 'PPDB') ?> ADMIN">
                <?php if (!empty($web_logo) && file_exists(FCPATH . 'uploads/logo/' . $web_logo)): ?>
                    <img src="<?= base_url('uploads/logo/' . $web_logo) ?>" alt="Logo" class="h-8 w-auto">
                <?php else: ?>
                    <?= substr(strtoupper($app_alias ?? 'PPDB'), 0, 1) ?>A
                <?php endif; ?>
            </span>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul>
                <li>
                    <a href="<?= base_url('admin/dashboard') ?>" class="<?= $linkClass ?> <?= uri_string() == 'admin/dashboard' ? $activeClass : '' ?>">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="sidebar-text ml-2">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-header px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4">
                    Manajemen
                </li>

                <li>
                    <a href="<?= base_url('admin/users') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/users') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-users-cog w-6"></i>
                        <span class="sidebar-text ml-2">Pengguna</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/siswa') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/siswa') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-user-graduate w-6"></i>
                        <span class="sidebar-text ml-2">Calon Siswa</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/unlockrequest') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/unlockrequest') === 0 ? $activeClass : '' ?> relative">
                        <i class="fas fa-unlock-alt w-6"></i>
                        <span class="sidebar-text ml-2 flex-1 flex items-center justify-between">
                            Buka Kunci
                            <?php if ($pendingUnlockCount > 0): ?>
                                <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $pendingUnlockCount ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/reset-password') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/reset-password') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-key w-6"></i>
                        <span class="sidebar-text ml-2">Reset Password</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/berkas') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/berkas') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="sidebar-text ml-2">Berkas</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/kelulusan') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/kelulusan') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-graduation-cap w-6"></i>
                        <span class="sidebar-text ml-2">Kelulusan</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/log_aktivitas') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/log_aktivitas') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-history w-6"></i>
                        <span class="sidebar-text ml-2">Log Aktivitas</span>
                    </a>
                </li>

                <li class="sidebar-header px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4">
                    Pengaturan Kartu
                </li>

                <li>
                    <a href="<?= base_url('admin/setting-kartu') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/setting-kartu') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-print w-6"></i>
                        <span class="sidebar-text ml-2">Desain Cetak Kartu</span>
                    </a>
                </li>

                <li class="sidebar-header px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4">
                    Konten & Pengaturan
                </li>

                <li>
                    <a href="<?= base_url('admin/pesan') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/pesan') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-envelope w-6"></i>
                        <span class="sidebar-text ml-2">Pesan Pribadi</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/pengumuman') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/pengumuman') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-bullhorn w-6"></i>
                        <span class="sidebar-text ml-2">Pengumuman</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/landing-content') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/landing-content') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-laptop-code w-6"></i>
                        <span class="sidebar-text ml-2">Landing Content</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/settings') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/settings') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-cogs w-6"></i>
                        <span class="sidebar-text ml-2">Pengaturan Sistem</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('admin/seo') ?>" class="<?= $linkClass ?> <?= strpos(uri_string(), 'admin/seo') === 0 ? $activeClass : '' ?>">
                        <i class="fas fa-search w-6"></i>
                        <span class="sidebar-text ml-2">Pengaturan SEO</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-green-700">
            <a href="<?= base_url('logout') ?>" class="link-item flex items-center text-green-300 hover:text-white transition duration-200">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span class="sidebar-text ml-2">Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Top Navbar -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10 shrink-0">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 focus:outline-none" id="mobile-menu-btn">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <!-- Desktop Sidebar Toggle -->
                <button class="hidden md:block text-gray-500 hover:text-gray-700 focus:outline-none transition-transform duration-300" id="desktop-toggle-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="font-semibold text-lg text-gray-700">
                    <?= $this->renderSection('page_title') ?>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600 hidden md:inline-block">Halo, <strong><?= session()->get('nama_lengkap') ?></strong></span>
                <div class="relative">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-300"
                        src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama_lengkap')) ?>&background=random"
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
    <nav class="fixed inset-y-0 left-0 w-64 bg-green-800 text-white z-30 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col" id="mobile-sidebar">
        <!-- Close Button -->
        <div class="p-4 flex justify-between items-center border-b border-green-700">
            <span class="font-bold text-xl">MENU</span>
            <button class="text-white focus:outline-none" id="close-sidebar-btn">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <!-- Same links as desktop sidebar -->
        <div class="flex-1 overflow-y-auto py-4">
            <ul>
                <li>
                    <a href="<?= base_url('admin/dashboard') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="sidebar-text ml-2">Dashboard</span>
                    </a>
                </li>
                <!-- ... copy of links ... -->
                <li>
                    <a href="<?= base_url('admin/users') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-users-cog w-6"></i>
                        <span class="sidebar-text ml-2">Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/siswa') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-user-graduate w-6"></i>
                        <span class="sidebar-text ml-2">Calon Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/unlockrequest') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-unlock-alt w-6"></i>
                        <span class="sidebar-text ml-2 flex-1 flex items-center justify-between pointer-events-none pr-4">
                            Buka Kunci
                            <?php if ($pendingUnlockCount > 0): ?>
                                <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-2"><?= $pendingUnlockCount ?></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/berkas') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-file-alt w-6"></i>
                        <span class="sidebar-text ml-2">Berkas</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/kelulusan') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-graduation-cap w-6"></i>
                        <span class="sidebar-text ml-2">Kelulusan</span>
                    </a>
                </li>
                <li class="sidebar-header px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4">
                    Pengaturan Kartu
                </li>
                <li>
                    <a href="<?= base_url('admin/setting-kartu') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-print w-6"></i>
                        <span class="sidebar-text ml-2">Desain Cetak Kartu</span>
                    </a>
                </li>
                <li class="sidebar-header px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4">
                    Konten & Pengaturan
                </li>
                <li>
                    <a href="<?= base_url('admin/pengumuman') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-bullhorn w-6"></i>
                        <span class="sidebar-text ml-2">Pengumuman</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/landing-content') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-laptop-code w-6"></i>
                        <span class="sidebar-text ml-2">Landing Content</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/settings') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-cogs w-6"></i>
                        <span class="sidebar-text ml-2">Pengaturan Sistem</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/seo') ?>" class="<?= $linkClass ?>">
                        <i class="fas fa-search w-6"></i>
                        <span class="sidebar-text ml-2">Pengaturan SEO</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="p-4 border-t border-green-700">
            <a href="<?= base_url('logout') ?>" class="flex items-center text-green-300 hover:text-white transition duration-200">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="sidebar-text ml-2">Logout</span>
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

        const desktopToggleBtn = document.getElementById('desktop-toggle-btn');
        const desktopSidebar = document.getElementById('desktop-sidebar');

        // Check LocalStorage for sidebar preference
        if (localStorage.getItem('admin_sidebar_minimized') === 'true') {
            desktopSidebar.classList.add('minimized');
        }

        if (desktopToggleBtn) {
            desktopToggleBtn.addEventListener('click', () => {
                desktopSidebar.classList.toggle('minimized');
                localStorage.setItem('admin_sidebar_minimized', desktopSidebar.classList.contains('minimized'));
            });
        }
    </script>
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>

</html>