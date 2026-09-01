<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">account_circle</span> Profil Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Validation Error Alerts -->
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50/90 p-4 text-red-800 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-300 shadow-theme-xs">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-500 text-xl flex-shrink-0 mt-0.5">error</span>
            <div class="flex-1">
                <p class="font-bold text-sm">Terjadi beberapa kesalahan:</p>
                <ul class="mt-1.5 list-disc list-inside text-xs space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Profile Overview Card -->
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start md:items-center gap-5 text-center sm:text-left">
            <!-- Avatar Container -->
            <div class="relative group">
                <div class="h-24 w-24 overflow-hidden rounded-2xl ring-4 ring-brand-500/10 dark:ring-brand-500/20 shadow-theme-sm bg-gray-100 dark:bg-gray-800">
                    <img id="header-avatar-img" src="<?= $avatarUrl ?>" alt="Foto Profil" class="h-full w-full object-cover" />
                </div>
                <button type="button" onclick="switchProfileTab('tab-avatar')" class="absolute -bottom-2 -right-2 flex h-8 w-8 items-center justify-center rounded-xl bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 transition-colors" title="Ganti Foto Profil">
                    <span class="material-symbols-outlined text-base">photo_camera</span>
                </button>
            </div>

            <!-- User Main Info -->
            <div>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        <?= esc($user['nama_lengkap'] ?: $user['username']) ?>
                    </h2>
                    <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-0.5 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/60 dark:border-brand-500/20">
                        <span class="material-symbols-outlined text-xs">verified_user</span>
                        <?= ucfirst(esc($user['level'] ?? 'Admin')) ?>
                    </span>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center justify-center sm:justify-start gap-1.5">
                    <span class="material-symbols-outlined text-sm">alternate_email</span>
                    @<?= esc($user['username']) ?>
                    <?php if (!empty($user['email'])): ?>
                        <span class="mx-1 text-gray-300 dark:text-gray-600">&bull;</span>
                        <span class="material-symbols-outlined text-sm">mail</span>
                        <?= esc($user['email']) ?>
                    <?php endif; ?>
                </p>
                <div class="mt-3 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-gray-400">calendar_today</span>
                        <span>Terdaftar: <b><?= !empty($user['tgl_daftar']) ? date('d M Y', strtotime($user['tgl_daftar'])) : '-' ?></b></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm text-gray-400">schedule</span>
                        <span>Login Terakhir: <b><?= !empty($user['last_login']) ? date('d M Y, H:i', strtotime($user['last_login'])) : '-' ?></b></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex items-center gap-2.5 self-stretch sm:self-auto justify-center">
            <button type="button" onclick="switchProfileTab('tab-security')" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                <span class="material-symbols-outlined text-base text-gray-500">lock_reset</span>
                Ganti Kata Sandi
            </button>
            <button type="button" onclick="switchProfileTab('tab-info')" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition-colors active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">edit</span>
                Edit Data
            </button>
        </div>
    </div>
</div>

<!-- Tab Navigation (TailAdmin Pill Style) -->
<div class="mb-6">
    <div class="flex flex-wrap gap-1.5 rounded-xl bg-gray-100 p-1.5 dark:bg-gray-800" role="tablist">
        <button onclick="switchProfileTab('tab-info')" id="btn-tab-info" class="profile-tab-btn flex items-center gap-2 rounded-lg px-5 py-2.5 text-xs font-bold transition-all duration-200" type="button">
            <span class="material-symbols-outlined text-base">person</span>
            <span>Informasi Akun</span>
        </button>
        <button onclick="switchProfileTab('tab-security')" id="btn-tab-security" class="profile-tab-btn flex items-center gap-2 rounded-lg px-5 py-2.5 text-xs font-bold transition-all duration-200" type="button">
            <span class="material-symbols-outlined text-base">security</span>
            <span>Keamanan & Password</span>
        </button>
        <button onclick="switchProfileTab('tab-avatar')" id="btn-tab-avatar" class="profile-tab-btn flex items-center gap-2 rounded-lg px-5 py-2.5 text-xs font-bold transition-all duration-200" type="button">
            <span class="material-symbols-outlined text-base">image</span>
            <span>Foto Profil</span>
        </button>
        <button onclick="switchProfileTab('tab-activity')" id="btn-tab-activity" class="profile-tab-btn flex items-center gap-2 rounded-lg px-5 py-2.5 text-xs font-bold transition-all duration-200" type="button">
            <span class="material-symbols-outlined text-base">history</span>
            <span>Riwayat Aktivitas</span>
        </button>
    </div>
</div>

<!-- Tab 1: Informasi Akun -->
<div id="tab-info" class="profile-tab-content">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Informasi Akun & Data Diri</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi identitas dan kontak akun Anda</p>
            </div>
            <span class="material-symbols-outlined text-brand-500 text-2xl">badge</span>
        </div>

        <form action="<?= base_url('admin/profile/update') ?>" method="post" class="p-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">person</span>
                        </span>
                        <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>" required
                               placeholder="Nama lengkap pengguna"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Username Login -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Username Login <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500 font-semibold text-sm">@</span>
                        <input type="text" name="username" value="<?= old('username', $user['username'] ?? '') ?>" required
                               placeholder="username_login"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-9 pr-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                    </div>
                    <p class="mt-1 text-[11px] text-gray-400">Hanya boleh berisi huruf dan angka tanpa spasi.</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">mail</span>
                        </span>
                        <input type="email" name="email" value="<?= old('email', $user['email'] ?? '') ?>"
                               placeholder="nama@email.com"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                    </div>
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nomor HP / WhatsApp
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">call</span>
                        </span>
                        <input type="text" name="telp" value="<?= old('telp', $user['telp'] ?? '') ?>"
                               placeholder="0812-3456-7890"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Alamat Tempat Tinggal
                    </label>
                    <div class="relative">
                        <textarea name="alamat" rows="3" placeholder="Alamat lengkap tempat tinggal..."
                                  class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all"><?= old('alamat', $user['alamat'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Peran / Level -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Peran / Hak Akses (Level)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">shield</span>
                        </span>
                        <input type="text" value="<?= ucfirst(esc($user['level'] ?? 'Admin')) ?>" readonly disabled
                               class="w-full rounded-xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-2.5 text-sm font-semibold text-gray-600 dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-400 cursor-not-allowed">
                    </div>
                    <p class="mt-1 text-[11px] text-gray-400">Hak akses dikonfigurasi melalui menu Pengguna.</p>
                </div>

                <!-- ID Pengguna -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        ID Pengguna
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">tag</span>
                        </span>
                        <input type="text" value="#<?= esc($user['id_user'] ?? '1') ?>" readonly disabled
                               class="w-full rounded-xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-2.5 text-sm font-mono text-gray-600 dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-400 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-200 dark:border-gray-800">
                <button type="reset" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined text-base">refresh</span>
                    Reset
                </button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition-all duration-200 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tab 2: Keamanan & Ganti Password -->
<div id="tab-security" class="profile-tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Ganti Kata Sandi</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pastikan menggunakan kata sandi yang kuat dan tidak mudah ditebak</p>
            </div>
            <span class="material-symbols-outlined text-amber-500 text-2xl">lock</span>
        </div>

        <form action="<?= base_url('admin/profile/updatePassword') ?>" method="post" class="p-6 max-w-2xl">
            <?= csrf_field() ?>

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kata Sandi Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">lock</span>
                        </span>
                        <input type="password" name="password_lama" id="pass_lama" required placeholder="Masukkan password saat ini"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-11 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('pass_lama', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">key</span>
                        </span>
                        <input type="password" name="password_baru" id="pass_baru" required placeholder="Minimal 6 karakter" minlength="6"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-11 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('pass_baru', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                    <p class="mt-1 text-[11px] text-gray-400">Minimal 6 karakter, kombinasikan huruf, angka, dan simbol.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-gray-500">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                        </span>
                        <input type="password" name="konfirmasi_password" id="pass_konfirmasi" required placeholder="Ketik ulang password baru" minlength="6"
                               class="w-full rounded-xl border border-gray-300 bg-white pl-10 pr-11 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder:text-gray-500 outline-none transition-all">
                        <button type="button" onclick="togglePasswordVisibility('pass_konfirmasi', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-200 dark:border-gray-800">
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition-all duration-200 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-base">key</span>
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tab 3: Foto Profil -->
<div id="tab-avatar" class="profile-tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Foto Profil</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Unggah foto profil yang akan ditampilkan pada header dan menu navigasi</p>
            </div>
            <span class="material-symbols-outlined text-brand-500 text-2xl">account_box</span>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <!-- Current Avatar Preview -->
                <div class="flex flex-col items-center justify-center p-6 rounded-2xl border border-gray-200 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/30 text-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Preview Saat Ini</p>
                    <div class="h-36 w-36 overflow-hidden rounded-2xl ring-4 ring-brand-500/20 shadow-theme-md bg-white dark:bg-gray-900">
                        <img id="tab-avatar-preview" src="<?= $avatarUrl ?>" alt="Foto Profil" class="h-full w-full object-cover" />
                    </div>
                    <span class="mt-4 text-xs font-semibold text-gray-700 dark:text-gray-300"><?= esc($user['nama_lengkap']) ?></span>
                    <span class="text-[11px] text-gray-400">@<?= esc($user['username']) ?></span>

                    <?php if (!empty($user['foto'])): ?>
                        <form action="<?= base_url('admin/profile/deleteFoto') ?>" method="post" class="mt-5" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto profil ini?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-white px-3.5 py-2 text-xs font-semibold text-red-600 shadow-theme-xs hover:bg-red-50 dark:border-red-900/50 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30 transition-colors">
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Hapus Foto Profil
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- Upload Form Area -->
                <div class="md:col-span-2 space-y-5">
                    <form action="<?= base_url('admin/profile/updateFoto') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700 p-8 text-center hover:border-brand-500 dark:hover:border-brand-400 transition-colors cursor-pointer bg-gray-50/50 dark:bg-gray-900/50" onclick="document.getElementById('avatar-file-input').click()">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400 mb-3">
                                <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pilih Berkas Foto Baru</h4>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Klik di sini untuk menjelajahi komputer Anda</p>
                            <input type="file" name="foto" id="avatar-file-input" accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden" onchange="previewUploadedAvatar(this)">
                        </div>

                        <!-- Info Guide -->
                        <div class="rounded-xl border border-brand-100 bg-brand-50/50 p-4 dark:border-brand-500/20 dark:bg-brand-500/10">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-brand-500 text-lg flex-shrink-0 mt-0.5">info</span>
                                <div class="text-xs text-gray-600 dark:text-gray-300 space-y-1">
                                    <p class="font-bold text-brand-700 dark:text-brand-300">Ketentuan Foto Profil:</p>
                                    <ul class="list-disc list-inside space-y-0.5 text-gray-500 dark:text-gray-400">
                                        <li>Format yang didukung: <b>JPG, JPEG, PNG, WebP</b>.</li>
                                        <li>Ukuran file maksimal: <b>2 MB</b>.</li>
                                        <li>Rekomendasi rasio gambar: <b>1:1 (Persegi)</b> untuk hasil optimal.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" id="btn-save-avatar" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-semibold text-white shadow-theme-xs hover:bg-brand-600 transition-all duration-200 active:scale-[0.98]">
                                <span class="material-symbols-outlined text-base">upload</span>
                                Simpan Foto Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab 4: Riwayat Aktivitas -->
<div id="tab-activity" class="profile-tab-content hidden">
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Aktivitas Terakhir</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Catatan aktivitas dan tindakan yang dilakukan oleh akun ini</p>
            </div>
            <a href="<?= base_url('admin/log_aktivitas') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-500 hover:text-brand-600 hover:underline">
                Lihat Semua Log
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <?php if (!empty($logs)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-gray-100 bg-gray-50/50 text-gray-500 dark:border-gray-800 dark:bg-gray-800/40 dark:text-gray-400 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-3.5">Waktu</th>
                            <th class="px-6 py-3.5">Tindakan</th>
                            <th class="px-6 py-3.5">Keterangan</th>
                            <th class="px-6 py-3.5">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php foreach ($logs as $log): ?>
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-xs text-gray-400">schedule</span>
                                        <?= date('d M Y, H:i', strtotime($log['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex rounded-lg bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                        <?= esc($log['tindakan']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    <?= esc($log['keterangan']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-gray-400 text-[11px]">
                                    <?= esc($log['ip_address'] ?? '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 mb-3">
                    <span class="material-symbols-outlined text-2xl">history_toggle_off</span>
                </div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada riwayat aktivitas</p>
                <p class="mt-1 text-xs text-gray-400">Aktivitas akun akan tercatat secara otomatis saat Anda menggunakan sistem.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function switchProfileTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.profile-tab-content').forEach(el => {
            el.classList.add('hidden');
        });

        // Reset button styles
        document.querySelectorAll('.profile-tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm');
            btn.classList.add('text-gray-500', 'dark:text-gray-400');
        });

        // Show active tab
        const targetContent = document.getElementById(tabId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Highlight active tab button
        const activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
            activeBtn.classList.add('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm');
        }

        // Save active tab
        localStorage.setItem('active_admin_profile_tab', tabId);
    }

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }

    function previewUploadedAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('tab-avatar-preview').src = e.target.result;
                document.getElementById('header-avatar-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const savedTab = localStorage.getItem('active_admin_profile_tab') || 'tab-info';
        if (document.getElementById(savedTab)) {
            switchProfileTab(savedTab);
        } else {
            switchProfileTab('tab-info');
        }
    });
</script>
<?= $this->endSection() ?>
