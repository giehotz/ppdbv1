        <!-- Tab: Cetak Masal -->
        <div id="cetak-masal" class="tab-content hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">
                <i class="fas fa-print text-green-600 mr-2"></i> Cetak Kartu Pelajar Secara Masal
            </h3>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i> <strong>Penting:</strong> Mencetak ratusan kartu sekaligus dapat menyebabkan browser lag atau crash. Gunakan filter untuk membatasi jumlah kartu yang dirender per halaman (disarankan maksimal 50-100 kartu sekaligus).
                </p>
            </div>

            <form action="<?= base_url('admin/setting-kartu/cetak-masal') ?>" method="GET" target="_blank" class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Filter Status Kelulusan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kelulusan</label>
                        <select name="status_kelulusan" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 px-3 py-2 border">
                            <option value="">Semua (Hati-hati, berat)</option>
                            <option value="LULUS" selected>Hanya LULUS / Diterima</option>
                            <option value="PROSES SELEKSI">Proses Seleksi</option>
                        </select>
                        <span class="text-xs text-gray-400 mt-1 block">Biasanya hanya peserta Lulus yang dicetak kartunya.</span>
                    </div>

                    <!-- Limit Data -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Batas Data / Render Size</label>
                        <select name="limit" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 px-3 py-2 border">
                            <option value="20">20 Siswa Pertama (Ringan)</option>
                            <option value="50" selected>50 Siswa Pertama (Disarankan)</option>
                            <option value="100">100 Siswa Pertama</option>
                            <option value="200">200 Siswa Pertama</option>
                            <option value="0">Semua Data (Jika PC Kuat)</option>
                        </select>
                        <span class="text-xs text-gray-400 mt-1 block">Gunakan Offset (halaman) di bawah jika mencetak berkelompok.</span>
                    </div>

                    <!-- Offset Data / Halaman -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Offset (Mulai dari urutan ke-)</label>
                        <input type="number" name="offset" value="0" min="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 px-3 py-2 border">
                        <span class="text-xs text-gray-400 mt-1 block">Isi 0 untuk awal, isi 50 untuk lanjut ke siswa 51, dsb.</span>
                    </div>

                    <!-- Mode Cetak (Sisi Kartu) -->
                    <div class="md:col-span-2 lg:col-span-3 border-t pt-4 mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Tipe Cetak (Layout)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Depan Belakang (Duplex) -->
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="print_mode" value="duplex" class="sr-only" checked>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span id="project-type-0-label" class="block text-sm font-medium text-gray-900">Depan & Belakang (Duplex)</span>
                                        <span id="project-type-0-description-0" class="mt-1 flex items-center text-sm text-gray-500">
                                            Mirroring column logic diterapkan untuk cetak bolak-balik.
                                        </span>
                                    </span>
                                </span>
                                <i class="fas fa-check-circle text-green-600 ml-3 h-5 w-5 hidden selected-icon"></i>
                            </label>

                            <!-- Depan Saja -->
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="print_mode" value="front" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span id="project-type-1-label" class="block text-sm font-medium text-gray-900">Depan Saja</span>
                                        <span id="project-type-1-description-0" class="mt-1 flex items-center text-sm text-gray-500">
                                            Cocok jika akan dilaminating manual sisi per sisi.
                                        </span>
                                    </span>
                                </span>
                                <i class="fas fa-check-circle text-green-600 ml-3 h-5 w-5 hidden selected-icon"></i>
                            </label>

                            <!-- Belakang Saja -->
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="print_mode" value="back" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span id="project-type-2-label" class="block text-sm font-medium text-gray-900">Belakang Saja</span>
                                        <span id="project-type-2-description-0" class="mt-1 flex items-center text-sm text-gray-500">
                                            Untuk stempel dan validasi legalitas.
                                        </span>
                                    </span>
                                </span>
                                <i class="fas fa-check-circle text-green-600 ml-3 h-5 w-5 hidden selected-icon"></i>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg shadow-md transition flex items-center gap-2">
                        <i class="fas fa-print"></i> Render & Cetak Sekarang
                    </button>
                </div>
            </form>
        </div>

        <style>
            input[type="radio"]:checked + span + i {
                display: block;
            }
            input[type="radio"]:checked ~ span {
                color: #15803d; /* green-700 */
            }
        </style>
        <script>
            // Add a simple visual cue for selected radio cards
            document.querySelectorAll('input[name="print_mode"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('input[name="print_mode"]').forEach(r => {
                        r.closest('label').classList.remove('border-green-500', 'ring-2', 'ring-green-500');
                    });
                    if (this.checked) {
                        this.closest('label').classList.add('border-green-500', 'ring-2', 'ring-green-500');
                    }
                });
                
                // Initialize state
                if(radio.checked) {
                    radio.closest('label').classList.add('border-green-500', 'ring-2', 'ring-green-500');
                }
            });
        </script>
