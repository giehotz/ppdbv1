<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Twibbon Kampanye<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">image</span> Kampanye Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6 pb-12">
    <!-- Header Banner inside Student Dashboard -->
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
        </div>
    </div>

    <!-- Core Campaign Cards Grid (Shared with public twibbon to avoid duplicate code) -->
    <?= view('twibbon/_campaign_grid', ['campaigns' => $campaigns, 'web' => $web ?? [], 'isSiswa' => true]) ?>
</div>

<?= $this->endSection() ?>
