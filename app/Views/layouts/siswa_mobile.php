<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $this->renderSection('title') ?> - <?= $app_alias ?? 'PPDB' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Mobile App Styles */
        body {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }

        /* Safe area for notch phones */
        .safe-area-top {
            padding-top: env(safe-area-inset-top);
        }

        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* Hide scrollbar but keep functionality */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 overflow-hidden">

    <!-- Main Container -->
    <div class="flex flex-col h-screen">

        <!-- Top Header -->
        <header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white safe-area-top sticky top-0 z-10 shadow-lg">
            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleMobileMenu()" class="p-2 -ml-2 hover:bg-white/10 rounded-lg transition">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center overflow-hidden border border-white/30 truncate">
                            <?php if (isset($siswa['foto']) && !empty($siswa['foto']) && isset($siswa['nisn']) && file_exists(FCPATH . 'uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto'])): ?>
                                <img src="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto']) ?>" alt="Ava" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-lg font-bold"><?= strtoupper(substr(session()->get('nama_lengkap') ?? 'S', 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold"><?= session()->get('nama_lengkap') ?? 'Siswa' ?></h2>
                            <p class="text-xs text-blue-100"><?= session()->get('no_pendaftaran') ?? '' ?></p>
                        </div>
                    </div>
                    <button onclick="window.location.href='<?= base_url('logout') ?>'" class="p-2 hover:bg-white/10 rounded-lg transition">
                        <i class="fas fa-sign-out-alt text-xl"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Page Title -->
        <div class="bg-white border-b px-4 py-3">
            <h1 class="text-lg font-bold text-gray-800"><?= $this->renderSection('page_title') ?></h1>
        </div>

        <!-- Content Area with Scroll -->
        <main class="flex-1 overflow-y-auto hide-scrollbar px-4 pb-20">
            <div class="py-4">
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 safe-area-bottom shadow-lg z-20">
            <div class="grid grid-cols-5 h-16">
                <a href="<?= base_url('siswa/dashboard') ?>" class="flex flex-col items-center justify-center <?= uri_string() == 'siswa/dashboard' ? 'text-blue-600' : 'text-gray-400' ?> hover:text-blue-600 transition">
                    <i class="fas fa-home text-xl mb-1"></i>
                    <span class="text-xs">Home</span>
                </a>

                <a href="<?= base_url('siswa/biodata') ?>" class="flex flex-col items-center justify-center <?= strpos(uri_string(), 'siswa/biodata') !== false ? 'text-blue-600' : 'text-gray-400' ?> hover:text-blue-600 transition">
                    <i class="fas fa-user-edit text-xl mb-1"></i>
                    <span class="text-xs">Biodata</span>
                </a>

                <a href="<?= base_url('siswa/pesan') ?>" class="flex flex-col items-center justify-center <?= strpos(uri_string(), 'siswa/pesan') !== false ? 'text-blue-600' : 'text-gray-400' ?> hover:text-blue-600 transition relative">
                    <i class="fas fa-envelope text-xl mb-1"></i>
                    <span class="text-xs">Pesan</span>
                </a>

                <a href="<?= base_url('siswa/status') ?>" class="flex flex-col items-center justify-center <?= strpos(uri_string(), 'siswa/status') !== false ? 'text-blue-600' : 'text-gray-400' ?> hover:text-blue-600 transition">
                    <i class="fas fa-clipboard-check text-xl mb-1"></i>
                    <span class="text-xs">Status</span>
                </a>

                <a href="<?= base_url('siswa/pengumuman') ?>" class="flex flex-col items-center justify-center <?= strpos(uri_string(), 'siswa/pengumuman') !== false ? 'text-blue-600' : 'text-gray-400' ?> hover:text-blue-600 transition">
                    <i class="fas fa-bullhorn text-xl mb-1"></i>
                    <span class="text-xs">Info</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Mobile Offcanvas Menu -->
    <div id="mobileMenu" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50 transition-opacity opacity-0" id="mobileMenuBackdrop" onclick="toggleMobileMenu()"></div>
        
        <!-- Sidebar -->
        <div class="absolute inset-y-0 left-0 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 flex flex-col" id="mobileMenuSidebar">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-4 safe-area-top">
                <div class="flex items-center justify-between text-white pb-2">
                    <h2 class="text-lg font-bold">Menu Siswa</h2>
                    <button onclick="toggleMobileMenu()" class="p-2 hover:bg-white/20 rounded-lg">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto py-2">
                <a href="<?= base_url('siswa/dashboard') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-home w-6 text-center text-gray-400 mr-2"></i> Dashboard
                </a>
                <a href="<?= base_url('siswa/biodata') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-user-edit w-6 text-center text-gray-400 mr-2"></i> Biodata
                </a>
                <a href="<?= base_url('siswa/berkas') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-file-upload w-6 text-center text-gray-400 mr-2"></i> Berkas
                </a>
                <a href="<?= base_url('siswa/status') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-clipboard-check w-6 text-center text-gray-400 mr-2"></i> Status Pendaftaran
                </a>
                <a href="<?= base_url('siswa/pengumuman') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-bullhorn w-6 text-center text-gray-400 mr-2"></i> Pengumuman
                </a>
                <a href="<?= base_url('siswa/pesan') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-envelope w-6 text-center text-gray-400 mr-2"></i> Pesan
                </a>
                <a href="<?= base_url('siswa/kelulusan') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-graduation-cap w-6 text-center text-gray-400 mr-2"></i> Kelulusan
                </a>
                <div class="border-t my-2"></div>
                <a href="<?= base_url('siswa/profile') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-user-circle w-6 text-center text-gray-400 mr-2"></i> Profil Saya
                </a>
                <a href="<?= base_url('siswa/ubah-password') ?>" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fas fa-key w-6 text-center text-gray-400 mr-2"></i> Ubah Password
                </a>
            </div>
            
            <div class="p-4 border-t pb-16">
                <a href="<?= base_url('logout') ?>" class="flex items-center justify-center w-full py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition font-bold">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </div>
    </div>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const backdrop = document.getElementById('mobileMenuBackdrop');
            const sidebar = document.getElementById('mobileMenuSidebar');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    sidebar.classList.remove('-translate-x-full');
                }, 10);
            } else {
                backdrop.classList.add('opacity-0');
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        }
    </script>
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>

</html>