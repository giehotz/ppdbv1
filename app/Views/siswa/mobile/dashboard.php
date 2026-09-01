<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">

    <!-- Hero Card (TailAdmin Mobile Style) -->
    <div class="rounded-2xl bg-gradient-to-br from-brand-600 via-brand-500 to-blue-600 p-4.5 text-white shadow-theme-sm relative overflow-hidden">
        <div class="flex items-center gap-3.5 relative z-10">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white font-bold text-lg border border-white/25 shrink-0 shadow-inner">
                <?= esc(strtoupper(substr($siswa['nama_lengkap'] ?? 'S', 0, 1))) ?>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-semibold text-brand-100 uppercase tracking-wider block">Selamat Datang,</span>
                <h3 class="text-sm font-bold text-white truncate leading-snug"><?= esc($siswa['nama_lengkap']) ?></h3>
                <div class="mt-1 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-black/20 text-[10px] font-mono text-white/95 border border-white/10">
                    <span class="material-symbols-outlined text-[13px]">badge</span>
                    <span><?= esc($siswa['no_pendaftaran']) ?></span>
                </div>
            </div>
        </div>

        <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
            <div class="mt-3.5 pt-3 border-t border-white/15">
                <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener"
                   class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-white text-emerald-700 hover:bg-white/95 px-3 py-2 text-xs font-bold shadow-sm transition-all active:scale-[0.98]">
                    <i class="fab fa-whatsapp text-emerald-600 text-sm"></i>
                    <span>Gabung Grup WhatsApp Siswa</span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Metric Status Cards -->
    <div class="grid grid-cols-2 gap-3">
        <!-- Verification Status -->
        <div class="rounded-2xl border border-gray-200 bg-white p-3.5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center flex flex-col items-center justify-center">
            <?php 
            $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
            if ($statusVerif === 'Terverifikasi') {
                $vColor = 'text-emerald-600 dark:text-emerald-400';
                $vBg = 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400';
                $vIcon = 'check_circle';
                $vLabel = 'Terverifikasi';
            } elseif ($statusVerif === 'Ditolak') {
                $vColor = 'text-red-600 dark:text-red-400';
                $vBg = 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400';
                $vIcon = 'cancel';
                $vLabel = 'Ditolak';
            } else {
                $vColor = 'text-amber-600 dark:text-amber-400';
                $vBg = 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400';
                $vIcon = 'hourglass_top';
                $vLabel = 'Menunggu';
            }
            ?>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl <?= $vBg ?> mb-2">
                <span class="material-symbols-outlined text-xl"><?= $vIcon ?></span>
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Verifikasi</span>
            <p class="text-xs font-bold mt-0.5 <?= $vColor ?> truncate"><?= $vLabel ?></p>
        </div>

        <!-- Completion Percentage -->
        <div class="rounded-2xl border border-gray-200 bg-white p-3.5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center flex flex-col items-center justify-center">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-extrabold text-xs mb-2">
                <?= $completionPercentage ?? 0 ?>%
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Kelengkapan</span>
            <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1.5 mt-1.5 overflow-hidden">
                <div class="bg-brand-500 h-1.5 rounded-full" style="width: <?= $completionPercentage ?? 0 ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Alert for Incomplete Data -->
    <?php if (!empty($incompleteFields)): ?>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/70 p-3.5 dark:border-amber-900/40 dark:bg-amber-950/20 text-xs">
            <div class="flex items-center gap-1.5 font-bold text-amber-800 dark:text-amber-300 mb-1">
                <span class="material-symbols-outlined text-base">warning</span>
                <span>Biodata Belum Lengkap (<?= count($incompleteFields) ?> Kolom)</span>
            </div>
            <p class="text-amber-700 dark:text-amber-400 text-[11px]">Silakan lengkapi formulir biodata hingga 100% agar dapat mencetak bukti dan finalisasi.</p>
        </div>
    <?php endif; ?>

    <!-- Service Grid (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
        <div class="flex items-center justify-between pb-2 border-b border-gray-100 dark:border-gray-800">
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">Menu Layanan Siswa</h4>
            <span class="text-[10px] text-gray-400">8 Menu</span>
        </div>

        <div class="grid grid-cols-4 gap-2.5">
            <?php 
            $mobileMenus = [
                ['url' => 'siswa/biodata', 'icon' => 'badge', 'label' => 'Biodata'],
                ['url' => 'siswa/berkas', 'icon' => 'upload_file', 'label' => 'Berkas'],
                ['url' => 'siswa/status', 'icon' => 'rule', 'label' => 'Status'],
                ['url' => 'siswa/pembiayaan', 'icon' => 'payments', 'label' => 'Biaya'],
                ['url' => 'siswa/pengumuman', 'icon' => 'campaign', 'label' => 'Info'],
                ['url' => 'siswa/pesan', 'icon' => 'mail', 'label' => 'Pesan'],
                ['url' => 'siswa/kelulusan', 'icon' => 'school', 'label' => 'Kelulusan'],
                ['url' => 'siswa/twibbon', 'icon' => 'photo_filter', 'label' => 'Twibbon'],
            ];
            foreach ($mobileMenus as $m) :
            ?>
                <a href="<?= base_url($m['url']) ?>"
                   class="flex flex-col items-center justify-center p-2.5 rounded-xl bg-gray-50/80 hover:bg-brand-50/50 hover:border-brand-200 border border-gray-100 dark:border-gray-800 dark:bg-gray-800/40 dark:hover:bg-gray-800 transition-all active:scale-95 text-center">
                    <span class="material-symbols-outlined text-2xl text-brand-500 mb-1"><?= $m['icon'] ?></span>
                    <span class="text-[10px] font-semibold text-gray-700 dark:text-gray-300 truncate w-full"><?= $m['label'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Cetak Formulir CTA -->
        <?php
        $isLocked = isset($completionPercentage) && $completionPercentage < 100;
        $url = $isLocked ? '#' : base_url('siswa/cetak-formulir');
        $target = $isLocked ? '' : 'target="_blank" rel="noopener"';
        $onClick = $isLocked ? 'onclick="alert(\'Silahkan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : '';
        ?>
        <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?>
           class="mt-2 w-full flex items-center justify-between p-3.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white shadow-theme-xs active:scale-[0.98] transition-all <?= $isLocked ? 'opacity-50 cursor-not-allowed' : '' ?>">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-xl">print</span>
                <span class="text-xs font-bold">Cetak Formulir Pendaftaran</span>
            </div>
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>

    <!-- Timeline Progress -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-3">
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-800">
            Alur Tahapan PPDB
        </h4>

        <div class="space-y-4 pl-1">
            <div class="flex items-start gap-3 relative">
                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 font-bold text-xs shrink-0">
                    <span class="material-symbols-outlined text-sm">check</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Registrasi Akun Siswa</h5>
                    <p class="text-[10px] text-gray-400"><?= $siswa['tgl_siswa'] ? date('d M Y', strtotime($siswa['tgl_siswa'])) : '-' ?></p>
                </div>
            </div>

            <div class="flex items-start gap-3 relative">
                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 font-bold text-xs shrink-0">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Pengisian Formulir Biodata</h5>
                    <p class="text-[10px] text-gray-400">Kelengkapan: <?= $completionPercentage ?? 0 ?>%</p>
                </div>
            </div>

            <div class="flex items-start gap-3 relative">
                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 font-bold text-xs shrink-0">
                    <span class="material-symbols-outlined text-sm">hourglass_top</span>
                </div>
                <div class="min-w-0 flex-1">
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Verifikasi Dokumen &amp; Seleksi</h5>
                    <p class="text-[10px] text-gray-400">Pemeriksaan oleh panitia</p>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
