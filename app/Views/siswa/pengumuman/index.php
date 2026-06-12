<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pengumuman
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto pb-12 px-4">
    <!-- Header Section: Serasi dengan halaman sebelumnya -->
    <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-green-700 text-white p-8 rounded-2xl shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold mb-2 flex items-center">
                <span class="bg-white/20 p-2 rounded-lg mr-3">
                    <i class="fas fa-bullhorn"></i>
                </span>
                Pusat Informasi
            </h2>
            <p class="text-emerald-50 opacity-90 font-medium">Dapatkan informasi terbaru mengenai proses pendaftaran dan kegiatan sekolah.</p>
        </div>
        <!-- Dekorasi Lingkaran -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute right-20 bottom-0 w-20 h-20 bg-emerald-400/20 rounded-full blur-xl"></div>
    </div>

    <?php if (empty($announcements)): ?>
        <!-- Empty State: Didesain lebih bersih -->
        <div class="bg-white rounded-2xl shadow-lg border border-emerald-50 p-16 text-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-comment-slash text-gray-300 text-5xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Pengumuman</h3>
            <p class="text-gray-500 max-w-sm mx-auto">Saat ini belum ada informasi atau pengumuman yang dibagikan oleh panitia.</p>
        </div>
    <?php else: ?>
        <!-- Announcements List -->
        <div class="grid grid-cols-1 gap-6">
            <?php foreach ($announcements as $announcement): ?>
                <?php
                    $typeColors = [
                        'general' => 'blue',
                        'ujian' => 'amber',
                        'kelulusan' => 'emerald'
                    ];
                    $typeIcons = [
                        'general' => 'fa-info-circle',
                        'ujian' => 'fa-file-alt',
                        'kelulusan' => 'fa-graduation-cap'
                    ];
                    $color = $typeColors[$announcement['tipe']] ?? 'gray';
                    $icon = $typeIcons[$announcement['tipe']] ?? 'fa-bullhorn';
                ?>
                <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border border-emerald-50 overflow-hidden flex flex-col md:flex-row">
                    <!-- Penanda Warna Samping (Desktop) -->
                    <div class="w-2 md:w-3 bg-<?= $color ?>-500"></div>
                    
                    <div class="flex-1 p-6 md:p-8">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="flex-1">
                                <!-- Badge Tipe -->
                                <div class="mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-<?= $color ?>-50 text-<?= $color ?>-700 border border-<?= $color ?>-100">
                                        <i class="fas <?= $icon ?> mr-2"></i>
                                        <?= ucfirst($announcement['tipe']) ?>
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-emerald-700 transition-colors">
                                    <?= esc($announcement['judul']) ?>
                                </h3>
                                
                                <div class="flex items-center text-sm text-gray-400 mb-6 bg-gray-50 w-fit px-3 py-1 rounded-full">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    <?= date('d F Y', strtotime($announcement['publish_date'])) ?>
                                </div>

                                <!-- Content Isi Pengumuman -->
                                <div class="prose max-w-none text-gray-600 leading-relaxed italic border-l-4 border-gray-100 pl-4 mb-6">
                                    <?php
                                    $content = (string)($announcement['isi_pengumuman'] ?? '');
                                    echo nl2br(esc($content));
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($announcement['lampiran'])): ?>
                            <!-- Attachment Section -->
                            <div class="mt-4 pt-6 border-t border-gray-100 flex items-center justify-between">
                                <p class="text-sm text-gray-400 hidden sm:block">
                                    <i class="fas fa-paperclip mr-1"></i> Lampiran tersedia
                                </p>
                                <a href="<?= base_url('uploads/pengumuman/' . $announcement['lampiran']) ?>"
                                    target="_blank"
                                    class="flex items-center justify-center space-x-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white px-6 py-2.5 rounded-xl font-bold transition-all duration-300 shadow-sm">
                                    <i class="fas fa-file-download"></i>
                                    <span>Unduh Lampiran</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Custom Scrollbar atau style tambahan jika diperlukan */
    .prose {
        color: #4b5563;
        font-size: 1.05rem;
    }
</style>

<?= $this->endSection() ?>