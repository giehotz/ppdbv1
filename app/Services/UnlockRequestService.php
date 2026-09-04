<?php

namespace App\Services;

use App\Models\UnlockRequestModel;
use App\Models\SiswaModel;

class UnlockRequestService
{
    protected UnlockRequestModel $unlockModel;
    protected SiswaModel $siswaModel;

    public function __construct(?UnlockRequestModel $unlockModel = null, ?SiswaModel $siswaModel = null)
    {
        $this->unlockModel = $unlockModel ?? new UnlockRequestModel();
        $this->siswaModel  = $siswaModel ?? new SiswaModel();
    }

    public function getPendingRequests(): array
    {
        return $this->unlockModel->getPendingRequests();
    }

    /**
     * Setujui permohonan buka kunci formulir biodata siswa
     *
     * @param int|string $idRequest
     * @param string $actor Nama user yang menyetujui
     * @return array ['success' => bool, 'message' => string]
     */
    public function approve($idRequest, string $actor = 'Admin'): array
    {
        $request = $this->unlockModel->find($idRequest);
        if (!$request) {
            return [
                'success' => false,
                'message' => 'Data permohonan tidak ditemukan.'
            ];
        }

        // 1. Update status request
        if ($this->unlockModel->update($idRequest, ['status' => 'Disetujui'])) {
            // 2. Kosongkan status_pendaftaran siswa agar kunci terbuka
            $this->siswaModel->update($request['id_siswa'], ['status_pendaftaran' => '']);
            
            $siswa = $this->siswaModel->find($request['id_siswa']);
            $namaSiswa = $siswa['nama_lengkap'] ?? "ID {$request['id_siswa']}";
            
            if (function_exists('catat_log')) {
                catat_log('Buka Kunci Biodata', "$actor menyetujui permohonan buka kunci biodata untuk siswa: $namaSiswa");
            }

            return [
                'success' => true,
                'message' => 'Permohonan disetujui. Formulir biodata siswa telah dibuka kembali.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal memproses persetujuan permohonan.'
        ];
    }

    /**
     * Tolak permohonan buka kunci formulir biodata siswa
     *
     * @param int|string $idRequest
     * @param string $actor Nama user yang menolak
     * @return array ['success' => bool, 'message' => string]
     */
    public function reject($idRequest, string $actor = 'Admin'): array
    {
        $request = $this->unlockModel->find($idRequest);
        if (!$request) {
            return [
                'success' => false,
                'message' => 'Data permohonan tidak ditemukan.'
            ];
        }

        if ($this->unlockModel->update($idRequest, ['status' => 'Ditolak'])) {
            $siswa = $this->siswaModel->find($request['id_siswa']);
            $namaSiswa = $siswa['nama_lengkap'] ?? "ID {$request['id_siswa']}";

            if (function_exists('catat_log')) {
                catat_log('Buka Kunci Biodata', "$actor menolak permohonan buka kunci biodata untuk siswa: $namaSiswa");
            }

            return [
                'success' => true,
                'message' => 'Permohonan ditolak. Formulir biodata siswa tetap terkunci.'
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal menolak permohonan.'
        ];
    }
}
