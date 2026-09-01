<!-- Tab: Alamat -->
<div id="content-alamat" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Alamat Domisili Siswa</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Pilih provinsi hingga desa/kelurahan sesuai alamat tempat tinggal sekarang.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Jalan / RT / RW / Dusun <span class="text-red-500">*</span></label>
            <textarea name="alamat_siswa" rows="2" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Jl. Contoh No. 123, RT 01 / RW 02"><?= esc($siswa['alamat_siswa'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Provinsi <span class="text-red-500">*</span></label>
            <select id="provinsi" name="prov" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Memuat Provinsi --</option>
            </select>
            <input type="hidden" id="provinsi_id" value="">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kabupaten / Kota <span class="text-red-500">*</span></label>
            <select id="kabupaten" name="kab" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 disabled:opacity-60" disabled>
                <option value="">-- Pilih Provinsi Terlebih Dahulu --</option>
            </select>
            <input type="hidden" id="kabupaten_id" value="">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
            <select id="kecamatan" name="kec" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 disabled:opacity-60" disabled>
                <option value="">-- Pilih Kab/Kota Terlebih Dahulu --</option>
            </select>
            <input type="hidden" id="kecamatan_id" value="">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Desa / Kelurahan <span class="text-red-500">*</span></label>
            <select id="kelurahan" name="desa" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 disabled:opacity-60" disabled>
                <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kode Pos</label>
            <input type="text" name="kode_pos" value="<?= esc($siswa['kode_pos'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="Kode pos">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jenis Tinggal</label>
            <select name="jenis_tinggal" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih Jenis Tinggal --</option>
                <option value="Bersama Orang Tua" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Orang Tua' ? 'selected' : '' ?>>Bersama Orang Tua</option>
                <option value="Bersama Wali" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Wali' ? 'selected' : '' ?>>Bersama Wali</option>
                <option value="Kost" <?= ($siswa['jenis_tinggal'] ?? '') == 'Kost' ? 'selected' : '' ?>>Kost</option>
                <option value="Asrama" <?= ($siswa['jenis_tinggal'] ?? '') == 'Asrama' ? 'selected' : '' ?>>Asrama</option>
                <option value="Panti Asuhan" <?= ($siswa['jenis_tinggal'] ?? '') == 'Panti Asuhan' ? 'selected' : '' ?>>Panti Asuhan</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jarak Rumah ke Sekolah (km)</label>
            <input type="number" name="jarak" value="<?= esc($siswa['jarak'] ?? '', 'attr') ?>" step="0.1" min="0" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Contoh: 2.5">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Moda Transportasi</label>
            <select name="trans" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih Transportasi --</option>
                <option value="Jalan Kaki" <?= ($siswa['trans'] ?? '') == 'Jalan Kaki' ? 'selected' : '' ?>>Jalan Kaki</option>
                <option value="Sepeda" <?= ($siswa['trans'] ?? '') == 'Sepeda' ? 'selected' : '' ?>>Sepeda</option>
                <option value="Motor" <?= ($siswa['trans'] ?? '') == 'Motor' ? 'selected' : '' ?>>Motor</option>
                <option value="Mobil" <?= ($siswa['trans'] ?? '') == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                <option value="Angkutan Umum" <?= ($siswa['trans'] ?? '') == 'Angkutan Umum' ? 'selected' : '' ?>>Angkutan Umum</option>
                <option value="Lainnya" <?= ($siswa['trans'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
        </div>
    </div>
</div>
