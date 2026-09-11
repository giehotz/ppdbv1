<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center gap-2.5 mb-4">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
            <span class="material-symbols-outlined text-lg">fact_check</span>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Validasi Status Pendaftar</h3>
    </div>

    <!-- Status Saat Ini -->
    <div class="text-center mb-5 p-4 rounded-xl bg-gray-50/80 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800">
        <span class="text-[11px] text-gray-400 dark:text-gray-500 block mb-1.5 font-semibold">Status Pendaftaran Saat Ini:</span>
        <?php
            $status = $siswa['status_verifikasi'] ?? '';
            if ($status == 'Terverifikasi') :
        ?>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Terverifikasi
            </span>
        <?php elseif ($status == 'Ditolak') : ?>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-1 text-xs font-bold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                <span class="h-2 w-2 rounded-full bg-red-500"></span> Ditolak
            </span>
        <?php else : ?>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-4 py-1 text-xs font-bold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                <span class="h-2 w-2 rounded-full bg-amber-500"></span> Menunggu Verifikasi
            </span>
        <?php endif; ?>
    </div>

    <!-- Form Update Status -->
    <form action="<?= base_url('verifikator/pindahan/verify/' . $siswa['id_pindahan']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ubah Status Verifikasi</label>
                <select name="status" required class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <option value="">-- Pilih Status --</option>
                    <option value="Terverifikasi" <?= $status == 'Terverifikasi' ? 'selected' : '' ?>>Terverifikasi</option>
                    <option value="Ditolak" <?= $status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    <option value="Menunggu" <?= $status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan Verifikasi (Opsional)</label>
                <textarea name="catatan" rows="3" class="w-full rounded-xl border border-gray-200 bg-white p-3 text-xs text-gray-900 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 placeholder:text-gray-400" placeholder="Alasan penolakan atau catatan tambahan untuk siswa..."><?= esc($siswa['catatan_verifikasi'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center gap-1.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold py-2.5 px-4 text-xs shadow-theme-xs transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">save</span>
                <span>Simpan Status Verifikasi</span>
            </button>
        </div>
    </form>
</div>