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
    <!-- Open Graph / Facebook / WhatsApp / Telegram -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta property="og:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta property="og:image" content="<?= $ogImage ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= current_url() ?>">
    <meta name="twitter:title" content="Daftar Kampanye Twibbon - <?= esc($web['nama_sekolah'] ?? 'PPDB') ?>">
    <meta name="twitter:description" content="Pilih kampanye twibbon resmi, pasang foto profil terbaik Anda, dan bagikan dukungan Anda!">
    <meta name="twitter:image" content="<?= $ogImage ?>">
    <link rel="icon" type="image/png" href="<?= base_url('favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0fdf4 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
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
<body class="min-h-screen flex flex-col justify-between">

    <!-- Top Navbar -->
    <header class="w-full glass sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="<?= base_url() ?>" class="flex items-center gap-2">
                <?php if (!empty($web['logo_sekolah']) && file_exists(FCPATH . 'uploads/logo/' . $web['logo_sekolah'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="h-8 w-auto">
                <?php endif; ?>
                <span class="text-xl font-extrabold text-emerald-800 tracking-tight"><?= esc($web['app_name'] ?? 'PPDB Online') ?></span>
            </a>
            <a href="<?= base_url() ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs px-4 py-2 rounded-full shadow-md transition-all duration-200 flex items-center gap-1.5">
                <i class="fas fa-home"></i> Beranda PPDB
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 py-12 px-4 max-w-6xl w-full mx-auto">
        <!-- Hero section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-emerald-950 tracking-tight leading-tight">
                Kampanye Twibbon Sekolah
            </h1>
            <p class="text-emerald-800 text-sm md:text-base mt-3 max-w-2xl mx-auto opacity-80">
                Pilih kampanye aktif di bawah ini, pasang foto profil terbaik Anda, dan bagikan dukungan Anda untuk <?= esc($web['nama_sekolah'] ?? 'sekolah kami') ?>!
            </p>
            
            <!-- Search bar -->
            <div class="mt-8 max-w-md mx-auto relative">
                <input type="text" id="search-campaign" placeholder="Cari kampanye..." class="w-full bg-white/90 border border-emerald-100 rounded-full py-3 px-6 pl-12 shadow-md outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-emerald-600"></i>
            </div>
        </div>

        <!-- Campaign Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="campaign-grid">
            <?php if (empty($campaigns)): ?>
                <div class="col-span-full text-center py-16 bg-white/60 border border-emerald-50 rounded-2xl">
                    <i class="far fa-folder-open text-5xl text-emerald-300"></i>
                    <p class="text-emerald-800 font-semibold mt-4 text-base">Saat ini tidak ada kampanye twibbon yang aktif.</p>
                </div>
            <?php else: ?>
                <?php foreach ($campaigns as $c): ?>
                    <div class="campaign-card glass rounded-2xl overflow-hidden shadow-lg hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <!-- Frame Preview -->
                            <div class="relative bg-checkerboard aspect-square overflow-hidden flex items-center justify-center border-b">
                                <!-- Silhouette Placeholder -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                                    <i class="fas fa-user text-[100px] text-emerald-900"></i>
                                </div>
                                
                                <?php if (!empty($c['frame']['file_path'])): ?>
                                    <img src="<?= base_url($c['frame']['file_path']) ?>" alt="<?= esc($c['title']) ?>" class="w-full h-full object-contain relative z-10">
                                <?php else: ?>
                                    <i class="far fa-image text-5xl text-emerald-200 relative z-10"></i>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-all duration-200 flex items-center justify-center group z-20">
                                    <a href="<?= base_url('twibbon/' . $c['slug']) ?>" class="bg-white text-emerald-800 text-xs font-bold px-4 py-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 flex items-center gap-1">
                                        <i class="fas fa-magic"></i> Gunakan Bingkai
                                    </a>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-emerald-950 truncate" title="<?= esc($c['title']) ?>"><?= esc($c['title']) ?></h3>
                                <p class="text-emerald-800 text-xs mt-2 line-clamp-3 leading-relaxed opacity-85">
                                    <?= strip_tags($c['description'] ?: 'Dukung kami melalui kampanye twibbon resmi dengan memasang foto profil Anda di bingkai ini.') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Action footer -->
                        <div class="p-6 pt-0">
                            <div class="flex items-center justify-between text-xs text-emerald-700 opacity-75 mb-4 border-t pt-4">
                                <span><i class="far fa-calendar-alt"></i> <?= $c['end_date'] ? 'Selesai: ' . date('d M Y', strtotime($c['end_date'])) : 'Selamanya' ?></span>
                            </div>
                            <div class="flex gap-2">
                                <a href="<?= base_url('twibbon/' . $c['slug']) ?>" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-center py-3 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-md text-sm">
                                    <i class="fas fa-magic"></i> Buat Twibbon
                                </a>
                                <button onclick="shareCampaign('<?= esc($c['title']) ?>', '<?= base_url('twibbon/' . $c['slug']) ?>')" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold p-3.5 rounded-xl transition duration-200 flex items-center justify-center shadow-sm" title="Bagikan Kampanye">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 bg-emerald-800 text-white text-xs font-bold px-4 py-3 rounded-xl shadow-lg transform translate-y-10 opacity-0 pointer-events-none transition-all duration-300 z-50 flex items-center gap-2">
        <i class="fas fa-check-circle text-emerald-400"></i>
        <span id="toast-message">Tautan berhasil disalin!</span>
    </div>

    <!-- Footer -->
    <footer class="w-full glass py-6 border-t mt-12">
        <div class="max-w-6xl mx-auto px-4 text-center text-xs text-emerald-800 opacity-75">
            <p>&copy; <?= date('Y') ?> <?= esc($web['nama_sekolah'] ?? 'PPDB Online') ?>. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Simple search filter
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

        // Sharing functionality
        function shareCampaign(title, url) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Ayo ikut serta dalam kampanye twibbon "' + title + '"!',
                    url: url
                }).catch(err => {
                    console.log('Share failed:', err);
                });
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Tautan berhasil disalin!');
                }).catch(err => {
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
