<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Twibbon<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    <!-- Header Banner -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0">
                <span class="material-symbols-outlined text-xl">photo_filter</span>
            </div>
            <div>
                <h3 class="text-xs font-bold text-gray-900 dark:text-white">Kampanye Twibbon</h3>
                <p class="text-[10px] text-gray-400">Pilih bingkai dan pasang foto terbaikmu.</p>
            </div>
        </div>

        <!-- Search Input -->
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <span class="material-symbols-outlined text-base">search</span>
            </span>
            <input type="text" id="search-campaign" placeholder="Cari kampanye twibbon..."
                class="h-9 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-3 pl-8.5 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        </div>
    </div>

    <!-- Campaigns List -->
    <?php if (empty($campaigns)): ?>
        <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-2">
                <span class="material-symbols-outlined text-2xl">sentiment_dissatisfied</span>
            </div>
            <h4 class="text-xs font-bold text-gray-800 dark:text-white">Belum Ada Kampanye</h4>
            <p class="text-[10px] text-gray-400 mt-0.5">Tidak ada bingkai twibbon yang aktif saat ini.</p>
        </div>
    <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($campaigns as $c): ?>
                <div class="campaign-item rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden dark:border-gray-800 dark:bg-white/[0.03] space-y-3 p-4">
                    <div class="flex gap-3">
                        <div class="h-18 w-18 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-1.5 shrink-0 flex items-center justify-center overflow-hidden">
                            <?php if (!empty($c['frame']['file_path'])): ?>
                                <img src="<?= base_url($c['frame']['file_path']) ?>" alt="Frame" class="h-full w-full object-contain">
                            <?php else: ?>
                                <span class="material-symbols-outlined text-2xl text-gray-300">image</span>
                            <?php endif; ?>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate"><?= esc($c['title']) ?></h4>
                            <p class="text-[10px] text-gray-400 line-clamp-2 mt-0.5 leading-relaxed">
                                <?= strip_tags($c['description'] ?: 'Ikut serta dalam kampanye twibbon ini.') ?>
                            </p>
                            <span class="text-[9px] text-gray-400 block mt-1">
                                <?= $c['end_date'] ? 'Sampai: ' . date('d M Y', strtotime($c['end_date'])) : 'Berlaku selamanya' ?>
                            </span>
                        </div>
                    </div>

                    <a href="<?= base_url('siswa/twibbon/' . $c['slug']) ?>"
                       class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white py-2 text-xs font-bold shadow-theme-xs transition-colors">
                        <span class="material-symbols-outlined text-sm">auto_fix_high</span>
                        <span>Buat Twibbon</span>
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
        const title = el.querySelector('h4').textContent.toLowerCase();
        el.style.display = title.includes(q) ? 'block' : 'none';
    });
});
</script>

<?= $this->endSection() ?>
