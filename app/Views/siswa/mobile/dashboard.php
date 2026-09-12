<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="space-y-5 pb-6">

    <!-- Header / Dashboard Title & Avatar -->
    <div class="flex items-center justify-between pt-2">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-gray-900">Halo, <?= esc(explode(' ', trim($siswa['nama_lengkap'] ?? 'Siswa'))[0]) ?> 👋</h2>
            <p class="text-[11px] text-gray-500 font-mono"><?= esc($siswa['no_pendaftaran']) ?> | <?= esc($siswa['jalur_pendaftaran'] ?? 'Reguler') ?></p>
        </div>
        <div class="h-11 w-11 overflow-hidden rounded-full ring-2 ring-brand-100 bg-brand-50 flex items-center justify-center shadow-sm shrink-0">
            <?php 
            $nisn = session()->get('nisn');
            $foto = session()->get('foto');
            $fotoPath = !empty($foto) ? 'uploads/berkas/' . $nisn . '/' . $foto : '';
            $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);
            if (!$hasFoto && !empty($siswa['id_siswa'])) {
                $berkasFoto = (new \App\Models\BerkasModel())
                    ->where('id_siswa', $siswa['id_siswa'])
                    ->where('jenis_berkas', 'foto')
                    ->first();
                if (!empty($berkasFoto['nama_file'])) {
                    $berkasPath = 'uploads/berkas/' . $nisn . '/' . $berkasFoto['nama_file'];
                    if (file_exists(FCPATH . $berkasPath)) {
                        $fotoPath = $berkasPath;
                        $hasFoto = true;
                    }
                }
            }
            if ($hasFoto): ?>
                <img src="<?= base_url($fotoPath) ?>" alt="Avatar" class="h-full w-full object-cover" />
            <?php else: ?>
                <span class="text-sm font-bold text-brand-600"><?= esc(strtoupper(substr($siswa['nama_lengkap'] ?? 'S', 0, 1))) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- 1. SMART ACTION ALERT BANNER (Mobile Optimized) -->
    <?php if (!empty($smartAlert)): ?>
        <?php
        $alertBgs = [
            'danger'  => 'border-red-200 bg-red-50/90 text-red-900',
            'warning' => 'border-amber-200 bg-amber-50/90 text-amber-900',
            'info'    => 'border-blue-200 bg-blue-50/90 text-blue-900',
            'billing' => 'border-indigo-200 bg-indigo-50/90 text-indigo-900',
            'success' => 'border-emerald-200 bg-emerald-50/90 text-emerald-900',
        ];
        $bgStyle = $alertBgs[$smartAlert['type']] ?? 'border-blue-200 bg-blue-50 text-blue-900';
        ?>
        <div class="rounded-2xl border p-3.5 shadow-sm <?= $bgStyle ?> space-y-2">
            <div class="flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5"><?= $smartAlert['icon'] ?></span>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold leading-snug"><?= esc($smartAlert['title']) ?></h4>
                    <p class="text-[10px] opacity-90 mt-0.5 leading-relaxed"><?= esc($smartAlert['message']) ?></p>
                </div>
            </div>
            <?php if (!empty($smartAlert['btn_url'])): ?>
                <a href="<?= esc($smartAlert['btn_url']) ?>" class="block text-center py-2 px-3 rounded-xl text-xs font-bold text-white shadow-sm <?= $smartAlert['btn_color'] ?>">
                    <?= esc($smartAlert['btn_text']) ?> &rarr;
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- 2. HORIZONTAL PPDB MILESTONE STEPPER (Mobile Scrollable) -->
    <?php if (!empty($milestones) && ($web['stepper_aktif'] ?? '1') == '1'): ?>
    <div class="rounded-[1.25rem] bg-white p-3.5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-gray-900 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-brand-500 text-sm">alt_route</span>
                Tahapan Pendaftaran
            </span>
            <span class="text-[10px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">
                <?= (int) ($completionPercentage ?? 0) ?>% Selesai
            </span>
        </div>

        <div class="overflow-x-auto no-scrollbar pb-1">
            <div class="flex items-center gap-2 min-w-[540px]">
                <?php foreach ($milestones as $idx => $m): ?>
                    <?php
                    $isComp = $m['status'] === 'completed';
                    $isCurr = $m['status'] === 'current';
                    $isWarn = $m['status'] === 'warning';
                    
                    if ($isComp) {
                        $badgeStyle = 'bg-emerald-500 text-white';
                    } elseif ($isCurr) {
                        $badgeStyle = 'bg-brand-500 text-white ring-2 ring-brand-200 animate-pulse';
                    } elseif ($isWarn) {
                        $badgeStyle = 'bg-amber-500 text-white';
                    } else {
                        $badgeStyle = 'bg-gray-100 text-gray-400';
                    }
                    ?>
                    <div class="flex items-center gap-2">
                        <div class="flex flex-col items-center text-center w-16">
                            <div class="h-7 w-7 rounded-full flex items-center justify-center text-xs font-bold <?= $badgeStyle ?>">
                                <span class="material-symbols-outlined text-[14px]">
                                    <?= $isComp ? 'check' : ($isWarn ? 'warning' : $m['icon']) ?>
                                </span>
                            </div>
                            <span class="text-[9px] font-bold text-gray-800 mt-1 truncate w-full leading-tight"><?= esc($m['title']) ?></span>
                            <span class="text-[8px] text-gray-400 truncate w-full"><?= esc($m['description']) ?></span>
                        </div>
                        <?php if ($idx < count($milestones) - 1): ?>
                            <div class="w-3 h-0.5 <?= $isComp ? 'bg-emerald-400' : 'bg-gray-200' ?> -mt-4"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- 3. 2x2 Metric Grid -->
    <div class="grid grid-cols-2 gap-3">
        
        <!-- Card 1: Kelengkapan Biodata -->
        <div class="rounded-[1.25rem] bg-gray-900 p-3.5 text-white shadow-md flex flex-col justify-between h-28 relative overflow-hidden">
            <div>
                <h3 class="text-xl font-bold font-mono tracking-tight"><?= (int)($completionPercentage ?? 0) ?>%</h3>
                <span class="text-[9px] text-gray-400 font-medium">Biodata Siswa</span>
            </div>
            <div>
                <div class="flex items-center justify-between text-[8px] text-gray-400 font-mono mb-1">
                    <span>0%</span>
                    <span>100%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-brand-400 h-1.5 rounded-full" style="width: <?= (int)($completionPercentage ?? 0) ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Card 2: Verifikasi Berkas -->
        <?php 
        $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
        if ($statusVerif === 'Terverifikasi') {
            $vLabel = 'Valid';
            $vColor = 'bg-emerald-500';
            $vText  = 'text-emerald-600';
        } elseif ($statusVerif === 'Ditolak') {
            $vLabel = 'Ditolak';
            $vColor = 'bg-red-500';
            $vText  = 'text-red-600';
        } else {
            $vLabel = 'Menunggu';
            $vColor = 'bg-amber-400';
            $vText  = 'text-amber-600';
        }
        ?>
        <div class="rounded-[1.25rem] bg-white p-3.5 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-28">
            <div>
                <h3 class="text-base font-bold tracking-tight truncate <?= $vText ?>"><?= $vLabel ?></h3>
                <span class="text-[9px] text-gray-400 font-medium">Verifikasi Berkas</span>
            </div>
            <div>
                <span class="text-[8px] text-gray-400 font-mono block mb-1">Status Panitia</span>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div class="<?= $vColor ?> h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Card 3: Berkas Dokumen -->
        <div class="rounded-[1.25rem] bg-white p-3.5 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-28">
            <div>
                <h3 class="text-base font-bold tracking-tight text-purple-600 font-mono"><?= (int)$berkasCount ?>/<?= (int)$berkasRequiredCount ?></h3>
                <span class="text-[9px] text-gray-400 font-medium">Unggah Dokumen</span>
            </div>
            <div>
                <span class="text-[8px] text-gray-400 font-mono block mb-1">
                    <?= $berkasCount >= $berkasRequiredCount ? 'Lengkap' : 'Belum Lengkap' ?>
                </span>
                <div class="w-full bg-purple-50 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: <?= min(100, ($berkasCount / max(1, $berkasRequiredCount)) * 100) ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Card 4: Pembiayaan / Biaya Masuk -->
        <div class="rounded-[1.25rem] bg-white p-3.5 text-gray-900 shadow-sm border border-gray-100 flex flex-col justify-between h-28">
            <div>
                <?php if ($tampilPembiayaan && $totalTagihan > 0): ?>
                    <h3 class="text-xs font-extrabold tracking-tight <?= $statusLunas ? 'text-emerald-600' : 'text-amber-600' ?>">
                        <?= $statusLunas ? 'LUNAS' : 'Rp ' . number_format($sisaTagihan, 0, ',', '.') ?>
                    </h3>
                <?php else: ?>
                    <h3 class="text-xs font-extrabold tracking-tight text-emerald-600">GRATIS</h3>
                <?php endif; ?>
                <span class="text-[9px] text-gray-400 font-medium">Kewajiban Biaya</span>
            </div>
            <div>
                <span class="text-[8px] text-gray-400 font-mono block mb-1">
                    <?= ($tampilPembiayaan && $totalTagihan > 0) ? ($statusLunas ? 'Semua Lunas' : 'Belum Lunas') : 'Bebas Biaya' ?>
                </span>
                <div class="w-full bg-emerald-50 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- 4. TINDAKAN UTAMA & CETAK DOKUMEN -->
    <div class="space-y-2.5">
        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tindakan &amp; Bukti Cetak</h3>
        
        <div class="rounded-[1.25rem] bg-white p-1 shadow-sm border border-gray-100 divide-y divide-gray-50">
            <!-- Cetak Kartu Peserta -->
            <?php
            $isCardLocked = !($canPrintCard ?? false);
            $urlCard = $isCardLocked ? '#' : base_url('siswa/cetak-kartu');
            $targetCard = $isCardLocked ? '' : 'target="_blank" rel="noopener"';
            $clickCard = $isCardLocked ? 'onclick="alert(\'Silakan lengkapi biodata 100% untuk mencetak kartu tanda peserta.\'); return false;"' : '';
            ?>
            <a href="<?= $urlCard ?>" <?= $targetCard ?> <?= $clickCard ?>
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors <?= $isCardLocked ? 'opacity-50' : '' ?>">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <span class="material-symbols-outlined text-xl">badge</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold text-gray-900 flex items-center gap-1">
                        <span>Cetak Kartu Peserta PPDB</span>
                        <?php if ($isCardLocked): ?>
                            <span class="material-symbols-outlined text-[12px] text-gray-400">lock</span>
                        <?php endif; ?>
                    </h4>
                    <p class="text-[10px] text-gray-500 truncate"><?= (($web['ujian_aktif'] ?? '0') == '1') ? 'ID Card tanda bukti peserta tes' : 'Tanda bukti pendaftaran resmi PPDB' ?></p>
                </div>
                <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
            </a>

            <!-- Cetak Formulir -->
            <?php
            $isFormLocked = ($completionPercentage ?? 0) < 100;
            $urlForm = $isFormLocked ? '#' : base_url('siswa/cetak-formulir');
            $targetForm = $isFormLocked ? '' : 'target="_blank" rel="noopener"';
            $clickForm = $isFormLocked ? 'onclick="alert(\'Silakan lengkapi biodata 100% untuk mencetak formulir.\'); return false;"' : '';
            ?>
            <a href="<?= $urlForm ?>" <?= $targetForm ?> <?= $clickForm ?>
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors <?= $isFormLocked ? 'opacity-50' : '' ?>">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                    <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold text-gray-900 flex items-center gap-1">
                        <span>Cetak Formulir Pendaftaran</span>
                        <?php if ($isFormLocked): ?>
                            <span class="material-symbols-outlined text-[12px] text-gray-400">lock</span>
                        <?php endif; ?>
                    </h4>
                    <p class="text-[10px] text-gray-500 truncate">Formulir lengkap pendaftar</p>
                </div>
                <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
            </a>

            <!-- Cetak Surat Pernyataan -->
            <a href="<?= base_url('siswa/surat-pernyataan') ?>" target="_blank" rel="noopener"
               class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <span class="material-symbols-outlined text-xl">description</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold text-gray-900">Surat Pernyataan Bermaterai</h4>
                    <p class="text-[10px] text-gray-500 truncate">Template resmi siap cetak &amp; materai</p>
                </div>
                <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
            </a>

            <!-- WhatsApp Group (Jika Aktif) -->
            <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" rel="noopener"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-gray-900">Grup WhatsApp Siswa</h4>
                        <p class="text-[10px] text-gray-500 truncate">Gabung grup calon siswa resmi</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400 text-sm">open_in_new</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 5. MENU LAYANAN LENGKAP (Collapsible List) -->
    <details class="group" open>
        <summary class="flex items-center justify-between mb-3 cursor-pointer list-none select-none [&::-webkit-details-marker]:hidden">
            <div class="flex items-center gap-1.5">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Menu Layanan Siswa</h3>
                <span class="material-symbols-outlined text-gray-400 text-[18px] transition-transform duration-200 group-open:rotate-180">expand_more</span>
            </div>
            <span class="text-[10px] text-brand-600 font-bold bg-brand-50 px-2 py-0.5 rounded-full">Menu</span>
        </summary>
        
        <div class="rounded-[1.25rem] bg-white p-1.5 shadow-sm border border-gray-100 space-y-1">
            <?php 
            $mobileMenus = [
                ['url' => 'siswa/biodata', 'icon' => 'badge', 'label' => 'Biodata Siswa', 'desc' => 'Lengkapi data identitas'],
                ['url' => 'siswa/berkas', 'icon' => 'upload_file', 'label' => 'Upload Berkas', 'desc' => 'Dokumen persyaratan'],
                ['url' => 'siswa/status', 'icon' => 'rule', 'label' => 'Status Pendaftaran', 'desc' => 'Cek hasil verifikasi'],
            ];

            if ($tampilPembiayaan) {
                $mobileMenus[] = ['url' => 'siswa/pembiayaan', 'icon' => 'payments', 'label' => 'Pembiayaan', 'desc' => 'Informasi tagihan & bayar'];
            }

            $mobileMenus[] = ['url' => 'siswa/pengumuman', 'icon' => 'campaign', 'label' => 'Pengumuman', 'desc' => 'Informasi terbaru'];
            $mobileMenus[] = ['url' => 'siswa/kelulusan', 'icon' => 'school', 'label' => 'Hasil Kelulusan', 'desc' => 'Pengumuman kelulusan'];

            if (($siswa['status_lulus'] ?? '') === 'Lulus') {
                $mobileMenus[] = ['url' => 'siswa/daftar-ulang', 'icon' => 'backpack', 'label' => 'Daftar Ulang', 'desc' => 'Konfirmasi pasca kelulusan'];
            }

            foreach ($mobileMenus as $i => $m) :
            ?>
                <a href="<?= base_url($m['url']) ?>" class="flex items-center justify-between p-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-50 text-gray-600 border border-gray-100">
                            <span class="material-symbols-outlined text-[18px]"><?= $m['icon'] ?></span>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900"><?= $m['label'] ?></h4>
                            <p class="text-[9px] text-gray-500"><?= $m['desc'] ?></p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-brand-500 bg-brand-50 px-2 py-0.5 rounded-md">Buka</span>
                </a>
                <?php if ($i < count($mobileMenus)-1): ?>
                    <div class="mx-3 border-t border-gray-50"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </details>

    <!-- 6. HELPDESK & FAQ ACCORDION -->
    <?php if (!empty($faqs)): ?>
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tanya Jawab (FAQ)</h3>
                <?php if (!empty($web['telepon'])): ?>
                    <?php
                    $cleanWa = preg_replace('/[^0-9]/', '', $web['telepon']);
                    if (substr($cleanWa, 0, 1) === '0') {
                        $cleanWa = '62' . substr($cleanWa, 1);
                    }
                    ?>
                    <a href="https://wa.me/<?= $cleanWa ?>" target="_blank" rel="noopener" class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                        <i class="fab fa-whatsapp"></i> Chat CS
                    </a>
                <?php endif; ?>
            </div>

            <div class="space-y-1.5">
                <?php foreach (array_slice($faqs, 0, 4) as $faq): ?>
                    <details class="rounded-xl border border-gray-100 bg-white p-3 shadow-sm group">
                        <summary class="flex cursor-pointer items-center justify-between font-bold text-xs text-gray-800 list-none [&::-webkit-details-marker]:hidden">
                            <span class="text-[11px]"><?= esc($faq['pertanyaan']) ?></span>
                            <span class="material-symbols-outlined text-gray-400 text-sm group-open:rotate-180 transition-transform">expand_more</span>
                        </summary>
                        <p class="mt-2 text-[10px] text-gray-600 leading-relaxed border-t border-gray-50 pt-2">
                            <?= esc($faq['jawaban']) ?>
                        </p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>
