<!-- Action Header Bar -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="<?= base_url('verifikator/pindahan') ?>" class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition-all">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        <span>Kembali</span>
    </a>

    <div class="flex flex-wrap items-center gap-2.5">
        <!-- Edit Biodata -->
        <a href="<?= base_url('verifikator/pindahan/biodata/' . $siswa['id_pindahan']) ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-blue-700 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">edit_document</span>
            <span>Edit Biodata &amp; Berkas</span>
        </a>

        <!-- Kelola Berkas -->
        <a href="<?= base_url('verifikator/pindahan/berkas/' . $siswa['id_pindahan']) ?>" class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-indigo-700 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">folder_open</span>
            <span>Kelola Berkas</span>
        </a>

        <!-- Cetak Akun -->
        <a href="<?= base_url('verifikator/pindahan/cetak-akun/' . $siswa['id_pindahan']) ?>" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-emerald-700 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-base">print</span>
            <span>Cetak Akun</span>
        </a>

        <!-- Hapus Siswa Pindahan -->
        <form action="<?= base_url('verifikator/pindahan/delete/' . $siswa['id_pindahan']) ?>" method="post" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa pindahan ini secara permanen? Seluruh berkas dan data pendaftaran akan terhapus!');">
            <?= csrf_field() ?>
            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-red-500 px-3.5 py-2 text-xs font-bold text-white shadow-theme-xs hover:bg-red-600 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-base">delete</span>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>

