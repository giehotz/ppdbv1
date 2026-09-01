<div id="faq" class="tab-content hidden p-6">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h4 class="text-base font-bold text-gray-900 dark:text-white">Frequently Asked Questions (FAQ)</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola daftar pertanyaan yang sering diajukan dan jawabannya untuk ditampilkan di Landing Page.</p>
        </div>
        <button type="button" onclick="resetFaqForm()" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-5 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97]">
            <i class="fas fa-plus text-xs"></i>
            Tambah FAQ
        </button>
    </div>

    <!-- Form Container -->
    <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 mb-8 dark:border-gray-700 dark:bg-gray-800/50">
        <h5 id="faq-form-title" class="font-bold text-sm text-gray-800 dark:text-gray-200 mb-5 pb-3 border-b border-gray-200 dark:border-gray-700">Tambah FAQ Baru</h5>
        <form action="<?= base_url('admin/landing-content/saveFaq') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>
            <input type="hidden" name="faq_id" id="faq_id" value="">

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan <span class="text-red-500">*</span></label>
                    <input type="text" name="pertanyaan" id="faq_pertanyaan" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required placeholder="Contoh: Kapan pendaftaran ditutup?">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Jawaban <span class="text-red-500">*</span></label>
                    <textarea name="jawaban" id="faq_jawaban" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" required placeholder="Tuliskan jawaban dari pertanyaan di atas secara detail."></textarea>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Gunakan baris baru (ENTER) untuk paragraf baru. Teks biasa.</p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="resetFaqForm()" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-5 rounded-xl border border-gray-200 shadow-theme-xs transition-all duration-200 text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 cursor-pointer">Batal / Reset</button>
                <button type="submit" class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-theme-xs transition-all duration-200 text-sm active:scale-[0.97] cursor-pointer">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Data List -->
    <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider w-16">No</th>
                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Pertanyaan / Jawaban</th>
                    <th scope="col" class="px-5 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                <?php if (empty($faqs)): ?>
                <tr>
                    <td colspan="3" class="px-5 py-8 text-center">
                        <div class="text-gray-400 dark:text-gray-500">
                            <i class="fas fa-folder-open text-2xl mb-2"></i>
                            <p class="text-sm">Belum ada data FAQ yang ditambahkan.</p>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($faqs as $row): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <?= $no++ ?>
                        </td>
                        <td class="px-5 py-4 text-sm border-l border-gray-100 dark:border-gray-800">
                            <h6 class="font-bold text-brand-500 dark:text-brand-400 mb-1"><?= esc((string)$row['pertanyaan']) ?></h6>
                            <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2"><?= nl2br(esc((string)$row['jawaban'])) ?></p>
                            <span class="text-xs text-gray-400 dark:text-gray-500 mt-2 block"><i class="far fa-clock mr-1"></i> Ditambahkan: <?= date('d M Y H:i', strtotime((string)$row['created_at'])) ?></span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" 
                                    onclick='editFaq(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/15 transition-colors mr-1"
                                    title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <form method="post" action="<?= base_url('admin/landing-content/deleteFaq/' . $row['id']) ?>"
                                data-confirm="Apakah Anda yakin ingin menghapus data FAQ ini?"
                                data-confirm-icon="question"
                                style="display:inline">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-500/15 transition-colors delete-btn"
                                    title="Hapus">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
