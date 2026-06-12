<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Log Aktivitas Sistem
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Log Aktivitas Pengguna
<?= $this->endSection() ?>

<?= $this->section('head') ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
    /* DataTables custom styling to match Tailwind design */
    #table-log_wrapper {
        font-family: 'Inter', sans-serif;
    }
    #table-log thead th {
        background-color: #f9fafb !important;
        border-bottom: 1px solid #e5e7eb !important;
        color: #6b7280 !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        padding: 0.75rem 1.5rem !important;
    }
    #table-log tbody td {
        padding: 0.75rem 1.5rem !important;
        border-bottom: 1px solid #e5e7eb !important;
        vertical-align: middle;
    }
    #table-log tbody tr:hover {
        background-color: #f9fafb !important;
    }
    /* DataTables controls styling */
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.25rem 2rem 0.25rem 0.5rem;
        font-size: 0.875rem;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.4rem 0.75rem;
        font-size: 0.875rem;
        outline: none;
        margin-left: 0.5rem;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.8rem;
        color: #6b7280;
        padding-top: 1rem !important;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 1rem !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 0.25rem 0.75rem !important;
        margin: 0 0.15rem !important;
        font-size: 0.8rem !important;
        color: #374151 !important;
        background: #fff !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f3f4f6 !important;
        color: #111827 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #16a34a !important;
        color: #fff !important;
        border-color: #16a34a !important;
        font-weight: 600;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #374151;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<div class="flex justify-between items-center mb-4 gap-2 flex-wrap">
    <div>
        <a href="<?= base_url('admin/log_aktivitas/export-excel') ?>" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold flex items-center gap-2 py-2 px-4 rounded transition shadow-sm text-sm">
            <i class="fas fa-file-excel"></i> Download Excel
        </a>
    </div>
    
    <button type="button" onclick="document.getElementById('modal-delete-log').classList.remove('hidden')" class="bg-red-500 hover:bg-red-600 text-white font-semibold flex items-center gap-2 py-2 px-4 rounded transition shadow-sm text-sm">
        <i class="fas fa-trash-alt"></i> Hapus Semua Log
    </button>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4">
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
            <tbody class="text-sm">
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="whitespace-nowrap text-gray-500">
                                <div class="font-medium text-gray-900"><?= date('d/m/Y', strtotime($log['created_at'])) ?></div>
                                <div class="text-xs"><?= date('H:i:s', strtotime($log['created_at'])) ?></div>
                            </td>
                            <td>
                                <div class="font-semibold text-gray-800"><?= esc($log['nama_user']) ?></div>
                                <?php
                                $roleColor = 'bg-gray-100 text-gray-800';
                                if ($log['role'] == 'admin') $roleColor = 'bg-red-100 text-red-800';
                                elseif ($log['role'] == 'verifikator') $roleColor = 'bg-blue-100 text-blue-800';
                                elseif ($log['role'] == 'siswa') $roleColor = 'bg-green-100 text-green-800';
                                ?>
                                <span class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 mt-1 rounded <?= $roleColor ?>"><?= esc($log['role']) ?></span>
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded block w-fit"><?= esc($log['tindakan']) ?></span>
                            </td>
                            <td class="text-gray-600 text-sm">
                                <?= esc($log['keterangan']) ?>
                            </td>
                            <td class="text-xs text-gray-400 font-mono" title="<?= esc($log['user_agent']) ?>">
                                <?= esc($log['ip_address']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus Log -->
<div id="modal-delete-log" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="document.getElementById('modal-delete-log').classList.add('hidden')">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= base_url('admin/log_aktivitas/clear') ?>" method="post" id="form-delete-log">
                <?= csrf_field() ?>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Konfirmasi Hapus Log
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <p class="mb-2">Tindakan ini akan menghapus <strong>semua</strong> riwayat log aktivitas secara permanen dan tidak dapat dibatalkan.</p>
                                <p>Silakan ketik teks <strong class="text-red-600">HAPUS LOG</strong> (huruf kapital) di bawah ini untuk mengonfirmasi aksi Anda.</p>
                                <input type="text" name="confirm_text" id="confirm_text" class="mt-2 w-full border-gray-300 rounded-md shadow-sm border px-3 py-2 text-gray-900" autocomplete="off" required placeholder="HAPUS LOG">
                                <p id="error_text" class="text-red-500 text-xs mt-1 hidden">Teks konfirmasi tidak sesuai!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="validateDeleteLog()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Hapus Semua
                    </button>
                    <button type="button" onclick="document.getElementById('modal-delete-log').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateDeleteLog() {
    const input = document.getElementById('confirm_text').value;
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
            zeroRecords: '<div class="text-center py-4 text-gray-500"><i class="fas fa-search block text-3xl mb-3 text-gray-300"></i>Tidak ada log aktivitas ditemukan.</div>',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        },
        columnDefs: [
            { targets: 3, orderable: false } // Keterangan column not sortable
        ]
    });
});
</script>
<?= $this->endSection() ?>
