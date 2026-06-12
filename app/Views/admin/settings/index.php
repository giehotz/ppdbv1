<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan Sistem
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pengaturan Sistem
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

<!-- Tab Navigation -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="settings-tabs" role="tablist">
            <li class="mr-2" role="presentation">
                <button class="tab-link inline-block p-4 border-b-2 rounded-t-lg transition-all duration-200" id="sistem-tab-btn" data-target="tab-sistem" type="button" role="tab">
                    <i class="fas fa-cogs mr-2 text-gray-500"></i> Sistem PPDB
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="tab-link inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-gray-600 hover:border-gray-300 transition-all duration-200" id="sekolah-tab-btn" data-target="tab-sekolah" type="button" role="tab">
                    <i class="fas fa-school mr-2 text-gray-500"></i> Profil Sekolah
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="tab-link inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-gray-600 hover:border-gray-300 transition-all duration-200" id="referensi-tab-btn" data-target="tab-referensi" type="button" role="tab">
                    <i class="fas fa-list mr-2 text-gray-500"></i> Data Referensi
                </button>
            </li>
            <li class="mr-2" role="presentation">
                <button class="tab-link inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-gray-600 hover:border-gray-300 transition-all duration-200" id="biodata-tab-btn" data-target="tab-biodata" type="button" role="tab">
                    <i class="fas fa-clipboard-check mr-2 text-gray-500"></i> Wajib Biodata
                </button>
            </li>
        </ul>
    </div>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="space-y-6">
        <!-- Tab Content -->
        <div id="tab-sistem" class="tab-content hidden">
            <?= view('admin/settings/_tab_sistem') ?>
        </div>
        
        <div id="tab-sekolah" class="tab-content hidden">
            <?= view('admin/settings/_tab_sekolah') ?>
        </div>

        <div id="tab-referensi" class="tab-content hidden">
            <?= view('admin/settings/_tab_referensi') ?>
        </div>

        <div id="tab-biodata" class="tab-content hidden">
            <?= view('admin/settings/_tab_biodata') ?>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded shadow-lg transform transition active:scale-95 duration-200">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        /**
         * Function to set active tab
         * @param {string} targetId - ID of the tab content to show
         */
        function setActiveTab(targetId) {
            // Unset all active states
            tabLinks.forEach(link => {
                link.classList.remove('active', 'border-green-600', 'text-green-600');
                link.classList.add('border-transparent', 'text-gray-500');
                
                // Update icon colors
                const icon = link.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-green-600');
                    icon.classList.add('text-gray-500');
                }
                
                if (link.getAttribute('data-target') === targetId) {
                    link.classList.add('active', 'border-green-600', 'text-green-600');
                    link.classList.remove('border-transparent', 'text-gray-500');
                    
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-green-600');
                    }
                }
            });

            // Toggle content visibility
            tabContents.forEach(content => {
                if (content.id === targetId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });

            // Save preference to localStorage
            localStorage.setItem('active_settings_tab', targetId);
        }

        // Add click listeners to buttons
        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                setActiveTab(targetId);
            });
        });

        // Initialize from localStorage correctly
        const lastTab = localStorage.getItem('active_settings_tab');
        if (lastTab && document.getElementById(lastTab)) {
            setActiveTab(lastTab);
        } else {
            setActiveTab('tab-sistem');
        }
    });
</script>

<?= $this->endSection() ?>