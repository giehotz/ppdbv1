<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarUlangModel extends Model
{
    protected $table            = 'tbl_daftar_ulang';
    protected $primaryKey       = 'id_daftar_ulang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'status_konfirmasi',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran_peci',
        'ukuran_sepatu',
        'alasan_mundur',
        'catatan',
        'data_seragam',
        'tgl_konfirmasi'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Dapatkan konfirmasi daftar ulang berdasarkan ID Siswa
     */
    public function getBySiswa($idSiswa)
    {
        return $this->where('id_siswa', $idSiswa)->first();
    }

    /**
     * Dapatkan rekap daftar ulang lengkap dengan data siswa
     */
    public function getRekapDaftarUlang($statusKonfirmasi = null, $thPelajaran = null, $search = null)
    {
        $builder = $this->db->table('tbl_siswa s')
            ->select('s.id_siswa, s.nama_lengkap, s.nisn, s.no_pendaftaran, s.jk, COALESCE(NULLIF(s.no_hp_ortu, \'\'), s.no_hp_siswa, \'\') AS telepon, s.th_pelajaran, s.status_lulus,
                      du.id_daftar_ulang, du.status_konfirmasi, du.ukuran_baju, du.ukuran_celana, du.ukuran_peci, du.ukuran_sepatu, du.alasan_mundur, du.catatan, du.data_seragam, du.tgl_konfirmasi')
            ->join('tbl_daftar_ulang du', 'du.id_siswa = s.id_siswa', 'left')
            ->where('s.status_lulus', 'Lulus');

        if ($thPelajaran) {
            $builder->where('s.th_pelajaran', $thPelajaran);
        }

        if ($statusKonfirmasi === 'bersedia') {
            $builder->where('du.status_konfirmasi', 'bersedia');
        } elseif ($statusKonfirmasi === 'mengundurkan_diri') {
            $builder->where('du.status_konfirmasi', 'mengundurkan_diri');
        } elseif ($statusKonfirmasi === 'belum_konfirmasi') {
            $builder->where('du.id_daftar_ulang IS NULL');
        }

        if ($search) {
            $builder->groupStart()
                ->like('s.nama_lengkap', $search)
                ->orLike('s.nisn', $search)
                ->orLike('s.no_pendaftaran', $search)
                ->groupEnd();
        }

        return $builder->orderBy('du.tgl_konfirmasi', 'DESC')->get()->getResultArray();
    }

    /**
     * Konfigurasi standar ukuran seragam sekolah
     */
    public static function getDefaultSeragamFields(): array
    {
        return [
            [
                'id'       => 'ukuran_baju',
                'label'    => 'Ukuran Baju / Kemeja',
                'type'     => 'select',
                'required' => 1,
                'options'  => 'S, M, L, XL, XXL, 3XL, Custom',
            ],
            [
                'id'       => 'ukuran_celana',
                'label'    => 'Ukuran Celana / Rok',
                'type'     => 'select',
                'required' => 1,
                'options'  => '26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, S, M, L, XL, XXL, Custom',
            ],
            [
                'id'       => 'ukuran_peci',
                'label'    => 'Ukuran Peci / Kopiah',
                'type'     => 'select',
                'required' => 0,
                'options'  => 'No. 4, No. 5, No. 6, No. 7, No. 8, No. 9, No. 10, Tidak Pakai',
            ],
            [
                'id'       => 'ukuran_sepatu',
                'label'    => 'Ukuran Sepatu',
                'type'     => 'select',
                'required' => 0,
                'options'  => '35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45',
            ],
        ];
    }

    /**
     * Parse seragam fields dari web data
     */
    public static function getSeragamFields($web): array
    {
        if (!empty($web['seragam_fields'])) {
            $decoded = json_decode($web['seragam_fields'], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        return self::getDefaultSeragamFields();
    }
}
