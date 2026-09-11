<?php

namespace App\Models\Pindahan;

use CodeIgniter\Model;

class BerkasPindahanModel extends Model
{
    protected $table            = 'tbl_berkas_pindahan';
    protected $primaryKey       = 'id_berkas_pindahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pindahan',
        'jenis_berkas',
        'nama_file',
        'path_file',
        'ukuran_file',
        'deskripsi',
        'keterangan',
        'status_verifikasi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Status verifikasi berkas pindahan.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_VALID   = 'valid';
    public const STATUS_INVALID = 'invalid';

    public const ALL_STATUS = [
        self::STATUS_PENDING,
        self::STATUS_VALID,
        self::STATUS_INVALID,
    ];

    /**
     * Jenis dokumen wajib yang harus diupload siswa pindahan.
     */
    public const JENIS_WAJIB = [
        'surat_pindah_sekolah',
        'surat_pindah_dapodik',
        'kk',
        'ijazah',
        'surat_pernyataan',
        'foto_siswa',
    ];

    /**
     * Daftar jenis dokumen beserta labelnya (untuk dropdown & tampilan).
     */
    public static function getJenisBerkasOptions(): array
    {
        return [
            'surat_pindah_sekolah' => 'Surat Pindah dari Sekolah Asal',
            'surat_pindah_dapodik' => 'Surat Pindah dari Dapodik/EMIS',
            'kk'                   => 'Kartu Keluarga (KK)',
            'ijazah'               => 'Ijazah / Surat Keterangan Lulus',
            'rapor'                => 'Rapor Terakhir',
            'sktm'                 => 'Surat Keterangan Tidak Mampu (SKTM)',
            'akta_kelahiran'       => 'Akta Kelahiran',
            'ktp_orang_tua'        => 'KTP Orang Tua/Wali',
            'sk_orang_tua'         => 'Surat Keterangan Kerja Orang Tua',
            'surat_pernyataan'     => 'Surat Pernyataan Orang Tua',
            'foto_siswa'           => 'Foto Siswa',
            'dokumen_lainnya'      => 'Dokumen Lainnya',
        ];
    }

    /**
     * Satu jenjang dokumen wajib diisi?
     */
    public static function isWajib(string $jenisBerkas): bool
    {
        return in_array($jenisBerkas, self::JENIS_WAJIB, true);
    }

    /**
     * Get dokumen beserta data siswa pindahan.
     */
    public function getDocumentsWithStudent($search = '', $perPage = 20)
    {
        $builder = $this->select('tbl_berkas_pindahan.*, tbl_siswa_pindahan.no_pendaftaran, tbl_siswa_pindahan.nama_lengkap, tbl_siswa_pindahan.nisn')
            ->join('tbl_siswa_pindahan', 'tbl_siswa_pindahan.id_pindahan = tbl_berkas_pindahan.id_pindahan');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tbl_siswa_pindahan.no_pendaftaran', $search)
                ->orLike('tbl_siswa_pindahan.nama_lengkap', $search)
                ->orLike('tbl_berkas_pindahan.jenis_berkas', $search)
                ->groupEnd();
        }

        return $builder->orderBy('tbl_berkas_pindahan.created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get distinct siswa pindahan yang sudah upload file.
     */
    public function getDistinctStudents($search = '', $perPage = 10)
    {
        $builder = $this->select('tbl_siswa_pindahan.id_pindahan, tbl_siswa_pindahan.no_pendaftaran, tbl_siswa_pindahan.nama_lengkap, tbl_siswa_pindahan.nisn, MAX(tbl_berkas_pindahan.created_at) as latest_upload')
            ->join('tbl_siswa_pindahan', 'tbl_siswa_pindahan.id_pindahan = tbl_berkas_pindahan.id_pindahan')
            ->groupBy('tbl_berkas_pindahan.id_pindahan');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tbl_siswa_pindahan.no_pendaftaran', $search)
                ->orLike('tbl_siswa_pindahan.nama_lengkap', $search)
                ->orLike('tbl_siswa_pindahan.nisn', $search)
                ->groupEnd();
        }

        return $builder->orderBy('latest_upload', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get semua dokumen milik seorang siswa pindahan.
     */
    public function getByPindahan($idPindahan)
    {
        return $this->where('id_pindahan', $idPindahan)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Cek apakah dokumen wajib untuk siswa pindahan sudah lengkap.
     * Menerima $berkasList opsional untuk menghindari query ulang jika data berkas sudah di-fetch.
     *
     * @param int        $idPindahan
     * @param array|null $berkasList
     * @return array
     */
     public function isWajibLengkap($idPindahan, ?array $berkasList = null): array
     {
         $sudahUpload = [];
         $rows = $berkasList !== null ? $berkasList : $this->where('id_pindahan', $idPindahan)->findAll();
         foreach ($rows as $row) {
             $sudahUpload[$row['jenis_berkas']] = $row;
         }
 
         $kurang = [];
         foreach (self::JENIS_WAJIB as $jenis) {
             if (!isset($sudahUpload[$jenis])) {
                 $kurang[] = $jenis;
             }
         }
 
         return [
             'sudah'   => count(array_intersect(self::JENIS_WAJIB, array_keys($sudahUpload))),
             'total'   => count(self::JENIS_WAJIB),
             'kurang'  => $kurang,
             'lengkap' => empty($kurang),
         ];
     }
 
     /**
      * Get jumlah dokumen per status verifikasi (single query aggregation).
      */
     public function getStatusCounts(): array
     {
         $db = \Config\Database::connect();
         $row = $db->table($this->table)
             ->select("
                 SUM(CASE WHEN status_verifikasi = " . $db->escape(self::STATUS_PENDING) . " THEN 1 ELSE 0 END) AS pending,
                 SUM(CASE WHEN status_verifikasi = " . $db->escape(self::STATUS_VALID) . " THEN 1 ELSE 0 END) AS valid,
                 SUM(CASE WHEN status_verifikasi = " . $db->escape(self::STATUS_INVALID) . " THEN 1 ELSE 0 END) AS invalid_count
             ")
             ->get()
             ->getRowArray();
 
         return [
             'pending' => (int) ($row['pending'] ?? 0),
             'valid'   => (int) ($row['valid'] ?? 0),
             'invalid' => (int) ($row['invalid_count'] ?? 0),
         ];
     }

    /**
     * Hapus file fisik dari server (dipanggil sebelum hapus record).
     */
    public function deleteFileRecord($idBerkas): bool
    {
        $berkas = $this->find($idBerkas);
        if (!$berkas) {
            return false;
        }

        $path = WRITEPATH . '..' . DIRECTORY_SEPARATOR . $berkas['path_file'];
        $resolved = realpath($path);
        if ($resolved !== false && is_file($resolved)) {
            @unlink($resolved);
        }

        return $this->delete($idBerkas);
    }
}