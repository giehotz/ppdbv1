<!-- Tab: Instansi -->
<div id="instansi" class="tab-content">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Identitas Instansi (Kop Kartu)</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi sekolah yang akan tercetak pada header kartu siswa</p>
            </div>
            <a href="<?= base_url('admin/settings') ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs py-2 px-4 shadow-theme-xs transition active:scale-[0.97]">
                <span class="material-symbols-outlined text-sm">edit</span>
                <span>Ubah di Pengaturan Profil Sekolah</span>
            </a>
        </div>

        <div class="rounded-xl border border-brand-100 bg-brand-50/60 dark:border-brand-500/20 dark:bg-brand-500/10 p-4 mb-6">
            <div class="flex items-start gap-2.5">
                <span class="material-symbols-outlined text-brand-500 text-lg flex-shrink-0 mt-0.5">info</span>
                <p class="text-xs text-brand-800 dark:text-brand-300 leading-relaxed">
                    Data kop Instansi / Sekolah kini terintegrasi langsung dengan menu <strong>Profil Sekolah</strong> utama untuk mencegah input berulang.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Nama Instansi / Sekolah</label>
                <p class="text-gray-900 dark:text-white font-bold text-base border-b border-gray-200 dark:border-gray-700 pb-2"><?= esc($instansi['nama_sekolah'] ?? '-') ?></p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                <p class="text-gray-800 dark:text-gray-200 text-sm border-b border-gray-200 dark:border-gray-700 pb-2">
                    <?= esc($instansi['alamat_sekolah'] ?? '-') ?><br>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Kec. <?= esc($instansi['kecamatan'] ?? '-') ?>, Kab. <?= esc($instansi['kabupaten'] ?? '-') ?>, <?= esc($instansi['provinsi'] ?? '-') ?></span>
                </p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">No. Telepon / WhatsApp</label>
                <p class="text-gray-800 dark:text-gray-200 text-sm font-mono border-b border-gray-200 dark:border-gray-700 pb-2"><?= esc($instansi['telepon'] ?? '-') ?></p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Website</label>
                <p class="text-gray-800 dark:text-gray-200 text-sm border-b border-gray-200 dark:border-gray-700 pb-2"><?= esc($instansi['website'] ?? '-') ?></p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Email</label>
                <p class="text-gray-800 dark:text-gray-200 text-sm border-b border-gray-200 dark:border-gray-700 pb-2"><?= esc($instansi['email'] ?? '-') ?></p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Logo Instansi</label>
                <div class="mt-2">
                    <?php if (!empty($instansi['logo_sekolah'])): ?>
                        <div class="h-20 w-20 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-2 shadow-theme-xs flex items-center justify-center">
                            <img src="<?= base_url('uploads/logo/' . $instansi['logo_sekolah']) ?>" class="max-h-full max-w-full object-contain" alt="Logo">
                        </div>
                    <?php else: ?>
                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">Belum ada logo terunggah</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
