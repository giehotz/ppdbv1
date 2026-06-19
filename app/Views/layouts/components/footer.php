<?php
// Version Control (Bisa diubah ketika ada pembaruan sistem)
$app_version = "v1.0.1";
?>
<!-- Footer Area -->
<footer class="bg-white border-t border-gray-200 p-4 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500 mt-auto shadow-sm relative z-10">
    <div class="text-center md:text-left mb-2 md:mb-0">
        &copy; <?= date('Y') ?> <?= $app_alias ?? 'PPDB' ?> Online - <?= esc($sekolahName ?? 'Sistem Informasi Sekolah') ?>. All rights reserved.
    </div>
    
    <!-- Version Button -->
    <button type="button" onclick="openChangelogModal()" 
        class="font-medium text-gray-400 bg-gray-50 hover:bg-gray-100 px-3 py-1 rounded-full border border-gray-200 hover:border-gray-300 text-xs shadow-sm transition-colors duration-200 focus:outline-none flex items-center">
        <i class="fas fa-code-branch mr-1 text-blue-500"></i> Versi <?= $app_version ?>
    </button>
</footer>

<!-- Changelog Modal -->
<div id="changelogModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeChangelogModal()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col transform transition-all scale-95 opacity-0" id="changelogModalContent">
            <!-- Header -->
            <div class="bg-blue-50 rounded-t-2xl px-6 py-4 border-b border-blue-100 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 rounded-full p-2 shadow-sm text-blue-600">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-blue-800">Change Log (Riwayat Pembaruan)</h3>
                    </div>
                </div>
                <button type="button" onclick="closeChangelogModal()" class="text-blue-400 hover:text-blue-700 focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="px-6 py-4 overflow-y-auto flex-1 bg-gray-50">
                <!-- Timeline List -->
                <div class="relative border-l border-gray-200 ml-3">
                    
                    <!-- Item 1 (Latest) -->
                    <div class="mb-6" style="margin-left: 1.5rem;">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-4 ring-white" style="left: -0.75rem;">
                            <i class="fas fa-star text-blue-600 text-xs"></i>
                        </span>
                        <div class="flex flex-col sm:flex-row sm:items-center mb-1">
                            <h4 class="text-md font-semibold text-gray-900">Versi 1.0.1</h4>
                            <span class="text-xs font-medium px-2 py-0.5 rounded ml-0 sm:ml-2 mt-1 sm:mt-0 bg-blue-100 text-blue-800 border border-blue-200">Terbaru</span>
                            <span class="text-sm text-gray-400 ml-0 sm:ml-auto mt-1 sm:mt-0"><i class="far fa-calendar-alt mr-1"></i> Juni 2026</span>
                        </div>
                        <p class="mb-2 text-sm text-gray-500">Pembaruan kecil dan perbaikan fitur:</p>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li><span class="font-medium text-emerald-600">Baru:</span> Fitur Modal "Reset Password" dengan kemampuan simpan otomatis dan *auto-download* resi PDF di halaman Siswa.</li>
                            <li><span class="font-medium text-emerald-600">Baru:</span> Fitur "Laporan & Analisis" pendaftar dengan grafik pada Dashboard Admin.</li>
                            <li><span class="font-medium text-emerald-600">Baru:</span> Tambahan komponen Global Footer dan UI Changelog.</li>
                            <li><span class="font-medium text-amber-600">Perbaikan:</span> Menghilangkan margin kaku pada *print layout* agar bisa mencetak Laporan secara *multi-page*.</li>
                        </ul>
                    </div>

                    <!-- Item 2 -->
                    <div class="mb-6" style="margin-left: 1.5rem;">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full ring-4 ring-white" style="left: -0.75rem;">
                            <i class="fas fa-check text-gray-500 text-xs"></i>
                        </span>
                        <div class="flex items-center mb-1">
                            <h4 class="text-md font-semibold text-gray-900">Versi 1.0.0</h4>
                            <span class="text-sm text-gray-400 ml-auto"><i class="far fa-calendar-alt mr-1"></i> Awal 2026</span>
                        </div>
                        <p class="mb-2 text-sm text-gray-500">Rilis Awal Sistem PPDB Online:</p>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li>Modul Pendaftaran Calon Siswa Baru.</li>
                            <li>Modul Kelengkapan Berkas & Upload Dokumen.</li>
                            <li>Modul Dashboard Verifikator dan Administrator.</li>
                            <li>Pengumuman Kelulusan & Cetak Surat Tanda Lulus.</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-3 border-t border-gray-100 bg-white rounded-b-2xl text-center">
                <button type="button" onclick="closeChangelogModal()" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openChangelogModal() {
        const modal = document.getElementById('changelogModal');
        const content = document.getElementById('changelogModalContent');
        modal.classList.remove('hidden');

        // Allow display:block to render before triggering transition
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeChangelogModal() {
        const content = document.getElementById('changelogModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('changelogModal').classList.add('hidden');
        }, 200); // match transition duration
    }

    // Close modal on Escape key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('changelogModal');
            if (!modal.classList.contains('hidden')) {
                closeChangelogModal();
            }
        }
    });
</script>
