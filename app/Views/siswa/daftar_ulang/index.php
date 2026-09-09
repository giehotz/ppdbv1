<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Konfirmasi Daftar Ulang <?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">backpack</span> Konfirmasi Daftar Ulang
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Flash Notification -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-900/40 dark:bg-emerald-950/20 flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl shrink-0">check_circle</span>
            <p class="text-xs sm:text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                <?= session()->getFlashdata('success') ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 dark:border-red-900/40 dark:bg-red-950/20 flex items-center gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl shrink-0">error</span>
            <p class="text-xs sm:text-sm font-semibold text-red-800 dark:text-red-300">
                <?= session()->getFlashdata('error') ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Banner Jika Daftar Ulang Ditutup / Kedaluwarsa -->
    <?php if (!empty($isClosed)): ?>
        <div class="rounded-2xl border border-amber-200 bg-amber-50/90 p-5 dark:border-amber-900/50 dark:bg-amber-950/30 flex items-start gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white">
                <span class="material-symbols-outlined text-2xl">lock_clock</span>
            </div>
            <div class="space-y-1.5 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-sm font-bold text-amber-900 dark:text-amber-200">
                        <?= !empty($isExpired) ? 'Periode Daftar Ulang Telah Berakhir' : 'Pendaftaran Ulang Belum Dibuka / Dinonaktifkan' ?>
                    </h4>
                    <span class="rounded-full bg-amber-200/70 px-2.5 py-0.5 text-[10px] font-bold text-amber-900 dark:bg-amber-800/40 dark:text-amber-200">
                        Akses Ditutup
                    </span>
                </div>
                <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">
                    <?php if (!empty($web['pesan_daftar_ulang'])): ?>
                        <?= nl2br(esc($web['pesan_daftar_ulang'])) ?>
                    <?php else: ?>
                        Akses pengisian formulir konfirmasi daftar ulang dan pendataan ukuran seragam saat ini sedang ditutup oleh panitia PPDB. Silakan tunggu informasi jadwal pembukaan atau hubungi pihak sekolah.
                    <?php endif; ?>
                </p>
                <?php if (!empty($daftarUlang)): ?>
                    <div class="mt-2 pt-2 border-t border-amber-200/60 dark:border-amber-800/50 flex items-center gap-1.5 text-xs font-semibold text-emerald-800 dark:text-emerald-300">
                        <span class="material-symbols-outlined text-sm text-emerald-600">verified</span>
                        <span>Data konfirmasi Anda sebelumnya telah tersimpan aman di sistem.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40">
                    <span class="material-symbols-outlined text-3xl">school</span>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/40 mb-1">
                        <span class="material-symbols-outlined text-xs">verified</span> Lulus Seleksi
                    </span>
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 dark:text-white">
                        Daftar Ulang &amp; Pemilihan Seragam
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Lengkapi formulir konfirmasi kesediaan dan ukuran seragam untuk keperluan persiapan seragam sekolah.
                    </p>
                </div>
            </div>

            <?php if (!empty($daftarUlang)): ?>
                <div class="shrink-0 text-left sm:text-right">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block">Status Konfirmasi</span>
                    <?php if (($daftarUlang['status_konfirmasi'] ?? '') === 'bersedia'): ?>
                        <span class="inline-flex items-center gap-1 rounded-xl bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300 mt-1">
                            <span class="material-symbols-outlined text-sm">how_to_reg</span> Bersedia Daftar Ulang
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1 rounded-xl bg-red-100 px-3 py-1 text-xs font-bold text-red-800 dark:bg-red-500/20 dark:text-red-300 mt-1">
                            <span class="material-symbols-outlined text-sm">cancel</span> Mengundurkan Diri
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($daftarUlang['tgl_konfirmasi'])): ?>
                        <p class="text-[10px] text-gray-400 mt-1">Tercatat: <?= date('d/m/Y H:i', strtotime($daftarUlang['tgl_konfirmasi'])) ?> WIB</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Form Section -->
    <form action="<?= base_url('siswa/daftar-ulang/simpan') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <fieldset <?= !empty($isClosed) ? 'disabled="disabled"' : '' ?> class="<?= !empty($isClosed) ? 'opacity-80' : '' ?> space-y-6">

            <!-- 1. Konfirmasi Kesediaan -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-brand-500">fact_check</span>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">1. Konfirmasi Kesediaan Masuk Sekolah</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php $statusCur = $daftarUlang['status_konfirmasi'] ?? 'bersedia'; ?>
                    
                    <label class="relative flex cursor-pointer rounded-2xl border p-4 transition-all focus:outline-none <?= $statusCur === 'bersedia' ? 'border-emerald-500 bg-emerald-50/40 dark:border-emerald-500 dark:bg-emerald-950/20' : 'border-gray-200 dark:border-gray-800' ?>" id="label-bersedia">
                        <input type="radio" name="status_konfirmasi" value="bersedia" class="sr-only" <?= $statusCur === 'bersedia' ? 'checked' : '' ?> onchange="toggleFormMode('bersedia')" <?= !empty($isClosed) ? 'disabled' : '' ?>>
                        <div class="flex items-start gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white">
                                <span class="material-symbols-outlined text-lg">check</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-900 dark:text-white">BERSEDIA DAFTAR ULANG</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Saya siap melanjutkan pendidikan dan melengkapi seluruh administrasi.</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex cursor-pointer rounded-2xl border p-4 transition-all focus:outline-none <?= $statusCur === 'mengundurkan_diri' ? 'border-red-500 bg-red-50/40 dark:border-red-500 dark:bg-red-950/20' : 'border-gray-200 dark:border-gray-800' ?>" id="label-mundur">
                        <input type="radio" name="status_konfirmasi" value="mengundurkan_diri" class="sr-only" <?= $statusCur === 'mengundurkan_diri' ? 'checked' : '' ?> onchange="toggleFormMode('mengundurkan_diri')" <?= !empty($isClosed) ? 'disabled' : '' ?>>
                        <div class="flex items-start gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white">
                                <span class="material-symbols-outlined text-lg">close</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-900 dark:text-white">MENGUNDURKAN DIRI</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Saya menyatakan mengundurkan diri dan melepaskan hak kelulusan.</span>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Box Alasan Mengundurkan Diri -->
                <div id="box-alasan-mundur" class="<?= $statusCur === 'mengundurkan_diri' ? '' : 'hidden' ?> mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alasan Mengundurkan Diri <span class="text-red-500">*</span></label>
                    <textarea name="alasan_mundur" rows="3" placeholder="Tuliskan alasan Anda mengundurkan diri (contoh: Diterima di sekolah negeri, pindah domisili, dll.)..."
                              class="w-full rounded-xl border border-gray-300 bg-white p-3 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"><?= esc($daftarUlang['alasan_mundur'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- 2. Pendataan Ukuran Seragam (Hanya jika Diaktifkan Admin & Siswa Bersedia) -->
            <?php if (!empty($seragamAktif)): ?>
                <div id="box-seragam" class="<?= $statusCur === 'mengundurkan_diri' ? 'hidden' : '' ?> rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-3 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-brand-500">apparel</span>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">2. Pendataan Ukuran Seragam</h3>
                        </div>
                        <span class="text-[11px] text-gray-400">Pilih ukuran yang paling sesuai dengan postur tubuh siswa.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <?php foreach ($seragamFields as $field): 
                            $fid = $field['id'];
                            $curVal = $seragamAnswers[$fid] ?? $daftarUlang[$fid] ?? '';
                            $isReq = !empty($field['required']);
                        ?>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                                    <?= esc($field['label']) ?> <?= $isReq ? '<span class="text-red-500">*</span>' : '' ?>
                                </label>
                                <?php if (($field['type'] ?? '') === 'select'): 
                                    $opts = array_map('trim', explode(',', $field['options'] ?? ''));
                                ?>
                                    <select name="<?= esc($fid) ?>" <?= $isReq ? 'required' : '' ?> class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white font-medium">
                                        <option value="">-- Pilih Ukuran --</option>
                                        <?php foreach ($opts as $opt): if ($opt === '') continue; ?>
                                            <option value="<?= esc($opt) ?>" <?= $curVal === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" name="<?= esc($fid) ?>" value="<?= esc($curVal) ?>" <?= $isReq ? 'required' : '' ?> placeholder="Masukkan <?= esc($field['label']) ?>..."
                                           class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white font-medium">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Panduan Ukuran Singkat -->
                    <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900/30 dark:bg-blue-950/20 text-xs text-gray-700 dark:text-gray-300 flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg shrink-0 mt-0.5">info</span>
                        <div>
                            <strong class="font-bold text-blue-900 dark:text-blue-300">Tips Memilih Ukuran:</strong>
                            <p class="text-[11px] text-gray-600 dark:text-gray-400 mt-0.5">
                                Disarankan memilih 1 tingkat ukuran lebih besar (misal: dari M ke L) untuk mengantisipasi pertumbuhan tinggi dan berat badan selama masa sekolah.
                            </p>
                        </div>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                            Catatan Khusus Seragam (Opsional)
                        </label>
                        <input type="text" name="catatan" value="<?= esc($daftarUlang['catatan'] ?? '') ?>" placeholder="Contoh: Lengan panjang ekstra 3 cm, celana model reguler, dll."
                               class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
            <?php endif; ?>

        </fieldset>

        <!-- Submit Button / Action Footer -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="<?= base_url('siswa/dashboard') ?>" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-xs font-bold text-gray-700 shadow-theme-xs hover:bg-gray-50 transition-colors dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                Kembali ke Dashboard
            </a>
            <?php if (empty($isClosed)): ?>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-6 py-2.5 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-700 transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">save</span>
                    <span>Simpan Konfirmasi Daftar Ulang</span>
                </button>
            <?php else: ?>
                <button type="button" disabled class="inline-flex items-center gap-2 rounded-xl bg-gray-300 px-6 py-2.5 text-xs font-bold text-gray-500 cursor-not-allowed dark:bg-gray-800 dark:text-gray-600">
                    <span class="material-symbols-outlined text-base">lock</span>
                    <span>Formulir Ditutup</span>
                </button>
            <?php endif; ?>
        </div>

    </form>

</div>

<script>
function toggleFormMode(mode) {
    const boxAlasan = document.getElementById('box-alasan-mundur');
    const boxSeragam = document.getElementById('box-seragam');
    const lblBersedia = document.getElementById('label-bersedia');
    const lblMundur = document.getElementById('label-mundur');

    if (mode === 'mengundurkan_diri') {
        if (boxAlasan) boxAlasan.classList.remove('hidden');
        if (boxSeragam) boxSeragam.classList.add('hidden');
        if (lblMundur) lblMundur.classList.add('border-red-500', 'bg-red-50/40');
        if (lblBersedia) lblBersedia.classList.remove('border-emerald-500', 'bg-emerald-50/40');
    } else {
        if (boxAlasan) boxAlasan.classList.add('hidden');
        if (boxSeragam) boxSeragam.classList.remove('hidden');
        if (lblBersedia) lblBersedia.classList.add('border-emerald-500', 'bg-emerald-50/40');
        if (lblMundur) lblMundur.classList.remove('border-red-500', 'bg-red-50/40');
    }
}
</script>

<?= $this->endSection() ?>
