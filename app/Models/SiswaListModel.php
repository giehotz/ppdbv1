<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaListModel extends Model
{
    protected $table            = 'tbl_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['is_checked'];

    protected $useTimestamps = false;
    protected $deletedField  = 'deleted_at';

    /**
     * Dapatkan tahun pelajaran aktif dari tbl_web
     */
    public function getActiveThPelajaran(): string
    {
        $db  = \Config\Database::connect();
        $web = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();
        return !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';
    }

    /**
     * Ambil semua siswa aktif (deleted_at IS NULL) terurut alfabetis,
     * difilter berdasarkan tahun pelajaran aktif.
     */
    public function getAllSiswaAktif(): array
    {
        $thPelajaran = $this->getActiveThPelajaran();

        return $this->select(
                'id_siswa, no_pendaftaran, nis, nisn, nik, nama_lengkap, jk, '
              . 'tempat_lahir, tgl_lahir, agama, jml_saudara, anak_ke, cita, hobi, '
              . 'paud, tk, no_kk, kepala_keluarga, '
              . 'nama_ayah, nik_ayah, tempat_lahir_ayah, tgl_lahir_ayah, pdd_ayah, pekerjaan_ayah, '
              . 'nama_ibu, nik_ibu, tempat_lahir_ibu, tgl_lahir_ibu, pdd_ibu, pekerjaan_ibu, '
              . 'no_hp_ortu, alamat_siswa, prov, kab, kec, desa, kode_pos, '
              . 'is_checked'
            )
            ->where('th_pelajaran', $thPelajaran)
            ->orderBy('nama_lengkap', 'ASC')
            ->findAll();
    }

    /**
     * Update status is_checked untuk 1 siswa
     */
    public function updateChecklistById(int $id_siswa, int $status): bool
    {
        return $this->where('id_siswa', $id_siswa)
                    ->set(['is_checked' => $status])
                    ->update();
    }

    /**
     * Batch update is_checked untuk semua siswa aktif
     */
    public function updateAllChecklist(int $status): bool
    {
        $thPelajaran = $this->getActiveThPelajaran();

        return $this->where('deleted_at', null)
                    ->where('th_pelajaran', $thPelajaran)
                    ->set(['is_checked' => $status])
                    ->update();
    }
}
