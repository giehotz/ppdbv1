<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\Pindahan\SiswaPindahanModel;
use App\Models\Pindahan\BerkasPindahanModel;
use App\Models\Pindahan\VerifikasiPindahanModel;
use App\Models\PenghasilanModel;
use App\Models\PekerjaanModel;
use App\Models\TblWebModel;
use App\Services\PindahanService;
use Config\PindahanConfig;
use CodeIgniter\HTTP\RedirectResponse;

class Pindahan extends BaseController
{
    protected SiswaPindahanModel $pindahanModel;
    protected BerkasPindahanModel $berkasModel;
    protected VerifikasiPindahanModel $verifikasiModel;
    protected PenghasilanModel $penghasilanModel;
    protected PekerjaanModel $pekerjaanModel;
    protected PindahanService $pindahanService;

    /**
     * Dependency injection opsional — default fallback ke instansiasi
     * manual agar tetap kompatibel dengan createController() CI4.
     */
    public function __construct(
        ?SiswaPindahanModel $pindahanModel = null,
        ?BerkasPindahanModel $berkasModel = null,
        ?VerifikasiPindahanModel $verifikasiModel = null,
        ?PenghasilanModel $penghasilanModel = null,
        ?PekerjaanModel $pekerjaanModel = null,
        ?PindahanService $pindahanService = null
    ) {
        $this->pindahanModel    = $pindahanModel ?? new SiswaPindahanModel();
        $this->berkasModel      = $berkasModel ?? new BerkasPindahanModel();
        $this->verifikasiModel  = $verifikasiModel ?? new VerifikasiPindahanModel();
        $this->penghasilanModel = $penghasilanModel ?? new PenghasilanModel();
        $this->pekerjaanModel   = $pekerjaanModel ?? new PekerjaanModel();
        $this->pindahanService  = $pindahanService ?? new PindahanService($this->pindahanModel, $this->berkasModel, $this->verifikasiModel);
    }

    // ─────────────────────────────────────────────────────────────
    // DASHBOARD
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        $idPindahan = session()->get('id_siswa');
        if (!$idPindahan) {
            return redirect()->to('/login');
        }

        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            session()->setFlashdata('error', 'Data pendaftaran pindahan tidak ditemukan.');
            return redirect()->to('/logout');
        }

        $completionData = $this->pindahanModel->calculateCompletionPercentage($pindahan);
        $completionPct  = $completionData['percentage'];

        $berkasList = $this->berkasModel->getByPindahan($idPindahan);
        $berkasWajib = $this->berkasModel->isWajibLengkap($idPindahan, $berkasList);

        $tagihanBerkas = count($berkasList);
        $requiredDocs  = BerkasPindahanModel::getJenisBerkasOptions();

        $hasRejectedBerkas = false;
        foreach ($berkasList as $b) {
            if (($b['status_verifikasi'] ?? '') === 'invalid') {
                $hasRejectedBerkas = true;
                break;
            }
        }

        $verifikasiRiwayat = $this->verifikasiModel->getByPindahan($idPindahan);

        $webModel = new TblWebModel();
        $web = $webModel->find(1) ?? [];

        // Smart alert sederhana
        $smartAlert = null;
        if (($pindahan['status_verifikasi'] ?? '') === 'Ditolak' || $hasRejectedBerkas) {
            $smartAlert = [
                'type'      => 'danger',
                'icon'      => 'error',
                'title'     => 'Perhatian: Dokumen Ditolak',
                'message'   => !empty($pindahan['catatan_verifikasi'])
                    ? 'Catatan Verifikator: "' . esc($pindahan['catatan_verifikasi']) . '". Silakan periksa dan unggah ulang dokumen.'
                    : 'Beberapa berkas persyaratan Anda ditolak. Silakan periksa dan perbaiki.',
                'btn_text'  => 'Perbaiki Berkas',
                'btn_url'   => base_url('siswa/pindahan/berkas'),
                'btn_color' => 'bg-red-600 hover:bg-red-700',
            ];
        } elseif ($completionPct < 100) {
            $smartAlert = [
                'type'      => 'warning',
                'icon'      => 'warning',
                'title'     => 'Kelengkapan Biodata Masih ' . $completionPct . '%',
                'message'   => 'Lengkapi data identitas, alamat, orang tua, sekolah asal pindahan, serta nilai rapor.',
                'btn_text'  => 'Lengkapi Biodata',
                'btn_url'   => base_url('siswa/pindahan/biodata'),
                'btn_color' => 'bg-amber-600 hover:bg-amber-700',
            ];
        } elseif (!$berkasWajib['lengkap']) {
            $smartAlert = [
                'type'      => 'info',
                'icon'      => 'cloud_upload',
                'title'     => 'Unggah Berkas Pindahan (' . $berkasWajib['sudah'] . '/' . $berkasWajib['total'] . ')',
                'message'   => 'Biodata lengkap! Segera unggah dokumen pindahan (surat pindah, KK, ijazah, surat pernyataan, foto) untuk diverifikasi.',
                'btn_text'  => 'Unggah Berkas',
                'btn_url'   => base_url('siswa/pindahan/berkas'),
                'btn_color' => 'bg-brand-600 hover:bg-brand-700',
            ];
        } elseif (($pindahan['status_verifikasi'] ?? '') === 'Menunggu') {
            $smartAlert = [
                'type'      => 'info',
                'icon'      => 'hourglass_top',
                'title'     => 'Pendaftaran Berhasil Dikirim',
                'message'   => 'Seluruh data dan berkas telah lengkap! Data Anda sedang dalam antrean verifikasi panitia.',
                'btn_text'  => 'Pantau Status',
                'btn_url'   => base_url('siswa/pindahan/status'),
                'btn_color' => 'bg-indigo-600 hover:bg-indigo-700',
            ];
        }

        $data = [
            'layout'            => 'pindahan/layouts/siswa_pindahan',
            'page_title'        => 'Dashboard Siswa Pindahan',
            'pindahan'          => $pindahan,
            'completionPercentage' => $completionPct,
            'incompleteFields'  => $completionData['incomplete'],
            'web'               => $web,
            'berkasList'        => $berkasList,
            'berkasWajib'       => $berkasWajib,
            'requiredDocs'      => $requiredDocs,
            'tagihanBerkas'     => $tagihanBerkas,
            'verifikasiRiwayat' => $verifikasiRiwayat,
            'smartAlert'        => $smartAlert,
        ];

        return view('pindahan/siswa/dashboard', $data);
    }

    // ─────────────────────────────────────────────────────────────
    // BIODATA (7 STEP WIZARD)
    // ─────────────────────────────────────────────────────────────
    public function biodata()
    {
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);

        if (!$pindahan) {
            session()->setFlashdata('error', 'Data pendaftaran pindahan tidak ditemukan.');
            return redirect()->to('/logout');
        }

        $completionData = $this->pindahanModel->calculateCompletionPercentage($pindahan);

        $penghasilan = $this->penghasilanModel->getAllOrdered();
        $pekerjaan   = $this->pekerjaanModel->getAllOrdered();
        $webModel = new TblWebModel();
        $web = $webModel->find(1);

        $berkas = $this->berkasModel->getByPindahan($idPindahan);
        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'layout'               => 'pindahan/layouts/siswa_pindahan',
            'page_title'           => 'Biodata Siswa Pindahan',
            'pindahan'             => $pindahan,
            'penghasilan'          => $penghasilan,
            'pekerjaan'            => $pekerjaan,
            'web'                  => $web,
            'completionPercentage' => $completionData['percentage'],
            'incompleteFields'     => $completionData['incomplete'],
            'requiredDocs'         => BerkasPindahanModel::getJenisBerkasOptions(),
            'uploadedBerkas'       => $uploadedBerkas,
            'semuaJenjang'         => PindahanConfig::getAllJenjang(),
            'kategoriAlasan'       => PindahanConfig::$kategoriAlasanPindah,
            'mapelRapor'           => PindahanConfig::$mapelRapor,
            'formAction'           => '/siswa/pindahan/biodata/update',
        ];

        return view('pindahan/siswa/biodata/index', $data);
    }

    /**
     * Wrapper untuk backward compatibility — delegasi ke PindahanService.
     */
    protected function getSanitizedBiodata(?array $raw = null): array
    {
        $data = $raw ?? $this->request->getPost();
        return $this->pindahanService->sanitizeBiodata($data);
    }

    public function updateBiodata()
    {
        $idPindahan = session()->get('id_siswa');
        if (!$idPindahan) {
            return redirect()->to('/login');
        }

        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $data = $this->pindahanService->sanitizeBiodata($this->request->getPost());
        $data = $this->pindahanService->normalizeJenjangData($data);
        $data = $this->pindahanService->hitungRataRata($data);

        // NIK unik (jika diisi)
        if (!empty($data['nik']) && $this->pindahanService->nikTerdaftar($data['nik'], (int) $idPindahan)) {
            session()->setFlashdata('error', 'NIK ' . esc($data['nik']) . ' sudah terdaftar pada pendaftar lain.');
            return redirect()->back()->withInput();
        }

        if ($this->pindahanModel->update($idPindahan, $data)) {
            $namaSiswa = $data['nama_lengkap'] ?? ($pindahan['nama_lengkap'] ?? 'ID ' . $idPindahan);
            catat_log('Update Biodata Pindahan', "Siswa pindahan $namaSiswa memperbarui biodata");
            session()->setFlashdata('success', 'Data biodata pindahan berhasil diperbarui.');
        } else {
            $errors = $this->pindahanModel->errors();
            $msg = !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui data biodata.';
            session()->setFlashdata('error', $msg);
        }

        return redirect()->to('/siswa/pindahan/biodata');
    }

    public function autoSave()
    {
        $idPindahan = session()->get('id_siswa');
        if (!$idPindahan) {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $raw = $this->request->is('json') ? $this->request->getJSON(true) : $this->request->getPost();
        $data = $this->pindahanService->sanitizeBiodata($raw);
        $data = $this->pindahanService->normalizeJenjangData($data);
        $data = $this->pindahanService->hitungRataRata($data);

        if (!empty($data)) {
            $this->pindahanModel->update($idPindahan, $data);
            $pindahan = $this->pindahanModel->find($idPindahan);
            $completionData = $this->pindahanModel->calculateCompletionPercentage($pindahan);
            return $this->response->setJSON([
                'success'    => true,
                'message'    => 'Draft tersimpan otomatis',
                'percentage' => $completionData['percentage'],
                'incomplete' => $completionData['incomplete'],
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada perubahan yang diproses']);
    }

    public function finalize()
    {
        $idPindahan = session()->get('id_siswa');
        if (!$idPindahan) {
            return redirect()->to('/login');
        }

        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $result = $this->pindahanService->doFinalize((int) $idPindahan);

        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);

        if ($result['success']) {
            catat_log('Finalisasi Biodata Pindahan', "Siswa pindahan {$result['namaSiswa']} memfinalisasi biodata (Final)");
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'     => $result['success'],
                'message'     => $result['message'],
                'offer_print' => $result['success'] ? true : false,
            ]);
        }

        return redirect()->to('/siswa/pindahan/biodata');
    }

    // ─────────────────────────────────────────────────────────────
    // BERKAS
    // ─────────────────────────────────────────────────────────────
    public function berkas()
    {
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);

        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $berkasList = $this->berkasModel->getByPindahan($idPindahan);
        $uploadedBerkas = [];
        foreach ($berkasList as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'layout'        => 'pindahan/layouts/siswa_pindahan',
            'page_title'    => 'Upload Berkas Pindahan',
            'pindahan'      => $pindahan,
            'requiredDocs'  => BerkasPindahanModel::getJenisBerkasOptions(),
            'uploadedBerkas'=> $uploadedBerkas,
            'berkasWajib'   => $this->berkasModel->isWajibLengkap($idPindahan, $berkasList),
        ];

        return view('pindahan/siswa/berkas/index', $data);
    }

    public function uploadBerkas()
    {
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            session()->setFlashdata('error', 'Data pendaftaran pindahan tidak ditemukan.');
            return redirect()->back();
        }

        $jenisBerkas = strtolower(trim((string) $this->request->getPost('jenis_berkas')));
        $file = $this->request->getFile('file_berkas');
        if (!$file || !$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid atau belum dipilih.');
            return redirect()->back();
        }

        $result = $this->pindahanService->doUploadBerkas($idPindahan, $file, $jenisBerkas, $pindahan);

        if ($result['success']) {
            catat_log('Upload Berkas Pindahan', "Siswa pindahan {$pindahan['nama_lengkap']} mengupload {$jenisBerkas}");
            session()->setFlashdata('success', $result['message']);
        } else {
            session()->setFlashdata('error', $result['message']);
        }

        return redirect()->to('/siswa/pindahan/berkas');
    }

    public function deleteBerkas($id)
    {
        $idPindahan = session()->get('id_siswa');
        $result = $this->pindahanService->doDeleteBerkas((int) $id, (int) $idPindahan);

        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);
        return redirect()->to('/siswa/pindahan/berkas');
    }

    // ─────────────────────────────────────────────────────────────
    // STATUS
    // ─────────────────────────────────────────────────────────────
    public function status()
    {
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $verifikasiRiwayat = $this->verifikasiModel->getByPindahan($idPindahan);
        $berkasWajib = $this->berkasModel->isWajibLengkap($idPindahan);

        $data = [
            'layout'        => 'pindahan/layouts/siswa_pindahan',
            'page_title'    => 'Status Pendaftaran',
            'pindahan'      => $pindahan,
            'verifikasiRiwayat' => $verifikasiRiwayat,
            'berkasWajib'   => $berkasWajib,
        ];

        return view('pindahan/siswa/status/index', $data);
    }

    // ─────────────────────────────────────────────────────────────
    // CETAK
    // ─────────────────────────────────────────────────────────────
    public function cetakFormulir()
    {
        helper('kop');
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $webModel = new TblWebModel();
        $web = $webModel->find(1);

        $data = [
            'pindahan' => $pindahan,
            'web'      => $web,
            'berkas'   => $this->berkasModel->getByPindahan($idPindahan),
        ];

        return view('pindahan/siswa/cetak_formulir', $data);
    }

    public function cetakKartu()
    {
        $idPindahan = session()->get('id_siswa');
        $pindahan = $this->pindahanModel->find($idPindahan);
        if (!$pindahan) {
            return redirect()->to('/logout');
        }

        $webModel = new TblWebModel();
        $layoutModel = new \App\Models\LayoutKartuModel();
        $qrModel = new \App\Models\SettingQrModel();
        $ttdModel = new \App\Models\TandaTanganModel();
        $printerModel = new \App\Models\SettingPrinterModel();

        $data = [
            'pindahan'   => $pindahan,
            'instansi'   => $webModel->first() ?? [],
            'layout'     => $layoutModel->first() ?? [],
            'qr'         => $qrModel->first() ?? [],
            'ttd'        => $ttdModel->first() ?? [],
            'printer'    => $printerModel->first() ?? [],
            'fotoBerkas' => $this->berkasModel->where('id_pindahan', $idPindahan)->where('jenis_berkas', 'foto_siswa')->first(),
        ];

        return view('pindahan/siswa/cetak_kartu', $data);
    }
}