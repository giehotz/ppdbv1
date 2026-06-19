<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'tbl_siswa';

    /**
     * Dapatkan ringkasan statistik umum
     */
    public function getStatistikUmum()
    {
        return [
            'total_pendaftar' => $this->countAll(),
            'terverifikasi'   => $this->where('status_verifikasi', 'Terverifikasi')->countAllResults(),
            'menunggu'        => $this->groupStart()
                                    ->where('status_verifikasi', 'Menunggu')
                                    ->orWhere('status_verifikasi IS NULL')
                                    ->orWhere('status_verifikasi', '')
                                 ->groupEnd()->countAllResults(),
            'ditolak'         => $this->where('status_verifikasi', 'Ditolak')->countAllResults(),
        ];
    }

    /**
     * Statistik Kelulusan
     */
    public function getKelulusan()
    {
        return [
            'lulus'       => $this->where('status_lulus', 'Lulus')->countAllResults(),
            'tidak_lulus' => $this->where('status_lulus', 'Tidak Lulus')->countAllResults(),
            'belum_diproses' => $this->groupStart()
                                    ->where('status_lulus', 'Pending')
                                    ->orWhere('status_lulus', '')
                                    ->orWhere('status_lulus IS NULL')
                                 ->groupEnd()->countAllResults(),
        ];
    }

    /**
     * Statistik Demografi (Jenis Kelamin)
     */
    public function getGenderStats()
    {
        return [
            'L' => $this->where('jk', 'L')->countAllResults(),
            'P' => $this->where('jk', 'P')->countAllResults()
        ];
    }

    /**
     * Statistik Jalur Pendaftaran
     */
    public function getJalurPendaftaranStats()
    {
        $query = $this->select('jalur_pendaftaran, COUNT(*) as total')
                      ->groupBy('jalur_pendaftaran')
                      ->findAll();
        
        $result = [];
        foreach ($query as $row) {
            $jalur = empty($row['jalur_pendaftaran']) ? 'Belum Memilih' : $row['jalur_pendaftaran'];
            $result[$jalur] = $row['total'];
        }
        return $result;
    }

    /**
     * Top Asal Sekolah (5 Terbanyak)
     */
    public function getTopSekolah()
    {
        return $this->select('nama_sekolah, COUNT(*) as total')
                    ->where('nama_sekolah IS NOT NULL')
                    ->where('nama_sekolah !=', '')
                    ->groupBy('nama_sekolah')
                    ->orderBy('total', 'DESC')
                    ->limit(5)
                    ->findAll();
    }

    /**
     * Top Sebaran Wilayah berdasarkan Kecamatan (5 Terbanyak)
     */
    public function getTopWilayah()
    {
        return $this->select('kec, COUNT(*) as total')
                    ->where('kec IS NOT NULL')
                    ->where('kec !=', '')
                    ->groupBy('kec')
                    ->orderBy('total', 'DESC')
                    ->limit(5)
                    ->findAll();
    }
}
