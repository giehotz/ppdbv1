<?php
/**
 * Tab Pengaturan Alur & Tahapan PPDB (PPDB Stepper)
 * Menampilkan saklar global, visual preview, serta builder interaktif (tambah, hapus, urutkan, aktif/nonaktif).
 */
?>
<div class="space-y-6">

    <!-- 1. Saklar Global Tampilkan Stepper di Portal Siswa -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                    <span class="material-symbols-outlined text-xl">alt_route</span>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white">Alur &amp; Tahapan Pendaftaran (PPDB Stepper)</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                        Aktifkan widget stepper interaktif di Dashboard Calon Siswa (desktop &amp; mobile) untuk memandu proses registrasi dari awal pendaftaran hingga daftar ulang.
                    </p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">Status Stepper:</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="stepper_aktif" value="0">
                    <input type="checkbox" name="stepper_aktif" value="1" <?= ($stepperAktif ?? 1) == 1 ? 'checked' : '' ?> class="sr-only peer" id="toggleStepperGlobal" onchange="updateGlobalStepperState(this.checked)">
                    <div class="w-14 h-7 bg-gray-300 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-brand-500"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- 2. Live Visual Preview (Pratinjau Alur Real-Time) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-brand-500 text-lg">visibility</span>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pratinjau Visual Stepper (Tampilan Siswa)</h4>
            </div>
            <span id="previewStatusBadge" class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full <?= ($stepperAktif ?? 1) == 1 ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' ?>">
                <?= ($stepperAktif ?? 1) == 1 ? 'Widget Aktif di Siswa' : 'Widget Disembunyikan' ?>
            </span>
        </div>

        <!-- Horizontal Stepper Preview Track -->
        <div class="relative overflow-x-auto no-scrollbar pb-3 pt-2 bg-gray-50/50 dark:bg-gray-900/40 rounded-xl p-4 border border-gray-100 dark:border-gray-800">
            <div class="flex items-start justify-between min-w-[700px] gap-2" id="stepperLiveTrack">
                <!-- Di-render oleh JavaScript renderLivePreview() -->
            </div>
        </div>
        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2 italic flex items-center gap-1">
            <span class="material-symbols-outlined text-xs">info</span>
            Warna &amp; ikon pada pratinjau ini menunjukkan simulasi alur aktif yang akan dilihat oleh calon siswa.
        </p>
    </div>

    <!-- 3. Dynamic Stepper Builder Table -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-500">checklist</span>
                    Kelola Langkah &amp; Urutan Tahapan
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Gunakan tombol naik/turun untuk mengatur urutan, saklar untuk mengaktifkan/menonaktifkan, atau klik tambah untuk membuat tahapan kustom.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="confirmResetStepper()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 transition shadow-xs">
                    <span class="material-symbols-outlined text-sm">restart_alt</span>
                    <span>Reset ke Default</span>
                </button>
                <button type="button" onclick="openModalTambahStep()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-500 hover:bg-brand-600 transition shadow-theme-xs hover:shadow-theme-md">
                    <span class="material-symbols-outlined text-sm">add_circle</span>
                    <span>Tambah Tahapan</span>
                </button>
            </div>
        </div>

        <!-- Hidden input yang menyimpan data JSON untuk form POST -->
        <input type="hidden" name="stepper_config" id="stepperConfigJson" value="<?= esc(json_encode($stepperConfig ?? [])) ?>">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50/80 font-bold text-gray-700 dark:border-gray-800 dark:bg-gray-900/60 dark:text-gray-300">
                        <th class="py-3.5 px-4 text-center w-16">Urutan</th>
                        <th class="py-3.5 px-4">Ikon &amp; Judul Tahapan</th>
                        <th class="py-3.5 px-4">Keterangan / Subtitle</th>
                        <th class="py-3.5 px-4">Tipe Alur</th>
                        <th class="py-3.5 px-4">Link Rute (URL)</th>
                        <th class="py-3.5 px-4 text-center w-28">Status Aktif</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody id="stepperTableBody" class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    <!-- Di-render oleh JavaScript renderStepperTable() -->
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-900/40 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-brand-500">verified</span>
                <span>Total: <b id="totalStepCount" class="text-gray-900 dark:text-white">0</b> Tahapan (<b id="activeStepCount" class="text-emerald-600 dark:text-emerald-400">0</b> Aktif)</span>
            </div>
            <p class="text-[11px]">Jangan lupa klik tombol <b>"Simpan Perubahan"</b> di bagian bawah halaman untuk menerapkan setelan ke sistem.</p>
        </div>
    </div>
</div>

<!-- Modals dipindahkan ke luar form utama (index.php) agar tidak memicu invalid form control HTML5 validation saat submit -->

<!-- ================= JAVASCRIPT LOGIC ================= -->
<script>
    // State lokal untuk list tahapan
    let stepperList = <?= json_encode($stepperConfig ?? []) ?>;

    // Pastikan array valid
    if (!Array.isArray(stepperList)) {
        stepperList = [];
    }

    // Inisialisasi tampilan tabel dan live preview
    document.addEventListener('DOMContentLoaded', function() {
        refreshStepperUI();
    });

    function refreshStepperUI() {
        renderStepperTable();
        renderLivePreview();
        syncStepperJson();
    }

    // Sinkronkan data ke input hidden JSON
    function syncStepperJson() {
        const input = document.getElementById('stepperConfigJson');
        if (input) {
            input.value = JSON.stringify(stepperList);
        }
    }

    // Render Tabel Builder
    function renderStepperTable() {
        const tbody = document.getElementById('stepperTableBody');
        if (!tbody) return;

        tbody.innerHTML = '';

        let activeCount = 0;

        stepperList.forEach((step, idx) => {
            if (step.is_active == 1) activeCount++;

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition-colors ' + (step.is_active == 0 ? 'opacity-50 bg-gray-50/30 dark:bg-gray-900/20' : '');

            const isFirst = idx === 0;
            const isLast  = idx === stepperList.length - 1;
            const isSystem = step.is_system == 1;

            tr.innerHTML = `
                <td class="py-3 px-4 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 font-mono font-bold text-xs text-gray-700 dark:text-gray-300">
                            ${idx + 1}
                        </span>
                        <div class="flex flex-col gap-0.5 ml-1">
                            <button type="button" onclick="moveStep(${idx}, -1)" ${isFirst ? 'disabled' : ''} class="text-gray-400 hover:text-brand-500 disabled:opacity-25 disabled:pointer-events-none p-0.5" title="Pindah ke Atas">
                                <span class="material-symbols-outlined text-sm leading-none">arrow_drop_up</span>
                            </button>
                            <button type="button" onclick="moveStep(${idx}, 1)" ${isLast ? 'disabled' : ''} class="text-gray-400 hover:text-brand-500 disabled:opacity-25 disabled:pointer-events-none p-0.5" title="Pindah ke Bawah">
                                <span class="material-symbols-outlined text-sm leading-none">arrow_drop_down</span>
                            </button>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                            <span class="material-symbols-outlined text-base">${escapeHtml(step.icon || 'circle')}</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white block text-xs">${escapeHtml(step.title || 'Tanpa Judul')}</span>
                            <span class="text-[10px] text-gray-400 font-mono">id: ${escapeHtml(step.id || '')}</span>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">
                    <span class="line-clamp-1">${escapeHtml(step.description || '-')}</span>
                </td>
                <td class="py-3 px-4">
                    ${isSystem ? 
                        `<span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-400">
                            <span class="material-symbols-outlined text-xs">auto_mode</span> Sistem
                         </span>` : 
                        `<span class="inline-flex items-center gap-1 rounded-full bg-purple-50 px-2 py-0.5 text-[10px] font-semibold text-purple-700 dark:bg-purple-500/15 dark:text-purple-400">
                            <span class="material-symbols-outlined text-xs">edit_note</span> Kustom
                         </span>`
                    }
                </td>
                <td class="py-3 px-4 font-mono text-[11px] text-gray-500 dark:text-gray-400">
                    ${step.url ? `<span class="truncate max-w-[140px] inline-block">${escapeHtml(step.url)}</span>` : '<span class="italic text-gray-400">Tidak ada link</span>'}
                </td>
                <td class="py-3 px-4 text-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" onchange="toggleStepActive(${idx}, this.checked)" ${step.is_active == 1 ? 'checked' : ''} class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-300 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                </td>
                <td class="py-3 px-4 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button type="button" onclick="openModalEditStep(${idx})" class="p-1 text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 transition" title="Edit Detail">
                            <span class="material-symbols-outlined text-base">edit</span>
                        </button>
                        ${!isSystem ? `
                            <button type="button" onclick="deleteStep(${idx})" class="p-1 text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition" title="Hapus Tahapan">
                                <span class="material-symbols-outlined text-base">delete</span>
                            </button>
                        ` : `
                            <button type="button" onclick="confirmHideSystemStep(${idx})" class="p-1 text-gray-300 hover:text-amber-500 dark:text-gray-600 transition" title="Langkah Bawaan Sistem (Nonaktifkan via Saklar)">
                                <span class="material-symbols-outlined text-base">lock</span>
                            </button>
                        `}
                    </div>
                </td>
            `;

            tbody.appendChild(tr);
        });

        // Update counts
        const totalElem = document.getElementById('totalStepCount');
        const activeElem = document.getElementById('activeStepCount');
        if (totalElem) totalElem.textContent = stepperList.length;
        if (activeElem) activeElem.textContent = activeCount;
    }

    // Render Live Preview
    function renderLivePreview() {
        const track = document.getElementById('stepperLiveTrack');
        if (!track) return;

        track.innerHTML = '';

        const activeSteps = stepperList.filter(s => s.is_active == 1);

        if (activeSteps.length === 0) {
            track.innerHTML = `
                <div class="w-full text-center py-6 text-gray-400 dark:text-gray-500 text-xs">
                    <span class="material-symbols-outlined text-3xl block mb-1">playlist_remove</span>
                    <span>Seluruh tahapan dinonaktifkan. Stepper tidak akan tampil di portal siswa.</span>
                </div>
            `;
            return;
        }

        activeSteps.forEach((step, idx) => {
            const isComp = idx === 0 || step.custom_status === 'completed';
            const isCurr = idx === 1 || step.custom_status === 'current';
            const isLast = idx === activeSteps.length - 1;

            let circleClass = 'bg-gray-100 text-gray-400 border-gray-200 dark:bg-gray-800 dark:text-gray-500 dark:border-gray-700';
            let iconText = step.icon || 'circle';

            if (isComp) {
                circleClass = 'bg-emerald-500 text-white border-emerald-500 shadow-sm';
                iconText = 'check';
            } else if (isCurr) {
                circleClass = 'bg-brand-500 text-white border-brand-500 ring-4 ring-brand-100 dark:ring-brand-900/40 shadow-sm animate-pulse';
            }

            const stepCol = document.createElement('div');
            stepCol.className = 'flex-1 flex flex-col items-center text-center relative group min-w-[75px]';

            stepCol.innerHTML = `
                <!-- Line connecting to next -->
                ${!isLast ? `<div class="absolute top-3.5 left-1/2 w-full h-0.5 ${isComp ? 'bg-emerald-400' : 'bg-gray-200 dark:bg-gray-700'} -z-0"></div>` : ''}

                <!-- Circle Icon -->
                <div class="relative z-10 flex h-7 w-7 items-center justify-center rounded-full border-2 text-[11px] font-bold ${circleClass}">
                    <span class="material-symbols-outlined text-[14px]">${iconText}</span>
                </div>

                <!-- Title & Subtitle -->
                <div class="mt-1.5 space-y-0.5 w-full px-1">
                    <span class="block text-[10px] font-bold text-gray-900 dark:text-white leading-tight truncate" title="${escapeHtml(step.title)}">
                        ${escapeHtml(step.title)}
                    </span>
                    <span class="block text-[9px] text-gray-400 truncate">
                        ${escapeHtml(step.description || '-')}
                    </span>
                </div>
            `;

            track.appendChild(stepCol);
        });
    }

    // Toggle status saklar global
    function updateGlobalStepperState(checked) {
        const badge = document.getElementById('previewStatusBadge');
        if (badge) {
            badge.className = 'text-[11px] font-semibold px-2.5 py-0.5 rounded-full ' + (checked ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400');
            badge.textContent = checked ? 'Widget Aktif di Siswa' : 'Widget Disembunyikan';
        }
    }

    // Geser urutan tahapan
    function moveStep(index, direction) {
        const newIndex = index + direction;
        if (newIndex < 0 || newIndex >= stepperList.length) return;

        const temp = stepperList[index];
        stepperList[index] = stepperList[newIndex];
        stepperList[newIndex] = temp;

        refreshStepperUI();
    }

    // Toggle status aktif per baris
    function toggleStepActive(index, checked) {
        if (!stepperList[index]) return;
        stepperList[index].is_active = checked ? 1 : 0;
        refreshStepperUI();
    }

    // Hapus tahapan kustom
    function deleteStep(index) {
        const step = stepperList[index];
        if (!step) return;

        Swal.fire({
            title: 'Hapus Tahapan?',
            text: `Apakah Anda yakin ingin menghapus tahapan "${step.title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                stepperList.splice(index, 1);
                refreshStepperUI();
            }
        });
    }

    // Notifikasi untuk sistem step
    function confirmHideSystemStep(index) {
        const step = stepperList[index];
        Swal.fire({
            title: 'Tahapan Bawaan Sistem',
            text: `Tahapan "${step.title}" terintegrasi dengan logika otomatis sistem (seperti validasi biodata, verifikasi berkas, atau kelulusan). Jika tidak ingin menampilkannya di alur siswa, cukup nonaktifkan saklar aktif di kolom sebelahnya.`,
            icon: 'info',
            confirmButtonText: 'Mengerti'
        });
    }

    // Buka & Tutup Modal Tambah
    function openModalTambahStep() {
        const titleInput = document.getElementById('newStepTitle');
        if (titleInput) titleInput.value = '';
        const descInput = document.getElementById('newStepDesc');
        if (descInput) descInput.value = '';
        const iconInput = document.getElementById('newStepIcon');
        if (iconInput) iconInput.value = 'groups';
        const iconPreview = document.getElementById('newStepIconPreview');
        if (iconPreview) iconPreview.textContent = 'groups';
        const urlInput = document.getElementById('newStepUrl');
        if (urlInput) urlInput.value = '';
        const statusSelect = document.getElementById('newStepCustomStatus');
        if (statusSelect) statusSelect.value = 'pending';

        const modal = document.getElementById('modalTambahStep');
        if (modal) modal.classList.remove('hidden');
    }

    function closeModalTambahStep() {
        const modal = document.getElementById('modalTambahStep');
        if (modal) modal.classList.add('hidden');
    }

    // Simpan Tahapan Baru
    function handleSaveNewStep() {
        const titleInput = document.getElementById('newStepTitle');
        const title = titleInput ? titleInput.value.trim() : '';

        if (!title) {
            Swal.fire({
                icon: 'warning',
                title: 'Judul Wajib Diisi',
                text: 'Silakan masukkan judul tahapan baru terlebih dahulu.',
                timer: 2000,
                showConfirmButton: false
            });
            if (titleInput) titleInput.focus();
            return;
        }

        const desc  = (document.getElementById('newStepDesc')?.value || '').trim();
        const icon  = (document.getElementById('newStepIcon')?.value || '').trim() || 'circle';
        const url   = (document.getElementById('newStepUrl')?.value || '').trim();
        const status = document.getElementById('newStepCustomStatus')?.value || 'pending';

        const newId = 'custom_' + Date.now();

        stepperList.push({
            id: newId,
            title: title,
            description: desc,
            icon: icon,
            url: url,
            is_active: 1,
            is_system: 0,
            system_handler: null,
            custom_status: status
        });

        closeModalTambahStep();
        refreshStepperUI();

        Swal.fire({
            icon: 'success',
            title: 'Tahapan Ditambahkan',
            text: `Tahapan "${title}" berhasil ditambahkan ke daftar alur.`,
            timer: 2000,
            showConfirmButton: false
        });
    }

    // Buka & Tutup Modal Edit
    function openModalEditStep(index) {
        const step = stepperList[index];
        if (!step) return;

        document.getElementById('editStepIndex').value = index;
        document.getElementById('editStepTitle').value = step.title || '';
        document.getElementById('editStepDesc').value = step.description || '';
        document.getElementById('editStepIcon').value = step.icon || 'circle';
        document.getElementById('editStepIconPreview').textContent = step.icon || 'circle';
        document.getElementById('editStepUrl').value = step.url || '';

        const customStatusElem = document.getElementById('editStepCustomStatus');
        const customWrapper = document.getElementById('editCustomStatusWrapper');
        if (step.is_system == 1) {
            if (customWrapper) customWrapper.classList.add('hidden');
        } else {
            if (customWrapper) customWrapper.classList.remove('hidden');
            if (customStatusElem) customStatusElem.value = step.custom_status || 'pending';
        }

        document.getElementById('modalEditStep').classList.remove('hidden');
    }

    function closeModalEditStep() {
        document.getElementById('modalEditStep').classList.add('hidden');
    }

    // Simpan Edit Tahapan
    function handleSaveEditStep() {
        const indexInput = document.getElementById('editStepIndex');
        const index = parseInt(indexInput ? indexInput.value : '-1');
        if (isNaN(index) || !stepperList[index]) return;

        const titleInput = document.getElementById('editStepTitle');
        const title = titleInput ? titleInput.value.trim() : '';
        if (!title) {
            Swal.fire({
                icon: 'warning',
                title: 'Judul Wajib Diisi',
                text: 'Judul tahapan tidak boleh kosong.',
                timer: 2000,
                showConfirmButton: false
            });
            if (titleInput) titleInput.focus();
            return;
        }

        stepperList[index].title = title;
        stepperList[index].description = (document.getElementById('editStepDesc')?.value || '').trim();
        stepperList[index].icon = (document.getElementById('editStepIcon')?.value || '').trim() || 'circle';
        stepperList[index].url = (document.getElementById('editStepUrl')?.value || '').trim();

        if (stepperList[index].is_system == 0) {
            stepperList[index].custom_status = document.getElementById('editStepCustomStatus')?.value || 'pending';
        }

        closeModalEditStep();
        refreshStepperUI();

        Swal.fire({
            icon: 'success',
            title: 'Tahapan Diperbarui',
            text: `Perubahan tahapan "${stepperList[index].title}" berhasil disimpan secara lokal. Klik "Simpan Perubahan" di bawah untuk memproses permanen.`,
            timer: 2000,
            showConfirmButton: false
        });
    }

    // Quick Icon Selector
    function selectQuickIcon(iconName, inputId, previewId) {
        document.getElementById(inputId).value = iconName;
        document.getElementById(previewId).textContent = iconName;
    }

    // Konfirmasi Reset ke Default Sistem
    function confirmResetStepper() {
        Swal.fire({
            title: 'Reset ke Alur Standar?',
            text: 'Apakah Anda ingin mengembalikan susunan alur tahapan PPDB ke 8 langkah standar bawaan sistem? Tahapan kustom yang pernah Anda buat akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Reset Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formResetStepperAction').submit();
            }
        });
    }

    // Helper escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>
