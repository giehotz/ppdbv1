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
            return redirect()->to('/siswa/dashboard');
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

        $completionData = $siswaModel->calculateCompletionPercentage($siswa);

        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);

        $data = [
            'siswa' => $siswa,
            'pendingRequest' => $pendingRequest,
            'requiredDocs' => $requiredDocs,
            'uploadedBerkas' => $uploadedBerkas,
            'penghasilan' => $penghasilan,
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
}
