<style>
    .neo-box {
        border: 3px solid #000000;
        box-shadow: 5px 5px 0px 0px #000000;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .neo-box-lg {
        border: 4px solid #000000;
        box-shadow: 8px 8px 0px 0px #000000;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .neo-btn {
        border: 3px solid #000000;
        box-shadow: 4px 4px 0px 0px #000000;
        font-weight: 800;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .neo-btn:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px 0px #000000;
    }
    .neo-btn:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px #000000;
    }
    .bg-checkerboard {
        background-color: #ffffff;
        background-image: 
            linear-gradient(45deg, #f0f0f0 25%, transparent 25%), 
            linear-gradient(-45deg, #f0f0f0 25%, transparent 25%), 
            linear-gradient(45deg, transparent 75%, #f0f0f0 75%), 
            linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
        background-size: 20px 20px;
        background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
    }
</style>

<div class="space-y-8">
    <!-- SEARCH & FILTER BAR -->
    <div class="max-w-lg mx-auto relative">
        <div class="relative flex items-center bg-white border-3 border-black rounded-2xl shadow-[4px_4px_0px_0px_#000] focus-within:shadow-[6px_6px_0px_0px_#000] transition-all overflow-hidden">
            <span class="pl-4 pr-2 text-black text-base">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="search-campaign" placeholder="Ketik nama kampanye twibbon..."
                class="h-12 w-full bg-transparent px-2 text-sm font-bold text-black placeholder:text-gray-400 focus:outline-none focus:ring-0">
            <span class="pr-3 text-[10px] font-black uppercase text-gray-500 bg-[#FFFDF5] border border-black rounded-md px-2 py-1 mr-2 hidden sm:inline-block">
                Filter
            </span>
        </div>
    </div>

    <!-- CAMPAIGN CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="campaign-grid">
        <?php if (empty($campaigns)): ?>
            <!-- Empty State -->
            <div class="col-span-full neo-box-lg bg-white rounded-3xl p-10 sm:p-14 text-center max-w-xl mx-auto space-y-4">
                <div class="w-20 h-20 bg-[#FFE600] rounded-2xl border-3 border-black shadow-[4px_4px_0px_0px_#000] flex items-center justify-center text-3xl text-black mx-auto rotate-3">
                    <i class="fas fa-paint-roller"></i>
                </div>
                <div class="space-y-1">
                    <span class="bg-[#FF6B8B] text-white font-black text-xs uppercase px-3 py-1 rounded-md border-2 border-black shadow-[2px_2px_0px_0px_#000] inline-block -rotate-1">
                        Belum Ada Bingkai Aktif
                    </span>
                    <h3 class="font-black text-xl text-black mt-2">Segera Hadir Kampanye Menarik!</h3>
                    <p class="text-xs font-semibold text-gray-600 max-w-sm mx-auto">
                        Panitia sedang mempersiapkan bingkai twibbon resmi PPDB. Silakan kembali beberapa saat lagi.
                    </p>
                </div>
            </div>
        <?php else: ?>
            <?php 
            $colors = ['#FFE600', '#00D2FF', '#A3E635', '#FF6B8B', '#C084FC', '#FF9F1C'];
            $i = 0;
            $isSiswaMode = isset($isSiswa) ? (bool)$isSiswa : (strpos(current_url(), 'siswa') !== false);
            foreach ($campaigns as $c): 
                $accentColor = $colors[$i % count($colors)];
                $i++;
                $campaignDetailUrl = base_url(($isSiswaMode ? 'siswa/twibbon/' : 'twibbon/') . $c['slug']);
                $publicShareUrl    = base_url('twibbon/' . $c['slug']);
            ?>
                <div class="campaign-card neo-box bg-white rounded-3xl flex flex-col justify-between overflow-hidden group hover:-translate-y-2 hover:shadow-[10px_10px_0px_0px_#000] transition-all duration-200">
                    <div>
                        <!-- Header Top Badge Stripe -->
                        <div class="px-5 py-2.5 border-b-[3px] border-black flex items-center justify-between" style="background-color: <?= $accentColor ?>;">
                            <span class="bg-black text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded border border-black shadow-[1px_1px_0px_0px_#FFF]">
                                ★ TWIBBON RESMI
                            </span>
                            <span class="text-black font-black text-xs">
                                <i class="far fa-heart group-hover:scale-125 transition-transform inline-block"></i>
                            </span>
                        </div>

                        <!-- Frame Preview Area (Transparent Checkerboard) -->
                        <div class="relative bg-checkerboard aspect-square border-b-[3px] border-black p-6 flex items-center justify-center overflow-hidden">
                            <?php if (!empty($c['frame']['file_path'])): ?>
                                <img src="<?= base_url($c['frame']['file_path']) ?>" 
                                     alt="<?= esc($c['title']) ?>" 
                                     class="w-full h-full object-contain relative z-10 drop-shadow-[0_4px_8px_rgba(0,0,0,0.15)] group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-5xl mb-2"></i>
                                    <span class="text-xs font-bold">Bingkai Default</span>
                                </div>
                            <?php endif; ?>

                            <!-- Sticker on Preview -->
                            <div class="absolute bottom-3 left-3 z-20">
                                <span class="bg-white text-black font-black text-[10px] px-2 py-0.5 rounded border-2 border-black shadow-[2px_2px_0px_0px_#000]">
                                    <?= (int)($c['frame']['width'] ?? 1080) ?> &times; <?= (int)($c['frame']['height'] ?? 1080) ?> PX
                                </span>
                            </div>
                        </div>

                        <!-- Content Details -->
                        <div class="p-5 sm:p-6 space-y-2.5">
                            <h3 class="font-black text-xl text-black truncate group-hover:text-[#FF6B8B] transition-colors" title="<?= esc($c['title']) ?>">
                                <?= esc($c['title']) ?>
                            </h3>
                            <p class="text-xs font-semibold text-gray-700 line-clamp-2 leading-relaxed">
                                <?= strip_tags($c['description'] ?: 'Ikuti kampanye twibbon resmi dengan memasang foto profil terbaik Anda untuk mendukung PPDB.') ?>
                            </p>
                        </div>
                    </div>

                    <!-- Card Action Footer -->
                    <div class="p-5 sm:p-6 pt-0 space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-gray-800 pt-3 border-t-2 border-dashed border-black">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="far fa-calendar-alt text-black"></i>
                                <span><?= $c['end_date'] ? 'Hingga ' . date('d M Y', strtotime($c['end_date'])) : 'Berlaku Selamanya' ?></span>
                            </span>
                            <span class="bg-[#A3E635] text-black font-black text-[10px] px-2 py-0.5 rounded border border-black">
                                Aktif
                            </span>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <a href="<?= $campaignDetailUrl ?>"
                               class="flex-1 neo-btn bg-[#FFE600] hover:bg-[#FFE600] text-black py-3 px-4 rounded-xl text-xs font-black shadow-[3px_3px_0px_0px_#000]">
                                <i class="fas fa-camera mr-1.5"></i>
                                <span>Buat Twibbon</span>
                            </a>

                            <button type="button" 
                                onclick="shareCampaign('<?= esc($c['title'], 'js') ?>', '<?= $publicShareUrl ?>')"
                                class="neo-btn bg-white hover:bg-[#00D2FF] text-black h-11 w-11 rounded-xl shadow-[3px_3px_0px_0px_#000]"
                                title="Bagikan Tautan">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast" class="fixed bottom-6 right-6 bg-[#000000] text-[#FFE600] border-3 border-[#FFE600] shadow-[5px_5px_0px_0px_#000] font-black text-xs px-5 py-3.5 rounded-2xl transform translate-y-12 opacity-0 pointer-events-none transition-all duration-300 z-50 flex items-center gap-3">
    <i class="fas fa-check-circle text-base text-[#A3E635]"></i>
    <span id="toast-message">Tautan berhasil disalin ke papan klip!</span>
</div>

<script>
    // Realtime search campaign cards
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-campaign');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const keyword = e.target.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.campaign-card');

                cards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const desc = card.querySelector('p').textContent.toLowerCase();
                    if (title.includes(keyword) || desc.includes(keyword)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    });

    // Native / Clipboard share
    function shareCampaign(title, url) {
        if (navigator.share) {
            navigator.share({
                title: 'Twibbon ' + title,
                text: 'Ayo buat foto Twibbon resmi: ' + title,
                url: url
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(url).then(() => {
                showToast('Tautan twibbon berhasil disalin!');
            }).catch(() => {
                showToast('Gagal menyalin tautan.');
            });
        }
    }

    function showToast(msg) {
        const toast = document.getElementById('toast');
        const toastMsg = document.getElementById('toast-message');
        if (!toast) return;
        toastMsg.innerText = msg;
        toast.classList.remove('translate-y-12', 'opacity-0', 'pointer-events-none');
        setTimeout(() => {
            toast.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none');
        }, 3000);
    }
</script>
