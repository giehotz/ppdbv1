<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-6 pb-6">

    <!-- Header / Dashboard Title & Avatar (Reference Style) -->
    <div class="flex items-center justify-between pt-2">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard</h2>
        <div class="h-10 w-10 overflow-hidden rounded-full ring-2 ring-brand-100 bg-brand-50 flex items-center justify-center shadow-sm">
            <?php 
            $nisn = session()->get('nisn');
            $foto = session()->get('foto');
            $fotoPath = 'uploads/berkas/' . $nisn . '/' . $foto;
            $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);
            if ($hasFoto): ?>
                <img src="<?= base_url($fotoPath) ?>" alt="Avatar" class="h-full w-full object-cover" />
            <?php else: ?>
                <span class="text-sm font-bold text-brand-600"><?= esc(strtoupper(substr($siswa['nama_lengkap'] ?? 'S', 0, 1))) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alert for Incomplete Data -->
    <?php if (!empty($incompleteFields)): ?>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-3.5 shadow-sm">
            <div class="flex items-center gap-2 font-bold text-amber-800 mb-1">
                <span class="material-symbols-outlined text-[18px]">warning</span>
                <span class="text-xs">Biodata Belum Lengkap (<?= count($incompleteFields) ?>)</span>
            </div>
            <p class="text-amber-700 text-[10px] pl-6">Silakan lengkapi biodata hingga 100%.</p>
        </div>
    <?php endif; ?>

    <!-- 2x2 Metric Grid -->
    <div class="grid grid-cols-2 gap-3.5">
        
        <!-- Card 1: Kelengkapan (Dark Theme) -->
        <div class="rounded-[1.25rem] bg-gray-900 p-4 text-white shadow-lg flex flex-col justify-between h-32 relative overflow-hidden">
            <div>
                <h3 class="text-2xl font-bold font-mono tracking-tight"><?= $completionPercentage ?? 0 ?>%</h3>
                <span class="text-[10px] text-gray-400 font-medium">Kelengkapan</span>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-[9px] text-gray-400 font-mono mb-1.5">
                    <span>0%</span>
                    <span>100%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-white h-1.5 rounded-full" style="width: <?= $completionPercentage ?? 0 ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Card 2: Verifikasi (Light Theme) -->
        <?php 
        $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
        if ($statusVerif === 'Terverifikasi') {
            $vLabel = 'Selesai';
            $vPct = 100;
            $vColor = 'bg-blue-500';
            $vBg = 'bg-blue-100';
        } elseif ($statusVerif === 'Ditolak') {
            $vLabel = 'Ditolak';
            $vPct = 100;
            $vColor = 'bg-red-500';
            $vBg = 'bg-red-100';
        } else {
            $vLabel = 'Menunggu';
            $vPct = 50;
            $vColor = 'bg-blue-400';
            $vBg = 'bg-blue-50';
        }
        ?>
        <div class="rounded-[1.25rem] bg-white p-4 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-32">
            <div>
                <h3 class="text-lg font-bold tracking-tight truncate"><?= $vLabel ?></h3>
                <span class="text-[10px] text-gray-500 font-medium">Verifikasi</span>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-[9px] text-gray-400 font-mono mb-1.5">
                    <span>Status</span>
                    <span>Panitia</span>
                </div>
                <div class="w-full <?= $vBg ?> rounded-full h-1.5 overflow-hidden">
                    <div class="<?= $vColor ?> h-1.5 rounded-full" style="width: <?= $vPct ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Pembayaran (Light Theme) -->
        <div class="rounded-[1.25rem] bg-white p-4 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-32">
            <div>
                <h3 class="text-lg font-bold tracking-tight text-emerald-600">Lunas</h3>
                <span class="text-[10px] text-gray-500 font-medium">Biaya Masuk</span>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-[9px] text-gray-400 font-mono mb-1.5">
                    <span>Min</span>
                    <span>Max</span>
                </div>
                <div class="w-full bg-emerald-50 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-400 h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Card 4: Berkas (Light Theme) -->
        <div class="rounded-[1.25rem] bg-white p-4 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-32">
            <div>
                <h3 class="text-lg font-bold tracking-tight text-pink-600 truncate">Lengkap</h3>
                <span class="text-[10px] text-gray-500 font-medium">Dokumen</span>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-between text-[9px] text-gray-400 font-mono mb-1.5">
                    <span>0%</span>
                    <span>100%</span>
                </div>
                <div class="w-full bg-pink-50 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-pink-400 h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group WhatsApp & Cetak Section (Replacing Revenue Chart) -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900">Tindakan</h3>
        </div>
        <div class="rounded-[1.25rem] bg-white p-1 shadow-sm border border-gray-100">
            <?php
            $isLocked = isset($completionPercentage) && $completionPercentage < 100;
            $url = $isLocked ? '#' : base_url('siswa/cetak-formulir');
            $target = $isLocked ? '' : 'target="_blank" rel="noopener"';
            $onClick = $isLocked ? 'onclick="alert(\'Silahkan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : '';
            ?>
            <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?>
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors <?= $isLocked ? 'opacity-60 cursor-not-allowed' : '' ?>">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                    <span class="material-symbols-outlined">print</span>
                </div>
                <div class="flex-1">
                    <h4 class="text-xs font-bold text-gray-900">Cetak Formulir</h4>
                    <p class="text-[10px] text-gray-500">Bukti pendaftaran siswa</p>
                </div>
                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                </div>
            </a>

            <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
            <div class="mx-4 border-t border-gray-50"></div>
            <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <i class="fab fa-whatsapp text-lg"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-xs font-bold text-gray-900">Grup WhatsApp</h4>
                    <p class="text-[10px] text-gray-500">Gabung grup calon siswa</p>
                </div>
                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Trending Items / Menu Layanan (List Style like Reference Image) -->
    <details class="group">
        <summary class="flex items-center justify-between mb-3 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
            <div class="flex items-center gap-1.5">
                <h3 class="text-sm font-bold text-gray-900">Menu Layanan</h3>
                <span class="material-symbols-outlined text-gray-400 text-[18px] transition-transform duration-200 group-open:rotate-180">expand_more</span>
            </div>
            <span class="text-[10px] text-brand-600 font-bold bg-brand-50 px-2 py-0.5 rounded-full">Tampilkan</span>
        </summary>
        
        <div class="rounded-[1.25rem] bg-white p-2 shadow-sm border border-gray-100 space-y-1">
            <?php 
            $mobileMenus = [
                ['url' => 'siswa/biodata', 'icon' => 'badge', 'label' => 'Biodata Siswa', 'desc' => 'Lengkapi data identitas'],
                ['url' => 'siswa/berkas', 'icon' => 'upload_file', 'label' => 'Upload Berkas', 'desc' => 'Dokumen persyaratan'],
                ['url' => 'siswa/status', 'icon' => 'rule', 'label' => 'Status Pendaftaran', 'desc' => 'Cek hasil verifikasi'],
            ];

            if (!isset($web['tampil_pembiayaan_siswa']) || $web['tampil_pembiayaan_siswa'] == 1) {
                $mobileMenus[] = ['url' => 'siswa/pembiayaan', 'icon' => 'payments', 'label' => 'Pembiayaan', 'desc' => 'Informasi tagihan & bayar'];
            }

            $mobileMenus = array_merge($mobileMenus, [
                ['url' => 'siswa/pengumuman', 'icon' => 'campaign', 'label' => 'Pengumuman', 'desc' => 'Informasi terbaru'],
                ['url' => 'siswa/kelulusan', 'icon' => 'school', 'label' => 'Hasil Kelulusan', 'desc' => 'Pengumuman kelulusan'],
            ]);
            foreach ($mobileMenus as $i => $m) :
            ?>
                <a href="<?= base_url($m['url']) ?>" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-600 border border-gray-100">
                            <span class="material-symbols-outlined text-[20px]"><?= $m['icon'] ?></span>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900"><?= $m['label'] ?></h4>
                            <p class="text-[10px] text-gray-500"><?= $m['desc'] ?></p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-brand-500 bg-brand-50 px-2.5 py-1 rounded-lg">Buka</span>
                </a>
                <?php if($i < count($mobileMenus)-1): ?>
                    <div class="mx-4 border-t border-gray-50"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </details>

</div>
<?= $this->endSection() ?>
