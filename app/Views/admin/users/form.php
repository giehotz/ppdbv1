<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?><?= isset($user) ? 'Edit User' : 'Tambah User' ?><?= $this->endSection() ?>
<?= $this->section('page_title') ?><?= isset($user) ? 'Edit User' : 'Tambah User' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center shrink-0">
                <i class="fas fa-user-plus text-green-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800"><?= isset($user) ? 'Edit User' : 'Tambah User Baru' ?></h3>
                <p class="text-sm text-gray-500"><?= isset($user) ? 'Ubah informasi pengguna' : 'Isi data untuk menambahkan pengguna baru' ?></p>
            </div>
        </div>

        <form action="<?= isset($user) ? base_url('admin/users/update/' . $user['id_user']) : base_url('admin/users/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="p-6 space-y-6">
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-id-card text-green-500"></i> Informasi Akun
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="username" value="<?= isset($user) ? esc($user['username']) : '' ?>"
                                    required
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Password <?= isset($user) ? '<span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>' : '<span class="text-red-500">*</span>' ?>
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="password" name="password" <?= !isset($user) ? 'required' : '' ?>
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-address-card text-green-500"></i> Informasi Pribadi
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-id-badge absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="text" name="nama_lengkap" value="<?= isset($user) ? esc($user['nama_lengkap']) : '' ?>"
                                    required
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400 text-sm"></i>
                                <textarea name="alamat" rows="3"
                                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none resize-none"><?= isset($user) ? esc($user['alamat']) : '' ?></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input type="email" name="email" value="<?= isset($user) ? esc($user['email']) : '' ?>"
                                        class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input type="text" name="telp" value="<?= isset($user) ? esc($user['telp']) : '' ?>"
                                        class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-user-tag text-green-500"></i> Hak Akses
                    </h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Level <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-shield-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <select name="level" required
                                class="w-full pl-9 pr-8 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none appearance-none bg-white">
                                <option value="">-- Pilih Level --</option>
                                <option value="admin" <?= (isset($user) && $user['level'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="verifikator" <?= (isset($user) && $user['level'] == 'verifikator') ? 'selected' : '' ?>>Verifikator</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <a href="<?= base_url('admin/users') ?>"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors duration-150">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-2.5 px-6 rounded-lg transition duration-150">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
