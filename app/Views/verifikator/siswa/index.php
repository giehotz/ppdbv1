<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Calon Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">groups</span> Daftar Calon Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('print_password')) : ?>
    <?php session()->keepFlashdata('print_password'); ?>
    <script>
        window.open('<?= base_url('verifikator/siswa/cetak-password') ?>', '_blank');
    </script>
<?php endif; ?>

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Header Section -->
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Calon Siswa</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola data pendaftaran, kelengkapan biodata, dan status verifikasi siswa.</p>
            </div>

            <div class="flex flex-col sm:flex-row w-full lg:w-auto items-stretch sm:items-center gap-2.5">
                <a href="<?= base_url('verifikator/siswa/reset-throttle') ?>" 
                   onclick="return confirm('Reset batas waktu login untuk membuka seluruh IP/akun yang terkunci?');"
                   class="inline-flex items-center justify-center gap-1.5 h-9 rounded-lg border border-amber-200 bg-amber-50 px-3 text-xs font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-900/50 dark:bg-amber-950/40 dark:text-amber-300 transition-colors shadow-theme-xs shrink-0" 
                   title="Reset batas waktu 15 menit login jika ada akun/IP terkunci">
                    <span class="material-symbols-outlined text-base">lock_open</span>
                    <span>Reset Batas Waktu Login</span>
                </a>

                <form action="<?= base_url('verifikator/siswa') ?>" method="get" class="flex w-full sm:w-auto">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined text-base">search</span>
                        </span>
                        <input type="text"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Cari No. Daftar, NISN, Nama..."
                            class="h-9 w-full rounded-l-lg border border-gray-200 bg-gray-50/50 py-2 pr-3 pl-9 text-xs text-gray-800 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-100 dark:placeholder:text-gray-500 dark:focus:border-brand-400 sm:w-64">
                    </div>
                    <button type="submit"
                            class="inline-flex items-center justify-center bg-gray-800 px-4 text-xs font-semibold text-white transition-colors hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 <?= empty($search) ? 'rounded-r-lg' : '' ?>">
                        Cari
                    </button>
                    <?php if (!empty($search)) : ?>
                        <a href="<?= base_url('verifikator/siswa') ?>"
                           class="flex items-center justify-center border border-l-0 border-red-200 bg-red-50 px-3 text-red-600 transition-colors hover:bg-red-100 rounded-r-lg dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-400"
                           title="Reset Pencarian">
                            <span class="material-symbols-outlined text-xs">close</span>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                    <th class="py-3.5 px-5">No. Pendaftaran</th>
                    <th class="py-3.5 px-5">Calon Siswa</th>
                    <th class="py-3.5 px-5 text-center">Gender</th>
                    <th class="py-3.5 px-5">Kelengkapan</th>
                    <th class="py-3.5 px-5">Status Validasi</th>
                    <th class="py-3.5 px-5">Tanggal Daftar</th>
                    <th class="py-3.5 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                <?php if (!empty($siswa)) : ?>
                    <?php foreach ($siswa as $s) : 
                        $inisial = mb_substr(trim($s['nama_lengkap']), 0, 1);
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <!-- No. Daftar -->
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex rounded-lg bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </span>
                            </td>

                            <!-- Nama & NISN -->
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= esc($inisial) ?>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('verifikator/siswa/detail/' . $s['id_siswa']) ?>" class="font-bold text-gray-900 dark:text-white hover:text-brand-500 dark:hover:text-brand-400 transition-colors block">
                                            <?= esc($s['nama_lengkap']) ?>
                                        </a>
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500 font-mono">
                                            NISN: <?= esc($s['nisn'] ?? '-') ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Gender -->
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <?php if ($s['jk'] === 'L') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                                        <span class="material-symbols-outlined text-xs">male</span> Laki-laki
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-md bg-pink-50 px-2 py-0.5 text-[11px] font-semibold text-pink-700 dark:bg-pink-500/15 dark:text-pink-400">
                                        <span class="material-symbols-outlined text-xs">female</span> Perempuan
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Kelengkapan -->
                            <td class="py-3.5 px-5 min-w-[140px]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                                        <div class="<?= $s['kelengkapan'] == 100 ? 'bg-emerald-500' : ($s['kelengkapan'] >= 50 ? 'bg-brand-500' : 'bg-amber-500') ?> h-2 rounded-full transition-all" style="width: <?= esc($s['kelengkapan'], 'attr') ?>%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold <?= $s['kelengkapan'] == 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' ?>">
                                        <?= esc($s['kelengkapan']) ?>%
                                    </span>
                                </div>
                            </td>

                            <!-- Status Validasi -->
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] === 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] === 'Ditolak') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400 border border-red-200 dark:border-red-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Tanggal Daftar -->
                            <td class="py-3.5 px-5 whitespace-nowrap text-gray-500 dark:text-gray-400 font-medium">
                                <?= $s['tgl_siswa'] ? date('d/m/Y', strtotime($s['tgl_siswa'])) : '-' ?>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <a href="<?= base_url('impersonate/start/' . $s['id_siswa']) ?>"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-500/15 transition-colors focus:outline-none"
                                        title="Login sebagai Siswa (Menyamar)">
                                        <span class="material-symbols-outlined text-base">switch_account</span>
                                    </a>
                                    <a href="<?= base_url('verifikator/siswa/detail/' . $s['id_siswa']) ?>"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-500/15 transition-colors"
                                        title="Detail & Verifikasi">
                                        <span class="material-symbols-outlined text-base">visibility</span>
                                    </a>
                                    <a href="<?= base_url('verifikator/siswa/cetak/' . $s['id_siswa']) ?>" target="_blank"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/15 transition-colors"
                                        title="Cetak Formulir">
                                        <span class="material-symbols-outlined text-base">print</span>
                                    </a>
                                    <button type="button"
                                        onclick="openResetPasswordModal('<?= $s['id_siswa'] ?>', '<?= esc(addslashes($s['nama_lengkap'])) ?>')"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-500/15 transition-colors"
                                        title="Reset Password">
                                        <span class="material-symbols-outlined text-base">key</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="py-12 px-5 text-center text-gray-400 dark:text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300 dark:text-gray-600">person_search</span>
                                <?php if (!empty($search)) : ?>
                                    <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pencarian Tidak Ditemukan</p>
                                    <p class="text-xs text-gray-400">Tidak ada siswa dengan kata kunci "<strong><?= esc($search) ?></strong>".</p>
                                    <a href="<?= base_url('verifikator/siswa') ?>" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-600 dark:text-brand-400 hover:underline">
                                        <span class="material-symbols-outlined text-xs">refresh</span> Reset Pencarian
                                    </a>
                                <?php else : ?>
                                    <p class="text-xs font-semibold text-gray-500">Belum ada calon siswa yang mendaftar saat ini.</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($siswa) && isset($pager)) : ?>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900/50 flex flex-col sm:flex-row justify-between items-center gap-3">
            <span class="text-xs text-gray-500 dark:text-gray-400">Menampilkan data calon siswa.</span>
            <div class="pagination-wrapper">
                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Reset Password Modal (TailAdmin Style) -->
<div id="resetPasswordModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-md w-full p-6 shadow-theme-xl border border-gray-200 dark:border-gray-800 transform transition-all scale-95" id="resetPasswordModalContent">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-500">lock_reset</span>
                <span>Reset Password Siswa</span>
            </h3>
            <button onclick="closeResetPasswordModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <div class="mb-4 bg-amber-50/70 dark:bg-amber-950/40 p-3.5 rounded-xl border border-amber-200/70 dark:border-amber-900/40 text-xs">
            <span class="text-amber-800 dark:text-amber-300 block font-semibold mb-0.5">Siswa Terpilih:</span>
            <span id="resetStudentName" class="font-bold text-gray-900 dark:text-white text-sm block"></span>
        </div>

        <form method="post" id="resetPasswordForm">
            <?= csrf_field() ?>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password Baru</label>
                    <div class="relative">
                        <input type="text" name="new_password" id="password_baru" required
                            class="w-full h-10 rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 text-xs text-gray-900 font-mono tracking-wider focus:border-brand-500 focus:bg-white focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                            placeholder="Minimal 6 karakter">
                        <button type="button" onclick="generateRandomPassword()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-[10px] font-bold rounded-lg hover:bg-amber-200 transition-colors">
                            Acak
                        </button>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 leading-relaxed">
                    Setelah reset, slip password baru akan terbuka di tab baru untuk dicetak/diserahkan ke siswa.
                </p>
            </div>

            <div class="mt-6 flex justify-end gap-2.5">
                <button type="button" onclick="closeResetPasswordModal()" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-xs font-bold text-white shadow-theme-xs transition-colors">
                    Simpan &amp; Cetak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetPasswordModal(idSiswa, namaSiswa) {
        document.getElementById('resetStudentName').textContent = namaSiswa;
        document.getElementById('resetPasswordForm').action = '<?= base_url('verifikator/siswa/resetPassword') ?>/' + idSiswa;
        generateRandomPassword();
        
        const modal = document.getElementById('resetPasswordModal');
        const content = document.getElementById('resetPasswordModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeResetPasswordModal() {
        const modal = document.getElementById('resetPasswordModal');
        const content = document.getElementById('resetPasswordModalContent');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    function generateRandomPassword() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let pass = '';
        for (let i = 0; i < 6; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('password_baru').value = pass;
    }
</script>

<?= $this->endSection() ?>