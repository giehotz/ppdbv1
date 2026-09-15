<?php
/**
 * Modal Riwayat Pembaruan (Changelog)
 * Digunakan pada template admin dan verifikator via layouts/components/footer.php
 */
$app_version = $app_version ?? 'v1.1.0';
?>
<!-- Changelog Modal -->
<div id="changelogModal" class="fixed inset-0 z-99999 hidden" aria-labelledby="changelogModalTitle" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeChangelogModal()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg max-h-[85vh] flex flex-col rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 overflow-hidden transform transition-all scale-95 opacity-0" id="changelogModalContent">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex justify-between items-center">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                        <i class="fas fa-clipboard-list text-sm"></i>
                    </div>
                    <div>
                        <h3 id="changelogModalTitle" class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Pembaruan (Changelog)</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Catatan rilis dan pembaharuan sistem PPDB</p>
                    </div>
                </div>
                <button type="button" onclick="closeChangelogModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors" aria-label="Tutup Modal">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="px-6 py-5 overflow-y-auto flex-1 bg-white dark:bg-gray-900">
                <!-- Timeline List -->
                <div class="relative border-l border-gray-200 dark:border-gray-800 ml-3 space-y-6">
                    
                    <!-- Item 1 (Latest) -->
                    <div class="relative pl-6">
                        <span class="absolute -left-3 top-0 flex h-6 w-6 items-center justify-center rounded-full bg-brand-50 ring-4 ring-white dark:bg-brand-500/20 dark:ring-gray-900">
                            <i class="fas fa-star text-brand-500 text-[10px]"></i>
                        </span>
                        <div class="flex flex-col sm:flex-row sm:items-center mb-1.5 gap-1 sm:gap-2">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Versi <?= esc(ltrim($app_version, 'v')) ?></h4>
                            <span class="inline-flex rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">Terbaru</span>
                            <span class="text-[11px] text-gray-400 dark:text-gray-500 sm:ml-auto"><i class="far fa-calendar-alt mr-1"></i> September 2026</span>
                        </div>
                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 font-medium">Pembaruan keamanan, arsitektur, UI mobile, & pengujian otomatis:</p>
                        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-rose-50 px-1.5 py-0.2 text-[10px] font-bold text-rose-600 dark:bg-rose-500/15 dark:text-rose-400 shrink-0 mt-0.5">Security</span>
                                <span>Proteksi CSRF global aktif &amp; pengamanan direktori upload dari eksekusi script (.htaccess).</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-emerald-50 px-1.5 py-0.2 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 shrink-0 mt-0.5">Baru</span>
                                <span>Fitur <em>Login sebagai Siswa</em> (Impersonate) aman via POST dengan middleware filter.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-brand-50 px-1.5 py-0.2 text-[10px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 mt-0.5">UI</span>
                                <span>Penyegaran tampilan modern Dashboard &amp; Formulir Biodata Siswa versi mobile ramah sentuhan.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-indigo-50 px-1.5 py-0.2 text-[10px] font-bold text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400 shrink-0 mt-0.5">Service</span>
                                <span>Ekstraksi <em>UnlockRequestService</em> untuk modularitas permohonan buka kunci biodata.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-blue-50 px-1.5 py-0.2 text-[10px] font-bold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 shrink-0 mt-0.5">Audit</span>
                                <span>Pencatatan log aktivitas otomatis untuk verifikasi berkas, pengajuan, &amp; finalisasi formulir.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-purple-50 px-1.5 py-0.2 text-[10px] font-bold text-purple-600 dark:bg-purple-500/15 dark:text-purple-400 shrink-0 mt-0.5">QA</span>
                                <span>Pemasangan automated test suite PHPUnit untuk validasi kalkulasi dan logika bisnis PPDB.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Item 2 -->
                    <div class="relative pl-6">
                        <span class="absolute -left-3 top-0 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-4 ring-white dark:bg-gray-800 dark:ring-gray-900">
                            <i class="fas fa-check text-gray-500 text-[10px]"></i>
                        </span>
                        <div class="flex items-center mb-1.5">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Versi 1.0.1</h4>
                            <span class="text-[11px] text-gray-400 dark:text-gray-500 ml-auto"><i class="far fa-calendar-alt mr-1"></i> Juni 2026</span>
                        </div>
                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 font-medium">Pembaruan tampilan TailAdmin & perbaikan fitur:</p>
                        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-brand-50 px-1.5 py-0.2 text-[10px] font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shrink-0 mt-0.5">UI</span>
                                <span>Integrasi antarmuka modern <strong>TailAdmin</strong> dengan dukungan Dark Mode.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-emerald-50 px-1.5 py-0.2 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 shrink-0 mt-0.5">Baru</span>
                                <span>Modal <em>Reset Password</em> dengan simpan instan dan cetak resi akun siswa.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-emerald-50 px-1.5 py-0.2 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 shrink-0 mt-0.5">Baru</span>
                                <span>Visual grafik analitik 7 hari pendaftar & peringkat sekolah asal di Dashboard.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="rounded bg-amber-50 px-1.5 py-0.2 text-[10px] font-bold text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 shrink-0 mt-0.5">Fix</span>
                                <span>Perbaikan margin print layout untuk cetak laporan pendaftar multi-halaman.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Item 3 -->
                    <div class="relative pl-6">
                        <span class="absolute -left-3 top-0 flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 ring-4 ring-white dark:bg-gray-800 dark:ring-gray-900">
                            <i class="fas fa-check text-gray-500 text-[10px]"></i>
                        </span>
                        <div class="flex items-center mb-1.5">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Versi 1.0.0</h4>
                            <span class="text-[11px] text-gray-400 dark:text-gray-500 ml-auto"><i class="far fa-calendar-alt mr-1"></i> Awal 2026</span>
                        </div>
                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400 font-medium">Rilis Perdana Sistem PPDB Online:</p>
                        <ul class="space-y-1 text-xs text-gray-600 dark:text-gray-300">
                            <li>• Modul Pendaftaran Calon Siswa Baru Online.</li>
                            <li>• Modul Kelengkapan & Validasi Berkas Persyaratan.</li>
                            <li>• Modul Dashboard Administrator dan Verifikator.</li>
                            <li>• Modul Pengumuman Kelulusan & Cetak Surat Tanda Lulus.</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 text-right">
                <button type="button" onclick="closeChangelogModal()" class="rounded-xl border border-gray-200 bg-white px-4 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
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
        if (!modal || !content) return;
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeChangelogModal() {
        const modal = document.getElementById('changelogModal');
        const content = document.getElementById('changelogModalContent');
        if (!modal || !content) return;
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('changelogModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeChangelogModal();
            }
        }
    });
</script>
