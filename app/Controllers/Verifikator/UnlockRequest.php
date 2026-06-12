<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\UnlockRequestModel;
use App\Models\SiswaModel;

class UnlockRequest extends BaseController
{
    protected $unlockModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->unlockModel = new UnlockRequestModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'requests' => $this->unlockModel->getPendingRequests()
        ];

        return view('verifikator/unlock_requests/index', $data);
    }

    public function approve($idRequest)
    {
        $request = $this->unlockModel->find($idRequest);
        if (!$request) {
            session()->setFlashdata('error', 'Data permohonan tidak ditemukan.');
            return redirect()->to('/verifikator/unlockrequest');
        }

        // 1. Update status request
        if ($this->unlockModel->update($idRequest, ['status' => 'Disetujui'])) {
            // 2. Kosongkan status_pendaftaran siswa agar kunci terbuka
            $this->siswaModel->update($request['id_siswa'], ['status_pendaftaran' => '']);
            session()->setFlashdata('success', 'Permohonan disetujui. Formulir biodata siswa telah dibuka kembali.');
        } else {
            session()->setFlashdata('error', 'Gagal memproses persetujuan permohonan.');
        }

        return redirect()->to('/verifikator/unlockrequest');
    }

    public function reject($idRequest)
    {
        $request = $this->unlockModel->find($idRequest);
        if (!$request) {
            session()->setFlashdata('error', 'Data permohonan tidak ditemukan.');
            return redirect()->to('/verifikator/unlockrequest');
        }

        if ($this->unlockModel->update($idRequest, ['status' => 'Ditolak'])) {
            session()->setFlashdata('success', 'Permohonan ditolak. Formulir biodata siswa tetap terkunci.');
        } else {
            session()->setFlashdata('error', 'Gagal menolak permohonan.');
        }

        return redirect()->to('/verifikator/unlockrequest');
    }
}
