<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Status Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Status Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto pb-10">
    <!-- Status Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-emerald-100">
        <!-- Header dengan Gradasi Hijau Cerah -->
        <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-green-700 text-white p-8 relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold mb-2 flex items-center">
                    <span class="bg-white/20 p-2 rounded-lg mr-3">
                        <i class="fas fa-clipboard-check"></i>
                    </span>
                    Status Pendaftaran
                </h2>
                <p class="text-emerald-50 opacity-90 font-medium">Pantau terus perkembangan pengajuan pendaftaran PPDB Anda</p>
            </div>
            <!-- Dekorasi Lingkaran -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-20 bottom-0 w-20 h-20 bg-emerald-400/20 rounded-full blur-xl"></div>
        </div>

        <div class="p-8">
            <!-- Status Visual Utama -->
            <div class="relative mb-10 text-center p-8 bg-<?= $statusInfo['color'] ?>-50 rounded-2xl border-2 border-dashed border-<?= $statusInfo['color'] ?>-200">
                <div class="inline-flex items-center justify-center w-24 h-24 mb-4 bg-white rounded-full shadow-sm">
                    <i class="fas <?= $statusInfo['icon'] ?> text-5xl text-<?= $statusInfo['color'] ?>-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                    <?= $statusInfo['text'] ?>
                </h3>
                <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                    <?= $statusInfo['description'] ?>
                </p>
            </div>

            <!-- Catatan Penolakan (Jika ada) -->
            <?php if ($siswa['status_verifikasi'] == 'rejected' && !empty($siswa['catatan_verifikasi'])): ?>
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-5 rounded-r-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-bold text-red-800 uppercase tracking-wider mb-1">Catatan Perbaikan dari Admin:</h4>
                            <p class="text-red-700 font-medium italic">"<?= $siswa['catatan_verifikasi'] ?>"</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Grid Informasi Siswa -->
            <div class="space-y-6">
                <div class="flex items-center space-x-2 border-b border-emerald-100 pb-2">
                    <i class="fas fa-id-card text-emerald-600"></i>
                    <h4 class="text-lg font-bold text-gray-800">Detail Data Pendaftar</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">NISN</p>
                        <p class="font-semibold text-gray-800 tracking-wide"><?= $siswa['nisn'] ?? '-' ?></p>
                    </div>

                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">NIK</p>
                        <p class="font-semibold text-gray-800 tracking-wide"><?= $siswa['nik'] ?? '-' ?></p>
                    </div>

                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 md:col-span-2 hover:border-emerald-200 transition-colors">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">Nama Lengkap</p>
                        <p class="font-bold text-gray-800 text-lg"><?= $siswa['nama_lengkap'] ?? '-' ?></p>
                    </div>

                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">Jenis Kelamin</p>
                        <div class="flex items-center space-x-2">
                             <i class="fas <?= ($siswa['jk'] ?? '') == 'L' ? 'fa-mars text-blue-500' : 'fa-venus text-pink-500' ?>"></i>
                             <p class="font-semibold text-gray-800">
                                <?= ($siswa['jk'] ?? '') == 'L' ? 'Laki-laki' : (($siswa['jk'] ?? '') == 'P' ? 'Perempuan' : '-') ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-xs font-bold text-emerald-600 uppercase mb-1">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800">
                            <?= ($siswa['tempat_lahir'] ?? '-') . ', ' . ($siswa['tgl_lahir'] ? date('d/m/Y', strtotime($siswa['tgl_lahir'])) : '-') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 pt-8 border-t border-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="<?= base_url('siswa/biodata') ?>" class="group flex items-center justify-center bg-white border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-bold py-3.5 px-6 rounded-xl transition duration-300 shadow-sm">
                        <i class="fas fa-user-edit mr-2 group-hover:scale-110 transition-transform"></i>
                        Biodata Lengkap
                    </a>

                    <a href="<?= base_url('siswa/berkas') ?>" class="group flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-6 rounded-xl transition duration-300 shadow-md shadow-emerald-200">
                        <i class="fas fa-file-upload mr-2 group-hover:bounce transition-transform"></i>
                        Upload Dokumen
                    </a>
                </div>

                <div class="mt-4">
                    <?php
                        $url = base_url('siswa/cetak-formulir');
                        $target = 'target="_blank"';
                        $onClick = '';
                        
                        if (isset($completionPercentage) && $completionPercentage < 100) {
                            $url = '#';
                            $target = '';
                            $onClick = 'onclick="alert(\'Silahkan lengkapi biodata untuk mencetak\'); return false;"';
                        }
                    ?>
                    <a href="<?= $url ?>" <?= $target ?> <?= $onClick ?> class="group flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl transition duration-300 shadow-md shadow-blue-200">
                        <i class="fas fa-print mr-2 group-hover:scale-110 transition-transform"></i>
                        Cetak Formulir Pendaftaran
                    </a>
                </div>

                <div class="mt-4">
                    <a href="<?= base_url('siswa/dashboard') ?>" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-3 px-6 rounded-xl transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Beranda Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .group-hover\:bounce {
        animation: bounce 0.5s infinite;
    }
</style>

<?= $this->endSection() ?>