<?php

namespace App\Models\Pindahan;

use CodeIgniter\Model;

class SiswaPindahanModel extends Model
{
    public const STATUS_MENUNGGU      = 'Menunggu';
    public const STATUS_TERVERIFIKASI = 'Terverifikasi';
    public const STATUS_DITOLAK       = 'Ditolak';

    public const ALL_STATUS = [
        self::STATUS_MENUNGGU,
        self::STATUS_TERVERIFIKASI,
        self::STATUS_DITOLAK,
    ];

    public const PENDAFTARAN_DRAFT = 'Draft';
    public const PENDAFTARAN_FINAL = 'Final';

    protected $table            = 'tbl_siswa_pindahan';
    protected $primaryKey       = 'id_pindahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_pendaftaran',
        'th_pelajaran',
        'password',
        'last_login',
        'nisn',
        'nik',
        'nama_lengkap',
        'email',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'foto',
        'status_keluarga',
        'anak_ke',
        'jml_saudara',
        'hobi',
        'cita',
        'alamat_siswa',
        'jenis_tinggal',
        'jarak',
        'trans',
        'desa',
        'kec',
        'kab',
        'prov',
        'kode_pos',
        'no_hp_siswa',
        'no_kk',
        'kepala_keluarga',
        'nama_ayah',
        'nik_ayah',
        'tempat_lahir_ayah',
        'tgl_lahir_ayah',
        'status_ayah',
        'pdd_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tgl_lahir_ibu',
        'status_ibu',
        'pdd_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'nik_wali',
        'tgl_lahir_wali',
        'pdd_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_hp_ortu',
        // === KHUSUS PINDAHAN: SEKOLAH ASAL ===
        'npsn_sekolah_asal',
        'nama_sekolah_asal',
        'alamat_sekolah_asal',
        'kota_asal',
        'provinsi_asal',
        'jenjang_sekolah_asal',
        'grup_jenjang_asal',
        'tahun_masuk_sekolah_asal',
        'tahun_keluar_sekolah_asal',
        'kelas_sekolah_asal',
        'kelas_diterima',
        'jurusan_sekolah_asal',
        'no_ijazah_sekolah_asal',
        'tgl_ijazah_sekolah_asal',
        // === ALASAN PINDAH ===
        'alasan_pindah',
        'alasan_pindah_kategori',
        // === NILAI RAPOR ===
        'rata_rata_nilai',
        'nilai_bahasa_indonesia',
        'nilai_bahasa_inggris',
        'nilai_matematika',
        'nilai_ipa',
        'nilai_ips',
        'nilai_pkn',
        'nilai_agama',
        'nilai_penjaskes',
        'nilai_seni_budaya',
        'no_kks',
        'file_kks',
        'no_pkh',
        'file_pkh',
        'no_kip',
        'file_kip',
        'komp_ahli',
        'jalur_pendaftaran',
        'tgl_pindahan',
        'status_verifikasi',
        'status_pendaftaran',
        'tgl_verifikasi',
        'verified_by',
        'catatan_verifikasi',
        'status_berkas',
        'status_lulus',
        'is_checked'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nisn'           => 'permit_empty|numeric|min_length[10]|max_length[20]',
        'nik'            => 'permit_empty|numeric|min_length[16]|max_length[20]',
        'nama_lengkap'   => 'permit_empty|string|max_length[255]',
        'email'          => 'permit_empty|valid_email|max_length[100]',
        'no_hp_siswa'    => 'permit_empty|regex_match[/^[0-9+\-\s]+$/]|max_length[20]',
        'no_hp_ortu'     => 'permit_empty|regex_match[/^[0-9+\-\s]+$/]|max_length[20]',
        'alasan_pindah'  => 'permit_empty|string',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Dapatkan tahun pelajaran aktif dari tabel pengaturan tbl_web
     */
    public function getActiveThPelajaran(): string
    {
        $db  = \Config\Database::connect();
        $web = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();

        return !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';
    }

    /**
     * Get status counts untuk filter tab admin/verifikator.
     *
     * Menggunakan satu query dengan COUNT(CASE WHEN ...) alih-alih
     * 5 clone builder (optimasi R6).
     */
    public function getStatusCounts($thPelajaran = null): array
    {
        if ($thPelajaran === null) {
            $thPelajaran = $this->getActiveThPelajaran();
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('tbl_siswa_pindahan')
            ->select("
                COUNT(*) AS total,
                SUM(CASE WHEN status_verifikasi IN (" . $db->escape(self::STATUS_MENUNGGU) . ", '') OR status_verifikasi IS NULL THEN 1 ELSE 0 END) AS menunggu,
                SUM(CASE WHEN status_verifikasi = " . $db->escape(self::STATUS_TERVERIFIKASI) . " THEN 1 ELSE 0 END) AS terverifikasi,
                SUM(CASE WHEN status_verifikasi = " . $db->escape(self::STATUS_DITOLAK) . " THEN 1 ELSE 0 END) AS ditolak,
                SUM(CASE WHEN " . $this->buildIncompleteCondition() . " THEN 1 ELSE 0 END) AS incomplete
            ")
            ->where('deleted_at', null);

        if ($thPelajaran !== 'all') {
            $builder->where('th_pelajaran', $thPelajaran);
        }

        $row = $builder->get()->getRowArray();

        return [
            'all'           => (int) ($row['total'] ?? 0),
            'menunggu'      => (int) ($row['menunggu'] ?? 0),
            'terverifikasi' => (int) ($row['terverifikasi'] ?? 0),
            'ditolak'       => (int) ($row['ditolak'] ?? 0),
            'incomplete'    => (int) ($row['incomplete'] ?? 0),
        ];
    }

    /**
     * Build raw WHERE condition untuk biodata yang belum lengkap.
     * Dipakai bersama oleh getStatusCounts() dan getStudents().
     *
     * @param string $prefix Prefix tabel (misal 'tbl_siswa_pindahan') atau ''.
     */
    protected function buildIncompleteCondition(string $prefix = ''): string
    {
        $fields = [
            'nisn', 'nik', 'nama_lengkap', 'jk', 'tempat_lahir', 'tgl_lahir', 'agama',
            'alamat_siswa', 'desa', 'kec', 'kab', 'prov',
            'nama_ayah', 'nama_ibu', 'no_hp_ortu',
            'jenjang_sekolah_asal', 'kelas_diterima',
        ];

        $conds = [];
        foreach ($fields as $f) {
            $col = $prefix !== '' ? $prefix . '.' . $f : $f;
            $conds[] = "({$col} IS NULL OR {$col} = '')";
        }

        return '(' . implode(' OR ', $conds) . ')';
    }

    /**
     * Get data siswa pindahan dengan pagination, search, filter tahun pelajaran, dan tab status.
     */
    public function getStudents($search = '', $perPage = 20, $sortOrder = 'ASC', $thPelajaran = null, $tab = 'all')
    {
        if ($thPelajaran === null) {
            $thPelajaran = $this->getActiveThPelajaran();
        }

        if ($thPelajaran !== 'all') {
            $this->where('tbl_siswa_pindahan.th_pelajaran', $thPelajaran);
        }

        if ($tab === 'menunggu') {
            $this->groupStart()
                ->where('tbl_siswa_pindahan.status_verifikasi', self::STATUS_MENUNGGU)
                ->orWhere('tbl_siswa_pindahan.status_verifikasi', '')
                ->orWhere('tbl_siswa_pindahan.status_verifikasi IS NULL')
                ->groupEnd();
        } elseif ($tab === 'terverifikasi') {
            $this->where('tbl_siswa_pindahan.status_verifikasi', self::STATUS_TERVERIFIKASI);
        } elseif ($tab === 'ditolak') {
            $this->where('tbl_siswa_pindahan.status_verifikasi', self::STATUS_DITOLAK);
        } elseif ($tab === 'incomplete') {
            $this->where($this->buildIncompleteCondition('tbl_siswa_pindahan'));
        }

        if (!empty($search)) {
            $this->groupStart()
                ->like('tbl_siswa_pindahan.no_pendaftaran', $search)
                ->orLike('tbl_siswa_pindahan.nisn', $search)
                ->orLike('tbl_siswa_pindahan.nama_lengkap', $search)
                ->orLike('tbl_siswa_pindahan.email', $search)
                ->orLike('tbl_siswa_pindahan.nama_sekolah_asal', $search)
                ->groupEnd();
        }

        return $this->orderBy('tbl_siswa_pindahan.tgl_pindahan', $sortOrder)
            ->paginate($perPage);
    }

    /**
     * Get detail siswa pindahan beserta riwayat verifikasi.
     */
    public function getStudentDetail($id)
    {
        return $this->select('tbl_siswa_pindahan.*, tbl_verifikasi_pindahan.isi as verifikasi_isi, tbl_verifikasi_pindahan.ket as verifikasi_ket')
            ->join('tbl_verifikasi_pindahan', 'tbl_verifikasi_pindahan.id_pindahan = tbl_siswa_pindahan.id_pindahan', 'left')
            ->where('tbl_siswa_pindahan.id_pindahan', $id)
            ->first();
    }

    /**
     * Hitung persentase kelengkapan biodata siswa pindahan.
     *
     * @param array $siswa          Data array siswa
     * @param bool  $includeDetails Jika false, lewati pengumpulan daftar label field yang belum diisi (optimal untuk loop index)
     * @return array ['percentage' => int, 'incomplete' => array]
     */
    public function calculateCompletionPercentage($siswa, bool $includeDetails = true): array
    {
        $requiredFields = [
            'nisn'                   => 'NISN',
            'nik'                    => 'NIK',
            'nama_lengkap'           => 'Nama Lengkap',
            'jk'                     => 'Jenis Kelamin',
            'tempat_lahir'           => 'Tempat Lahir',
            'tgl_lahir'              => 'Tanggal Lahir',
            'agama'                  => 'Agama',
            'alamat_siswa'           => 'Alamat',
            'desa'                   => 'Desa/Kelurahan',
            'kec'                    => 'Kecamatan',
            'kab'                    => 'Kabupaten/Kota',
            'prov'                   => 'Provinsi',
            'nama_ayah'              => 'Nama Ayah',
            'nama_ibu'               => 'Nama Ibu',
            'no_hp_ortu'             => 'No. HP Orang Tua',
            // === KHUSUS PINDAHAN ===
            'nama_sekolah_asal'    => 'Sekolah Asal',
            'jenjang_sekolah_asal' => 'Jenjang Sekolah Asal',
            'kelas_diterima'       => 'Diterima di Kelas',
        ];

        $totalRequired = count($requiredFields);
        $filled        = 0;

        if (!$includeDetails) {
            foreach (array_keys($requiredFields) as $field) {
                if (!empty($siswa[$field])) {
                    $filled++;
                }
            }
            return [
                'percentage' => (int) round(($filled / $totalRequired) * 100),
                'incomplete' => [],
            ];
        }

        $incompleteFields = [];
        foreach ($requiredFields as $field => $label) {
            if (!empty($siswa[$field])) {
                $filled++;
            } else {
                $incompleteFields[] = $label;
            }
        }

        return [
            'percentage' => (int) round(($filled / $totalRequired) * 100),
            'incomplete' => $incompleteFields,
        ];
    }

    /**
     * Hitung hanya persentase kelengkapan (ringan untuk list index).
     */
    public function getCompletionPercentageOnly($siswa): int
    {
        return $this->calculateCompletionPercentage($siswa, false)['percentage'];
    }
}