<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'tbl_siswa';

    /**
     * Dapatkan tahun pelajaran aktif dari tabel pengaturan tbl_web
     */
    public function getActiveThPelajaran(): string
    {
        $db = \Config\Database::connect();
        $web = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();
        return !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';
    }

    private function applyThFilter($query, $thPelajaran)
    {
        if ($thPelajaran === null) {
            $thPelajaran = $this->getActiveThPelajaran();
        }
        if ($thPelajaran !== 'all') {
            $query->where('th_pelajaran', $thPelajaran);
        }
        return $query;
    }

    /**
     * Dapatkan ringkasan statistik umum
     */
    public function getStatistikUmum($thPelajaran = null)
    {
        $th = ($thPelajaran === null) ? $this->getActiveThPelajaran() : $thPelajaran;

        $q = function() use ($th) {
            $m = new self();
            if ($th !== 'all') {
                $m->where('th_pelajaran', $th);
            }
            return $m;
        };

        return [
            'total_pendaftar' => $q()->countAllResults(),
            'terverifikasi'   => $q()->where('status_verifikasi', 'Terverifikasi')->countAllResults(),
            'menunggu'        => $q()->groupStart()
                                    ->where('status_verifikasi', 'Menunggu')
                                    ->orWhere('status_verifikasi IS NULL')
                                    ->orWhere('status_verifikasi', '')
                                 ->groupEnd()->countAllResults(),
            'ditolak'         => $q()->where('status_verifikasi', 'Ditolak')->countAllResults(),
        ];
    }

    /**
     * Statistik Kelulusan
     */
    public function getKelulusan($thPelajaran = null)
    {
        $th = ($thPelajaran === null) ? $this->getActiveThPelajaran() : $thPelajaran;

        $q = function() use ($th) {
            $m = new self();
            if ($th !== 'all') {
                $m->where('th_pelajaran', $th);
            }
            return $m;
        };

        return [
            'lulus'       => $q()->where('status_lulus', 'Lulus')->countAllResults(),
            'tidak_lulus' => $q()->where('status_lulus', 'Tidak Lulus')->countAllResults(),
            'belum_diproses' => $q()->groupStart()
                                    ->where('status_lulus', 'Pending')
                                    ->orWhere('status_lulus', '')
                                    ->orWhere('status_lulus IS NULL')
                                 ->groupEnd()->countAllResults(),
        ];
    }

    /**
     * Statistik Demografi (Jenis Kelamin)
     */
    public function getGenderStats($thPelajaran = null)
    {
        $th = ($thPelajaran === null) ? $this->getActiveThPelajaran() : $thPelajaran;

        $q = function() use ($th) {
            $m = new self();
            if ($th !== 'all') {
                $m->where('th_pelajaran', $th);
            }
            return $m;
        };

        return [
            'L' => $q()->where('jk', 'L')->countAllResults(),
            'P' => $q()->where('jk', 'P')->countAllResults()
        ];
    }

    /**
     * Statistik Jalur Pendaftaran
     */
    public function getJalurPendaftaranStats($thPelajaran = null)
    {
        $builder = $this->select('jalur_pendaftaran, COUNT(*) as total');
        $this->applyThFilter($builder, $thPelajaran);
        $query = $builder->groupBy('jalur_pendaftaran')->findAll();
        
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
    public function getTopSekolah($thPelajaran = null)
    {
        $builder = $this->select('nama_sekolah, COUNT(*) as total')
                    ->where('nama_sekolah IS NOT NULL')
                    ->where('nama_sekolah !=', '');
        $this->applyThFilter($builder, $thPelajaran);
        return $builder->groupBy('nama_sekolah')
                    ->orderBy('total', 'DESC')
                    ->limit(5)
                    ->findAll();
    }

    /**
     * Top Sebaran Wilayah berdasarkan Kecamatan (5 Terbanyak)
     */
    public function getTopWilayah($thPelajaran = null)
    {
        $builder = $this->select('kec, COUNT(*) as total')
                    ->where('kec IS NOT NULL')
                    ->where('kec !=', '');
        $this->applyThFilter($builder, $thPelajaran);
        return $builder->groupBy('kec')
                    ->orderBy('total', 'DESC')
                    ->limit(5)
                    ->findAll();
    }
}
