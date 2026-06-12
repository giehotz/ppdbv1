<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('page_title') ?> Dashboard <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="relative overflow-hidden bg-slate-900 rounded-2xl shadow-2xl mb-8 group">
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-blue-500 rounded-full opacity-10 blur-3xl transition-transform duration-700 group-hover:scale-110"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-48 h-48 bg-indigo-500 rounded-full opacity-10 blur-3xl"></div>

    <div class="relative p-8 md:p-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <div class="hidden sm:flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white text-3xl font-bold shadow-lg">
                <?= esc(substr($siswa['nama_lengkap'], 0, 1)) ?>
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                    Halo, <?= esc($siswa['nama_lengkap']) ?>! 👋
                </h3>
                <div class="flex flex-wrap gap-3 text-slate-300 text-sm">
                    <span class="flex items-center gap-1.5 bg-slate-800 px-3 py-1 rounded-full border border-slate-700">
                        <i class="fas fa-id-badge text-blue-400"></i> <?= $siswa['no_pendaftaran'] ?>
                    </span>
                    <span class="flex items-center gap-1.5 bg-slate-800 px-3 py-1 rounded-full border border-slate-700">
                        <i class="fas fa-fingerprint text-blue-400"></i> NISN: <?= $siswa['nisn'] ?>
                    </span>
                </div>
                
                <?php if (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1 && !empty($web['link_grup_wa'])) : ?>
                    <div class="mt-4">
                        <p class="text-slate-400 text-xs mb-2 italic">Untuk mengetahui info lebih lanjut silahkan bergabung di grup WhatsApp:</p>
                        <a href="<?= esc($web['link_grup_wa']) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-green-500/30 transform hover:-translate-y-0.5">
                            <i class="fab fa-whatsapp text-lg"></i> Bergabung Grup WA
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full md:w-auto">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center min-w-[200px]">
                <p class="text-xs text-slate-400 uppercase tracking-[0.2em] font-bold mb-3">Hasil Seleksi</p>
                <?php if ($siswa['status_lulus'] == 'Lulus') : ?>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-400 font-bold text-lg mb-3 border border-emerald-500/30">
                        <i class="fas fa-check-circle"></i> LULUS
                    </div>
                    <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" class="block w-full py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-bold transition-all transform hover:scale-105 active:scale-95">
                        <i class="fas fa-print mr-2"></i>Cetak Pengumuman
                    </a>
                <?php elseif ($siswa['status_lulus'] == 'Tidak Lulus') : ?>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-500/20 text-rose-400 font-bold text-lg border border-rose-500/30">
                        <i class="fas fa-times-circle"></i> TIDAK LULUS
                    </span>
                <?php else : ?>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/20 text-amber-400 font-bold text-lg border border-amber-500/30">
                        <i class="fas fa-clock"></i> PROSES SELEKSI
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl">
                <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Status Verifikasi</p>
                <div class="mt-1">
                    <?php if ($siswa['status_verifikasi'] == 'Terverifikasi') : ?>
                        <span class="text-emerald-600 font-bold flex items-center gap-1.5"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                    <?php elseif ($siswa['status_verifikasi'] == 'Ditolak') : ?>
                        <span class="text-rose-600 font-bold flex items-center gap-1.5"><i class="fas fa-times-circle"></i> Data Ditolak</span>
                    <?php else : ?>
                        <span class="text-amber-600 font-bold flex items-center gap-1.5"><i class="fas fa-hourglass-half"></i> Menunggu Antrean</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative group">
        <div class="flex items-center gap-4 mb-4">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                <i class="fas fa-chart-pie text-2xl"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-slate-500">Kelengkapan Data</p>
                <p class="text-xl font-black text-slate-800"><?= $completionPercentage ?>%</p>
            </div>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
            <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: <?= $completionPercentage ?>%"></div>
        </div>

        <div class="invisible group-hover:visible absolute inset-x-0 -bottom-2 translate-y-full z-20 pt-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
            <div class="bg-slate-800 text-white text-xs p-4 rounded-xl shadow-xl border border-slate-700">
                <?php if (!empty($incompleteFields)): ?>
                    <p class="font-bold text-amber-400 mb-2">Perlu dilengkapi:</p>
                    <ul class="grid grid-cols-1 gap-1">
                        <?php foreach ($incompleteFields as $field): ?>
                            <li class="flex items-center gap-2 italic opacity-80 uppercase text-[10px]">
                                <div class="w-1 h-1 bg-amber-400 rounded-full"></div> <?= $field ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="flex items-center gap-2 font-bold text-emerald-400">
                        <i class="fas fa-check-double"></i> Data sudah sempurna!
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Terdaftar Pada</p>
                <p class="text-lg font-bold text-slate-800">
                    <?= $siswa['tgl_siswa'] ? date('d M Y', strtotime($siswa['tgl_siswa'])) : '-' ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mb-8">
    <h4 class="text-slate-800 font-extrabold text-lg mb-4 flex items-center gap-2">
        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
        Menu Utama
    </h4>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <?php 
        $menus = [
            ['url' => 'siswa/biodata', 'icon' => 'fa-user-edit', 'label' => 'Biodata', 'color' => 'blue'],
            ['url' => 'siswa/berkas', 'icon' => 'fa-file-upload', 'label' => 'Berkas', 'color' => 'emerald'],
            ['url' => 'siswa/cetak-formulir', 'icon' => 'fa-file-pdf', 'label' => 'Cetak PDF', 'color' => 'rose'],
            ['url' => 'siswa/status', 'icon' => 'fa-clipboard-check', 'label' => 'Cek Status', 'color' => 'amber'],
            ['url' => 'siswa/pengumuman', 'icon' => 'fa-bullhorn', 'label' => 'Info', 'color' => 'violet'],
        ];
        foreach ($menus as $menu) : 
            $isCetak = ($menu['label'] == 'Cetak PDF');
            $url = base_url($menu['url']);
            $target = $isCetak ? 'target="_blank"' : '';
            $onClick = '';
            
            if ($isCetak && isset($completionPercentage) && $completionPercentage < 100) {
                $url = '#';
                $target = '';
                $onClick = 'onclick="alert(\'Silahkan lengkapi biodata untuk mencetak\'); return false;"';
            }
        ?>
        <a href="<?= $url ?>" 
           <?= $target ?> <?= $onClick ?>
           class="group bg-white border border-slate-100 p-5 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-xl bg-<?= $menu['color'] ?>-50 text-<?= $menu['color'] ?>-600 group-hover:bg-<?= $menu['color'] ?>-600 group-hover:text-white transition-colors duration-300">
                <i class="fas <?= $menu['icon'] ?> text-xl"></i>
            </div>
            <p class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors"><?= $menu['label'] ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <i class="fas fa-lightbulb text-amber-500"></i> Informasi Penting
        </h3>
    </div>
    <div class="p-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="flex gap-4 items-start p-4 rounded-xl bg-blue-50/50">
                <div class="text-blue-600"><i class="fas fa-info-circle text-lg"></i></div>
                <p class="text-sm text-slate-600 leading-relaxed">Pastikan data biodata Anda sudah **lengkap dan benar** sebelum divalidasi oleh admin.</p>
            </div>
            <div class="flex gap-4 items-start p-4 rounded-xl bg-blue-50/50">
                <div class="text-blue-600"><i class="fas fa-info-circle text-lg"></i></div>
                <p class="text-sm text-slate-600 leading-relaxed">Upload berkas wajib menggunakan format **PDF/JPG** dengan ukuran maksimal 2MB.</p>
            </div>
            <div class="flex gap-4 items-start p-4 rounded-xl bg-blue-50/50">
                <div class="text-blue-600"><i class="fas fa-info-circle text-lg"></i></div>
                <p class="text-sm text-slate-600 leading-relaxed">Cek status verifikasi dan pengumuman secara berkala di halaman dashboard ini.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>