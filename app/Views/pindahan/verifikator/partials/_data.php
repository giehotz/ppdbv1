<!-- A. Data Pribadi -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                <span class="material-symbols-outlined text-lg">badge</span>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">A. Data Pribadi Calon Siswa Pindahan</h3>
        </div>
        <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 font-mono text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <?= esc($siswa['no_pendaftaran']) ?>
        </span>
    </div>

    <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Nama Lengkap</span>
            <span class="font-bold text-gray-900 dark:text-white text-sm block"><?= esc($siswa['nama_lengkap']) ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">NISN</span>
            <span class="font-mono font-bold text-gray-800 dark:text-gray-200 text-sm block"><?= esc($siswa['nisn'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">NIK (KTP/KIA)</span>
            <span class="font-mono text-gray-800 dark:text-gray-200 block"><?= esc($siswa['nik'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Jenis Kelamin</span>
            <span class="font-semibold text-gray-800 dark:text-gray-200 block">
                <?= ($siswa['jk'] ?? '') == 'L' ? 'Laki-laki' : (($siswa['jk'] ?? '') == 'P' ? 'Perempuan' : '-') ?>
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Tempat, Tanggal Lahir</span>
            <span class="text-gray-800 dark:text-gray-200 block">
                <?= esc($siswa['tempat_lahir'] ?? '' ?: '-') ?>,
                <?= (!empty($siswa['tgl_lahir']) && strtotime($siswa['tgl_lahir'])) ? date('d F Y', strtotime($siswa['tgl_lahir'])) : '-' ?>
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Agama</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['agama'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">No. HP / WhatsApp Siswa</span>
            <span class="text-gray-800 dark:text-gray-200 font-mono block"><?= esc($siswa['no_hp_siswa'] ?? '' ?: '-') ?></span>
            <span class="text-[11px] text-gray-400 dark:text-gray-500"><?= esc($siswa['email'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Tanggal Pendaftaran Pindah</span>
            <span class="text-gray-800 dark:text-gray-200 block">
                <?= (!empty($siswa['tgl_pindahan']) && strtotime($siswa['tgl_pindahan'])) ? date('d F Y H:i', strtotime($siswa['tgl_pindahan'])) : '-' ?>
            </span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">No. Kartu Keluarga (KK)</span>
            <span class="font-mono text-gray-800 dark:text-gray-200 block"><?= esc($siswa['no_kk'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kepala Keluarga</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kepala_keluarga'] ?? '' ?: '-') ?></span>
        </div>
    </div>
</div>

<!-- B. Data Alamat -->
<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 flex items-center gap-2.5 bg-gray-50/50 dark:bg-gray-800/30">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
            <span class="material-symbols-outlined text-lg">location_on</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">B. Alamat Tempat Tinggal</h3>
    </div>

    <div class="p-5 md:p-6 grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
        <div class="sm:col-span-2">
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Alamat Lengkap</span>
            <p class="text-gray-800 dark:text-gray-200 font-medium leading-relaxed"><?= esc($siswa['alamat_siswa'] ?? '' ?: '-') ?></p>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Desa / Kelurahan</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['desa'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kecamatan</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kec'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Kabupaten / Kota</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['kab'] ?? '' ?: '-') ?></span>
        </div>
        <div>
            <span class="text-gray-400 dark:text-gray-500 uppercase tracking-wider font-semibold block text-[10px] mb-1">Provinsi &amp; Kode Pos</span>
            <span class="text-gray-800 dark:text-gray-200 block"><?= esc($siswa['prov'] ?? '' ?: '-') ?> (<?= esc($siswa['kode_pos'] ?? '' ?: '-') ?>)</span>
        </div>
    </div>
</div>