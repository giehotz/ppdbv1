<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Twibbon Kampanye<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">image</span> Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <!-- Header Banner -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 border border-brand-200/60 dark:border-brand-500/20">
                    <span class="material-symbols-outlined text-2xl">photo_filter</span>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Kampanye Twibbon PPDB</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Pilih bingkai twibbon resmi, pasang foto terbaikmu, dan bagikan ke media sosial!</p>
                </div>
            </div>

            <!-- Search input -->
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <span class="material-symbols-outlined text-base">search</span>
                </span>
                <input type="text" id="search-campaign" placeholder="Cari kampanye..."
                    class="h-9.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
        </div>
    </div>

    <!-- Campaigns Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="campaign-grid">
        <?php if (empty($campaigns)): ?>
            <div class="col-span-full rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mx-auto mb-3">
                    <span class="material-symbols-outlined text-3xl">sentiment_dissatisfied</span>
                </div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Belum Ada Kampanye Twibbon</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Saat ini belum ada bingkai twibbon yang aktif.</p>
            </div>
        <?php else: ?>
            <?php foreach ($campaigns as $c): ?>
                <div class="campaign-item rounded-2xl border border-gray-200 bg-white shadow-theme-xs overflow-hidden transition-all duration-200 hover:shadow-theme-md hover:-translate-y-0.5 hover:border-brand-500/40 dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
                    
                    <div class="relative aspect-square bg-gray-50 dark:bg-gray-900 p-4 flex items-center justify-center overflow-hidden border-b border-gray-100 dark:border-gray-800">
                        <?php if (!empty($c['frame']['file_path'])): ?>
                            <img src="<?= base_url($c['frame']['file_path']) ?>" alt="<?= esc($c['title']) ?>" class="w-full h-full object-contain">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-700">image</span>
                        <?php endif; ?>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                            <?= esc($c['title']) ?>
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mt-1.5 leading-relaxed flex-1">
                            <?= strip_tags($c['description'] ?: 'Ikuti kampanye twibbon resmi ini.') ?>
                        </p>

                        <div class="flex items-center justify-between text-[11px] text-gray-400 dark:text-gray-500 pt-3 border-t border-gray-100 dark:border-gray-800 mt-4">
                            <span class="inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">event</span>
                                <?= $c['end_date'] ? 'Sampai: ' . date('d M Y', strtotime($c['end_date'])) : 'Selamanya' ?>
                            </span>
                        </div>

                        <a href="<?= base_url('siswa/twibbon/' . $c['slug']) ?>"
                           class="mt-3.5 inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                            <span class="material-symbols-outlined text-base">auto_fix_high</span>
                            <span>Pasang Twibbon</span>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('search-campaign');
    const cards = document.querySelectorAll('.campaign-item');
    if (input) {
        input.addEventListener('input', function(e) {
            const q = e.target.value.toLowerCase();
            cards.forEach(card => {
                const title = card.querySelector('h4').textContent.toLowerCase();
                card.style.display = title.includes(q) ? 'flex' : 'none';
            });
        });
    }
});
</script>

<?= $this->endSection() ?>
