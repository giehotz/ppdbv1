<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Daftar Ulang<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Konfirmasi Daftar Ulang<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4 pb-6">

    <!-- Flash Notifications -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 flex items-center gap-2.5">
            <span class="material-symbols-outlined text-emerald-600 text-lg shrink-0">check_circle</span>
            <p class="text-xs font-semibold text-emerald-800"><?= session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="rounded-xl border border-red-200 bg-red-50 p-3 flex items-center gap-2.5">
            <span class="material-symbols-outlined text-red-600 text-lg shrink-0">error</span>
            <p class="text-xs font-semibold text-red-800"><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <!-- Banner Jika Daftar Ulang Ditutup / Kedaluwarsa -->
    <?php if (!empty($isClosed)): ?>
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 space-y-2">
            <div class="flex items-center gap-2 text-amber-900 font-bold text-xs">
                <span class="material-symbols-outlined text-amber-600 text-lg">lock_clock</span>
                <span><?= !empty($isExpired) ? 'Periode Daftar Ulang Telah Berakhir' : 'Daftar Ulang Ditutup / Dinonaktifkan' ?></span>
            </div>
            <p class="text-xs text-amber-800 leading-relaxed">
                <?php if (!empty($web['pesan_daftar_ulang'])): ?>
                    <?= nl2br(esc($web['pesan_daftar_ulang'])) ?>
                <?php else: ?>
                    Akses pengisian formulir konfirmasi daftar ulang saat ini sedang ditutup oleh panitia PPDB. Silakan tunggu jadwal pembukaan atau hubungi pihak sekolah.
                <?php endif; ?>
            </p>
            <?php if (!empty($daftarUlang)): ?>
                <div class="pt-2 border-t border-amber-200 flex items-center gap-1 text-[11px] font-semibold text-emerald-800">
                    <span class="material-symbols-outlined text-xs text-emerald-600">verified</span>
                    <span>Data konfirmasi Anda telah tersimpan sebelumnya.</span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Status Header Card -->
    <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm space-y-3">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
            <div class="min-w-0 flex-1">
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full uppercase">Lulus Seleksi</span>
                <h3 class="text-sm font-extrabold text-gray-900 truncate mt-0.5"><?= esc($siswa['nama_lengkap']) ?></h3>
                <p class="text-[10px] text-gray-500 font-mono"><?= esc($siswa['no_pendaftaran']) ?></p>
            </div>
        </div>

        <?php if (!empty($daftarUlang)): ?>
            <div class="p-3 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between text-xs">
                <span class="text-gray-500 text-[11px]">Konfirmasi Saat Ini:</span>
                <?php if (($daftarUlang['status_konfirmasi'] ?? '') === 'bersedia'): ?>
                    <span class="font-bold text-emerald-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span> Bersedia
                    </span>
                <?php else: ?>
                    <span class="font-bold text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">cancel</span> Mundur
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Form -->
    <form action="<?= base_url('siswa/daftar-ulang/simpan') ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>
        <?php $statusCur = $daftarUlang['status_konfirmasi'] ?? 'bersedia'; ?>

        <fieldset <?= !empty($isClosed) ? 'disabled="disabled"' : '' ?> class="<?= !empty($isClosed) ? 'opacity-80' : '' ?> space-y-4">

            <!-- Pilihan Kesediaan -->
            <div class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm space-y-3">
                <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider">1. Kesediaan Masuk</h4>
                
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-xl border <?= $statusCur === 'bersedia' ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-200' ?>" id="m-lbl-bersedia">
                        <input type="radio" name="status_konfirmasi" value="bersedia" class="sr-only" <?= $statusCur === 'bersedia' ? 'checked' : '' ?> onchange="mToggleMode('bersedia')" <?= !empty($isClosed) ? 'disabled' : '' ?>>
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block">Bersedia Daftar Ulang</span>
                            <span class="text-[10px] text-gray-500 block">Siap melanjutkan proses pendaftaran</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border <?= $statusCur === 'mengundurkan_diri' ? 'border-red-500 bg-red-50/50' : 'border-gray-200' ?>" id="m-lbl-mundur">
                        <input type="radio" name="status_konfirmasi" value="mengundurkan_diri" class="sr-only" <?= $statusCur === 'mengundurkan_diri' ? 'checked' : '' ?> onchange="mToggleMode('mengundurkan_diri')" <?= !empty($isClosed) ? 'disabled' : '' ?>>
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-red-500 text-white">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-gray-900 block">Mengundurkan Diri</span>
                            <span class="text-[10px] text-gray-500 block">Melepaskan status kelulusan</span>
                        </div>
                    </label>
                </div>

                <!-- Box Alasan Mundur -->
                <div id="m-box-alasan" class="<?= $statusCur === 'mengundurkan_diri' ? '' : 'hidden' ?> pt-2">
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Alasan Mengundurkan Diri <span class="text-red-500">*</span></label>
                    <textarea name="alasan_mundur" rows="2" placeholder="Tuliskan alasan pengunduran diri..." class="w-full rounded-xl border border-gray-200 p-2.5 text-xs focus:outline-none focus:border-brand-500"><?= esc($daftarUlang['alasan_mundur'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Ukuran Seragam (Hanya jika Diaktifkan Admin & Siswa Bersedia) -->
            <?php if (!empty($seragamAktif)): ?>
                <div id="m-box-seragam" class="<?= $statusCur === 'mengundurkan_diri' ? 'hidden' : '' ?> rounded-2xl border border-gray-100 bg-white p-4 shadow-sm space-y-3">
                    <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider">2. Ukuran Seragam</h4>

                    <div class="space-y-3">
                        <?php foreach ($seragamFields as $field): 
                            $fid = $field['id'];
                            $curVal = $seragamAnswers[$fid] ?? $daftarUlang[$fid] ?? '';
                            $isReq = !empty($field['required']);
                        ?>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 mb-1">
                                    <?= esc($field['label']) ?> <?= $isReq ? '<span class="text-red-500">*</span>' : '' ?>
                                </label>
                                <?php if (($field['type'] ?? '') === 'select'): 
                                    $opts = array_map('trim', explode(',', $field['options'] ?? ''));
                                ?>
                                    <select name="<?= esc($fid) ?>" <?= $isReq ? 'required' : '' ?> class="w-full rounded-xl border border-gray-200 bg-white p-2.5 text-xs focus:outline-none focus:border-brand-500">
                                        <option value="">-- Pilih Ukuran --</option>
                                        <?php foreach ($opts as $opt): if ($opt === '') continue; ?>
                                            <option value="<?= esc($opt) ?>" <?= $curVal === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" name="<?= esc($fid) ?>" value="<?= esc($curVal) ?>" <?= $isReq ? 'required' : '' ?> placeholder="Masukkan <?= esc($field['label']) ?>..."
                                           class="w-full rounded-xl border border-gray-200 p-2.5 text-xs focus:outline-none focus:border-brand-500">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <input type="text" name="catatan" value="<?= esc($daftarUlang['catatan'] ?? '') ?>" placeholder="Contoh: Lengan panjang ekstra 3 cm" class="w-full rounded-xl border border-gray-200 p-2.5 text-xs focus:outline-none focus:border-brand-500">
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </fieldset>

        <!-- Submit Button -->
        <?php if (empty($isClosed)): ?>
            <button type="submit" class="w-full rounded-xl bg-brand-600 hover:bg-brand-700 py-3 text-xs font-bold text-white shadow-sm transition-all active:scale-[0.98]">
                Simpan Konfirmasi Daftar Ulang
            </button>
        <?php else: ?>
            <button type="button" disabled class="w-full rounded-xl bg-gray-300 py-3 text-xs font-bold text-gray-500 cursor-not-allowed">
                Formulir Pendaftaran Ulang Ditutup
            </button>
        <?php endif; ?>

        <a href="<?= base_url('siswa/dashboard') ?>" class="block text-center text-xs text-gray-500 py-2">
            Kembali ke Dashboard
        </a>
    </form>

</div>

<script>
function mToggleMode(mode) {
    const boxAlasan = document.getElementById('m-box-alasan');
    const boxSeragam = document.getElementById('m-box-seragam');
    const lblBersedia = document.getElementById('m-lbl-bersedia');
    const lblMundur = document.getElementById('m-lbl-mundur');

    if (mode === 'mengundurkan_diri') {
        if (boxAlasan) boxAlasan.classList.remove('hidden');
        if (boxSeragam) boxSeragam.classList.add('hidden');
        if (lblMundur) lblMundur.classList.add('border-red-500', 'bg-red-50/50');
        if (lblBersedia) lblBersedia.classList.remove('border-emerald-500', 'bg-emerald-50/50');
    } else {
        if (boxAlasan) boxAlasan.classList.add('hidden');
        if (boxSeragam) boxSeragam.classList.remove('hidden');
        if (lblBersedia) lblBersedia.classList.add('border-emerald-500', 'bg-emerald-50/50');
        if (lblMundur) lblMundur.classList.remove('border-red-500', 'bg-red-50/50');
    }
}
</script>

<?= $this->endSection() ?>
