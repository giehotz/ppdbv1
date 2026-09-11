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
     * Ambil tahun sebelumnya dari format "YYYY/YYYY" (mis. "2026/2027" -> "2025/2026").
     * Untuk data yang belum ada, hasil statistik otomatis 0.
     */
    public function getTahunSebelumnya(?string $thPelajaran = null): string
    {
        $th = $thPelajaran ?? $this->getActiveThPelajaran();
        [$awal, $akhir] = array_replace(['', ''], explode('/', $th));
        if ($awal === '' || $akhir === '') {
            return '';
        }
        return ($awal - 1) . '/' . ($akhir - 1);
    }

    /**
     * Perbandingan jumlah pendaftar tahun aktif vs tahun sebelumnya (total, L, P) + persentase.
     */
    public function getTrenPendaftar(?string $thPelajaran = null): array
    {
        $th   = $thPelajaran ?? $this->getActiveThPelajaran();
        $prev = $this->getTahunSebelumnya($th);

        $current = ['total' => 0, 'L' => 0, 'P' => 0];
        $before  = ['total' => 0, 'L' => 0, 'P' => 0];

        if ($prev !== '') {
            $before  = $this->getGenderStats($prev);
            $before['total'] = $before['L'] + $before['P'];
        }
        $current = $this->getGenderStats($th);
        $current['total'] = $current['L'] + $current['P'];

        $selisih = $current['total'] - $before['total'];
        $pct     = $before['total'] > 0 ? round($selisih / $before['total'] * 100, 1) : 0;

        // ponytail: denominator 0 -> laporkan 0%, bukan null/error
        return [
            'th_active'  => $th,
            'th_prev'    => $prev,
            'current'    => $current,
            'previous'   => $before,
            'selisih'    => $selisih,
            'pct'        => $pct,
            'arah'       => $selisih < 0 ? 'turun' : ($selisih > 0 ? 'naik' : 'stabil'),
        ];
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
