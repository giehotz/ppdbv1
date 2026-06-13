<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Verifikasi Data') ?></title>

    <?php
    $page_title = $title ?? 'Verifikasi Data';
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .verified-badge {
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border-t-4 <?= $status === 'success' ? 'border-green-500' : 'border-red-500' ?> overflow-hidden">
        
        <div class="p-6 text-center">
            <?php if ($status === 'success'): ?>
                <!-- SUCCESS STATE -->
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4 verified-badge">
                    <i class="fas fa-check-circle text-4xl text-green-500"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-1">DATA VALID</h2>
                <p class="text-gray-500 text-sm mb-6">Tercatat Resmi di Sistem <?= esc($instansi['nama_instansi'] ?? 'Sekolah') ?></p>
                
                <div class="mb-6">
                    <?php if (!empty($siswa['foto_berkas'])): ?>
                        <div class="w-24 h-32 mx-auto rounded overflow-hidden shadow-md mb-4 border-2 border-green-500">
                            <img src="<?= base_url(esc($siswa['foto_berkas'])) ?>" alt="Pas Foto Siswa" class="w-full h-full object-cover">
                        </div>
                    <?php elseif (!empty($siswa['foto'])): ?>
                        <div class="w-24 h-32 mx-auto rounded overflow-hidden shadow-md mb-4 border-2 border-green-500">
                            <img src="<?= base_url('uploads/berkas/' . esc($siswa['nisn']) . '/' . esc($siswa['foto'])) ?>" alt="Foto Database" class="w-full h-full object-cover">
                        </div>
                    <?php else: ?>
                        <div class="w-24 h-32 mx-auto rounded bg-gray-200 flex items-center justify-center mb-4 border-2 border-gray-300">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama_lengkap'] ?? 'S') ?>&background=1e3a8a&color=fff&size=128" alt="Placeholder" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="text-xl font-bold text-gray-800"><?= esc($siswa['nama_lengkap']) ?></h3>
                    <p class="text-green-600 font-semibold mb-2"><?= esc($siswa['no_pendaftaran']) ?></p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4 text-left shadow-inner text-sm space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">NISN</span>
                        <span class="font-semibold text-gray-800"><?= esc($siswa['nisn'] ?? '-') ?></span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Kelulusan</span>
                        <?php if ($siswa['status_lulus'] === 'Lulus'): ?>
                            <span class="font-bold text-green-600 px-2 bg-green-100 rounded-md">LULUS</span>
                        <?php elseif ($siswa['status_lulus'] === 'Tidak Lulus'): ?>
                            <span class="font-bold text-red-600 px-2 bg-red-100 rounded-md">TIDAK LULUS</span>
                        <?php else: ?>
                            <span class="font-bold text-yellow-600 px-2 bg-yellow-100 rounded-md">PROSES SELEKSI</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Asal Sekolah</span>
                        <span class="font-semibold text-gray-800 text-right max-w-[60%]"><?= esc($siswa['nama_sekolah'] ?? '-') ?></span>
                    </div>
                </div>

            <?php else: ?>
                <!-- ERROR STATE -->
                <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-times-circle text-4xl text-red-500"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 mb-2">TIDAK VALID</h2>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-600 text-sm"><?= esc($message ?? 'Data tidak ditemukan.') ?></p>
                </div>
                <p class="text-gray-500 text-xs mb-4">Mohon waspada terhadap pemalsuan kartu Bukti Pendaftaran / Kartu Peserta.</p>
            <?php endif; ?>
        </div>
        
        <div class="bg-gray-50 px-6 py-4 border-t text-center">
            <a href="<?= base_url() ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                <i class="fas fa-home mr-1"></i> Kembali ke Beranda
            </a>
        </div>
        
    </div>

</body>
</html>
