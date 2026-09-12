<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Profil Saya<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Profil Calon Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-5 pb-6">
    
    <!-- Profile Card (TailAdmin Mobile) -->
    <div class="rounded-[1.25rem] border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] text-center space-y-4">
        <?php
        $nisn = $siswa['nisn'] ?? session()->get('nisn');
        $hasFoto = !empty($fotoPath) && file_exists(FCPATH . $fotoPath);
        $avatarUrl = $hasFoto ? base_url($fotoPath) : null;
        $inisial = mb_substr(trim($siswa['nama_lengkap'] ?? 'S'), 0, 1);
        ?>

        <div class="relative inline-block mx-auto">
            <div class="h-24 w-24 rounded-full overflow-hidden bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center justify-center font-bold text-3xl border-2 border-brand-100 dark:border-brand-500/30 shadow-sm">
                <?php if ($avatarUrl): ?>
                    <img src="<?= $avatarUrl ?>" alt="Foto" class="h-full w-full object-cover">
                <?php else: ?>
                    <?= esc($inisial) ?>
                <?php endif; ?>
            </div>
            <button onclick="document.getElementById('foto-input').click()"
                class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-xl bg-brand-500 text-white shadow-theme-xs"
                title="<?= !empty($isFromBerkas) ? 'Unggah Foto Profil Khusus' : 'Ganti Foto' ?>">
                <span class="material-symbols-outlined text-sm">photo_camera</span>
            </button>
        </div>

        <?php if (!empty($isFromBerkas)): ?>
            <div>
                <span class="inline-flex items-center gap-1 text-[10px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-800/50 px-2.5 py-0.5 rounded-full" title="Foto ini diambil otomatis dari Pas Foto yang diunggah di menu Berkas">
                    <span class="material-symbols-outlined text-xs text-emerald-600">verified</span>
                    <span>Foto dari Berkas</span>
                </span>
            </div>
        <?php endif; ?>

        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap']) ?></h3>
            <p class="text-[11px] font-mono text-gray-400 mt-1">NISN: <?= esc($siswa['nisn'] ?? '-') ?></p>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-2 text-left">
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">No. Pendaftaran</span>
                <span class="text-xs font-bold font-mono text-brand-600 dark:text-brand-400"><?= esc($siswa['no_pendaftaran'] ?? '-') ?></span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">Status Verifikasi</span>
                <?php
                $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
                if ($statusVerif === 'Terverifikasi') {
                    $color = 'text-emerald-600 dark:text-emerald-400';
                } elseif ($statusVerif === 'Ditolak') {
                    $color = 'text-red-600 dark:text-red-400';
                } else {
                    $color = 'text-amber-600 dark:text-amber-400';
                }
                ?>
                <span class="text-xs font-bold <?= $color ?>"><?= esc($statusVerif) ?></span>
            </div>
        </div>

        <?php if (empty($isFromBerkas) && $hasFoto): ?>
            <button onclick="confirmDelete()" class="inline-flex items-center gap-1 text-[10px] font-semibold text-red-600 hover:text-red-700 pt-1">
                <span class="material-symbols-outlined text-xs">delete</span>
                <span>Hapus Foto Profil</span>
            </button>
        <?php endif; ?>
    </div>

    <!-- Hidden photo upload forms -->
    <form action="<?= base_url('siswa/profile/update-foto') ?>" method="POST" enctype="multipart/form-data" id="foto-form" class="hidden">
        <?= csrf_field() ?>
        <input type="file" id="foto-input" name="foto" accept="image/*" onchange="previewAndSubmit(this)">
    </form>
    <form action="<?= base_url('siswa/profile/delete-foto') ?>" method="POST" id="delete-foto-form" class="hidden">
        <?= csrf_field() ?>
    </form>

    <!-- Settings Navigation -->
    <div class="rounded-[1.25rem] border border-gray-100 bg-white p-3 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] space-y-1">
        <div class="px-3 py-2 flex items-center justify-between">
            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white">
                Pengaturan Akun
            </h4>
        </div>

        <a href="<?= base_url('siswa/ubah-password') ?>"
           class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 border border-brand-100">
                    <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                </div>
                <div>
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Ubah Password</h5>
                    <p class="text-[10px] text-gray-500">Ganti kata sandi akun pendaftaran</p>
                </div>
            </div>
            <span class="material-symbols-outlined text-base text-gray-400">chevron_right</span>
        </a>

        <div class="mx-3 border-t border-gray-50 dark:border-gray-800"></div>

        <a href="<?= base_url('siswa/biodata') ?>"
           class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100">
                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                </div>
                <div>
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Formulir Biodata</h5>
                    <p class="text-[10px] text-gray-500">Lengkapi data pribadi dan orang tua</p>
                </div>
            </div>
            <span class="material-symbols-outlined text-base text-gray-400">chevron_right</span>
        </a>
    </div>

</div>

<script>
function previewAndSubmit(input) {
    if (input.files && input.files[0]) {
        document.getElementById('foto-form').submit();
    }
}
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
        document.getElementById('delete-foto-form').submit();
    }
}
</script>

<?= $this->endSection() ?>
