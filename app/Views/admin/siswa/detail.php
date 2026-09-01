<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Detail Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detail Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300 px-5 py-4 rounded-2xl shadow-sm mb-6 flex items-center gap-3 animate-fade-in-down" role="alert">
        <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
            <i class="fas fa-check"></i>
        </div>
        <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<!-- Top Action Bar -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <a href="<?= base_url('admin/siswa') ?>" class="inline-flex items-center text-gray-500 hover:text-gray-800 bg-white border border-gray-200 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white font-medium py-2 px-4 rounded-xl transition-all shadow-sm">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <div class="flex flex-wrap items-center gap-3">
        <a href="<?= base_url('admin/siswa/cetak-kartu/' . $siswa['id_siswa']) ?>" target="_blank" class="inline-flex items-center bg-white text-indigo-600 border border-indigo-200 hover:bg-indigo-50 dark:border-indigo-900/50 dark:bg-indigo-950/40 dark:text-indigo-400 dark:hover:bg-indigo-900/60 font-medium py-2 px-4 rounded-xl transition-all shadow-sm">
            <i class="fas fa-print mr-2"></i> Cetak Kartu
        </a>
        <form action="<?= base_url('admin/siswa/resetPassword/' . $siswa['id_siswa']) ?>" method="post" data-confirm="Yakin ingin mereset password siswa ini? Password baru akan digenerate secara acak." class="inline-block">
            <?= csrf_field() ?>
            <button type="submit" class="inline-flex items-center bg-gray-800 hover:bg-gray-900 text-white dark:bg-gray-700 dark:hover:bg-gray-600 font-medium py-2 px-4 rounded-xl transition-all shadow-sm">
                <i class="fas fa-key mr-2"></i> Reset Password
            </button>
        </form>
    </div>
</div>

<!-- ==========================================
     SECTION 0: HERO PROFILE
=========================================== -->
<div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mb-8">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-8 md:px-10 md:py-8 text-white flex flex-col md:flex-row items-center md:items-start gap-6 relative overflow-hidden">
        <i class="fas fa-graduation-cap absolute -right-10 -top-10 text-9xl text-white opacity-10"></i>
        
        <?php if (!empty($berkasFoto) && !empty($siswa['nisn'])): ?>
            <?php $fotoUrl = base_url('uploads/berkas/' . $siswa['nisn'] . '/' . $berkasFoto['nama_file']); ?>
            <div class="w-24 h-24 rounded-full border-4 border-white/30 flex-shrink-0 shadow-lg overflow-hidden">
                <img src="<?= $fotoUrl ?>" alt="Foto <?= esc($siswa['nama_lengkap']) ?>" class="w-full h-full object-cover">
            </div>
        <?php else: ?>
            <div class="w-24 h-24 rounded-full bg-white/20 border-4 border-white/30 flex items-center justify-center flex-shrink-0 backdrop-blur-sm shadow-lg">
                <i class="fas fa-user text-4xl text-white"></i>
            </div>
        <?php endif; ?>
        
        <div class="text-center md:text-left z-10 flex-1">
            <div class="flex flex-col md:flex-row items-center gap-3 mb-2">
                <h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wide"><?= esc($siswa['nama_lengkap']) ?></h2>
                <?php $statusBadge = $siswa['status_verifikasi'] ?? ''; ?>
                <span class="<?= $statusBadge == 'Terverifikasi' ? 'bg-emerald-500' : ($statusBadge == 'Ditolak' ? 'bg-red-500' : 'bg-amber-500') ?> text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm border border-white/20">
                    <?= esc($statusBadge ?: 'Menunggu') ?>
                </span>
            </div>
            
            <div class="flex flex-wrap justify-center md:justify-start gap-4 text-blue-100 mt-3 text-sm md:text-base">
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-hashtag text-sm"></i> No. Daftar: <span class="font-semibold text-white"><?= esc($siswa['no_pendaftaran']) ?></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-id-card text-sm"></i> NISN: <span class="font-semibold text-white"><?= esc($siswa['nisn'] ?? '-') ?></span>
                </div>
                <?php if (!empty($siswa['nis'])): ?>
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-id-badge text-sm"></i> NIS: <span class="font-semibold text-white"><?= esc($siswa['nis']) ?></span>
                </div>
                <?php endif; ?>
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-map-marker-alt text-sm"></i> Jalur: <span class="font-semibold text-white"><?= esc($siswa['jalur_pendaftaran'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 1: ADMINISTRASI & VERIFIKASI
=========================================== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Info Pendaftaran -->
    <div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden flex flex-col">
        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-3">
            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Informasi Pendaftaran</h3>
        </div>
        <div class="p-6 flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Waktu Mendaftar</p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= $siswa['tgl_siswa'] ? date('d F Y • H:i', strtotime($siswa['tgl_siswa'])) : '-' ?></p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Jalur Masuk</p>
                    <p class="font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg inline-block"><?= esc($siswa['jalur_pendaftaran'] ?? '-') ?></p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pilihan Jurusan / Kompetensi Ahli</p>
                    <p class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['komp_ahli'] ?? '-') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Verifikasi -->
    <div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden flex flex-col">
        <div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 dark:bg-emerald-950/30 dark:border-emerald-900/50 flex items-center gap-3">
            <i class="fas fa-clipboard-check text-emerald-600 text-lg"></i>
            <h3 class="font-bold text-emerald-900 dark:text-emerald-400 text-lg">Panel Verifikasi Berkas</h3>
        </div>
        <div class="p-6 flex-1">
            <form action="<?= base_url('admin/siswa/verify/' . $siswa['id_siswa']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status Pendaftaran</label>
                        <div class="relative">
                            <select name="status" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 dark:bg-gray-900/50 dark:border-gray-800 dark:text-white dark:placeholder-gray-500 rounded-xl focus:ring-2 focus:ring-emerald-500 py-3 px-4 outline-none appearance-none cursor-pointer font-medium">
                                <option value="">-- Pilih Status --</option>
                                <option value="Terverifikasi" <?= $statusBadge == 'Terverifikasi' ? 'selected' : '' ?>>✅ Terverifikasi</option>
                                <option value="Ditolak" <?= $statusBadge == 'Ditolak' ? 'selected' : '' ?>>❌ Ditolak</option>
                                <option value="Menunggu" <?= $statusBadge == 'Menunggu' ? 'selected' : '' ?>>⏳ Menunggu</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 dark:text-gray-400">
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan Verifikasi</label>
                        <textarea name="catatan" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl dark:bg-gray-900/50 dark:border-gray-800 dark:text-white dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 py-2.5 px-4 outline-none resize-none text-sm" placeholder="Catatan untuk siswa..."><?= esc($siswa['catatan_verifikasi'] ?? '') ?></textarea>
                    </div>
                    <div class="sm:col-span-2 mt-2">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition duration-200 shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Status Verifikasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 2: IDENTITAS PRIBADI SISWA
=========================================== -->
<div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mb-8">
    <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-3">
        <i class="fas fa-address-card text-indigo-500 text-lg"></i>
        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Identitas Pribadi Siswa</h3>
    </div>
    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-6 gap-x-8">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">NIK</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nik'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= $siswa['jk'] == 'L' ? 'Laki-laki' : ($siswa['jk'] == 'P' ? 'Perempuan' : '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tempat Lahir</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['tempat_lahir'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= $siswa['tgl_lahir'] ? date('d-m-Y', strtotime($siswa['tgl_lahir'])) : '-' ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Agama</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['agama'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Anak Ke / Saudara</p>
                <p class="font-semibold text-gray-800 dark:text-white">Ke-<?= esc($siswa['anak_ke'] ?? '-') ?> dari <?= esc($siswa['jml_saudara'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status Keluarga</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['status_keluarga'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Hobi / Cita-cita</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['hobi'] ?? '-') ?> / <?= esc($siswa['cita'] ?? '-') ?></p>
            </div>
            
            <div class="col-span-1 md:col-span-2 bg-gray-50/50 p-4 rounded-xl border border-gray-100 dark:bg-gray-800/30 dark:border-gray-800">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kontak Siswa</p>
                <p class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fas fa-phone-alt text-gray-400 dark:text-gray-500 text-sm"></i> <?= esc($siswa['no_hp_siswa'] ?? '-') ?>
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                    <i class="fas fa-envelope text-gray-400 dark:text-gray-500 text-sm"></i> <?= esc($siswa['email'] ?? 'Tidak ada email') ?>
                </p>
            </div>
            
            <div class="col-span-1 md:col-span-2 bg-gray-50/50 p-4 rounded-xl border border-gray-100 dark:bg-gray-800/30 dark:border-gray-800">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nomor Kartu Keluarga (KK)</p>
                <p class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['no_kk'] ?? '-') ?></p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kepala Keluarga: <span class="font-medium text-gray-700 dark:text-gray-300"><?= esc($siswa['kepala_keluarga'] ?? '-') ?></span></p>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 3: ALAMAT TEMPAT TINGGAL
=========================================== -->
<div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mb-8">
    <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-3">
        <i class="fas fa-map-marker-alt text-red-500 text-lg px-1"></i>
        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Alamat & Tempat Tinggal</h3>
    </div>
    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-8">
            <div class="md:col-span-3">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jalan / Detail Alamat</p>
                <p class="font-semibold text-gray-800 dark:text-white text-base leading-relaxed"><?= esc($siswa['alamat_siswa'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Desa / Kelurahan</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['desa'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kecamatan</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['kec'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kabupaten / Kota</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['kab'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Provinsi & Kode Pos</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['prov'] ?? '-') ?> <span class="text-gray-400 dark:text-gray-500 font-normal">(<?= esc($siswa['kode_pos'] ?? '-') ?>)</span></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Tinggal</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['jenis_tinggal'] ?? '-') ?></p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Transportasi & Jarak</p>
                <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['trans'] ?? '-') ?> <span class="text-gray-400 dark:text-gray-500 font-normal">(<?= esc($siswa['jarak'] ?? '-') ?>)</span></p>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 4: DATA ORANG TUA & WALI
=========================================== -->
<div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mb-8">
    <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-users text-amber-500 text-lg"></i>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Data Orang Tua & Wali</h3>
        </div>
        <div class="bg-red-50 text-red-700 px-4 py-1.5 rounded-full border border-red-100 dark:bg-red-950/40 dark:border-red-900/50 dark:text-red-300 flex items-center gap-2">
            <i class="fas fa-phone-alt text-sm"></i>
            <span class="text-xs font-bold uppercase tracking-wide">Kontak Darurat:</span>
            <span class="font-black"><?= esc($siswa['no_hp_ortu'] ?? '-') ?></span>
        </div>
    </div>
    
    <div class="p-6 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-100 dark:divide-gray-800">
            
            <!-- Box Ayah -->
            <div class="lg:pr-8 space-y-4 pt-4 lg:pt-0">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">1</span>
                    <h4 class="font-bold text-gray-800 dark:text-white text-lg">Data Ayah</h4>
                </div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Nama Ayah</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nama_ayah'] ?? '-') ?> <span class="text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-2 py-0.5 rounded ml-2"><?= esc($siswa['status_ayah'] ?? '-') ?></span></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">NIK Ayah</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nik_ayah'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tempat Lahir Ayah</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['tempat_lahir_ayah'] ?? '-') ?></p></div>
                <?php if (!empty($siswa['tgl_lahir_ayah'])): ?>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tanggal Lahir Ayah</p><p class="font-semibold text-gray-800 dark:text-white"><?= date('d-m-Y', strtotime($siswa['tgl_lahir_ayah'])) ?></p></div>
                <?php endif; ?>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tahun Lahir</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['th_lahir_ayah'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pendidikan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pdd_ayah'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pekerjaan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pekerjaan_ayah'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Penghasilan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['penghasilan_ayah'] ?? '-') ?></p></div>
            </div>

            <!-- Box Ibu -->
            <div class="lg:px-8 space-y-4 pt-6 lg:pt-0">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-sm">2</span>
                    <h4 class="font-bold text-gray-800 dark:text-white text-lg">Data Ibu</h4>
                </div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Nama Ibu</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nama_ibu'] ?? '-') ?> <span class="text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-2 py-0.5 rounded ml-2"><?= esc($siswa['status_ibu'] ?? '-') ?></span></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">NIK Ibu</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nik_ibu'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tempat Lahir Ibu</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['tempat_lahir_ibu'] ?? '-') ?></p></div>
                <?php if (!empty($siswa['tgl_lahir_ibu'])): ?>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tanggal Lahir Ibu</p><p class="font-semibold text-gray-800 dark:text-white"><?= date('d-m-Y', strtotime($siswa['tgl_lahir_ibu'])) ?></p></div>
                <?php endif; ?>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tahun Lahir</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['th_lahir_ibu'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pendidikan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pdd_ibu'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pekerjaan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pekerjaan_ibu'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Penghasilan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['penghasilan_ibu'] ?? '-') ?></p></div>
            </div>

            <!-- Box Wali -->
            <div class="lg:pl-8 space-y-4 pt-6 lg:pt-0">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-sm">3</span>
                    <h4 class="font-bold text-gray-800 dark:text-white text-lg flex items-center gap-2">Data Wali <span class="text-xs font-normal text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">(Opsional)</span></h4>
                </div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Nama Wali</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nama_wali'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">NIK Wali</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['nik_wali'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Tahun Lahir</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['th_lahir_wali'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pendidikan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pdd_wali'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Pekerjaan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['pekerjaan_wali'] ?? '-') ?></p></div>
                <div><p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-1">Penghasilan</p><p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['penghasilan_wali'] ?? '-') ?></p></div>
            </div>

        </div>
    </div>
</div>

<!-- ==========================================
     SECTION 5: SEKOLAH ASAL & KESEJAHTERAAN
=========================================== -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Info Sekolah Asal -->
    <div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-3">
            <i class="fas fa-school text-purple-500 text-lg"></i>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Sekolah Asal</h3>
        </div>
        <div class="p-6">
            <div class="space-y-5">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Sekolah (NPSN)</p>
                    <p class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['nama_sekolah'] ?? '-') ?> <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-1">(<?= esc($siswa['npsn_sekolah'] ?? '-') ?>)</span></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenjang</p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['jenjang_sekolah'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status</p>
                        <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['status_sekolah'] ?? '-') ?></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Lokasi / Kabupaten Sekolah</p>
                    <p class="font-semibold text-gray-800 dark:text-white"><?= esc($siswa['lokasi_sekolah'] ?? '-') ?></p>
                </div>
                <div class="bg-gray-50/50 border border-gray-100 p-3 rounded-lg dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-2">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Riwayat PAUD/TK:</p>
                    <span class="text-sm font-semibold text-gray-800 dark:text-white bg-white px-2 py-0.5 rounded border border-gray-200 dark:bg-gray-800 dark:border-gray-700">PAUD: <?= esc($siswa['paud'] ?? '-') ?></span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-white bg-white px-2 py-0.5 rounded border border-gray-200 dark:bg-gray-800 dark:border-gray-700">TK: <?= esc($siswa['tk'] ?? '-') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Kesejahteraan -->
    <div class="bg-white rounded-2xl shadow-theme-xs border border-gray-200 dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 dark:bg-gray-800/30 dark:border-gray-800 flex items-center gap-3">
            <i class="fas fa-wallet text-amber-500 text-lg"></i>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Program Kesejahteraan</h3>
        </div>
        <div class="p-6 flex flex-col justify-center h-full">
            <div class="space-y-4">
                <div class="flex items-center justify-between bg-gray-50/50 border border-gray-100 p-4 rounded-xl dark:bg-gray-800/30 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-white dark:bg-gray-800 p-2 rounded shadow-theme-xs"><i class="fas fa-credit-card text-gray-400 dark:text-gray-500"></i></div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. KKS</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Kartu Keluarga Sejahtera</p>
                        </div>
                    </div>
                    <span class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['no_kks'] ?: '-') ?></span>
                </div>
                
                <div class="flex items-center justify-between bg-gray-50/50 border border-gray-100 p-4 rounded-xl dark:bg-gray-800/30 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-white dark:bg-gray-800 p-2 rounded shadow-theme-xs"><i class="fas fa-hands-helping text-gray-400 dark:text-gray-500"></i></div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. PKH</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Program Keluarga Harapan</p>
                        </div>
                    </div>
                    <span class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['no_pkh'] ?: '-') ?></span>
                </div>
                
                <div class="flex items-center justify-between bg-gray-50/50 border border-gray-100 p-4 rounded-xl dark:bg-gray-800/30 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="bg-white dark:bg-gray-800 p-2 rounded shadow-theme-xs"><i class="fas fa-book-reader text-gray-400 dark:text-gray-500"></i></div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. KIP</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Kartu Indonesia Pintar</p>
                        </div>
                    </div>
                    <span class="font-bold text-gray-800 dark:text-white text-lg"><?= esc($siswa['no_kip'] ?: '-') ?></span>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>