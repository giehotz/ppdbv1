<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Antrean Reset Password
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">lock_reset</span> Antrean Reset Password
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('wa_url')) : ?>
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/80 dark:border-emerald-500/20 dark:bg-emerald-500/10 p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-theme-xs">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400">
                <span class="material-symbols-outlined text-xl">chat</span>
            </div>
            <div>
                <p class="text-sm font-bold text-emerald-900 dark:text-emerald-200">
                    Password <span class="underline"><?= esc(session()->getFlashdata('wa_nama')) ?></span> berhasil direset!
                </p>
                <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5">Kirimkan rincian akun baru ke kontak WhatsApp siswa/wali sekarang.</p>
            </div>
        </div>
        <a href="<?= session()->getFlashdata('wa_url') ?>" target="_blank"
           class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97] shrink-0">
            <span class="material-symbols-outlined text-base">send</span>
            <span>Kirim via WhatsApp</span>
        </a>
    </div>
<?php endif; ?>

<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-4 mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Permohonan Reset Password Siswa</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar calon peserta didik yang mengajukan permohonan reset password masuk sistem</p>
        </div>
        <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 px-3 py-1 text-xs font-bold border border-brand-200/50 dark:border-brand-500/20 self-start sm:self-auto">
            <?= count($requests ?? []) ?> Permohonan Pending
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                    <th class="py-3.5 px-4">Waktu Pengajuan</th>
                    <th class="py-3.5 px-4">Nama Lengkap</th>
                    <th class="py-3.5 px-4">NIK</th>
                    <th class="py-3.5 px-4">No. Pendaftaran</th>
                    <th class="py-3.5 px-4 text-center">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs md:text-sm">
                <?php if (!empty($requests)) : ?>
                    <?php foreach ($requests as $r) : ?>
                        <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-4 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                                <div><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500"><?= date('H:i:s', strtotime($r['created_at'])) ?> WIB</div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold font-mono text-sm">
                                        <?= strtoupper(substr($r['nama'] ?? 'S', 0, 1)) ?>
                                    </div>
                                    <span class="font-bold text-gray-900 dark:text-white"><?= esc($r['nama']) ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap font-mono text-xs text-gray-600 dark:text-gray-400">
                                <?= esc($r['nik']) ?>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <?php if (!empty($r['no_pendaftaran'])): ?>
                                    <span class="inline-flex items-center rounded-full bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400 px-2.5 py-0.5 text-xs font-bold font-mono border border-blue-200/50 dark:border-blue-500/20">
                                        <?= esc($r['no_pendaftaran']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400">&mdash;</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <form action="<?= base_url('admin/reset-password/approve/' . $r['id']) ?>" method="post" class="inline" data-confirm="Reset password siswa ini? Password baru akan dibuat otomatis oleh sistem.">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 shadow-theme-xs transition active:scale-[0.97] text-xs">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                            <span>Setujui & Reset</span>
                                        </button>
                                    </form>

                                    <form action="<?= base_url('admin/reset-password/reject/' . $r['id']) ?>" method="post" class="inline" data-confirm="Tolak permintaan reset password ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25 font-bold py-1.5 px-3 transition active:scale-[0.97] text-xs">
                                            <span class="material-symbols-outlined text-sm">close</span>
                                            <span>Tolak</span>
                                        </button>
                                    </form>

                                    <?php
                                        $nomor = $r['no_hp_siswa'] ?? ($r['no_hp_ortu'] ?? '');
                                        if (!empty($nomor)):
                                    ?>
                                        <a href="https://wa.me/<?= esc($nomor) ?>" target="_blank"
                                           class="inline-flex items-center gap-1 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-bold py-1.5 px-3 shadow-theme-xs transition active:scale-[0.97] text-xs"
                                           title="Hubungi Siswa/Wali">
                                            <span class="material-symbols-outlined text-sm text-emerald-600 dark:text-emerald-400">chat</span>
                                            <span>Hubungi</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-4xl block mb-2">lock_open</span>
                            <p class="text-xs">Tidak ada permintaan reset password yang tertunda saat ini.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
