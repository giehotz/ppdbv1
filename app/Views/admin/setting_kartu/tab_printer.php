<!-- Tab: Printer -->
<div id="printer" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Kalibrasi Mesin & Kertas Print</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Penyesuaian resolusi DPI, batas margin cetak kertas, dan jarak (gap) antar kartu saat cetak masal</p>
        </div>

        <form action="<?= base_url('admin/setting-kartu/savePrinter') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id_printer" value="<?= esc($printer['id_printer'] ?? '') ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Kerapatan Cetak (DPI Resolution)
                    </label>
                    <input type="number" name="dpi" value="<?= esc($printer['dpi'] ?? 300) ?>"
                           class="w-full max-w-sm rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1.5 text-xs text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Resolusi standar industri untuk cetak tajam adalah 300 DPI.
                    </p>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Batas Margin Kiri di Kertas (cm)
                    </label>
                    <input type="number" step="0.01" name="margin_kiri" value="<?= esc($printer['margin_kiri'] ?? 0.5) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Batas Margin Atas di Kertas (cm)
                    </label>
                    <input type="number" step="0.01" name="margin_atas" value="<?= esc($printer['margin_atas'] ?? 0.5) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Jarak Horizontal Antar Kartu (X-Gap cm)
                    </label>
                    <input type="number" step="0.01" name="margin_kartu_kanan" value="<?= esc($printer['margin_kartu_kanan'] ?? 0.1) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Jarak Vertikal Antar Kartu (Y-Gap cm)
                    </label>
                    <input type="number" step="0.01" name="margin_kartu_bawah" value="<?= esc($printer['margin_kartu_bawah'] ?? 0.1) ?>"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Margin Depan - Belakang Saat Dicetak Berdampingan (cm)
                    </label>
                    <input type="number" step="0.01" name="margin_depan_belakang" value="<?= esc($printer['margin_depan_belakang'] ?? 0) ?>"
                           class="w-full max-w-sm rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                </div>
            </div>

            <div class="mt-8 flex justify-end pt-5 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Kalibrasi Printer</span>
                </button>
            </div>
        </form>
    </div>
</div>
