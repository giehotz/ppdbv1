<?= $this->extend('layouts/verifikator') ?>

<?= $this->section('title') ?>Lengkapi Biodata Siswa<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Pendaftaran Siswa Offline<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden max-w-5xl mx-auto">
    <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Langkah 2: Lengkapi Biodata</h2>
            <p class="text-slate-500 text-sm mt-1">Siswa: <span class="font-bold text-blue-600"><?= esc($siswa['nama_lengkap']) ?></span> (<?= esc($siswa['nisn']) ?>)</p>
        </div>
        <div class="hidden sm:flex text-sm font-semibold text-slate-400 gap-4">
            <span class="text-green-600"><i class="fas fa-check-circle"></i> Akun</span>
            <span class="text-blue-600 border-b-2 border-blue-600 pb-1">2. Biodata</span>
            <span>3. Berkas</span>
            <span>4. Selesai</span>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="m-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-0" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="m-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-0 text-sm" role="alert">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 bg-gray-50 mt-4">
        <nav class="flex -mb-px overflow-x-auto scrollbar-hide scrollable-tabs" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            <button onclick="showTab('dataDiri')" id="tab-dataDiri" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-blue-600 text-blue-600 flex-shrink-0">
                <i class="fas fa-user mr-1 md:mr-2"></i>Data Diri
            </button>
            <button onclick="showTab('alamat')" id="tab-alamat" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-map-marker-alt mr-1 md:mr-2"></i>Alamat
            </button>
            <button onclick="showTab('orangTua')" id="tab-orangTua" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-users mr-1 md:mr-2"></i>Orang Tua/Wali
            </button>
            <button onclick="showTab('kesejahteraan')" id="tab-kesejahteraan" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-hand-holding-heart mr-1 md:mr-2"></i>Kesejahteraan
            </button>
            <button onclick="showTab('sekolah')" id="tab-sekolah" class="tab-button whitespace-nowrap py-3 px-4 md:py-4 md:px-6 text-xs md:text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0">
                <i class="fas fa-school mr-1 md:mr-2"></i>Asal Sekolah
            </button>
        </nav>
    </div>

    <?php
    $this->setData([
        'isFinal' => false,
        'siswa' => $siswa,
        'provinsi' => $provinsi ?? [],
        'penghasilan' => $penghasilan ?? []
    ]);
    ?>

    <form action="<?= base_url('verifikator/siswa/biodataStore/' . $siswa['id_siswa']) ?>" method="post" class="p-6" id="formBiodata">
        <?= csrf_field() ?>

        <?= $this->include('siswa/biodata/_data_diri') ?>
        <?= $this->include('siswa/biodata/_alamat') ?>
        <?= $this->include('siswa/biodata/_orang_tua') ?>
        <?= $this->include('siswa/biodata/_kesejahteraan') ?>
        <?= $this->include('siswa/biodata/_asal_sekolah') ?>

        <div class="flex justify-between items-center mt-8 pt-6 border-t border-slate-100">
            <button type="button" id="btnPrev" onclick="navigateTab('prev')" class="flex items-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 px-6 rounded-xl transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
            </button>

            <div class="flex items-center gap-3">
                <button type="button" id="btnNext" onclick="navigateTab('next')" class="flex items-center bg-slate-800 hover:bg-slate-900 text-white font-semibold py-2.5 px-8 rounded-xl transition duration-200 shadow-md">
                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                </button>
                <button type="submit" name="finish_skip" value="1" class="hidden text-sm text-slate-500 hover:text-slate-800 font-semibold py-2.5 px-4 underline">
                    Simpan & Lewati Berkas
                </button>
                <button type="submit" id="btnSubmit" class="hidden bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-8 rounded-xl transition duration-200 shadow-md shadow-blue-600/30">
                    Simpan Biodata & Lanjut Berkas <i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/biodata.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/biodata.js') ?>"></script>
<script>
    setupBiodata({
        baseUrl: '<?= base_url() ?>',
        csrfToken: '<?= csrf_token() ?>',
        csrfHash: '<?= csrf_hash() ?>'
    });

    setIsFinal(false);

    setSavedValues({
        prov: '<?= $siswa['prov'] ?? '' ?>',
        kab: '<?= $siswa['kab'] ?? '' ?>',
        kec: '<?= $siswa['kec'] ?? '' ?>',
        desa: '<?= $siswa['desa'] ?? '' ?>'
    });

    document.getElementById('formBiodata').addEventListener('submit', function() {
        this.querySelectorAll('[disabled]').forEach(el => el.disabled = false);
    });
</script>
<?= $this->endSection() ?>
