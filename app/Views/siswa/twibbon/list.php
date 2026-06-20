<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Twibbon<?= $this->endSection() ?>

<?= $this->section('page_title') ?>Kampanye Twibbon<?= $this->endSection() ?>

<?= $this->section('head') ?>
<style>
    .campaign-card {
        transition: all 0.3s ease;
    }
    .campaign-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.1);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="max-w-6xl mx-auto pb-12 px-4">

    <!-- Hero -->
    <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-green-700 text-white p-8 rounded-2xl shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold mb-2 flex items-center">
                <span class="bg-white/20 p-2 rounded-lg mr-3">
                    <i class="fas fa-image"></i>
                </span>
                Kampanye Twibbon
            </h2>
            <p class="text-emerald-50 opacity-90 font-medium">Pilih kampanye, upload foto, dan buat twibbon kerenmu sekarang!</p>
        </div>
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-1/4 w-32 h-32 bg-emerald-400/10 rounded-full blur-xl"></div>
    </div>

    <!-- Search -->
    <div class="mb-8 max-w-md">
        <div class="relative">
            <input type="text" id="search-campaign" placeholder="Cari kampanye..." class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none shadow-sm">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="campaign-grid">
        <?php if (empty($campaigns)): ?>
            <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-gray-100">
                <i class="far fa-folder-open text-5xl text-gray-300"></i>
                <p class="text-gray-500 font-semibold mt-4">Belum ada kampanye twibbon yang aktif.</p>
            </div>
        <?php else: ?>
            <?php foreach ($campaigns as $c): ?>
                <div class="campaign-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col campaign-item">
                    <div class="relative aspect-square bg-gray-50 overflow-hidden">
                        <?php if (!empty($c['frame']['file_path'])): ?>
                            <img src="<?= base_url($c['frame']['file_path']) ?>" alt="<?= esc($c['title']) ?>" class="w-full h-full object-contain p-4">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="far fa-image text-6xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-base truncate"><?= esc($c['title']) ?></h3>
                        <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed flex-1">
                            <?= strip_tags($c['description'] ?: 'Ikut serta dalam kampanye twibbon ini.') ?>
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-400 mt-4 pt-4 border-t">
                            <span><i class="far fa-calendar-alt mr-1"></i> <?= $c['end_date'] ? 'Selesai: ' . date('d M Y', strtotime($c['end_date'])) : 'Selamanya' ?></span>
                        </div>
                        <a href="<?= base_url('siswa/twibbon/' . $c['slug']) ?>" class="mt-3 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-center py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-magic"></i> Buat Twibbon
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
                const title = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = title.includes(q) ? 'flex' : 'none';
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
