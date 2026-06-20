<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Daftarkan Siswa Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pendaftaran Siswa Offline<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center" role="alert">
        <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
        <span class="block sm:inline font-medium"><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
        <ul class="list-disc list-inside">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Modal Registrasi Akun -->
<div id="registerModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50 flex items-center justify-between rounded-t-2xl">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Registrasi Akun Siswa Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Isi data akun dasar untuk membuat akun siswa baru di sistem.</p>
            </div>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-200 rounded-full w-10 h-10 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-6 md:p-8">
            <form action="<?= base_url('verifikator/siswa/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="text" name="nisn" id="nisn" required value="<?= old('nisn') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="10 digit angka">
                    </div>

                    <div>
                        <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required value="<?= old('nama_lengkap') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="Sesuai Akte Kelahiran">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Aktif <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" required value="<?= old('email') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="contoh@email.com">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-2">No. Handphone/WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" required value="<?= old('no_hp') ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="Contoh: 08123456789">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Akun <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="Minimal 6 karakter">
                        <p class="text-xs text-slate-400 mt-1">Buatkan password sementara yang kuat untuk siswa (min. 8 karakter, kombinasi huruf &amp; angka).</p>
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="confirm_password" id="confirm_password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                            placeholder="Ulangi password di atas">
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-sm shadow-blue-600/30 transition-all flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Daftarkan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Daftar Siswa Terdaftar -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-6xl mx-auto">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between flex-wrap gap-3">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Siswa Terdaftar</h3>
            <p class="text-slate-500 text-sm mt-1">Siswa yang berhasil didaftarkan. Lengkapi biodata untuk melanjutkan.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm font-semibold text-slate-500 bg-white px-3 py-1 rounded-full border border-slate-200">
                <i class="fas fa-users mr-1"></i> <?= count($siswaList ?? []) ?> siswa
            </span>
            <button onclick="openModal()" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-sm shadow-blue-600/30 transition-all text-sm flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Siswa
            </button>
        </div>
    </div>

    <?php if (!empty($siswaList)) : ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs tracking-wider">
                        <th class="py-4 px-6 font-semibold">No. Pendaftaran</th>
                        <th class="py-4 px-6 font-semibold">NISN</th>
                        <th class="py-4 px-6 font-semibold">Nama Lengkap</th>
                        <th class="py-4 px-6 font-semibold">Kelengkapan Biodata</th>
                        <th class="py-4 px-6 font-semibold">Status</th>
                        <th class="py-4 px-6 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    <?php foreach ($siswaList as $s) : ?>
                        <tr class="border-b border-gray-100 hover:bg-gray-50/80 transition-colors">
                            <td class="py-3 px-6 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-700 py-1 px-2 rounded text-xs font-bold"><?= esc($s['no_pendaftaran']) ?></span>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap"><?= esc($s['nisn'] ?? '-') ?></td>
                            <td class="py-3 px-6 font-medium text-gray-900"><?= esc($s['nama_lengkap']) ?></td>
                            <td class="py-3 px-6 min-w-[160px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="<?= ($s['kelengkapan'] ?? 0) == 100 ? 'bg-emerald-500' : (($s['kelengkapan'] ?? 0) >= 50 ? 'bg-blue-500' : 'bg-red-500') ?> h-2.5 rounded-full transition-all" style="width: <?= esc($s['kelengkapan'] ?? 0, 'attr') ?>%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 font-bold whitespace-nowrap"><?= esc($s['kelengkapan'] ?? 0) ?>%</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 whitespace-nowrap">
                                <?php if ($s['status_verifikasi'] == 'Terverifikasi') : ?>
                                    <span class="inline-flex items-center bg-emerald-100 text-emerald-700 py-1 px-3 rounded-full text-xs font-bold border border-emerald-200">
                                        <i class="fas fa-check-circle mr-1.5"></i> Terverifikasi
                                    </span>
                                <?php elseif ($s['status_verifikasi'] == 'Ditolak') : ?>
                                    <span class="inline-flex items-center bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold border border-red-200">
                                        <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="inline-flex items-center bg-amber-100 text-amber-700 py-1 px-3 rounded-full text-xs font-bold border border-amber-200">
                                        <i class="fas fa-hourglass-half mr-1.5"></i> Menunggu
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= base_url('verifikator/siswa/biodata/' . $s['id_siswa']) ?>"
                                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded-lg transition duration-200 shadow-sm"
                                        title="Isi Biodata">
                                        <i class="fas fa-edit mr-1"></i> Isi Biodata
                                    </a>
                                    <a href="<?= base_url('verifikator/siswa/cetak-akun/' . $s['id_siswa']) ?>" target="_blank"
                                        class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-2 px-3 rounded-lg transition duration-200 shadow-sm"
                                        title="Cetak Informasi Akun">
                                        <i class="fas fa-print mr-1"></i> Cetak Akun
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="py-12 px-6 text-center">
            <div class="flex flex-col items-center justify-center text-gray-400">
                <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg font-medium text-gray-600 mb-1">Belum Ada Siswa Terdaftar</p>
                <p class="text-sm">Daftarkan akun siswa menggunakan tombol <strong>Tambah Siswa</strong> di atas.</p>
            </div>
        </div>
    <?php endif; ?>
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
