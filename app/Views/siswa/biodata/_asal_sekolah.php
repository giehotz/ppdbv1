<!-- Tab: Asal Sekolah -->
<div id="content-sekolah" class="tab-content hidden space-y-4">
    <div class="border-b border-gray-100 dark:border-gray-800 pb-3">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Data Riwayat Asal Sekolah</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Informasi jenjang dan sekolah sebelumnya tempat siswa menempuh pendidikan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Nama Asal Sekolah / Madrasah <span class="text-red-500">*</span></label>
            <input type="text" name="nama_sekolah" value="<?= esc($siswa['nama_sekolah'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Contoh: RA Al-Hidayah / SDN 1 Contoh">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">NPSN Asal Sekolah</label>
            <input type="text" name="npsn_sekolah" value="<?= esc($siswa['npsn_sekolah'] ?? '', 'attr') ?>" maxlength="8" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500 font-mono" placeholder="8 digit NPSN">
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Jenjang Asal Sekolah</label>
            <select name="jenjang_sekolah" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Jenjang --</option>
                <option value="TK/RA/PAUD" <?= ($siswa['jenjang_sekolah'] ?? '') == 'TK/RA/PAUD' ? 'selected' : '' ?>>TK / RA / PAUD</option>
                <option value="SD/MI" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SD/MI' ? 'selected' : '' ?>>SD / MI</option>
                <option value="SMP/MTs" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SMP/MTs' ? 'selected' : '' ?>>SMP / MTs</option>
                <option value="Lainnya" <?= ($siswa['jenjang_sekolah'] ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya / Tidak Sekolah</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Status Asal Sekolah</label>
            <select name="status_sekolah" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500">
                <option value="">-- Pilih Status --</option>
                <option value="Negeri" <?= ($siswa['status_sekolah'] ?? '') == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                <option value="Swasta" <?= ($siswa['status_sekolah'] ?? '') == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
            </select>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Kabupaten / Kota Asal Sekolah</label>
            <input type="text" name="lokasi_sekolah" value="<?= esc($siswa['lokasi_sekolah'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Kota / Kabupaten">
        </div>

        <div class="md:col-span-2">
            <label class="mb-2.5 block text-sm font-medium text-black dark:text-white">Peminatan / Jurusan (Khusus Lanjutan)</label>
            <input type="text" name="komp_ahli" value="<?= esc($siswa['komp_ahli'] ?? '', 'attr') ?>" class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-sm text-black outline-none transition focus:border-brand-500 active:border-brand-500 disabled:cursor-default disabled:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-brand-500" placeholder="Kosongkan jika jenjang dasar">
        </div>
    </div>
</div>
