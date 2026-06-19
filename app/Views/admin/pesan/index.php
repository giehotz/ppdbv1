<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pesan Pribadi Terkirim
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pesan Pribadi Terkirim
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

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h3 class="text-lg font-medium text-gray-900">Daftar Pesan Terkirim</h3>
            
            <a href="<?= base_url('admin/pesan/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                <i class="fas fa-paper-plane mr-2"></i> Buat Pesan Baru
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6">Kepada</th>
                    <th class="py-3 px-6">Subjek</th>
                    <th class="py-3 px-6">Waktu Kirim</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (!empty($pesan)) : ?>
                    <?php foreach ($pesan as $p) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 font-medium">
                                <?= esc($p['nama_penerima']) ?>
                            </td>
                            <td class="py-3 px-6">
                                <div class="font-semibold text-gray-800"><?= esc($p['subjek']) ?></div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    <?= substr(strip_tags($p['isi_pesan']), 0, 50) ?>...
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                <?= date('d/m/Y H:i', strtotime($p['created_at'])) ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <?php if ($p['status'] == 'read') : ?>
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs">
                                        <i class="fas fa-check-double"></i> Dibaca
                                    </span>
                                <?php else : ?>
                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs">
                                        <i class="fas fa-check"></i> Terkirim
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center gap-2">
                                    <a href="<?= base_url('admin/pesan/detail/' . $p['id_pesan']) ?>"
                                        class="text-blue-500 hover:text-blue-700 transform hover:scale-110"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="post" action="<?= base_url('admin/pesan/delete/' . $p['id_pesan']) ?>"
                                        data-confirm="Yakin ingin menghapus pesan ini?"
                                        style="display:inline">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 transform hover:scale-110"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                            Belum ada pesan yang dikirim.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
