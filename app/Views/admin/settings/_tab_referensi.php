<!-- Card 5: Data Referensi -->
<div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-2">
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Data Referensi (Penghasilan Orang Tua)</h3>
    </div>
    <div class="p-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Rentang Penghasilan</label>
        <textarea name="penghasilan_list" rows="10" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-2 px-3 border" placeholder="Masukkan satu pilihan per baris..."><?= esc($penghasilan_list ?? '') ?></textarea>
        <p class="mt-2 text-xs text-blue-600 bg-blue-50 p-2 rounded border border-blue-100">
            <i class="fas fa-info-circle mr-1"></i> Masukkan satu rentang penghasilan per baris. Urutan di sini akan menentukan urutan pilihan pada form pendaftaran/biodata siswa.
        </p>
    </div>
</div>
