<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Pesan Terkirim
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detail Pesan Terkirim
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">
            <i class="fas fa-envelope-open mr-2 text-blue-500"></i>
            <?= esc($pesan['subjek']) ?>
        </h3>
        
        <a href="<?= base_url('admin/pesan') ?>" class="text-gray-500 hover:text-gray-700 p-1 border rounded-md">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <div class="p-6">
        <div class="flex justify-between items-start mb-6 pb-4 border-b">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-4">
                    <?= substr($pesan['nama_penerima'], 0, 1) ?>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">Kepada: <?= esc($pesan['nama_penerima']) ?></h4>
                    <p class="text-sm text-gray-500">
                        Status: 
                        <?php if ($pesan['status'] == 'read') : ?>
                            <span class="text-green-600 font-medium"><i class="fas fa-check-double text-xs"></i> Telah Dibaca</span>
                        <?php else : ?>
                            <span class="text-gray-500"><i class="fas fa-check text-xs"></i> Belum Dibaca</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="text-right text-sm text-gray-500">
                <i class="far fa-clock mr-1"></i> <?= date('d M Y, H:i', strtotime($pesan['created_at'])) ?>
            </div>
        </div>

        <div class="prose max-w-none text-gray-800 bg-gray-50 p-6 rounded-lg border border-gray-100 min-h-[200px] whitespace-pre-wrap">
<?= esc($pesan['isi_pesan']) ?>
        </div>
        
        <div class="mt-8 flex justify-end">
            <a href="<?= base_url('admin/pesan/delete/' . $pesan['id_pesan']) ?>" 
               onclick="return confirm('Yakin menghapus pesan ini?')" 
               class="text-red-500 border border-red-500 hover:bg-red-50 px-4 py-2 rounded-md transition font-medium mr-2">
                <i class="fas fa-trash mr-1"></i> Hapus Pesan
            </a>
            <a href="<?= base_url('admin/pesan/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition font-medium">
                <i class="fas fa-paper-plane mr-1"></i> Kirim Pesan Baru
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
