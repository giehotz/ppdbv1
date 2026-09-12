<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\UnlockRequestModel;
use App\Models\BerkasModel;

class Biodata extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/logout');
        }

        $unlockRequestModel = new UnlockRequestModel();
        $pendingRequest = $unlockRequestModel->where('id_siswa', $idSiswa)
            ->where('status', 'Pending')
            ->first();

        // Get uploaded berkas
        $berkasModel = new BerkasModel();
        $berkas = $berkasModel->where('id_siswa', $idSiswa)->findAll();

        // Define required documents
        $requiredDocs = [
            'kk' => 'Kartu Keluarga (KK)',
            'akte' => 'Akte Kelahiran',
            'ijazah' => 'Ijazah/SKHUN',
            'foto' => 'Pas Foto 3x4',
            'ktp_ortu' => 'KTP Orang Tua',
        ];

        // Map uploaded berkas by jenis
        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        // Get penghasilan data
        $db = \Config\Database::connect();
        $penghasilan = $db->table('tbl_penghasilan')->orderBy('urutan', 'ASC')->get()->getResultArray();

        // Get pekerjaan reference data
        $pekerjaan = $db->table('tbl_pekerjaan')->orderBy('urutan', 'ASC')->get()->getResultArray();

        $completionData = $siswaModel->calculateCompletionPercentage($siswa);

        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);

        $data = [
            'siswa' => $siswa,
            'pendingRequest' => $pendingRequest,
            'requiredDocs' => $requiredDocs,
            'uploadedBerkas' => $uploadedBerkas,
            'penghasilan' => $penghasilan,
            'pekerjaan' => $pekerjaan,
            'completionPercentage' => $completionData['percentage'],
            'incompleteFields' => $completionData['incomplete'],
            'web' => $web,
            'offer_print' => session()->getFlashdata('offer_print')
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/biodata', $data);
        }

        return view('siswa/biodata/index', $data);
    }

    public function update()
    {
        $siswaModel = new SiswaModel();
        $idSiswa = session()->get('id_siswa');

        // Get all POST data
        $data = $this->request->getPost();

        // Mencegah Mass Assignment: hapus field sensitif yang tidak boleh diubah siswa secara langsung
        $restrictedFields = [
            'id_siswa',
            'no_pendaftaran',
            'password',
            'status_verifikasi',
            'status_pendaftaran',
            'status_berkas',
            'status_lulus',
            'tgl_verifikasi',
            'verified_by',
            'catatan_verifikasi',
            'tgl_siswa'
        ];

        foreach ($restrictedFields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }
        
        // Unset legacy fields
        unset($data['th_lahir_ayah'], $data['th_lahir_ibu'], $data['th_lahir_wali']);

        // Konversi string kosong pada tanggal lahir menjadi null
        foreach (['tgl_lahir_ayah', 'tgl_lahir_ibu', 'tgl_lahir_wali'] as $df) {
            if (array_key_exists($df, $data) && ($data[$df] === '' || $data[$df] === '0000-00-00')) {
                $data[$df] = null;
            }
        }

        // Update student data
        if ($siswaModel->update($idSiswa, $data)) {
            session()->setFlashdata('success', 'Data biodata berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui data biodata.');
        }

        return redirect()->to('/siswa/biodata');
    }

    public function finalize()
    {
        $siswaModel = new SiswaModel();
        $idSiswa = session()->get('id_siswa');

        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        // Finalize student data by setting status_pendaftaran to 'Final'
        $dataToUpdate = [
            'status_pendaftaran' => 'Final'
        ];

        if ($siswaModel->update($idSiswa, $dataToUpdate)) {
            $namaSiswa = session()->get('nama_lengkap') ?? "ID $idSiswa";
            catat_log('Finalisasi Biodata', "Siswa $namaSiswa memfinalisasi formulir biodata (Status: Final)");

            $message = 'Data Biodata berhasil dikirim secara permanen (Final). Anda tidak dapat mengubahnya lagi.';
            session()->setFlashdata('success', $message);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'offer_print' => true
                ]);
            }
        } else {
            $message = 'Gagal memfinalisasi data biodata.';
            session()->setFlashdata('error', $message);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message
                ]);
            }
        }

        return redirect()->to('/siswa/biodata');
    }

    public function ajukanBukaKunci()
    {
        $idSiswa = session()->get('id_siswa');
        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        $alasan = $this->request->getPost('alasan') ?? '';

        if (trim($alasan) === '') {
            session()->setFlashdata('error', 'Alasan pengajuan buka kunci harus diisi.');
            return redirect()->back();
        }

        $unlockRequestModel = new UnlockRequestModel();

        // Cek jika sudah ada request pending untuk siswa ini
        $existingPending = $unlockRequestModel->where('id_siswa', $idSiswa)
            ->where('status', 'Pending')
            ->first();

        if ($existingPending) {
            session()->setFlashdata('error', 'Anda sudah memiliki pengajuan buka kunci yang sedang menunggu diproses Admin.');
            return redirect()->back();
        }

        // Insert request baru
        $dataToInsert = [
            'id_siswa'   => $idSiswa,
            'alasan'     => $alasan,
            'status'     => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($unlockRequestModel->insert($dataToInsert)) {
            $namaSiswa = session()->get('nama_lengkap') ?? "ID $idSiswa";
            catat_log('Pengajuan Buka Kunci', "Siswa $namaSiswa mengajukan buka kunci biodata: " . mb_substr($alasan, 0, 50));

            session()->setFlashdata('success', 'Permohonan buka kunci berhasil diajukan. Silakan tunggu Admin meninjaunya.');
        } else {
            session()->setFlashdata('error', 'Gagal mengajukan permohonan buka kunci.');
        }

        return redirect()->to('/siswa/biodata');
    }

    public function autoSave()
    {
        $siswaModel = new SiswaModel();
        $idSiswa = session()->get('id_siswa');
        
        if (!$idSiswa) {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Handle both JSON and standard POST bodies
        $data = $this->request->is('json') ? $this->request->getJSON(true) : $this->request->getPost();
        
        // Mencegah Mass Assignment sama seperti update()
        $restrictedFields = [
            'id_siswa', 'no_pendaftaran', 'password', 'status_verifikasi',
            'status_pendaftaran', 'status_berkas', 'status_lulus',
            'tgl_verifikasi', 'verified_by', 'catatan_verifikasi', 'tgl_siswa'
        ];

        foreach ($restrictedFields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }

        // Unset legacy fields
        unset($data['th_lahir_ayah'], $data['th_lahir_ibu'], $data['th_lahir_wali']);

        // Konversi string kosong pada tanggal lahir menjadi null
        foreach (['tgl_lahir_ayah', 'tgl_lahir_ibu', 'tgl_lahir_wali'] as $df) {
            if (array_key_exists($df, $data) && ($data[$df] === '' || $data[$df] === '0000-00-00')) {
                $data[$df] = null;
            }
        }

        // Only update if there is data to process
        if (!empty($data)) {
            if ($siswaModel->update($idSiswa, $data)) {
                // Return updated completion percentage
                $siswa = $siswaModel->find($idSiswa);
                $completionData = $siswaModel->calculateCompletionPercentage($siswa);
                
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Draft tersimpan secara otomatis',
                    'percentage' => $completionData['percentage'],
                    'incomplete' => $completionData['incomplete']
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false, 
            'message' => 'Tidak ada perubahan yang diproses'
        ]);
    }

    /**
     * Cari data sekolah dari API Kemdikbud/Kemenag (ikhsan-rfl/api-sekolah)
     * Dilengkapi server-side caching 24 jam untuk efisiensi dan respons cepat.
     * Mendukung pencarian via nama, NPSN, kode wilayah, dan filter bentuk_pendidikan.
     */
    public function searchSekolah()
    {
        $q = trim($this->request->getGet('q') ?? '');
        $bentuk = trim($this->request->getGet('bentuk') ?? $this->request->getGet('bentuk_pendidikan') ?? '');
        $kodeWilayah = trim($this->request->getGet('kode_wilayah') ?? '');
        $limit = (int) ($this->request->getGet('limit') ?? 20);
        if ($limit < 1 || $limit > 100) {
            $limit = 20;
        }

        if (mb_strlen($q) < 3 && empty($kodeWilayah)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kata kunci pencarian minimal 3 karakter',
                'data'    => [],
            ]);
        }

        $isNpsn = (bool) preg_match('/^[0-9]{8}$/', $q);
        $params = [];
        if ($isNpsn) {
            $params['npsn'] = $q;
        } else {
            if (!empty($kodeWilayah) && preg_match('/^[0-9]{2,6}$/', $kodeWilayah)) {
                $params['kode_wilayah'] = $kodeWilayah;
            }
            if (!empty($q)) {
                $params['nama'] = $q;
            }
            if (!empty($bentuk)) {
                $params['bentuk_pendidikan'] = strtoupper($bentuk);
            }
            $params['limit'] = $limit;
        }

        $queryString = http_build_query($params);
        $apiUrl = 'https://sekolah.devapi.id/sekolah?' . $queryString;

        $cacheKey = 'api_sekolah_' . md5($queryString);
        $cached = cache($cacheKey);
        if ($cached !== null) {
            return $this->response->setJSON($cached);
        }

        try {
            $client = \Config\Services::curlrequest([
                'timeout'     => 6,
                'headers'     => [
                    'Accept'     => 'application/json',
                    'User-Agent' => 'PPDB-App/1.0',
                ],
                'http_errors' => false,
            ]);

            $res = $client->get($apiUrl);
            if ($res->getStatusCode() === 200) {
                $body = json_decode($res->getBody(), true);
                if ($body && !empty($body['success'])) {
                    cache()->save($cacheKey, $body, 86400);
                    return $this->response->setJSON($body);
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'API Sekolah Error: ' . $e->getMessage());
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data sekolah tidak ditemukan atau server sedang sibuk',
            'data'    => [],
        ]);
    }
}

