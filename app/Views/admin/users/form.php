<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= isset($user) ? 'Edit User' : 'Tambah User' ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= isset($user) ? 'Edit User' : 'Tambah User' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900"><?= isset($user) ? 'Edit User' : 'Tambah User Baru' ?></h3>
    </div>

    <form action="<?= isset($user) ? base_url('admin/users/update/' . $user['id_user']) : base_url('admin/users/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="<?= isset($user) ? $user['username'] : '' ?>"
                        required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password <?= isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '<span class="text-red-500">*</span>' ?>
                    </label>
                    <input type="password" name="password" <?= !isset($user) ? 'required' : '' ?>
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" value="<?= isset($user) ? $user['nama_lengkap'] : '' ?>"
                    required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border"><?= isset($user) ? $user['alamat'] : '' ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="<?= isset($user) ? $user['email'] : '' ?>"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="telp" value="<?= isset($user) ? $user['telp'] : '' ?>"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                <select name="level" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border">
                    <option value="">-- Pilih Level --</option>
                    <option value="admin" <?= (isset($user) && $user['level'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="verifikato" <?= (isset($user) && $user['level'] == 'verifikato') ? 'selected' : '' ?>>Verifikator</option>
                </select>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <a href="<?= base_url('admin/users') ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>