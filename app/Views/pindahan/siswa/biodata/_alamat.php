<!-- Tab: Alamat (Pindahan) -->
<div id="content-alamat" class="tab-content hidden space-y-6">
    <!-- Header -->
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                <span class="material-symbols-outlined text-lg">home_pin</span>
            </span>
            <span>Alamat Domisili &amp; Tempat Tinggal</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pilih provinsi hingga desa/kelurahan sesuai alamat tempat tinggal calon siswa saat ini.</p>
    </div>

    <!-- Section 1: Alamat Domisili & Wilayah Administratif -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">map</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">1. Alamat Jalan &amp; Wilayah Administratif</h4>
        </div>

        <div class="space-y-4">
            <!-- Alamat Jalan / RT / RW -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Alamat Jalan / RT / RW / Dusun / No. Rumah <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat_siswa" rows="2" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: Jl. Merdeka No. 45, RT 02 / RW 05, Dusun Sukamaju"><?= esc($pindahan['alamat_siswa'] ?? '') ?></textarea>
            </div>

            <!-- Cascading Region Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Provinsi -->
                <div>
                    <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Provinsi <span class="text-red-500">*</span>
                    </label>
                    <select id="provinsi" name="prov" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Memuat Provinsi --</option>
                    </select>
                    <input type="hidden" id="provinsi_id" value="">
                </div>

                <!-- Kabupaten / Kota -->
                <div>
                    <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Kabupaten / Kota <span class="text-red-500">*</span>
                    </label>
                    <select id="kabupaten" name="kab" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer disabled:opacity-60" disabled>
                        <option value="">-- Pilih Provinsi Dahulu --</option>
                    </select>
                    <input type="hidden" id="kabupaten_id" value="">
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Kecamatan <span class="text-red-500">*</span>
                    </label>
                    <select id="kecamatan" name="kec" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer disabled:opacity-60" disabled>
                        <option value="">-- Pilih Kab/Kota Dahulu --</option>
                    </select>
                    <input type="hidden" id="kecamatan_id" value="">
                </div>

                <!-- Desa / Kelurahan -->
                <div>
                    <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Desa / Kelurahan <span class="text-red-500">*</span>
                    </label>
                    <select id="kelurahan" name="desa" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer disabled:opacity-60" disabled>
                        <option value="">-- Pilih Kecamatan Dahulu --</option>
                    </select>
                </div>

                <!-- Kode Pos -->
                <div>
                    <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Kode Pos
                    </label>
                    <div class="input-icon-wrapper">
                        <span class="input-icon material-symbols-outlined">markunread_mailbox</span>
                        <input type="text" name="kode_pos" value="<?= esc($pindahan['kode_pos'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="5 digit kode pos">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Aksesibilitas & Karakteristik Tempat Tinggal -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">commute</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">2. Karakteristik Tinggal &amp; Aksesibilitas</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
            <!-- Jenis Tinggal -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jenis Tempat Tinggal
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">apartment</span>
                    <select name="jenis_tinggal" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Jenis Tinggal --</option>
                        <option value="Bersama Orang Tua" <?= ($pindahan['jenis_tinggal'] ?? '') == 'Bersama Orang Tua' ? 'selected' : '' ?>>Bersama Orang Tua</option>
                        <option value="Bersama Wali" <?= ($pindahan['jenis_tinggal'] ?? '') == 'Bersama Wali' ? 'selected' : '' ?>>Bersama Wali</option>
                        <option value="Kost" <?= ($pindahan['jenis_tinggal'] ?? '') == 'Kost' ? 'selected' : '' ?>>Kost</option>
                        <option value="Asrama" <?= ($pindahan['jenis_tinggal'] ?? '') == 'Asrama' ? 'selected' : '' ?>>Asrama / Pesantren</option>
                        <option value="Panti Asuhan" <?= ($pindahan['jenis_tinggal'] ?? '') == 'Panti Asuhan' ? 'selected' : '' ?>>Panti Asuhan</option>
                    </select>
                </div>
            </div>

            <!-- Jarak Rumah ke Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jarak ke Sekolah (km)
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">straighten</span>
                    <input type="number" name="jarak" value="<?= esc($pindahan['jarak'] ?? '', 'attr') ?>" step="0.1" min="0" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: 2.5">
                </div>
            </div>

            <!-- Moda Transportasi -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Moda Transportasi Utama
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">directions_bike</span>
                    <select name="trans" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Transportasi --</option>
                        <option value="Jalan Kaki" <?= ($pindahan['trans'] ?? '') == 'Jalan Kaki' ? 'selected' : '' ?>>Jalan Kaki</option>
                        <option value="Sepeda" <?= ($pindahan['trans'] ?? '') == 'Sepeda' ? 'selected' : '' ?>>Sepeda</option>
                        <option value="Motor" <?= ($pindahan['trans'] ?? '') == 'Motor' ? 'selected' : '' ?>>Sepeda Motor</option>
                        <option value="Mobil" <?= ($pindahan['trans'] ?? '') == 'Mobil' ? 'selected' : '' ?>>Mobil Pribadi</option>
                        <option value="Angkutan Umum" <?= ($pindahan['trans'] ?? '') == 'Angkutan Umum' ? 'selected' : '' ?>>Angkutan Umum</option>
                        <option value="Lainnya" <?= ($pindahan['trans'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>