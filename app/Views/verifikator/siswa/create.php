<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Daftarkan Siswa Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">person_add</span> Pendaftaran Siswa Offline (Verifikator)
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50/80 p-4 text-red-800 shadow-sm dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg mt-0.5">error</span>
            <div class="flex-1 text-xs">
                <span class="font-bold block mb-1">Gagal Mendaftarkan Siswa:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Daftar Siswa Terdaftar Card -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800 md:px-6 flex items-center justify-between flex-wrap gap-3">
        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Siswa Registrasi Offline</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Siswa yang didaftarkan langsung oleh Verifikator. Klik "Isi Biodata" untuk melengkapi formulir.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-theme-xs">
                <span class="material-symbols-outlined text-sm text-brand-500">group</span>
                <span><?= count($siswaList ?? []) ?> Siswa</span>
            </span>
            <button onclick="openModal()" class="inline-flex items-center gap-1.5 rounded-xl bg-brand-500 px-4 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-brand-600 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">add</span>
                <span>Tambah Siswa Baru</span>
            </button>
        </div>
    </div>

    <?php if (!empty($siswaList)) : ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:border-gray-800 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/30">
                        <th class="py-3.5 px-5">No. Pendaftaran</th>
                        <th class="py-3.5 px-5">Calon Siswa</th>
                        <th class="py-3.5 px-5">Kelengkapan</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                    <?php foreach ($siswaList as $s) : 
                        $namaLengkap = $s['nama_lengkap'] ?? '-';
                        $inisial = mb_substr(trim($namaLengkap), 0, 1);
                        if (empty($inisial)) $inisial = 'S';
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors dark:hover:bg-white/[0.02]">
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex rounded-lg bg-gray-100 px-2 py-0.5 font-mono text-[11px] font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <?= esc($s['no_pendaftaran']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-full bg-brand-50 dark:bg-brand-500/15 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= esc($inisial) ?>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white block"><?= esc($namaLengkap) ?></span>
                                        <span class="text-[11px] text-gray-400 dark:text-gray-500 font-mono">NISN: <?= esc($s['nisn'] ?? '-') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 min-w-[140px]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-2 overflow-hidden">
                                        <div class="<?= ($s['kelengkapan'] ?? 0) == 100 ? 'bg-emerald-500' : (($s['kelengkapan'] ?? 0) >= 50 ? 'bg-brand-500' : 'bg-amber-500') ?> h-2 rounded-full transition-all" style="width: <?= esc($s['kelengkapan'] ?? 0, 'attr') ?>%"></div>
                                    </div>
                                    <span class="text-[11px] font-bold <?= ($s['kelengkapan'] ?? 0) == 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' ?>">
                                        <?= esc($s['kelengkapan'] ?? 0) ?>%
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <?php if (($s['status_verifikasi'] ?? '') === 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                    </span>
                                <?php elseif (($s['status_verifikasi'] ?? '') === 'Ditolak') : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3.5 px-5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="<?= base_url('verifikator/siswa/biodata/' . $s['id_siswa']) ?>"
                                        class="inline-flex items-center gap-1 rounded-lg bg-brand-500 px-3 py-1.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition-colors"
                                        title="Lengkapi Biodata">
                                        <span class="material-symbols-outlined text-xs">edit_note</span>
                                        <span>Isi Biodata</span>
                                    </a>
                                    <a href="<?= base_url('verifikator/siswa/cetak-akun/' . $s['id_siswa']) ?>" target="_blank"
                                        class="inline-flex items-center gap-1 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 transition-colors"
                                        title="Cetak Akun">
                                        <span class="material-symbols-outlined text-xs">badge</span>
                                        <span>Slip Akun</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="py-12 px-5 text-center text-gray-400 dark:text-gray-500">
            <div class="flex flex-col items-center justify-center">
                <span class="material-symbols-outlined text-4xl mb-2 text-gray-300 dark:text-gray-600">person_add_disabled</span>
                <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Belum Ada Siswa Terdaftar</p>
                <p class="text-xs text-gray-400">Daftarkan akun siswa offline menggunakan tombol di atas.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Registrasi Akun (TailAdmin Style) -->
<div id="registerModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-900 rounded-2xl max-w-2xl w-full p-6 md:p-8 shadow-theme-xl border border-gray-200 dark:border-gray-800 max-h-[90vh] overflow-y-auto transform transition-all">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500">person_add</span>
                    <span>Registrasi Akun Siswa Baru</span>
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Isi data dasar untuk membuat akun calon siswa di sistem PPDB.</p>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3.5 text-red-800 text-xs dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300">
                <span class="font-bold block mb-1">Periksa kembali data yang dimasukkan:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('verifikator/siswa/store') ?>" method="post" id="formRegisterSiswa" onsubmit="return validateFormRegister()">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nisn" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NISN (10 Digit) <span class="text-red-500">*</span></label>
                    <input type="text" name="nisn" id="nisn" required value="<?= old('nisn') ?>"
                        maxlength="10" minlength="10" pattern="[0-9]{10}" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none font-mono"
                        placeholder="Contoh: 0071234567">
                </div>

                <div>
                    <label for="nama_lengkap" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" required value="<?= old('nama_lengkap') ?>"
                        minlength="3"
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none"
                        placeholder="Sesuai Akte Kelahiran / KK">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email Aktif <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required value="<?= old('email') ?>"
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none"
                        placeholder="contoh@email.com">
                </div>

                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. WhatsApp / HP <span class="text-red-500">*</span></label>
                    <input type="tel" name="no_hp" id="no_hp" required value="<?= old('no_hp') ?>"
                        maxlength="16" inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none font-mono"
                        placeholder="Contoh: 081234567890">
                </div>

                <div class="relative">
                    <label for="password" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password Akun <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required minlength="6"
                            oninput="checkPasswordMatch()"
                            class="w-full h-10 px-3.5 pr-10 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none"
                            placeholder="Minimal 6 karakter">
                        <button type="button" onclick="togglePasswordVisibility('password', 'eyePassword')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <span class="material-symbols-outlined text-base" id="eyePassword">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <label for="confirm_password" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" required minlength="6"
                            oninput="checkPasswordMatch()"
                            class="w-full h-10 px-3.5 pr-10 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-brand-500 focus:bg-white focus:outline-none"
                            placeholder="Ulangi password">
                        <button type="button" onclick="togglePasswordVisibility('confirm_password', 'eyeConfirmPassword')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <span class="material-symbols-outlined text-base" id="eyeConfirmPassword">visibility</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="passwordMismatchError" class="mt-3 text-red-500 text-xs font-semibold hidden flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">warning</span>
                <span>Konfirmasi password tidak cocok dengan password akun!</span>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-100 dark:border-gray-800 flex justify-end gap-2.5">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-xs font-bold text-white shadow-theme-xs transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">how_to_reg</span>
                    <span>Daftarkan Akun</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('registerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('registerModal').classList.add('hidden');
    document.body.style.overflow = '';
}
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
function checkPasswordMatch() {
    const pwd = document.getElementById('password').value;
    const confirmPwd = document.getElementById('confirm_password').value;
    const errEl = document.getElementById('passwordMismatchError');
    if (confirmPwd.length > 0 && pwd !== confirmPwd) {
        if (errEl) errEl.classList.remove('hidden');
        return false;
    } else {
        if (errEl) errEl.classList.add('hidden');
        return true;
    }
}
function validateFormRegister() {
    return checkPasswordMatch();
}
document.getElementById('registerModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
<?php if (session()->getFlashdata('errors') || session()->getFlashdata('error')) : ?>
document.addEventListener('DOMContentLoaded', openModal);
<?php endif; ?>
</script>

<?= $this->endSection() ?>
