<?= $this->extend('layouts/siswa') ?>

<?= $this->section('title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Profil Saya
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="max-w-4xl mx-auto">
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Photo Section -->
            <div class="flex-shrink-0">
                <?php
                $fotoPath = 'uploads/berkas/' . $siswa['nisn'] . '/' . ($siswa['foto'] ?? '');
                $displayFoto = (isset($siswa['foto']) && file_exists(FCPATH . $fotoPath))
                    ? base_url($fotoPath)
                    : base_url('assets/img/default-avatar.png');
                ?>
                <div class="relative">
                    <img src="<?= $displayFoto ?>"
                        alt="Foto Profil"
                        class="w-32 h-32 rounded-full object-cover border-4 border-blue-600">
                    <button onclick="document.getElementById('foto-input').click()"
                        class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>

                <!-- Hidden File Input -->
                <form action="<?= base_url('siswa/profile/update-foto') ?>" method="POST" enctype="multipart/form-data" id="foto-form">
                    <?= csrf_field() ?>
                    <input type="file"
                        id="foto-input"
                        name="foto"
                        class="hidden"
                        accept="image/*"
                        onchange="previewAndSubmit(this)">
                </form>

                <!-- Delete Photo Button -->
                <?php if (!empty($siswa['foto'])): ?>
                    <button onclick="confirmDelete()"
                        class="mt-3 w-full bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Foto
                    </button>

                    <form action="<?= base_url('siswa/profile/delete-foto') ?>" method="POST" id="delete-foto-form" class="hidden">
                        <?= csrf_field() ?>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Info Section -->
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800 mb-2"><?= esc($siswa['nama_lengkap']) ?></h2>
                <p class="text-gray-600 mb-4">
                    <i class="fas fa-id-card mr-2"></i><?= esc($siswa['nisn']) ?>
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">No. Pendaftaran</p>
                        <p class="font-semibold text-gray-800"><?= esc($siswa['no_pendaftaran']) ?></p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 mb-1">Status Verifikasi</p>
                        <?php
                        // Map numeric status to text
                        $statusMap = [
                            '0' => 'Menunggu',
                            '1' => 'Terverifikasi',
                            '2' => 'Ditolak'
                        ];

                        $statusColors = [
                            'Menunggu' => 'yellow',
                            'Terverifikasi' => 'green',
                            'Ditolak' => 'red'
                        ];

                        // Get status text from numeric value or use as-is if already text
                        $statusValue = $siswa['status_verifikasi'] ?? '0';
                        $statusText = $statusMap[$statusValue] ?? $statusValue;

                        // Handle if already text
                        if (!isset($statusMap[$statusValue])) {
                            $statusText = $statusValue ?: 'Menunggu';
                        }

                        $color = $statusColors[$statusText] ?? 'gray';
                        ?>
                        <p class="font-semibold text-<?= $color ?>-600"><?= esc($statusText) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Settings Card -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-cog mr-2 text-blue-600"></i>Pengaturan Akun
        </h3>

        <div class="space-y-3">
            <a href="<?= base_url('siswa/ubah-password') ?>"
                class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition group">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-key text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Ubah Password</p>
                        <p class="text-sm text-gray-500">Ganti password akun Anda</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
            </a>

            <a href="<?= base_url('siswa/biodata') ?>"
                class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition group">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-edit text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Edit Biodata</p>
                        <p class="text-sm text-gray-500">Lengkapi dan update biodata Anda</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewAndSubmit(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (file.size > maxSize) {
                alert('Ukuran file maksimal 2MB');
                input.value = '';
                return;
            }

            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar');
                input.value = '';
                return;
            }

            // Confirm before upload
            if (confirm('Yakin ingin mengupdate foto profil?')) {
                document.getElementById('foto-form').submit();
            } else {
                input.value = '';
            }
        }
    }

    function confirmDelete() {
        if (confirm('Yakin ingin menghapus foto profil? File akan dihapus dari storage.')) {
            document.getElementById('delete-foto-form').submit();
        }
    }
</script>
<?= $this->endSection() ?>