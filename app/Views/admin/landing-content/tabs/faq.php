<div id="faq" class="tab-content hidden p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h4 class="text-lg font-bold text-gray-800">Frequently Asked Questions (FAQ)</h4>
            <p class="text-sm text-gray-500">Kelola daftar pertanyaan yang sering diajukan dan jawabannya untuk ditampilkan di Landing Page.</p>
        </div>
        <button type="button" onclick="resetFaqForm()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 shadow flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Tambah FAQ
        </button>
    </div>

    <!-- Form Container -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-8">
        <h5 id="faq-form-title" class="font-bold text-gray-700 mb-4 pb-2 border-b">Tambah FAQ Baru</h5>
        <form action="<?= base_url('admin/landing-content/saveFaq') ?>" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="faq_id" id="faq_id" value="">

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                    <input type="text" name="pertanyaan" id="faq_pertanyaan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="Contoh: Kapan pendaftaran ditutup?">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban <span class="text-red-500">*</span></label>
                    <textarea name="jawaban" id="faq_jawaban" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="Tuliskan jawaban dari pertanyaan di atas secara detail."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Gunakan baris baru (ENTER) untuk paragraf baru. Teks biasa.</p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="resetFaqForm()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200 shadow cursor-pointer">Batal / Reset</button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200 shadow cursor-pointer">Simpan Data</button>
            </div>
        </form>
    </div>

    <!-- Data List -->
    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pertanyaan / Jawaban</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($faqs)): ?>
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 m-4">
                        <i class="fas fa-folder-open text-3xl mb-3 text-gray-400"></i>
                        <p>Belum ada data FAQ yang ditambahkan.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($faqs as $row): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= $no++ ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-l border-gray-100">
                            <h6 class="font-bold text-green-700 mb-1"><?= esc((string)$row['pertanyaan']) ?></h6>
                            <p class="text-sm text-gray-600 line-clamp-2"><?= nl2br(esc((string)$row['jawaban'])) ?></p>
                            <span class="text-xs text-gray-400 mt-2 block"><i class="far fa-clock"></i> Ditambahkan: <?= date('d M Y H:i', strtotime((string)$row['created_at'])) ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" 
                                    onclick='editFaq(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' 
                                    class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded transition duration-200 mr-1"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="<?= base_url('admin/landing-content/deleteFaq/' . $row['id']) ?>" 
                               class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-2 py-1 rounded transition duration-200 delete-btn"
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data FAQ ini?')"
                               title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
