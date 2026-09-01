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
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NISN <span class="text-red-500">*</span></label>
            <input type="text" name="nisn" value="<?= esc($siswa['nisn'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-100 px-3.5 text-xs text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 font-mono" readonly>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
            <input type="text" name="nik" value="<?= esc($siswa['nik'] ?? '', 'attr') ?>" maxlength="16" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 font-mono" placeholder="16 digit NIK">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap Siswa <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="<?= esc($siswa['nama_lengkap'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Nama lengkap sesuai akta kelahiran">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jk" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L" <?= ($siswa['jk'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($siswa['jk'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status dalam Keluarga</label>
            <select name="status_keluarga" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih Status --</option>
                <option value="Anak Kandung" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                <option value="Anak Tiri" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                <option value="Anak Angkat" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Angkat' ? 'selected' : '' ?>>Anak Angkat</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Agama <span class="text-red-500">*</span></label>
            <select name="agama" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
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
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="<?= esc($siswa['tempat_lahir'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Kota / Kabupaten Kelahiran">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input type="date" name="tgl_lahir" value="<?= esc($siswa['tgl_lahir'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Siswa / Ortu</label>
            <input type="email" name="email" value="<?= esc($siswa['email'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="nama@email.com">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. HP / WhatsApp Siswa</label>
            <input type="text" name="no_hp_siswa" value="<?= esc($siswa['no_hp_siswa'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="08xxxxxxxxxx">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Anak Ke-</label>
            <input type="number" name="anak_ke" value="<?= esc($siswa['anak_ke'] ?? '', 'attr') ?>" min="1" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Saudara</label>
            <input type="number" name="jml_saudara" value="<?= esc($siswa['jml_saudara'] ?? '', 'attr') ?>" min="0" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Hobi / Minat</label>
            <input type="text" name="hobi" value="<?= esc($siswa['hobi'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Membaca, Olahraga, dll.">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Cita-cita</label>
            <input type="text" name="cita" value="<?= esc($siswa['cita'] ?? '', 'attr') ?>" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" placeholder="Dokter, Guru, Insinyur, dll.">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pernah PAUD?</label>
            <select name="paud" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['paud'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['paud'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pernah TK / RA?</label>
            <select name="tk" class="h-10.5 w-full rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['tk'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['tk'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>
    </div>
</div>
