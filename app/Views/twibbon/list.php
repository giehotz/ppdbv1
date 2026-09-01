<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?></title>
    <meta name="description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda untuk <?= esc($web['nama_sekolah'] ?? 'sekolah kami') ?>!">

    <?php 
    $ogImage = base_url('favicon.png');
    if (!empty($campaigns) && !empty($campaigns[0]['frame']['file_path'])) {
        $ogImage = base_url($campaigns[0]['frame']['file_path']);
    }
    ?>
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta property="og:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta property="og:image" content="<?= $ogImage ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta name="twitter:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta name="twitter:image" content="<?= $ogImage ?>">

    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (TailAdmin tokens) -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
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
        .bg-checkerboard {
            background-color: #f9fafb;
            background-image: 
                linear-gradient(45deg, #e5e7eb 25%, transparent 25%), 
                linear-gradient(-45deg, #e5e7eb 25%, transparent 25%), 
                linear-gradient(45deg, transparent 75%, #e5e7eb 75%), 
                linear-gradient(-45deg, transparent 75%, #e5e7eb 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-gray-50 text-gray-900 antialiased">

    <!-- Top Navbar -->
    <header class="w-full bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200 shadow-theme-xs">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="<?= base_url() ?>" class="flex items-center gap-2.5">
                <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-8 w-auto">
                <?php else: ?>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 text-white font-bold shadow-theme-xs">
                        <span class="material-symbols-outlined text-lg">school</span>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="text-sm sm:text-base font-extrabold text-gray-900 tracking-tight block leading-none"><?= esc($web['app_name'] ?? 'PPDB Online') ?></span>
                    <span class="text-[10px] text-gray-500"><?= esc($web['nama_sekolah'] ?? 'Portal PPDB') ?></span>
                </div>
            </a>
            
            <div class="flex items-center gap-2">
                <a href="<?= base_url() ?>" 
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-theme-xs transition-colors">
                    <span class="material-symbols-outlined text-base">home</span>
                    <span class="hidden sm:inline">Beranda PPDB</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-8 sm:py-12 px-4 max-w-6xl w-full mx-auto space-y-8">
        
        <!-- Hero Banner (TailAdmin Style) -->
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-brand-600 border border-brand-200/60 shadow-theme-xs">
                <span class="material-symbols-outlined text-sm">photo_filter</span>
                Twibbon Campaign
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Kampanye Twibbon Resmi
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                Pilih bingkai twibbon resmi di bawah ini, pasang foto profil terbaik Anda, dan bagikan dukungan Anda untuk <?= esc($web['nama_sekolah'] ?? 'madrasah kami') ?>!
            </p>
            
            <!-- Search Bar -->
            <div class="pt-2 max-w-md mx-auto relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <span class="material-symbols-outlined text-lg">search</span>
                </span>
                <input type="text" id="search-campaign" placeholder="Cari kampanye twibbon..."
                    class="h-11 w-full rounded-2xl border border-gray-200 bg-white pr-4 pl-10 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none shadow-theme-xs transition-all">
            </div>
        </div>

        <!-- Campaign Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="campaign-grid">
            <?php if (empty($campaigns)): ?>
                <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-theme-xs">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-400 mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl">sentiment_dissatisfied</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900">Belum Ada Kampanye Twibbon</h3>
                    <p class="text-xs text-gray-500 mt-1">Saat ini belum ada bingkai twibbon aktif yang dipublikasikan.</p>
                </div>
            <?php else: ?>
                <?php foreach ($campaigns as $c): ?>
                    <div class="campaign-card rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden transition-all duration-200 hover:shadow-theme-md hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <!-- Frame Preview with Checkerboard Transparency Background -->
                            <div class="relative bg-checkerboard aspect-square overflow-hidden flex items-center justify-center border-b border-gray-100 p-4">
                                <?php if (!empty($c['frame']['file_path'])): ?>
                                    <img src="<?= base_url($c['frame']['file_path']) ?>" alt="<?= esc($c['title']) ?>" class="w-full h-full object-contain relative z-10">
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-5xl text-gray-300 relative z-10">image</span>
                                <?php endif; ?>
                            </div>

                            <!-- Content Info -->
                            <div class="p-5 space-y-2">
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate" title="<?= esc($c['title']) ?>">
                                    <?= esc($c['title']) ?>
                                </h3>
                                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
                                    <?= strip_tags($c['description'] ?: 'Ikut serta dalam kampanye twibbon resmi dengan memasang foto profil terbaik Anda.') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Action Footer -->
                        <div class="p-5 pt-0 space-y-3">
                            <div class="flex items-center justify-between text-[11px] text-gray-400 pt-3 border-t border-gray-100">
                                <span class="inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">event</span>
                                    <?= $c['end_date'] ? 'Sampai: ' . date('d M Y', strtotime($c['end_date'])) : 'Berlaku Selamanya' ?>
                                </span>
                            </div>

                            <div class="flex gap-2">
                                <a href="<?= base_url('twibbon/' . $c['slug']) ?>"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white py-2.5 text-xs font-bold shadow-theme-xs transition-colors">
                                    <span class="material-symbols-outlined text-base">auto_fix_high</span>
                                    <span>Buat Twibbon</span>
                                </a>

                                <button type="button" onclick="shareCampaign('<?= esc($c['title'], 'js') ?>', '<?= base_url('twibbon/' . $c['slug']) ?>')"
                                    class="inline-flex items-center justify-center h-10 w-10 rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 hover:text-brand-600 shadow-theme-xs transition-colors"
                                    title="Bagikan Kampanye">
                                    <span class="material-symbols-outlined text-base">share</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 bg-gray-900 text-white text-xs font-semibold px-4 py-3 rounded-xl shadow-2xl transform translate-y-10 opacity-0 pointer-events-none transition-all duration-300 z-50 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-400 text-base">check_circle</span>
        <span id="toast-message">Tautan berhasil disalin!</span>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-white border-t border-gray-200 py-6 mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-gray-500">
            <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Search Filter
        const searchInput = document.getElementById('search-campaign');
        const campaignCards = document.querySelectorAll('.campaign-card');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase();
                campaignCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const desc = card.querySelector('p').textContent.toLowerCase();
                    if (title.includes(query) || desc.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Web Share & Clipboard API
        function shareCampaign(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Ayo buat twibbon resmi "' + title + '"!',
                    url: url
                }).catch(err => {});
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Tautan kampanye berhasil disalin!');
                }).catch(() => {
                    alert('Gagal menyalin tautan.');
                });
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-10', 'opacity-0', 'pointer-events-none');
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }
    </script>
</body>
</html>
