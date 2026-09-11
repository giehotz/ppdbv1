<!-- Tab: Sekolah Asal (Pindahan) -->
<div id="content-asal" class="tab-content hidden space-y-6">
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-50 text-teal-600 dark:bg-teal-500/15 dark:text-teal-400">
                <span class="material-symbols-outlined text-lg">school</span>
            </span>
            <span>Data Sekolah Asal</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi sekolah / madrasah asal tempat siswa sebelumnya menempuh pendidikan.</p>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">domain</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">1. Identitas Sekolah Asal</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Jenjang Asal -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jenjang Asal <span class="text-red-500">*</span>
                </label>
                <select name="jenjang_sekolah_asal" id="jenjang_sekolah_asal" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer" required>
                    <option value="">-- Pilih Jenjang Asal --</option>
                    <?php foreach (($semuaJenjang ?? []) as $kode => $label): ?>
                        <option value="<?= esc($kode) ?>" <?= ($pindahan['jenjang_sekolah_asal'] ?? '') === $kode ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Nama Sekolah Asal -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Sekolah Asal <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_sekolah_asal" value="<?= esc($pindahan['nama_sekolah_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: SDN 1 Bandung / SMPIT Al-Falaah">
            </div>

            <!-- NPSN -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">NPSN Sekolah Asal</label>
                <input type="text" name="npsn_sekolah_asal" value="<?= esc($pindahan['npsn_sekolah_asal'] ?? '', 'attr') ?>" maxlength="8" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="8 digit NPSN">
            </div>

            <!-- Kota Asal -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Kota / Kabupaten Asal</label>
                <input type="text" name="kota_asal" value="<?= esc($pindahan['kota_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: Bandung / Jakarta Timur">
            </div>

            <!-- Provinsi Asal -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Provinsi Asal</label>
                <input type="text" name="provinsi_asal" value="<?= esc($pindahan['provinsi_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: Jawa Barat">
            </div>

            <!-- Alamat Sekolah Asal -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Alamat Lengkap Sekolah</label>
                <textarea name="alamat_sekolah_asal" rows="2" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Alamat jalan sekolah asal"><?= esc($pindahan['alamat_sekolah_asal'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">calendar_month</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">2. Periode &amp; Kelas</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Tahun Masuk -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Tahun Masuk Sekolah Asal</label>
                <input type="number" name="tahun_masuk_sekolah_asal" value="<?= esc($pindahan['tahun_masuk_sekolah_asal'] ?? '', 'attr') ?>" min="2000" max="<?= date('Y') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Contoh: 2020">
            </div>

            <!-- Tahun Keluar -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Tahun Keluar / Pindah</label>
                <input type="number" name="tahun_keluar_sekolah_asal" value="<?= esc($pindahan['tahun_keluar_sekolah_asal'] ?? '', 'attr') ?>" min="2000" max="<?= date('Y') + 1 ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Contoh: 2026">
            </div>

            <!-- Kelas Terakhir -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Kelas Terakhir Ditempuh</label>
                <input type="text" name="kelas_sekolah_asal" value="<?= esc($pindahan['kelas_sekolah_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: 6 / IX / XII">
            </div>

            <!-- Diterima di Kelas -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Diterima di Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kelas_diterima" value="<?= esc($pindahan['kelas_diterima'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: 1 / VII / X" required>
            </div>

            <!-- Jurusan (untuk SMA/SMK) -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Jurusan / Peminatan (jika ada)</label>
                <input type="text" name="jurusan_sekolah_asal" value="<?= esc($pindahan['jurusan_sekolah_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: IPA / IPS / TKJ (kosongkan jika dasar)">
            </div>

            <!-- No. Ijazah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">No. Ijazah / Surat Kelulusan</label>
                <input type="text" name="no_ijazah_sekolah_asal" value="<?= esc($pindahan['no_ijazah_sekolah_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Nomor ijazah terakhir">
            </div>

            <!-- Tanggal Ijazah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Tanggal Ijazah / Kelulusan</label>
                <input type="date" name="tgl_ijazah_sekolah_asal" value="<?= esc($pindahan['tgl_ijazah_sekolah_asal'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600">
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">flag</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">3. Alasan Pindah</h4>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 -mt-1">Lengkapi alasan pindah berikut ini.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Kategori Alasan -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Kategori Alasan Pindah</label>
                <select name="alasan_pindah_kategori" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach (($kategoriAlasan ?? []) as $key => $label): ?>
                        <option value="<?= esc($key) ?>" <?= ($pindahan['alasan_pindah_kategori'] ?? '') === $key ? 'selected' : '' ?>><?= esc($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Alasan Lengkap -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">Alasan Pindah (Detail)</label>
                <textarea name="alasan_pindah" rows="3" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Jelaskan secara singkat alasan Anda pindah sekolah..."><?= esc($pindahan['alasan_pindah'] ?? '') ?></textarea>
            </div>
        </div>
    </div>
</div>