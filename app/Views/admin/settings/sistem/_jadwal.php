<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">schedule</span>
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Jadwal Seleksi & Pengumuman</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kontrol jadwal pelaksanaan ujian seleksi dan tanggal publikasi pengumuman kelulusan.</p>
        </div>
    </div>
    <div class="p-6 space-y-5">
        <!-- Pengumuman Kelulusan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Status Pengumuman</label>
                <select name="pengumuman_aktif"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="1" <?= ($web['pengumuman_aktif'] == 1) ? 'selected' : '' ?>>Aktif (Bisa Dilihat)</option>
                    <option value="0" <?= ($web['pengumuman_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Mengatur apakah hasil seleksi/kelulusan sudah dapat diakses siswa.</p>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Tanggal & Waktu Pengumuman</label>
                <?php $tgl_pengumuman_val = (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_pengumuman'])) : ''; ?>
                <input type="datetime-local" name="tgl_pengumuman" value="<?= $tgl_pengumuman_val ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Waktu rilis resmi hasil pengumuman kelulusan pendaftaran.</p>
            </div>
        </div>

        <!-- Ujian Seleksi -->
        <div class="pt-4 border-t border-gray-100 dark:border-gray-800/80 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Fitur Ujian Seleksi</label>
                <select name="ujian_aktif"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="0" <?= (($web['ujian_aktif'] ?? '0') == '0') ? 'selected' : '' ?>>Tidak Ada Ujian (Seleksi Berkas/Administrasi)</option>
                    <option value="1" <?= (($web['ujian_aktif'] ?? '0') == '1') ? 'selected' : '' ?>>Ada Ujian Seleksi</option>
                </select>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Pilih jika tahapan seleksi calon siswa memerlukan tes/ujian.</p>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Tanggal &amp; Waktu Ujian Seleksi</label>
                <?php $tgl_ujian_val = (!empty($web['tgl_ujian']) && $web['tgl_ujian'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_ujian'])) : ''; ?>
                <input type="datetime-local" name="tgl_ujian" value="<?= $tgl_ujian_val ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">
                    Ditampilkan pada hitung mundur dashboard siswa dan kartu peserta jika fitur ujian aktif.
                </p>
            </div>
        </div>
    </div>
</div>
