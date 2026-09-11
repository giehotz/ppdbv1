<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\Pindahan\SiswaPindahanModel;
use App\Models\Pindahan\BerkasPindahanModel;
use App\Models\Pindahan\VerifikasiPindahanModel;
use App\Models\PenghasilanModel;
use App\Models\PekerjaanModel;
use App\Models\TblWebModel;
use App\Services\PindahanService;
use Config\PindahanConfig;

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

    public function index()
    {
        $search     = $this->request->getGet('search');
        $activeTh   = $this->pindahanModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;
        $tab        = $this->request->getGet('tab') ?? 'all';

        $siswaList = $this->pindahanModel->getStudents($search, 20, 'ASC', $selectedTh, $tab);
        foreach ($siswaList as &$s) {
            $s['kelengkapan'] = $this->pindahanModel->getCompletionPercentageOnly($s);
            $s['foto_url']    = $this->pindahanService->resolvePhotoUrl($s['foto'] ?? null);
        }
        unset($s);

        $tahunModel = new \App\Models\TahunPelajaranModel();
        $tahunList  = $tahunModel->orderBy('id_tahun', 'DESC')->findAll();

        $data = [
            'layout'       => 'layouts/verifikator',
            'page_title'   => 'Data Siswa Pindahan',
            'siswa'        => $siswaList,
            'pager'        => $this->pindahanModel->pager,
            'search'       => $search,
            'selectedTh'   => $selectedTh,
            'activeTh'     => $activeTh,
            'tahunList'    => $tahunList,
            'currentTab'   => $tab,
            'statusCounts' => $this->pindahanModel->getStatusCounts($selectedTh),
        ];

        return view('pindahan/verifikator/index', $data);
    }

    public function create()
    {
        $createdIds = session()->get('verifikator_created_pindahan') ?? [];
        $siswaList = [];
        if (!empty($createdIds)) {
            $siswaList = $this->pindahanModel
                ->whereIn('id_pindahan', $createdIds)
                ->orderBy('id_pindahan', 'DESC')
                ->findAll();
        } else {
            $siswaList = $this->pindahanModel
                ->orderBy('id_pindahan', 'DESC')
                ->findAll(10);
        }

        foreach ($siswaList as &$s) {
            $s['kelengkapan'] = $this->pindahanModel->getCompletionPercentageOnly($s);
        }
        unset($s);

        $data = [
            'layout'       => 'layouts/verifikator',
            'page_title'   => 'Pendaftaran Offline Siswa Pindahan',
            'siswaList'    => $siswaList,
            'semuaJenjang' => PindahanConfig::getAllJenjang(),
        ];

        return view('pindahan/verifikator/create', $data);
    }

    public function store()
    {
        $session = session();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nisn'          => 'required|numeric|min_length[10]|max_length[10]|is_unique[tbl_siswa_pindahan.nisn]',
            'nama_lengkap'  => 'required|min_length[3]',
            'email'         => 'required|valid_email|is_unique[tbl_siswa_pindahan.email]',
            'no_hp'         => 'required|min_length[8]|max_length[16]|regex_match[/^[0-9+\-\s]+$/]',
            'password'      => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'jenjang_sekolah_asal'   => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $session->setFlashdata('errors', $validation->getErrors());
            return redirect()->to('/verifikator/pindahan/create')->withInput();
        }

        $result = $this->pindahanService->createOffline($this->request->getPost());

        if (!$result['success']) {
            $session->setFlashdata('error', $result['message']);
            return redirect()->to('/verifikator/pindahan/create')->withInput();
        }

        $insertId = $result['insertId'];
        $plainPassword = $result['plainPassword'];
        $noPendaftaran = $result['noPendaftaran'];

        session()->set('pindahan_pwd_' . $insertId, $plainPassword);
        $createdIds = session()->get('verifikator_created_pindahan') ?? [];
        $createdIds[] = $insertId;
        session()->set('verifikator_created_pindahan', $createdIds);

        catat_log('Pendaftaran Offline Pindahan', 'Verifikator ' . (session()->get('nama_lengkap') ?: '-') . ' mendaftarkan siswa pindahan: ' . $this->request->getPost('nama_lengkap'));

        $session->setFlashdata('success', $result['message']);
        return redirect()->to('/verifikator/pindahan/create');
    }

    public function detail($id)
    {
        $siswa = $this->pindahanModel->getStudentDetail($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/verifikator/pindahan');
        }

        $comp = $this->pindahanModel->calculateCompletionPercentage($siswa);
        $siswa['kelengkapan'] = $comp['percentage'];
        $siswa['incomplete_fields'] = $comp['incomplete'];
        $siswa['foto_url'] = $this->pindahanService->resolvePhotoUrl($siswa['foto'] ?? null);

        $berkasList = $this->berkasModel->getByPindahan($id);
        $verifikasiRiwayat = $this->verifikasiModel->getByPindahan($id);

        $data = [
            'layout'       => 'layouts/verifikator',
            'page_title'   => 'Detail Siswa Pindahan',
            'siswa'        => $siswa,
            'berkasList'   => $berkasList,
            'verifikasiRiwayat' => $verifikasiRiwayat,
            'berkasWajib'  => $this->berkasModel->isWajibLengkap($id, $berkasList),
        ];

        return view('pindahan/verifikator/detail', $data);
    }

    public function biodata($id)
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/verifikator/pindahan');
        }

        $penghasilan = $this->penghasilanModel->getAllOrdered();
        $pekerjaan   = $this->pekerjaanModel->getAllOrdered();
        $webModel = new TblWebModel();
        $web = $webModel->find(1);

        $comp = $this->pindahanModel->calculateCompletionPercentage($siswa);

        $berkas = $this->berkasModel->getByPindahan($id);
        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'layout'               => 'layouts/verifikator',
            'page_title'           => 'Edit Biodata Siswa Pindahan',
            'pindahan'             => $siswa,
            'penghasilan'          => $penghasilan,
            'pekerjaan'            => $pekerjaan,
            'web'                  => $web,
            'completionPercentage' => $comp['percentage'],
            'incompleteFields'     => $comp['incomplete'],
            'requiredDocs'         => BerkasPindahanModel::getJenisBerkasOptions(),
            'uploadedBerkas'       => $uploadedBerkas,
            'semuaJenjang'         => PindahanConfig::getAllJenjang(),
            'kategoriAlasan'       => PindahanConfig::$kategoriAlasanPindah,
            'mapelRapor'           => PindahanConfig::$mapelRapor,
            'formAction'           => '/verifikator/pindahan/biodataStore/' . $id,
            'uploadUrl'            => '/verifikator/pindahan/berkasUpload/' . $id,
            'deleteUrl'            => '/verifikator/pindahan/berkasDelete/',
            'isVerifikator'        => true,
        ];

        return view('pindahan/siswa/biodata/index', $data);
    }

    public function biodataStore($id)
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/verifikator/pindahan');
        }

        $data = $this->request->getPost();

        $restrictedFields = [
            'id_pindahan', 'id_siswa', 'no_pendaftaran', 'password', 'last_login',
            'status_verifikasi', 'status_pendaftaran', 'status_berkas', 'status_lulus',
            'tgl_verifikasi', 'verified_by', 'catatan_verifikasi',
            'jalur_pendaftaran', 'tgl_pindahan', 'is_checked',
            'csrf_test_name', 'finish_skip'
        ];
        foreach ($restrictedFields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }

        // Normalisasi jenjang via service
        $data = $this->pindahanService->normalizeJenjangData($data);

        // Hitung rata-rata nilai via service
        $data = $this->pindahanService->hitungRataRata($data);

        if (!empty($data['nik'])) {
            $nikClean = preg_replace('/[^0-9]/', '', (string) $data['nik']);
            if ($this->pindahanService->nikTerdaftar($nikClean, (int) $id)) {
                session()->setFlashdata('error', 'NIK ' . esc($data['nik']) . ' sudah terdaftar pada pendaftar lain.');
                return redirect()->back()->withInput();
            }
        }

        if ($this->pindahanModel->update($id, $data)) {
            $namaSiswa = $data['nama_lengkap'] ?? $siswa['nama_lengkap'];
            catat_log('Update Biodata Pindahan (Verifikator)', "Verifikator " . session()->get('nama_lengkap') . " memperbarui data biodata siswa pindahan: $namaSiswa (ID $id)");
            session()->setFlashdata('success', 'Data biodata pindahan berhasil disimpan.');
        } else {
            $errors = $this->pindahanModel->errors();
            $msg = !empty($errors) ? implode(', ', $errors) : 'Gagal memperbarui data biodata ke database.';
            session()->setFlashdata('error', $msg);
        }

        if ($this->request->getPost('finish_skip')) {
            return redirect()->to('/verifikator/pindahan/cetak-akun/' . $id);
        }

        return redirect()->to('/verifikator/pindahan/biodata/' . $id);
    }

    public function berkas($id)
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/verifikator/pindahan');
        }

        $berkasList = $this->berkasModel->getByPindahan($id);
        $uploadedBerkas = [];
        foreach ($berkasList as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'layout'        => 'layouts/verifikator',
            'page_title'    => 'Kelola Berkas Siswa Pindahan',
            'siswa'         => $siswa,
            'requiredDocs'  => BerkasPindahanModel::getJenisBerkasOptions(),
            'uploadedBerkas'=> $uploadedBerkas,
            'berkasWajib'   => $this->berkasModel->isWajibLengkap($id, $berkasList),
        ];

        return view('pindahan/verifikator/berkas', $data);
    }

    public function berkasUpload($id)
    {
        $pindahan = $this->pindahanModel->find($id);
        if (!$pindahan) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->back();
        }

        $jenisBerkas = strtolower(trim((string) $this->request->getPost('jenis_berkas')));
        $file = $this->request->getFile('file_berkas');
        if (!$file || !$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid atau belum dipilih.');
            return redirect()->back();
        }

        $result = $this->pindahanService->doUploadBerkas((int) $id, $file, $jenisBerkas, $pindahan);
        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);
        return redirect()->back();
    }

    public function berkasDelete($idBerkas)
    {
        $result = $this->pindahanService->doDeleteBerkas((int) $idBerkas);
        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);
        return redirect()->back();
    }

    public function verify($id)
    {
        $status  = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');
        $actorName = session()->get('nama_lengkap') ?: 'Verifikator';

        $result = $this->pindahanService->doVerify((int) $id, $status, $catatan, $actorName, 'Verifikator');

        session()->setFlashdata($result['success'] ? 'success' : 'error', $result['message']);
        return redirect()->to('/verifikator/pindahan/detail/' . $id);
    }

    public function cetakAkun($id)
    {
        helper('kop');
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa pindahan tidak ditemukan.');
            return redirect()->to('/verifikator/pindahan');
        }

        $siswa['password_asli'] = session()->get('pindahan_pwd_' . $id);
        session()->remove('pindahan_pwd_' . $id);

        return view('pindahan/verifikator/cetak_akun', ['siswa' => $siswa]);
    }

    public function delete($id)
    {
        $result = $this->pindahanService->deletePindahanPermanently((int) $id);

        if (!$result['success']) {
            session()->setFlashdata('error', $result['message']);
            if ($result['siswa'] !== null) {
                return redirect()->to('/verifikator/pindahan/detail/' . $id);
            }
            return redirect()->to('/verifikator/pindahan');
        }

        catat_log('Hapus Siswa Pindahan', 'Verifikator ' . (session()->get('nama_lengkap') ?: '-') . ' menghapus permanen siswa pindahan: ' . ($result['siswa']['nama_lengkap'] ?? $id));

        session()->setFlashdata('success', $result['message']);
        return redirect()->to('/verifikator/pindahan');
    }
}