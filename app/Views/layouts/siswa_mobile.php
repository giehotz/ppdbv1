<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= $this->renderSection('title') ?> - <?= $app_alias ?? 'PPDB' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>?v=<?= @filemtime(FCPATH . 'favicon.ico') ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (TailAdmin tokens) -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <style>
        *, *::before, *::after {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 22px;
            line-height: 1;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        .safe-top { padding-top: env(safe-area-inset-top, 0px); }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .pb-safe { padding-bottom: calc(env(safe-area-inset-bottom, 0px) + 5.5rem); }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Header Glass */
        .header-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Bottom Tab Bar */
        .tab-bar {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
        .tab-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .tab-item.active {
            color: #465fff;
        }
        .tab-item.active .tab-icon-wrap {
            transform: scale(1.1);
        }
        .tab-item::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 24px;
            height: 3px;
            border-radius: 9999px;
            background: #465fff;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .tab-item.active::before {
            transform: translateX(-50%) scaleX(1);
        }

        @media (display-mode: standalone) {
            body { user-select: none; }
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body class="bg-gray-100/70 text-gray-800 antialiased overflow-hidden">

    <div class="flex flex-col h-screen">

        <!-- ===== HEADER (TailAdmin Mobile - No Hamburger) ===== -->
        <header class="header-glass text-gray-900 safe-top sticky top-0 z-20 shadow-sm">
            <div class="flex items-center justify-between px-4 h-14">
                <?php 
                $isRootDashboard = (uri_string() === 'siswa/dashboard' || uri_string() === 'siswa' || uri_string() === '');
                ?>

                <?php if ($isRootDashboard): ?>
                    <div class="flex items-center gap-2.5">
                        <?php 
                        $schoolLogo = $web['logo_sekolah'] ?? ($web_logo ?? null);
                        if (!empty($schoolLogo)): ?>
                            <img src="<?= base_url('uploads/logo/' . esc($schoolLogo, 'url')) ?>" alt="Logo" class="h-8 w-8 object-contain">
                        <?php else: ?>
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-brand-500 text-white font-bold text-sm shadow-sm">
                                <span class="material-symbols-outlined text-lg">school</span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h1 class="text-xs font-extrabold tracking-tight text-gray-900"><?= esc($app_alias ?? 'PPDB') ?></h1>
                            <span class="text-[9px] text-gray-500 block -mt-0.5">Portal Calon Siswa</span>
                        </div>
                    </div>
                <?php else: ?>
                    <button onclick="window.location.href='<?= base_url('siswa/dashboard') ?>'" 
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 active:scale-95 transition-all border border-gray-200/50" 
                            aria-label="Kembali ke Beranda" title="Kembali ke Dashboard">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                    </button>
                    
                    <h1 class="text-sm font-bold truncate max-w-[200px] text-center tracking-tight text-gray-900">
                        <?= $this->renderSection('page_title') ?>
                    </h1>
                <?php endif; ?>

                <button onclick="if(confirm('Apakah Anda yakin ingin keluar?')) window.location.href='<?= base_url('logout') ?>'" 
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-500 hover:text-red-600 hover:bg-red-50 active:scale-95 transition-all border border-gray-200/50" 
                        aria-label="Keluar" title="Keluar">
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </div>
        </header>

        <!-- Impersonation Banner -->
        <?php if (session()->get('impersonator_id')): ?>
        <div class="bg-orange-500 text-white px-3 py-2 flex items-center justify-between shadow-md z-10 shrink-0">
            <div class="flex items-center gap-1.5 min-w-0">
                <span class="material-symbols-outlined text-lg shrink-0">visibility</span>
                <span class="text-[10px] sm:text-xs font-bold leading-tight truncate">
                    Menyamar sebagai: <?= esc(session()->get('nama_lengkap') ?? 'Siswa') ?>
                </span>
            </div>
            <form action="<?= base_url('impersonate/stop') ?>" method="POST" class="m-0 p-0 shrink-0">
                <?= csrf_field() ?>
                <button type="submit" class="bg-white/20 hover:bg-white/30 px-2 py-1 rounded-md text-[10px] font-bold transition-colors border border-white/30">
                    Kembali
                </button>
            </form>
        </div>
        <?php endif; ?>

        <!-- ===== CONTENT ===== -->
        <main class="flex-1 overflow-y-auto hide-scrollbar p-4 bg-gray-100/60">
            <div class="pb-safe">
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <!-- ===== BOTTOM TAB BAR (TailAdmin Mobile) ===== -->
        <nav class="tab-bar fixed bottom-0 left-0 right-0 z-20 safe-bottom shadow-theme-sm">
            <div class="flex items-center h-[4.25rem] px-2">
                <?php
                $currentUri = uri_string();
                $tabs = [
                    ['url' => 'siswa/dashboard',  'icon' => 'home',           'label' => 'Home',      'match' => $isRootDashboard],
                    ['url' => 'siswa/biodata',    'icon' => 'badge',          'label' => 'Biodata',   'match' => strpos($currentUri, 'siswa/biodata') !== false],
                    ['url' => 'siswa/berkas',     'icon' => 'upload_file',    'label' => 'Berkas',    'match' => strpos($currentUri, 'siswa/berkas') !== false],
                    ['url' => 'siswa/status',     'icon' => 'rule',           'label' => 'Status',    'match' => strpos($currentUri, 'siswa/status') !== false],
                    ['url' => 'siswa/profile',    'icon' => 'person',         'label' => 'Profil',    'match' => strpos($currentUri, 'siswa/profile') !== false || strpos($currentUri, 'siswa/ubah-password') !== false],
                ];
                foreach ($tabs as $t):
                    $isActive = $t['match'];
                ?>
                <a href="<?= base_url($t['url']) ?>" class="tab-item flex-1 h-full <?= $isActive ? 'active' : 'text-gray-400 hover:text-gray-600' ?>">
                    <div class="tab-icon-wrap transition-transform duration-200">
                        <span class="material-symbols-outlined text-[22px]"><?= $t['icon'] ?></span>
                    </div>
                    <span class="text-[10px] font-bold mt-0.5 tracking-tight"><?= $t['label'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </nav>
    </div>

    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>
</html>
