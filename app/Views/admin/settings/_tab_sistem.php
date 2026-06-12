<!-- Card 1: Pengaturan PPDB -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Status & Jadwal</h3>
    </div>
    <div class="p-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Istilah Pendaftaran (Alias Sistem)</label>
            <input type="text" name="app_alias" value="<?= $web['app_alias'] ?? 'PPDB' ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border" required>
            <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
                <i class="fas fa-info-circle mr-1"></i> Gunakan kolom ini untuk mengganti istilah PPDB menjadi SPMB, PMBM, atau istilah lainnya. <br>
                <strong>Pilihan Istilah:</strong> ini akan ikut memengaruhi Judul pada Tab Browser, Teks pada Tombol Pendaftaran, dan Header pada Laporan PDF / Kartu Ujian.
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kepanjangan Istilah (Nama Lengkap Sistem)</label>
            <input type="text" name="app_name" value="<?= $web['app_name'] ?? 'Penerimaan Peserta Didik Baru' ?>" placeholder="Misal: Penerimaan Peserta Didik Baru" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pendaftaran</label>
            <select name="status_ppdb" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                <option value="Buka" <?= ($web['status_ppdb'] == 'Buka') ? 'selected' : '' ?>>Buka</option>
                <option value="Tutup" <?= ($web['status_ppdb'] == 'Tutup') ? 'selected' : '' ?>>Tutup</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelajaran</label>
                <input type="text" name="th_pelajaran" value="<?= $web['th_pelajaran'] ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <option value="Ganjil" <?= ($web['semester'] == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                    <option value="Genap" <?= ($web['semester'] == 'Genap') ? 'selected' : '' ?>>Genap</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal & Waktu Pengumuman</label>
            <?php $tgl_pengumuman_val = (!empty($web['tgl_pengumuman']) && $web['tgl_pengumuman'] !== '0000-00-00 00:00:00') ? date('Y-m-d\TH:i', strtotime($web['tgl_pengumuman'])) : ''; ?>
            <input type="datetime-local" name="tgl_pengumuman" value="<?= $tgl_pengumuman_val ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pengumuman</label>
            <select name="pengumuman_aktif" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                <option value="1" <?= ($web['pengumuman_aktif'] == 1) ? 'selected' : '' ?>>Aktif (Bisa Dilihat)</option>
                <option value="0" <?= ($web['pengumuman_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Format No. Pendaftaran</label>
            <input type="text" name="format_no_daftar" value="<?= esc($web['format_no_daftar'] ?? 'PPDB-{TAHUN}-{URUT}') ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border" required>
            <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
                <i class="fas fa-info-circle mr-1"></i> Gunakan format berikut (gunakan kurung kurawal): <br>
                <strong>{TAHUN}</strong> = Tahun (misal: <?= date('Y') ?>) &bull;
                <strong>{BULAN}</strong> = Bulan (misal: <?= date('m') ?>) &bull;
                <strong>{URUT}</strong> = Nomor urut otomatis (misal: 0001)
            </p>
        </div>
    </div>
</div>

<!-- Card: Pilihan Template Landing Page -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
        <i class="fas fa-palette text-purple-500"></i>
        <h3 class="text-lg font-medium text-gray-900">Template Landing Page</h3>
    </div>
    <div class="p-6">
        <p class="text-sm text-gray-500 mb-4">Pilih salah satu desain landing page yang akan ditampilkan untuk pengunjung website.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
            $currentVariant = $web['landing_variant'] ?? 'index';
            $variants = [
                [
                    'value' => 'index',
                    'name'  => 'Modern Dynamic',
                    'desc'  => 'Desain modern dengan animasi dinamis, popup pengumuman, dan SEO terintegrasi.',
                    'icon'  => 'fas fa-rocket',
                    'color' => 'blue',
                ],
                [
                    'value' => 'index2',
                    'name'  => 'Clean Minimal',
                    'desc'  => 'Tampilan bersih dengan parallax hero, timeline staggered, dan transisi halus.',
                    'icon'  => 'fas fa-feather-alt',
                    'color' => 'emerald',
                ],
                [
                    'value' => 'index3',
                    'name'  => 'Enhanced Classic',
                    'desc'  => 'Versi klasik yang ditingkatkan dengan scroll spy, animasi lightbox, dan navigasi aktif.',
                    'icon'  => 'fas fa-gem',
                    'color' => 'purple',
                ],
            ];
            foreach ($variants as $v):
                $isSelected = ($currentVariant === $v['value']);
            ?>
                <label class="relative cursor-pointer">
                    <input type="radio" name="landing_variant" value="<?= $v['value'] ?>" <?= $isSelected ? 'checked' : '' ?> class="sr-only peer">
                    
                    <!-- Main Card Content -->
                    <div class="h-full rounded-xl border-2 p-5 transition-all duration-200 bg-white border-gray-200 peer-checked:border-<?= $v['color'] ?>-500 peer-checked:ring-2 peer-checked:ring-<?= $v['color'] ?>-200 peer-checked:bg-<?= $v['color'] ?>-50 hover:border-gray-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-<?= $v['color'] ?>-100 flex items-center justify-center text-<?= $v['color'] ?>-600">
                                <i class="<?= $v['icon'] ?> text-lg"></i>
                            </div>
                            <h4 class="font-bold text-gray-800"><?= $v['name'] ?></h4>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed"><?= $v['desc'] ?></p>
                    </div>

                    <!-- Checkmark (as sibling of peer) -->
                    <div class="absolute top-3 right-3 hidden peer-checked:flex items-center justify-center w-6 h-6 bg-<?= $v['color'] ?>-500 text-white rounded-full shadow-sm">
                        <i class="fas fa-check text-[10px]"></i>
                    </div>

                    <!-- "Terpilih" Badge (as sibling of peer) -->
                    <div class="absolute bottom-5 left-5 hidden peer-checked:inline-flex items-center gap-1 text-xs font-bold text-<?= $v['color'] ?>-600">
                        <i class="fas fa-circle text-[6px]"></i> Terpilih
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
</div>
