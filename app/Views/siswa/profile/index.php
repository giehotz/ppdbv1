<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>Profil Saya<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">person</span> Profil Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Profile Card (TailAdmin Style) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            
            <!-- Photo Avatar -->
            <div class="flex flex-col items-center shrink-0">
                <?php
                $nisn = $siswa['nisn'] ?? session()->get('nisn');
                $foto = $siswa['foto'] ?? session()->get('foto');
                $fotoPath = 'uploads/berkas/' . $nisn . '/' . $foto;
                $hasFoto = !empty($foto) && file_exists(FCPATH . $fotoPath);
                $avatarUrl = $hasFoto ? base_url($fotoPath) : null;
                $inisial = mb_substr(trim($siswa['nama_lengkap'] ?? 'S'), 0, 1);
                ?>
                
                <div class="relative group">
                    <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-3xl overflow-hidden bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center justify-center font-bold text-4xl border-2 border-brand-200 dark:border-brand-500/30 shadow-theme-sm">
                        <?php if ($avatarUrl): ?>
                            <img src="<?= $avatarUrl ?>" alt="Foto Profil" class="h-full w-full object-cover">
                        <?php else: ?>
                            <?= esc($inisial) ?>
                        <?php endif; ?>
                    </div>

                    <button onclick="document.getElementById('foto-input').click()"
                        class="absolute -bottom-2 -right-2 flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-theme-sm hover:bg-brand-600 transition-transform active:scale-95"
                        title="Ganti Foto Profil">
                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                    </button>
                </div>

                <!-- Hidden File Upload Form -->
                <form action="<?= base_url('siswa/profile/update-foto') ?>" method="POST" enctype="multipart/form-data" id="foto-form" class="hidden">
                    <?= csrf_field() ?>
                    <input type="file" id="foto-input" name="foto" accept="image/*" onchange="previewAndSubmit(this)">
                </form>

                <?php if ($hasFoto): ?>
                    <button onclick="confirmDelete()"
                        class="mt-3.5 inline-flex items-center gap-1 text-[11px] font-semibold text-red-600 hover:text-red-700 dark:text-red-400">
                        <span class="material-symbols-outlined text-sm">delete</span>
                        <span>Hapus Foto</span>
                    </button>
                    <form action="<?= base_url('siswa/profile/delete-foto') ?>" method="POST" id="delete-foto-form" class="hidden">
                        <?= csrf_field() ?>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Details Section -->
            <div class="flex-1 text-center sm:text-left space-y-4 min-w-0">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white truncate">
                        <?= esc($siswa['nama_lengkap']) ?>
                    </h2>
                    <p class="text-xs sm:text-sm font-mono text-gray-500 dark:text-gray-400 mt-0.5">
                        NISN: <?= esc($siswa['nisn'] ?? '-') ?> • NIK: <?= esc($siswa['nik'] ?? '-') ?>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-0.5">Nomor Pendaftaran</span>
                        <span class="text-sm font-bold font-mono text-brand-600 dark:text-brand-400"><?= esc($siswa['no_pendaftaran'] ?? '-') ?></span>
                    </div>

                    <div class="rounded-xl border border-gray-100 bg-gray-50/70 p-3.5 dark:border-gray-800 dark:bg-gray-850/40">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 block mb-0.5">Status Verifikasi</span>
                        <?php
                        $statusVerif = $siswa['status_verifikasi'] ?? 'Menunggu';
                        if ($statusVerif === 'Terverifikasi') {
                            $badgeClass = 'text-emerald-600 dark:text-emerald-400';
                            $iconName = 'check_circle';
                        } elseif ($statusVerif === 'Ditolak') {
                            $badgeClass = 'text-red-600 dark:text-red-400';
                            $iconName = 'cancel';
                        } else {
                            $badgeClass = 'text-amber-600 dark:text-amber-400';
                            $iconName = 'hourglass_top';
                        }
                        ?>
                        <span class="text-sm font-bold flex items-center justify-center sm:justify-start gap-1 <?= $badgeClass ?>">
                            <span class="material-symbols-outlined text-base"><?= $iconName ?></span>
                            <span><?= esc($statusVerif) ?></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Navigation / Settings List -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] space-y-4">
        <div class="flex items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
            <span class="material-symbols-outlined text-brand-500">settings</span>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pengaturan Akun &amp; Data</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="<?= base_url('siswa/ubah-password') ?>"
               class="group flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-brand-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-gray-850/40 dark:hover:bg-gray-800 transition-all">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">Ubah Password</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Ganti kata sandi akun pendaftaran Anda</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-base text-gray-400 group-hover:text-brand-500 transition-colors">chevron_right</span>
            </a>

            <a href="<?= base_url('siswa/biodata') ?>"
               class="group flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-brand-500/40 hover:shadow-theme-sm dark:border-gray-800 dark:bg-gray-850/40 dark:hover:bg-gray-800 transition-all">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">edit_note</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">Formulir Biodata</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Lengkapi data pribadi dan orang tua</p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-base text-gray-400 group-hover:text-brand-500 transition-colors">chevron_right</span>
            </a>
        </div>
    </div>

</div>

<script>
function previewAndSubmit(input) {
    if (input.files && input.files[0]) {
        // Submit form
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