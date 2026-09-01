<!-- Tab: QR -->
<div id="qr" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Konfigurasi Barcode / QR Code</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pengaturan resolusi, tingkat toleransi error, ukuran, dan penempatan QR Code pada kartu</p>
        </div>

        <form action="<?= base_url('admin/setting-kartu/saveQr') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_qr" value="<?= esc($qr['id_qr'] ?? '') ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Versi QR Matrix
                    </label>
                    <select name="version" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= ($qr['version'] ?? 4) == $i ? 'selected' : '' ?>>Versi <?= $i ?> (Ukuran matriks <?= 17 + ($i * 4) ?>x<?= 17 + ($i * 4) ?>)</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Tingkat Toleransi Error (ECC)
                    </label>
                    <select name="ecc_level" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                        <option value="L" <?= ($qr['ecc_level'] ?? 'M') == 'L' ? 'selected' : '' ?>>Low (7% pemulihan error)</option>
                        <option value="M" <?= ($qr['ecc_level'] ?? 'M') == 'M' ? 'selected' : '' ?>>Medium (15% pemulihan error - Disarankan)</option>
                        <option value="Q" <?= ($qr['ecc_level'] ?? 'M') == 'Q' ? 'selected' : '' ?>>Quartile (25% pemulihan error)</option>
                        <option value="H" <?= ($qr['ecc_level'] ?? 'M') == 'H' ? 'selected' : '' ?>>High (30% pemulihan error)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Ukuran Render QR (Pixel)
                    </label>
                    <input type="number" name="size_pixel" value="<?= esc($qr['size_pixel'] ?? 100) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Tepi Kosong / Quiet Zone (Margin pixel)
                    </label>
                    <input type="number" name="padding_tepi" value="<?= esc($qr['padding_tepi'] ?? 2) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Posisi QR Code Pada Kartu
                    </label>
                    <select name="posisi_kartu" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                        <option value="Depan" <?= ($qr['posisi_kartu'] ?? 'Depan') == 'Depan' ? 'selected' : '' ?>>Bagian Depan</option>
                        <option value="Belakang" <?= ($qr['posisi_kartu'] ?? 'Depan') == 'Belakang' ? 'selected' : '' ?>>Bagian Belakang</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Global URL / Teks Cadangan
                    </label>
                    <input type="text" name="global_text" value="<?= esc($qr['global_text'] ?? '') ?>" placeholder="https://sekolah.sch.id/verify"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1 text-[11px] text-gray-400">Digunakan jika nomor NISN / ID verifikasi anggota kosong.</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end pt-5 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Pengaturan QR</span>
                </button>
            </div>
        </form>
    </div>
</div>
