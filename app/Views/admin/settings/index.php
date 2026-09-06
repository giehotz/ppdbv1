<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan Sistem
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">settings</span> Pengaturan Sistem
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Tab Navigation (TailAdmin Pill Style) -->
<div class="mb-8">
    <div class="flex flex-wrap gap-1 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl" id="settings-tabs" role="tablist">
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="sistem-tab-btn" data-target="tab-sistem" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">settings</span>
            <span>Sistem PPDB</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="sekolah-tab-btn" data-target="tab-sekolah" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">school</span>
            <span>Profil Sekolah</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="referensi-tab-btn" data-target="tab-referensi" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">list_alt</span>
            <span>Data Referensi</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="biodata-tab-btn" data-target="tab-biodata" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">fact_check</span>
            <span>Wajib Biodata</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="kop-tab-btn" data-target="tab-kop" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">description</span>
            <span>Kop Dokumen</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="stepper-tab-btn" data-target="tab-stepper" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">alt_route</span>
            <span>Alur &amp; Stepper</span>
        </button>
    </div>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="space-y-6">
        <div id="tab-sistem" class="tab-content hidden">
            <?= view('admin/settings/_tab_sistem') ?>
        </div>

        <div id="tab-sekolah" class="tab-content hidden">
            <?= view('admin/settings/_tab_sekolah') ?>
        </div>

        <div id="tab-referensi" class="tab-content hidden">
            <?= view('admin/settings/_tab_referensi') ?>
        </div>

        <div id="tab-biodata" class="tab-content hidden">
            <?= view('admin/settings/_tab_biodata') ?>
        </div>

        <div id="tab-kop" class="tab-content hidden">
            <?= view('admin/settings/_tab_kop') ?>
        </div>

        <div id="tab-stepper" class="tab-content hidden">
            <?= view('admin/settings/_tab_stepper', ['stepperConfig' => $stepperConfig, 'stepperAktif' => $stepperAktif]) ?>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-800">
            <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 px-8 rounded-xl shadow-theme-xs hover:shadow-theme-md transition-all duration-200 active:scale-[0.97]">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<!-- Standalone Action Forms (Tidak nested dalam form utama) -->
<form id="form-activate-tp" action="" method="post" class="hidden">
    <?= csrf_field() ?>
</form>

<form id="form-delete-tp" action="" method="post" class="hidden">
    <?= csrf_field() ?>
</form>

<form id="formResetStepperAction" action="<?= base_url('admin/settings/stepper/reset') ?>" method="post" class="hidden">
    <?= csrf_field() ?>
</form>

<!-- Modal Tambah Tahun Pelajaran -->
<div id="modal-tambah-tp" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-theme-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">calendar_add_on</span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Tahun Pelajaran</h3>
            </div>
            <button type="button" onclick="closeModalTambahTP()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="<?= base_url('admin/settings/tahun-pelajaran/store') ?>" method="post" class="mt-5 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Tahun Pelajaran <span class="text-red-500">*</span></label>
                <input type="text" name="tahun_pelajaran" placeholder="Contoh: 2026/2027" pattern="^[0-9]{4}/[0-9]{4}$" required
                       class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                <span class="text-[11px] text-gray-400 mt-1 block">Format: YYYY/YYYY (contoh: 2026/2027)</span>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Keterangan / Catatan</label>
                <input type="text" name="keterangan" placeholder="Contoh: Tahun Ajaran Baru 2026/2027"
                       class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div class="pt-2">
                <label class="flex items-start gap-2.5 cursor-pointer">
                    <input type="checkbox" name="set_aktif" value="1" class="mt-0.5 rounded text-brand-500 focus:ring-brand-400">
                    <span class="text-xs text-gray-700 dark:text-gray-300 font-medium leading-relaxed">
                        <strong>Langsung jadikan Tahun Pelajaran Aktif</strong><br>
                        <span class="text-gray-500 dark:text-gray-400 text-[11px]">Sistem akan langsung menyembunyikan pendaftar dari tahun sebelumnya.</span>
                    </span>
                </label>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800 mt-6">
                <button type="button" onclick="closeModalTambahTP()" class="px-4 py-2 text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-lg shadow-theme-xs transition-colors">
                    Simpan Tahun
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Tahapan Custom Stepper -->
<div id="modalTambahStep" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-theme-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">add_task</span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Tahapan Baru</h3>
            </div>
            <button type="button" onclick="closeModalTambahStep()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="mt-5 space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Judul Tahapan <span class="text-red-500">*</span></label>
                <input type="text" id="newStepTitle" placeholder="Contoh: Wawancara Orang Tua & Siswa"
                       class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Deskripsi / Petunjuk Singkat</label>
                <textarea id="newStepDesc" rows="2" placeholder="Contoh: Datang ke sekolah bersama orang tua sesuai jadwal"
                          class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Icon Material Symbol</label>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0 border border-gray-200 dark:border-gray-700">
                            <span id="newStepIconPreview" class="material-symbols-outlined text-brand-500 text-lg">groups</span>
                        </div>
                        <input type="text" id="newStepIcon" value="groups" oninput="const prev = document.getElementById('newStepIconPreview'); if(prev) prev.textContent = this.value || 'circle'"
                               placeholder="groups, event, school"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 block">Nama icon dari Google Material Symbols</span>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Status Bawaan Siswa</label>
                    <select id="newStepCustomStatus" class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                        <option value="pending">Menunggu / Belum Selesai</option>
                        <option value="success">Selesai (Centang Hijau)</option>
                        <option value="process">Sedang Berlangsung (Biru)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Link / URL Tombol Aksi (Opsional)</label>
                <input type="text" id="newStepUrl" placeholder="Contoh: siswa/daftar-ulang atau https://..."
                       class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                <span class="text-[10px] text-gray-400 mt-1 block">Kosongkan jika tahapan ini hanya bersifat informasi tanpa tautan halaman</span>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800 mt-6">
                <button type="button" onclick="closeModalTambahStep()" class="px-4 py-2.5 text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="button" onclick="handleSaveNewStep()" class="px-5 py-2.5 text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-theme-xs transition-colors">
                    Tambahkan ke Alur
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Tahapan Stepper -->
<div id="modalEditStep" class="fixed inset-0 z-[9999] hidden overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-theme-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500">edit_note</span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Edit Tahapan</h3>
            </div>
            <button type="button" onclick="closeModalEditStep()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="mt-5 space-y-4">
            <input type="hidden" id="editStepIndex" value="">
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Judul Tahapan <span class="text-red-500">*</span></label>
                <input type="text" id="editStepTitle"
                       class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Deskripsi / Petunjuk Singkat</label>
                <textarea id="editStepDesc" rows="2"
                          class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Icon Material Symbol</label>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0 border border-gray-200 dark:border-gray-700">
                            <span id="editStepIconPreview" class="material-symbols-outlined text-brand-500 text-lg">circle</span>
                        </div>
                        <input type="text" id="editStepIcon" oninput="const prev = document.getElementById('editStepIconPreview'); if(prev) prev.textContent = this.value || 'circle'"
                               class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                    </div>
                </div>
                <div id="editCustomStatusWrapper">
                    <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Status Bawaan Siswa</label>
                    <select id="editStepCustomStatus" class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                        <option value="pending">Menunggu / Belum Selesai</option>
                        <option value="success">Selesai (Centang Hijau)</option>
                        <option value="process">Sedang Berlangsung (Biru)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200 mb-1.5">Link / URL Tombol Aksi (Opsional)</label>
                <input type="text" id="editStepUrl" placeholder="Contoh: siswa/daftar-ulang atau https://..."
                       class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2 text-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800 mt-6">
                <button type="button" onclick="closeModalEditStep()" class="px-4 py-2.5 text-xs font-bold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="button" onclick="handleSaveEditStep()" class="px-5 py-2.5 text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 rounded-xl shadow-theme-xs transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModalTambahTP() {
        const modal = document.getElementById('modal-tambah-tp');
        if (modal) modal.classList.remove('hidden');
    }

    function closeModalTambahTP() {
        const modal = document.getElementById('modal-tambah-tp');
        if (modal) modal.classList.add('hidden');
    }

    function confirmActivateTP(id, tahun, totalSiswa) {
        Swal.fire({
            title: 'Ganti Tahun Pelajaran Aktif?',
            html: `<div class="text-left text-xs space-y-2">
                    <p>Anda akan mengaktifkan Tahun Pelajaran <strong>${tahun}</strong>.</p>
                    <div class="p-3 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300">
                        <strong>Perhatian:</strong> Data calon siswa dari tahun sebelumnya akan <strong>otomatis disembunyikan</strong> dari pendaftar aktif dan dashboard.<br>
                        Tahun ${tahun} saat ini memiliki <strong>${totalSiswa}</strong> pendaftar terdaftar.
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Jadikan Aktif!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('form-activate-tp');
                form.action = '<?= base_url('admin/settings/tahun-pelajaran/activate') ?>/' + id;
                form.submit();
            }
        });
    }

    function confirmDeleteTP(id, tahun) {
        Swal.fire({
            title: 'Hapus Tahun Pelajaran?',
            text: `Apakah Anda yakin ingin menghapus Tahun Pelajaran ${tahun} dari riwayat?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('form-delete-tp');
                form.action = '<?= base_url('admin/settings/tahun-pelajaran/delete') ?>/' + id;
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        function setActiveTab(targetId) {
            tabLinks.forEach(link => {
                link.classList.remove('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm');
                link.classList.add('text-gray-500', 'dark:text-gray-400');

                if (link.getAttribute('data-target') === targetId) {
                    link.classList.remove('text-gray-500', 'dark:text-gray-400');
                    link.classList.add('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm');
                }
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.id !== targetId);
            });

            localStorage.setItem('active_settings_tab', targetId);
        }

        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                setActiveTab(this.getAttribute('data-target'));
            });
        });

        const lastTab = localStorage.getItem('active_settings_tab');
        if (lastTab && document.getElementById(lastTab)) {
            setActiveTab(lastTab);
        } else {
            setActiveTab('tab-sistem');
        }
    });
</script>

<?= $this->endSection() ?>
