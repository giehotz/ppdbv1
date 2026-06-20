<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>
Kelulusan
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Hasil Kelulusan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 mb-6 overflow-hidden">
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 p-5 text-center">
        <h2 class="text-base font-bold text-white uppercase tracking-wider">Pengumuman Kelulusan</h2>
        <p class="text-[10px] text-emerald-100/80"><?= $app_alias ?? 'PPDB' ?></p>
    </div>

    <div class="p-5 text-center">
        <?php if (isset($web['pengumuman_aktif']) && $web['pengumuman_aktif'] == 1) : ?>
            <?php if ($siswa['status_lulus'] == 'Lulus') : ?>
                <div class="mb-5">
                    <div class="w-20 h-20 bg-emerald-100/80 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-emerald-200/50">
                        <i class="fas fa-check text-emerald-500 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 mb-1">LULUS!</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Selamat! Anda telah lolos seleksi.</p>
                </div>

                <div class="bg-slate-50/60 backdrop-blur-sm rounded-xl p-4 mb-5 text-left border border-slate-200/50">
                    <div class="flex justify-between items-center py-2 border-b border-slate-200/50">
                        <span class="text-[10px] text-slate-500">Nama Lengkap</span>
                        <span class="text-xs font-bold text-slate-800"><?= $siswa['nama_lengkap'] ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-200/50">
                        <span class="text-[10px] text-slate-500">No. Daftar</span>
                        <span class="text-xs font-mono font-bold text-slate-800"><?= $siswa['no_pendaftaran'] ?></span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-[10px] text-slate-500">NISN</span>
                        <span class="text-xs font-bold text-slate-800"><?= $siswa['nisn'] ?></span>
                    </div>
                </div>

                <a href="<?= base_url('siswa/kelulusan/cetak') ?>" target="_blank" class="flex items-center justify-center w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-sm active:scale-[0.97] mb-4">
                    <i class="fas fa-print mr-2"></i> Cetak Bukti Lulus
                </a>
                
                <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <p class="text-[10px] text-slate-400">
                        Diumumkan pada: <?= date('d M Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB
                    </p>
                <?php endif; ?>

            <?php elseif ($siswa['status_lulus'] == 'Tidak Lulus') : ?>
                <div class="py-6">
                    <div class="w-20 h-20 bg-rose-100/80 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-rose-200/50">
                        <i class="fas fa-times text-rose-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 mb-1">TIDAK LULUS</h3>
                    <p class="text-xs text-slate-500 leading-relaxed px-4">Maaf, Anda tidak lolos seleksi. Tetap semangat!</p>
                </div>
                
                <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <p class="text-[10px] text-slate-400 mt-2">
                        Diumumkan pada: <?= date('d M Y, H:i', strtotime($web['tgl_pengumuman'])) ?> WIB
                    </p>
                <?php endif; ?>
                
            <?php else : ?>
                <div class="py-6">
                    <div class="w-16 h-16 bg-amber-100/80 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-amber-200/50">
                        <i class="fas fa-clock text-amber-500 text-2xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-1">DALAM PROSES</h3>
                    <p class="text-xs text-slate-500 leading-relaxed px-4">Status kelulusan Anda sedang diproses.</p>
                    
                    <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                        <p class="text-xs text-slate-500 mt-3">
                            Harap cek pada tanggal:<br>
                            <span class="font-bold text-slate-800"><?= date('m/d/Y h:i A', strtotime($web['tgl_pengumuman'])) ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="py-6">
                <div class="w-16 h-16 bg-amber-100/80 rounded-full flex items-center justify-center mx-auto mb-3 animate-pulse border-2 border-amber-200/50">
                    <i class="fas fa-clock text-amber-500 text-2xl"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">BELUM DIUMUMKAN</h3>
                <p class="text-xs text-slate-500 leading-relaxed px-4 mb-4">Hasil seleksi belum diumumkan oleh panitia.</p>
                
                <?php if(!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] != '0000-00-00 00:00:00') : ?>
                    <div class="bg-blue-50/80 backdrop-blur-sm border border-blue-200/50 text-blue-800 rounded-xl p-3 inline-block">
                        <span class="text-[10px] font-bold uppercase tracking-wider block mb-1">Jadwal Pengumuman:</span>
                        <div class="font-bold text-sm">
                            <?= date('d M Y', strtotime($web['tgl_pengumuman'])) ?> <br>
                            <?= date('H:i', strtotime($web['tgl_pengumuman'])) ?> WIB
                        </div>
                    </div>
                <?php else : ?>
                    <p class="text-xs text-slate-400 mt-2 border-t pt-3 inline-block">
                        Silakan cek kembali secara berkala.
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
