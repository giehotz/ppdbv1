<!-- Tab: Asal Sekolah -->
<div id="content-sekolah" class="tab-content hidden space-y-6">
    <!-- Header -->
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-50 text-teal-600 dark:bg-teal-500/15 dark:text-teal-400">
                <span class="material-symbols-outlined text-lg">school</span>
            </span>
            <span>Data Riwayat Asal Sekolah</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi jenjang dan sekolah sebelumnya tempat siswa menempuh pendidikan.</p>
    </div>

    <!-- Section 1: Identitas Sekolah Sebelumnya -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">domain</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">1. Identitas Sekolah Asal</h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            <!-- Nama Asal Sekolah -->
            <div class="md:col-span-2">
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama Asal Sekolah / Madrasah <span class="text-red-500">*</span>
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">school</span>
                    <input type="text" name="nama_sekolah" value="<?= esc($siswa['nama_sekolah'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: RA Al-Hidayah / SDN 1 Sukamaju / SMP Negeri 1">
                </div>
            </div>

            <!-- NPSN Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    NPSN Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">numbers</span>
                    <input type="text" name="npsn_sekolah" value="<?= esc($siswa['npsn_sekolah'] ?? '', 'attr') ?>" maxlength="8" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="8 digit NPSN sekolah">
                </div>
            </div>

            <!-- Jenjang Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Jenjang Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">stairs</span>
                    <select name="jenjang_sekolah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="TK/RA/PAUD" <?= ($siswa['jenjang_sekolah'] ?? '') == 'TK/RA/PAUD' ? 'selected' : '' ?>>TK / RA / PAUD</option>
                        <option value="SD/MI" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SD/MI' ? 'selected' : '' ?>>SD / MI</option>
                        <option value="SMP/MTs" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SMP/MTs' ? 'selected' : '' ?>>SMP / MTs</option>
                        <option value="Lainnya" <?= ($siswa['jenjang_sekolah'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya / Tidak Sekolah</option>
                    </select>
                </div>
            </div>

            <!-- Status Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Status Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">verified</span>
                    <select name="status_sekolah" class="form-input-control border border-gray-300 dark:border-gray-600 cursor-pointer">
                        <option value="">-- Pilih Status --</option>
                        <option value="Negeri" <?= ($siswa['status_sekolah'] ?? '') == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                        <option value="Swasta" <?= ($siswa['status_sekolah'] ?? '') == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                    </select>
                </div>
            </div>

            <!-- Kabupaten / Kota Asal Sekolah -->
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Kabupaten / Kota Asal Sekolah
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">location_on</span>
                    <input type="text" name="lokasi_sekolah" value="<?= esc($siswa['lokasi_sekolah'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Kota / Kabupaten sekolah asal">
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Peminatan / Kompetensi Keahlian Sebelumnya -->
    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-4">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">tune</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">2. Peminatan / Jurusan Sebelumnya</h4>
        </div>

        <div>
            <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                Peminatan / Jurusan (Khusus Lanjutan SMP/SMA/SMK)
            </label>
            <div class="input-icon-wrapper">
                <span class="input-icon material-symbols-outlined">category</span>
                <input type="text" name="komp_ahli" value="<?= esc($siswa['komp_ahli'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600" placeholder="Contoh: IPA / IPS / TKJ / Rekayasa Perangkat Lunak (Kosongkan jika dasar)">
            </div>
            <p class="text-[11px] text-gray-400 mt-1.5">Kosongkan kolom ini apabila jenjang yang didaftar adalah jenjang dasar (TK/SD).</p>
        </div>
    </div>
</div>
