<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">tune</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Status & Jadwal</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Istilah Pendaftaran (Alias Sistem)</label>
            <input type="text" name="app_alias" value="<?= $web['app_alias'] ?? 'PPDB' ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl border border-brand-100 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-brand-500 text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Gunakan kolom ini untuk mengganti istilah PPDB menjadi SPMB, PMBM, atau istilah lainnya.<br>
                    <strong>Pilihan Istilah:</strong> ini akan ikut memengaruhi Judul pada Tab Browser, Teks pada Tombol Pendaftaran, dan Header pada Laporan PDF / Kartu Ujian.
                </p>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kepanjangan Istilah (Nama Lengkap Sistem)</label>
            <input type="text" name="app_name" value="<?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?>" placeholder="Misal: Penerimaan Peserta Didik Baru"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Status Pendaftaran</label>
                <select name="status_ppdb"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="Buka" <?= ($web['status_ppdb'] == 'Buka') ? 'selected' : '' ?>>Buka</option>
                    <option value="Tutup" <?= ($web['status_ppdb'] == 'Tutup') ? 'selected' : '' ?>>Tutup</option>
                </select>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Semester</label>
                <select name="semester"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <option value="Ganjil" <?= ($web['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= ($web['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Tahun Pelajaran</label>
                <input type="text" name="th_pelajaran" value="<?= $web['th_pelajaran'] ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Tanggal & Waktu Pengumuman</label>
                <?php $tgl_pengumuman_val = (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_pengumuman'])) : ''; ?>
                <input type="datetime-local" name="tgl_pengumuman" value="<?= $tgl_pengumuman_val ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Status Pengumuman</label>
            <select name="pengumuman_aktif"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                <option value="1" <?= ($web['pengumuman_aktif'] == 1) ? 'selected' : '' ?>>Aktif (Bisa Dilihat)</option>
                <option value="0" <?= ($web['pengumuman_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Format No. Pendaftaran</label>
            <input type="text" name="format_no_daftar" value="<?= esc($web['format_no_daftar'] ?? 'PPDB-{TAHUN}-{URUT}') ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-brand-50 dark:bg-brand-500/10 rounded-xl border border-brand-100 dark:border-brand-500/20">
                <span class="material-symbols-outlined text-brand-500 text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Gunakan format berikut (gunakan kurung kurawal): <br>
                    <strong>{TAHUN}</strong> = Tahun (misal: <?= date('Y') ?>) &bull;
                    <strong>{BULAN}</strong> = Bulan (misal: <?= date('m') ?>) &bull;
                    <strong>{URUT}</strong> = Nomor urut otomatis (misal: 0001)
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Card: Pilihan Template Landing Page -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-brand-500">palette</span>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Template Landing Page</h3>
        </div>
        <a href="<?= base_url('/') ?>" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-brand-500 hover:text-brand-600 font-bold transition-colors">
            <span>Lihat Halaman Utama</span>
            <span class="material-symbols-outlined text-sm">open_in_new</span>
        </a>
    </div>
    <div class="p-6">
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Pilih salah satu desain landing page yang akan ditampilkan untuk pengunjung website. Simpan perubahan untuk menerapkan.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php
            $currentVariant = $web['landing_variant'] ?? 'index';
            $variants = [
                [
                    'value' => 'index',
                    'name'  => 'Modern Dynamic',
                    'desc'  => 'Desain modern dengan animasi dinamis, popup pengumuman, dan SEO terintegrasi.',
                    'icon'  => 'rocket',
                    'badge' => 'Rekomendasi',
                ],
                [
                    'value' => 'index2',
                    'name'  => 'Neo-Brutalism Pop',
                    'desc'  => 'Gaya Neo-Brutalism bold dengan garis batas tegas, solid drop-shadow, palet warna pop vibran, dan mikro-interaksi responsif.',
                    'icon'  => 'bolt',
                    'badge' => 'Neo-Brutalism',
                ],
                [
                    'value' => 'index3',
                    'name'  => 'Enhanced Classic',
                    'desc'  => 'Versi klasik yang ditingkatkan dengan scroll spy, animasi lightbox, dan navigasi aktif.',
                    'icon'  => 'diamond',
                    'badge' => 'Klasik',
                ],
            ];
            foreach ($variants as $v):
                $isSelected = ($currentVariant === $v['value']);
            ?>
                <div class="relative group">
                    <label class="block h-full cursor-pointer">
                        <input type="radio" name="landing_variant" value="<?= $v['value'] ?>" <?= $isSelected ? 'checked' : '' ?> class="sr-only peer">

                        <div class="h-full rounded-2xl border-2 p-5 pb-14 transition-all duration-200 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 peer-checked:border-brand-500 peer-checked:bg-brand-50/40 dark:peer-checked:bg-brand-500/10 hover:border-brand-300 hover:shadow-theme-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-10 h-10 rounded-xl bg-brand-50 dark:bg-brand-500/15 flex items-center justify-center text-brand-500 dark:text-brand-400 transition-colors">
                                        <span class="material-symbols-outlined"><?= $v['icon'] ?></span>
                                    </div>
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                        <?= $v['badge'] ?>
                                    </span>
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-white mb-1.5"><?= $v['name'] ?></h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed"><?= $v['desc'] ?></p>
                            </div>
                        </div>

                        <!-- Check badge top-right -->
                        <div class="absolute top-3 right-3 hidden peer-checked:flex items-center justify-center w-6 h-6 bg-brand-500 text-white rounded-full shadow-theme-xs pointer-events-none">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>

                        <!-- Selected indicator bottom-left -->
                        <div class="absolute bottom-4 left-5 hidden peer-checked:inline-flex items-center gap-1.5 text-xs font-bold text-brand-500 dark:text-brand-400 pointer-events-none">
                            <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                            <span>Sedang Digunakan</span>
                        </div>
                    </label>

                    <!-- Preview Button (tidak submit form) -->
                    <div class="absolute bottom-3 right-4 z-10">
                        <a href="<?= base_url('/?template=' . $v['value']) ?>" target="_blank"
                           class="inline-flex items-center gap-1 text-[11px] font-bold text-gray-500 hover:text-brand-600 dark:text-gray-400 dark:hover:text-brand-400 bg-gray-100 hover:bg-brand-50 dark:bg-gray-800 dark:hover:bg-brand-500/20 px-2.5 py-1 rounded-lg transition-all border border-gray-200 dark:border-gray-700"
                           title="Lihat pratinjau desain ini di tab baru">
                            <span class="material-symbols-outlined text-xs">visibility</span>
                            <span>Preview</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
