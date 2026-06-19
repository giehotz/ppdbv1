<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftar - <?= isset($content['navbar']['nama_sekolah']) ? esc($content['navbar']['nama_sekolah']) : 'PPDB Online' ?></title>
    
    <?php
    $page_title = 'Daftar Pendaftar';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-madrasah { background-color: #064e3b; }
        .text-madrasah { color: #064e3b; }

        /* CI4 Pager Styling for Tailwind */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            gap: 0.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pagination li a, .pagination li span {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            line-height: 1.25;
            color: #16a34a;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .pagination li a:hover {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
            color: #15803d;
        }
        .pagination li.active span {
            z-index: 1;
            color: #fff;
            background-color: #16a34a;
            border-color: #16a34a;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <?php if (!empty($web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain rounded-full bg-white p-0.5 border border-gray-100">
                <?php else: ?>
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-madrasah rounded-full flex items-center justify-center text-white font-bold text-lg md:text-xl">
                        <?= mb_substr(esc($content['navbar']['nama_sekolah'] ?? 'M'), 0, 1) ?>
                    </div>
                <?php endif; ?>
                <span class="font-bold text-sm sm:text-lg md:text-xl tracking-tight leading-tight"><?= esc($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus') ?></span>
            </div>
            <div class="hidden lg:flex space-x-6 font-medium">
                <a href="<?= base_url('/') ?>#beranda" class="hover:text-green-600 transition">Beranda</a>
                <a href="<?= base_url('/') ?>#jadwal" class="hover:text-green-600 transition">Jadwal</a>
                <a href="<?= base_url('/') ?>#syarat" class="hover:text-green-600 transition">Syarat</a>
                <a href="<?= base_url('/') ?>#kontak" class="hover:text-green-600 transition">Kontak</a>
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                    <a href="<?= base_url('pendaftar') ?>" class="text-green-600 transition border-b-2 border-green-600 pb-1">Data Pendaftar</a>
                <?php endif; ?>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="<?= base_url('login') ?>" class="bg-blue-700 text-white font-bold py-1.5 px-3 md:py-2 md:px-5 rounded-full hover:bg-blue-800 transition duration-300 text-xs md:text-sm hidden sm:inline-block">Login</a>
                <a href="<?= base_url('auth/register') ?>" class="bg-green-700 text-white font-bold py-1.5 px-3 md:py-2 md:px-5 rounded-full hover:bg-green-800 transition duration-300 text-xs md:text-sm hidden sm:inline-block">Daftar</a>
                <button class="lg:hidden text-gray-600 p-1" id="menu-btn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200 px-4 py-3 space-y-2 bg-gray-50 absolute w-full shadow-lg">
            <a href="<?= base_url('/') ?>#beranda" class="block py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-600 font-medium">Beranda</a>
            <a href="<?= base_url('/') ?>#jadwal" class="block py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-600 font-medium">Jadwal</a>
            <a href="<?= base_url('/') ?>#syarat" class="block py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-600 font-medium">Syarat</a>
            <a href="<?= base_url('/') ?>#kontak" class="block py-2 px-3 rounded-lg hover:bg-green-50 hover:text-green-600 font-medium">Kontak</a>
            <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] === '1'): ?>
                <a href="<?= base_url('pendaftar') ?>" class="block py-2 px-3 rounded-lg bg-green-50 text-green-600 font-medium">Data Pendaftar</a>
            <?php endif; ?>
            <div class="border-t border-gray-200 pt-3 mt-2 flex flex-col space-y-2 sm:hidden">
                <a href="<?= base_url('login') ?>" class="block text-center bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700">Login</a>
                <a href="<?= base_url('auth/register') ?>" class="block text-center bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-grow py-12 px-4 bg-gradient-to-b from-green-50 to-white">
        <div class="container mx-auto max-w-5xl">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <span class="inline-block py-1 px-4 rounded-full bg-green-100 text-green-700 font-bold tracking-wider text-xs mb-4 uppercase shadow-sm border border-green-200">Data Publik</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-madrasah mb-4">Daftar Pendaftar</h1>
                <div class="w-24 h-1.5 bg-gradient-to-r from-green-400 to-green-600 mx-auto rounded-full mb-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/30 animate-pulse"></div>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed">Untuk perlindungan privasi, sebagian data NISN dan Nama Lengkap <span class="font-semibold text-green-700">disensor</span> sesuai dengan kebijakan yang berlaku.</p>
            </div>

            <!-- Search Section -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_-4px_rgba(0,0,0,0.05)] border border-gray-100 p-6 sm:p-8 mb-10 transform scale-100 hover:scale-[1.01] transition-transform duration-300">
                <form action="<?= base_url('pendaftar') ?>" method="get" class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 group-focus-within:text-green-500 transition-colors"></i>
                        </div>
                        <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Cari berdasarkan NISN atau Nama Lengkap..." 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all font-medium text-gray-700 placeholder-gray-400">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-grow sm:flex-grow-0 bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-8 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center space-x-2">
                            <span>Cari Data</span>
                        </button>
                        <?php if(!empty($search)): ?>
                            <a href="<?= base_url('pendaftar') ?>" title="Reset Pencarian" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3.5 px-5 rounded-2xl transition-colors flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_-4px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden relative">
                <?php if (!empty($search) && !empty($pendaftar)): ?>
                    <div class="bg-green-50 border-b border-green-100 px-6 py-4 flex items-center text-green-800 text-sm">
                        <i class="fas fa-info-circle mr-2 text-green-600"></i>
                        <span>Menampilkan hasil pencarian untuk: <span class="font-bold">"<?= esc($search) ?>"</span></span>
                    </div>
                <?php endif; ?>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="py-5 px-6 font-semibold text-gray-500 text-xs uppercase tracking-wider w-16 text-center">No</th>
                                <th class="py-5 px-6 font-semibold text-gray-500 text-xs uppercase tracking-wider">NISN</th>
                                <th class="py-5 px-6 font-semibold text-gray-500 text-xs uppercase tracking-wider">Nama Pendaftar</th>
                                <th class="py-5 px-6 font-semibold text-gray-500 text-xs uppercase tracking-wider w-1/4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if (empty($pendaftar)): ?>
                                <tr>
                                    <td colspan="4" class="py-16 px-6 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                                            </div>
                                            <p class="text-lg font-medium text-gray-700">Tidak ada data ditemukan</p>
                                            <?php if(!empty($search)): ?>
                                                <p class="text-sm mt-1">Coba gunakan kata kunci pencarian yang berbeda.</p>
                                            <?php else: ?>
                                                <p class="text-sm mt-1">Belum ada pendaftar yang masuk ke sistem.</p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php 
                                $page = isset($_GET['page_pendaftar']) ? (int)$_GET['page_pendaftar'] : 1;
                                $no = ($page - 1) * 20 + 1;
                                foreach ($pendaftar as $p): 
                                ?>
                                    <tr class="group hover:bg-green-50/50 transition-colors">
                                        <td class="py-4 px-6 text-sm text-gray-500 text-center font-medium"><?= $no++ ?></td>
                                        <td class="py-4 px-6 text-sm font-semibold text-gray-800">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-100 transition-colors">
                                                    <i class="fas fa-id-card text-xs"></i>
                                                </div>
                                                <span class="tracking-widest"><?= esc($p['nisn']) ?></span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-sm font-semibold text-gray-800 tracking-wide"><?= esc($p['nama_lengkap']) ?></td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                                Terdaftar
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (!empty($pendaftar) && $pager->getPageCount('pendaftar') > 1): ?>
                <div class="p-6 border-t border-gray-100 bg-white flex justify-center mt-2">
                    <?= $pager->links('pendaftar', 'default_full') ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-madrasah text-white pt-8 pb-6 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold mb-2"><?= esc($content['footer']['nama_sekolah'] ?? ($content['navbar']['nama_sekolah'] ?? 'MIN 2 Tanggamus')) ?></h3>
            <p class="text-green-200 text-sm mb-4">&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? '') ?>. <?= esc($content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.') ?></p>
        </div>
    </footer>

    <script>
        document.getElementById('menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
