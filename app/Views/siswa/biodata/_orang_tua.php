<!-- Tab: Orang Tua -->
<div id="content-orangTua" class="tab-content hidden space-y-6">
    <!-- Header -->
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                <span class="material-symbols-outlined text-lg">family_restroom</span>
            </span>
            <span>Data Orang Tua &amp; Wali Siswa</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Lengkapi data ayah kandung, ibu kandung, dan wali (jika siswa diasuh oleh wali).</p>
    </div>

    <!-- Data Ayah Kandung Card -->
    <div class="rounded-2xl border border-blue-100 bg-white p-5 sm:p-6 shadow-sm dark:border-blue-950/50 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-blue-50 dark:border-gray-800">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-500 text-white shadow-sm shadow-blue-500/20">
                    <span class="material-symbols-outlined text-lg">person</span>
                </span>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white">Data Ayah Kandung</h4>
                    <p class="text-[11px] text-gray-400">Identitas ayah sesuai dokumen kependudukan</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2.5 py-0.5 text-[11px] font-bold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">
                Ayah
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nama Lengkap Ayah -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Lengkap Ayah <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">person</span>
                    <input type="text" name="nama_ayah" value="<?= esc($siswa['nama_ayah'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Nama lengkap ayah kandung">
                </div>
            </div>

            <!-- Status Keberadaan Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Status Keberadaan Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">vital_signs</span>
                    <select name="status_ayah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="Masih Hidup" <?= ($siswa['status_ayah'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                        <option value="Telah Meninggal" <?= ($siswa['status_ayah'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                        <option value="Tidak Diketahui" <?= ($siswa['status_ayah'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                    </select>
                </div>
            </div>

            <!-- NIK Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    NIK Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">credit_card</span>
                    <input type="text" name="nik_ayah" value="<?= esc($siswa['nik_ayah'] ?? '', 'attr') ?>" maxlength="16" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="16 digit NIK ayah">
                </div>
            </div>

            <!-- Tempat Lahir Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tempat Lahir Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_city</span>
                    <input type="text" name="tempat_lahir_ayah" value="<?= esc($siswa['tempat_lahir_ayah'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Isi Sesuai KK">
                </div>
            </div>

            <!-- Tanggal Lahir Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tanggal Lahir Ayah
                </label>
                <div class="relative">
                    <input type="text" 
                           name="tgl_lahir_ayah" 
                           id="tgl_lahir_ayah" 
                           value="<?= (!empty($siswa['tgl_lahir_ayah']) && $siswa['tgl_lahir_ayah'] !== '0000-00-00') ? esc($siswa['tgl_lahir_ayah'], 'attr') : '' ?>" 
                           placeholder="Pilih tanggal lahir ayah" 
                           class="datepicker-parent form-input-control border border-gray-300 dark:border-gray-600 pr-11">
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                    </span>
                </div>
            </div>

            <!-- Pendidikan Terakhir Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pendidikan Terakhir Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">school</span>
                    <select name="pdd_ayah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Pendidikan --</option>
                        <?php foreach (['Tidak Sekolah', 'SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3'] as $pdd): ?>
                            <option value="<?= $pdd ?>" <?= ($siswa['pdd_ayah'] ?? '') == $pdd ? 'selected' : '' ?>><?= $pdd ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Pekerjaan Ayah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pekerjaan Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">work</span>
                    <select name="pekerjaan_ayah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php if(!empty($pekerjaan)): foreach ($pekerjaan as $pk): ?>
                            <option value="<?= esc($pk['nama_pekerjaan']) ?>" <?= ($siswa['pekerjaan_ayah'] ?? '') == $pk['nama_pekerjaan'] ? 'selected' : '' ?>>
                                <?= esc($pk['nama_pekerjaan']) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <!-- Penghasilan Bulanan Ayah -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Penghasilan Bulanan Ayah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">payments</span>
                    <select name="penghasilan_ayah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
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
    </div>

    <!-- Data Ibu Kandung Card -->
    <div class="rounded-2xl border border-rose-100 bg-white p-5 sm:p-6 shadow-sm dark:border-rose-950/50 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center justify-between pb-3 border-b border-rose-50 dark:border-gray-800">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-rose-500 text-white shadow-sm shadow-rose-500/20">
                    <span class="material-symbols-outlined text-lg">person_3</span>
                </span>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white">Data Ibu Kandung</h4>
                    <p class="text-[11px] text-gray-400">Identitas ibu sesuai dokumen kependudukan</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-bold text-rose-700 dark:bg-rose-500/15 dark:text-rose-300">
                Ibu
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nama Lengkap Ibu -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Lengkap Ibu <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">person_3</span>
                    <input type="text" name="nama_ibu" value="<?= esc($siswa['nama_ibu'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Nama lengkap ibu kandung">
                </div>
            </div>

            <!-- Status Keberadaan Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Status Keberadaan Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">vital_signs</span>
                    <select name="status_ibu" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="Masih Hidup" <?= ($siswa['status_ibu'] ?? '') == 'Masih Hidup' ? 'selected' : '' ?>>Masih Hidup</option>
                        <option value="Telah Meninggal" <?= ($siswa['status_ibu'] ?? '') == 'Telah Meninggal' ? 'selected' : '' ?>>Telah Meninggal</option>
                        <option value="Tidak Diketahui" <?= ($siswa['status_ibu'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                    </select>
                </div>
            </div>

            <!-- NIK Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    NIK Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">credit_card</span>
                    <input type="text" name="nik_ibu" value="<?= esc($siswa['nik_ibu'] ?? '', 'attr') ?>" maxlength="16" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="16 digit NIK ibu">
                </div>
            </div>

            <!-- Tempat Lahir Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tempat Lahir Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_city</span>
                    <input type="text" name="tempat_lahir_ibu" value="<?= esc($siswa['tempat_lahir_ibu'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Isi Sesuai KK">
                </div>
            </div>

            <!-- Tanggal Lahir Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tanggal Lahir Ibu
                </label>
                <div class="relative">
                    <input type="text" 
                           name="tgl_lahir_ibu" 
                           id="tgl_lahir_ibu" 
                           value="<?= (!empty($siswa['tgl_lahir_ibu']) && $siswa['tgl_lahir_ibu'] !== '0000-00-00') ? esc($siswa['tgl_lahir_ibu'], 'attr') : '' ?>" 
                           placeholder="Pilih tanggal lahir ibu" 
                           class="datepicker-parent form-input-control border border-gray-300 dark:border-gray-600 pr-11">
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                    </span>
                </div>
            </div>

            <!-- Pendidikan Terakhir Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pendidikan Terakhir Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">school</span>
                    <select name="pdd_ibu" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Pendidikan --</option>
                        <?php foreach (['Tidak Sekolah', 'SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK / Sederajat', 'D1 / D2 / D3', 'D4 / S1', 'S2', 'S3'] as $pdd): ?>
                            <option value="<?= $pdd ?>" <?= ($siswa['pdd_ibu'] ?? '') == $pdd ? 'selected' : '' ?>><?= $pdd ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Pekerjaan Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pekerjaan Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">work</span>
                    <select name="pekerjaan_ibu" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php if(!empty($pekerjaan)): foreach ($pekerjaan as $pk): ?>
                            <option value="<?= esc($pk['nama_pekerjaan']) ?>" <?= ($siswa['pekerjaan_ibu'] ?? '') == $pk['nama_pekerjaan'] ? 'selected' : '' ?>>
                                <?= esc($pk['nama_pekerjaan']) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <!-- Penghasilan Bulanan Ibu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Penghasilan Bulanan Ibu
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">payments</span>
                    <select name="penghasilan_ibu" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Rentang Penghasilan --</option>
                        <?php if(!empty($penghasilan)): foreach ($penghasilan as $p): ?>
                            <option value="<?= esc($p['nama_penghasilan']) ?>" <?= ($siswa['penghasilan_ibu'] ?? '') == $p['nama_penghasilan'] ? 'selected' : '' ?>>
                                <?= esc($p['nama_penghasilan']) ?>
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <!-- No. HP / WhatsApp Orang Tua (PROMINENT) -->
            <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-3.5 dark:border-emerald-900/50 dark:bg-emerald-950/20">
                <label class="mb-1.5 flex items-center justify-between text-xs font-bold text-emerald-900 dark:text-emerald-300">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base text-emerald-600">call</span>
                        <span>No. HP Ortu / Narahubung <span class="text-red-500">*</span></span>
                    </span>
                    <span class="text-[10px] bg-emerald-600 text-white font-bold px-1.5 py-0.5 rounded">Paling Penting</span>
                </label>
                <input type="text" name="no_hp_ortu" value="<?= esc($siswa['no_hp_ortu'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono font-bold" placeholder="08xxxxxxxxxx (Nomor aktif WhatsApp)">
                <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 block">Digunakan panitia untuk konfirmasi kelulusan, jadwal tes &amp; pembiayaan.</span>
            </div>
        </div>
    </div>

    <!-- Data Wali Siswa Card (Opsional) -->
    <div class="rounded-2xl border border-amber-100 bg-white p-5 sm:p-6 shadow-sm dark:border-amber-950/50 dark:bg-gray-800/40 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-amber-50 dark:border-gray-800">
            <div class="flex items-center gap-2.5">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm shadow-amber-500/20">
                    <span class="material-symbols-outlined text-lg">supervised_user_circle</span>
                </span>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-gray-900 dark:text-white">Data Wali Siswa <span class="text-xs font-normal text-gray-400 lowercase">(opsional)</span></h4>
                    <p class="text-[11px] text-gray-400">Diisi jika calon siswa tinggal/diasuh bersama wali</p>
                </div>
            </div>

            <!-- Wali Quick Switcher -->
            <div class="flex items-center gap-2">
                <label for="pilih_wali" class="text-xs font-semibold text-gray-600 dark:text-gray-400 shrink-0">Opsi Cepat:</label>
                <select id="pilih_wali" onchange="handleWaliChanged()" class="form-input-control border border-gray-300 dark:border-gray-600 text-xs font-bold py-1.5 px-3 bg-gray-50 dark:bg-gray-800 cursor-pointer">
                    <option value="lainnya">Lainnya / Isi Manual</option>
                    <option value="ayah">Sama dengan Data Ayah</option>
                    <option value="ibu">Sama dengan Data Ibu</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nama Lengkap Wali -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Lengkap Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">person</span>
                    <input type="text" id="nama_wali" name="nama_wali" value="<?= esc($siswa['nama_wali'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 wali-field" placeholder="Nama wali jika ada">
                </div>
            </div>

            <!-- NIK Wali -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    NIK Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">credit_card</span>
                    <input type="text" id="nik_wali" name="nik_wali" value="<?= esc($siswa['nik_wali'] ?? '', 'attr') ?>" maxlength="16" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono wali-field" placeholder="16 digit NIK wali">
                </div>
            </div>

            <!-- Tempat Lahir Wali -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tempat Lahir Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_city</span>
                    <input type="text" id="tempat_lahir_wali" name="tempat_lahir_wali" value="<?= esc($siswa['tempat_lahir_wali'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 wali-field" placeholder="Isi Sesuai KK">
                </div>
            </div>

            <!-- Tanggal Lahir Wali -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tanggal Lahir Wali
                </label>
                <div class="relative">
                    <input type="text" 
                           id="tgl_lahir_wali" 
                           name="tgl_lahir_wali" 
                           value="<?= (!empty($siswa['tgl_lahir_wali']) && $siswa['tgl_lahir_wali'] !== '0000-00-00') ? esc($siswa['tgl_lahir_wali'], 'attr') : '' ?>" 
                           placeholder="Pilih tanggal lahir wali" 
                           class="datepicker-parent wali-field form-input-control border border-gray-300 dark:border-gray-600 pr-11">
                    <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                    </span>
                </div>
            </div>

            <!-- Pendidikan Terakhir Wali -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pendidikan Terakhir Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">school</span>
                    <input type="text" id="pdd_wali" name="pdd_wali" value="<?= esc($siswa['pdd_wali'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 wali-field" placeholder="Contoh: S1 / SMA">
                </div>
            </div>

            <!-- Pekerjaan Wali -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pekerjaan Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">work</span>
                    <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" value="<?= esc($siswa['pekerjaan_wali'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 wali-field" placeholder="Contoh: Wiraswasta / Karyawan">
                </div>
            </div>

            <!-- Penghasilan Bulanan Wali -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Penghasilan Bulanan Wali
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">payments</span>
                    <select id="penghasilan_wali" name="penghasilan_wali" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer wali-field">
                        <option value="">-- Pilih Rentang Penghasilan Wali --</option>
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
</div>
