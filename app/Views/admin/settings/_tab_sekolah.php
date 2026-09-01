<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">badge</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Identitas Sekolah</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Nama Sekolah</label>
            <input type="text" name="nama_sekolah" value="<?= $web['nama_sekolah'] ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">NSM</label>
                <input type="text" name="nsm" value="<?= $web['nsm'] ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">NPSN</label>
                <input type="text" name="npsn" value="<?= $web['npsn'] ?>"
                       class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
            </div>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Logo Sekolah</label>
            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                <?php if ($web['logo_sekolah']): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" class="h-14 w-14 object-contain bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-1 shadow-theme-xs">
                <?php endif; ?>
                <input type="file" name="logo_sekolah"
                       class="flex-1 text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-brand-50 file:text-brand-500 hover:file:bg-brand-100 dark:file:bg-brand-500/15 dark:file:text-brand-400 file:cursor-pointer file:transition-colors">
            </div>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">map</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Alamat & Kontak</h3>
    </div>
    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Alamat Lengkap</label>
                    <textarea name="alamat_sekolah" rows="3"
                              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all"><?= $web['alamat_sekolah'] ?></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kecamatan</label>
                        <input type="text" name="kecamatan" value="<?= $web['kecamatan'] ?>"
                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" value="<?= $web['kabupaten'] ?>"
                               class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Provinsi</label>
                    <input type="text" name="provinsi" value="<?= $web['provinsi'] ?>"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">No. Telepon / WhatsApp</label>
                    <input type="text" name="telepon" value="<?= $web['telepon'] ?>"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Email</label>
                    <input type="email" name="email" value="<?= $web['email'] ?>"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Website</label>
                    <input type="text" name="website" value="<?= $web['website'] ?>"
                           class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>
                <div class="pt-4 mt-2 border-t border-gray-200 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-[#25D366]"></i>
                        Integrasi Grup WhatsApp Siswa
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Link Grup WhatsApp</label>
                            <input type="url" name="link_grup_wa" placeholder="https://chat.whatsapp.com/..." value="<?= esc($web['link_grup_wa'] ?? '') ?>"
                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                            <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Link undangan grup WhatsApp untuk siswa baru.</p>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="hidden" name="tampil_grup_wa" value="0">
                                <input type="checkbox" name="tampil_grup_wa" value="1" <?= (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1) ? 'checked' : '' ?>
                                       class="sr-only peer" id="tampil_grup_wa">
                                <div class="w-11 h-6 bg-gray-300 dark:bg-gray-600 rounded-full peer-checked:bg-[#25D366] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium group-hover:text-brand-500 transition-colors">Tampilkan Tombol Grup WhatsApp di Dashboard Siswa</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
        <span class="material-symbols-outlined text-brand-500">person</span>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Kepala Sekolah</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">Nama Kepala Sekolah</label>
            <input type="text" name="nama_kepala" value="<?= $web['nama_kepala'] ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-gray-800 dark:text-gray-200">NIP Kepala Sekolah</label>
            <input type="text" name="nip_kepala" value="<?= $web['nip_kepala'] ?>"
                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
        </div>
    </div>
</div>
