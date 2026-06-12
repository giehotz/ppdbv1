<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Pengumuman Kelulusan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto pb-12 px-4">
    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-emerald-100">
        
        <!-- Header: Diserasikan dengan Status Pendaftaran -->
        <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-green-700 text-white p-8 relative overflow-hidden">
            <div class="relative z-10 text-center">
                <h2 class="text-3xl font-extrabold mb-2 tracking-tight">
                    Pengumuman Kelulusan
                </h2>
                <p class="text-emerald-50 opacity-90 font-medium italic">
                    <?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?>
                </p>
            </div>
            <!-- Dekorasi Lingkaran -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-emerald-400/20 rounded-full blur-xl"></div>
        </div>

        <div class="p-8">
            <?php if (isset($web['pengumuman_aktif']) && $web['pengumuman_aktif'] == 1) : ?>
                
                <?php if ($siswa['status_lulus'] == 'Lulus') : ?>
                    <!-- CASE: LULUS -->
                    <div class="text-center mb-10">
                        <div class="relative inline-block mb-6">
                            <div class="w-28 h-28 bg-emerald-100 rounded-full flex items-center justify-center mx-auto shadow-inner">
                                <i class="fas fa-check text-emerald-600 text-6xl animate-bounce-short"></i>
                            </div>
                            <div class="absolute -right-2 -bottom-2 bg-yellow-400 text-white p-2 rounded-full shadow-lg">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        
                        <h3 class="text-4xl font-black text-gray-800 mb-2 uppercase tracking-tighter">Selamat!</h3>
                        <p class="text-xl text-gray-600 max-w-md mx-auto leading-relaxed">
                            Anda dinyatakan <span class="text-emerald-600 font-bold px-2 py-1 bg-emerald-50 rounded">LULUS</span> seleksi <?= $app_alias ?? 'PPDB' ?>.
                        </p>
                    </div>

                    <!-- Info Detail Siswa (Box Style) -->
                    <div class="bg-gray-50/80 rounded-2xl border border-emerald-100 p-6 mb-8 max-w-lg mx-auto shadow-sm">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Nama Lengkap</span>
                                <span class="font-bold text-gray-800"><?= $siswa['nama_lengkap'] ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">No. Pendaftaran</span>
                                <span class="font-mono font-bold text-emerald-700 bg-white px-2 py-0.5 rounded border border-emerald-100 shadow-sm">
                                    <?= $siswa['no_pendaftaran'] ?>
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">NISN</span>
                                <span class="font-bold text-gray-800 tracking-wider"><?= $siswa['nisn'] ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Lulus -->
                    <div class="text-center space-y-4">
                        <p class="text-gray-500 italic text-sm">Silakan cetak bukti kelulusan ini sebagai syarat daftar ulang.</p>
                        <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" class="group inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-10 rounded-xl transition duration-300 shadow-lg shadow-emerald-200">
                            <i class="fas fa-print mr-3 group-hover:scale-110 transition-transform"></i> 
                            Cetak Bukti Kelulusan
                        </a>
                    </div>

                <?php elseif ($siswa['status_lulus'] == 'Tidak Lulus') : ?>
                    <!-- CASE: TIDAK LULUS -->
                    <div class="text-center py-10">
                        <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-red-100 shadow-sm">
                            <i class="fas fa-times text-red-500 text-5xl"></i>
                        </div>
                        <h3 class="text-3xl font-extrabold text-gray-800 mb-3 uppercase">Mohon Maaf</h3>
                        <p class="text-lg text-gray-600 max-w-md mx-auto leading-relaxed">
                            Anda dinyatakan <span class="font-bold text-red-600">TIDAK LULUS</span> seleksi <?= $app_alias ?? 'PPDB' ?>.
                        </p>
                        <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100 inline-block">
                            <p class="text-gray-500 font-medium">Tetap semangat dan jangan pernah putus asa!</p>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- CASE: DALAM PROSES -->
                    <div class="text-center py-10">
                        <div class="w-24 h-24 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-amber-100 shadow-sm">
                            <i class="fas fa-hourglass-half text-amber-500 text-5xl animate-pulse"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2 uppercase">Dalam Proses</h3>
                        <p class="text-gray-600 mb-6 font-medium">Status kelulusan Anda sedang dalam tahap finalisasi oleh Panitia.</p>
                        
                        <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                            <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-100 inline-block">
                                <p class="text-sm text-amber-800">Harap cek kembali pada tanggal:</p>
                                <p class="text-lg font-bold text-amber-900"><?= date('d F Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Footer Info (Timestamp) -->
                <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <div class="mt-12 pt-6 border-t border-gray-100 text-center">
                        <span class="inline-flex items-center text-xs font-semibold text-gray-400 bg-gray-50 px-3 py-1.5 rounded-full uppercase tracking-widest">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Diumumkan: <?= date('d M Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB
                        </span>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <!-- CASE: BELUM AKTIF -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-blue-100 shadow-sm">
                        <i class="fas fa-bullhorn text-blue-500 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 uppercase">Belum Diumumkan</h3>
                    <p class="text-gray-600 max-w-sm mx-auto mb-8 font-medium">
                        Sabar ya! Hasil seleksi <?= $app_alias ?? 'PPDB' ?> saat ini belum dipublikasikan oleh panitia.
                    </p>
                    
                    <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                        <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg shadow-blue-100 inline-block">
                            <div class="relative z-10 flex items-center space-x-4">
                                <div class="bg-white/20 p-3 rounded-xl">
                                    <i class="fas fa-calendar-check text-2xl"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs uppercase font-bold opacity-80 tracking-tighter">Jadwal Pengumuman</p>
                                    <p class="text-xl font-black"><?= date('d F Y', strtotime($web['tgl_pengumuman'])) ?></p>
                                    <p class="text-sm font-medium opacity-90">Pukul <?= date('H:i', strtotime($web['tgl_pengumuman'])) ?> WIB</p>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <p class="text-gray-400 italic text-sm">Pantau terus akun Anda atau website resmi sekolah.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tombol Kembali yang Seragam -->
        <div class="bg-gray-50 p-6 border-t border-gray-100">
            <a href="<?= base_url('siswa/dashboard') ?>" class="flex items-center justify-center text-gray-600 hover:text-emerald-700 font-bold py-2 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes bounce-short {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    .animate-bounce-short {
        animation: bounce-short 1s ease-in-out infinite;
    }
</style>

<?= $this->endSection() ?>