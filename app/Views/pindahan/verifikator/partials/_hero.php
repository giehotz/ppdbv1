<!-- Hero Section -->
<div class="mb-6 relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 via-brand-500 to-indigo-500 p-6 md:p-8 shadow-theme-md dark:from-brand-700 dark:via-brand-600 dark:to-indigo-700">
    <div class="absolute -top-10 -right-10 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
    <div class="absolute bottom-0 right-24 h-24 w-24 rounded-full bg-white/10 blur-xl"></div>

    <div class="relative flex flex-col lg:flex-row justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-2xl font-extrabold shrink-0 ring-1 ring-white/30">
                <?= esc($inisialP) ?>
            </div>
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-white/90 px-2.5 py-0.5 text-[10px] font-bold text-brand-700 shadow-sm">
                        <span class="material-symbols-outlined text-[12px]">swap_horiz</span> Jalur: Pindahan
                    </span>
                    <?php
                        $stHero = $siswa['status_verifikasi'] ?? '';
                        if ($stHero === 'Terverifikasi') :
                    ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-400/90 px-2.5 py-0.5 text-[10px] font-bold text-emerald-950 shadow-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-900"></span> Terverifikasi
                        </span>
                    <?php elseif ($stHero === 'Ditolak') : ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-red-400/90 px-2.5 py-0.5 text-[10px] font-bold text-red-950 shadow-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-900"></span> Ditolak
                        </span>
                    <?php else : ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-400/90 px-2.5 py-0.5 text-[10px] font-bold text-amber-950 shadow-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-900"></span> Menunggu Verifikasi
                        </span>
                    <?php endif; ?>
                </div>
                <h2 class="text-xl md:text-2xl font-extrabold text-white leading-tight"><?= esc($siswa['nama_lengkap'] ?? '-') ?></h2>
                <p class="text-[11px] md:text-xs text-white/80 font-mono">
                    No. Pendaftaran: <strong><?= esc($siswa['no_pendaftaran'] ?? '-') ?></strong>
                    <span class="mx-1.5 opacity-50">|</span>
                    NISN: <strong><?= esc($siswa['nisn'] ?? '-') ?></strong>
                </p>
            </div>
        </div>

        <!-- Jenjang Asal -->
        <div class="shrink-0 flex flex-col items-start lg:items-end justify-center gap-2 rounded-2xl bg-white/15 backdrop-blur-md px-4 py-3 ring-1 ring-white/30">
            <span class="text-[10px] font-bold uppercase tracking-wider text-white/80">Jenjang Asal</span>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-1.5 text-xs font-bold text-blue-700 shadow-sm">
                    <span class="material-symbols-outlined text-sm">school</span> <?= esc($siswa['jenjang_sekolah_asal'] ?? '-') ?>
                </span>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <div class="flex-1 bg-white/25 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-white h-1.5 rounded-full" style="width: <?= esc($siswa['kelengkapan'] ?? 0, 'attr') ?>%"></div>
                </div>
                <span class="text-[10px] font-bold text-white"><?= esc($siswa['kelengkapan'] ?? 0) ?>% Biodata</span>
            </div>
        </div>
    </div>
</div>