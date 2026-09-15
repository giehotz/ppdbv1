<?php
// Version Control
$app_version = "v1.1.0";
$sessionUserType = strtolower(session()->get('user_type') ?? session()->get('level') ?? session()->get('role') ?? '');
$isStaff = in_array($sessionUserType, ['admin', 'verifikator']);
?>
<!-- TailAdmin Footer Area -->
<footer class="border-t border-gray-200 bg-white/80 backdrop-blur-md px-4 py-3.5 sm:px-6 dark:border-gray-800 dark:bg-gray-900/80 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 dark:text-gray-400 mt-auto relative z-10 gap-2">
    <div class="text-center sm:text-left font-medium">
        &copy; <?= date('Y') ?> <span class="font-bold text-gray-700 dark:text-gray-200"><?= esc($app_alias ?? 'PPDB') ?></span> - <?= esc($sekolahName ?? 'Sistem Informasi Sekolah') ?>. Hak cipta dilindungi.
    </div>
    
    <?php if ($isStaff): ?>
    <!-- Version Button -->
    <button type="button" onclick="openChangelogModal()" 
        class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-50/80 px-3 py-1 text-[11px] font-semibold text-gray-600 shadow-theme-xs transition-colors hover:border-brand-500 hover:text-brand-600 dark:border-gray-800 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:border-brand-500 dark:hover:text-brand-400 cursor-pointer">
        <i class="fas fa-code-branch text-brand-500"></i> Versi <?= $app_version ?>
    </button>
    <?php endif; ?>
</footer>

<?php if ($isStaff): ?>
    <!-- Modal Riwayat Pembaruan (Changelog) -->
    <?= $this->include('layouts/components/modal_changelog', ['app_version' => $app_version]) ?>
<?php endif; ?>

