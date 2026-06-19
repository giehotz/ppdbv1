<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">badge</span>
        <h3 class="text-lg font-bold text-on-surface">Identitas Sekolah</h3>
    </div>
    <div class="p-6 space-y-5">
        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Nama Sekolah</label>
            <input type="text" name="nama_sekolah" value="<?= $web['nama_sekolah'] ?>"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">NSM</label>
                <input type="text" name="nsm" value="<?= $web['nsm'] ?>"
                       class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-1.5">NPSN</label>
                <input type="text" name="npsn" value="<?= $web['npsn'] ?>"
                       class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Logo Sekolah</label>
            <div class="flex items-center gap-4 p-4 bg-surface rounded-lg border border-dashed border-outline-variant">
                <?php if ($web['logo_sekolah']): ?>
                    <img src="<?= base_url('uploads/logo/' . $web['logo_sekolah']) ?>" class="h-14 w-14 object-contain bg-white rounded-lg border border-outline-variant p-1 shadow-sm">
                <?php endif; ?>
                <input type="file" name="logo_sekolah"
                       class="flex-1 text-sm text-on-surface file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer file:transition-colors">
            </div>
        </div>
    </div>
</div>

<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">map</span>
        <h3 class="text-lg font-bold text-on-surface">Alamat & Kontak</h3>
    </div>
    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat_sekolah" rows="3"
                              class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"><?= $web['alamat_sekolah'] ?></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-1.5">Kecamatan</label>
                        <input type="text" name="kecamatan" value="<?= $web['kecamatan'] ?>"
                               class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-1.5">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" value="<?= $web['kabupaten'] ?>"
                               class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-1.5">Provinsi</label>
                    <input type="text" name="provinsi" value="<?= $web['provinsi'] ?>"
                           class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-1.5">No. Telepon / WhatsApp</label>
                    <input type="text" name="telepon" value="<?= $web['telepon'] ?>"
                           class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-1.5">Email</label>
                    <input type="email" name="email" value="<?= $web['email'] ?>"
                           class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-1.5">Website</label>
                    <input type="text" name="website" value="<?= $web['website'] ?>"
                           class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div class="pt-4 mt-2 border-t border-surface-variant">
                    <h4 class="text-sm font-bold text-on-surface mb-4 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-[#25D366]"></i>
                        Integrasi Grup WhatsApp Siswa
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-1.5">Link Grup WhatsApp</label>
                            <input type="url" name="link_grup_wa" placeholder="https://chat.whatsapp.com/..." value="<?= esc($web['link_grup_wa'] ?? '') ?>"
                                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            <p class="mt-1.5 text-xs text-on-surface-variant">Link undangan grup WhatsApp untuk siswa baru.</p>
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="hidden" name="tampil_grup_wa" value="0">
                                <input type="checkbox" name="tampil_grup_wa" value="1" <?= (isset($web['tampil_grup_wa']) && $web['tampil_grup_wa'] == 1) ? 'checked' : '' ?>
                                       class="sr-only peer" id="tampil_grup_wa">
                                <div class="w-11 h-6 bg-outline-variant rounded-full peer-checked:bg-[#25D366] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                            </div>
                            <span class="text-sm text-on-surface font-medium group-hover:text-primary transition-colors">Tampilkan Tombol Grup WhatsApp di Dashboard Siswa</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-surface-variant overflow-hidden mt-6">
    <div class="px-6 py-5 border-b border-surface-variant flex items-center gap-3">
        <span class="material-symbols-outlined text-primary">person</span>
        <h3 class="text-lg font-bold text-on-surface">Kepala Sekolah</h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">Nama Kepala Sekolah</label>
            <input type="text" name="nama_kepala" value="<?= $web['nama_kepala'] ?>"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
        </div>
        <div>
            <label class="block text-sm font-bold text-on-surface mb-1.5">NIP Kepala Sekolah</label>
            <input type="text" name="nip_kepala" value="<?= $web['nip_kepala'] ?>"
                   class="w-full border border-outline-variant rounded-lg px-4 py-2.5 text-sm text-on-surface bg-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
        </div>
    </div>
</div>
