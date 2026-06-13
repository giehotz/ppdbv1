<!-- Tab: Data Diri -->
<div id="content-dataDiri" class="tab-content">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-800">Data Pribadi Siswa</h3>
        <?php if ($isFinal): ?>
            <div class="flex items-center gap-3">
                <?php if (!isset($pendingRequest) || !$pendingRequest): ?>
                    <button type="button" onclick="requestUnlock()" class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold py-1.5 px-3 rounded shadow-sm transition duration-200 flex items-center">
                        <i class="fas fa-unlock-alt mr-1"></i> Ajukan Buka Kunci
                    </button>
                <?php endif; ?>

                <div class="flex flex-col items-end">
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400 mb-1"><i class="fas fa-lock mr-1"></i> Data Terkunci (Final)</span>
                    <?php if (isset($pendingRequest) && $pendingRequest): ?>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400"><i class="fas fa-hourglass-half mr-1"></i> Menunggu Persetujuan Admin (Buka Kunci)</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NISN <span class="text-red-500">*</span></label>
            <input type="text" name="nisn" value="<?= $siswa['nisn'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
            <input type="text" name="nik" value="<?= $siswa['nik'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="<?= $siswa['nama_lengkap'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jk" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="L" <?= ($siswa['jk'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= ($siswa['jk'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Keluarga</label>
            <select name="status_keluarga" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Status --</option>
                <option value="Anak Kandung" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Kandung' ? 'selected' : '' ?>>Anak Kandung</option>
                <option value="Anak Tiri" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Tiri' ? 'selected' : '' ?>>Anak Tiri</option>
                <option value="Anak Angkat" <?= ($siswa['status_keluarga'] ?? '') == 'Anak Angkat' ? 'selected' : '' ?>>Anak Angkat</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
            <select name="agama" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Islam" <?= ($siswa['agama'] ?? '') == 'Islam' ? 'selected' : '' ?>>Islam</option>
                <option value="Kristen" <?= ($siswa['agama'] ?? '') == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                <option value="Katolik" <?= ($siswa['agama'] ?? '') == 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                <option value="Hindu" <?= ($siswa['agama'] ?? '') == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                <option value="Buddha" <?= ($siswa['agama'] ?? '') == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                <option value="Konghucu" <?= ($siswa['agama'] ?? '') == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="<?= $siswa['tempat_lahir'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input type="date" name="tgl_lahir" value="<?= $siswa['tgl_lahir'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="<?= $siswa['email'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">No. HP Siswa</label>
            <input type="text" name="no_hp_siswa" value="<?= $siswa['no_hp_siswa'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Anak Ke</label>
            <input type="number" name="anak_ke" value="<?= $siswa['anak_ke'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Saudara</label>
            <input type="number" name="jml_saudara" value="<?= $siswa['jml_saudara'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Hobi</label>
            <input type="text" name="hobi" value="<?= $siswa['hobi'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cita-cita</label>
            <input type="text" name="cita" value="<?= $siswa['cita'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pernah PAUD?</label>
            <select name="paud" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['paud'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['paud'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pernah TK?</label>
            <select name="tk" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih --</option>
                <option value="Ya" <?= ($siswa['tk'] ?? '') == 'Ya' ? 'selected' : '' ?>>Ya</option>
                <option value="Tidak" <?= ($siswa['tk'] ?? '') == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">No. KK Keluarga</label>
            <input type="text" name="no_kk" value="<?= $siswa['no_kk'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Kepala Keluarga</label>
            <input type="text" name="kepala_keluarga" value="<?= $siswa['kepala_keluarga'] ?? '' ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>
</div>
