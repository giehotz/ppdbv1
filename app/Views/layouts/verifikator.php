<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function() {
            try {
                if (localStorage.getItem('darkMode') === 'true') {
                    document.documentElement.classList.add('dark');
                    document.documentElement.style.colorScheme = 'dark';
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.style.colorScheme = 'light';
                }
            } catch (e) {}
        })();
    </script>
    <style>
        html.dark {
            color-scheme: dark;
            background-color: #111827;
        }
        html.dark body {
            background-color: #111827 !important;
            color: #f3f4f6;
        }
    </style>
    <title><?= $this->renderSection('title') ?> - Verifikator <?= esc($app_alias ?? 'PPDB') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>?v=<?= @filemtime(FCPATH . 'favicon.ico') ?>">

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TailAdmin CSS & Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/tailadmin/css/tailadmin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <!-- TailAdmin Bundle JS (Alpine.js, Flatpickr, etc.) -->
    <script defer src="<?= base_url('assets/tailadmin/js/tailadmin.js') ?>"></script>

    <style>
        body { font-family: 'Outfit', 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Dark mode theme toggle icons */
        html.dark .theme-toggle-moon { display: none !important; }
        html.dark .theme-toggle-sun { display: block !important; }
        html:not(.dark) .theme-toggle-sun { display: none !important; }
        html:not(.dark) .theme-toggle-moon { display: block !important; }
    </style>
    <?= $this->renderSection('head') ?>
    <?= $this->renderSection('styles') ?>
</head>

<body
    x-data="{ 
        page: 'verifikator', 
        loaded: true, 
        darkMode: localStorage.getItem('darkMode') === 'true', 
        sidebarToggle: localStorage.getItem('sidebarToggle') === 'true' 
    }"
    x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
            document.documentElement.style.colorScheme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.style.colorScheme = 'light';
        }
        $watch('darkMode', val => {
            localStorage.setItem('darkMode', JSON.stringify(val));
            if (val) {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
        });
        $watch('sidebarToggle', val => localStorage.setItem('sidebarToggle', JSON.stringify(val)));
    "
    :class="darkMode ? 'dark bg-gray-900 text-gray-100' : 'bg-gray-50 text-gray-800'"
    class="font-sans antialiased text-sm h-screen overflow-hidden flex flex-col bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100"
>

    <?php
    $unlockModel = new \App\Models\UnlockRequestModel();
    $pendingUnlockCount = $unlockModel->getPendingCount();

    $webData = $web ?? \Config\Services::renderer()->getData()['web'] ?? [];
    $sekolahName = $webData['nama_sekolah'] ?? 'Sekolah';

    $sidebarMenus = [
        'Dashboard' => [
            ['label' => 'Dashboard',          'icon' => 'tachometer-alt', 'url' => 'verifikator/dashboard'],
        ],
        'Verifikasi Data' => [
            ['label' => 'Data Siswa',         'icon' => 'users',          'url' => 'verifikator/siswa'],
            ['label' => 'Siswa Pindahan',     'icon' => 'user-friends',    'url' => 'verifikator/pindahan'],
            ['label' => 'Daftarkan Siswa',    'icon' => 'user-plus',      'url' => 'verifikator/siswa/create'],
            ['label' => 'Verifikasi Berkas',  'icon' => 'file-signature', 'url' => 'verifikator/berkas'],
            ['label' => 'Antrean Buka Kunci', 'icon' => 'unlock-alt',     'url' => 'verifikator/unlockrequest', 'badge' => $pendingUnlockCount],
        ],
        'Keuangan' => [
            ['label' => 'Pembiayaan Siswa',   'icon' => 'money-bill-wave','url' => 'verifikator/pembiayaan'],
        ],
        'Komunikasi' => [
            ['label' => 'Pesan Pribadi',      'icon' => 'envelope',       'url' => 'verifikator/pesan'],
        ],
        'Akun' => [
            ['label' => 'Profil Saya',        'icon' => 'user-circle',    'url' => 'verifikator/profile'],
        ],
    ];
    ?>

    <!-- Main Outer Wrapper -->
    <div class="flex h-screen overflow-hidden">
        <!-- Small Device Overlay -->
        <?= $this->include('layouts/components/tailadmin_overlay') ?>

        <!-- Sidebar Navigation -->
        <?= view('layouts/components/tailadmin_sidebar', [
            'sidebarMenus' => $sidebarMenus,
            'app_alias' => $app_alias ?? 'PPDB',
            'sekolahName' => $sekolahName,
            'web_logo' => $web_logo ?? null
        ]) ?>

        <!-- Content Area -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <!-- Header Bar -->
            <?= view('layouts/components/tailadmin_header', [
                'pendingUnlockCount' => $pendingUnlockCount,
                'app_alias' => $app_alias ?? 'PPDB',
                'sekolahName' => $sekolahName
            ]) ?>

            <!-- Page Title Bar (if defined) -->
            <?php if ($pageTitle = $this->renderSection('page_title')): ?>
            <div class="border-b border-gray-200/80 bg-white px-4 py-3 dark:border-gray-800 dark:bg-gray-900 sm:px-6">
                <h1 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                    <?= $pageTitle ?>
                </h1>
            </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                <!-- Flash Alerts (Auto-dismiss & Closable with Alpine.js) -->
                <?php if (session()->getFlashdata('success')): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4500)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mb-4 flex items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-800 shadow-sm dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-lg text-emerald-600 dark:text-emerald-400 shrink-0">check_circle</span>
                        <div class="flex-1 text-xs sm:text-sm font-medium">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 shrink-0 p-1">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mb-4 flex items-center justify-between gap-3 rounded-xl border border-red-200 bg-red-50/90 p-4 text-red-800 shadow-sm dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-lg text-red-600 dark:text-red-400 shrink-0">error</span>
                        <div class="flex-1 text-xs sm:text-sm font-medium">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 shrink-0 p-1">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('warning')): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mb-4 flex items-center justify-between gap-3 rounded-xl border border-amber-200 bg-amber-50/90 p-4 text-amber-800 shadow-sm dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-lg text-amber-600 dark:text-amber-400 shrink-0">warning</span>
                        <div class="flex-1 text-xs sm:text-sm font-medium">
                            <?= session()->getFlashdata('warning') ?>
                        </div>
                    </div>
                    <button @click="show = false" class="text-amber-600 hover:text-amber-800 dark:text-amber-400 dark:hover:text-amber-200 shrink-0 p-1">
                        <span class="material-symbols-outlined text-base">close</span>
                    </button>
                </div>
                <?php endif; ?>

                <!-- Page Content Section -->
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Global Footer -->
            <?= $this->include('layouts/components/footer') ?>
        </div>
    </div>

    <!-- Scripts Section -->
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>

</html>