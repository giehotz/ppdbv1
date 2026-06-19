<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Daftarkan Siswa Baru<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pendaftaran Siswa Offline<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-4xl mx-auto">
    <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Langkah 1: Registrasi Akun Siswa</h2>
            <p class="text-slate-500 text-sm mt-1">Isi data akun dasar untuk membuat akun siswa baru di sistem.</p>
        </div>
        <div class="hidden sm:flex text-sm font-semibold text-slate-400 gap-4">
            <span class="text-blue-600 border-b-2 border-blue-600 pb-1">1. Akun</span>
            <span>2. Biodata</span>
            <span>3. Berkas</span>
            <span>4. Selesai</span>
        </div>
    </div>

    <div class="p-6 md:p-8">
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('verifikator/siswa/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NISN -->
                <div>
                    <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-2">NISN <span class="text-red-500">*</span></label>
                    <input type="text" name="nisn" id="nisn" required value="<?= old('nisn') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="10 digit angka">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" required value="<?= old('nama_lengkap') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="Sesuai Akte Kelahiran">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Aktif <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required value="<?= old('email') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="contoh@email.com">
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-2">No. Handphone/WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" id="no_hp" required value="<?= old('no_hp') ?>"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="Contoh: 08123456789">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password Akun <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="Minimal 6 karakter">
                    <p class="text-xs text-slate-400 mt-1">Buatkan password sementara untuk siswa (misal: 123456).</p>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="Ulangi password di atas">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                <a href="<?= base_url('verifikator/siswa') ?>" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-sm shadow-blue-600/30 transition-all flex items-center gap-2">
                    Buat Akun & Lanjut <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
