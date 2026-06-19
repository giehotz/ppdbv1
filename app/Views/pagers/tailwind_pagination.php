<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex justify-center mt-4 mb-2">
    <ul class="inline-flex items-center -space-x-px">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="First" class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 transition font-medium">
                    <span aria-hidden="true">&laquo; Awal</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="Previous" class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 transition font-medium">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="<?= $link['active'] ? 'z-10 block px-4 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 font-bold' : 'block px-4 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 transition font-medium' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="Next" class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 transition font-medium">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="Last" class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 transition font-medium">
                    <span aria-hidden="true">Akhir &raquo;</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
