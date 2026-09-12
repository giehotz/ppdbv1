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
    <title><?= $this->renderSection('title') ?> - Siswa <?= esc($app_alias ?? 'PPDB') ?></title>
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
    </style>
    <?= $this->renderSection('head') ?>
    <?= $this->renderSection('styles') ?>
</head>

<body
    x-data="{ 
        page: 'siswa', 
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
    $webData = $web ?? \Config\Services::renderer()->getData()['web'] ?? [];
    $sekolahName = $webData['nama_sekolah'] ?? 'Sekolah';

    $pesanModel = new \App\Models\PesanModel();
    $unreadPesan = $pesanModel->countUnreadSiswa(session()->get('id_siswa'));

    $sidebarMenus = [
        'Menu Utama' => [
            ['label' => 'Dashboard',           'icon' => 'home',            'url' => 'siswa/dashboard'],
            ['label' => 'Biodata Siswa',       'icon' => 'user-edit',       'url' => 'siswa/biodata'],
            ['label' => 'Upload Berkas',       'icon' => 'file-upload',     'url' => 'siswa/berkas'],
            ['label' => 'Cetak Kartu Peserta', 'icon' => 'id-card',         'url' => 'siswa/cetak-kartu'],
        ],
        'Tahapan PPDB' => [
            ['label' => 'Status Pendaftaran',  'icon' => 'clipboard-check', 'url' => 'siswa/status'],
            ['label' => 'Hasil Kelulusan',     'icon' => 'graduation-cap',  'url' => 'siswa/kelulusan'],
        ],
        'Informasi & Dokumen' => [
            ['label' => 'Pengumuman',          'icon' => 'bullhorn',        'url' => 'siswa/pengumuman'],
            ['label' => 'Surat Pernyataan',    'icon' => 'file-contract',   'url' => 'siswa/surat-pernyataan'],
            ['label' => 'Twibbon',             'icon' => 'image',           'url' => 'siswa/twibbon'],
            ['label' => 'Kotak Masuk',         'icon' => 'inbox',           'url' => 'siswa/pesan', 'badge' => $unreadPesan],
        ],
    ];

    if (!isset($webData['tampil_pembiayaan_siswa']) || $webData['tampil_pembiayaan_siswa'] == 1) {
        array_unshift($sidebarMenus['Tahapan PPDB'], ['label' => 'Pembiayaan', 'icon' => 'money-bill-wave', 'url' => 'siswa/pembiayaan']);
    }

    $idSiswaNav = session()->get('id_siswa');
    if ($idSiswaNav) {
        $siswaModelNav = new \App\Models\SiswaModel();
        $siswaNav = $siswaModelNav->select('status_lulus')->find($idSiswaNav);
        if (($siswaNav['status_lulus'] ?? '') === 'Lulus') {
            $labelDu = (($webData['seragam_aktif'] ?? '1') == '1') ? 'Daftar Ulang & Seragam' : 'Daftar Ulang';
            $iconDu  = (($webData['seragam_aktif'] ?? '1') == '1') ? 'tshirt' : 'user-check';
            $sidebarMenus['Tahapan PPDB'][] = ['label' => $labelDu, 'icon' => $iconDu, 'url' => 'siswa/daftar-ulang'];
        }
    }

    $nisn = session()->get('nisn');
    $foto = session()->get('foto');
    $fotoPath = !empty($foto) ? 'uploads/berkas/' . $nisn . '/' . $foto : '';
    $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);

    if (!$hasFoto && !empty($idSiswaNav)) {
        $berkasFoto = (new \App\Models\BerkasModel())
            ->where('id_siswa', $idSiswaNav)
            ->where('jenis_berkas', 'foto')
            ->first();
        if (!empty($berkasFoto['nama_file'])) {
            $berkasPath = 'uploads/berkas/' . $nisn . '/' . $berkasFoto['nama_file'];
            if (file_exists(FCPATH . $berkasPath)) {
                $fotoPath = $berkasPath;
                $hasFoto = true;
            }
        }
    }

    $avatarUrl = $hasFoto ? base_url($fotoPath) : null;
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
            'web_logo' => $web_logo ?? null,
            'collapsibleGroups' => ['Tahapan PPDB', 'Informasi & Dokumen'],
        ]) ?>

        <!-- Content Area -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            
            <!-- Impersonation Banner -->
            <?php if (session()->get('impersonator_id')): ?>
            <div class="sticky top-0 z-[1000] bg-orange-500 text-white px-4 py-2.5 flex flex-col sm:flex-row sm:items-center justify-between shadow-md gap-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">visibility</span>
                    <span class="text-xs sm:text-sm font-semibold">Mode Menyamar: Mengakses sebagai <strong><?= esc(session()->get('nama_lengkap') ?? 'Siswa') ?></strong></span>
                </div>
                <form action="<?= base_url('impersonate/stop') ?>" method="POST" class="m-0 p-0 shrink-0">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full sm:w-auto bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors border border-white/30 flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">logout</span> Kembali ke Akun Asli
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Header Bar -->
            <header
              x-data="{ notificationOpen: false, profileOpen: false }"
              class="sticky top-0 z-999 flex w-full border-b border-gray-200 bg-white/90 backdrop-blur-md dark:border-gray-800 dark:bg-gray-900/90"
            >
              <div class="flex grow items-center justify-between px-4 py-3 sm:px-6 lg:py-3.5">
                <div class="flex items-center gap-3">
                  <!-- Hamburger Toggle BTN -->
                  <button
                    :class="sidebarToggle ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white'"
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 transition-colors dark:border-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800"
                    @click.stop="sidebarToggle = !sidebarToggle"
                    title="Toggle Menu Sidebar"
                  >
                    <svg class="fill-current" width="18" height="14" viewBox="0 0 16 12" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z" />
                    </svg>
                  </button>

                  <!-- App Title on Mobile -->
                  <div class="flex items-center gap-2 lg:hidden">
                    <span class="text-base font-bold tracking-tight text-gray-900 dark:text-white">
                      <?= esc($app_alias ?? 'PPDB') ?> Siswa
                    </span>
                  </div>
                </div>

                <!-- Right Area Action Items -->
                <div class="flex items-center gap-2 sm:gap-3">
                  <!-- Dark Mode Toggler -->
                  <button
                    class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    @click.prevent="darkMode = !darkMode"
                    title="Ganti Tema (Dark / Light Mode)"
                  >
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg class="hidden dark:block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg class="dark:hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                  </button>

                  <!-- Notification Bell (Pengumuman) -->
                  <div class="relative">
                    <button
                      id="notification-button"
                      onclick="toggleNotificationDropdown()"
                      class="relative flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                      title="Pengumuman Terbaru"
                    >
                      <span class="material-symbols-outlined text-xl">notifications</span>
                      <span id="notification-badge" class="absolute -top-1 -right-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white shadow hidden">0</span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50 overflow-hidden">
                      <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between">
                        <h3 class="text-xs font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                          <span class="material-symbols-outlined text-sm text-brand-500">campaign</span>
                          <span>Pengumuman Terbaru</span>
                        </h3>
                      </div>
                      <div id="notification-dropdown-content" class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                        <div class="px-4 py-6 text-center text-gray-400 dark:text-gray-500">
                          <span class="material-symbols-outlined text-2xl animate-spin mb-1">progress_activity</span>
                          <p>Memuat pengumuman...</p>
                        </div>
                      </div>
                      <div class="p-2.5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 text-center">
                        <a href="<?= base_url('siswa/pengumuman') ?>" class="text-xs font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                          Lihat Semua Pengumuman &rarr;
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- Messages Notification Icon -->
                  <?php if (!empty($unreadPesan) && $unreadPesan > 0): ?>
                  <a
                    href="<?= base_url('siswa/pesan') ?>"
                    class="relative flex h-10 w-10 items-center justify-center rounded-lg border border-purple-200 bg-purple-50/50 text-purple-600 transition-colors hover:bg-purple-100 dark:border-purple-900/50 dark:bg-purple-950/40 dark:text-purple-400"
                    title="<?= $unreadPesan ?> Pesan Masuk Belum Dibaca"
                  >
                    <span class="material-symbols-outlined text-xl">mail</span>
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white shadow">
                      <?= $unreadPesan ?>
                    </span>
                  </a>
                  <?php endif; ?>

                  <!-- User Profile Dropdown -->
                  <div
                    class="relative"
                    x-data="{ profileOpen: false }"
                    @click.outside="profileOpen = false"
                  >
                    <button
                      class="flex items-center gap-2.5 rounded-lg p-1.5 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300"
                      @click.prevent="profileOpen = !profileOpen"
                    >
                      <span class="h-9 w-9 overflow-hidden rounded-full ring-2 ring-brand-500/20 bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center font-bold text-brand-600 dark:text-brand-400 text-xs">
                        <?php if ($avatarUrl): ?>
                          <img src="<?= $avatarUrl ?>" alt="Avatar" class="h-full w-full object-cover" />
                        <?php else: ?>
                          <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'S', 0, 1)) ?>
                        <?php endif; ?>
                      </span>

                      <div class="hidden text-left md:block">
                        <span class="block text-xs font-semibold text-gray-800 dark:text-gray-100 max-w-[130px] truncate">
                          <?= esc(session()->get('nama_lengkap') ?? 'Siswa') ?>
                        </span>
                        <span class="block text-[10px] text-gray-400 dark:text-gray-500 font-mono leading-none mt-0.5">
                          <?= esc(session()->get('no_pendaftaran') ?? 'Calon Siswa') ?>
                        </span>
                      </div>

                      <span class="material-symbols-outlined text-base text-gray-400">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                      x-show="profileOpen"
                      x-transition:enter="transition ease-out duration-150"
                      x-transition:enter-start="opacity-0 scale-95"
                      x-transition:enter-end="opacity-100 scale-100"
                      x-transition:leave="transition ease-in duration-100"
                      x-transition:leave-start="opacity-100 scale-100"
                      x-transition:leave-end="opacity-0 scale-95"
                      class="absolute right-0 mt-2 w-56 rounded-2xl border border-gray-200 bg-white p-2 shadow-xl dark:border-gray-800 dark:bg-gray-900 z-50"
                      style="display: none;"
                    >
                      <div class="border-b border-gray-100 px-3 py-2 dark:border-gray-800">
                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate"><?= esc(session()->get('nama_lengkap') ?? 'Siswa') ?></p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 font-mono">NISN: <?= esc(session()->get('nisn') ?? '-') ?></p>
                      </div>

                      <div class="py-1">
                        <a
                          href="<?= base_url('siswa/profile') ?>"
                          class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors"
                        >
                          <span class="material-symbols-outlined text-base text-gray-400">person</span>
                          <span>Profil Saya</span>
                        </a>
                        <a
                          href="<?= base_url('siswa/ubah-password') ?>"
                          class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white transition-colors"
                        >
                          <span class="material-symbols-outlined text-base text-gray-400">lock_reset</span>
                          <span>Ubah Password</span>
                        </a>
                      </div>

                      <div class="border-t border-gray-100 pt-1 dark:border-gray-800">
                        <a
                          href="<?= base_url('logout') ?>"
                          class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40 transition-colors"
                        >
                          <span class="material-symbols-outlined text-base text-red-500">logout</span>
                          <span>Keluar (Logout)</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </header>

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

    <!-- Notification System JavaScript -->
    <script src="<?= base_url('js/notifications.js') ?>"></script>

    <!-- Scripts Section -->
    <?= $this->renderSection('scripts') ?>
    <?= view('partials/sweetalert') ?>
</body>

</html>