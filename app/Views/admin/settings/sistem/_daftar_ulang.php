<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-brand-500">backpack</span>
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Ulang &amp; Seragam</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pengaturan akses konfirmasi daftar ulang, formulir seragam, tenggat waktu, dan catatan penutupan.</p>
            </div>
        </div>
        <a href="<?= base_url('admin/daftar-ulang') ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
            <span>Buka Modul Daftar Ulang</span>
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Status Akses Daftar Ulang</label>
                <select name="daftar_ulang_aktif"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="1" <?= (($web['daftar_ulang_aktif'] ?? '1') == '1') ? 'selected' : '' ?>>Aktif / Dibuka</option>
                    <option value="0" <?= (($web['daftar_ulang_aktif'] ?? '1') == '0') ? 'selected' : '' ?>>Tidak Aktif / Ditutup</option>
                </select>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Mengontrol apakah siswa yang lulus seleksi dapat mengisi formulir daftar ulang.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Visibilitas Bagian 2 (Seragam)</label>
                <select name="seragam_aktif"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="1" <?= (($web['seragam_aktif'] ?? '1') == '1') ? 'selected' : '' ?>>Tampilkan Formulir Seragam</option>
                    <option value="0" <?= (($web['seragam_aktif'] ?? '1') == '0') ? 'selected' : '' ?>>Sembunyikan (Hanya Kesediaan)</option>
                </select>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Sembunyikan jika pihak sekolah tidak mengoordinir pemesanan seragam.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Batas Waktu Penutupan (Opsional)</label>
                <?php $tgl_tutup_du = (!empty($web['tgl_tutup_daftar_ulang']) && $web['tgl_tutup_daftar_ulang'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_tutup_daftar_ulang'])) : ''; ?>
                <input type="datetime-local" name="tgl_tutup_daftar_ulang" value="<?= $tgl_tutup_du ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Batas akhir pengisian konfirmasi daftar ulang oleh calon siswa.</p>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Instruksi / Catatan Pengumuman untuk Siswa saat Ditutup (Opsional)</label>
            <textarea name="pesan_daftar_ulang" rows="3" placeholder="Pesan pemberitahuan jika pendaftaran ulang telah ditutup atau berakhir..."
                      class="w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all"><?= esc($web['pesan_daftar_ulang'] ?? '') ?></textarea>
        </div>
    </div>
</div>
