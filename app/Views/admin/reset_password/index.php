<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Antrean Reset Password
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Antrean Permintaan Reset Password
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

<?php if (session()->getFlashdata('wa_url')) : ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded relative mb-4 flex items-center justify-between" role="alert">
        <span>
            <i class="fab fa-whatsapp text-green-500 mr-1"></i>
            Password <strong><?= session()->getFlashdata('wa_nama') ?></strong> berhasil direset! Kirim notifikasi ke siswa:
        </span>
        <a href="<?= session()->getFlashdata('wa_url') ?>" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1.5 px-4 rounded shadow-sm transition text-sm flex items-center gap-1">
            <i class="fab fa-whatsapp"></i> Kirim ke WhatsApp
        </a>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Daftar Permintaan Reset Password (Pending)</h3>
        <p class="text-sm text-gray-500 mt-1">Siswa yang lupa password akan mengajukan permintaan reset melalui halaman login.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                    <th class="py-3 px-6">Waktu</th>
                    <th class="py-3 px-6">Nama Siswa</th>
                    <th class="py-3 px-6">NIK</th>
                    <th class="py-3 px-6">No. Pendaftaran</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
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
                                <span class="font-semibold text-gray-800"><?= esc($r['nama']) ?></span>
                            </td>
                            <td class="py-3 px-6 font-mono text-xs"><?= esc($r['nik']) ?></td>
                            <td class="py-3 px-6">
                                <?php if (!empty($r['no_pendaftaran'])): ?>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded"><?= esc($r['no_pendaftaran']) ?></span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <form action="<?= base_url('admin/reset-password/approve/' . $r['id']) ?>" method="post" class="inline" data-confirm="Reset password siswa ini? Password baru akan digenerate secara acak.">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1.5 px-3 rounded shadow-sm transition text-xs flex items-center gap-1">
                                            <i class="fas fa-check"></i> Reset & Setujui
                                        </button>
                                    </form>

                                    <form action="<?= base_url('admin/reset-password/reject/' . $r['id']) ?>" method="post" class="inline" data-confirm="Tolak permintaan reset ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded shadow-sm transition text-xs flex items-center gap-1">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>

                                    <?php
                                        $nomor = $r['no_hp_siswa'] ?? ($r['no_hp_ortu'] ?? '');
                                        if (!empty($nomor)):
                                    ?>
                                        <a href="https://wa.me/<?= esc($nomor) ?>" target="_blank" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-1.5 px-3 rounded shadow-sm transition text-xs flex items-center gap-1">
                                            <i class="fab fa-whatsapp"></i> Hubungi WA
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3 block"></i>
                            <p>Tidak ada permintaan reset password yang tertunda saat ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
