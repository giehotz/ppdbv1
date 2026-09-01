<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Log Aktivitas Sistem
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">history</span> Log Aktivitas Pengguna
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
    /* DataTables TailAdmin Theme Styling */
    #table-log_wrapper {
        font-family: inherit;
    }
    #table-log thead th {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(229, 231, 235, 0.8) !important;
        color: #6b7280 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 0.875rem 1.25rem !important;
    }
    .dark #table-log thead th {
        border-bottom: 1px solid rgba(55, 65, 81, 0.8) !important;
        color: #9ca3af !important;
    }
    #table-log tbody td {
        padding: 0.875rem 1.25rem !important;
        border-bottom: 1px solid rgba(243, 244, 246, 0.8) !important;
        vertical-align: middle;
    }
    .dark #table-log tbody td {
        border-bottom: 1px solid rgba(31, 41, 55, 0.8) !important;
    }
    #table-log tbody tr:hover {
        background-color: rgba(249, 250, 251, 0.8) !important;
    }
    .dark #table-log tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }
    /* Controls Styling */
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        padding: 0.35rem 2rem 0.35rem 0.75rem;
        font-size: 0.8125rem;
        outline: none;
        background-color: #fff;
    }
    .dark .dataTables_wrapper .dataTables_length select {
        border-color: #374151;
        background-color: #111827;
        color: #f3f4f6;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
        padding: 0.4rem 0.875rem;
        font-size: 0.8125rem;
        outline: none;
        margin-left: 0.5rem;
        background-color: #fff;
    }
    .dark .dataTables_wrapper .dataTables_filter input {
        border-color: #374151;
        background-color: #111827;
        color: #f3f4f6;
    }
    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #465fff;
        box-shadow: 0 0 0 3px rgba(70, 95, 255, 0.15);
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.75rem;
        color: #6b7280;
        padding-top: 1.25rem !important;
    }
    .dark .dataTables_wrapper .dataTables_info {
        color: #9ca3af;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 1rem !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
        margin: 0 0.15rem !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #4b5563 !important;
        background: #fff !important;
        transition: all 0.2s;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-color: #374151 !important;
        background: #1f2937 !important;
        color: #d1d5db !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f3f4f6 !important;
        color: #111827 !important;
        border-color: #d1d5db !important;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #374151 !important;
        color: #fff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #465fff !important;
        color: #fff !important;
        border-color: #465fff !important;
        box-shadow: 0 1px 2px rgba(70, 95, 255, 0.2);
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #465fff !important;
        color: #fff !important;
        border-color: #465fff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1.25rem;
        font-size: 0.8125rem;
        color: #4b5563;
    }
    .dark .dataTables_wrapper .dataTables_length,
    .dark .dataTables_wrapper .dataTables_filter {
        color: #9ca3af;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Action Header -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Log Sistem</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Memantau seluruh jejak aktivitas pengguna, admin, dan verifikator</p>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <a href="<?= base_url('admin/log_aktivitas/export-excel') ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-semibold text-white shadow-theme-xs transition-all duration-200 active:scale-[0.97]">
            <i class="fas fa-file-excel"></i>
            <span>Export Excel</span>
        </a>

        <button type="button" onclick="openDeleteModal()" class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-white hover:bg-red-50 text-red-600 px-4 py-2.5 text-xs font-semibold shadow-theme-xs transition-all duration-200 dark:border-red-900/50 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30 active:scale-[0.97]">
            <i class="fas fa-trash-alt"></i>
            <span>Hapus Semua Log</span>
        </button>
    </div>
</div>

<!-- Main Table Card -->
<div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
        <table id="table-log" class="w-full text-left border-collapse display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pengguna</th>
                    <th>Tindakan</th>
                    <th>Keterangan</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody class="text-xs md:text-sm">
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="whitespace-nowrap text-gray-500 dark:text-gray-400">
                                <div class="font-bold text-gray-900 dark:text-white"><?= date('d/m/Y', strtotime($log['created_at'])) ?></div>
                                <div class="text-[11px] text-gray-400 dark:text-gray-500 font-mono"><?= date('H:i:s', strtotime($log['created_at'])) ?></div>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-900 dark:text-white"><?= esc($log['nama_user']) ?></div>
                                <?php
                                $roleBadge = 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border-gray-200 dark:border-gray-700';
                                if ($log['role'] == 'admin') {
                                    $roleBadge = 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400 border-red-200/60 dark:border-red-500/20';
                                } elseif ($log['role'] == 'verifikator') {
                                    $roleBadge = 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400 border-blue-200/60 dark:border-blue-500/20';
                                } elseif ($log['role'] == 'siswa') {
                                    $roleBadge = 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400 border-emerald-200/60 dark:border-emerald-500/20';
                                }
                                ?>
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 mt-1 rounded-full border <?= $roleBadge ?>">
                                    <?= esc($log['role']) ?>
                                </span>
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="inline-flex rounded-lg bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 border border-brand-200/50 dark:border-brand-500/20">
                                    <?= esc($log['tindakan']) ?>
                                </span>
                            </td>
                            <td class="text-gray-700 dark:text-gray-300 leading-relaxed max-w-md">
                                <?= esc($log['keterangan']) ?>
                            </td>
                            <td class="whitespace-nowrap text-[11px] text-gray-400 dark:text-gray-500 font-mono" title="<?= esc($log['user_agent']) ?>">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs text-gray-400">devices</span>
                                    <span><?= esc($log['ip_address']) ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus Semua Log -->
<div id="modal-delete-log" class="fixed inset-0 z-[99999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <!-- Modal Dialog Container -->
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4 overflow-y-auto">
        <div class="relative bg-white dark:bg-gray-900 rounded-2xl text-left overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-800 w-full max-w-lg transform transition-all">
            <form action="<?= base_url('admin/log_aktivitas/clear') ?>" method="post" id="form-delete-log">
                <?= csrf_field() ?>
                <div class="p-6">
                    <div class="sm:flex sm:items-start gap-4">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400 sm:mx-0">
                            <span class="material-symbols-outlined text-2xl">warning</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:text-left flex-1">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white" id="modal-title">
                                Konfirmasi Hapus Semua Log
                            </h3>
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 space-y-2">
                                <p>Tindakan ini akan menghapus <strong>seluruh</strong> riwayat aktivitas sistem secara permanen dan tidak dapat dibatalkan.</p>
                                <p>Ketik teks <strong class="text-red-600 dark:text-red-400 font-mono">HAPUS LOG</strong> di bawah ini untuk mengonfirmasi:</p>
                                <input type="text" name="confirm_text" id="confirm_text" class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-sm text-gray-900 dark:text-white shadow-theme-xs focus:border-red-400 focus:ring-2 focus:ring-red-400/20 outline-none font-mono" autocomplete="off" required placeholder="HAPUS LOG">
                                <p id="error_text" class="text-red-500 text-xs mt-1 hidden font-semibold">Teks konfirmasi tidak cocok! Harap ketik "HAPUS LOG".</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2.5 border-t border-gray-100 dark:border-gray-800">
                    <button type="button" onclick="closeDeleteModal()" class="inline-flex justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-2.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-theme-xs">
                        Batal
                    </button>
                    <button type="button" onclick="validateDeleteLog()" class="inline-flex justify-center rounded-xl bg-red-600 hover:bg-red-700 px-5 py-2.5 text-xs font-semibold text-white transition-all shadow-theme-xs active:scale-[0.97]">
                        Ya, Hapus Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    const modal = document.getElementById('modal-delete-log');
    const input = document.getElementById('confirm_text');
    const errorText = document.getElementById('error_text');
    if (input) input.value = '';
    if (errorText) errorText.classList.add('hidden');
    if (modal) modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('modal-delete-log');
    if (modal) modal.classList.add('hidden');
}

function validateDeleteLog() {
    const input = document.getElementById('confirm_text').value.trim();
    if (input === 'HAPUS LOG') {
        document.getElementById('form-delete-log').submit();
    } else {
        document.getElementById('error_text').classList.remove('hidden');
    }
}
</script>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    $('#table-log').DataTable({
        responsive: true,
        order: [[0, 'desc']],
        pageLength: 20,
        lengthMenu: [10, 20, 50, 100],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: '<div class="text-center py-6 text-gray-400 dark:text-gray-500"><i class="fas fa-search block text-3xl mb-2 text-gray-300 dark:text-gray-600"></i>Tidak ada log aktivitas ditemukan.</div>',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        },
        columnDefs: [
            { targets: 3, orderable: false }
        ]
    });
});
</script>
<?= $this->endSection() ?>
