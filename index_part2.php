    <!-- Requirements Section -->
    <section class="py-24 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20" id="requirements">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-6"><?= $content['syarat']['title'] ?? 'Persyaratan Dokumen' ?></h2>
                <p class="text-on-surface-variant mb-8 text-lg">Siapkan dokumen digital atau berkas fisik berikut sebelum memulai pengisian formulir pendaftaran online.</p>
                <div class="space-y-4">
                    <?php
                    $defaultSyarat = [
                        'Berusia minimal 6 tahun pada bulan Juli.',
                        'Fotocopy Akta Kelahiran.',
                        'Fotocopy Kartu Keluarga (KK).',
                        'Fotocopy Ijazah TK/RA (jika ada).',
                        'Pas Foto ukuran 3x4.',
                        'Membawa map folder plastik kancing saat verifikasi.'
                    ];
                    
                    for ($i = 1; $i <= 6; $i++):
                        $syaratText = $content['syarat']["item{$i}"] ?? '';
                        if (empty($syaratText) && isset($defaultSyarat[$i - 1])) $syaratText = $defaultSyarat[$i - 1];
                        if (empty($syaratText)) continue;
                    ?>
                    <div class="flex items-start gap-4 p-4 bg-surface-container-low rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <span class="material-symbols-outlined text-primary mt-1" data-icon="check_circle" data-weight="fill" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <div>
                            <p class="font-bold text-on-surface">Syarat <?= $i ?></p>
                            <p class="text-sm text-on-surface-variant leading-relaxed"><?= esc($syaratText) ?></p>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <?php if (isset($content['pendaftar']['is_visible']) && $content['pendaftar']['is_visible'] == '1'): ?>
                <div class="mt-8">
                    <a href="<?= base_url('pendaftar') ?>" class="inline-flex items-center gap-2 bg-surface-container-highest text-primary font-bold px-6 py-3 rounded-md hover:bg-surface-variant transition-colors shadow-sm">
                        <span class="material-symbols-outlined">search</span>
                        Cek Data Pendaftar Publik
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div class="bg-surface-container-highest h-48 rounded-xl overflow-hidden shadow-sm">
                        <img alt="Student Registration" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC10MVSel-cz0bBJVliTvHNWDtEU21QZJaqxUjq5nzp4Eoi1PDEozsBFUlJsyejhfzgZrMST4cZ3TV3UnP9G5rtORQZo2lio97siedRuhzbutNYobZ_kp3oSPRi3igWjKSNoiMwR3_dCO1b484eHXAb1HVqEXiFfNCzmxtgWg4DCnrLB0eu2TFRUYdqxAWtvV90nOe5yOGgdKjEtSRDsn7HimDYttp4-MKJEAG_RJfaldDTCtcF24zPJ4R3R7Kiy_Nh5fQVYPFi4nJd"/>
                    </div>
                    <div class="bg-secondary-fixed h-64 rounded-xl flex items-center justify-center p-8 shadow-sm">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-5xl text-on-secondary-fixed mb-4" data-icon="info">info</span>
                            <p class="font-bold text-on-secondary-fixed">Siapkan berkas asli saat jadwal verifikasi tiba.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 pt-8">
                    <div class="bg-primary h-64 rounded-xl flex items-center justify-center p-8 text-white shadow-sm">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-5xl mb-4" data-icon="folder_special">folder_special</span>
                            <p class="font-bold">Pastikan data yang diinputkan sesuai dengan dokumen resmi.</p>
                        </div>
                    </div>
                    <div class="bg-surface-container-highest h-48 rounded-xl overflow-hidden shadow-sm">
                        <img alt="Document Setup" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrliBk067FrEmLUGzDeKPibJ5qWL3MNUlRBnBbpM_UClk1GLe3-Rrtq8HVPPcE3ONBpAdjSRe_vNnD5dkRRcUZdpWz-9DKxPi4GwnwABZAOSljDcZaQ61QQi5j7Tav8bauEc1mZFM3Nem8qL7ZABr0eDlqAmDsmCWh1PiXKX4QBMXYBSTKQx-gFH3aOZMoylr4L_dnkhfqO5BG2jF6eoLarPob4HwYKQOlO9GEoK3M8u9KkEiPIYfGSwo3q27_-aViGpHKj2A6tL0Q"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery (Masonry style) -->
    <?php if (!empty($galeri)): ?>
    <section class="py-24 bg-surface-container-low scroll-mt-20" id="galeri">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Galeri Aktivitas</h2>
                <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
                <p class="text-on-surface-variant">Dokumentasi kegiatan dan fasilitas di lingkungan madrasah kami.</p>
            </div>
            
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                <?php foreach ($galeri as $index => $g): ?>
                <div onclick="openLightbox('<?= base_url($g['gambar']) ?>', '<?= esc(addslashes($g['judul'])) ?>', '<?= esc(addslashes($g['deskripsi'] ?? '')) ?>')"
                     class="relative group overflow-hidden rounded-xl cursor-pointer shadow-sm hover:shadow-lg transition-shadow">
                    <img src="<?= base_url($g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" class="w-full h-auto group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-primary/85 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-6 text-center">
                        <span class="material-symbols-outlined text-white text-3xl mb-2 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-100">zoom_in</span>
                        <p class="text-white font-bold text-lg leading-tight drop-shadow-md transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-75"><?= esc($g['judul']) ?></p>
                        <?php if (!empty($g['deskripsi'])): ?>
                            <p class="text-white/80 text-sm mt-2 line-clamp-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-150"><?= esc($g['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox" class="fixed inset-0 z-[100] hidden bg-black/90 flex flex-col items-center justify-center p-4 transition-opacity duration-300" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-error rounded-full text-white flex items-center justify-center transition-colors z-[101]">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="max-w-5xl w-full relative flex flex-col items-center" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="Gallery Image" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl">
            <div class="bg-surface-variant/10 backdrop-blur-md px-6 py-4 rounded-2xl mt-4 border border-white/10 text-center max-w-2xl w-full">
                <p id="lightbox-caption" class="text-white text-xl font-bold mb-1 font-headline"></p>
                <p id="lightbox-desc" class="text-surface-dim text-sm line-clamp-3"></p>
            </div>
        </div>
    </div>

    <!-- Testimonials (Marquee) -->
    <?php if (!empty($testimoni)): ?>
    <section class="py-24 overflow-hidden bg-surface scroll-mt-20" id="testimoni">
        <div class="text-center mb-16 px-4">
            <h2 class="text-3xl md:text-4xl font-bold font-headline text-primary mb-4">Suara Mereka</h2>
            <div class="h-1 w-24 bg-secondary mx-auto mb-4"></div>
            <p class="text-on-surface-variant">Apa kata wali santri dan alumni tentang Madrasah kami.</p>
        </div>
        
        <div class="marquee relative">
            <!-- Fade masks for smooth edges -->
            <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-surface to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-surface to-transparent z-10"></div>
            
            <div class="marquee-content py-4">
                <?php 
                // Duplicate for infinite scroll loop effect
                $scrollTestimoni = array_merge($testimoni, $testimoni);
                foreach ($scrollTestimoni as $t): 
                ?>
                <div class="w-80 md:w-96 p-8 bg-surface-container-low rounded-xl border border-outline-variant/20 flex-shrink-0 shadow-sm hover:shadow-md transition-shadow relative">
                    <span class="material-symbols-outlined text-6xl text-primary/5 absolute top-4 right-4" data-icon="format_quote">format_quote</span>
                    <div class="flex items-center gap-4 mb-6 relative z-10">
                        <img src="<?= !empty($t['avatar']) ? base_url($t['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=006948&color=fff' ?>" alt="<?= esc($t['nama']) ?>" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <div>
                            <p class="font-bold text-on-surface"><?= esc($t['nama']) ?></p>
                            <p class="text-xs text-primary font-bold uppercase tracking-wider mt-0.5"><?= esc($t['peran']) ?></p>
                        </div>
                    </div>
                    <div class="mb-4 text-secondary text-sm">
                        <?php for($i=0; $i<$t['rating']; $i++) echo '<i class="fas fa-star mr-1"></i>'; ?>
                        <?php for($i=$t['rating']; $i<5; $i++) echo '<i class="far fa-star text-outline-variant mr-1"></i>'; ?>
                    </div>
                    <p class="italic text-on-surface-variant leading-relaxed text-sm relative z-10">"<?= esc($t['isi']) ?>"</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Contact & Map -->
    <section class="py-24 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20" id="contact">
        <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm grid lg:grid-cols-2 border border-surface-variant">
            <div class="p-8 md:p-12 border-b lg:border-b-0 lg:border-r border-surface-variant">
                <h2 class="text-3xl font-bold text-primary mb-8 font-headline">Hubungi Kami</h2>
                <div class="space-y-8">
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="location_on">location_on</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Alamat Kampus</p>
                            <p class="text-on-surface-variant leading-relaxed"><?= $content['kontak']['alamat'] ?? 'Jl. Raya No. 123, Kab. Tanggamus' ?></p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="mail">mail</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Email</p>
                            <p class="text-on-surface-variant font-medium">info@madrasah.sch.id</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0 group-hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-primary group-hover:text-white transition-colors" data-icon="phone_iphone">phone_iphone</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">WhatsApp Hotline</p>
                            <p class="text-on-surface-variant font-medium"><?= $content['kontak']['whatsapp_nama'] ?? '+62 812-3456-7890 (Panitia)' ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 flex">
                    <?php $waNumber = $content['kontak']['whatsapp_number'] ?? '6281234567890'; ?>
                    <a href="https://wa.me/<?= esc($waNumber) ?>" target="_blank" class="flex items-center justify-center w-full lg:w-auto gap-3 bg-[#25D366] text-white px-8 py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-[#25D366]/30 hover:-translate-y-1 transition-all">
                        <i class="fab fa-whatsapp text-2xl"></i>
                        <span>Chat via WhatsApp</span>
                    </a>
                </div>
            </div>
            
            <div class="h-80 lg:h-auto bg-surface-variant relative">
                <?php if (!empty($content['kontak']['google_maps'])): ?>
                    <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0 saturate-[1.1] contrast-[1.05]">
                        <?= $content['kontak']['google_maps'] ?>
                    </div>
                <?php else: ?>
                    <img class="w-full h-full object-cover grayscale opacity-50" data-alt="map block placeholder" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3MnA1hCd7z6LZiMZygXHMEqdD4iV5PSKRiCzKmj0tZ53hw1XYFxyRmcGjy1NZuT1Mj-kz3WFDxQvJKqtKx78aHQGGZc0el5yOcfl6Q93WGnRDfJ6ZPPUPglNA3RswqneUqlCf02C00ii2aw7ww-N4VsWPTg9BPSlUcxugyTxqTXTOEH7aVLoj6A4-BI7hgV3t2EPXSgMpmEyhBkpIgRQ13TUIaPQyWX0bo3bl8VyFdopCxYCqHB11gs5dHAwubD_2Md28UQLhlvXp"/>
                    <div class="absolute inset-0 flex items-center justify-center text-on-surface-variant bg-surface/50 backdrop-blur-sm">
                        <p class="font-bold flex items-center gap-2"><span class="material-symbols-outlined">map</span> Peta belum dikonfigurasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-emerald-900 text-white w-full border-t-[4px] border-secondary-fixed">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 px-8 py-16 w-full max-w-7xl mx-auto">
            
            <!-- Branding -->
            <div class="md:col-span-5">
                <div class="flex items-center gap-4 mb-6">
                    <?php if (!empty($web['logo_sekolah'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" alt="Logo" class="w-12 h-12 object-contain bg-white rounded-lg p-1">
                    <?php endif; ?>
                    <span class="text-xl font-extrabold text-white block tracking-tight"><?= $content['footer']['nama_sekolah'] ?? ($content['navbar']['nama_sekolah'] ?? 'Madrasah Al-Maqam') ?></span>
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-emerald-100/70 mb-8 max-w-sm">
                    Mencetak generasi rabbani yang unggul dalam ilmu pengetahuan dan berakhlak mulia melalui kurikulum integratif dan lingkungan islami yang asri.
                </p>
                <div class="flex gap-4">
                    <?php if (!empty($content['footer']['facebook_link'])): ?>
                        <a href="<?= esc($content['footer']['facebook_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['instagram_link'])): ?>
                        <a href="<?= esc($content['footer']['instagram_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['tiktok_link'])): ?>
                        <a href="<?= esc($content['footer']['tiktok_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-black transition-colors">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($content['footer']['youtube_link'])): ?>
                        <a href="<?= esc($content['footer']['youtube_link']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-red-600 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="md:col-span-3">
                <h4 class="font-bold text-secondary-fixed mb-6 uppercase tracking-wider text-xs">Pintasan Informasi</h4>
                <ul class="space-y-4 font-body text-sm">
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#home">Beranda PPDB</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#schedule">Jadwal Seleksi</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="#requirements">Panduan Syarat</a></li>
                    <li><a class="text-emerald-100/70 hover:text-white hover:translate-x-1 transition-transform inline-block" href="<?= base_url('auth/register') ?>">Formulir Pendaftaran</a></li>
                </ul>
            </div>
            
            <!-- Subscribe / Contact Info -->
            <div class="md:col-span-4">
                <h4 class="font-bold text-secondary-fixed mb-6 uppercase tracking-wider text-xs">Bantuan Segera</h4>
                <p class="text-emerald-100/70 text-sm mb-6 leading-relaxed">Punya pertanyaan mendesak terkait kendala sistem pendaftaran? Tim IT kami siap membantu.</p>
                <div class="inline-flex rounded-xl overflow-hidden shadow-lg w-full">
                    <div class="bg-emerald-800 text-sm px-4 py-3 w-full flex items-center gap-3 text-emerald-100">
                        <i class="fas fa-envelope text-lg opacity-50"></i>
                        <span>ppdb@madrasah.sch.id</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="border-t border-emerald-800/50 py-6 text-center text-sm font-medium text-emerald-100/50">
            <?= esc($web['nama_sekolah'] ?? '') ?> &copy; <?= date('Y') ?> <?= $content['footer']['copyright'] ?? 'Official Website PPDB. All rights reserved.' ?>
        </div>
    </footer>

    <!-- Announcement Popup Logic -->
    <?php if (!empty($popups)) : ?>
    <div id="announcement-popup" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-surface rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all duration-300 scale-100">
            <div class="relative p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-surface-variant">
                    <span class="material-symbols-outlined text-primary text-3xl shrink-0" data-icon="campaign">campaign</span>
                    <h3 id="popup-title" class="text-xl font-bold font-headline text-on-surface line-clamp-2">Pengumuman Penting</h3>
                </div>
                
                <div id="popup-content" class="max-h-[60vh] overflow-y-auto custom-scrollbar text-on-surface-variant space-y-4">
                    <!-- Content will be injected by JS -->
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button id="close-popup-btn" class="signature-gradient text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-sm hover:shadow-md flex items-center gap-2 group">
                        <span>Tutup Dialog</span>
                        <span id="popup-countdown-text"></span>
                        <i class="fas fa-times group-hover:rotate-90 transition-transform duration-300 opacity-70 group-hover:opacity-100"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const popups = <?= json_encode($popups) ?>;
        let currentPopupIndex = 0;

        function showPopup(index) {
            if (index >= popups.length) return;

            const popup = popups[index];
            const modal = document.getElementById('announcement-popup');
            const contentContainer = document.getElementById('popup-content');
            const titleContainer = document.getElementById('popup-title');
            const closeBtn = document.getElementById('close-popup-btn');
            const countdownSpan = document.getElementById('popup-countdown-text');
            
            titleContainer.innerText = popup.judul;
            
            let html = '';
            if (popup.lampiran && (popup.lampiran.match(/\.(jpg|jpeg|png|gif)$/i))) {
                html += `<img src="<?= base_url('uploads/pengumuman/') ?>${popup.lampiran}" class="w-full rounded-lg mb-4 shadow-sm border border-surface-variant">`;
            }
            html += `<div class="prose prose-sm prose-emerald max-w-none">${popup.isi_pengumuman}</div>`;
            
            contentContainer.innerHTML = html;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            let countdown = parseInt(popup.popup_countdown) || 0;
            
            if (countdown > 0) {
                closeBtn.disabled = true;
                closeBtn.classList.add('opacity-50', 'cursor-not-allowed', 'grayscale');
                countdownSpan.innerText = ` (${countdown})`;
                
                const timer = setInterval(() => {
                    countdown--;
                    if (countdown <= 0) {
                        clearInterval(timer);
                        closeBtn.disabled = false;
                        closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'grayscale');
                        countdownSpan.innerText = '';
                    } else {
                        countdownSpan.innerText = ` (${countdown})`;
                    }
                }, 1000);
            } else {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'grayscale');
                countdownSpan.innerText = '';
            }

            closeBtn.onclick = function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
                
                if (currentPopupIndex + 1 < popups.length) {
                    currentPopupIndex++;
                    setTimeout(() => showPopup(currentPopupIndex), 300);
                }
            };
        }

        window.addEventListener('load', () => { setTimeout(() => showPopup(0), 1000); });
    </script>
    <?php endif; ?>

    <!-- Scripts Interactions -->
    <script>
        // Navbar scroll effect
        const navbar = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md');
                navbar.classList.remove('shadow-sm', 'border-b');
            } else {
                navbar.classList.add('shadow-sm', 'border-b');
                navbar.classList.remove('shadow-md');
            }
        });

        // Mobile Menu Toggle
        const btn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        btn.addEventListener('click', () => {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                menuIcon.innerText = 'close';
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.innerText = 'menu';
            }
        });

        // Smooth scroll & close menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    const offset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        menuIcon.innerText = 'menu';
                    }
                }
            });
        });

        // Lightbox Functions
        function openLightbox(imageUrl, title, desc = '') {
            const lightbox = document.getElementById('lightbox');
            document.getElementById('lightbox-img').src = imageUrl;
            document.getElementById('lightbox-caption').innerText = title;
            document.getElementById('lightbox-desc').innerText = desc;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeLightbox();
        });

        // Active nav link highlighting
        const sections = document.querySelectorAll('section[id], header[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 150;
                const sectionBottom = sectionTop + section.offsetHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('text-emerald-700', 'border-b-2', 'border-amber-400', 'pb-1');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('text-emerald-700', 'border-b-2', 'border-amber-400', 'pb-1');
                }
            });
        });
    </script>
</body>
</html>
