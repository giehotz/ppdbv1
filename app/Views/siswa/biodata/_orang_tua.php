<!-- Tab: Orang Tua -->
<div id="content-orangTua" class="tab-content hidden">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Data Orang Tua/Wali</h3>

    <!-- Data Ayah -->
    <h4 class="font-semibold text-gray-700 mb-3 mt-6">Data Ayah</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ayah" value="<?= $siswa['nama_ayah'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Ayah</label>
            <select name="status_ayah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Masih Hidup" <?= ($siswa['status_ayah'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                <option value="Telah Meninggal" <?= ($siswa['status_ayah'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                <option value="Tidak Diketahui" <?= ($siswa['status_ayah'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NIK Ayah</label>
            <input type="text" name="nik_ayah" value="<?= $siswa['nik_ayah'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Lahir Ayah</label>
            <input type="number" name="th_lahir_ayah" value="<?= $siswa['th_lahir_ayah'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Ayah</label>
            <input type="text" name="pdd_ayah" value="<?= $siswa['pdd_ayah'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ayah</label>
            <select name="pekerjaan_ayah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Pekerjaan --</option>
                <option value="PNS/TNI/Polri" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'PNS/TNI/Polri' ? 'selected' : '' ?>>PNS/TNI/Polri</option>
                <option value="Tenaga Medis" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Tenaga Medis' ? 'selected' : '' ?>>Tenaga Medis</option>
                <option value="Tenaga Pendidik" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Tenaga Pendidik' ? 'selected' : '' ?>>Tenaga Pendidik</option>
                <option value="Karyawan Swasta" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Karyawan Swasta' ? 'selected' : '' ?>>Karyawan Swasta</option>
                <option value="Wiraswasta/Pedagang" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Wiraswasta/Pedagang' ? 'selected' : '' ?>>Wiraswasta/Pedagang</option>
                <option value="Petani/Peternak/Nelayan" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Petani/Peternak/Nelayan' ? 'selected' : '' ?>>Petani/Peternak/Nelayan</option>
                <option value="Buruh/Pekerja Lepas" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Buruh/Pekerja Lepas' ? 'selected' : '' ?>>Buruh/Pekerja Lepas</option>
                <option value="Seni/Hukum/Komunikasi" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Seni/Hukum/Komunikasi' ? 'selected' : '' ?>>Seni/Hukum/Komunikasi</option>
                <option value="Transportasi" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Transportasi' ? 'selected' : '' ?>>Transportasi</option>
                <option value="Pensiunan" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Pensiunan' ? 'selected' : '' ?>>Pensiunan</option>
                <option value="Tidak Bekerja" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Tidak Bekerja' ? 'selected' : '' ?>>Tidak Bekerja/Ibu Rumah Tangga</option>
                <option value="Sudah Meninggal" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Sudah Meninggal' ? 'selected' : '' ?>>Sudah Meninggal</option>
            </select>
            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                <strong>PNS/TNI/Polri:</strong> Pegawai negeri sipil, anggota TNI, dan Kepolisian •
                <strong>Tenaga Medis:</strong> Dokter, perawat, bidan •
                <strong>Tenaga Pendidik:</strong> Guru, dosen, instruktur •
                <strong>Karyawan Swasta:</strong> Pegawai perusahaan non-pemerintah •
                <strong>Wiraswasta/Pedagang:</strong> Pengusaha, pemilik toko, pedagang •
                <strong>Petani/Peternak/Nelayan:</strong> Sektor pertanian, peternakan, kelautan •
                <strong>Buruh/Pekerja Lepas:</strong> Buruh harian, kuli bangunan, pekerja serabutan •
                <strong>Seni/Hukum/Komunikasi:</strong> Seniman, pengacara, notaris, jurnalis •
                <strong>Transportasi:</strong> Sopir, pilot, pramugara •
                <strong>Pensiunan:</strong> Sudah purna tugas •
                <strong>Tidak Bekerja:</strong> Tidak memiliki penghasilan tetap •
                <strong>Sudah Meninggal:</strong> Orang tua telah wafat
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ayah</label>
            <select name="penghasilan_ayah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Penghasilan --</option>
                <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                    <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_ayah'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                        <?= esc($p['nama_penghasilan']) ?>
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>

    <!-- Data Ibu -->
    <h4 class="font-semibold text-gray-700 mb-3 mt-6">Data Ibu</h4>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ibu" value="<?= $siswa['nama_ibu'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Ibu</label>
            <select name="status_ibu" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Masih Hidup" <?= ($siswa['status_ibu'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                <option value="Telah Meninggal" <?= ($siswa['status_ibu'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                <option value="Tidak Diketahui" <?= ($siswa['status_ibu'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NIK Ibu</label>
            <input type="text" name="nik_ibu" value="<?= $siswa['nik_ibu'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Lahir Ibu</label>
            <input type="number" name="th_lahir_ibu" value="<?= $siswa['th_lahir_ibu'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Ibu</label>
            <input type="text" name="pdd_ibu" value="<?= $siswa['pdd_ibu'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Ibu</label>
            <select name="pekerjaan_ibu" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Pekerjaan --</option>
                <option value="PNS/TNI/Polri" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'PNS/TNI/Polri' ? 'selected' : '' ?>>PNS/TNI/Polri</option>
                <option value="Tenaga Medis" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Tenaga Medis' ? 'selected' : '' ?>>Tenaga Medis</option>
                <option value="Tenaga Pendidik" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Tenaga Pendidik' ? 'selected' : '' ?>>Tenaga Pendidik</option>
                <option value="Karyawan Swasta" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Karyawan Swasta' ? 'selected' : '' ?>>Karyawan Swasta</option>
                <option value="Wiraswasta/Pedagang" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Wiraswasta/Pedagang' ? 'selected' : '' ?>>Wiraswasta/Pedagang</option>
                <option value="Petani/Peternak/Nelayan" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Petani/Peternak/Nelayan' ? 'selected' : '' ?>>Petani/Peternak/Nelayan</option>
                <option value="Buruh/Pekerja Lepas" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Buruh/Pekerja Lepas' ? 'selected' : '' ?>>Buruh/Pekerja Lepas</option>
                <option value="Seni/Hukum/Komunikasi" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Seni/Hukum/Komunikasi' ? 'selected' : '' ?>>Seni/Hukum/Komunikasi</option>
                <option value="Transportasi" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Transportasi' ? 'selected' : '' ?>>Transportasi</option>
                <option value="Pensiunan" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Pensiunan' ? 'selected' : '' ?>>Pensiunan</option>
                <option value="Tidak Bekerja" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Tidak Bekerja' ? 'selected' : '' ?>>Tidak Bekerja/Ibu Rumah Tangga</option>
                <option value="Sudah Meninggal" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Sudah Meninggal' ? 'selected' : '' ?>>Sudah Meninggal</option>
            </select>
            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                <strong>PNS/TNI/Polri:</strong> Pegawai negeri sipil, anggota TNI, dan Kepolisian •
                <strong>Tenaga Medis:</strong> Dokter, perawat, bidan •
                <strong>Tenaga Pendidik:</strong> Guru, dosen, instruktur •
                <strong>Karyawan Swasta:</strong> Pegawai perusahaan non-pemerintah •
                <strong>Wiraswasta/Pedagang:</strong> Pengusaha, pemilik toko, pedagang •
                <strong>Petani/Peternak/Nelayan:</strong> Sektor pertanian, peternakan, kelautan •
                <strong>Buruh/Pekerja Lepas:</strong> Buruh harian, kuli bangunan, pekerja serabutan •
                <strong>Seni/Hukum/Komunikasi:</strong> Seniman, pengacara, notaris, jurnalis •
                <strong>Transportasi:</strong> Sopir, pilot, pramugara •
                <strong>Pensiunan:</strong> Sudah purna tugas •
                <strong>Tidak Bekerja:</strong> Tidak memiliki penghasilan tetap •
                <strong>Sudah Meninggal:</strong> Orang tua telah wafat
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Ibu</label>
            <select name="penghasilan_ibu" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Penghasilan --</option>
                <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                    <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_ibu'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                        <?= esc($p['nama_penghasilan']) ?>
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp_ortu" value="<?= $siswa['no_hp_ortu'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <!-- Data Wali -->
    <h4 class="font-semibold text-gray-700 mb-3 mt-8">Data Wali (Opsional)</h4>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Hubungan Wali</label>
        <select id="pilih_wali" onchange="handleWaliChanged()" class="w-full md:w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="lainnya">Lainnya / Isi Manual</option>
            <option value="ayah">Sama dengan Ayah</option>
            <option value="ibu">Sama dengan Ibu</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Wali</label>
            <input type="text" id="nama_wali" name="nama_wali" value="<?= $siswa['nama_wali'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NIK Wali</label>
            <input type="text" id="nik_wali" name="nik_wali" value="<?= $siswa['nik_wali'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Lahir Wali</label>
            <input type="number" id="th_lahir_wali" name="th_lahir_wali" value="<?= $siswa['th_lahir_wali'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Wali</label>
            <input type="text" id="pdd_wali" name="pdd_wali" value="<?= $siswa['pdd_wali'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan Wali</label>
            <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" value="<?= $siswa['pekerjaan_wali'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Wali</label>
            <select id="penghasilan_wali" name="penghasilan_wali" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 wali-field pointer-events-auto">
                <option value="">-- Pilih Penghasilan --</option>
                <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                    <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_wali'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                        <?= esc($p['nama_penghasilan']) ?>
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>
</div>
