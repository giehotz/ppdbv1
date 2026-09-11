<?php

namespace App\Models\Pindahan;

use CodeIgniter\Model;

class VerifikasiPindahanModel extends Model
{
    protected $table            = 'tbl_verifikasi_pindahan';
    protected $primaryKey       = 'id_verifikasi_pindahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pindahan',
        'isi',
        'ket',
        'tgl_verifikasi',
        'verifikator'
    ];

    protected $useTimestamps = false;

    /**
     * Get semua riwayat verifikasi seorang siswa pindahan.
     */
    public function getByPindahan($idPindahan)
    {
        return $this->where('id_pindahan', $idPindahan)
            ->orderBy('tgl_verifikasi', 'DESC')
            ->findAll();
    }

    /**
     * Get catatan verifikasi terbaru seorang siswa pindahan.
     */
    public function getLatest($idPindahan)
    {
        return $this->where('id_pindahan', $idPindahan)
            ->orderBy('tgl_verifikasi', 'DESC')
            ->first();
    }

    /**
     * Catat log verifikasi baru.
     *
     * @param int   $idPindahan
     * @param array $data        [isi, ket, verifikator]
     *
     * @return int|false ID log baru
     */
    public function insertLog(int $idPindahan, array $data)
    {
        $log = [
            'id_pindahan'  => $idPindahan,
            'isi'          => $data['isi'] ?? null,
            'ket'          => $data['ket'] ?? null,
            'tgl_verifikasi' => date('Y-m-d H:i:s'),
            'verifikator'  => $data['verifikator'] ?? null,
        ];

        if ($this->insert($log)) {
            return $this->getInsertID();
        }

        return false;
    }

    /**
     * Hapus semua riwayat verifikasi seorang siswa pindahan.
     */
    public function deleteByPindahan($idPindahan): bool
    {
        return $this->where('id_pindahan', $idPindahan)->delete();
    }
}