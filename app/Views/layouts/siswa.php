<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - <?= $app_alias ?? 'PPDB' ?> Siswa</title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Sidebar layout transitions */
        #sidebar {
            transition: width 0.3s ease, transform 0.3s ease;
        }

        .sidebar-text {
            transition: opacity 0.2s ease;
            overflow: hidden;
            white-space: nowrap;
        }

        @media (min-width: 1024px) {
            #sidebar.minimized {
                width: 5rem;
                /* w-20 */
            }

            #sidebar.minimized .sidebar-text {
                opacity: 0;
                width: 0;
                display: none;
            }

            #sidebar.minimized #sidebar-brand {
                display: none;
            }

            #sidebar:not(.minimized) #sidebar-brand-mini {
                display: none;
            }

            #sidebar.minimized .link-item {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            #sidebar.minimized .link-item i {
                margin: 0 auto;
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden" onclick="toggleMobileMenu()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 w-64 bg-gradient-to-b from-emerald-600 to-emerald-800 text-white flex-shrink-0 transition-all duration-300 ease-in-out z-40">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div id="sidebar-brand">
                        <h1 class="text-2xl font-bold flex items-center">
                            <?php if (!empty($web_logo) && file_exists(FCPATH . 'uploads/logo/' . $web_logo)): ?>
                                <img src="<?= base_url('uploads/logo/' . $web_logo) ?>" alt="Logo" class="h-8 w-auto mr-2">
                            <?php endif; ?>
                            <?= $app_alias ?? 'PPDB' ?> Siswa
                        </h1>
                        <p class="text-blue-200 text-sm mt-1 sidebar-text">Dashboard Pendaftar</p>
                    </div>
                    <span id="sidebar-brand-mini" class="text-2xl font-bold tracking-wider flex items-center justify-center w-full" title="<?= strtoupper($app_alias ?? 'PPDB') ?> SISWA">
                        <?php if (!empty($web_logo) && file_exists(FCPATH . 'uploads/logo/' . $web_logo)): ?>
                            <img src="<?= base_url('uploads/logo/' . $web_logo) ?>" alt="Logo" class="h-8 w-auto">
                        <?php else: ?>
                            <?= substr(strtoupper($app_alias ?? 'PPDB'), 0, 1) ?>S
                        <?php endif; ?>
                    </span>
                    <button onclick="toggleMobileMenu()" class="lg:hidden text-white ml-auto">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <nav class="mt-6">
                <a href="<?= base_url('siswa/dashboard') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= uri_string() == 'siswa/dashboard' ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-home w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Dashboard</span>
                </a>

                <a href="<?= base_url('siswa/biodata') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/biodata') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-user-edit w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Biodata</span>
                </a>

                <a href="<?= base_url('siswa/berkas') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/berkas') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-file-upload w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Upload Berkas</span>
                </a>

                <a href="<?= base_url('siswa/pembiayaan') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/pembiayaan') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-money-bill-wave w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Pembiayaan</span>
                </a>

                <a href="<?= base_url('siswa/status') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/status') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-clipboard-check w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Status Pendaftaran</span>
                </a>

                <a href="<?= base_url('siswa/kelulusan') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/kelulusan') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-graduation-cap w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Kelulusan</span>
                </a>

                <a href="<?= base_url('siswa/pengumuman') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/pengumuman') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-bullhorn w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Pengumuman</span>
                </a>

                <a href="<?= base_url('siswa/twibbon') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/twibbon') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-image w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Twibbon</span>
                </a>

                <?php 
                $pesanModel = new \App\Models\PesanModel();
                $unreadPesan = $pesanModel->countUnreadSiswa(session()->get('id_siswa'));
                ?>
                <a href="<?= base_url('siswa/pesan') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-blue-700 transition duration-200 <?= strpos(uri_string(), 'siswa/pesan') !== false ? 'bg-blue-700 border-l-4 border-white' : '' ?>">
                    <i class="fas fa-inbox w-6 text-center"></i>
                    <span class="sidebar-text ml-3 flex-1 flex items-center justify-between pointer-events-none pr-4">
                        Kotak Masuk
                        <?php if ($unreadPesan > 0): ?>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-2"><?= $unreadPesan ?></span>
                        <?php endif; ?>
                    </span>
                </a>

                <a href="<?= base_url('logout') ?>" class="link-item flex items-center px-6 py-3 text-white hover:bg-red-600 transition duration-200 mt-4">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white shadow-sm relative z-20">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <div class="flex items-center">
                        <button onclick="toggleMobileMenu()" class="lg:hidden text-gray-800 mr-4">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>

                        <!-- Desktop Sidebar Toggle -->
                        <button class="hidden lg:block text-gray-500 hover:text-gray-700 focus:outline-none transition-transform duration-300 mr-4" id="desktop-toggle-btn">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <h2 class="text-xl lg:text-2xl font-semibold text-gray-800">
                            <?= $this->renderSection('page_title') ?>
                        </h2>
                    </div>

                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button id="notification-button"
                                onclick="toggleNotificationDropdown()"
                                class="relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-full transition duration-200">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notification-badge"
                                    class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full hidden">
                                    0
                                </span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown"
                                class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                <!-- Dropdown Header -->
                                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-800">
                                            <i class="fas fa-bell mr-2"></i>Pengumuman Terbaru
                                        </h3>
                                    </div>
                                </div>

                                <!-- Dropdown Content -->
                                <div id="notification-dropdown-content" class="max-h-96 overflow-y-auto">
                                    <!-- Will be populated by JavaScript -->
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                        <p>Memuat...</p>
                                    </div>
                                </div>

                                <!-- Dropdown Footer -->
                                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                                    <a href="<?= base_url('siswa/pengumuman') ?>"
                                        class="block text-center text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                                        Lihat Semua Pengumuman →
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <button id="profile-button"
                                onclick="toggleProfileDropdown()"
                                class="flex items-center space-x-2 lg:space-x-3 hover:bg-gray-100 rounded-lg p-2 transition duration-200">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-medium text-gray-800"><?= session()->get('nama_lengkap') ?? 'Siswa' ?></p>
                                    <p class="text-xs text-gray-500"><?= session()->get('no_pendaftaran') ?? '' ?></p>
                                </div>
                                <?php
                                // Get user photo or show initials
                                $nisn = session()->get('nisn');
                                $foto = session()->get('foto');
                                $fotoPath = 'uploads/berkas/' . $nisn . '/' . $foto;
                                $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);
                                ?>

                                <?php if ($hasFoto): ?>
                                    <img src="<?= base_url($fotoPath) ?>"
                                        alt="Avatar"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-blue-600">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                        <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'S', 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <i class="fas fa-chevron-down text-gray-600 text-xs hidden sm:block"></i>
                            </button>

                            <!-- Profile Dropdown Menu -->
                            <div id="profile-dropdown"
                                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                <div class="py-2">
                                    <a href="<?= base_url('siswa/profile') ?>"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                        <i class="fas fa-user-circle mr-3 text-blue-600"></i>
                                        <span>Profil Saya</span>
                                    </a>
                                    <a href="<?= base_url('siswa/ubah-password') ?>"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                        <i class="fas fa-key mr-3 text-blue-600"></i>
                                        <span>Ubah Password</span>
                                    </a>
                                    <hr class="my-2 border-gray-200">
                                    <a href="<?= base_url('logout') ?>"
                                        class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-6 flex flex-col relative z-10">
                <?= $this->renderSection('content') ?>
            </main>

            <?= $this->include('layouts/components/footer') ?>
        </div>
    </div>

    <!-- Notification System JavaScript -->
    <script src="<?= base_url('js/notifications.js') ?>"></script>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Profile Dropdown
        let isProfileDropdownOpen = false;

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            isProfileDropdownOpen = !isProfileDropdownOpen;

            if (isProfileDropdownOpen) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileButton = document.getElementById('profile-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (!profileButton?.contains(event.target) && !profileDropdown?.contains(event.target)) {
                if (isProfileDropdownOpen) {
                    profileDropdown?.classList.add('hidden');
                    isProfileDropdownOpen = false;
                }
            }
        });

        const desktopToggleBtn = document.getElementById('desktop-toggle-btn');
        const sidebarMain = document.getElementById('sidebar');

        // Check LocalStorage for sidebar preference
        if (localStorage.getItem('siswa_sidebar_minimized') === 'true') {
            if (window.innerWidth >= 1024) { // only apply if desktop
                sidebarMain.classList.add('minimized');
            }
        }

        if (desktopToggleBtn) {
            desktopToggleBtn.addEventListener('click', () => {
                sidebarMain.classList.toggle('minimized');
                localStorage.setItem('siswa_sidebar_minimized', sidebarMain.classList.contains('minimized'));
            });
        }
    </script>

    <?= $this->renderSection('scripts') ?>

    <?= view('partials/sweetalert') ?>
</body>

</html>