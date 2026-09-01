<!-- Tab: Cetak Masal -->
<div id="cetak-masal" class="tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="mb-6 pb-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">print_connect</span>
                    Cetak Kartu Pelajar Secara Masal
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Generate dan cetak kartu pelajar dalam format grid untuk banyak siswa sekaligus</p>
            </div>
            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40">
                Bulk Print
            </span>
        </div>

        <div class="rounded-xl border border-amber-200/70 bg-amber-50/60 dark:border-amber-500/20 dark:bg-amber-500/10 p-4 mb-6">
            <div class="flex items-start gap-2.5">
                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg flex-shrink-0 mt-0.5">warning</span>
                <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                    <strong>Penting:</strong> Merender ratusan kartu dengan grafis tinggi sekaligus dapat membebani memori browser. Gunakan filter batas data (disarankan maksimal <strong>50 - 100 kartu</strong> per sesi cetak).
                </p>
            </div>
        </div>

        <form action="<?= base_url('admin/setting-kartu/cetak-masal') ?>" method="GET" target="_blank">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filter Status Kelulusan -->
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Filter Status Kelulusan
                    </label>
                    <select name="status_kelulusan" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                        <option value="LULUS" selected>Hanya Siswa LULUS / Diterima (Disarankan)</option>
                        <option value="">Semua Data Pendaftar</option>
                        <option value="PROSES SELEKSI">Sedang Proses Seleksi</option>
                    </select>
                    <p class="mt-1.5 text-[11px] text-gray-400">Biasanya hanya peserta Lulus yang dicetak kartunya.</p>
                </div>

                <!-- Limit Data -->
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Batas Jumlah Data (Per Lembar)
                    </label>
                    <select name="limit" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                        <option value="20">20 Siswa Pertama (Ringan)</option>
                        <option value="50" selected>50 Siswa Pertama (Optimal)</option>
                        <option value="100">100 Siswa Pertama</option>
                        <option value="200">200 Siswa Pertama</option>
                        <option value="0">Semua Data Sekaligus</option>
                    </select>
                    <p class="mt-1.5 text-[11px] text-gray-400">Pilih jumlah sesuai kapasitas memori PC/printer Anda.</p>
                </div>

                <!-- Offset Data -->
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Offset (Mulai Urutan Ke-)
                    </label>
                    <input type="number" name="offset" value="0" min="0"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white outline-none transition-all">
                    <p class="mt-1.5 text-[11px] text-gray-400">Isi 0 untuk awal, isi 50 untuk mulai dari siswa ke-51, dst.</p>
                </div>

                <!-- Mode Cetak Sisi Kartu -->
                <div class="md:col-span-3 pt-2">
                    <label class="mb-3 block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                        Pilihan Layout Cetak (Sisi Kartu)
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Duplex -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="print_mode" value="duplex" class="sr-only peer" checked>
                            <div class="h-full rounded-2xl border-2 p-5 transition-all duration-200 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 dark:peer-checked:bg-emerald-500/10 hover:border-emerald-300 hover:shadow-theme-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-500/15 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                        <span class="material-symbols-outlined text-lg">flip</span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">Depan & Belakang (Duplex)</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                    Pencetakan bolak-balik otomatis dengan logika mirroring kolom.
                                </p>
                            </div>
                        </label>

                        <!-- Depan Saja -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="print_mode" value="front" class="sr-only peer">
                            <div class="h-full rounded-2xl border-2 p-5 transition-all duration-200 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 dark:peer-checked:bg-emerald-500/10 hover:border-emerald-300 hover:shadow-theme-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-500/15 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <span class="material-symbols-outlined text-lg">credit_card</span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">Depan Saja</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                    Hanya mencetak sisi depan. Cocok jika laminasi manual per sisi.
                                </p>
                            </div>
                        </label>

                        <!-- Belakang Saja -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="print_mode" value="back" class="sr-only peer">
                            <div class="h-full rounded-2xl border-2 p-5 transition-all duration-200 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 dark:peer-checked:bg-emerald-500/10 hover:border-emerald-300 hover:shadow-theme-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-500/15 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                        <span class="material-symbols-outlined text-lg">qr_code</span>
                                    </div>
                                    <h4 class="font-bold text-gray-900 dark:text-white text-sm">Belakang Saja</h4>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                    Hanya sisi belakang untuk stempel legalitas & QR code.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end pt-5 border-t border-gray-100 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-8 py-3 text-xs font-bold text-white shadow-theme-xs transition active:scale-[0.97]">
                    <span class="material-symbols-outlined text-base">print</span>
                    <span>Render & Cetak Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>
