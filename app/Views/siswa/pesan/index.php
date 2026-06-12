<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Kotak Masuk
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Kotak Masuk
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow overflow-hidden max-w-5xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">
            <i class="fas fa-inbox text-blue-600 mr-2"></i> Pesan Masuk
        </h3>
    </div>

    <div class="overflow-hidden">
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($pesan)) : ?>
                <?php foreach ($pesan as $p) : ?>
                    <li class="hover:bg-blue-50 transition duration-150 <?= $p['status'] == 'unread' ? 'bg-white' : 'bg-gray-50' ?>">
                        <a href="<?= base_url('siswa/pesan/detail/' . $p['id_pesan']) ?>" class="block px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="<?= $p['status'] == 'unread' ? 'bg-blue-600' : 'bg-gray-400' ?> rounded-full w-12 h-12 flex items-center justify-center text-white font-bold text-lg">
                                            <?= substr($p['nama_pengirim'], 0, 1) ?>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0 pr-4">
                                        <div class="flex items-baseline justify-between mb-1">
                                            <p class="text-sm font-bold <?= $p['status'] == 'unread' ? 'text-gray-900' : 'text-gray-600' ?> truncate">
                                                <?= esc($p['nama_pengirim']) ?> 
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $p['pengirim_type'] == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' ?>">
                                                    <?= ucfirst($p['pengirim_type']) ?>
                                                </span>
                                            </p>
                                            <p class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                                <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                                            </p>
                                        </div>
                                        <p class="text-sm <?= $p['status'] == 'unread' ? 'font-semibold text-gray-800' : 'text-gray-600' ?> truncate mb-1">
                                            <?= esc($p['subjek']) ?>
                                        </p>
                                        <p class="text-sm text-gray-500 truncate">
                                            <?= substr(strip_tags($p['isi_pesan']), 0, 80) ?>...
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-4 hidden sm:block">
                                    <?php if ($p['status'] == 'unread') : ?>
                                        <span class="inline-block w-3 h-3 bg-blue-600 rounded-full"></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="px-6 py-12 text-center text-gray-500">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400 text-3xl">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-900 mb-1">Kotak Masuk Kosong</p>
                    <p class="text-sm text-gray-500">Belum ada pesan masuk dari panitia.</p>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>
