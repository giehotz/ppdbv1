<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Detail Pesan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detail Pesan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">
            <i class="fas fa-envelope-open mr-2 text-blue-500"></i>
            <?= esc($pesan['subjek']) ?>
        </h3>
        
        <a href="<?= base_url('siswa/pesan') ?>" class="text-gray-500 hover:text-gray-700 p-1 border rounded-md transition hover:bg-gray-200">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <div class="p-6">
        <div class="flex justify-between items-start mb-6 pb-4 border-b">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl mr-4 shadow-sm border border-blue-200">
                    <?= substr($pesan['nama_pengirim'], 0, 1) ?>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 flex items-center">
                        Dari: <?= esc($pesan['nama_pengirim']) ?>
                    </h4>
                    <p class="text-sm mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $pesan['pengirim_type'] == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' ?>">
                            <?= ucfirst($pesan['pengirim_type']) ?>
                        </span>
                    </p>
                </div>
            </div>
            <div class="text-right text-sm text-gray-500 flex flex-col items-end">
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full whitespace-nowrap mb-1">
                    <i class="far fa-clock mr-1"></i> <?= date('d M Y, H:i', strtotime($pesan['created_at'])) ?>
                </span>
            </div>
        </div>

        <div class="prose max-w-none text-gray-800 bg-gray-50 p-6 rounded-lg border border-gray-100 min-h-[300px] shadow-inner whitespace-pre-wrap">
<?= esc($pesan['isi_pesan']) ?>
        </div>
        
        <div class="mt-8 flex justify-end">
            <a href="<?= base_url('siswa/pesan') ?>" class="bg-gray-100 border border-gray-300 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-md transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Kotak Masuk
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
