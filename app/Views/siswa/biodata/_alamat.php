<!-- Tab: Alamat -->
<div id="content-alamat" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Alamat Domisili Siswa</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Pilih provinsi hingga desa/kelurahan sesuai alamat tempat tinggal sekarang.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Alamat Jalan / RT / RW / Dusun <span class="text-red-500">*</span></label>
            <textarea name="alamat_siswa" rows="2" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Jl. Contoh No. 123, RT 01 / RW 02"><?= esc($siswa['alamat_siswa'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Provinsi <span class="text-red-500">*</span></label>
            <select id="provinsi" name="prov" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Memuat Provinsi --</option>
            </select>
            <input type="hidden" id="provinsi_id" value="">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Kabupaten / Kota <span class="text-red-500">*</span></label>
            <select id="kabupaten" name="kab" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 disabled:opacity-60" disabled>
                <option value="">-- Pilih Provinsi Terlebih Dahulu --</option>
            </select>
            <input type="hidden" id="kabupaten_id" value="">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Kecamatan <span class="text-red-500">*</span></label>
            <select id="kecamatan" name="kec" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 disabled:opacity-60" disabled>
                <option value="">-- Pilih Kab/Kota Terlebih Dahulu --</option>
            </select>
            <input type="hidden" id="kecamatan_id" value="">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Desa / Kelurahan <span class="text-red-500">*</span></label>
            <select id="kelurahan" name="desa" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 disabled:opacity-60" disabled>
                <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Kode Pos</label>
            <input type="text" name="kode_pos" value="<?= esc($siswa['kode_pos'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="Kode pos">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Jenis Tinggal</label>
            <select name="jenis_tinggal" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Jenis Tinggal --</option>
                <option value="Bersama Orang Tua" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Orang Tua' ? 'selected' : '' ?>>Bersama Orang Tua</option>
                <option value="Bersama Wali" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Wali' ? 'selected' : '' ?>>Bersama Wali</option>
                <option value="Kost" <?= ($siswa['jenis_tinggal'] ?? '') == 'Kost' ? 'selected' : '' ?>>Kost</option>
                <option value="Asrama" <?= ($siswa['jenis_tinggal'] ?? '') == 'Asrama' ? 'selected' : '' ?>>Asrama</option>
                <option value="Panti Asuhan" <?= ($siswa['jenis_tinggal'] ?? '') == 'Panti Asuhan' ? 'selected' : '' ?>>Panti Asuhan</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Jarak Rumah ke Sekolah (km)</label>
            <input type="number" name="jarak" value="<?= esc($siswa['jarak'] ?? '', 'attr') ?>" step="0.1" min="0" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Contoh: 2.5">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Moda Transportasi</label>
            <select name="trans" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
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
