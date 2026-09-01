<!-- Tab: Orang Tua -->
<div id="content-orangTua" class="tab-content hidden space-y-6">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Data Orang Tua / Wali</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Lengkapi data ayah, ibu, dan wali siswa sesuai dokumen kependudukan.</p>
    </div>

    <!-- Data Ayah -->
    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-850/40 space-y-4">
        <div class="flex items-center gap-2 border-b border-gray-200/60 dark:border-gray-700/60 pb-2">
            <span class="material-symbols-outlined text-brand-500 text-lg">person</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">Data Ayah Kandung</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Ayah <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ayah" value="<?= esc($siswa['nama_ayah'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Nama lengkap ayah">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status Keberadaan Ayah</label>
                <select name="status_ayah" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Status --</option>
                    <option value="Masih Hidup" <?= ($siswa['status_ayah'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                    <option value="Telah Meninggal" <?= ($siswa['status_ayah'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                    <option value="Tidak Diketahui" <?= ($siswa['status_ayah'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NIK Ayah</label>
                <input type="text" name="nik_ayah" value="<?= esc($siswa['nik_ayah'] ?? '', 'attr') ?>" maxlength="16" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="16 digit NIK ayah">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tempat Lahir Ayah</label>
                <input type="text" name="tempat_lahir_ayah" value="<?= esc($siswa['tempat_lahir_ayah'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Kota lahir">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Lahir Ayah</label>
                <input type="date" name="tgl_lahir_ayah" value="<?= esc($siswa['tgl_lahir_ayah'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun Lahir Ayah</label>
                <input type="number" name="th_lahir_ayah" value="<?= esc($siswa['th_lahir_ayah'] ?? '', 'attr') ?>" min="1930" max="<?= date('Y') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="YYYY">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pendidikan Terakhir Ayah</label>
                <select name="pdd_ayah" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Pendidikan --</option>
                    <?php foreach (['Tidak Sekolah', 'SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3'] as $pdd): ?>
                        <option value="<?= $pdd ?>" <?= ($siswa['pdd_ayah'] ?? '') == $pdd ? 'selected' : '' ?>><?= $pdd ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan Ayah</label>
                <select name="pekerjaan_ayah" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
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
                    <option value="Tidak Bekerja" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Tidak Bekerja' ? 'selected' : '' ?>>Tidak Bekerja</option>
                    <option value="Sudah Meninggal" <?= ($siswa['pekerjaan_ayah'] ?? '') == 'Sudah Meninggal' ? 'selected' : '' ?>>Sudah Meninggal</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Penghasilan Bulanan Ayah</label>
                <select name="penghasilan_ayah" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Rentang Penghasilan --</option>
                    <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                        <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_ayah'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                            <?= esc($p['nama_penghasilan']) ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Ibu -->
    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-850/40 space-y-4">
        <div class="flex items-center gap-2 border-b border-gray-200/60 dark:border-gray-700/60 pb-2">
            <span class="material-symbols-outlined text-brand-500 text-lg">person_3</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">Data Ibu Kandung</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Ibu <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ibu" value="<?= esc($siswa['nama_ibu'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Nama lengkap ibu kandung">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status Keberadaan Ibu</label>
                <select name="status_ibu" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Status --</option>
                    <option value="Masih Hidup" <?= ($siswa['status_ibu'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                    <option value="Telah Meninggal" <?= ($siswa['status_ibu'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                    <option value="Tidak Diketahui" <?= ($siswa['status_ibu'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NIK Ibu</label>
                <input type="text" name="nik_ibu" value="<?= esc($siswa['nik_ibu'] ?? '', 'attr') ?>" maxlength="16" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="16 digit NIK ibu">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tempat Lahir Ibu</label>
                <input type="text" name="tempat_lahir_ibu" value="<?= esc($siswa['tempat_lahir_ibu'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Kota lahir">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Lahir Ibu</label>
                <input type="date" name="tgl_lahir_ibu" value="<?= esc($siswa['tgl_lahir_ibu'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun Lahir Ibu</label>
                <input type="number" name="th_lahir_ibu" value="<?= esc($siswa['th_lahir_ibu'] ?? '', 'attr') ?>" min="1930" max="<?= date('Y') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="YYYY">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pendidikan Terakhir Ibu</label>
                <select name="pdd_ibu" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Pendidikan --</option>
                    <?php foreach (['Tidak Sekolah', 'SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3'] as $pdd): ?>
                        <option value="<?= $pdd ?>" <?= ($siswa['pdd_ibu'] ?? '') == $pdd ? 'selected' : '' ?>><?= $pdd ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan Ibu</label>
                <select name="pekerjaan_ibu" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
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
                    <option value="Tidak Bekerja" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Tidak Bekerja' ? 'selected' : '' ?>>Tidak Bekerja / Ibu Rumah Tangga</option>
                    <option value="Sudah Meninggal" <?= ($siswa['pekerjaan_ibu'] ?? '') == 'Sudah Meninggal' ? 'selected' : '' ?>>Sudah Meninggal</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Penghasilan Bulanan Ibu</label>
                <select name="penghasilan_ibu" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Rentang Penghasilan --</option>
                    <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                        <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_ibu'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                            <?= esc($p['nama_penghasilan']) ?>
                        </option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. HP Orang Tua / Wali <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp_ortu" value="<?= esc($siswa['no_hp_ortu'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="08xxxxxxxxxx">
            </div>
        </div>
    </div>

    <!-- Data Wali -->
    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4 dark:border-gray-800 dark:bg-gray-850/40 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-200/60 dark:border-gray-700/60 pb-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">supervised_user_circle</span>
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">Data Wali (Opsional)</h4>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Pilih:</label>
                <select id="pilih_wali" onchange="handleWaliChanged()" class="h-8 rounded-lg border border-gray-200 bg-white px-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                    <option value="lainnya">Lainnya / Isi Manual</option>
                    <option value="ayah">Sama dengan Ayah</option>
                    <option value="ibu">Sama dengan Ibu</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Wali</label>
                <input type="text" id="nama_wali" name="nama_wali" value="<?= esc($siswa['nama_wali'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 wali-field" placeholder="Nama wali jika tidak tinggal bersama orang tua">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NIK Wali</label>
                <input type="text" id="nik_wali" name="nik_wali" value="<?= esc($siswa['nik_wali'] ?? '', 'attr') ?>" maxlength="16" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono wali-field" placeholder="16 digit NIK wali">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun Lahir Wali</label>
                <input type="number" id="th_lahir_wali" name="th_lahir_wali" value="<?= esc($siswa['th_lahir_wali'] ?? '', 'attr') ?>" min="1930" max="<?= date('Y') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono wali-field" placeholder="YYYY">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pendidikan Terakhir Wali</label>
                <input type="text" id="pdd_wali" name="pdd_wali" value="<?= esc($siswa['pdd_wali'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 wali-field" placeholder="Contoh: S1 / SMA">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pekerjaan Wali</label>
                <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" value="<?= esc($siswa['pekerjaan_wali'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 wali-field" placeholder="Contoh: Wiraswasta">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Penghasilan Bulanan Wali</label>
                <select id="penghasilan_wali" name="penghasilan_wali" class="h-10.5 w-full rounded-xl border border-gray-200 bg-white px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 wali-field">
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
</div>
