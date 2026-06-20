<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Twibbon<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pb-4">

    <!-- Hero Glass -->
    <div class="bg-gradient-to-br from-emerald-600 to-green-700 rounded-2xl p-5 shadow-lg mb-5 relative overflow-hidden">
        <div class="absolute -top-6 -right-6 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-2">
                <span class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-image text-white text-base"></i>
                </span>
                <div>
                    <h2 class="text-white font-bold text-base">Kampanye Twibbon</h2>
                    <p class="text-emerald-100 text-[10px]">Buat twibbon keren sekarang!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Glass -->
    <div class="relative mb-5">
        <input type="text" id="search-campaign" placeholder="Cari kampanye..." class="w-full bg-white/80 backdrop-blur-md border-0 rounded-xl pl-10 pr-4 py-3 shadow-sm text-xs focus:ring-2 focus:ring-emerald-500/50 outline-none">
        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
    </div>

    <!-- Campaign List -->
    <?php if (empty($campaigns)): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 p-8 flex flex-col items-center justify-center text-center mt-4">
            <div class="w-14 h-14 bg-slate-100/80 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-image text-slate-300 text-2xl"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Kampanye</h3>
            <p class="text-[10px] text-slate-500">Tidak ada kampanye twibbon yang aktif saat ini.</p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($campaigns as $c): ?>
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 overflow-hidden campaign-item active:scale-[0.98] transition-transform">
                    <div class="flex p-4 gap-4">
                        <!-- Thumbnail -->
                        <div class="w-20 h-20 rounded-xl bg-slate-50/60 flex items-center justify-center overflow-hidden shrink-0 border border-slate-200/30">
                            <?php if (!empty($c['frame']['file_path'])): ?>
                                <img src="<?= base_url($c['frame']['file_path']) ?>" alt="<?= esc($c['title']) ?>" class="w-full h-full object-contain p-2">
                            <?php else: ?>
                                <i class="far fa-image text-2xl text-slate-300"></i>
                            <?php endif; ?>
                        </div>
                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-slate-900 text-sm truncate"><?= esc($c['title']) ?></h3>
                            <p class="text-[10px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                <?= strip_tags($c['description'] ?: 'Ikut serta dalam kampanye twibbon ini.') ?>
                            </p>
                            <p class="text-[10px] text-slate-400 mt-2">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?= $c['end_date'] ? 'Selesai: ' . date('d M Y', strtotime($c['end_date'])) : 'Berlaku selamanya' ?>
                            </p>
                        </div>
                    </div>
                    <a href="<?= base_url('siswa/twibbon/' . $c['slug']) ?>" class="flex items-center justify-center gap-2 w-full py-3 bg-emerald-600 text-white text-xs font-semibold active:bg-emerald-700 active:scale-[0.99] transition-all">
                        <i class="fas fa-magic text-[10px]"></i> Buat Twibbon
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('search-campaign')?.addEventListener('input', function(e) {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('.campaign-item').forEach(el => {
        const title = el.querySelector('h3').textContent.toLowerCase();
        el.style.display = title.includes(q) ? 'block' : 'none';
    });
});
</script>
<?= $this->endSection() ?>
