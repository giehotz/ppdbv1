<!-- Tab: Nilai Rapor (Pindahan) -->
<div id="content-rapor" class="tab-content hidden space-y-6">
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                <span class="material-symbols-outlined text-lg">grading</span>
            </span>
            <span>Nilai Rapor Terakhir</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Input nilai rata-rata per mata pelajaran pada rapor terakhir sebelum pindah. Rata-rata akan dihitung otomatis.</p>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 space-y-5">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-brand-500 text-lg">edit_note</span>
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200">Daftar Mata Pelajaran</h4>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            <?php
            $mapelList = $mapelRapor ?? \Config\PindahanConfig::$mapelRapor;
            foreach ($mapelList as $field => $label):
            ?>
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-gray-700 dark:text-gray-300">
                        <?= esc($label) ?>
                    </label>
                    <input type="number" name="<?= esc($field) ?>"
                           value="<?= esc($pindahan[$field] ?? '', 'attr') ?>"
                           min="0" max="100" step="0.01"
                           class="form-input-control border border-gray-300 dark:border-gray-600 rapor-input"
                           placeholder="0 - 100">
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Rata-rata otomatis -->
        <div class="rounded-xl border border-brand-200 bg-brand-50/50 p-4 dark:border-brand-900/40 dark:bg-brand-950/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-brand-600 dark:text-brand-400 text-xl">calculate</span>
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white">Rata-Rata Nilai Rapor</span>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Dihitung otomatis dari seluruh mata pelajaran yang diisi</p>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <span id="rataRataDisplay" class="text-2xl font-black font-mono text-brand-600 dark:text-brand-400">
                    <?= esc($pindahan['rata_rata_nilai'] ?? '0') ?>
                </span>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">/ 100</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.rapor-input');
    const display = document.getElementById('rataRataDisplay');
    if (!display) return;

    function hitungRataRata() {
        let sum = 0, count = 0;
        inputs.forEach(el => {
            const val = parseFloat(el.value);
            if (!isNaN(val) && el.value.trim() !== '') {
                sum += val;
                count++;
            }
        });
        const avg = count > 0 ? (sum / count).toFixed(2) : '0';
        display.textContent = avg;
    }

    inputs.forEach(el => {
        el.addEventListener('input', hitungRataRata);
        el.addEventListener('change', hitungRataRata);
    });
});
</script>