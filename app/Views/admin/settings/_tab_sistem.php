<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">tune</span>
        <h3 class="text-lg font-bold text-on-surface">Status & Jadwal</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Istilah Pendaftaran (Alias Sistem)</label>
            <input type="text" name="app_alias" value="<?= $web['app_alias'] ?? 'PPDB' ?>"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-primary-container/20 rounded-lg border border-primary/10">
                <span class="material-symbols-outlined text-primary text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Gunakan kolom ini untuk mengganti istilah PPDB menjadi SPMB, PMBM, atau istilah lainnya.<br>
                    <strong>Pilihan Istilah:</strong> ini akan ikut memengaruhi Judul pada Tab Browser, Teks pada Tombol Pendaftaran, dan Header pada Laporan PDF / Kartu Ujian.
                </p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Kepanjangan Istilah (Nama Lengkap Sistem)</label>
            <input type="text" name="app_name" value="<?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?>" placeholder="Misal: Penerimaan Peserta Didik Baru"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">Status Pendaftaran</label>
                <select name="status_ppdb"
                        class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    <option value="Buka" <?= ($web['status_ppdb'] == 'Buka') ? 'selected' : '' ?>>Buka</option>
                    <option value="Tutup" <?= ($web['status_ppdb'] == 'Tutup') ? 'selected' : '' ?>>Tutup</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">Semester</label>
                <select name="semester"
                        class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    <option value="Ganjil" <?= ($web['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= ($web['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">Tahun Pelajaran</label>
                <input type="text" name="th_pelajaran" value="<?= $web['th_pelajaran'] ?>"
                       class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">Tanggal & Waktu Pengumuman</label>
                <?php $tgl_pengumuman_val = (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_pengumuman'])) : ''; ?>
                <input type="datetime-local" name="tgl_pengumuman" value="<?= $tgl_pengumuman_val ?>"
                       class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Status Pengumuman</label>
            <select name="pengumuman_aktif"
                    class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <option value="1" <?= ($web['pengumuman_aktif'] == 1) ? 'selected' : '' ?>>Aktif (Bisa Dilihat)</option>
                <option value="0" <?= ($web['pengumuman_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Format No. Pendaftaran</label>
            <input type="text" name="format_no_daftar" value="<?= esc($web['format_no_daftar'] ?? 'PPDB-{TAHUN}-{URUT}') ?>"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
            <div class="mt-2 flex items-start gap-2 p-3 bg-primary-container/20 rounded-lg border border-primary/10">
                <span class="material-symbols-outlined text-primary text-base flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-on-surface-variant leading-relaxed">
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
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-secondary">palette</span>
        <h3 class="text-lg font-bold text-on-surface">Template Landing Page</h3>
    </div>
    <div class="p-6">
        <p class="text-sm text-on-surface-variant mb-5">Pilih salah satu desain landing page yang akan ditampilkan untuk pengunjung website.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php
            $currentVariant = $web['landing_variant'] ?? 'index';
            $variants = [
                [
                    'value' => 'index',
                    'name'  => 'Modern Dynamic',
                    'desc'  => 'Desain modern dengan animasi dinamis, popup pengumuman, dan SEO terintegrasi.',
                    'icon'  => 'rocket',
                ],
                [
                    'value' => 'index2',
                    'name'  => 'Clean Minimal',
                    'desc'  => 'Tampilan bersih dengan parallax hero, timeline staggered, dan transisi halus.',
                    'icon'  => 'spa',
                ],
                [
                    'value' => 'index3',
                    'name'  => 'Enhanced Classic',
                    'desc'  => 'Versi klasik yang ditingkatkan dengan scroll spy, animasi lightbox, dan navigasi aktif.',
                    'icon'  => 'diamond',
                ],
            ];
            foreach ($variants as $v):
                $isSelected = ($currentVariant === $v['value']);
            ?>
                <label class="relative cursor-pointer group">
                    <input type="radio" name="landing_variant" value="<?= $v['value'] ?>" <?= $isSelected ? 'checked' : '' ?> class="sr-only peer">

                    <div class="h-full rounded-xl border-2 p-5 transition-all duration-200 bg-surface border-outline-variant peer-checked:border-primary peer-checked:bg-primary-container/20 hover:border-primary/40 hover:shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary peer-checked:bg-primary peer-checked:text-on-primary transition-colors">
                                <span class="material-symbols-outlined"><?= $v['icon'] ?></span>
                            </div>
                            <h4 class="font-bold text-on-surface"><?= $v['name'] ?></h4>
                        </div>
                        <p class="text-xs text-on-surface-variant leading-relaxed"><?= $v['desc'] ?></p>
                    </div>

                    <div class="absolute top-3 right-3 hidden peer-checked:flex items-center justify-center w-6 h-6 bg-primary text-on-primary rounded-full shadow-sm">
                        <span class="material-symbols-outlined text-sm">check</span>
                    </div>

                    <div class="absolute bottom-5 left-5 hidden peer-checked:inline-flex items-center gap-1.5 text-xs font-bold text-primary">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Terpilih
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
</div>
