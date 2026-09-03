<!-- Tab: Data Diri -->
<div id="content-dataDiri" class="tab-content space-y-4">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b border-gray-100 dark:border-gray-800 pb-3">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Data Pribadi Siswa</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pastikan identitas kependudukan siswa sesuai dengan Kartu Keluarga &amp; Akta Kelahiran.</p>
        </div>
        
        <?php if ($isFinal): ?>
            <div class="flex items-center gap-2.5">
                <?php if (!isset($pendingRequest) || !$pendingRequest): ?>
                    <button type="button" onclick="requestUnlock()" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-1.5 px-3 shadow-theme-xs transition duration-200">
                        <span class="material-symbols-outlined text-sm">lock_open</span>
                        <span>Ajukan Buka Kunci</span>
                    </button>
                <?php endif; ?>

                <div class="flex flex-col items-end">
                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-900/50 text-[10px] font-bold px-2.5 py-0.5">
                        <span class="material-symbols-outlined text-xs">lock</span> Data Terkunci (Final)
                    </span>
                    <?php if (isset($pendingRequest) && $pendingRequest): ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 text-[10px] font-semibold px-2.5 py-0.5 mt-1">
                            <span class="material-symbols-outlined text-xs">hourglass_top</span> Menunggu Persetujuan Buka Kunci
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">NISN <span class="text-red-500">*</span></label>
            <input type="text" name="nisn" value="<?= esc($siswa['nisn'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-gray-100 py-3 px-5 text-sm text-gray-500 outline-none transition dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 font-mono disabled:cursor-not-allowed" readonly>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
            <input type="text" name="nik" value="<?= esc($siswa['nik'] ?? '', 'attr') ?>" maxlength="16" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="16 digit NIK">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Nama Lengkap Siswa <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="<?= esc($siswa['nama_lengkap'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Nama lengkap sesuai akta kelahiran">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jk" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" <?= ($siswa['jk'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($siswa['jk'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Status dalam Keluarga</label>
            <select name="status_keluarga" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Status --</option>
                <option value="Anak Kandung" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                <option value="Anak Tiri" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                <option value="Anak Angkat" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Angkat' ? 'selected' : '' ?>>Anak Angkat</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Agama <span class="text-red-500">*</span></label>
            <select name="agama" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Agama --</option>
                <option value="Islam" <?= ($siswa['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                <option value="Kristen" <?= ($siswa['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                <option value="Katolik" <?= ($siswa['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                <option value="Hindu" <?= ($siswa['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                <option value="Buddha" <?= ($siswa['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                <option value="Konghucu" <?= ($siswa['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="<?= esc($siswa['tempat_lahir'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Kota / Kabupaten Kelahiran">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input type="date" name="tgl_lahir" value="<?= esc($siswa['tgl_lahir'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Email Siswa / Ortu</label>
            <input type="email" name="email" value="<?= esc($siswa['email'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="nama@email.com">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">No. HP / WhatsApp Siswa</label>
            <input type="text" name="no_hp_siswa" value="<?= esc($siswa['no_hp_siswa'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="08xxxxxxxxxx">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Anak Ke-</label>
            <input type="number" name="anak_ke" value="<?= esc($siswa['anak_ke'] ?? '', 'attr') ?>" min="1" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Jumlah Saudara</label>
            <input type="number" name="jml_saudara" value="<?= esc($siswa['jml_saudara'] ?? '', 'attr') ?>" min="0" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Hobi / Minat</label>
            <input type="text" name="hobi" value="<?= esc($siswa['hobi'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Membaca, Olahraga, dll.">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Cita-cita</label>
            <input type="text" name="cita" value="<?= esc($siswa['cita'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Dokter, Guru, Insinyur, dll.">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Pernah PAUD?</label>
            <select name="paud" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['paud'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['paud'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Pernah TK / RA?</label>
            <select name="tk" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['tk'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['tk'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>
    </div>
</div>
