<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex justify-center items-center my-4">
    <ul class="inline-flex items-center gap-1">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="Awal"
                   class="h-9 px-3 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors">
                    <span>Awal</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="Sebelumnya"
                   class="h-9 w-9 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors">
                    <span class="material-symbols-outlined text-base">chevron_left</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>"
                   class="h-9 min-w-9 px-2 inline-flex items-center justify-center rounded-xl text-xs font-bold transition-all shadow-theme-xs <?= $link['active'] ? 'bg-brand-500 text-white border border-brand-500' : 'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="Berikutnya"
                   class="h-9 w-9 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors">
                    <span class="material-symbols-outlined text-base">chevron_right</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="Akhir"
                   class="h-9 px-3 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs transition-colors">
                    <span>Akhir</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
