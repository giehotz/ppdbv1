<!-- Tab: Sekolah -->
<div id="content-sekolah" class="tab-content hidden">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Asal Sekolah</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
            <input type="text" name="nama_sekolah" value="<?= esc($siswa['nama_sekolah'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NPSN Sekolah</label>
            <input type="text" name="npsn_sekolah" value="<?= esc($siswa['npsn_sekolah'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenjang Sekolah</label>
            <select name="jenjang_sekolah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="TK/RA/PAUD" <?= ($siswa['jenjang_sekolah'] ?? '') == 'TK/RA/PAUD' ? 'selected' : '' ?>>TK/RA/PAUD</option>
                <option value="SD/MI" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SD/MI' ? 'selected' : '' ?>>SD/MI</option>
                <option value="SMP/MTs" <?= ($siswa['jenjang_sekolah'] ?? '') == 'SMP/MTs' ? 'selected' : '' ?>>SMP/MTs</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Sekolah</label>
            <select name="status_sekolah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Negeri" <?= ($siswa['status_sekolah'] ?? '') == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                <option value="Swasta" <?= ($siswa['status_sekolah'] ?? '') == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Sekolah</label>
            <input type="text" name="lokasi_sekolah" value="<?= esc($siswa['lokasi_sekolah'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Kompetensi Keahlian (Jurusan)</label>
            <input type="text" name="komp_ahli" value="<?= esc($siswa['komp_ahli'] ?? '', 'attr') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Teknik Komputer dan Jaringan">
        </div>
    </div>
</div>
