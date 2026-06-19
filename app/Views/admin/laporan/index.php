<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Laporan & Analisis
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Laporan & Analisis Data Pendaftar
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Analisis Data PPDB</h2>
        <p class="text-sm text-gray-500 mt-1">Rangkuman statistik seluruh data calon siswa yang terdaftar dalam sistem.</p>
    </div>
    <div>
        <a href="<?= base_url('admin/laporan/cetak') ?>" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-5 rounded-lg shadow-sm transition duration-200 flex items-center">
            <i class="fas fa-print mr-2"></i> Cetak Laporan PDF
        </a>
    </div>
</div>

<!-- Grid Ringkasan Utama -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 font-medium">Total Pendaftar</h3>
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600"><i class="fas fa-users"></i></div>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $statistik['total_pendaftar'] ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 font-medium">Terverifikasi</h3>
            <div class="bg-emerald-100 p-2 rounded-lg text-emerald-600"><i class="fas fa-check-circle"></i></div>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $statistik['terverifikasi'] ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 font-medium">Menunggu</h3>
            <div class="bg-amber-100 p-2 rounded-lg text-amber-600"><i class="fas fa-clock"></i></div>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $statistik['menunggu'] ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-gray-500 font-medium">Ditolak</h3>
            <div class="bg-red-100 p-2 rounded-lg text-red-600"><i class="fas fa-times-circle"></i></div>
        </div>
        <p class="text-3xl font-bold text-gray-800"><?= $statistik['ditolak'] ?></p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Demografi Kelamin & Kelulusan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4">Status & Demografi</h3>
        
        <div class="mb-6">
            <p class="text-sm font-medium text-gray-500 mb-2">Jenis Kelamin</p>
            <?php 
                $totalGender = $gender['L'] + $gender['P'];
                $pctL = $totalGender > 0 ? round(($gender['L'] / $totalGender) * 100) : 0;
                $pctP = $totalGender > 0 ? round(($gender['P'] / $totalGender) * 100) : 0;
            ?>
            <div class="flex justify-between text-sm mb-1">
                <span class="text-blue-600 font-bold"><i class="fas fa-mars mr-1"></i> Laki-laki (<?= $gender['L'] ?>)</span>
                <span class="text-pink-600 font-bold">(<?= $gender['P'] ?>) Perempuan <i class="fas fa-venus ml-1"></i></span>
            </div>
            <div class="w-full bg-pink-200 rounded-full h-4 overflow-hidden flex">
                <div class="bg-blue-500 h-4" style="width: <?= $pctL ?>%"></div>
                <div class="bg-pink-500 h-4" style="width: <?= $pctP ?>%"></div>
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span><?= $pctL ?>%</span>
                <span><?= $pctP ?>%</span>
            </div>
        </div>

        <div>
            <p class="text-sm font-medium text-gray-500 mb-2">Status Kelulusan</p>
            <div class="flex gap-4">
                <div class="flex-1 bg-emerald-50 rounded-lg p-3 text-center border border-emerald-100">
                    <p class="text-2xl font-bold text-emerald-600"><?= $kelulusan['lulus'] ?></p>
                    <p class="text-xs text-emerald-800 uppercase tracking-wide">Lulus</p>
                </div>
                <div class="flex-1 bg-red-50 rounded-lg p-3 text-center border border-red-100">
                    <p class="text-2xl font-bold text-red-600"><?= $kelulusan['tidak_lulus'] ?></p>
                    <p class="text-xs text-red-800 uppercase tracking-wide">Tidak Lulus</p>
                </div>
                <div class="flex-1 bg-gray-50 rounded-lg p-3 text-center border border-gray-200">
                    <p class="text-2xl font-bold text-gray-600"><?= $kelulusan['belum_diproses'] ?></p>
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Belum Diproses</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jalur Pendaftaran -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4">Jalur Pendaftaran</h3>
        <div class="space-y-4">
            <?php if(empty($jalur)): ?>
                <p class="text-sm text-gray-500 text-center py-4">Belum ada data jalur pendaftaran.</p>
            <?php else: ?>
                <?php foreach($jalur as $name => $count): 
                    $pct = $statistik['total_pendaftar'] > 0 ? round(($count / $statistik['total_pendaftar']) * 100) : 0;
                ?>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700"><?= $name ?></span>
                        <span class="text-gray-500"><?= $count ?> Pendaftar (<?= $pct ?>%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-purple-500 h-2.5 rounded-full" style="width: <?= $pct ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Top 5 Asal Sekolah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4"><i class="fas fa-school text-gray-400 mr-2"></i> Top 5 Asal Sekolah</h3>
        <?php if(empty($topSekolah)): ?>
            <p class="text-sm text-gray-500 text-center py-4">Belum ada data asal sekolah.</p>
        <?php else: ?>
            <ul class="divide-y divide-gray-100">
                <?php foreach($topSekolah as $index => $sekolah): ?>
                <li class="py-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold mr-3"><?= $index + 1 ?></span>
                        <span class="font-medium text-gray-800 text-sm"><?= strtoupper($sekolah['nama_sekolah']) ?></span>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold"><?= $sekolah['total'] ?> Siswa</span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Top 5 Sebaran Wilayah (Kecamatan) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4"><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i> Top 5 Sebaran Kecamatan</h3>
        <?php if(empty($topWilayah)): ?>
            <p class="text-sm text-gray-500 text-center py-4">Belum ada data wilayah.</p>
        <?php else: ?>
            <ul class="divide-y divide-gray-100">
                <?php foreach($topWilayah as $index => $wilayah): ?>
                <li class="py-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold mr-3"><?= $index + 1 ?></span>
                        <span class="font-medium text-gray-800 text-sm"><?= ucwords(strtolower($wilayah['kec'])) ?></span>
                    </div>
                    <span class="bg-blue-50 text-blue-700 py-1 px-3 rounded-full text-xs font-bold"><?= $wilayah['total'] ?> Pendaftar</span>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
