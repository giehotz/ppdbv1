<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= $this->renderSection('title') ?> - <?= $app_alias ?? 'PPDB' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .safe-top { padding-top: env(safe-area-inset-top, 0px); }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .pb-safe { padding-bottom: calc(env(safe-area-inset-bottom, 0px) + 5rem); }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Header glass */
        .header-glass {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .header-glass.dark {
            background: rgba(5, 40, 25, 0.92);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        /* Bottom tab bar */
        .tab-bar {
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-top: 1px solid rgba(0,0,0,0.06);
        }
        .tab-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
            -webkit-tap-highlight-color: transparent;
        }
        .tab-item .tab-icon {
            font-size: 1.25rem;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .tab-item.active .tab-icon { transform: scale(1.15); }
        .tab-item .tab-label {
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            margin-top: 2px;
            transition: opacity 0.2s ease;
        }
        .tab-item::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 20px;
            height: 3px;
            border-radius: 3px;
            background: #059669;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .tab-item.active::before { transform: translateX(-50%) scaleX(1); }

        /* Offcanvas */
        .offcanvas-backdrop {
            transition: opacity 0.35s ease;
        }
        .offcanvas-panel {
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .offcanvas-panel.open { transform: translateX(0); }

        /* Profile card in offcanvas */
        .profile-card {
            background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
        }

        /* Menu item hover touch */
        .menu-item {
            position: relative;
            overflow: hidden;
        }
        .menu-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: currentColor;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .menu-item:active::after { opacity: 0.06; }

        /* Page transition */
        .page-enter {
            animation: pageIn 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Ripple */
        .ripple {
            position: relative;
            overflow: hidden;
        }
        .ripple::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            width: 100px; height: 100px;
            margin-top: -50px; margin-left: -50px;
            top: 50%; left: 50%;
            transform: scale(0);
            opacity: 0;
        }
        .ripple:active::after {
            transform: scale(3);
            opacity: 1;
            transition: transform 0.4s ease, opacity 0.3s ease;
        }

        /* Badge */
        .badge-dot {
            position: absolute;
            top: 2px;
            right: -2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ef4444;
            border: 2px solid #fff;
        }

        @media (display-mode: standalone) {
            body { user-select: none; }
        }
    </style>
    <?= $this->renderSection('head') ?>
</head>
<body class="bg-gray-50 overflow-hidden">

    <div class="flex flex-col h-screen">

        <!-- ===== HEADER ===== -->
        <header class="header-glass dark text-white safe-top sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 h-14">
                <button onclick="toggleOffcanvas()" class="w-9 h-9 flex items-center justify-center rounded-xl active:bg-white/10 transition-colors ripple" aria-label="Menu">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                <h1 class="text-sm font-bold truncate max-w-[180px] text-center">
                    <?= $this->renderSection('page_title') ?>
                </h1>

                <button onclick="window.location.href='<?= base_url('logout') ?>'" class="w-9 h-9 flex items-center justify-center rounded-xl active:bg-white/10 transition-colors ripple" aria-label="Keluar">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </div>
        </header>

        <!-- ===== CONTENT ===== -->
        <main class="flex-1 overflow-y-auto hide-scrollbar bg-gray-50/80">
            <div class="page-enter pb-safe">
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <!-- ===== BOTTOM TAB BAR ===== -->
        <nav class="tab-bar fixed bottom-0 left-0 right-0 z-20 safe-bottom">
            <div class="flex items-center h-[4.25rem] px-1">
                <?php
                $tabs = [
                    ['url' => 'siswa/dashboard',  'icon' => 'fa-home',        'label' => 'Home',      'match' => uri_string() == 'siswa/dashboard'],
                    ['url' => 'siswa/biodata',    'icon' => 'fa-user-edit',   'label' => 'Biodata',   'match' => strpos(uri_string(), 'siswa/biodata') !== false],
                    ['url' => 'siswa/twibbon',    'icon' => 'fa-image',       'label' => 'Twibbon',   'match' => strpos(uri_string(), 'siswa/twibbon') !== false],
                    ['url' => 'siswa/pesan',      'icon' => 'fa-envelope',    'label' => 'Pesan',     'match' => strpos(uri_string(), 'siswa/pesan') !== false],
                    ['url' => 'siswa/status',     'icon' => 'fa-clipboard-check', 'label' => 'Status', 'match' => strpos(uri_string(), 'siswa/status') !== false],
                ];
                foreach ($tabs as $t):
                    $isActive = $t['match'];
                ?>
                <a href="<?= base_url($t['url']) ?>" class="tab-item flex-1 h-full <?= $isActive ? 'active text-emerald-600' : 'text-gray-400' ?>">
                    <div class="relative">
                        <i class="fas <?= $t['icon'] ?> tab-icon"></i>
                    </div>
                    <span class="tab-label"><?= $t['label'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </nav>
    </div>

    <!-- ===== OFFCANVAS MENU ===== -->
    <div id="offcanvas" class="fixed inset-0 z-50 hidden">
        <div id="offcanvasBackdrop" class="absolute inset-0 bg-black/40 offcanvas-backdrop opacity-0" onclick="toggleOffcanvas()"></div>

        <div id="offcanvasPanel" class="absolute inset-y-0 left-0 w-72 max-w-[85vw] bg-white shadow-2xl offcanvas-panel -translate-x-full flex flex-col">
            <!-- Profile Card -->
            <div class="profile-card p-5 safe-top">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-white/60 text-xs font-semibold uppercase tracking-wider">Menu</span>
                    <button onclick="toggleOffcanvas()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 active:bg-white/20 transition-colors" aria-label="Tutup">
                        <i class="fas fa-times text-white text-sm"></i>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center overflow-hidden border-2 border-white/20 shrink-0 shadow-lg">
                        <?php if (isset($siswa['foto']) && !empty($siswa['foto']) && isset($siswa['nisn']) && file_exists(FCPATH . 'uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto'])): ?>
                            <img src="<?= base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $siswa['foto']) ?>" alt="Foto" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="text-2xl font-bold text-white"><?= strtoupper(substr(session()->get('nama_lengkap') ?? 'S', 0, 1)) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-white font-bold text-sm truncate"><?= session()->get('nama_lengkap') ?? 'Siswa' ?></h3>
                        <p class="text-emerald-100 text-xs mt-0.5 truncate"><?= session()->get('no_pendaftaran') ?? '' ?></p>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 overflow-y-auto hide-scrollbar py-2">
                <?php
                $menuGroups = [
                    'Utama' => [
                        ['url' => 'siswa/dashboard',  'icon' => 'fa-home',          'label' => 'Dashboard'],
                        ['url' => 'siswa/biodata',    'icon' => 'fa-user-edit',     'label' => 'Biodata'],
                        ['url' => 'siswa/berkas',     'icon' => 'fa-file-upload',   'label' => 'Upload Berkas'],
                    ],
                    'Informasi' => [
                        ['url' => 'siswa/status',     'icon' => 'fa-clipboard-check','label' => 'Status Pendaftaran'],
                        ['url' => 'siswa/kelulusan',  'icon' => 'fa-graduation-cap','label' => 'Kelulusan'],
                        ['url' => 'siswa/pengumuman', 'icon' => 'fa-bullhorn',      'label' => 'Pengumuman'],
                        ['url' => 'siswa/twibbon',    'icon' => 'fa-image',         'label' => 'Twibbon'],
                        ['url' => 'siswa/pesan',      'icon' => 'fa-envelope',      'label' => 'Pesan'],
                    ],
                    'Akun' => [
                        ['url' => 'siswa/profile',     'icon' => 'fa-user-circle',   'label' => 'Profil Saya'],
                        ['url' => 'siswa/ubah-password','icon' => 'fa-key',          'label' => 'Ubah Password'],
                    ],
                ];
                $gIdx = 0;
                foreach ($menuGroups as $groupLabel => $items):
                    $gIdx++;
                ?>
                <?php if ($gIdx > 1): ?><div class="border-t border-gray-100 my-2 mx-4"></div><?php endif; ?>
                <p class="px-5 pt-3 pb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-400"><?= $groupLabel ?></p>
                <?php foreach ($items as $item):
                    $isActive = strpos(uri_string(), $item['url']) !== false;
                ?>
                <a href="<?= base_url($item['url']) ?>" class="menu-item flex items-center gap-3 px-5 py-3 <?= $isActive ? 'text-emerald-600 bg-emerald-50 font-semibold' : 'text-gray-600' ?> transition-colors">
                    <span class="w-8 h-8 flex items-center justify-center rounded-xl <?= $isActive ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400' ?> shrink-0 transition-colors">
                        <i class="fas <?= $item['icon'] ?> text-sm"></i>
                    </span>
                    <span class="text-sm"><?= $item['label'] ?></span>
                </a>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </div>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-100 safe-bottom bg-gray-50/80">
                <a href="<?= base_url('logout') ?>" class="flex items-center justify-center gap-2 w-full py-3 bg-white border border-red-200 text-red-600 hover:bg-red-50 active:bg-red-100 rounded-xl transition-colors font-semibold text-sm ripple">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>

    <script>
    function toggleOffcanvas() {
        const el = document.getElementById('offcanvas');
        const backdrop = document.getElementById('offcanvasBackdrop');
        const panel = document.getElementById('offcanvasPanel');
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.add('open');
            });
        } else {
            backdrop.classList.add('opacity-0');
            panel.classList.remove('open');
            setTimeout(() => el.classList.add('hidden'), 350);
        }
    }

    // Swipe to close offcanvas
    let touchStartX = 0;
    document.getElementById('offcanvasPanel')?.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    document.getElementById('offcanvasPanel')?.addEventListener('touchmove', e => {
        const dx = e.touches[0].clientX - touchStartX;
        if (dx < -40) toggleOffcanvas();
    }, { passive: true });
    </script>
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>
</html>
