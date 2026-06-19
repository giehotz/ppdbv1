<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Pengaturan Sistem
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Pengaturan Sistem
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="flex items-center gap-3 bg-primary-container/30 text-on-primary-container border border-primary/20 px-5 py-4 rounded-xl mb-6 shadow-sm" role="alert">
        <span class="material-symbols-outlined text-primary text-2xl">check_circle</span>
        <span class="font-semibold text-sm"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="flex items-center gap-3 bg-error-container/30 text-on-error-container border border-error/20 px-5 py-4 rounded-xl mb-6 shadow-sm" role="alert">
        <span class="material-symbols-outlined text-error text-2xl">error</span>
        <span class="font-semibold text-sm"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Tab Navigation -->
<div class="mb-8">
    <div class="flex flex-wrap gap-1 p-1.5 bg-surface-container-high rounded-xl" id="settings-tabs" role="tablist">
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="sistem-tab-btn" data-target="tab-sistem" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">settings</span>
            <span>Sistem PPDB</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="sekolah-tab-btn" data-target="tab-sekolah" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">school</span>
            <span>Profil Sekolah</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="referensi-tab-btn" data-target="tab-referensi" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">list_alt</span>
            <span>Data Referensi</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="biodata-tab-btn" data-target="tab-biodata" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">fact_check</span>
            <span>Wajib Biodata</span>
        </button>
        <button class="tab-link flex items-center gap-2 px-5 py-3 rounded-lg text-sm font-bold transition-all duration-200" id="kop-tab-btn" data-target="tab-kop" type="button" role="tab">
            <span class="material-symbols-outlined text-lg">description</span>
            <span>Kop Dokumen</span>
        </button>
    </div>
</div>

<form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="space-y-6">
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

        <div id="tab-kop" class="tab-content hidden">
            <?= view('admin/settings/_tab_kop') ?>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6 border-t border-surface-variant">
            <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-primary text-white font-bold py-3 px-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 active:scale-[0.97]">
                <span class="material-symbols-outlined text-lg">save</span>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        function setActiveTab(targetId) {
            tabLinks.forEach(link => {
                link.classList.remove('bg-surface', 'text-primary', 'shadow-sm');
                link.classList.add('text-on-surface-variant');

                if (link.getAttribute('data-target') === targetId) {
                    link.classList.remove('text-on-surface-variant');
                    link.classList.add('bg-surface', 'text-primary', 'shadow-sm');
                }
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.id !== targetId);
            });

            localStorage.setItem('active_settings_tab', targetId);
        }

        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                setActiveTab(this.getAttribute('data-target'));
            });
        });

        const lastTab = localStorage.getItem('active_settings_tab');
        if (lastTab && document.getElementById(lastTab)) {
            setActiveTab(lastTab);
        } else {
            setActiveTab('tab-sistem');
        }
    });
</script>

<?= $this->endSection() ?>
