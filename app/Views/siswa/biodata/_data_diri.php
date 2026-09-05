<!-- Tab: Data Diri -->
<div id="content-dataDiri" class="tab-content space-y-6">
    <!-- Tab Header & Quick Unlock Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pb-2 border-b border-gray-100 dark:border-gray-800">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                    <span class="material-symbols-outlined text-lg">badge</span>
                </span>
                <span>Data Pribadi Siswa</span>
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pastikan identitas kependudukan siswa sesuai dengan Kartu Keluarga &amp; Akta Kelahiran.</p>
        </div>
        
        <?php if ($isFinal): ?>
            <div class="flex items-center gap-2.5 flex-wrap">
                <?php if (!isset($pendingRequest) || !$pendingRequest): ?>
                    <button type="button" onclick="requestUnlock()" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-2 px-3.5 shadow-sm transition duration-200">
                        <span class="material-symbols-outlined text-sm">lock_open</span>
                        <span>Ajukan Buka Kunci</span>
                    </button>
                <?php endif; ?>

                <div class="flex flex-col items-end">
                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-900/50 text-[10px] font-bold px-3 py-1">
                        <span class="material-symbols-outlined text-xs">lock</span> Data Terkunci (Final)
                    </span>
                    <?php if (isset($pendingRequest) && $pendingRequest): ?>
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-900/50 text-[10px] font-semibold px-2.5 py-0.5 mt-1">
                            <span class="material-symbols-outlined text-xs">hourglass_top</span> Menunggu Persetujuan
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 1: Identitas Pokok & Kependudukan -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">fingerprint</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">1. Identitas Pokok &amp; Kependudukan</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- NISN (Readonly) -->
            <div>
                <label class="mb-2 flex items-center justify-between text-xs font-bold text-gray-700 dark:text-gray-300">
                    <span>NISN <span class="text-red-500">*</span></span>
                    <span class="inline-flex items-center gap-0.5 text-[10px] font-semibold text-gray-400 dark:text-gray-500">
                        <span class="material-symbols-outlined text-xs">lock</span> Terkunci Otomatis
                    </span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">tag</span>
                    <input type="text" name="nisn" value="<?= esc($siswa['nisn'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono font-bold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/80 cursor-not-allowed" readonly>
                </div>
            </div>

            <!-- NIK -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">credit_card</span>
                    <input type="text" name="nik" value="<?= esc($siswa['nik'] ?? '', 'attr') ?>" maxlength="16" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="16 digit NIK sesuai KK">
                </div>
            </div>

            <!-- Nama Lengkap Siswa -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">person</span>
                    <input type="text" name="nama_lengkap" value="<?= esc($siswa['nama_lengkap'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-medium" placeholder="Nama lengkap sesuai akta kelahiran / ijazah">
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">wc</span>
                    <select name="jk" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" <?= ($siswa['jk'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= ($siswa['jk'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Agama -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Agama <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">menu_book</span>
                    <select name="agama" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" <?= ($siswa['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                        <option value="Kristen" <?= ($siswa['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                        <option value="Katolik" <?= ($siswa['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                        <option value="Hindu" <?= ($siswa['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                        <option value="Buddha" <?= ($siswa['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                        <option value="Konghucu" <?= ($siswa['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                    </select>
                </div>
            </div>

            <!-- Tempat Lahir -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tempat Lahir <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_city</span>
                    <input type="text" name="tempat_lahir" value="<?= esc($siswa['tempat_lahir'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Kota / Kabupaten Kelahiran">
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Tanggal Lahir <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">calendar_month</span>
                    <input type="date" name="tgl_lahir" value="<?= esc($siswa['tgl_lahir'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Kontak & Komunikasi Siswa -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">contact_phone</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">2. Kontak &amp; Komunikasi</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- No. HP / WhatsApp Siswa -->
            <div>
                <label class="mb-2 flex items-center justify-between text-xs font-bold text-gray-700 dark:text-gray-300">
                    <span>No. HP / WhatsApp Siswa</span>
                    <span class="text-[10px] text-gray-400 dark:text-gray-500 font-normal">Aktif WhatsApp</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">chat</span>
                    <input type="text" name="no_hp_siswa" value="<?= esc($siswa['no_hp_siswa'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <!-- Email Siswa / Ortu -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Email Siswa / Orang Tua
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">mail</span>
                    <input type="email" name="email" value="<?= esc($siswa['email'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="nama@email.com">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Status Keluarga & Posisi Anak -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">group</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">3. Status Keluarga &amp; Posisi Anak</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
            <!-- Status dalam Keluarga -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Status dalam Keluarga
                </label>
                <select name="status_keluarga" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                    <option value="">-- Pilih Status --</option>
                    <option value="Anak Kandung" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                    <option value="Anak Tiri" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                    <option value="Anak Angkat" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Angkat' ? 'selected' : '' ?>>Anak Angkat</option>
                </select>
            </div>

            <!-- Anak Ke- -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Anak Ke-
                </label>
                <input type="number" name="anak_ke" value="<?= esc($siswa['anak_ke'] ?? '', 'attr') ?>" min="1" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: 1">
            </div>

            <!-- Jumlah Saudara -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jumlah Saudara Kandung
                </label>
                <input type="number" name="jml_saudara" value="<?= esc($siswa['jml_saudara'] ?? '', 'attr') ?>" min="0" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: 2">
            </div>
        </div>
    </div>

    <!-- Section 4: Minat & Riwayat Prasekolah -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">stars</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">4. Minat &amp; Riwayat Prasekolah</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Hobi -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Hobi / Minat
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">sports_soccer</span>
                    <input type="text" name="hobi" value="<?= esc($siswa['hobi'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Membaca, Olahraga, Menggambar, dll.">
                </div>
            </div>

            <!-- Cita-cita -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Cita-cita
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">rocket_launch</span>
                    <input type="text" name="cita" value="<?= esc($siswa['cita'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Dokter, Guru, Insinyur, dll.">
                </div>
            </div>

            <!-- Pernah PAUD? -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pernah PAUD?
                </label>
                <select name="paud" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                    <option value="">-- Pilih --</option>
                    <option value="Ya" <?= ($siswa['paud'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya, Pernah</option>
                    <option value="Tidak" <?= ($siswa['paud'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>

            <!-- Pernah TK / RA? -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pernah TK / RA?
                </label>
                <select name="tk" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                    <option value="">-- Pilih --</option>
                    <option value="Ya" <?= ($siswa['tk'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya, Pernah</option>
                    <option value="Tidak" <?= ($siswa['tk'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>
        </div>
    </div>
</div>
