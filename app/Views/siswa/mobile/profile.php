<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?>Profil Saya<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Profil Calon Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="space-y-4">
    
    <!-- Profile Card (TailAdmin Mobile) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] text-center space-y-3">
        <?php
        $nisn = $siswa['nisn'] ?? session()->get('nisn');
        $foto = $siswa['foto'] ?? session()->get('foto');
        $fotoPath = 'uploads/berkas/' . $nisn . '/' . $foto;
        $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);
        $avatarUrl = $hasFoto ? base_url($fotoPath) : null;
        $inisial = mb_substr(trim($siswa['nama_lengkap'] ?? 'S'), 0, 1);
        ?>

        <div class="relative inline-block mx-auto">
            <div class="h-20 w-20 rounded-2xl overflow-hidden bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center justify-center font-bold text-2xl border border-brand-200 dark:border-brand-500/30 shadow-theme-xs">
                <?php if ($avatarUrl): ?>
                    <img src="<?= $avatarUrl ?>" alt="Foto" class="h-full w-full object-cover">
                <?php else: ?>
                    <?= esc($inisial) ?>
                <?php endif; ?>
            </div>
            <button onclick="document.getElementById('foto-input').click()"
                class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-xl bg-brand-500 text-white shadow-theme-xs"
                title="Ganti Foto">
                <span class="material-symbols-outlined text-sm">photo_camera</span>
            </button>
        </div>

        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white"><?= esc($siswa['nama_lengkap']) ?></h3>
            <p class="text-xs font-mono text-gray-400 mt-0.5">NISN: <?= esc($siswa['nisn'] ?? '-') ?></p>
        </div>

        <div class="grid grid-cols-2 gap-2 pt-1 text-left">
            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-2.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400 block">No. Pendaftaran</span>
                <span class="text-xs font-bold font-mono text-brand-600 dark:text-brand-400"><?= esc($siswa['no_pendaftaran'] ?? '-') ?></span>
            </div>

            <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-2.5 dark:border-gray-800 dark:bg-gray-850/40">
                <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400 block">Status Verifikasi</span>
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

        <?php if ($hasFoto): ?>
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
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-2">
        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-white pb-2 border-b border-gray-100 dark:border-gray-800">
            Pengaturan Akun
        </h4>

        <a href="<?= base_url('siswa/ubah-password') ?>"
           class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-xl text-brand-500">lock_reset</span>
                <div>
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Ubah Password</h5>
                    <p class="text-[10px] text-gray-400">Ganti kata sandi akun pendaftaran</p>
                </div>
            </div>
            <span class="material-symbols-outlined text-base text-gray-400">chevron_right</span>
        </a>

        <a href="<?= base_url('siswa/biodata') ?>"
           class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-xl text-emerald-500">edit_note</span>
                <div>
                    <h5 class="text-xs font-bold text-gray-900 dark:text-white">Edit Formulir Biodata</h5>
                    <p class="text-[10px] text-gray-400">Lengkapi data pribadi dan orang tua</p>
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
