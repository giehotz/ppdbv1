<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>
Detail Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detail Calon Siswa - <?= esc($siswa['nama_lengkap']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span class="block sm:inline font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    </div>
<?php endif; ?>

<!-- Action Buttons -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="<?= base_url('verifikator/siswa') ?>" class="inline-flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="flex flex-wrap items-center gap-3">
        <a href="<?= base_url('verifikator/siswa/cetak/' . $siswa['id_siswa']) ?>" target="_blank" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 shadow-sm">
            <i class="fas fa-print mr-2"></i> Cetak Formulir
        </a>
    </div>
</div>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <!-- Bagian Kiri (Lebar 2 Kolom) -->
    <div class="xl:col-span-2 space-y-6">

        <!-- A. Data Pribadi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">A. Data Pribadi Siswa</h3>
                <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                    <i class="fas fa-user text-sm"></i>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">No. Pendaftaran</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['no_pendaftaran']) ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NISN</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['nisn'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['nama_lengkap']) ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIK</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['nik'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                    <p class="text-gray-900 font-medium">
                        <?= $siswa['jk'] == 'L' ? 'Laki-laki' : ($siswa['jk'] == 'P' ? 'Perempuan' : '-') ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                    <p class="text-gray-900 font-medium">
                        <?= esc($siswa['tempat_lahir'] ?? '-') ?>, 
                        <?= $siswa['tgl_lahir'] ? date('d-m-Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Agama</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['agama'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">No. HP Siswa / Email</p>
                    <p class="text-gray-900 font-medium">
                        <?= esc($siswa['no_hp_siswa'] ?? '-') ?> <br>
                        <span class="text-sm text-gray-500 font-normal"><?= esc($siswa['email'] ?? '-') ?></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Dalam Keluarga</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['status_keluarga'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Anak Ke / Jml Saudara</p>
                    <p class="text-gray-900 font-medium">
                        <?= esc($siswa['anak_ke'] ?? '-') ?> dari <?= esc($siswa['jml_saudara'] ?? '-') ?> bersaudara
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Hobi / Cita-cita</p>
                    <p class="text-gray-900 font-medium">
                        <?= esc($siswa['hobi'] ?? '-') ?> / <?= esc($siswa['cita'] ?? '-') ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Riwayat Pendidikan</p>
                    <p class="text-gray-900 font-medium text-sm mt-1">
                        <span class="inline-block bg-gray-100 rounded px-2 py-1 mr-2">PAUD: <?= esc($siswa['paud'] ?? '-') ?></span>
                        <span class="inline-block bg-gray-100 rounded px-2 py-1">TK: <?= esc($siswa['tk'] ?? '-') ?></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">No. KK</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['no_kk'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kepala Keluarga</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['kepala_keluarga'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <!-- B. Data Alamat -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">B. Alamat Tempat Tinggal</h3>
                <div class="bg-red-100 text-red-600 p-2 rounded-lg">
                    <i class="fas fa-map-marker-alt text-sm px-1"></i>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['alamat_siswa'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Desa/Kelurahan</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['desa'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kecamatan</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['kec'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kabupaten/Kota</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['kab'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Provinsi (Kode Pos)</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['prov'] ?? '-') ?> (<?= esc($siswa['kode_pos'] ?? '-') ?>)</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Tinggal</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['jenis_tinggal'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Transportasi / Jarak</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['trans'] ?? '-') ?> (<?= esc($siswa['jarak'] ?? '-') ?>)</p>
                </div>
            </div>
        </div>

        <!-- C. Data Orang Tua/Wali -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">C. Data Orang Tua & Wali</h3>
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                    <i class="fas fa-users text-sm"></i>
                </div>
            </div>

            <div class="p-6 space-y-8">
                <!-- Ayah -->
                <div class="relative">
                    <div class="flex items-center mb-4">
                        <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold mr-3">1</span>
                        <h4 class="font-bold text-gray-800 text-lg">Data Ayah</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-11">
                        <div><p class="text-xs text-gray-500 uppercase">Nama Ayah</p><p class="font-medium"><?= esc($siswa['nama_ayah'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Status</p><p class="font-medium"><?= esc($siswa['status_ayah'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">NIK</p><p class="font-medium"><?= esc($siswa['nik_ayah'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Tahun Lahir</p><p class="font-medium"><?= esc($siswa['th_lahir_ayah'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pendidikan</p><p class="font-medium"><?= esc($siswa['pdd_ayah'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pekerjaan</p><p class="font-medium"><?= esc($siswa['pekerjaan_ayah'] ?? '-') ?></p></div>
                        <div class="sm:col-span-2"><p class="text-xs text-gray-500 uppercase">Penghasilan</p><p class="font-medium"><?= esc($siswa['penghasilan_ayah'] ?? '-') ?></p></div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Ibu -->
                <div class="relative">
                    <div class="flex items-center mb-4">
                        <span class="w-8 h-8 rounded-full bg-pink-100 text-pink-700 flex items-center justify-center font-bold mr-3">2</span>
                        <h4 class="font-bold text-gray-800 text-lg">Data Ibu</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-11">
                        <div><p class="text-xs text-gray-500 uppercase">Nama Ibu</p><p class="font-medium"><?= esc($siswa['nama_ibu'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Status</p><p class="font-medium"><?= esc($siswa['status_ibu'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">NIK</p><p class="font-medium"><?= esc($siswa['nik_ibu'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Tahun Lahir</p><p class="font-medium"><?= esc($siswa['th_lahir_ibu'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pendidikan</p><p class="font-medium"><?= esc($siswa['pdd_ibu'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pekerjaan</p><p class="font-medium"><?= esc($siswa['pekerjaan_ibu'] ?? '-') ?></p></div>
                        <div class="sm:col-span-2"><p class="text-xs text-gray-500 uppercase">Penghasilan</p><p class="font-medium"><?= esc($siswa['penghasilan_ibu'] ?? '-') ?></p></div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Wali -->
                <div class="relative">
                    <div class="flex items-center mb-4">
                        <span class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold mr-3">3</span>
                        <h4 class="font-bold text-gray-800 text-lg">Data Wali <span class="text-sm font-normal text-gray-500">(Opsional)</span></h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-11">
                        <div><p class="text-xs text-gray-500 uppercase">Nama Wali</p><p class="font-medium"><?= esc($siswa['nama_wali'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">NIK</p><p class="font-medium"><?= esc($siswa['nik_wali'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Tahun Lahir</p><p class="font-medium"><?= esc($siswa['th_lahir_wali'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pendidikan</p><p class="font-medium"><?= esc($siswa['pdd_wali'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Pekerjaan</p><p class="font-medium"><?= esc($siswa['pekerjaan_wali'] ?? '-') ?></p></div>
                        <div><p class="text-xs text-gray-500 uppercase">Penghasilan</p><p class="font-medium"><?= esc($siswa['penghasilan_wali'] ?? '-') ?></p></div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="mt-6 bg-emerald-50 p-4 rounded-lg border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">Kontak Darurat (No. HP Ortu/Wali)</p>
                        <p class="text-emerald-900 font-bold text-xl"><?= esc($siswa['no_hp_ortu'] ?? '-') ?></p>
                    </div>
                    <div class="text-emerald-400">
                        <i class="fas fa-phone-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bagian Kanan (Sidebar - Lebar 1 Kolom) -->
    <div class="xl:col-span-1 space-y-6">

        <!-- Status Verifikasi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden border-t-4 border-t-emerald-500">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Form Verifikasi</h3>
            </div>
            <div class="p-6">
                <!-- Status Badge -->
                <div class="text-center mb-6 p-4 rounded-lg bg-gray-50 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2 font-medium">Status Pendaftaran Saat Ini</p>
                    <?php 
                        $status = $siswa['status_verifikasi'] ?? '';
                        if ($status == 'Terverifikasi') : 
                    ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 font-bold text-sm">
                            <i class="fas fa-check-circle mr-2"></i> Terverifikasi
                        </span>
                    <?php elseif ($status == 'Ditolak') : ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-bold text-sm">
                            <i class="fas fa-times-circle mr-2"></i> Ditolak
                        </span>
                    <?php else : ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-amber-100 text-amber-800 font-bold text-sm">
                            <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Form Verifikasi -->
                <form action="<?= base_url('verifikator/siswa/verify/' . $siswa['id_siswa']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Update Status</label>
                            <select name="status" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-2.5 px-3 border outline-none transition">
                                <option value="">-- Pilih Status --</option>
                                <option value="Terverifikasi" <?= $status == 'Terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                                <option value="Ditolak" <?= $status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                <option value="Menunggu" <?= $status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Verifikasi</label>
                            <textarea name="catatan" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 border outline-none transition" placeholder="Alasan penolakan / catatan lain..."><?= esc($siswa['catatan_verifikasi'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="w-full flex justify-center items-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 shadow-md">
                            <i class="fas fa-save mr-2"></i> Simpan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Sekolah Asal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Sekolah Asal</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Sekolah</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['nama_sekolah'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NPSN</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['npsn_sekolah'] ?? '-') ?></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenjang</p>
                        <p class="text-gray-900 font-medium"><?= esc($siswa['jenjang_sekolah'] ?? '-') ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                        <p class="text-gray-900 font-medium"><?= esc($siswa['status_sekolah'] ?? '-') ?></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Lokasi</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['lokasi_sekolah'] ?? '-') ?></p>
                </div>
            </div>
        </div>

        <!-- Kartu Kesejahteraan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Kartu Kesejahteraan</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-semibold text-gray-500 uppercase">KKS</span>
                    <span class="font-medium text-gray-900"><?= esc($siswa['no_kks'] ?? '-') ?></span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-semibold text-gray-500 uppercase">PKH</span>
                    <span class="font-medium text-gray-900"><?= esc($siswa['no_pkh'] ?? '-') ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-500 uppercase">KIP</span>
                    <span class="font-medium text-gray-900"><?= esc($siswa['no_kip'] ?? '-') ?></span>
                </div>
            </div>
        </div>

        <!-- Info Pendaftaran Tambahan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-semibold text-gray-800">Detail Pendaftaran</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Daftar</p>
                    <p class="text-gray-900 font-medium"><?= $siswa['tgl_siswa'] ? date('d/m/Y H:i', strtotime($siswa['tgl_siswa'])) : '-' ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jalur Pendaftaran</p>
                    <p class="text-gray-900 font-medium bg-blue-50 text-blue-700 px-2 py-1 rounded inline-block mt-1"><?= esc($siswa['jalur_pendaftaran'] ?? '-') ?></p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pilihan Jurusan</p>
                    <p class="text-gray-900 font-medium"><?= esc($siswa['komp_ahli'] ?? '-') ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>