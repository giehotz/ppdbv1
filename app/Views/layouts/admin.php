<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Admin <?= $app_alias ?? 'PPDB' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }
        #desktop-sidebar { transition: width 0.3s ease; }
        .sidebar-text { transition: opacity 0.2s ease; overflow: hidden; white-space: nowrap; }
        #desktop-sidebar.minimized { width: 5rem; }
        #desktop-sidebar.minimized .sidebar-text { opacity: 0; width: 0; display: none; }
        #desktop-sidebar.minimized .sidebar-header { display: none; }
        #desktop-sidebar.minimized #sidebar-brand { display: none; }
        #desktop-sidebar:not(.minimized) #sidebar-brand-mini { display: none; }
        #desktop-sidebar.minimized .link-item { justify-content: center; padding-left: 0; padding-right: 0; }
        #desktop-sidebar.minimized .link-item i { margin: 0 auto; font-size: 1.25rem; }
        #desktop-sidebar.minimized .badge-count { display: none; }
        #desktop-sidebar.minimized .menu-group-list { display: block !important; }
    </style>
    <?= $this->renderSection('head') ?>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex h-screen overflow-hidden">

    <?php
    // Preferred classes
    $linkClass   = "link-item flex items-center px-6 py-3 text-gray-300 hover:bg-green-700 hover:text-white transition-colors duration-200";
    $activeClass = "bg-green-700 text-white";

    $unlockModel = new \App\Models\UnlockRequestModel();
    $pendingUnlockCount = $unlockModel->getPendingCount();

    $webData = $web ?? \Config\Services::renderer()->getData()['web'] ?? [];
    $sekolahName = $webData['nama_sekolah'] ?? 'Sekolah';

    // Sidebar menu definition — single source of truth
    $sidebarMenus = [
        'Dashboard' => [
            ['label' => 'Dashboard',       'icon' => 'tachometer-alt', 'url' => 'admin/dashboard'],
        ],
        'Manajemen' => [
            ['label' => 'Pengguna',        'icon' => 'users-cog',      'url' => 'admin/users'],
            ['label' => 'Calon Siswa',     'icon' => 'user-graduate',  'url' => 'admin/siswa'],
            ['label' => 'Buka Kunci',      'icon' => 'unlock-alt',     'url' => 'admin/unlockrequest', 'badge' => $pendingUnlockCount],
            ['label' => 'Reset Password',  'icon' => 'key',            'url' => 'admin/reset-password'],
            ['label' => 'Berkas',          'icon' => 'file-alt',       'url' => 'admin/berkas'],
            ['label' => 'Kelulusan',       'icon' => 'graduation-cap', 'url' => 'admin/kelulusan'],
            ['label' => 'Laporan & Analisis', 'icon' => 'chart-pie',   'url' => 'admin/laporan'],
            ['label' => 'Pembiayaan',      'icon' => 'money-bill-wave', 'url' => 'admin/pembiayaan'],
            ['label' => 'Log Aktivitas',   'icon' => 'history',        'url' => 'admin/log_aktivitas'],
        ],
        'Pengaturan Kartu' => [
            ['label' => 'Desain Cetak Kartu', 'icon' => 'print',       'url' => 'admin/setting-kartu'],
        ],
        'Konten & Pengaturan' => [
            ['label' => 'Pesan Pribadi',   'icon' => 'envelope',       'url' => 'admin/pesan'],
            ['label' => 'Pengumuman',      'icon' => 'bullhorn',       'url' => 'admin/pengumuman'],
            ['label' => 'Landing Content', 'icon' => 'laptop-code',    'url' => 'admin/landing-content'],
            ['label' => 'Kampanye Twibbon', 'icon' => 'image',         'url' => 'admin/twibbon'],
            ['label' => 'Pengaturan Sistem','icon' => 'cogs',          'url' => 'admin/settings'],
            ['label' => 'Pengaturan SEO',  'icon' => 'search',         'url' => 'admin/seo'],
        ],
    ];

    $currentUri = uri_string();

    function isActive($url, $currentUri) {
        return strpos($currentUri, $url) === 0 ? true : false;
    }

    function renderMenu($menus, $linkClass, $activeClass, $currentUri, $prefix = 'menu') {
        $output = '';
        $groupId = 0;
        foreach ($menus as $groupLabel => $items) {
            $groupId++;
            
            $isGroupActive = false;
            foreach ($items as $item) {
                if (isActive($item['url'], $currentUri)) {
                    $isGroupActive = true;
                    break;
                }
            }

            if ($groupLabel !== 'Dashboard') {
                $output .= '<li class="sidebar-group">';
                $output .= '<button type="button" class="sidebar-header w-full flex justify-between items-center px-6 py-2 text-xs font-semibold text-green-300 uppercase tracking-wider mt-4 focus:outline-none hover:text-white transition-colors" onclick="toggleMenu(\'' . $prefix . '-' . $groupId . '\', this)">';
                $output .= '<span class="sidebar-text">' . esc($groupLabel) . '</span>';
                $output .= '<i class="fas fa-chevron-' . ($isGroupActive ? 'down' : 'right') . ' sidebar-text transition-transform duration-200"></i>';
                $output .= '</button>';
                $output .= '<ul id="' . $prefix . '-' . $groupId . '" class="menu-group-list ' . ($isGroupActive ? 'block' : 'hidden') . '">';
            }
            
            foreach ($items as $item) {
                $active = isActive($item['url'], $currentUri);
                $cls = $linkClass . ($active ? ' ' . $activeClass : '');
                $output .= '<li><a href="' . base_url($item['url']) . '" class="' . $cls . '">';
                $output .= '<i class="fas fa-' . $item['icon'] . ' w-6 flex-shrink-0 text-center"></i>';
                $output .= '<span class="sidebar-text ml-2">' . esc($item['label']) . '</span>';
                if (!empty($item['badge']) && $item['badge'] > 0) {
                    $output .= '<span class="badge-count ml-auto bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">' . $item['badge'] . '</span>';
                }
                $output .= '</a></li>';
            }

            if ($groupLabel !== 'Dashboard') {
                $output .= '</ul></li>';
            }
        }
        return $output;
    }
    ?>

    <!-- Desktop Sidebar -->
    <aside id="desktop-sidebar" class="w-64 bg-gray-800 text-white flex-shrink-0 hidden md:flex flex-col shadow-xl z-20">
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
                <?= renderMenu($sidebarMenus, $linkClass, $activeClass, $currentUri, 'desktop') ?>
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
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 md:px-6 z-10 shrink-0">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-600 focus:outline-none hover:text-gray-800" id="mobile-menu-btn">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <button class="hidden md:block text-gray-500 hover:text-gray-700 focus:outline-none transition-transform duration-300" id="desktop-toggle-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="font-semibold text-lg text-gray-700 truncate max-w-[200px] md:max-w-none">
                    <?= $this->renderSection('page_title') ?>
                </div>
            </div>

            <div class="flex items-center space-x-3 md:space-x-4">
                <span class="text-sm text-gray-600 hidden md:inline-block">Halo, <strong><?= session()->get('nama_lengkap') ?></strong></span>
                <div class="relative shrink-0">
                    <img class="h-8 w-8 rounded-full object-cover border border-gray-300"
                        src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama_lengkap')) ?>&background=random"
                        alt="Avatar">
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <?= $this->include('layouts/components/footer') ?>
    </div>

    <!-- Mobile Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden" id="mobile-backdrop"></div>

    <!-- Mobile Sidebar -->
    <nav class="fixed inset-y-0 left-0 w-64 bg-green-800 text-white z-30 transform -translate-x-full transition-transform duration-300 md:hidden flex flex-col" id="mobile-sidebar">
        <div class="p-4 flex justify-between items-center border-b border-green-700">
            <span class="font-bold text-xl">MENU</span>
            <button class="text-white focus:outline-none hover:text-green-200" id="close-sidebar-btn">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4">
            <ul>
                <?= renderMenu($sidebarMenus, $linkClass, $activeClass, $currentUri, 'mobile') ?>
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

        function toggleMenu(id, btn) {
            const el = document.getElementById(id);
            const icon = btn.querySelector('i.fa-chevron-down, i.fa-chevron-right');
            
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                el.classList.add('block');
                if (icon) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                }
            } else {
                el.classList.remove('block');
                el.classList.add('hidden');
                if (icon) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            }
        }

        mobileBtn.addEventListener('click', toggleSidebar);
        closeSidebarBtn.addEventListener('click', toggleSidebar);
        mobileBackdrop.addEventListener('click', toggleSidebar);

        const desktopToggleBtn = document.getElementById('desktop-toggle-btn');
        const desktopSidebar = document.getElementById('desktop-sidebar');

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
