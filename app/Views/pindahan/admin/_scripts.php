<script>
    // ==========================================
    // BULK ACTIONS LOGIC
    // ==========================================
    function toggleSelectAll(master) {
        const checkboxes = document.querySelectorAll('.pindahan-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBulkBar();
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.pindahan-checkbox:checked')).map(cb => cb.value);
    }

    function updateBulkBar() {
        const checked = document.querySelectorAll('.pindahan-checkbox:checked');
        const all = document.querySelectorAll('.pindahan-checkbox');
        const bar = document.getElementById('bulkActionBar');
        const countBadge = document.getElementById('selectedCountBadge');
        const master = document.getElementById('selectAllCheckbox');

        if (master && all.length > 0) {
            master.checked = (checked.length === all.length);
        }

        if (checked.length > 0) {
            countBadge.textContent = checked.length;
            bar.classList.remove('hidden');
            setTimeout(() => {
                bar.classList.remove('translate-y-10', 'opacity-0');
                bar.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        } else {
            bar.classList.remove('translate-y-0', 'opacity-100');
            bar.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                bar.classList.add('hidden');
            }, 300);
        }
    }

    function clearSelection() {
        document.querySelectorAll('.pindahan-checkbox').forEach(cb => cb.checked = false);
        const master = document.getElementById('selectAllCheckbox');
        if (master) master.checked = false;
        updateBulkBar();
    }

    function openBulkVerifyModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('bulkVerifyCount').textContent = ids.length;

        const modal = document.getElementById('bulkVerifyModal');
        const content = document.getElementById('bulkVerifyModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBulkVerifyModal() {
        const modal = document.getElementById('bulkVerifyModal');
        const content = document.getElementById('bulkVerifyModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    async function submitBulkVerify(e) {
        e.preventDefault();
        const ids = getSelectedIds();
        const status = document.getElementById('bulkVerifyStatus').value;
        const catatan = document.getElementById('bulkVerifyCatatan').value;
        const submitBtn = document.getElementById('bulkVerifySubmitBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const formData = new FormData(document.getElementById('bulkVerifyForm'));
        formData.append('ids', ids.join(','));
        formData.set('status', status);
        formData.set('catatan', catatan);

        try {
            const resp = await fetch('<?= base_url('admin/pindahan/bulk-verify') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await resp.json();
            if (data.status === 'success') {
                closeBulkVerifyModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Simpan Perubahan';
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Simpan Perubahan';
        }
    }

    function openBulkDeleteModal() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;
        document.getElementById('bulkDeleteCountText').textContent = ids.length;
        document.getElementById('bulkDeleteConfirmInput').value = '';
        resetBulkDeleteBtn();

        const modal = document.getElementById('bulkDeleteModal');
        const content = document.getElementById('bulkDeleteModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('bulkDeleteConfirmInput').focus();
        }, 200);
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('bulkDeleteModal');
        const content = document.getElementById('bulkDeleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function resetBulkDeleteBtn() {
        const btn = document.getElementById('bulkDeleteConfirmBtn');
        btn.disabled = true;
        btn.classList.add('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    function enableBulkDeleteBtn() {
        const btn = document.getElementById('bulkDeleteConfirmBtn');
        btn.disabled = false;
        btn.classList.remove('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    document.getElementById('bulkDeleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('bulkDeleteHint');
        if (value === 'hapus') {
            enableBulkDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-[11px] text-emerald-600 mt-2 text-center font-medium';
        } else {
            resetBulkDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-[11px] text-red-500 mt-2 text-center';
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-[11px] text-gray-500 mt-2 text-center';
            }
        }
    });

    async function submitBulkDelete(e) {
        e.preventDefault();
        const ids = getSelectedIds();
        const confirmText = document.getElementById('bulkDeleteConfirmInput').value;
        const submitBtn = document.getElementById('bulkDeleteConfirmBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

        const formData = new FormData(document.getElementById('bulkDeleteForm'));
        formData.append('ids', ids.join(','));
        formData.set('confirm', confirmText);

        try {
            const resp = await fetch('<?= base_url('admin/pindahan/bulk-delete') ?>', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await resp.json();
            if (data.status === 'success') {
                closeBulkDeleteModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Hapus Permanen';
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Hapus Permanen';
        }
    }

    // ==========================================
    // 1-CLICK WHATSAPP LOGIC
    // ==========================================
    let currentWaStudent = null;

    function openWhatsAppModal(id, name, noDaftar, hpSiswa, hpOrtu) {
        currentWaStudent = { id, name, noDaftar, hpSiswa, hpOrtu };
        document.getElementById('waStudentHeader').textContent = `${name} (${noDaftar})`;

        const container = document.getElementById('waRecipientOptions');
        container.innerHTML = '';

        const hasSiswa = hpSiswa && hpSiswa.trim().length >= 8;
        const hasOrtu = hpOrtu && hpOrtu.trim().length >= 8;

        // Siswa radio
        const optSiswa = document.createElement('label');
        optSiswa.className = `flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-colors ${hasSiswa ? 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' : 'border-dashed border-gray-200 text-gray-400 opacity-60 cursor-not-allowed'}`;
        optSiswa.innerHTML = `
            <input type="radio" name="wa_target_phone" value="${hasSiswa ? hpSiswa : ''}" ${hasSiswa ? 'checked' : 'disabled'} class="text-emerald-600 focus:ring-emerald-500">
            <div>
                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200">Siswa</span>
                <span class="block text-[11px] font-mono text-gray-500">${hasSiswa ? hpSiswa : '(Tidak ada nomor)'}</span>
            </div>
        `;
        container.appendChild(optSiswa);

        // Ortu radio
        const optOrtu = document.createElement('label');
        optOrtu.className = `flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-colors ${hasOrtu ? 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800' : 'border-dashed border-gray-200 text-gray-400 opacity-60 cursor-not-allowed'}`;
        optOrtu.innerHTML = `
            <input type="radio" name="wa_target_phone" value="${hasOrtu ? hpOrtu : ''}" ${(!hasSiswa && hasOrtu) ? 'checked' : ''} ${hasOrtu ? '' : 'disabled'} class="text-emerald-600 focus:ring-emerald-500">
            <div>
                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200">Orang Tua / Wali</span>
                <span class="block text-[11px] font-mono text-gray-500">${hasOrtu ? hpOrtu : '(Tidak ada nomor)'}</span>
            </div>
        `;
        container.appendChild(optOrtu);

        applyWaTemplate('berkas');

        const modal = document.getElementById('whatsappModal');
        const content = document.getElementById('whatsappModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeWhatsAppModal() {
        const modal = document.getElementById('whatsappModal');
        const content = document.getElementById('whatsappModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function applyWaTemplate(type) {
        if (!currentWaStudent) return;
        const name = currentWaStudent.name;
        const noDaftar = currentWaStudent.noDaftar;
        let msg = '';

        switch (type) {
            case 'berkas':
                msg = `Halo ${name}, kami dari Panitia PPDB menginformasikan bahwa data/berkas pendaftaran pindahan Anda (${noDaftar}) masih belum lengkap. Mohon segera login ke akun pendaftaran dan melengkapi berkas sebelum batas waktu berakhir. Terima kasih.`;
                break;
            case 'verif':
                msg = `Halo ${name}, selamat! Berkas dan biodata pendaftaran pindahan Anda dengan No. Pendaftaran ${noDaftar} telah selesai DIVERIFIKASI dan dinyatakan VALID oleh Panitia. Silakan unduh kartu pendaftaran Anda di dashboard siswa.`;
                break;
            case 'ditolak':
                msg = `Halo ${name}, kami menginformasikan bahwa berkas pendaftaran pindahan Anda (${noDaftar}) memerlukan perbaikan. Silakan login ke portal pendaftaran untuk memeriksa catatan dari verifikator dan unggah ulang berkas yang diminta.`;
                break;
        }

        document.getElementById('waMessageText').value = msg;
    }

    function cleanPhoneNumber(phone) {
        if (!phone) return '';
        let cleaned = phone.replace(/[^0-9]/g, '');
        if (cleaned.startsWith('0')) {
            cleaned = '62' + cleaned.substring(1);
        } else if (cleaned.startsWith('8')) {
            cleaned = '62' + cleaned;
        }
        return cleaned;
    }

    function sendWhatsAppNow() {
        const selectedRadio = document.querySelector('input[name="wa_target_phone"]:checked');
        if (!selectedRadio || !selectedRadio.value) {
            Swal.fire({ icon: 'warning', title: 'Nomor Tidak Valid', text: 'Nomor WhatsApp untuk target yang dipilih tidak tersedia.' });
            return;
        }

        const phone = cleanPhoneNumber(selectedRadio.value);
        const text = encodeURIComponent(document.getElementById('waMessageText').value);

        if (!phone || phone.length < 9) {
            Swal.fire({ icon: 'warning', title: 'Nomor Tidak Valid', text: 'Format nomor telepon tidak sesuai untuk WhatsApp.' });
            return;
        }

        window.open(`https://wa.me/${phone}?text=${text}`, '_blank');
        closeWhatsAppModal();
    }

    // ==========================================
    // QUICK DETAIL PREVIEW MODAL
    // ==========================================
    async function openQuickDetail(id) {
        const modal = document.getElementById('quickDetailModal');
        const content = document.getElementById('quickDetailContent');

        // Reset modal fields to loading state
        document.getElementById('qdNama').textContent = 'Memuat...';
        document.getElementById('qdSubheader').textContent = 'Mengambil data siswa...';
        document.getElementById('qdPhoto').src = 'https://ui-avatars.com/api/?name=Loading&background=random';
        document.getElementById('qdStudentId').value = id;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        try {
            const resp = await fetch('<?= base_url('admin/pindahan/quick-detail') ?>/' + id, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const res = await resp.json();
            if (res.status !== 'success') {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message || 'Gagal memuat data siswa.' });
                closeQuickDetail();
                return;
            }

            const s = res.data.student;
            const b = res.data.berkas;

            // Header
            document.getElementById('qdNama').textContent = s.nama_lengkap;
            document.getElementById('qdSubheader').textContent = `No: ${s.no_pendaftaran} • TP: ${s.th_pelajaran || '-'}`;
            const qdPhotoEl = document.getElementById('qdPhoto');
            let fotoUrl = s.foto_url;
            if (!fotoUrl && s.foto && s.nisn) {
                fotoUrl = '<?= base_url('uploads/berkas') ?>/' + s.nisn + '/' + s.foto;
            }
            qdPhotoEl.onerror = function() {
                this.onerror = null;
                this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(s.nama_lengkap)}&background=random`;
            };
            qdPhotoEl.src = fotoUrl ? fotoUrl : `https://ui-avatars.com/api/?name=${encodeURIComponent(s.nama_lengkap)}&background=random`;

            // Status Verif Badge
            const stVerif = s.status_verifikasi || 'Menunggu';
            let stBadge = '';
            if (stVerif === 'Terverifikasi') {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400"><i class="fas fa-check-circle text-[10px]"></i> Terverifikasi</span>';
            } else if (stVerif === 'Ditolak') {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-0.5 text-[11px] font-semibold text-red-700 dark:bg-red-500/15 dark:text-red-400"><i class="fas fa-times-circle text-[10px]"></i> Ditolak</span>';
            } else {
                stBadge = '<span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-400"><i class="fas fa-clock text-[10px]"></i> Menunggu</span>';
            }
            document.getElementById('qdStatusVerifBadge').innerHTML = stBadge;

            // Biodata details
            document.getElementById('qdNisnNik').textContent = `${s.nisn || '-'} / ${s.nik || '-'}`;
            document.getElementById('qdJk').textContent = s.jk === 'L' ? 'Laki-laki' : 'Perempuan';
            document.getElementById('qdTTL').textContent = `${s.tempat_lahir || '-'}, ${s.tgl_lahir || '-'}`;
            document.getElementById('qdSekolah').textContent = s.nama_sekolah_asal || '-';
            document.getElementById('qdAlamat').textContent = s.alamat_siswa || '-';
            document.getElementById('qdOrtu').textContent = `${s.nama_ayah || '-'} / ${s.nama_ibu || '-'}`;
            document.getElementById('qdHp').textContent = `${s.no_hp_siswa || '-'} / ${s.no_hp_ortu || '-'}`;

            // Progress Kelengkapan
            const percent = s.kelengkapan || 0;
            document.getElementById('qdKelengkapanPercent').textContent = percent + '%';
            document.getElementById('qdKelengkapanBar').style.width = percent + '%';
            document.getElementById('qdKelengkapanBar').className = `h-2 rounded-full transition-all ${percent === 100 ? 'bg-emerald-500' : (percent >= 50 ? 'bg-brand-500' : 'bg-red-500')}`;

            const missingContainer = document.getElementById('qdMissingFields');
            if (s.incomplete_fields && s.incomplete_fields.length > 0) {
                missingContainer.classList.remove('hidden');
                document.getElementById('qdMissingList').textContent = s.incomplete_fields.slice(0, 4).join(', ') + (s.incomplete_fields.length > 4 ? ` (+${s.incomplete_fields.length - 4} lainnya)` : '');
            } else {
                missingContainer.classList.add('hidden');
            }

            // Quick Verifikasi select
            document.getElementById('qdStatusSelect').value = ['Terverifikasi', 'Menunggu', 'Ditolak'].includes(stVerif) ? stVerif : 'Menunggu';
            document.getElementById('qdCatatanInput').value = s.verifikasi_isi || '';

            // Berkas list
            const berkasDiv = document.getElementById('qdBerkasList');
            berkasDiv.innerHTML = '';
            if (b && b.length > 0) {
                b.forEach(file => {
                    const isImg = file.path_file && file.path_file.match(/\.(jpg|jpeg|png|webp)$/i);
                    const fileUrl = '<?= base_url() ?>' + file.path_file;
                    const item = document.createElement('div');
                    item.className = 'flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-800/40 text-[11px] border border-gray-100 dark:border-gray-800';
                    item.innerHTML = `
                        <div class="flex items-center gap-2 truncate">
                            <i class="${isImg ? 'fas fa-image text-blue-500' : 'fas fa-file-pdf text-red-500'}"></i>
                            <span class="font-medium text-gray-800 dark:text-gray-200 capitalize truncate">${file.jenis_berkas.replace(/_/g, ' ')}</span>
                        </div>
                        <a href="${fileUrl}" target="_blank" class="text-brand-500 hover:underline font-semibold ml-2 shrink-0">
                            Lihat <i class="fas fa-external-link-alt text-[9px]"></i>
                        </a>
                    `;
                    berkasDiv.appendChild(item);
                });
            } else {
                berkasDiv.innerHTML = '<span class="text-gray-400 italic text-[11px]">Belum ada berkas yang diunggah.</span>';
            }

            // Footer Links
            document.getElementById('qdCetakFormulir').href = '<?= base_url('admin/pindahan/cetak') ?>/' + s.id_pindahan;
            document.getElementById('qdCetakKartu').href = '<?= base_url('admin/pindahan/cetak-kartu') ?>/' + s.id_pindahan;
            document.getElementById('qdFullDetailLink').href = '<?= base_url('admin/pindahan/detail') ?>/' + s.id_pindahan;

        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
            closeQuickDetail();
        }
    }

    function closeQuickDetail() {
        const modal = document.getElementById('quickDetailModal');
        const content = document.getElementById('quickDetailContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    async function submitQuickVerify(e) {
        e.preventDefault();
        const id = document.getElementById('qdStudentId').value;
        const status = document.getElementById('qdStatusSelect').value;
        const catatan = document.getElementById('qdCatatanInput').value;
        const btn = document.getElementById('qdVerifySubmitBtn');

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const formData = new FormData();
        formData.append('status', status);
        formData.append('catatan', catatan);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        try {
            const resp = await fetch('<?= base_url('admin/pindahan/verify') ?>/' + id, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            closeQuickDetail();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status verifikasi siswa telah diperbarui.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => location.reload());

        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save text-[11px]"></i> Simpan Verifikasi';
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
        }
    }

    // ==========================================
    // DELETE & RESET PASSWORD
    // ==========================================
    function openDeleteModal(name, url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteStudentName').textContent = name;
        document.getElementById('deleteConfirmInput').value = '';
        document.getElementById('deleteHint').textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
        document.getElementById('deleteHint').className = 'text-[11px] text-gray-500 mt-2 text-center';
        resetDeleteBtn();

        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        setTimeout(() => {
            document.getElementById('deleteConfirmInput').focus();
        }, 200);
    }

    function closeDeleteModal() {
        const content = document.getElementById('deleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('deleteModal').classList.add('hidden');
        }, 200);
    }

    function resetDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = true;
        btn.classList.add('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.remove('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    function enableDeleteBtn() {
        const btn = document.getElementById('deleteConfirmBtn');
        btn.disabled = false;
        btn.classList.remove('bg-red-400', 'cursor-not-allowed', 'opacity-60');
        btn.classList.add('bg-red-600', 'hover:bg-red-700', 'cursor-pointer', 'opacity-100');
    }

    document.getElementById('deleteConfirmInput').addEventListener('input', function() {
        const value = this.value.trim().toLowerCase();
        const hint = document.getElementById('deleteHint');

        if (value === 'hapus') {
            enableDeleteBtn();
            hint.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi valid — tombol aktif';
            hint.className = 'text-[11px] text-emerald-600 mt-2 text-center font-medium';
        } else {
            resetDeleteBtn();
            if (value.length > 0) {
                hint.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata tidak sesuai — ketik "hapus"';
                hint.className = 'text-[11px] text-red-500 mt-2 text-center';
            } else {
                hint.textContent = 'Masukkan kata "hapus" untuk mengaktifkan tombol';
                hint.className = 'text-[11px] text-gray-500 mt-2 text-center';
            }
        }
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        const input = document.getElementById('deleteConfirmInput');
        if (input.value.trim().toLowerCase() !== 'hapus') {
            e.preventDefault();
            return false;
        }
    });

    // ==========================================
    // ROW ACTION DROPDOWN MENU
    // ==========================================
    function toggleActionMenu(e, menuId) {
        e.stopPropagation();
        const menu = document.getElementById(menuId);
        if (!menu) return;
        const isHidden = menu.classList.contains('hidden');

        // Close all other student action menus
        document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));

        if (isHidden) {
            // Position fixed so the menu is never clipped by overflow-x-auto table
            const btn = e.currentTarget;
            const rect = btn.getBoundingClientRect();
            menu.classList.remove('hidden');
            menu.classList.add('fixed');
            menu.style.left = (rect.right - menu.offsetWidth) + 'px';
            if (window.innerHeight - rect.bottom < menu.offsetHeight + 8) {
                menu.style.top = '';
                menu.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
            } else {
                menu.style.bottom = '';
                menu.style.top = (rect.bottom + 4) + 'px';
            }
        } else {
            menu.classList.remove('fixed');
            menu.style.top = menu.style.bottom = menu.style.left = '';
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.student-action-menu') && !e.target.closest('button[onclick^="toggleActionMenu"]')) {
            document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.student-action-menu').forEach(m => m.classList.add('hidden'));
            closeDeleteModal();
            closeResetPasswordModal();
            closeWhatsAppModal();
            closeQuickDetail();
            closeBulkVerifyModal();
            closeBulkDeleteModal();
        }
    });

    function openResetPasswordModal(id, name) {
        document.getElementById('resetPasswordForm').action = '<?= base_url('admin/pindahan/reset-password') ?>/' + id;
        document.getElementById('resetStudentName').textContent = name;
        document.getElementById('newPasswordInput').value = '';

        const modal = document.getElementById('resetPasswordModal');
        const content = document.getElementById('resetPasswordModalContent');
        modal.classList.remove('hidden');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeResetPasswordModal() {
        const content = document.getElementById('resetPasswordModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.getElementById('resetPasswordModal').classList.add('hidden');
        }, 200);
    }

    function generateRandomPassword() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        let pass = '';
        for (let i = 0; i < 6; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('newPasswordInput').value = pass;
    }
</script>

<style>
    .pagination-wrapper ul.pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.25rem;
    }
    .pagination-wrapper ul.pagination li a,
    .pagination-wrapper ul.pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 0.5rem;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        transition: all 0.15s;
    }
    .pagination-wrapper ul.pagination li.active span {
        background-color: #465fff;
        border-color: #465fff;
        color: #ffffff;
    }
    .pagination-wrapper ul.pagination li a:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
</style>