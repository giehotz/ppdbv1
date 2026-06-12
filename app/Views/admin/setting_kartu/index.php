<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Tabs Header -->
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 overflow-x-auto" id="settingTabs">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 rounded-t-lg tab-trigger active text-blue-600 border-blue-600" data-target="instansi">Data Instansi</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-trigger border-blue-600" data-target="preview">Preview Kartu</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-trigger border-blue-600" data-target="layout">Desain & Layout</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-trigger border-blue-600" data-target="qr">Pengaturan QR</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-trigger border-blue-600" data-target="ttd">Tanda Tangan</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-trigger border-blue-600" data-target="printer">Mesin Printer</button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-green-600 hover:border-green-300 tab-trigger font-bold" data-target="cetak-masal"><i class="fas fa-print mr-1"></i> Cetak Masal</button>
            </li>
        </ul>
    </div>

    <!-- Tab Contents -->
    <div class="p-6">

        <?= $this->include('admin/setting_kartu/tab_instansi') ?>

        <?= $this->include('admin/setting_kartu/tab_preview') ?>

        <?= $this->include('admin/setting_kartu/tab_layout') ?>

        <?= $this->include('admin/setting_kartu/tab_qr') ?>

        <?= $this->include('admin/setting_kartu/tab_ttd') ?>

        <?= $this->include('admin/setting_kartu/tab_printer') ?>

        <?= $this->include('admin/setting_kartu/tab_cetak_masal') ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Tab Script
    const triggers = document.querySelectorAll('.tab-trigger');
    const contents = document.querySelectorAll('.tab-content');

    // Retrieve active tab from localStorage
    const activeTab = localStorage.getItem('activeSettingKartuTab') || 'instansi';

    function switchTab(target) {
        triggers.forEach(t => {
            // Reset base styles
            t.classList.remove('active', 'text-blue-600', 'border-blue-600', 'text-green-600', 'border-green-600');
            t.classList.add('border-transparent');
        });
        
        let trigger = document.querySelector(`.tab-trigger[data-target="${target}"]`);
        if (!trigger) {
            trigger = triggers[0];
            target = trigger.dataset.target;
        }
        
        if (target === 'cetak-masal') {
            trigger.classList.add('active', 'text-green-600', 'border-green-600');
        } else {
            trigger.classList.add('active', 'text-blue-600', 'border-blue-600');
        }
        trigger.classList.remove('border-transparent');

        // Toggle content visibility
        contents.forEach(c => c.classList.add('hidden'));
        document.getElementById(target).classList.remove('hidden');
        
        // Save state
        localStorage.setItem('activeSettingKartuTab', target);
    }

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            switchTab(trigger.dataset.target);
        });
    });

    // Initialize tab on page load
    switchTab(activeTab);
</script>
<?= $this->endSection() ?>