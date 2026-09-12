<!-- WhatsApp Modal -->
<div id="whatsappModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeWhatsAppModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="whatsappModalContent">
            <div class="border-b border-emerald-100 bg-emerald-50/70 px-6 py-4 dark:border-emerald-950 dark:bg-emerald-950/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Kirim Pesan WhatsApp</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="waStudentHeader">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeWhatsAppModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- Target Penerima -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Tujuan Nomor WhatsApp</label>
                    <div class="grid grid-cols-2 gap-2" id="waRecipientOptions">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Template Pesan Cepat -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Pilih Template Pesan</label>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="applyWaTemplate('berkas')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            📑 Kelengkapan Berkas
                        </button>
                        <button type="button" onclick="applyWaTemplate('verif')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            ✅ Verifikasi Diterima
                        </button>
                        <button type="button" onclick="applyWaTemplate('ditolak')" class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                            ⚠️ Perbaikan Berkas
                        </button>
                    </div>
                </div>

                <!-- Textarea Pesan -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi Pesan (Bisa Diedit)</label>
                    <textarea id="waMessageText" rows="6" class="w-full rounded-xl border border-gray-200 bg-gray-50/50 p-3 text-xs text-gray-900 focus:border-emerald-500 focus:outline-none dark:border-gray-800 dark:bg-gray-900/60 dark:text-white" placeholder="Ketik pesan..."></textarea>
                </div>
            </div>

            <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                <button type="button" onclick="closeWhatsAppModal()"
                    class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="sendWhatsAppNow()"
                    class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i> Buka WhatsApp Web / App
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Detail Preview Modal -->
<div id="quickDetailModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeQuickDetail()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-3xl max-h-[90vh] rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 flex flex-col overflow-hidden" id="quickDetailContent">
            <!-- Header -->
            <div class="border-b border-gray-100 px-6 py-4 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <img id="qdPhoto" src="" alt="Foto" class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm dark:border-gray-700">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white" id="qdNama">-</h3>
                            <span id="qdStatusVerifBadge"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" id="qdSubheader">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeQuickDetail()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-sm">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 text-xs flex-grow" id="qdBody">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left: Biodata & Kelengkapan -->
                    <div class="space-y-4">
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-800/20 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-brand-500"></i> Biodata Calon Siswa
                            </h4>
                            <dl class="space-y-2 text-xs">
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">NISN / NIK</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100 font-mono" id="qdNisnNik">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Jenis Kelamin</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdJk">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Tempat, Tgl Lahir</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdTTL">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Sekolah Asal</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdSekolah">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100 text-right max-w-[200px]" id="qdAlamat">-</dd>
                                </div>
                                <div class="flex justify-between py-1 border-b border-gray-100 dark:border-gray-800">
                                    <dt class="text-gray-500">Orang Tua (Ayah/Ibu)</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdOrtu">-</dd>
                                </div>
                                <div class="flex justify-between py-1">
                                    <dt class="text-gray-500">No. HP Siswa / Ortu</dt>
                                    <dd class="font-medium text-gray-900 dark:text-gray-100" id="qdHp">-</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Progress Kelengkapan -->
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Kelengkapan Biodata</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-white" id="qdKelengkapanPercent">0%</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800 mb-2">
                                <div id="qdKelengkapanBar" class="h-2 rounded-full bg-brand-500 transition-all" style="width: 0%"></div>
                            </div>
                            <div id="qdMissingFields" class="text-[11px] text-rose-500 hidden">
                                Belum diisi: <span id="qdMissingList" class="font-medium"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Verifikasi & Berkas -->
                    <div class="space-y-4">
                        <!-- Quick Verifikasi Form -->
                        <div class="rounded-xl border border-brand-200/60 bg-brand-50/20 dark:border-brand-900/40 dark:bg-brand-950/20 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-1.5">
                                <i class="fas fa-check-shield text-brand-500"></i> Verifikasi Cepat
                            </h4>
                            <form id="qdVerifyForm" onsubmit="submitQuickVerify(event)">
                                <input type="hidden" id="qdStudentId" name="id">
                                <div class="space-y-2.5">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Ubah Status</label>
                                        <select id="qdStatusSelect" name="status" class="w-full h-8 rounded-lg border border-gray-200 bg-white px-2.5 text-xs font-semibold text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                                            <option value="Terverifikasi">Terverifikasi</option>
                                            <option value="Menunggu">Menunggu</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Catatan Verifikasi</label>
                                        <input type="text" id="qdCatatanInput" name="catatan" placeholder="Opsional (misal: Berkas valid)" class="w-full h-8 rounded-lg border border-gray-200 bg-white px-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                                    </div>
                                    <button type="submit" id="qdVerifySubmitBtn" class="w-full h-8 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold shadow-theme-xs transition-colors flex items-center justify-center gap-1.5">
                                        <i class="fas fa-save text-[11px]"></i> Simpan Verifikasi
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Berkas Uploaded -->
                        <div class="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 mb-2 flex items-center gap-1.5">
                                <i class="fas fa-paperclip text-purple-500"></i> Dokumen Berkas
                            </h4>
                            <div id="qdBerkasList" class="space-y-1.5 max-h-32 overflow-y-auto">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-100 px-6 py-3.5 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40 flex flex-wrap justify-between items-center gap-2 shrink-0">
                <div class="flex items-center gap-2">
                    <a id="qdCetakFormulir" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-print text-[11px] text-emerald-500"></i> Formulir
                    </a>
                    <a id="qdCetakKartu" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-id-card text-[11px] text-purple-500"></i> Kartu
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeQuickDetail()" class="px-3.5 py-1.5 rounded-lg border border-gray-200 bg-white text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50">
                        Tutup
                    </button>
                    <a id="qdFullDetailLink" href="#" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold shadow-theme-xs transition-colors">
                        <span>Halaman Lengkap</span> &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Verify Modal -->
<div id="bulkVerifyModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBulkVerifyModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="bulkVerifyModalContent">
            <div class="border-b border-emerald-100 bg-emerald-50/60 px-6 py-4 dark:border-emerald-950 dark:bg-emerald-950/30">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400">
                        <i class="fas fa-check-double text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Verifikasi Massal</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Ubah status verifikasi untuk siswa pindahan terpilih</p>
                    </div>
                </div>
            </div>

            <form id="bulkVerifyForm" onsubmit="submitBulkVerify(event)">
                <?= csrf_field() ?>
                <div class="p-6 space-y-4">
                    <p class="text-xs text-gray-600 dark:text-gray-300">
                        Anda memilih <strong id="bulkVerifyCount" class="text-emerald-600 font-bold">0</strong> siswa pindahan. Pilih status verifikasi baru:
                    </p>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Status Baru</label>
                        <select name="status" id="bulkVerifyStatus" class="w-full h-10 rounded-xl border border-gray-200 bg-white px-3 text-xs font-semibold text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none">
                            <option value="Terverifikasi">✅ Terverifikasi</option>
                            <option value="Menunggu">⏳ Menunggu</option>
                            <option value="Ditolak">❌ Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Catatan Verifikasi</label>
                        <input type="text" name="catatan" id="bulkVerifyCatatan" value="Verifikasi massal oleh Admin" class="w-full h-10 rounded-xl border border-gray-200 bg-transparent px-3 text-xs text-gray-800 dark:border-gray-700 dark:text-white focus:outline-none" placeholder="Masukkan catatan">
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeBulkVerifyModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="bulkVerifySubmitBtn"
                        class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulkDeleteModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeBulkDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="bulkDeleteModalContent">
            <div class="border-b border-red-100 bg-red-50/60 px-6 py-5 dark:border-red-950 dark:bg-red-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-red-900 dark:text-red-300">Konfirmasi Hapus Massal</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini permanen dan tidak dapat dibatalkan!</p>
                    </div>
                </div>
            </div>

            <form id="bulkDeleteForm" onsubmit="submitBulkDelete(event)">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Anda akan menghapus secara permanen data milik:</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
                        <span id="bulkDeleteCountText" class="text-red-600">0</span> siswa pindahan yang dipilih
                    </p>

                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-3 mb-4 dark:border-amber-900/50 dark:bg-amber-950/40">
                        <p class="text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Ketik kata <strong class="text-red-600 uppercase">hapus</strong> untuk mengonfirmasi:</span>
                        </p>
                    </div>

                    <input type="text" id="bulkDeleteConfirmInput"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-center text-sm font-semibold focus:border-red-500 focus:outline-none dark:border-gray-800 dark:text-white"
                        placeholder="Ketik 'hapus' di sini"
                        autocomplete="off">
                    <p class="text-[11px] text-gray-500 mt-2 text-center" id="bulkDeleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeBulkDeleteModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="bulkDeleteConfirmBtn" disabled
                        class="rounded-xl bg-red-400 px-4 py-2 text-xs font-semibold text-white transition-all cursor-not-allowed opacity-60 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="deleteModalContent">
            <div class="border-b border-red-100 bg-red-50/60 px-6 py-5 dark:border-red-950 dark:bg-red-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-red-900 dark:text-red-300">Konfirmasi Hapus Data</h3>
                        <p class="text-xs text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan!</p>
                    </div>
                </div>
            </div>

            <form method="post" id="deleteForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Anda akan menghapus seluruh data pendaftaran milik:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="deleteStudentName"></p>

                    <div class="rounded-xl border border-amber-200 bg-amber-50/70 p-3 mb-4 dark:border-amber-900/50 dark:bg-amber-950/40">
                        <p class="text-xs text-amber-800 dark:text-amber-300 flex items-start gap-2">
                            <i class="fas fa-info-circle mt-0.5"></i>
                            <span>Ketik kata <strong class="text-red-600 uppercase">hapus</strong> untuk mengonfirmasi:</span>
                        </p>
                    </div>

                    <input type="text" id="deleteConfirmInput" name="delete_confirm"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-center text-sm font-semibold focus:border-red-500 focus:outline-none dark:border-gray-800 dark:text-white"
                        placeholder="Ketik 'hapus' di sini"
                        autocomplete="off">
                    <p class="text-[11px] text-gray-500 mt-2 text-center" id="deleteHint">Masukkan kata "hapus" untuk mengaktifkan tombol</p>
                </div>

                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeDeleteModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="deleteConfirmBtn" disabled
                        class="rounded-xl bg-red-400 px-4 py-2 text-xs font-semibold text-white transition-all cursor-not-allowed opacity-60 flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 z-99999 hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeResetPasswordModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900 transform transition-all scale-95 opacity-0 overflow-hidden" id="resetPasswordModalContent">
            <div class="border-b border-amber-100 bg-amber-50/60 px-6 py-5 dark:border-amber-950 dark:bg-amber-950/30">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400">
                        <i class="fas fa-key text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-amber-900 dark:text-amber-300">Reset Password Siswa Pindahan</h3>
                        <p class="text-xs text-amber-600 dark:text-amber-400">Buat password baru untuk akun siswa pindahan</p>
                    </div>
                </div>
            </div>
            <form method="post" id="resetPasswordForm">
                <?= csrf_field() ?>
                <div class="p-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Reset password untuk siswa pindahan:</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mb-4 pb-3 border-b border-gray-100 dark:border-gray-800" id="resetStudentName"></p>

                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" id="newPasswordInput" name="new_password" required
                            class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm font-semibold focus:border-amber-500 focus:outline-none dark:border-gray-800 dark:text-white"
                            placeholder="Ketik password atau klik acak">
                        <button type="button" onclick="generateRandomPassword()"
                            class="shrink-0 rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                            <i class="fas fa-random mr-1"></i> Acak
                        </button>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex gap-2.5 justify-end bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/40">
                    <button type="button" onclick="closeResetPasswordModal()"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="rounded-xl bg-brand-500 px-4 py-2 text-xs font-semibold text-white hover:bg-brand-600 transition-all flex items-center gap-2 shadow-theme-xs">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>