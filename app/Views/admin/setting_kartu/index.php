<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan Kartu Siswa
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
<span class="material-symbols-outlined text-brand-500 mr-1">badge</span> Pengaturan Kartu Siswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Pill Tabs Navigation (TailAdmin Style) -->
<div class="mb-6">
    <div class="flex flex-wrap gap-1 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-xl" id="settingTabs" role="tablist">
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="instansi" type="button">
            <span class="material-symbols-outlined text-base">school</span>
            <span>Data Instansi</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="preview" type="button">
            <span class="material-symbols-outlined text-base">visibility</span>
            <span>Pratinjau Kartu</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="layout" type="button">
            <span class="material-symbols-outlined text-base">palette</span>
            <span>Desain & Layout</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="qr" type="button">
            <span class="material-symbols-outlined text-base">qr_code_2</span>
            <span>Pengaturan QR</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="ttd" type="button">
            <span class="material-symbols-outlined text-base">draw</span>
            <span>Tanda Tangan & Cap</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200" data-target="printer" type="button">
            <span class="material-symbols-outlined text-base">print</span>
            <span>Mesin Printer</span>
        </button>
        <button class="tab-trigger flex items-center gap-2 px-4 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 ml-auto" data-target="cetak-masal" type="button">
            <span class="material-symbols-outlined text-base text-emerald-500">print_connect</span>
            <span class="text-emerald-600 dark:text-emerald-400">Cetak Masal</span>
        </button>
    </div>
</div>

<!-- Tab Contents -->
<div class="space-y-6">
    <?= $this->include('admin/setting_kartu/tab_instansi') ?>
    <?= $this->include('admin/setting_kartu/tab_preview') ?>
    <?= $this->include('admin/setting_kartu/tab_layout') ?>
    <?= $this->include('admin/setting_kartu/tab_qr') ?>
    <?= $this->include('admin/setting_kartu/tab_ttd') ?>
    <?= $this->include('admin/setting_kartu/tab_printer') ?>
    <?= $this->include('admin/setting_kartu/tab_cetak_masal') ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const triggers = document.querySelectorAll('.tab-trigger');
    const contents = document.querySelectorAll('.tab-content');

    const urlParams = new URLSearchParams(window.location.search);
    const tabParam  = urlParams.get('tab');
    const activeTab = tabParam || localStorage.getItem('activeSettingKartuTab') || 'instansi';
    let previousTab = localStorage.getItem('previousSettingKartuTab') || 'instansi';

    function switchTab(target) {
        triggers.forEach(t => {
            t.classList.remove('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm', 'bg-emerald-50', 'dark:bg-emerald-500/15', 'text-emerald-600', 'dark:text-emerald-400');
            t.classList.add('text-gray-500', 'dark:text-gray-400');
        });
        
        let trigger = document.querySelector(`.tab-trigger[data-target="${target}"]`);
        if (!trigger) {
            trigger = triggers[0];
            target = trigger.dataset.target;
        }

        const currentActive = localStorage.getItem('activeSettingKartuTab');
        if (currentActive && currentActive !== 'preview' && currentActive !== target) {
            previousTab = currentActive;
            localStorage.setItem('previousSettingKartuTab', previousTab);
        }
        
        trigger.classList.remove('text-gray-500', 'dark:text-gray-400');
        if (target === 'cetak-masal') {
            trigger.classList.add('bg-white', 'dark:bg-gray-900', 'text-emerald-600', 'dark:text-emerald-400', 'shadow-sm');
        } else {
            trigger.classList.add('bg-white', 'dark:bg-gray-900', 'text-brand-500', 'shadow-sm');
        }

        // Toggle content visibility
        contents.forEach(c => c.classList.add('hidden'));
        const activeContent = document.getElementById(target);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }
        
        localStorage.setItem('activeSettingKartuTab', target);

        // Jika membuka tab preview, pastikan iframe bersih dan tidak tersangkut halaman lain
        if (target === 'preview') {
            const iframe = document.getElementById('previewCardIframe');
            if (iframe && (!iframe.src || iframe.src.indexOf('preview') === -1)) {
                iframe.src = '<?= base_url('admin/setting-kartu/preview') ?>';
            }
        }
    }

    // Fungsi untuk menutup pratinjau kartu dari dalam iframe (mencegah bug mirror)
    window.closeCardPreviewTab = function() {
        const target = (previousTab && previousTab !== 'preview') ? previousTab : 'instansi';
        switchTab(target);
    };

    // Fungsi muat ulang iframe pratinjau
    window.reloadCardPreview = function() {
        const iframe = document.getElementById('previewCardIframe');
        if (iframe) {
            iframe.src = '<?= base_url('admin/setting-kartu/preview') ?>?_t=' + new Date().getTime();
        }
    };

    // Listener postMessage jika iframe berkomunikasi via pesan lintas frame
    window.addEventListener('message', function(event) {
        if (event.data && event.data.action === 'close_preview') {
            window.closeCardPreviewTab();
        }
    });

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            switchTab(trigger.dataset.target);
        });
    });

    switchTab(activeTab);
</script>
<?= $this->endSection() ?>