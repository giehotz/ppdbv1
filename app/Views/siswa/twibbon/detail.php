<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Buat Twibbon - <?= esc($campaign['title']) ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">auto_fix_high</span> Buat Twibbon
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-6 pb-12">
    <!-- Breadcrumb & Back Navigation inside Student Dashboard -->
    <div class="flex items-center justify-between gap-4 pb-2 border-b border-gray-200 dark:border-gray-800">
        <a href="<?= base_url('siswa/twibbon') ?>" 
           class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 transition-colors">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            <span>Kembali ke Daftar Kampanye</span>
        </a>
        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 hidden sm:inline">
            Ukuran Bingkai: <?= (int)($frame['width'] ?? 1080) ?> &times; <?= (int)($frame['height'] ?? 1080) ?> PX
        </span>
    </div>

    <!-- Core Twibbon Editor Workspace (Shared with public twibbon to avoid duplicate code) -->
    <?= view('twibbon/_editor_workspace', ['campaign' => $campaign, 'frame' => $frame, 'web' => $web ?? [], 'isSiswa' => true]) ?>
</div>

<?= $this->endSection() ?>
