<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Landing Content Management
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Landing Content Management
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

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Edit Landing Page</h3>
        <a href="<?= base_url('/') ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            <i class="fas fa-eye mr-2"></i> Preview Landing Page
        </a>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px flex-wrap" aria-label="Tabs">
            <button onclick="switchTab('navbar')" id="tab-navbar" class="tab-button border-b-2 border-green-500 text-green-600 py-4 px-6 text-sm font-medium">
                <i class="fas fa-compass mr-1"></i> Navbar
            </button>
            <button onclick="switchTab('hero')" id="tab-hero" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-star mr-1"></i> Hero
            </button>
            <button onclick="switchTab('jadwal')" id="tab-jadwal" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-calendar-alt mr-1"></i> Jadwal
            </button>
            <button onclick="switchTab('syarat')" id="tab-syarat" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-clipboard-list mr-1"></i> Syarat
            </button>
            <button onclick="switchTab('kontak')" id="tab-kontak" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-phone-alt mr-1"></i> Kontak
            </button>
            <button onclick="switchTab('footer')" id="tab-footer" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-shoe-prints mr-1"></i> Footer
            </button>
            <button onclick="switchTab('fitur')" id="tab-fitur" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-star mr-1"></i> Keunggulan
            </button>
            <button onclick="switchTab('galeri')" id="tab-galeri" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-images mr-1"></i> Galeri
            </button>
            <button onclick="switchTab('testimoni')" id="tab-testimoni" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-comments mr-1"></i> Testimoni
            </button>
            <button onclick="switchTab('faq')" id="tab-faq" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-question-circle mr-1"></i> FAQ
            </button>
            <button onclick="switchTab('pendaftar')" id="tab-pendaftar" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-users mr-1"></i> Data Pendaftar
            </button>
            <button onclick="switchTab('favicon')" id="tab-favicon" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-6 text-sm font-medium">
                <i class="fas fa-image mr-1"></i> Favicon
            </button>
        </nav>
    </div>

    <!-- ===================== NAVBAR ===================== -->
    <?= $this->include('admin/landing-content/tabs/navbar') ?>

    <!-- ===================== HERO ===================== -->
    <?= $this->include('admin/landing-content/tabs/hero') ?>

    <!-- ===================== JADWAL ===================== -->
    <?= $this->include('admin/landing-content/tabs/jadwal') ?>

    <!-- ===================== SYARAT ===================== -->
    <?= $this->include('admin/landing-content/tabs/syarat') ?>

    <!-- ===================== KONTAK ===================== -->
    <?= $this->include('admin/landing-content/tabs/kontak') ?>

    <!-- ===================== FOOTER ===================== -->
    <?= $this->include('admin/landing-content/tabs/footer') ?>

    <!-- ===================== FITUR / KEUNGGULAN ===================== -->
    <?= $this->include('admin/landing-content/tabs/fitur') ?>

    <!-- ===================== GALERI ===================== -->
    <?= $this->include('admin/landing-content/tabs/galeri') ?>

    <!-- ===================== TESTIMONI ===================== -->
    <?= $this->include('admin/landing-content/tabs/testimoni') ?>

    <!-- ===================== FAQ ===================== -->
    <?= $this->include('admin/landing-content/tabs/faq') ?>

    <!-- ===================== PENDAFTAR ===================== -->
    <?= $this->include('admin/landing-content/tabs/pendaftar') ?>

    <!-- ===================== FAVICON ===================== -->
    <?= $this->include('admin/landing-content/tabs/favicon') ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function switchTab(tabName) {
        // Save to localStorage
        localStorage.setItem('activeLandingTab', tabName);
        
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active state from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-green-500', 'text-green-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });

        // Show selected content
        const targetContent = document.getElementById('form-' + tabName) || document.getElementById(tabName);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Activate selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        if (activeTab) {
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-green-500', 'text-green-600');
        }
    }

    // Initialize active tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = localStorage.getItem('activeLandingTab') || 'navbar';
        if (document.getElementById('tab-' + activeTab)) {
            switchTab(activeTab);
        }
    });

    function uploadHeroImage(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const formData = new FormData();
        const csrfName = '<?= csrf_token() ?>';
        // Get CSRF value from the page (e.g. from the first form encountered since all share it)
        const csrfHash = document.querySelector('input[name="' + csrfName + '"]').value;

        formData.append('media', file);
        formData.append('section', 'hero');
        formData.append('content_key', 'background_image');
        formData.append(csrfName, csrfHash); // Add CSRF token

        const progressBar = document.getElementById('hero-progress-bar');
        const progressContainer = document.getElementById('hero-upload-progress');
        const uploadArea = document.getElementById('hero-upload-area');
        const previewArea = document.getElementById('hero-preview');
        const previewImg = document.getElementById('hero-preview-img');
        const hiddenInput = document.getElementById('hero-bg-value');

        progressContainer.classList.remove('hidden');
        progressBar.style.width = '0%';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('admin/landing-content/uploadMedia') ?>', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                progressBar.style.width = percentComplete + '%';
            }
        };

        xhr.onload = function() {
            progressContainer.classList.add('hidden');
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);

                    // Update CSRF token on page if returned
                    if (response.token) {
                        document.querySelectorAll('input[name="' + csrfName + '"]').forEach(el => {
                            el.value = response.token;
                        });
                    }

                    if (response.success) {
                        previewImg.src = response.path;
                        hiddenInput.value = response.relative_path;
                        uploadArea.classList.add('hidden');
                        previewArea.classList.remove('hidden');
                    } else {
                        alert('Upload gagal: ' + response.message);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    alert('Terjadi kesalahan saat memproses respon server.');
                }
            } else {
                alert('Terjadi kesalahan saat upload (Status: ' + xhr.status + ').');
            }
        };

        xhr.onerror = function() {
            progressContainer.classList.add('hidden');
            alert('Gagal menghubungi server.');
        };

        xhr.send(formData);
    }

    function removeHeroImage() {
        if (!confirm('Hapus gambar background?')) return;

        const uploadArea = document.getElementById('hero-upload-area');
        const previewArea = document.getElementById('hero-preview');
        const hiddenInput = document.getElementById('hero-bg-value');
        const fileInput = document.getElementById('hero-file-input');

        hiddenInput.value = '';
        fileInput.value = '';
        previewArea.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    }

    // =========================================================================
    // FITUR FUNCTIONS
    // =========================================================================

    function editFitur(data) {
        document.getElementById('fitur-form-title').innerText = 'Edit Keunggulan';
        document.getElementById('fitur_id').value = data.fitur_id;
        document.getElementById('fitur_judul').value = data.judul;
        document.getElementById('fitur_urutan').value = data.urutan;
        document.getElementById('fitur_ikon').value = data.ikon;
        document.getElementById('fitur_deskripsi').value = data.deskripsi;
        document.getElementById('fitur_is_active').checked = data.is_active == 1;
        document.getElementById('fitur_judul').focus();
    }

    function resetFiturForm() {
        document.getElementById('fitur-form-title').innerText = 'Tambah Keunggulan Baru';
        document.getElementById('fitur_id').value = '';
        document.getElementById('fitur_judul').value = '';
        document.getElementById('fitur_urutan').value = '0';
        document.getElementById('fitur_ikon').value = '';
        document.getElementById('fitur_deskripsi').value = '';
        document.getElementById('fitur_is_active').checked = true;
    }

    // =========================================================================
    // GALERI FUNCTIONS
    // =========================================================================

    function editGaleri(data) {
        document.getElementById('galeri-form-title').innerText = 'Edit Galeri';
        document.getElementById('galeri_id').value = data.galeri_id;
        document.getElementById('galeri_judul').value = data.judul;
        document.getElementById('galeri_urutan').value = data.urutan;
        document.getElementById('galeri_deskripsi').value = data.deskripsi;
        document.getElementById('galeri_is_active').checked = data.is_active == 1;
        document.getElementById('galeri_gambar_note').classList.remove('hidden');
        document.getElementById('galeri_judul').focus();
    }

    function resetGaleriForm() {
        document.getElementById('galeri-form-title').innerText = 'Tambah Galeri Baru';
        document.getElementById('galeri_id').value = '';
        document.getElementById('galeri_judul').value = '';
        document.getElementById('galeri_urutan').value = '0';
        document.getElementById('galeri_gambar').value = '';
        document.getElementById('galeri_deskripsi').value = '';
        document.getElementById('galeri_is_active').checked = true;
        document.getElementById('galeri_gambar_note').classList.add('hidden');
    }

    // =========================================================================
    // TESTIMONI FUNCTIONS
    // =========================================================================

    function editTestimoni(data) {
        document.getElementById('testimoni-form-title').innerText = 'Edit Testimoni';
        document.getElementById('testimoni_id').value = data.testimoni_id;
        document.getElementById('testimoni_nama').value = data.nama;
        document.getElementById('testimoni_peran').value = data.peran;
        document.getElementById('testimoni_rating').value = data.rating;
        document.getElementById('testimoni_isi').value = data.isi;
        document.getElementById('testimoni_is_active').checked = data.is_active == 1;
        document.getElementById('testimoni_nama').focus();
    }

    function resetTestimoniForm() {
        document.getElementById('testimoni-form-title').innerText = 'Tambah Testimoni Baru';
        document.getElementById('testimoni_id').value = '';
        document.getElementById('testimoni_nama').value = '';
        document.getElementById('testimoni_peran').value = '';
        document.getElementById('testimoni_rating').value = '5';
        document.getElementById('testimoni_avatar').value = '';
        document.getElementById('testimoni_isi').value = '';
        document.getElementById('testimoni_is_active').checked = true;
    }

    // =========================================================================
    // FAQ FUNCTIONS
    // =========================================================================

    function editFaq(data) {
        document.getElementById('faq-form-title').innerText = 'Edit FAQ';
        document.getElementById('faq_id').value = data.id;
        document.getElementById('faq_pertanyaan').value = data.pertanyaan;
        document.getElementById('faq_jawaban').value = data.jawaban;
        document.getElementById('faq_pertanyaan').focus();
    }

    function resetFaqForm() {
        document.getElementById('faq-form-title').innerText = 'Tambah FAQ Baru';
        document.getElementById('faq_id').value = '';
        document.getElementById('faq_pertanyaan').value = '';
        document.getElementById('faq_jawaban').value = '';
    }
</script>
<?= $this->endSection() ?>