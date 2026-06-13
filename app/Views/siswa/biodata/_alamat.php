<!-- Tab: Alamat -->
<div id="content-alamat" class="tab-content hidden">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Alamat Tempat Tinggal</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="alamat_siswa" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $siswa['alamat_siswa'] ?? '' ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
            <select id="provinsi" name="prov" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Provinsi --</option>
            </select>
            <input type="hidden" id="provinsi_id" value="">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
            <select id="kabupaten" name="kab" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                <option value="">-- Pilih Provinsi Dahulu --</option>
            </select>
            <input type="hidden" id="kabupaten_id" value="">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan <span class="text-red-500">*</span></label>
            <select id="kecamatan" name="kec" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                <option value="">-- Pilih Kabupaten/Kota Dahulu --</option>
            </select>
            <input type="hidden" id="kecamatan_id" value="">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Desa/Kelurahan <span class="text-red-500">*</span></label>
            <select id="kelurahan" name="desa" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" disabled>
                <option value="">-- Pilih Kecamatan Dahulu --</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
            <input type="text" name="kode_pos" value="<?= $siswa['kode_pos'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Tinggal</label>
            <select name="jenis_tinggal" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Bersama Orang Tua" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Orang Tua' ? 'selected' : '' ?>>Bersama Orang Tua</option>
                <option value="Bersama Wali" <?= ($siswa['jenis_tinggal'] ?? '') == 'Bersama Wali' ? 'selected' : '' ?>>Bersama Wali</option>
                <option value="Kost" <?= ($siswa['jenis_tinggal'] ?? '') == 'Kost' ? 'selected' : '' ?>>Kost</option>
                <option value="Asrama" <?= ($siswa['jenis_tinggal'] ?? '') == 'Asrama' ? 'selected' : '' ?>>Asrama</option>
            </select>
        </div>
    </div>
</div>
