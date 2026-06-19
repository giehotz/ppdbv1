<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Antrean Buka Kunci
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Antrean Permohonan Buka Kunci
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
        <h3 class="text-lg font-medium text-gray-900">Daftar Permohonan Buka Kunci (Tertunda)</h3>
        <p class="text-sm text-gray-500 mt-1">Siswa di bawah ini memohon perbaikan biodata dan meminta Anda membuka kembali Form mereka yang sudah Final.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6">Waktu Pengajuan</th>
                    <th class="py-3 px-6">Identitas Siswa</th>
                    <th class="py-3 px-6 w-1/3">Alasan / Pesan Siswa</th>
                    <th class="py-3 px-6 text-center">Aksi (Eksekusi)</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 font-light text-sm">
                <?php if (!empty($requests)) : ?>
                    <?php foreach ($requests as $r) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 whitespace-nowrap">
                                <div class="font-medium"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                                <div class="text-xs text-gray-400"><?= date('H:i:s', strtotime($r['created_at'])) ?></div>
                            </td>
                            <td class="py-3 px-6">
                                <span class="font-semibold text-gray-800 block"><?= esc($r['nama_lengkap']) ?></span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded mt-1 inline-block"><?= esc($r['no_pendaftaran']) ?></span>
                            </td>
                            <td class="py-3 px-6">
                                <div class="bg-gray-50 p-3 rounded text-sm italic border-l-4 border-yellow-400 text-gray-700">
                                    "<?= htmlspecialchars($r['alasan']) ?>"
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center gap-2">
                                    <form action="<?= base_url('verifikator/unlockrequest/approve/' . $r['id_request']) ?>" method="post" class="inline" data-confirm="Apakah Anda yakin menyetujui dan MEMBUKA KEMBALI form siswa ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1.5 px-3 rounded shadow-sm transition text-xs flex items-center">
                                            <i class="fas fa-check mr-1"></i> Terima & Buka
                                        </button>
                                    </form>

                                    <form action="<?= base_url('verifikator/unlockrequest/reject/' . $r['id_request']) ?>" method="post" class="inline" data-confirm="Tolak permohonan ini? (Data siswa akan tetap TERKUNCI FINAL)">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded shadow-sm transition text-xs flex items-center">
                                            <i class="fas fa-times mr-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="py-8 px-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3 block"></i>
                            <p>Keren! Belum ada satupun antrean permohonan perbaikan biodata saat ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
