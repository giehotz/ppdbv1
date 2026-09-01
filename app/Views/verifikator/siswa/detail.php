<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Detail Siswa - <?= esc($siswa['nama_lengkap']) ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">person</span> Detail Calon Siswa &amp; Verifikasi
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header Bar -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="<?= base_url('verifikator/siswa') ?>" class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-all">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        <span>Kembali</span>
    </a>

    <div class="flex flex-wrap items-center gap-2.5">
        <!-- Edit Biodata -->
        <a href="<?= base_url('verifikator/siswa/biodata/' . $siswa['id_siswa']) ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-blue-700 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">edit_document</span>
            <span>Edit Biodata &amp; Berkas</span>
        </a>

        <!-- Cetak Formulir -->
        <a href="<?= base_url('verifikator/siswa/cetak/' . $siswa['id_siswa']) ?>" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">print</span>
            <span>Cetak Formulir</span>
        </a>

        <!-- Pembiayaan -->
        <a href="<?= base_url('verifikator/pembiayaan/siswa/' . $siswa['id_siswa']) ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-amber-600 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">payments</span>
            <span>Pembiayaan</span>
        </a>

        <!-- Hapus Siswa -->
        <form action="<?= base_url('verifikator/siswa/delete/' . $siswa['id_siswa']) ?>" method="post" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini secara permanen? Seluruh berkas dan data pendaftaran akan terhapus!');">
            <?= csrf_field() ?>
            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-red-500 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-red-600 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">delete</span>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <!-- Bagian Kiri (Lebar 2 Kolom) -->
    <div class="xl:col-span-2 space-y-6">

        <!-- A. Data Pribadi -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                        <span class="material-symbols-outlined text-lg">badge</span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">A. Data Pribadi Calon Siswa</h3>
                </div>
                <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 font-mono text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <?= esc($siswa['no_pendaftaran']) ?>
                </span>
            </div>
            
            <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Nama Lengkap</span>
                    <span class="font-bold text-gray-900 dark:text-white text-sm block"><?= esc($siswa['nama_lengkap']) ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">NISN</span>
                    <span class="font-mono font-bold text-gray-800 dark:text-gray-200 text-sm block"><?= esc($siswa['nisn'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">NIK (KTP/KIA)</span>
                    <span class="font-mono text-gray-800 dark:text-gray-200 block"><?= esc($siswa['nik'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Jenis Kelamin</span>
                    <span class="font-semibold text-gray-800 dark:text-gray-200 block">
                        <?= $siswa['jk'] == 'L' ? 'Laki-laki' : ($siswa['jk'] == 'P' ? 'Perempuan' : '-') ?>
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Tempat, Tanggal Lahir</span>
                    <span class="text-gray-800 dark:text-gray-200 block">
                        <?= esc($siswa['tempat_lahir'] ?? '' ?: '-') ?>, 
                        <?= (!empty($siswa['tgl_lahir']) && strtotime($siswa['tgl_lahir'])) ? date('d F Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Agama</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['agama'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">No. HP / WhatsApp Siswa</span>
                    <span class="text-gray-800 dark:text-gray-200 font-mono block"><?= esc($siswa['no_hp_siswa'] ?? '' ?: '-') ?></span>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500"><?= esc($siswa['email'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Status Dalam Keluarga</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['status_keluarga'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Anak Ke / Jumlah Saudara</span>
                    <span class="text-gray-800 dark:text-gray-200 block">
                        Anak ke-<?= esc($siswa['anak_ke'] ?? '' ?: '-') ?> dari <?= esc($siswa['jml_saudara'] ?? '' ?: '-') ?> bersaudara
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Hobi &amp; Cita-cita</span>
                    <span class="text-gray-800 dark:text-gray-200 block">
                        <?= esc($siswa['hobi'] ?? '' ?: '-') ?> / <?= esc($siswa['cita'] ?? '' ?: '-') ?>
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">No. Kartu Keluarga (KK)</span>
                    <span class="font-mono text-gray-800 dark:text-gray-200 block"><?= esc($siswa['no_kk'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kepala Keluarga</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kepala_keluarga'] ?? '' ?: '-') ?></span>
                </div>
            </div>
        </div>

        <!-- B. Data Alamat -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-lg">location_on</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">B. Alamat Tempat Tinggal</h3>
            </div>
            
            <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div class="sm:col-span-2">
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Alamat Lengkap</span>
                    <p class="text-gray-800 dark:text-gray-200 font-medium leading-relaxed"><?= esc($siswa['alamat_siswa'] ?? '' ?: '-') ?></p>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Desa / Kelurahan</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['desa'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kecamatan</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kec'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kabupaten / Kota</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kab'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Provinsi &amp; Kode Pos</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['prov'] ?? '' ?: '-') ?> (<?= esc($siswa['kode_pos'] ?? '' ?: '-') ?>)</span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Jenis Tempat Tinggal</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['jenis_tinggal'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Transportasi / Jarak</span>
                    <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['trans'] ?? '' ?: '-') ?> (<?= esc($siswa['jarak'] ?? '' ?: '-') ?>)</span>
                </div>
            </div>
        </div>

        <!-- C. Data Orang Tua & Wali -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                    <span class="material-symbols-outlined text-lg">family_restroom</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">C. Data Orang Tua &amp; Wali</h3>
            </div>

            <div class="p-5 md:p-6 space-y-6 text-xs">
                <!-- Ayah -->
                <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                    <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined text-base">man</span>
                        <span>Data Ayah Kandung</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div><span class="text-gray-400 block text-[10px] uppercase">Nama Ayah</span><span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_ayah'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Status</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['status_ayah'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">NIK Ayah</span><span class="font-mono text-gray-800 dark:text-gray-200"><?= esc($siswa['nik_ayah'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Pendidikan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pdd_ayah'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_ayah'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Penghasilan</span><span class="font-semibold text-emerald-600 dark:text-emerald-400"><?= esc($siswa['penghasilan_ayah'] ?? '' ?: '-') ?></span></div>
                    </div>
                </div>

                <!-- Ibu -->
                <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                    <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-pink-600 dark:text-pink-400">
                        <span class="material-symbols-outlined text-base">woman</span>
                        <span>Data Ibu Kandung</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div><span class="text-gray-400 block text-[10px] uppercase">Nama Ibu</span><span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_ibu'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Status</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['status_ibu'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">NIK Ibu</span><span class="font-mono text-gray-800 dark:text-gray-200"><?= esc($siswa['nik_ibu'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Pendidikan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pdd_ibu'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_ibu'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Penghasilan</span><span class="font-semibold text-emerald-600 dark:text-emerald-400"><?= esc($siswa['penghasilan_ibu'] ?? '' ?: '-') ?></span></div>
                    </div>
                </div>

                <!-- Wali -->
                <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-800/30">
                    <h4 class="font-bold text-gray-900 dark:text-white text-xs mb-3 flex items-center gap-1.5 text-amber-600 dark:text-amber-400">
                        <span class="material-symbols-outlined text-base">supervisor_account</span>
                        <span>Data Wali (Opsional)</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div><span class="text-gray-400 block text-[10px] uppercase">Nama Wali</span><span class="font-medium text-gray-800 dark:text-gray-200"><?= esc($siswa['nama_wali'] ?? '' ?: '-') ?></span></div>
                        <div><span class="text-gray-400 block text-[10px] uppercase">Pekerjaan</span><span class="text-gray-800 dark:text-gray-200"><?= esc($siswa['pekerjaan_wali'] ?? '' ?: '-') ?></span></div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/60 dark:border-emerald-900/50 dark:bg-emerald-950/30 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-300 block mb-0.5">Kontak Darurat (No. WhatsApp Ortu/Wali)</span>
                        <span class="font-mono text-base font-extrabold text-emerald-900 dark:text-emerald-200"><?= esc($siswa['no_hp_ortu'] ?? '' ?: '-') ?></span>
                    </div>
                    <span class="material-symbols-outlined text-2xl text-emerald-600 dark:text-emerald-400">call</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bagian Kanan (Sidebar - Lebar 1 Kolom) -->
    <div class="xl:col-span-1 space-y-6">

        <!-- Form Verifikasi (TailAdmin Card) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                    <span class="material-symbols-outlined text-lg">fact_check</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Validasi Status Pendaftar</h3>
            </div>

            <!-- Status Saat Ini -->
            <div class="text-center mb-5 p-4 rounded-xl bg-gray-50/80 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
                <span class="text-[11px] text-gray-400 dark:text-gray-500 block mb-1.5 font-semibold">Status Pendaftaran Saat Ini:</span>
                <?php 
                    $status = $siswa['status_verifikasi'] ?? '';
                    if ($status == 'Terverifikasi') : 
                ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Terverifikasi
                    </span>
                <?php elseif ($status == 'Ditolak') : ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-1 text-xs font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span> Ditolak
                    </span>
                <?php else : ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-4 py-1 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                    </span>
                <?php endif; ?>
            </div>

            <!-- Form Update Status -->
            <form action="<?= base_url('verifikator/siswa/verify/' . $siswa['id_siswa']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ubah Status Verifikasi</label>
                        <select name="status" required class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">-- Pilih Status --</option>
                            <option value="Terverifikasi" <?= $status == 'Terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                            <option value="Ditolak" <?= $status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            <option value="Menunggu" <?= $status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan Verifikasi (Opsional)</label>
                        <textarea name="catatan" rows="3" class="w-full rounded-xl border border-gray-200 bg-white p-3 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 placeholder:text-gray-400" placeholder="Alasan penolakan atau catatan tambahan untuk siswa..."><?= esc($siswa['catatan_verifikasi'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold py-2.5 px-4 text-xs shadow-theme-xs transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan Status Verifikasi</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Asal Sekolah & Jalur -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                    <span class="material-symbols-outlined text-lg">school</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Asal Sekolah &amp; Jalur</h3>
            </div>

            <div class="space-y-3.5 text-xs">
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Nama Sekolah Asal</span>
                    <span class="font-bold text-gray-900 dark:text-white block"><?= esc($siswa['nama_sekolah'] ?? '' ?: '-') ?></span>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">NPSN Sekolah</span>
                    <span class="font-mono text-gray-800 dark:text-gray-200 block"><?= esc($siswa['npsn_sekolah'] ?? '' ?: '-') ?></span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Jenjang</span>
                        <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['jenjang_sekolah'] ?? '' ?: '-') ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Status</span>
                        <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['status_sekolah'] ?? '' ?: '-') ?></span>
                    </div>
                </div>
                <div>
                    <span class="text-gray-400 dark:text-gray-500 uppercase text-[10px] font-semibold block mb-0.5">Jalur Pendaftaran</span>
                    <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 text-xs mt-0.5">
                        <?= esc($siswa['jalur_pendaftaran'] ?? '' ?: '-') ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Kartu Kesejahteraan -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-2.5 mb-4">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">
                    <span class="material-symbols-outlined text-lg">card_membership</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Bantuan Kesejahteraan</h3>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                    <span class="text-gray-500 dark:text-gray-400 font-semibold">No. KKS</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_kks'] ?? '' ?: '-') ?></span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                    <span class="text-gray-500 dark:text-gray-400 font-semibold">No. PKH</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_pkh'] ?? '' ?: '-') ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400 font-semibold">No. KIP</span>
                    <span class="font-mono font-bold text-gray-900 dark:text-white"><?= esc($siswa['no_kip'] ?? '' ?: '-') ?></span>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>