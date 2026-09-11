<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Siswa Pindahan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<div class="flex items-center gap-3 flex-wrap">
    <span class="material-symbols-outlined text-brand-500">swap_horiz</span>
    <span>Siswa Pindahan</span>
    <?php if (!empty($activeTh)): ?>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-sm ring-2 ring-emerald-500/20 dark:bg-emerald-500 dark:text-gray-950">
            <i class="fas fa-calendar-check text-xs"></i>
            <span>TP: <?= esc($activeTh) ?> ★ (Aktif)</span>
        </span>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <?= $this->include('pindahan/admin/_header') ?>
    <?= $this->include('pindahan/admin/_filter_tabs') ?>
    <?= $this->include('pindahan/admin/_table') ?>
</div>

<?= $this->include('pindahan/admin/_bulk_actions') ?>
<?= $this->include('pindahan/admin/_modals') ?>
<?= $this->include('pindahan/admin/_scripts') ?>

<?= $this->endSection() ?>