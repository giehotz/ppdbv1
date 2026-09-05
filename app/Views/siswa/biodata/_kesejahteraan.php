<!-- Tab: Kesejahteraan -->
<div id="content-kesejahteraan" class="tab-content hidden space-y-6">
    <!-- Header -->
    <div class="pb-2 border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">
                <span class="material-symbols-outlined text-lg">card_membership</span>
            </span>
            <span>Program Bantuan Kesejahteraan Sosial</span>
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Isi nomor kartu program perlindungan sosial jika keluarga Anda terdaftar sebagai penerima manfaat.</p>
    </div>

    <!-- Informational Banner -->
    <div class="rounded-2xl border border-purple-100 bg-gradient-to-r from-purple-50/70 via-indigo-50/40 to-blue-50/50 p-5 dark:border-purple-900/40 dark:from-purple-950/20 dark:via-indigo-950/10 dark:to-blue-950/20">
        <div class="flex items-start gap-3.5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-600 text-white shadow-md shadow-purple-600/20">
                <span class="material-symbols-outlined text-xl">info</span>
            </div>
            <div class="space-y-1">
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Informasi Program Bantuan (Afirmasi &amp; Beasiswa)</h4>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Data kartu di bawah bersifat <strong class="text-purple-700 dark:text-purple-400">OPSIONAL</strong> (tidak wajib). Jika calon siswa memiliki kartu bantuan dari pemerintah (KIP, PKH, atau KKS), masukkan nomor kartu dengan benar untuk verifikasi jalur afirmasi atau keringanan biaya sekolah. <strong class="text-gray-700 dark:text-gray-300">Biarkan kosong jika keluarga Anda tidak memilikinya.</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- 3 Card Grid for Welfare Programs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- 1. KIP (Kartu Indonesia Pintar) -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 flex flex-col justify-between space-y-4 hover:border-brand-500/40 transition-colors">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <span class="material-symbols-outlined text-xl">school</span>
                    </span>
                    <span class="rounded-full bg-brand-50 px-2.5 py-0.5 text-[10px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">PIP / KIP</span>
                </div>
                <h5 class="text-sm font-bold text-gray-900 dark:text-white">Kartu Indonesia Pintar (KIP)</h5>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Kartu bantuan pendidikan Program Indonesia Pintar untuk siswa dari Kementerian Pendidikan &amp; Kebudayaan.</p>
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    No. Kartu KIP
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">badge</span>
                    <input type="text" name="no_kip" value="<?= esc($siswa['no_kip'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Kosongkan jika tidak ada">
                </div>
            </div>
        </div>

        <!-- 2. PKH (Program Keluarga Harapan) -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 flex flex-col justify-between space-y-4 hover:border-emerald-500/40 transition-colors">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                        <span class="material-symbols-outlined text-xl">volunteer_activism</span>
                    </span>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">Kemensos</span>
                </div>
                <h5 class="text-sm font-bold text-gray-900 dark:text-white">Program Keluarga Harapan (PKH)</h5>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Program pemberian bantuan sosial bersyarat kepada keluarga yang terdaftar dalam DTKS Kemensos.</p>
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    No. Kartu / Kepesertaan PKH
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">credit_card</span>
                    <input type="text" name="no_pkh" value="<?= esc($siswa['no_pkh'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Kosongkan jika tidak ada">
                </div>
            </div>
        </div>

        <!-- 3. KKS (Kartu Keluarga Sejahtera) -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/40 flex flex-col justify-between space-y-4 hover:border-indigo-500/40 transition-colors">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                        <span class="material-symbols-outlined text-xl">loyalty</span>
                    </span>
                    <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-[10px] font-bold text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">Bansos</span>
                </div>
                <h5 class="text-sm font-bold text-gray-900 dark:text-white">Kartu Keluarga Sejahtera (KKS)</h5>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Kartu identitas bagi penyandang masalah kesejahteraan sosial / penerima program sembako bantuan sosial.</p>
            </div>
            <div>
                <label class="mb-2 block text-xs font-bold text-gray-700 dark:text-gray-300">
                    No. Kartu KKS
                </label>
                <div class="input-icon-wrapper">
                    <span class="input-icon material-symbols-outlined">card_membership</span>
                    <input type="text" name="no_kks" value="<?= esc($siswa['no_kks'] ?? '', 'attr') ?>" class="form-input-control border border-gray-300 dark:border-gray-600 font-mono" placeholder="Kosongkan jika tidak ada">
                </div>
            </div>
        </div>
    </div>
</div>
